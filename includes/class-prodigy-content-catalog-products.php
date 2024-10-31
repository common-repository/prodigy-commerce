<?php

namespace Prodigy\Includes;

/**
 * Prodigy content catalog products
 *
 * @version    2.8.9
 */
class Prodigy_Content_Catalog_Products extends Prodigy_Main_Content {
	/**
	 * @var object $products
	 */
	public $products;

	/**
	 * Option to check object already exist
	 *
	 * @var bool
	 */
	public $is_object_init = false;

	/**
	 * @param array $query
	 * @param bool  $is_elementor
	 *
	 * @return void
	 */
	public function init( array $query, bool $is_elementor = false ) {
		$this->is_object_init = true;
		$category             = $this->get_catalog_category_param( $query['tax_slug'] ?? '', $query['tax_name'] ?? '' );
		$query_params         = $this->set_query_catalog_params( $query, $is_elementor );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$this->products = $this->get_catalog_products( $query_params, (int) $this->get_number_per_page() );
	}

	/**
	 * @param string $query_params
	 * @param int    $number_items_per_page
	 *
	 * @return mixed
	 */
	public function get_catalog_products( string $query_params, int $number_items_per_page ) {
		$query    = $this->catalog_query_builder( $query_params, $number_items_per_page );
		$products = $this->cache->get_catalog_products( $query );

		if ( ! empty( $products ) && ! empty( $products['data'] ) ) {
			$object = $products;
		} else {
			$product_url      = prodigy_is_frontend() ? Prodigy_Api_Client::PRODUCTS_URL : Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
			$api_url          = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . '?' . $query;
			$product_response = $this->api_client->get_remote_content( $api_url );
			$body             = wp_remote_retrieve_body( $product_response );
			$object           = json_decode( $body, true );
			$this->cache->set_catalog_products( $object ?? array(), $query );
		}

		return $object;
	}

	/**
	 * @return array
	 */
	public function get_products(): array {
		$products = array();
		if ( isset( $this->products['data'] ) ) {
			foreach ( $this->products['data'] as $key => $item ) {
				$products[ $key ] = $item;
			}
		}

		return $products;
	}

	/**
	 * Get pagination info
	 *
	 * @return mixed
	 */
	public function get_pagination() {
		return $this->filters->links ?? array();
	}
}
