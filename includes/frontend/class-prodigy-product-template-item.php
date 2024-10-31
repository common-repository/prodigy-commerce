<?php
/**
 * Prodigy common widget class
 *
 * @version    2.0.6
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Product_Item
 */
class Prodigy_Product_Template_Item {

	protected $row_id;
	protected $remote_product_id;
	protected $fields;
	protected $meta;
	protected $categories;
	protected $tags;
	protected $count_reviews;
	protected $count_rating;
	protected $average_rating;
	protected $range_setting;
	protected $prepared_attributes;
	protected $prepared_variants;
	protected $subscriptions;
	protected $up_sell_products;
	protected $cross_sell_products;
	protected $both_sell_products;
	protected $local_product_id;
	protected $remote_stock_status;
	protected $remote_tags;
	protected $remote_categories;
	protected $remote_description;
	protected $remote_title;
	protected $remote_variants;
	protected $remote_range_current_price;
	protected $remote_main_sku;
	protected $remote_images;

	protected $images;
	protected $variant_option;
	protected $descriptive_option;
	protected $descriptive_attributes;
	public $remote_master_variant_info;
	public $remote_master_id_variant;
	public $remote_main_price;

	public $display_options_type;

	public $tiered_prices;
	public $tiered_price_range;

	public $master_variant_logos;

	/**
	 *  Set logos for option
	 *
	 * @var array
	 */
	protected $logos;

	/**
	 *  Set logo locations for option
	 *
	 * @var array
	 */
	protected $logo_locations;


	protected $personalizations_fields;

	/**
	 * Charge amount
	 *
	 * @var string
	 */
	protected $charge_amount;

	/**
	 * Options intersection
	 *
	 * @var array
	 */
	protected $options_intersect;

	/**
	 * @return mixed
	 */
	public function get_row_id() {
		return $this->row_id;
	}

	/**
	 * @param array $logos
	 */
	public function set_logos( array $logos ) {
		$this->logos = $logos;
	}

	/**
	 * @param array $logo_locations
	 */
	public function set_logo_locations( array $logo_locations ) {
		$this->logo_locations = $logo_locations;
	}

	/**
	 * @return array
	 */
	public function get_logo_locations(): array {
		return $this->logo_locations ?? array();
	}

	/**
	 * @return array
	 */
	public function get_logos(): array {
		return $this->logos ?? array();
	}

	/**
	 * @return mixed
	 */
	public function get_remote_product_id() {
		return $this->remote_product_id;
	}

	public function get_display_options_type() {
		return $this->display_options_type;
	}

	/**
	 * @param array $prices_range
	 * @return void
	 */
	public function set_tiered_price_range( array $prices_range ) {
		$this->tiered_price_range = $prices_range;
	}

	/**
	 * @param array $fields
	 * @return void
	 */
	public function set_personalizations_fields( array $fields ) {
		$this->personalizations_fields = $fields;
	}

	/**
	 * @return mixed
	 */
	public function get_personalizations_fields() {
		return $this->personalizations_fields;
	}

	/**
	 * @return mixed
	 */
	public function get_tiered_price_range() {
		return $this->tiered_price_range;
	}

	/**
	 * @param array $prices
	 * @return void
	 */
	public function set_tiered_prices( array $prices ) {
		$this->tiered_prices = $prices;
	}

	/**
	 * @return mixed
	 */
	public function get_tiered_prices() {
		return $this->tiered_prices;
	}

	public function set_display_options_type( $type ) {
		$this->display_options_type = $type;
	}

	/**
	 * @param $id
	 */
	public function set_row_id( $id ): void {
		$this->row_id = $id;
	}

	public function set_remote_product_id( $id ) {
		$this->remote_product_id = $id;
	}

	/**
	 * @param array $fields
	 */
	public function set_fields( $fields ) {
		$this->fields = $fields;
	}

	/**
	 * @param array $meta
	 */
	public function set_meta( $meta ) {
		$this->meta = $meta;
	}

	/**
	 * @param $variants
	 */
	public function set_prepared_variants( $variants ) {
		$this->prepared_variants = $variants;
	}

	/**
	 * @param array $data
	 */
	public function set_subscriptions( array $data ) {
		$this->subscriptions = $data;
	}

	/**
	 * @return mixed
	 */
	public function get_subscriptions() {
		return $this->subscriptions;
	}

	/**
	 * @return mixed
	 */
	public function get_prepared_variants() {
		return $this->prepared_variants;
	}

	/**
	 * @param array $data
	 */
	public function set_up_sell_products( array $data ) {
		$this->up_sell_products = $data;
	}

	/**
	 * @param array $data
	 */
	public function set_cross_sell_products( array $data ) {
		$this->cross_sell_products = $data;
	}

	/**
	 * @param array $data
	 */
	public function set_both_sell_products( array $data ) {
		$this->both_sell_products = $data;
	}

	/**
	 * @param int $id
	 */
	public function set_local_product_id( $id ) {
		$this->local_product_id = $id;
	}

	/**
	 * @param object $tags
	 */
	public function set_remote_main_stock_status( $status ) {
		$this->remote_stock_status = $status;
	}

	/**
	 * @param array $tags
	 */
	public function set_remote_tags( array $tags ) {
		$this->remote_tags = $tags;
	}

	/**
	 * @param array $categories
	 */
	public function set_remote_categories( array $categories ) {
		$this->remote_categories = $categories;
	}

	/**
	 * @param string $description
	 */
	public function set_remote_description( $description ) {
		$this->remote_description = $description;
	}

	/**
	 * @param string $description
	 */
	public function set_remote_title( $title ) {
		$this->remote_title = $title;
	}

