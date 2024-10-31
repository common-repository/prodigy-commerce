<?php

namespace Prodigy\Includes\Content;

use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;

defined( 'ABSPATH' ) || exit;

/**
 * Prodigy main content class
 *
 * @version    2.8.9
 */
class Prodigy_Main_Content {

	/**
	 * @var Prodigy_Api_Client
	 */
	protected $api_client;

	/**
	 * @var object Prodigy_Cache
	 */
	public $cache;

	/**
	 * Elementor options from DB
	 *
	 * @var false|array
	 */
	public $elementor_options;

	/**
	 * Customizer options from DB
	 *
	 * @var false|array
	 */
	public $customizer_options;

	/**
	 * @var false|array
	 */
	public $elementor_conditions;

	/**
	 * Types of related products
	 */
	const REMOTE_UP_SELL_PRODUCTS                     = 'up-sell-products';
	const REMOTE_CROSS_SELL_PRODUCTS                  = 'cross-sell-products';
	const REMOTE_TYPE_INCLUDED_UP_CROSS_SELL_PRODUCTS = 'products';

	/**
	 * Prodigy_Product_Catalog constructor.
	 */
	public function __construct() {
		$this->api_client           = new Prodigy_Api_Client();
		$this->cache                = new Prodigy_Cache();
		$this->customizer_options   = get_option( 'prodigy_shop_settings', array() );
		$this->elementor_options    = get_option( 'pg_elementor_archive_widget', array() );
		$this->elementor_conditions = get_option( 'elementor_pro_theme_builder_conditions', array() );
	}

	/**
	 * @param array  $includes
	 * @param int    $id
	 * @param string $type
	 *
	 * @return array
	 */
	public function parse_included_obj_by_id( array $includes, int $id, string $type = '' ): array {
		$remote_included = $includes['included'];
		$data            = array();

		if ( empty( $remote_included ) ) {
			return $data;
		}

		foreach ( $remote_included as $remote_include ) {
			if ( ! empty( $type ) ) {
				if ( (int) $remote_include['id'] === $id && $remote_include['type'] === $type ) {
					$data = $remote_include;
				}
			} elseif ( (int) $remote_include['id'] === $id ) {
				$data = $remote_include;
			}
		}

		return $data;
	}

	/**
	 * @param array  $includes
	 * @param int    $relation_id
	 * @param string $type
	 *
	 * @return array
	 */
	protected function get_logo_ids_from_includes( array $includes, int $relation_id, string $type ): array {
		$logo_relation_ids = array();

		foreach ( $includes as $include ) {
			if (
				! empty( $relation_id ) &&
				(int) $include['id'] === $relation_id &&
				$include['type'] === $type
			) {
				$logo_relation_ids[ $relation_id ] = $include['attributes'];
			}
		}

		return $logo_relation_ids;
	}

	/**
	 * @param array  $ids
	 * @param array  $includes
	 * @param string $type
	 *
	 * @return array
	 */
	public function parse_included_obj_by_ids( array $ids, array $includes = array(), string $type = '' ): array {
		$remote_included = $includes['included'] ?? null;
		$data            = array();

		if ( empty( $remote_included ) ) {
			return $data;
		}

		foreach ( $remote_included as $remote_include ) {
			if ( ! empty( $type ) ) {
				if ( in_array( $remote_include['id'], $ids, true ) && $remote_include['type'] === $type ) {
					$data[] = $remote_include;
				}
			} elseif ( in_array( $remote_include['id'], $ids, true ) ) {
				$data[] = $remote_include;
			}
		}

		return $data ?? array();
	}

	/**
	 * @param array $product
	 *
	 * @return array
	 */
	protected function get_up_sell_products_main( array $product ): array {
		$id_attributes = array();

		if ( ! empty( $product['data']['relationships'] ) ) {
			$data_parse = $product['data']['relationships'][ self::REMOTE_UP_SELL_PRODUCTS ];
			if ( ! empty( $data_parse['data'] ) ) {
				$id_attributes = wp_list_pluck( $data_parse['data'], 'id', 'id' );
			}
		}

		return $this->parse_included_obj_by_ids( $id_attributes, $product, self::REMOTE_TYPE_INCLUDED_UP_CROSS_SELL_PRODUCTS );
	}

