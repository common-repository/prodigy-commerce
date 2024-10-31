<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Prodigy;

/**
 * Class Prodigy_Admin_Notices
 */
class Prodigy_Admin_Notices {

	/**
	 * Minimum version of MySQL.
	 */
	const MYSQL_MINIMAL_VERSION = 5.6;

	/**
	 * Prodigy_Admin_Notices constructor.
	 */
	public function __construct() {
		add_action( 'admin_print_styles', array( $this, 'add_notices' ) );
	}

	/**
	 * Set notice action
	 */
	public function add_notices() {
		add_action( 'admin_notices', array( $this, 'check_mysql_notice' ) );
		add_action( 'admin_notices', array( $this, 'check_sync_products' ) );
	}

	/**
	 * Set check version notice
	 */
	public function check_mysql_notice() {
		global $pagenow, $wpdb;

		$post_type = isset( $_GET['post_type'] ) ? esc_url_raw( wp_unslash( $_GET['post_type'] ) ) : '';

		if ( 'index.php' === $pagenow || Prodigy::get_prodigy_product_type() === $post_type ) {
			$current_version = $wpdb->db_version();

			if ( (float) $current_version < self::MYSQL_MINIMAL_VERSION ) {
				self::update_notice( 'check_mysql_notice', true );
			} else {
				self::update_notice( 'check_mysql_notice', false );
			}

			if ( get_option( 'prodigy_admin_notice_check_mysql_notice' ) ) {
				include __DIR__ . '/notice_views/check-db-version-notice.php';
			}
		}
	}

	/**
	 * Set check version notice
	 */
	public function check_sync_products() {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === Prodigy::get_prodigy_product_type() ) {

			if ( get_option( 'run_sync_content_prodigy_process' ) ) {
				self::update_notice( 'check_sync_products', true );
			} else {
				self::update_notice( 'check_sync_products', false );
			}

			if ( get_option( 'prodigy_admin_notice_check_sync_products' ) ) {
				include __DIR__ . '/notice_views/check-sync-products.php';
			}
		}
	}

	/**
	 * @param string $name
	 * @param string $is_enable
	 */
	public static function update_notice( string $name, string $is_enable ) {
		$option = get_option( 'prodigy_admin_notice_' . $name );
		if ( isset( $option ) ) {
			update_option( 'prodigy_admin_notice_' . $name, $is_enable );
		}
	}
}

new Prodigy_Admin_Notices();