	/**
	 * @param array $variants
	 */
	public function set_remote_variants( array $variants ) {
		$this->remote_variants = $variants;
	}

	/**
	 * @param array $price
	 */
	public function set_remote_main_price( $price ) {
		$this->remote_main_price = $price;
	}

	/**
	 * @param $status
	 */
	public function set_range_setting( $status ) {
		$this->range_setting = $status;
	}

	/**
	 * @return mixed
	 */
	public function get_range_setting() {
		return $this->range_setting;
	}

	/**
	 * @param array $data
	 */
	public function set_remote_range_current_price( $data ) {
		$this->remote_range_current_price = $data;
	}

	/**
	 * @param string $sku
	 */
	public function set_remote_main_sku( $sku ) {
		$this->remote_main_sku = $sku;
	}

	/**
	 * Set charge amount
	 *
	 * @param string $amount
	 */
	public function set_charge_amount( string $amount ) {
		$this->charge_amount = $amount;
	}

	/**
	 * Get charge amount
	 *
	 * @return string
	 */
	public function get_charge_amount(): string {
		return $this->charge_amount;
	}

	/**
	 * @param array $images
	 */
	public function set_remote_images( array $images ) {
		$this->remote_images = $images;
	}

	/**
	 * @param object $data
	 */
	public function set_remote_master_variant_info( $data ) {
		$this->remote_master_variant_info = $data;
	}

	/**
	 * @param array $data
	 */
	public function set_master_variant_logos( array $data ) {
		$this->master_variant_logos = $data;
	}

	/**
	 * @return mixed
	 */
	public function get_master_variant_logos() {
		return $this->master_variant_logos;
	}

	/**
	 * @param $data
	 */
	public function set_descriptive_attributes( $data ) {
		$this->descriptive_attributes = $data;
	}

	/**
	 * @param $data
	 */
	public function set_descriptive_option( $data ) {
		$this->descriptive_option = $data;
	}

	/**
	 * @param array $data
	 */
	public function set_variant_options( array $data ) {
		$this->variant_option = $data;
	}

	public function set_images( $data ) {
		$this->images = $data;
	}

	/**
	 * @param int $id
	 */
	public function set_master_id_variant( $id ) {
		$this->remote_master_id_variant = $id;
	}
	/*
	 * @version 2.0.0
	 */

	/**
	 * @param int $count
	 */
	public function set_count_reviews( $count ) {
		$this->count_reviews = $count;
	}

	/**
	 * @param int $count
	 */
	public function set_count_rating( $count ) {
		$this->count_rating = $count;
	}

	/**
	 * @param float $avg
	 */
	public function set_average_rating( $avg ) {
		$this->average_rating = $avg;
	}

	/**
	 * @return array
	 */
	public function get_count_reviews() {
		return $this->count_reviews;
	}

	/**
	 * @return int
	 */
	public function get_count_rating() {
		return $this->count_rating;
	}

	/**
	 * @return float
	 */
	public function get_average_rating() {
		return $this->average_rating;
	}

	/**
	 * @param string $field_name
	 *
	 * @return string
	 */
	public function get_field( $field_name ) {
		return isset( $this->fields[ $field_name ] ) ? $this->fields[ $field_name ] : '';
	}

	/**
	 * @param string $meta_field_name
	 *
	 * @return string
	 */
	public function get_meta_field( $meta_field_name ) {
		return isset( $this->meta[ $meta_field_name ][0] ) ? $this->meta[ $meta_field_name ][0] : '';
	}

	/**
	 * @return object
	 */
	public function get_remote_tags() {
		return $this->remote_tags ?? '';
	}

	/**
	 * @return object
	 */
	public function get_cross_sell_products() {
		return $this->cross_sell_products ?? '';
	}

	/**
	 * @return object
	 */
	public function get_both_sell_products() {
		return $this->both_sell_products ?? '';
	}

	/**
	 * @return object
	 */
	public function get_up_sell_products() {
		return $this->up_sell_products ?? '';
	}

	/**
	 * @return object
	 */
	public function get_remote_categories() {
		return $this->remote_categories ?? '';
	}

	/**
	 * @return object
	 */
	public function get_remote_variants() {
		return $this->remote_variants ?? '';
	}

	/**
	 * @return object
	 */
	public function get_remote_main_price() {
		return $this->remote_main_price ?? '';
	}

	public function get_remote_range_current_price() {
		return $this->remote_range_current_price ?? '';
	}

	/**
	 * @return object
	 */
	public function get_remote_main_sku() {
		return $this->remote_main_sku ?? '';
	}

	/**
	 * @return object
	 */
	public function get_remote_images() {
		return $this->remote_images ?? '';
	}

	/**
	 * @return array
	 */
	public function get_remote_master_variant_info() {
		return $this->remote_master_variant_info ?? array();
	}

	/**
	 * @return string
	 */
	public function get_remote_description() {
		return $this->remote_description ?? '';
	}

	/**
	 * @return string
	 */
	public function get_remote_title() {
		return $this->remote_title ?? '';
	}

	/**
	 * @return object
	 */
	public function get_descriptive_attributes() {
		return $this->descriptive_attributes ?? '';
	}

	/**
	 * @return object
	 */
	public function get_descriptive_option() {
		return $this->descriptive_option ?? '';
	}

	/**
	 * @return array
	 */
	public function get_variant_options(): array {
		return $this->variant_option ?? array();
	}

	/**
	 * @return mixed
	 */
	public function get_images() {
		return $this->images ?? '';
	}

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function set_option_variants_intersect( array $options ): array {
		return $this->options_intersect = $options;
	}

	/**
	 * @return array
	 */
	public function get_option_variants_intersect(): array {
		return $this->options_intersect;
	}
}
