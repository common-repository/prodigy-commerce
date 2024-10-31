<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Content\Prodigy_Api_Client;

defined( 'ABSPATH' ) || exit;

/**
 * Set default options class
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Options {

	const SITE_URL_OPTION = 'siteurl';

	/**
	 * @var Prodigy_Api_Client
	 */
	public $api_client;

	/**
	 * Prodigy_Options constructor.
	 */
	public function __construct() {
		$this->api_client = new Prodigy_Api_Client();
		add_action( 'update_option', array( $this, 'update_options_listener' ), 10, 3 );
	}

	/**
	 * List of prodigy options
	 *
	 * @var static array
	 */
	public static $default_options = array(
		'pg_currency_type'                        => '$',
		'pg_currency_position'                    => 'left',
		'pg_thousands_separator'                  => ', ',
		'pg_decimal_separator'                    => '.',
		'pg_number_decimals'                      => 2,
		'pg_hold_stock_time'                      => 1,
		'pg_cart_expiration_time'                 => 168,
		'pg_custom_expiration_time'               => 0,
		'pg_add_cart_behaviour'                   => 'current_page',
		'pg_all_slugs_product_type'               => array( 'prodigy_product_type', 'product' ),
		'pg_all_slugs_category_type'              => array( 'prodigy_product_cat', 'product-category' ),
		'pg_all_slugs_tag_type'                   => array( 'prodigy_product_tag', 'product-tag' ),
		'pg_indicator_sync_content'               => 'yes',
		'pg_install_demo_content_wizard'          => 0,
		'pg_set_pages'                            => false,
		'pg_product_rating'                       => 1,
		'pg_product_review'                       => 1,
		'prodigy_admin_notice_check_mysql_notice' => 0,
		Prodigy_Cache::EXPIRATION_TIME_OPTION     => Prodigy_Cache::DEFAULT_EXPIRATION_TIME,
		Prodigy_Cache::CACHE_STATE_OPTION         => Prodigy_Cache::DEFAULT_CACHE_STATE,
		'pg_save_data'                            => array(
			'categories' => 'on',
			'products'   => 'on',
			'category'   => 'on',
		),
		'pg_enable_captcha'                       => 0,
		'pg_product_type_slug'                    => 'product',
		'pg_category_type_slug'                   => 'product-category',
		'pg_tag_type_slug'                        => 'product-tag',
		'pg_enable_google_analytics'              => 0,
	);


	/**
	 * @param string $option_name
	 *
	 * @return void
	 */
	public function update_options_listener( string $option_name ) {
		if ( $option_name === self::SITE_URL_OPTION ) {
			$this->refresh_wp_domain_on_hs_side();
		}
	}

	/**
	 * @return void
	 */
	private function refresh_wp_domain_on_hs_side() {
		$api_url  = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::API_CONNECTION_URL;
		$params   = array( 'url' => site_url() );
		$response = $this->api_client->put_remote_content( $api_url, $params );
		if ( isset( $response['response'] ) && $response['response']['code'] !== \WP_Http::NO_CONTENT && PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
			do_action( 'logger', $response['response'], 'error' );
		}
	}

	/**
	 * Set default options
	 *
	 * @return void
	 */
	public function set_default_options(): void {
		foreach ( self::$default_options as $option_name => $value ) {
			if ( get_option( $option_name ) === false ) {
				add_option( $option_name, $value );
			}
		}

		$this->set_default_pages();
	}

	/**
	 * Set default pages ids
	 *
	 * @return void
	 */
	public function set_default_pages(): void {
		$shop_page  = prodigy_get_post_by_title( __( 'Shop', 'prodigy' ) );
		$thank_page = prodigy_get_post_by_title( __( 'Thank you', 'prodigy' ) );
		$cart_page  = prodigy_get_post_by_title( __( 'Cart', 'prodigy' ) );

		if ( isset( $thank_page ) && empty( get_option( 'prodigy_thank_page_id' ) ) ) {
			update_option( 'prodigy_thank_page_id', $thank_page->ID );
		}

		if ( isset( $cart_page ) && empty( get_option( 'prodigy_cart_page_id' ) ) ) {
			update_option( 'prodigy_cart_page_id', $cart_page->ID );
		}

		if ( isset( $shop_page ) && empty( get_option( 'prodigy_shop_page_id' ) ) ) {
			update_option( 'prodigy_shop_page_id', $shop_page->ID );
		}
	}

	/**
	 * @return bool
	 */
	public static function get_redemption_store_status(): bool {
		$plugin_settings     = get_option( 'prodigy_plugin_settings' );
		$is_redemption_store = $plugin_settings['data']['attributes']['redemption-store'] ?? false;
		return ! $is_redemption_store;
	}
}
