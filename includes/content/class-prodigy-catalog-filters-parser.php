<?php
namespace Prodigy\Includes\Content;

use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Categories;
use Prodigy\Includes\Prodigy_Cache;

/**
 * Prodigy content catalog filters
 *
 * @version    2.8.9
 */
class Prodigy_Catalog_Filters_Parser extends Prodigy_Main_Content {

	/**
	 * Types of content data in catalog-filters query response
	 */
	const CATEGORIES_TYPE_CONTENT       = 'categories';
	const ATTRIBUTES_TYPE_CONTENT       = 'properties';
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
	 * @param array $content
	 *
	 * @return array
	 */
	public static function get_categories( array $content ) {
		$categories = array();
		if ( ! empty( $content['included'] ) ) {
			foreach ( $content['included'] as $item ) {
				if ( $item['type'] === self::CATEGORIES_TYPE_CONTENT ) {
					$categories[ $item['id'] ] = $item;
				}
			}
		}

		return $categories;
	}


	/**
	 * @param array $content
	 *
	 * @return array
	 */
	public static function get_attributes( array $content ): array {
		$attributes = array();
		if ( ! empty( $content['included'] ) ) {
			foreach ( $content['included'] as $key => $item ) {
				if ( $item['type'] === self::ATTRIBUTES_TYPE_CONTENT ) {
					$attributes[ $key ] = $item;
				}
			}
		}

		$options = array();
		if ( ! empty( $content['included'] ) ) {
			foreach ( $content['included'] as $key => $item ) {
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
				if ( ! empty( $attribute['relationships']['options']['data'] ) ) {
					foreach ( $attribute['relationships']['options']['data'] as $key_value => $value ) {
						foreach ( $options as $option ) {
							if ( isset( $value['id'] ) && $value['id'] === $option['id'] ) {
								$value = (array) $option['attributes'];
								$new_attributes[ $key ]['values'][ $key_value ]['id']   = $option['id'];
								$new_attributes[ $key ]['values'][ $key_value ]['name'] = $value['value'];
								if ( $attribute['attributes']['slug'] ) {
									$new_attributes[ $key ]['values'][ $key_value ]['slug'] = $value['slug'];
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
	 * @param array $content
	 *
	 * @return array
	 */
	public static function get_catalog_info( array $content ): array {
		return $content['data'] ?? array();
	}
}
