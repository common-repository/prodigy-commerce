<?php

/**
 * Fired during plugin deactivation.
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Deactivator
 */
class Prodigy_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::delete_settings();
		self::remove_roles();
	}

	/**
	 *  Delete default settings
	 */
	public static function delete_settings() {

		// enable require fields in comment form
		update_option( 'require_name_email', 1 );
		update_option( 'show_comments_cookies_opt_in', 1 );
	}

	/**
	 * Remove roles.
	 */
	public static function remove_roles() {
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		remove_role( 'customer' );
		remove_role( 'shop_manager' );
	}

}
