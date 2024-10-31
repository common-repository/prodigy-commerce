<?php
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include core functions
require dirname( PRODIGY_PLUGIN_FILE ) . '/includes/helpers/prodigy-hooks-functions.php';

$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
if (
	! function_exists( 'is_shop' ) &&
	( is_plugin_active( 'elementor-pro/elementor-pro.php' ) || did_action( 'elementor/loaded' ) ) &&
	! empty( $elementor_options['archive'] )
) {
	function is_shop(): bool {
		return is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) );
	}
}

/**
 * @return bool
 */
function is_wp_api_request(): bool {
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	return (bool) strpos( $uri, rest_get_url_prefix() );
}

if ( ! function_exists( 'prodigy_get_images_id_by_title' ) ) {
	function prodigy_get_images_id_by_title( string $img_names, string $post_type = 'attachment' ): array {

		$img_ids_by_names = array();
		$img_names        = explode( ',', $img_names );
		if ( is_array( $img_names ) ) {
			foreach ( $img_names as $img_name ) {
				$attachment = prodigy_get_post_by_title( trim( $img_name ), $post_type );
				if ( is_object( $attachment ) ) {
					$img_ids_by_names[] = $attachment->ID;
				}
			}
		}

		return $img_ids_by_names;
	}
}



/**
 * Display a beautiful, human-readable, comment time
 *
 * @param int $comment_id
 *
 * @return string
 */
function prodigy_get_comment_time( $comment_id = 0 ): string {
	return sprintf(
		_x( '%s ago', 'Human-readable time', 'prodigy' ),
		human_time_diff(
			get_comment_date( 'U', $comment_id ),
			current_time( 'timestamp' )
		)
	);
}

function prodigy_get_admin_url( $path = null, $query = array() ): string {
	if ( ! empty( $query ) ) {
		$query_string = http_build_query( $query );
		$path         = $path . '?' . $query_string;
	}

	return admin_url( $path );
}


/**
 * @param string $title
 * @param string $type
 * @return WP_Post|null
 */
function prodigy_get_post_by_title( string $title, string $type = 'page' ) {
	$query = new \WP_Query(
		array(
			'post_type'              => $type,
			'title'                  => $title,
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		)
	);

	$page = null;
	if ( ! empty( $query->post ) ) {
		$page = $query->post;
	}

	return $page;
}
