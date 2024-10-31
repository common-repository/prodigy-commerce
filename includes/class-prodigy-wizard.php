<?php
/**
 * Setup Wizard Class
 * Takes new users through some basic steps to setup their store.
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy_Wizard class.
 */
class Prodigy_Wizard {

	/**
	 * @var array
	 */
	private static $weights = array(
		'lbs',
		'kg',
		'g',
		'oz',
	);

	/**
	 * @var array
	 */
	private static $name_settings = array(
		'pg_weight',
		'pg_dimensions',
	);

	/**
	 * Prodigy_Wizard constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_update_settings_wizard', array( $this, 'update_settings_wizard' ) );
		add_action( 'wp_ajax_remove-indicator-sync-content', array( $this, 'remove_indicator_sync_content' ) );
		add_action( 'wp_ajax_set-indicator-sync-content', array( $this, 'set_indicator_sync_content' ) );
	}

	/**
	 * Set option sync content.
	 */
	public function remove_indicator_sync_content() {
		check_ajax_referer( 'prodigyajax-nonce', 'nonce_code' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'You don\'t have access', 'prodigy' ), 403 );
		}

		update_option( 'pg_indicator_sync_content', 'no' );
		wp_send_json_success();
	}

	/**
	 * Set option sync content.
	 */
	public function set_indicator_sync_content() {

		check_ajax_referer( 'prodigyajax-nonce', 'nonce_code' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'You don\'t have access', 'prodigy' ), 403 );
		}

		update_option( 'pg_indicator_sync_content', 'yes' );
		wp_send_json_success();
	}

	/**
	 * @return array
	 */
	public static function get_weights(): array {
		return self::$weights;
	}

	/**
	 * @return array
	 */
	public static function get_name_settings(): array {
		return self::$name_settings;
	}

	/**
	 * Ajax update settings on step 2.
	 */
	public function update_settings_wizard() {
		$is_nonce = check_ajax_referer( 'prodigyajax-nonce', 'nonce_code' );

		if ( $is_nonce && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'You don\'t have access', 'prodigy' ), 403 );
		}
		$settings_name = isset( $_SERVER['settings_name'] ) ? sanitize_text_field( wp_unslash( $_SERVER['settings_name'] ) ) : '';
		$settings_val  = isset( $_SERVER['settings_val'] ) ? sanitize_text_field( wp_unslash( $_SERVER['settings_val'] ) ) : '';
		if ( ! isset( $settings_name, $settings_val ) ) {
			wp_send_json_error();
		}

		if ( in_array( $settings_name, self::get_name_settings(), true )
			&& ( in_array( $settings_val, self::get_weights(), true ) )
		) {
			$res = update_option( $settings_name, $settings_val );

			if ( empty( $res ) ) {
				wp_send_json_error();
			}
		}
		wp_send_json_success();
	}
}