	/**
	 * @param array $product
	 *
	 * @return array
	 */
	protected function get_cross_sell_products_main( array $product ): array {
		$id_attributes = array();

		if ( ! empty( $product['data']['relationships'] ) ) {
			$data_parse = $product['data']['relationships'][ self::REMOTE_CROSS_SELL_PRODUCTS ];
			if ( ! empty( $data_parse['data'] ) ) {
				$id_attributes = wp_list_pluck( $data_parse['data'], 'id', 'id' );
			}
		}

		return $this->parse_included_obj_by_ids( $id_attributes, $product, self::REMOTE_TYPE_INCLUDED_UP_CROSS_SELL_PRODUCTS );
	}

	/**
	 * @return int
	 */
	public function get_number_per_page(): int {
		if ( Prodigy_Layouts_Manager::is_using_archive_elementor_templates() &&
			isset( $this->elementor_options['content_archive_products_content_items_number'] )
		) {
			return $this->elementor_options['content_archive_products_content_items_number'];
		} elseif ( isset( $this->customizer_options['prodigy_shop_products_number_items_per_page'] ) ) {
			return $this->customizer_options['prodigy_shop_products_number_items_per_page'];
		}

		return Prodigy_Shop_Page::NUMBER_ITEMS_PER_PAGE;
	}

	/**
	 * @param array $query
	 * @param bool  $is_elementor
	 *
	 * @return string
	 */
	public function set_query_catalog_params( array $query, bool $is_elementor = false ): string {
		if ( $is_elementor && isset( $this->elementor_options['content_archive_products_content_order_by'] ) && ! isset( $query['sort'] ) ) {
			$order = '';
			if (
				isset( $this->elementor_options['content_archive_products_content_order'] )
				&& $this->elementor_options['content_archive_products_content_order'] === 'desc'
			) {
				$order = '-';
			}
			$query['sort'] = $order . $this->mapping_order_params( $this->elementor_options['content_archive_products_content_order_by'] );
		}

		return build_query( $query );
	}


	/**
	 * @param string $order
	 *
	 * @return string
	 */
	public function mapping_order_params( string $order ): string {
		$hsParams = array(
			'id'         => 'id',
			'created_at' => 'created_at',
			'date'       => 'created_at',
			'title'      => 'name',
			'rating'     => 'rating',
			'price'      => 'price',
		);

		return $hsParams[ $order ];
	}


	/**
	 * @param string $tax_name
	 * @param string $tax_slug
	 *
	 * @return string
	 */
	public function get_catalog_category_param( string $tax_name, string $tax_slug ): string {
		$category = isset( $_GET[ Prodigy::get_prodigy_category_type() ] ) ? sanitize_text_field( wp_unslash( $_GET[ Prodigy::get_prodigy_category_type() ] ) ) : '';
		$tag      = isset( $_GET[ Prodigy::get_prodigy_tag_type() ] ) ? sanitize_text_field( wp_unslash( $_GET[ Prodigy::get_prodigy_tag_type() ] ) ) : '';
		$uri      = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		if ( ! empty( $category ) ) {
			$tax_name = $category;
			$tax_slug = Prodigy::get_prodigy_category_slug();
		}

		if ( isset( $_GET[ Prodigy::get_prodigy_tag_type() ] ) ) {
			$tax_name = $tag;
			$tax_slug = Prodigy::get_prodigy_tag_slug();
		}

		if ( empty( $tax_name ) && empty( $tax_slug ) ) {
			$info = wp_parse_url( $uri );

			$path = explode( '/', $info['path'] );
			foreach ( $path as $part ) {
				if (
					$part === Prodigy::get_prodigy_category_slug() ||
					$part === Prodigy::get_prodigy_tag_slug()
				) {
					$tax_slug = $part;
					$tax_name = true;
				}
			}

			if ( $tax_slug === Prodigy::get_prodigy_category_slug() ) {
				foreach ( $path as $part ) {
					$term = get_term_by( 'slug', $part, Prodigy::get_prodigy_category_type() );
					if ( $term ) {
						$tax_name = $part;
					}
				}
			}

			if ( is_bool( $tax_name ) ) {
				wp_safe_redirect( home_url( '404' ) );
				exit();
			}

			if ( $tax_slug === Prodigy::get_prodigy_tag_slug() ) {
				foreach ( $path as $part ) {
					$term = get_term_by( 'slug', $part, Prodigy::get_prodigy_tag_type() );
					if ( ! empty( $term ) ) {
						$tax_name = $part;
					}
				}
			}
		}

		$result = '';
		if ( is_string( $tax_name ) && ! empty( $tax_slug ) ) {
			$is_prodigy_category = wp_doing_ajax()
				? ( $tax_slug === Prodigy::get_prodigy_category_type() ) : ( $tax_slug === Prodigy::get_prodigy_category_slug() );
			$is_prodigy_tag      = wp_doing_ajax()
				? ( $tax_slug === Prodigy::get_prodigy_tag_type() ) : ( $tax_slug === Prodigy::get_prodigy_tag_slug() );

			if ( $is_prodigy_category ) {
				$taxonomy = Prodigy_Taxonomies::get_taxonomy_by_different_slugs( Prodigy::get_prodigy_category_type(), $tax_name );
				if ( ! empty( $taxonomy ) ) {
					$termmeta = get_term_meta( $taxonomy->term_id, 'prodigy_hosted_category_relation', true );
					if ( ! empty( $termmeta ) ) {
						$result = 'category_id=' . $termmeta;
					}
				}
			} elseif ( $is_prodigy_tag ) {
				$taxonomy = Prodigy_Taxonomies::get_taxonomy_by_different_slugs( Prodigy::get_prodigy_tag_type(), $tax_name );
				if ( ! empty( $taxonomy ) ) {
					$termmeta = get_term_meta( $taxonomy->term_id, Prodigy::PRODIGY_HOSTED_TAG_RELATION, true );
					if ( ! empty( $termmeta ) ) {
						$result = 'tag_id=' . $termmeta;
					}
				}
			}
		}

		return $result;
	}


