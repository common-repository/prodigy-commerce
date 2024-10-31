<?php
namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Cache
 *
 * @package Prodigy\Includes
 * @version 2.0.5
 */
class Prodigy_Cache {

	const PLUGIN_TAG                    = 'prodigy';
	const PRODUCT_TAG                   = 'product';
	const CATALOG_FILTERS_TAG           = 'catalog_filters';
	const CATALOG_PRODUCTS_TAG          = 'catalog_products';
	const ORDER_TAG                     = 'order';
	const RELATED_PRODUCT_TAG           = 'related_product';
	const ANALYTICS_TAG                 = 'analytics';
	const PRODUCTS_SHORTCODE_TAG        = 'products_shortcode';
	const CATEGORIES_SHORTCODE_TAG      = 'categories_shortcode';
	const SETTINGS_TAG                  = 'hosted_system_settings';
	const DEFAULT_EXPIRATION_TIME       = 900;
	const EXPIRATION_TIME_OPTION        = 'pg_cache_expiration_time';
	const CUSTOM_EXPIRATION_TIME_OPTION = 'pg_custom_expiration_cache_time';
	const CACHE_STATE_OPTION            = 'pg_enable_cache';
	const DEFAULT_CACHE_STATE           = 1;

	public $prefix;

	/** @var string */
	public $user_prefix;

	public $is_enabled;

	/**
	 * Prodigy_Cache constructor.
	 */
	public function __construct() {
		$this->is_enabled  = get_option( self::CACHE_STATE_OPTION );
		$this->prefix      = $this->generate_prefix();
		$this->user_prefix = $this->generate_user_prefix();
	}

	/**
	 * @return string
	 */
	private function generate_prefix(): string {
		return md5( self::PLUGIN_TAG . get_option( 'pg_store_key' ) );
	}

	/**
	 * @return string
	 */
	private function generate_user_prefix(): string {
		$access_cookie = isset( $_COOKIE[ Prodigy_User::ACCESS_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_User::ACCESS_COOKIE_NAME ] ) ) : '';
		$hash          = Prodigy_User::is_logged_in() ? $access_cookie : get_option( 'pg_store_key' );

		return md5( self::PLUGIN_TAG . $hash );
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	private function get_product_key( int $id ): string {
		return $this->user_prefix . self::PRODUCT_TAG . $id;
	}

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	private function get_order_key( string $id ): string {
		return $this->user_prefix . self::ORDER_TAG . $id;
	}

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	private function get_related_product_key( string $id ): string {
		return $this->user_prefix . self::RELATED_PRODUCT_TAG . $id;
	}

	/**
	 * @param string $filter
	 *
	 * @return string
	 */
	private function get_catalog_filters_key( string $filter = '' ): string {
		return $this->get_catalog_filters_prefix() . md5( $filter );
	}

	/**
	 * @param string $filter
	 *
	 * @return string
	 */
	private function get_catalog_products_key( string $filter = '' ): string {
		return $this->get_catalog_products_prefix() . md5( $filter );
	}

	/**
	 * @param string $filter
	 *
	 * @return string
	 */
	private function get_product_shortcode_key( string $filter = '' ): string {
		return $this->get_products_shortcode_prefix() . md5( $filter );
	}

	/**
	 * @param string $filter
	 *
	 * @return string
	 */
	private function get_categories_shortcode_key( string $filter = '' ): string {
		return $this->get_categories_shortcode_prefix() . md5( $filter );
	}

	/**
	 * @return string
	 */
	private function get_settings_key(): string {
		return $this->prefix . self::SETTINGS_TAG;
	}

	/**
	 * @return string
	 */
	private function get_categories_shortcode_prefix(): string {
		return $this->user_prefix . self::CATEGORIES_SHORTCODE_TAG;
	}

	/**
	 * @return string
	 */
	private function get_products_shortcode_prefix(): string {
		return $this->user_prefix . self::PRODUCTS_SHORTCODE_TAG;
	}

	/**
	 * @return string
	 */
	private function get_catalog_filters_prefix(): string {
		return $this->user_prefix . self::CATALOG_FILTERS_TAG;
	}

	/**
	 * @return string
	 */
	private function get_catalog_products_prefix(): string {
		return $this->user_prefix . self::CATALOG_PRODUCTS_TAG;
	}

	/**
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function get_product( int $id ) {
		return get_transient( $this->get_product_key( $id ) );
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function get_related_product( string $id ) {
		return get_transient( $this->get_related_product_key( $id ) );
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 */
	public function get_order( string $id ) {
		return get_transient( $this->get_order_key( $id ) );
	}

	/**
	 *
	 * @return int
	 */
	private function set_expiration_time(): int {
		if ( $this->is_enabled ) {
			$expiration_time = get_option( self::EXPIRATION_TIME_OPTION );
			$custom_time     = get_option( self::CUSTOM_EXPIRATION_TIME_OPTION );

			return (int) ( $expiration_time === 'custom' ? $custom_time : $expiration_time );
		}

		return 0;
	}

