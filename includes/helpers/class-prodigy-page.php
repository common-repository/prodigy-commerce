<?php
namespace Prodigy\Includes\Helpers;

/**
 * Class Prodigy Helper
 */
class Prodigy_Page {
	/**
	 * @param string $page
	 *
	 * @return bool|int
	 */
	public static function prodigy_get_page_id( string $page ) {
		$page = apply_filters( 'prodigy_get_' . $page . '_page_id', get_option( 'prodigy_' . $page . '_page_id' ) );

		if ( $page ) {
			return absint( $page );
		}

		return false;
	}

	/**
	 * @return false|string
	 */
	public static function prodigy_get_thank_url() {
		return self::prodigy_get_page_permalink( 'thank' );
	}

	/**
	 * @return false|string
	 */
	public static function prodigy_get_shop_url() {
		return self::prodigy_get_page_permalink( 'shop' );
	}

	/**
	 * @return mixed
	 */
	public static function prodigy_get_cart_url() {
		return self::prodigy_get_page_permalink( 'cart' );
	}

	/**
	 * @param string  $page
	 * @param ?string $fallback
	 *
	 * @return false|string
	 */
	public static function prodigy_get_page_permalink( string $page, string $fallback = null ) {
		$page_id   = self::prodigy_get_page_id( $page );
		$permalink = 0 < $page_id ? get_permalink( $page_id ) : '';

		if ( ! $permalink ) {
			$permalink = $fallback ?? get_home_url();
		}

		return $permalink;
	}

	/**
	 * @return bool
	 */
	public static function prodigy_is_frontend_ajax(): bool {
		$script_filename = sanitize_url( wp_unslash( $_SERVER['SCRIPT_FILENAME'] ?? '' ) );

		if ( wp_doing_ajax() ) {
			$ref = '';
			if ( ! empty( $_REQUEST['_wp_http_referer'] ) ) {
				$ref = sanitize_url( wp_unslash( $_REQUEST['_wp_http_referer'] ) );
			} elseif ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
				$ref = sanitize_url( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
			}

			// If referer does not contain admin URL and we are using the admin-ajax.php endpoint, this is likely a frontend AJAX request
			if ( ( ( strpos( $ref, admin_url() ) === false ) && ( basename( $script_filename ) === 'admin-ajax.php' ) ) ) {
				return true;
			}
		}

		// If no checks triggered, we end up here - not an AJAX request.
		return false;
	}

	/**
	 * @return bool
	 */
	public static function prodigy_is_frontend(): bool {
		if ( wp_doing_ajax() ) {
			return self::prodigy_is_frontend_ajax();
		}

		return ! is_admin();
	}
}