	/**
	 * @param string $query
	 * @param int    $count_items_per_page
	 *
	 * @return string
	 */
	public function catalog_query_builder( string $query, int $count_items_per_page ): string {
		$request_attr = array();
		if ( ! empty( $query ) ) {
			parse_str( urldecode( (string) $query ), $request_attr );
		}

		$request_attr = (array) $request_attr;

		$attributes = array();
		if ( ! empty( $request_attr ) ) {
			if ( ! empty( $request_attr['search'] ) ) {
				$attributes['search'] = $request_attr['search'];
			} else {
				if ( ! empty( $request_attr['attr'] ) ) {
					foreach ( $request_attr['attr'] as $key => $attribute ) {
						$values[ $key ] = explode( ';', $attribute );

						$attribute_values = array();
						foreach ( $values[ $key ] as $key_val => $value ) {
							$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_remote_id( $key );
							if ( isset( $taxonomy ) ) {
								$term_attribute = Prodigy_Attributes::get_attributes_by_different_slugs( $taxonomy->slug, $value );

								if ( isset( $term_attribute ) ) {
									$attribute_value_remote_id                           = get_term_meta(
										$term_attribute->term_id,
										'prodigy_attribute_value_remote_id',
										true
									);
									$attribute_values[ $key_val ]                        = $attribute_value_remote_id;
									$attributes['options_filter'][ $key ]['property_id'] = $key;
									$attributes['options_filter'][ $key ]['option_ids']  = $attribute_values;
								}
							}
						}
					}
				}
				if ( isset( $request_attr['category_id'] ) ) {
					$attributes['category_id'] = $request_attr['category_id'];
				}

				if ( isset( $request_attr['tag_id'] ) ) {
					$attributes['tag_id'] = $request_attr['tag_id'];
				}

				if ( isset( $request_attr['price_min'] ) ) {
					$attributes['price']['min'] = $request_attr['price_min'];
					$attributes['price']['max'] = $request_attr['price_max'];
				}
			}
			$attributes['page']['size']   = $count_items_per_page;
			$attributes['page']['number'] = $request_attr['pg'] ?? 1;
		}

		if ( empty( $request_attr ) ) {
			$attributes['page']['size']   = $count_items_per_page;
			$attributes['page']['number'] = $request_attr['pg'] ?? 1;
		}

		if ( ! empty( $request_attr['sort'] ) ) {
			$patterns[0]        = '/_asc/';
			$patterns[1]        = '/_desc/';
			$replacements       = '';
			$sort               = preg_replace( $patterns, $replacements, $request_attr['sort'] );
			$attributes['sort'] = $sort;
		} else {
			$attributes['sort'] = $this->customizer_options['prodigy_shop_default_sortable'] ?? '-created_at';
		}

		$attributes['sync'] = true;

		if ( ! Prodigy_Page::prodigy_is_frontend() ) {
			$attributes['admin'] = true;
		}

		$query_string = http_build_query( $attributes );

		return urldecode( preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D/', '[]', $query_string ) );
	}
}