	/**
	 * @param string $key
	 * @param mixed  $data
	 * @param int    $time
	 *
	 * @return bool
	 */
	public function set_cache( string $key, $data, int $time ): bool {
		$result = false;
		if ( $this->is_enabled ) {
			$result = set_transient( $key, $data, $time );
		}

		return $result;
	}

	/**
	 * @param int   $id
	 * @param array $product_data
	 *
	 * @return bool
	 */
	public function set_product( int $id, array $product_data ): bool {
		return $this->set_cache( $this->get_product_key( $id ), $product_data, $this->set_expiration_time() );
	}

	/**
	 * @param string $id
	 * @param array  $data
	 *
	 * @return bool
	 */
	public function set_related_product( string $id, array $data ): bool {
		return $this->set_cache( $this->get_related_product_key( $id ), $data, $this->set_expiration_time() );
	}


	/**
	 * @param string $id
	 * @param array  $data
	 *
	 * @return bool
	 */
	public function set_order( string $id, array $data ): bool {
		return $this->set_cache( $this->get_order_key( $id ), $data, $this->set_expiration_time() );
	}


	/**
	 * @param array  $data
	 * @param string $filter
	 *
	 * @return bool
	 */
	public function set_catalog_products( array $data, string $filter ): bool {
		return $this->set_cache( $this->get_catalog_products_key( $filter ), $data, $this->set_expiration_time() );
	}

	/**
	 * @param string $filter
	 *
	 * @return mixed
	 */
	public function get_catalog_products( string $filter ) {
		return get_transient( $this->get_catalog_products_key( $filter ) );
	}

	/**
	 * @param array  $data
	 * @param string $filter
	 *
	 * @return bool
	 */
	public function set_catalog_filters( array $data, string $filter ): bool {
		return $this->set_cache( $this->get_catalog_filters_key( $filter ), $data, $this->set_expiration_time() );
	}

	/**
	 * @param string $filter
	 *
	 * @return mixed
	 */
	public function get_catalog_filters( string $filter ) {
		return get_transient( $this->get_catalog_filters_key( $filter ) );
	}


	/**
	 * @param string $data
	 *
	 * @return bool
	 */
	public function set_settings( string $data ): bool {
		return $this->set_cache( $this->get_settings_key(), $data, $this->set_expiration_time() );
	}

	/**
	 *
	 * @return mixed
	 */
	public function get_settings() {
		return get_transient( $this->get_settings_key() );
	}

	/**
	 * @param array  $data
	 * @param string $filter
	 *
	 * @return bool
	 */
	public function set_products_shortcode( array $data, string $filter ): bool {
		return $this->set_cache( $this->get_product_shortcode_key( $filter ), $data, $this->set_expiration_time() );
	}

	/**
	 * @param string $filter
	 *
	 * @return mixed
	 */
	public function get_products_shortcode( string $filter ) {
		return get_transient( $this->get_product_shortcode_key( $filter ) );
	}

	/**
	 * @param array  $data
	 * @param string $filter
	 *
	 * @return bool
	 */
	public function set_categories_shortcode( array $data, string $filter ): bool {
		return $this->set_cache( $this->get_categories_shortcode_key( $filter ), $data, $this->set_expiration_time() );
	}

	/**
	 * @param string $filter
	 *
	 * @return mixed
	 */
	public function get_categories_shortcode( string $filter ) {
		return get_transient( $this->get_categories_shortcode_key( $filter ) );
	}

	/**
	 * @param int $id
	 *
	 * @return bool
	 */
	public function reset_product( int $id ): bool {
		return delete_transient( $this->get_product_key( $id ) );
	}

	/**
	 * @return void
	 */
	public function reset_catalog() {
		$this->clear( $this->get_catalog_products_prefix() );
		$this->clear( $this->get_catalog_filters_prefix() );
	}

	/**
	 * @param string $token
	 *
	 * @return void
	 */
	public function reset_order( string $token ) {
		$this->clear( $this->get_order_key( $token ) );
	}

	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public function reset_related_products( string $id ) {
		$this->clear( $this->get_related_product_key( $id ) );
	}

	/**
	 * @param string $prefix
	 *
	 * @return bool
	 */
	public function clear( string $prefix = '' ) {
		global $wpdb;

		if ( empty( $prefix ) ) {
			$prefix = esc_sql( $this->prefix );
			$t      = esc_sql( "_transient_$prefix%" );
		} else {
			$t = "%_transient_$prefix" . '%';
		}

		$transients = $wpdb->get_col(
			$wpdb->prepare(
				"
			      SELECT option_name
			      FROM {$wpdb->options}
			      WHERE option_name like %s
			    ",
				$t
			)
		);

		foreach ( $transients as $transient ) {
			$key = str_replace( '_transient_', '', $transient );
			delete_transient( $key );
		}

		wp_cache_flush();
	}
}
