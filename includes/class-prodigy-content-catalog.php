<?php

/**
 * Prodigy content catalog
 *
 * @version    2.0
 * @package    prodigy/includes/public/remote-hs
 */
namespace Prodigy\Includes;

use Exception;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Taxonomies;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Product_Catalog
 */
class Prodigy_Content_Catalog extends Prodigy_Main_Content {

	const PRODUCT_TYPE_CONTENT          = 'products';
	const CATEGORIES_TYPE_CONTENT       = 'categories';
	const ATTRIBUTES_TYPE_CONTENT       = 'properties';
	const ATTRIBUTES_VALUE_TYPE_CONTENT = 'options';

	private $catalog;

	public $cache;

	public $attributes;

	public $elementor_options;

	public $customizer_options;

	public $elementor_conditions;

	public $categories;

	private static $instances = array();
	public $getMain           = false;

	protected function __clone() { }

	public function __wakeup() {
		throw new Exception( 'Cannot unserialize singleton' );
	}


	public static function getInstance(): Prodigy_Content_Catalog {
		$cls = static::class;
		if ( ! isset( self::$instances[ $cls ] ) ) {
			self::$instances[ $cls ] = new static();
		}

		return self::$instances[ $cls ];
	}

	/**
	 * @return int
	 */
	public function getNumberPerPage(): int {
		if ( Prodigy_Layouts_Manager::is_using_elementor_templates() &&
			isset($this->elementor_options['content_archive_products_content_items_number'])
		) {
			return $this->elementor_options['content_archive_products_content_items_number'];
		} elseif (isset($this->customizer_options['prodigy_shop_products_number_items_per_page'])) {
			return $this->customizer_options['prodigy_shop_products_number_items_per_page'];
		} else {
			return Prodigy_Shop_Page::NUMBER_ITEMS_PER_PAGE;
		}
	}

	/**
	 * @param array $query
	 * @param bool  $is_elementor
	 *
	 * @return string
	 */
	public function setQueryParams( array $query, bool $is_elementor = false ) {
		if ( $is_elementor ) {
			if ( isset( $this->elementor_options['content_archive_products_content_order_by'] ) && ! isset( $query['sort'] ) ) {
				$order = '';
				if (
					isset( $this->elementor_options['content_archive_products_content_order'] )
					&& $this->elementor_options['content_archive_products_content_order'] == 'desc'
				) {
					$order = '-';
				}
				$query['sort'] = $order . $this->mappingOrderParams( $this->elementor_options['content_archive_products_content_order_by'] );
			}
		}

		return build_query( $query );
	}

