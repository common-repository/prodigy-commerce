<?php

use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Prodigy;

/**
 * @return bool
 */
function prodigy_is_admin(): bool {
	$user = wp_get_current_user();
	$d    = is_admin();
	if ( ! empty( $user->roles ) && $user->roles[0] === 'administrator' ) {
		$result = true;
	} else {
		$result = false;
	}

	return $result;
}

/**
 * @return bool
 */
function prodigy_check_shop_page(): bool {
	$uri        = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$url_params = wp_parse_url( $uri );
	$path       = explode( '/', $url_params['path'] );
	foreach ( $path as $part ) {
		if ( ! empty( $part ) &&
			 (
				 $part === Prodigy::get_prodigy_category_slug() ||
				 $part === Prodigy::get_prodigy_tag_slug()
			 )
		) {
			return true;
		}
	}
	return false;
}

/**
 * @return bool
 */
function prodigy_is_blog(): bool {
	return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' == get_post_type();
}

if ( ! function_exists( 'is_prodigy_shop' ) ) {
	function is_prodigy_shop(): bool {
		return is_page( prodigy_get_page_id( 'shop' ) );
	}
}

$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
// just for elementor
if (
	! function_exists( 'is_shop' ) &&
	( is_plugin_active( 'elementor-pro/elementor-pro.php' ) || did_action( 'elementor/loaded' ) ) &&
	! empty( $elementor_options['archive'] )
) {
	function is_shop(): bool {
		return is_page( prodigy_get_page_id( 'shop' ) );
	}
}

if ( ! function_exists( 'is_cart' ) ) {
	/**
	 * Check current page is Cart
	 *
	 * @return bool
	 */
	function is_cart(): bool {
		$url = prodigy_get_cart_url();
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		return ! empty( $url ) && ! empty( $uri ) ? substr_count( $url, $uri ) : false;
	}
}
