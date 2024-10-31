<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Categories;

/**
 * Prodigy content catalog filters
 *
 * @version    2.8.9
 */
class Prodigy_Content_Catalog_Filters extends Prodigy_Main_Content {

	/**
	 * Types of catalog filters response data
	 */
	const CATEGORIES_TYPE_CONTENT = 'categories';
	const ATTRIBUTES_TYPE_CONTENT = 'properties';
	const ATTRIBUTES_VALUE_TYPE_CONTENT = 'options';

	/**
	 * @var object $filters
	 */
	private $filters;

	/**
	 * @var Prodigy_Cache
	 */
	public $cache;

	/**
	 * @var Prodigy_Attributes
	 */
	public $attributes;

	/**
	 * @var Prodigy_Categories
	 */
	public $categories;

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
		$this->is_object_init    = true;
		$this->cache      = new Prodigy_Cache();
		$this->attributes = new Prodigy_Product_Attributes();
		$category         = $this->get_catalog_category_param( $query['tax_slug'] ?? '', $query['tax_name'] ?? '' );
		$query_params     = $this->set_query_catalog_params( $query, $is_elementor );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$this->filters = $this->get_filters( $query_params, (int) $this->get_number_per_page() );
	}


	/**
	 * @param string $query_params
	 * @param int    $number_items_per_page
	 *
	 * @return mixed
	 */
	public function get_filters( string $query_params, int $number_items_per_page ) {
		$query           = $this->catalog_query_builder( $query_params, $number_items_per_page );
		$relations_query = 'categories.children,categories.parent,tags,properties.options';
		$catalog         = $this->cache->get_catalog_filters( $query );
		$catalog_url     = prodigy_is_frontend() ? Prodigy_Api_Client::CATALOG_URL : Prodigy_Api_Client::CATALOG_ADMIN_URL;

		if ( ! empty( $catalog ) ) {
			$object = $catalog;
		} else {
			$catalog_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $catalog_url . '?include=' . $relations_query . '&' . $query;
			$response    = $this->api_client->get_remote_content( $catalog_url );
			$body        = wp_remote_retrieve_body( $response );
			$object      = json_decode( $body, true );
			$this->cache->set_catalog_filters( $object ?? array(), $query );
		}

		return $object;
	}

	/**
	 * @return array
	 */
	public function get_categories() {
		$this->categories = array();
		if ( ! empty( $this->filters['included'] ) ) {
			foreach ( $this->filters['included'] as $item ) {
				if ( $item['type'] === self::CATEGORIES_TYPE_CONTENT ) {
					$this->categories[ $item['id'] ] = $item;
				}
			}
		}

		return $this->categories;
	}

	/**
	 * @return array
	 */
	public function get_attributes(): array {
		$attributes = array();
		if ( ! empty( $this->filters['included'] ) ) {
			foreach ( $this->filters['included'] as $key => $item ) {
				if ( $item['type'] === self::ATTRIBUTES_TYPE_CONTENT ) {
					$attributes[ $key ] = $item;
				}
			}
		}

		$options = array();
		if ( ! empty( $this->filters['included'] ) ) {
			foreach ( $this->filters['included'] as $key => $item ) {
				if ( $item['type'] === self::ATTRIBUTES_VALUE_TYPE_CONTENT ) {
					$options[ $key ] = $item;
				}
			}
		}

		$new_attributes = array();
		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $key => $attribute ) {
				$new_attributes[ $key ]['name'] = $attribute['attributes']['name'];
				$new_attributes[ $key ]['id']   = $attribute['id'];
				$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_name( $attribute['attributes']['name'] );
				if ( ! empty( $attribute['relationships']['options']['data'] ) ) {
					foreach ( $attribute['relationships']['options']['data'] as $key_value => $value ) {
						foreach ( $options as $option ) {
							if ( isset( $value['id'] ) && $value['id'] === $option['id'] ) {
								$value                                                      = (array) $option['attributes'];
								$new_attributes[ $key ]['values'][ $key_value ]['id']       = $option['id'];
								$new_attributes[ $key ]['values'][ $key_value ]['name']     = $value['value'];
								if ( $taxonomy ) {
									$term = get_term_by( 'name', $value['value'], $taxonomy->slug );
									if ( $term ) {
										$new_attributes[ $key ]['values'][ $key_value ]['slug'] = $term->slug;
									}
								}
								$new_attributes[ $key ]['values'][ $key_value ]['selected'] = $value['selected'];
								$new_attributes[ $key ]['values'][ $key_value ]['count']    = $value['products-count'];
							}
						}
					}
				}
			}
		}

		return $new_attributes;
	}

	/**
	 * Get catalog info
	 *
	 * @return mixed
	 */
	public function get_catalog_info() {
		return $this->filters['data'] ?? array();
	}
}