    /**
     * @param string $order
     * @return string
     */
    public function mappingOrderParams( string $order ) {
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
	 * @param array $query
	 * @param bool  $is_elementor
	 *
	 * @return void
	 */
	public function init( array $query, $is_elementor = false ) {
		$this->getMain              = true;
		$this->cache                = new Prodigy_Cache();
		$this->attributes           = new Prodigy_Product_Attributes();
		$this->elementor_options    = get_option( 'pg_elementor_archive_widget', array() );
		$this->customizer_options   = get_option( 'prodigy_shop_settings', array() );
		$this->elementor_conditions = get_option( 'elementor_pro_theme_builder_conditions', array() );
        $category = $this->get_category_param($query['tax_slug'] ?? '', $query['tax_name'] ?? '');
		$query_params               = $this->setQueryParams( $query, $is_elementor );
		if ( ! empty( $category ) && is_string( $category ) && is_string( $query_params ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$this->catalog = $this->get_catalog( $query_params, $this->getNumberPerPage() );
	}

	/**
	 * @param $query_params
	 * @param $number_items_per_page
	 *
	 * @return mixed
	 */
	public function get_catalog( $query_params, $number_items_per_page ) {
		$query           = $this->catalog_query_builder( $query_params, $number_items_per_page );
		$relations_query = 'products,categories.children,categories.parent,tags,properties.options';
		$catalog         = $this->cache->get_catalog( $query );
		$catalog_url     = prodigy_is_frontend() ? Prodigy_Api_Client::CATALOG_URL : Prodigy_Api_Client::CATALOG_ADMIN_URL;

		if ( ! empty( $catalog ) ) {
			$object = $catalog;
		} else {
			$catalog_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $catalog_url . '?include=' . $relations_query . '&' . $query;
			$response    = $this->api_client->get_remote_content( $catalog_url );
			$body        = wp_remote_retrieve_body( $response );
			$object      = json_decode( $body, false );
			$this->cache->set_catalog( $object, $query );
		}

		return $object;
	}

	/**
	 * Check and get category from url
	 *
	 * @return bool|mixed|string
	 */
    public function get_category_param($tax_name, $tax_slug) {
        if (empty($tax_name) && empty($tax_slug)) {
            $url = isset($_SERVER['REQUEST_URI']) ? esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : '';
            $info = wp_parse_url($url);

            $path = explode('/', $info['path']);
            foreach ($path as $part) {
                if (
                    $part === Prodigy::get_prodigy_category_slug() ||
                    $part === Prodigy::get_prodigy_tag_slug()
                ) {
                    $tax_slug = $part;
                    $tax_name = true;
                }
            }

            foreach ( $path as $part ) {
                $term = get_term_by( 'slug', $part, Prodigy::get_prodigy_category_type() );
                if ( ! empty( $term ) ) {
                    $tax_name = $part;
                }
            }
        }

        $result = '';
        if (is_string($tax_name) && !empty($tax_slug)) {
            $is_prodigy_category = wp_doing_ajax()
                ? ($tax_slug === Prodigy::get_prodigy_category_type()) : ($tax_slug === Prodigy::get_prodigy_category_slug());
            $is_prodigy_tag = wp_doing_ajax()
                ? ($tax_slug === Prodigy::get_prodigy_tag_type()) : ($tax_slug === Prodigy::get_prodigy_tag_slug());

            if ($is_prodigy_category) {
                $taxonomy = Prodigy_Taxonomies::get_taxonomy_by_different_slugs(Prodigy::get_prodigy_category_type(), $tax_name);
                if (!empty($taxonomy)) {
                    $termmeta = get_term_meta($taxonomy->term_id, 'prodigy_hosted_category_relation', true);
                    if (!empty($termmeta)) {
                        $result = 'category_id=' . $termmeta;
                    }
                }
            } elseif ($is_prodigy_tag) {
                $taxonomy = Prodigy_Taxonomies::get_taxonomy_by_different_slugs(Prodigy::get_prodigy_tag_type(), $tax_name);
                if (!empty($taxonomy)) {
                    $termmeta = get_term_meta($taxonomy->term_id, Prodigy::PRODIGY_HOSTED_TAG_RELATION, true);
                    if (!empty($termmeta)) {
                        $result = 'tag_id=' . $termmeta;
                    }
                }
            }
        }

        return $result;
    }


	/**
	 * @param $query
	 * @param $count_items_per_page
	 *
	 * @return string
	 */
	public function catalog_query_builder( $query, $count_items_per_page ) {
		$request_attr = array();
		if ( ! empty( $query ) && is_string( $query ) ) {
			parse_str( urldecode( (string) $query ), $request_attr );
		}

		$request_attr = (array) $request_attr;

		$attributes = array();
		if ( isset( $request_attr ) ) {
			if ( ! empty( $request_attr['search'] ) ) {
				$attributes['search'] = $request_attr['search'];
			} else {
				if ( ! empty( $request_attr['attr'] ) ) {
					foreach ( $request_attr['attr'] as $key => $attribute ) {
						$values[ $key ] = explode( ';', $attribute );

						$attribute_values = array();
						foreach ( $values[ $key ] as $key_val => $value ) {
							$slug = self::createSlug( $value );

							$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_remote_id( $key );
							if ( isset( $taxonomy ) ) {
								$term_attribute = Prodigy_Attributes::get_attributes_by_different_slugs( $taxonomy->slug, $slug );

								$attribute_value_remote_id    = get_term_meta(
									$term_attribute->term_id,
									'prodigy_attribute_value_remote_id',
									true
								);
								$attribute_values[ $key_val ] = $attribute_value_remote_id;
								$attributes['options_filter'][ $key ]['property_id'] = $key;
								$attributes['options_filter'][ $key ]['option_ids']  = $attribute_values;
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

				if ( isset( $request_attr['sort'] ) ) {
					$attributes['sort'] = $request_attr['sort'];
				}

				$attributes['page']['size']   = $count_items_per_page;
				$attributes['page']['number'] = $request_attr['pg'] ?? 1;
			}
		}

		if ( empty( $request_attr ) ) {
			$attributes['page']['size']   = $count_items_per_page;
			$attributes['page']['number'] = $request_attr['pg'] ?? 1;
		}

		if ( isset( $request_attr['sort'] ) ) {
			$patterns[0]        = '/_asc/';
			$patterns[1]        = '/_desc/';
			$replacements       = '';
			$sort               = preg_replace( $patterns, $replacements, $request_attr['sort'] );
			$attributes['sort'] = $sort;
		} else {
			$attributes['sort'] = $this->customizer_options['prodigy_shop_default_sortable'] ?? '-created_at';
		}

        $attributes['sync'] = true;

		if ( ! prodigy_is_frontend() ) {
			$attributes['admin'] = true;
		}

		$query_string       = http_build_query( $attributes );
		return urldecode( preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D/', '[]', $query_string ) );
	}

	public static function createSlug( $str, $delimiter = '-' ) {
		return $slug = strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $str ) ) );
	}

	/**
	 * @return array
	 */
	public function get_products() {
		$products = array();
		if ( isset( $this->catalog->included ) ) {
			foreach ( $this->catalog->included as $key => $item ) {
				if ( self::PRODUCT_TYPE_CONTENT === $item->type ) {
					$products[ $key ] = $item;
				}
			}
		}

		return $products;
	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function getCategoryInfoById( int $id ) {
		$result = array();

		if ( isset( $this->categories[ $id ] ) ) {
			$result = $this->categories[ $id ];
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function get_categories() {
		$this->categories = array();
		if ( ! empty( $this->catalog->included ) ) {
			foreach ( $this->catalog->included as $key => $item ) {
				if ( self::CATEGORIES_TYPE_CONTENT === $item->type ) {
					$this->categories[ $item->id ] = $item;
				}
			}
		}

		return $this->categories;
	}

	/**
	 * @return array
	 */
	public function get_attributes() {
		$attributes = array();
		if ( ! empty( $this->catalog->included ) ) {
			foreach ( $this->catalog->included as $key => $item ) {
				if ( self::ATTRIBUTES_TYPE_CONTENT === $item->type ) {
					$attributes[ $key ] = $item;
				}
			}
		}

		$options = array();
		if ( ! empty( $this->catalog->included ) ) {
			foreach ( $this->catalog->included as $key => $item ) {
				if ( self::ATTRIBUTES_VALUE_TYPE_CONTENT === $item->type ) {
					$options[ $key ] = $item;
				}
			}
		}

		$new_attributes = array();
		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $key => $attribute ) {
				$new_attributes[ $key ]['name'] = $attribute->attributes->name;
				$new_attributes[ $key ]['id']   = $attribute->id;
				if ( ! empty( $attribute->relationships->options->data ) ) {

					foreach ( $attribute->relationships->options->data as $key_value => $value ) {
						foreach ( $options as $option ) {
							if ( isset( $value->id, $option->id ) ) {
								if ( $value->id === $option->id ) {
									$value = (array) $option->attributes;
									$new_attributes[ $key ]['values'][ $key_value ]['id']       = $option->id;
									$new_attributes[ $key ]['values'][ $key_value ]['name']     = $value['value'];
									$new_attributes[ $key ]['values'][ $key_value ]['selected'] = $value['selected'];
									$new_attributes[ $key ]['values'][ $key_value ]['count']    = $value['products-count'];
								}
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
		return $this->catalog->data ?? array();
	}

	/**
	 * Get pagination info
	 *
	 * @return mixed
	 */
	public function get_pagination() {
		return $this->catalog->links ?? array();
	}

}
