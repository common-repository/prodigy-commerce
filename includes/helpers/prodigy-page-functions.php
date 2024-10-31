<?php
/**
 * @param string $page
 *
 * @return bool|int
 */
function prodigy_get_page_id( string $page ) {
	$page = apply_filters( 'prodigy_get_' . $page . '_page_id', get_option( 'prodigy_' . $page . '_page_id' ) );

	return $page ? absint( $page ) : false;
}


/**
 * @return string|void
 */
function prodigy_get_thank_url() {
	return prodigy_get_page_permalink( 'thank' );
}


/**
 * @return string|void
 */
function prodigy_get_shop_url() {
	return prodigy_get_page_permalink( 'shop' );
}


/**
 * @return false|mixed|string|WP_Error
 */
function prodigy_get_cart_url() {
	return prodigy_get_page_permalink( 'cart' );
}


/**
 * @param $page
 * @param $fallback
 *
 * @return false|mixed|string|WP_Error
 */
function prodigy_get_page_permalink( $page, $fallback = null ) {
	$page_id   = prodigy_get_page_id( $page );
	$permalink = 0 < $page_id ? get_permalink( $page_id ) : '';

	if ( ! $permalink ) {
		$permalink = is_null( $fallback ) ? get_home_url() : $fallback;
	}

	return $permalink;
}

if ( ! function_exists( 'prodigy_is_frontend_ajax' ) ) {

	function prodigy_is_frontend_ajax(): bool {
		$script_filename = $_SERVER['SCRIPT_FILENAME'] ?? '';

		if ( wp_doing_ajax() ) {
			$ref = '';
			if ( ! empty( $_REQUEST['_wp_http_referer'] ) ) {
				$ref = wp_unslash( $_REQUEST['_wp_http_referer'] );
			} elseif ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
				$ref = wp_unslash( $_SERVER['HTTP_REFERER'] );
			}

			//If referer does not contain admin URL and we are using the admin-ajax.php endpoint, this is likely a frontend AJAX request
			if ( ( ( strpos( $ref, admin_url() ) === false ) && ( basename( $script_filename ) === 'admin-ajax.php' ) ) ) {
				return true;
			}
		}

		//If no checks triggered, we end up here - not an AJAX request.
		return false;
	}
}


if ( ! function_exists( 'prodigy_is_frontend' ) ) {
	function prodigy_is_frontend(): bool {
		if ( wp_doing_ajax() ) {
			return prodigy_is_frontend_ajax();
		}
		return ! is_admin();
	}
}