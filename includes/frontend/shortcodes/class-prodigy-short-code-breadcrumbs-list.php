<?php
/**
 * Prodigy breadcrumbs shortcode class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Breadcrumbs
 */
class Prodigy_Short_Code_Breadcrumbs_List {

	public function __construct() {
		add_shortcode( 'prodigy_breadcrumbs_list', array( $this, 'output' ) );
	}

	/**
	 * @param array  $atts
	 * @param null   $content
	 * @param string $name
	 *
	 * @return string
	 */
	public function output( $atts, $name, $content = null ): string {
		$current_object = get_queried_object();
		$category_slug  = '';
		$link_to_shop   = get_permalink( get_page_by_path( 'shop' ) );

		if (
				! empty( $current_object )
				&& (
						! is_wp_error( get_term( $current_object->term_id, Prodigy::get_prodigy_category_type() ) )
						|| ! is_wp_error( get_term( $current_object->term_id, Prodigy::get_prodigy_tag_type() ) )
				)
		) {
			$category_slug     = $current_object->slug;
			$category_name     = $current_object->name;
			$category_taxonomy = $current_object->taxonomy;

			$url_to = '/' . $category_taxonomy . '/' . $category_slug;
		} else {
			if ( isset( $current_object->ID ) ) {
				$url_to = get_page_link( $current_object->ID );
			}

			$category_name = '';

			if ( isset( $current_object->ID ) && get_page_link( $current_object->ID ) != $link_to_shop ) {
				$category_name = $current_object->post_title;
			}
		}

		ob_start();

		do_action(
			'prodigy_shortcode_template_breadcrumbs',
			array(
				'category_name'   => $category_name,
				'link_to_shop'    => $link_to_shop,
				'category_slug'   => $category_slug,
				'url_to'          => $url_to ?? '',
				'attr_shortrcode' => $atts,
			)
		);

		wp_reset_postdata();

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
