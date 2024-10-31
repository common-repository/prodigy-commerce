<?php
namespace Prodigy\Includes\Helpers;

use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy Template Helper
 *
 * @version    3.0.2
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Template {

	/**
	 * @param string $slug
	 * @param string $name
	 */
	public static function prodigy_get_template_part( string $slug, string $name = '' ) {
		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/prodigy/slug-name.php.
		if ( $name ) {
			$template = locate_template( array( "{$slug}-{$name}.php", 'prodigy/' . "{$slug}-{$name}.php" ) );
		}

		// Get default slug-name.php.
		if ( ! $template && $name && file_exists( PRODIGY_PLUGIN_PATH . "/templates/partials/{$slug}-{$name}.php" ) ) {
			$template = PRODIGY_PLUGIN_PATH . "/templates/partials/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/prodigy/slug.php.
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", 'prodigy/' . "{$slug}.php" ) );
		}

		if ( $template ) {
			load_template( $template, false );
		}
	}


	/**
	 * @param string $template_name
	 * @param array  $args
	 * @param string $template_path
	 * @param string $default_path
	 * @param string $directory_name
	 */
	public static function prodigy_get_template( string $template_name, $args = array(), string $directory_name = 'templates', string $template_path = '', string $default_path = '' ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		$located = self::prodigy_locate_template( $template_name, $directory_name, $template_path, $default_path );
		$located = apply_filters( 'prodigy_get_' . $directory_name, $located, $template_name, $args, $template_path, $default_path );

		if ( ! is_dir( $located ) && file_exists( $located ) ) {
			include $located;
		}
	}

	/**
	 * @param string $template_name
	 * @param array  $args
	 * @param string $template_path
	 * @param string $default_path
	 * @param string $directory_name
	 *
	 * @return false|string
	 */
	public static function prodigy_get_template_html( string $template_name, array $args = array(), string $directory_name = 'templates', string $template_path = '', string $default_path = '' ) {
		if ( ! empty( $template_name ) ) {
			ob_start();
			self::prodigy_get_template( $template_name, $args, $directory_name, $template_path, $default_path );

			return ob_get_clean();
		}
	}

	/**
	 * @param string $template_name
	 * @param string $template_path
	 * @param string $default_path
	 * @param string $directory_name
	 *
	 * @return string
	 */
	public static function prodigy_locate_template( string $template_name, string $directory_name = 'templates', string $template_path = '', string $default_path = '' ): string {
		if ( ! $template_path ) {
			$template_path = 'prodigy/';
		}

		if ( ! $default_path ) {
			$default_path = PRODIGY_PLUGIN_PATH . $directory_name . '/partials/';
		}

		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// Get default template/.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		return $template;
	}

	/**
	 * @return bool
	 */
	public static function prodigy_is_admin(): bool {
		$user = wp_get_current_user();
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
	public static function prodigy_check_shop_page(): bool {
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
	public static function prodigy_is_blog(): bool {
		return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' == get_post_type();
	}


	/**
	 * @return bool
	 */
	public static function is_prodigy_shop(): bool {
		return is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) );
	}

	/**
	 * Check current page is Cart
	 *
	 * @return bool
	 */
	public static function is_cart(): bool {
		$url = Prodigy_Page::prodigy_get_cart_url();
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		if ( ! empty( $url ) && ! empty( $uri ) ) {
			return substr_count( $url, $uri );
		}

		return false;
	}

}