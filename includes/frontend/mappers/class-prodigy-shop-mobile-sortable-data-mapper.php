<?php
namespace Prodigy\Includes\Frontend\Mappers;

/**
 * Prodigy shop mobile sortable
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Shop_Mobile_Sortable_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		global $wp_query;

		$paged = get_query_var( 'paged' );

		if ( empty( $paged ) ) {
			$paged = 1;
		}

		if ( isset( $paged ) ) {
			$prev_posts = ( $paged - 1 ) * $wp_query->query_vars['posts_per_page'];
			$from       = 1 + $prev_posts;
			if ( ! empty( $wp_query->posts ) ) {
				$to = count( $wp_query->posts ) + $prev_posts;
				$of = $wp_query->found_posts;
			}
		}

		if ( isset( $_GET['_wpnonce'], $_GET['search'] ) || wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ?? '' ), 'store-nonce' ) ) {
			$search = wp_strip_all_tags( sanitize_text_field( wp_unslash( $_GET['search'] ) ) ?? '' );
		}

		if ( ! have_posts() ) {
			return array();
		}

		$sort = explode( 'sort=', sanitize_text_field( wp_unslash( $_POST['query'] ?? '' ) ) );

		return array(
			'from'   => $from ?? 0,
			'paged'  => $paged,
			'to'     => $to ?? 0,
			'of'     => $of ?? 0,
			'search' => $search ?? '',
			'sort'   => $sort,
		);
	}
}
