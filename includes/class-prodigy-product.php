<?php

namespace Prodigy\Includes;

use SplMinHeap;
use SplMaxHeap;

defined( 'ABSPATH' ) || exit;

/**
 * Class RemoteProduct
 *
 * @version 2.0.0
 */
class Prodigy_Product extends Prodigy_Main_Content {
    const PRODUCTS_IDS                               = 'ids';
    const PRODUCTS_NAMES                             = 'names';
	const REMOTE_NAME_CATEGORIES                     = 'categories';
	const REMOTE_NAME_TAGS                           = 'tags';
	const REMOTE_NAME_VARIANTS                       = 'variants';
	const REMOTE_NAME_MASTER_VARIANT                 = 'master-variant';
	const REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES         = 'descriptive-attributes';
	const REMOTE_NAME_VARIANT_ATTRIBUTES             = 'variant-attributes';
	const REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES = 'properties';
	const REMOTE_NAME_IMAGES                         = 'images';
	const SUBSCRIPTION_PLANS                         = 'subscription-plans';
	const QUANTITY_PRICE_BREAKS                         = 'quantity-price-breaks';


    const MAX_RANGE_LIMIT = 99999;

	public static $variant_post_type = Prodigy::PRODIGY_VARIATION_POST_TYPE;


	/**
	 * @var $product
	 */
	private $product;

	/**
	 * Include by types
	 *
	 * @var array
	 */
	private $parseInclude = array();

	/** @var object Prodigy_Cache $cache */
	public $cache;

	public $filter_variants;

	/**
	 * Product constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->cache = new Prodigy_Cache();
	}

	/**
	 * @param int    $parent_id
	 * @param string $name
	 *
	 * @return object|null
	 */
	public function get_product_variant_by_name( $parent_id, $name ) {
		global $wpdb;

		$variant = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->posts} WHERE post_parent= %d and post_title=%s and post_type=%s ",
				array( $parent_id, $name, self::$variant_post_type )
			)
		);

		return $variant;
	}


	/**
	 * @param int $id_remote_product
	 *
	 * @return bool
	 */
	public function check_remote_product( int $id_remote_product ): bool {
		$product_url        = prodigy_is_frontend() ? Prodigy_Api_Client::PRODUCTS_URL : Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		$api_url            = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . '/' . $id_remote_product;
		$product_obj_remote = $this->api_client->get_remote_content( $api_url );
		$response_code      = $product_obj_remote['code'] ?? '';

		return $response_code === \WP_Http::OK;
	}


	/**
	 * @param null   $id_remote_product
	 * @param string $includes
	 *
	 * @return mixed
	 */
	public function getProduct(
		$id_remote_product = null,
		string $includes = null
	) {
		if ( $includes === null ) {
			$includes = implode(
                ',',
                array(
					'tags',
					'categories',
					'tax-information',
					'master-variant.dimension',
					'master-variant.inventory',
					'variants.dimension',
					'variants.inventory',
					'cross-sell-products',
					'up-sell-products',
					'descriptive-attributes.options.images',
					'variant-attributes.options.images',
					'images',
					'master-variant.subscription-plan.subscription-conditions',
					'variants.subscription-plan.subscription-conditions',
					'quantity-price-breaks',
                )
            );
		}

		$product     = $this->cache->get_product( (int) $id_remote_product );
		$product_url = prodigy_is_frontend() ? Prodigy_Api_Client::PRODUCTS_URL : Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		if ( ! empty( $product ) ) {
			$object = $product;
		} else {
			$api_url           = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . '/' . $id_remote_product;
			$params['include'] = $includes;
			if ( ! prodigy_is_frontend() ) {
				$params['admin'] = true;
			}

			$request_url        = add_query_arg( $params, $api_url );
			$product_obj_remote = $this->api_client->get_remote_content( $request_url );
			$response_code      = $product_obj_remote['code'] ?? '';

			if ( $response_code === \WP_Http::NOT_FOUND ) {
				if ( PRODIGY_DEBUG_MODE ) {
					do_action( 'logger', $product_obj_remote['response']['message'], 'error' );
				}
				wp_redirect( home_url( '404' ) );
				exit();
			}

			$body            = wp_remote_retrieve_body( $product_obj_remote );
			$obj_data_remote = json_decode( $body, 1 );
			$this->cache->set_product( (int) $id_remote_product, $obj_data_remote ?? array() );
			$object = $obj_data_remote;
		}

		$this->product = $object;

		return $object;
	}

	/**
	 * @param int $remote_product_id
	 *
	 * @return void
	 */
	public function remove_deleted_product( int $remote_product_id ) {
		$posts = get_posts(
            array(
				'numberposts' => - 1,
				'post_type'   => Prodigy::get_prodigy_product_type(),
				'meta_key'    => Prodigy::PRODIGY_REMOTE_PRODUCT_ID,
				'meta_value'  => $remote_product_id,
				'limit'       => 1,
            )
        );

		if ( isset( $posts[0] ) ) {
			$cache  = new Prodigy_Cache();
			wp_delete_post( $posts[0]->ID );
			$cache->reset_product( $posts[0]->ID );
		}
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		if ( isset( $this->product['data'] ) ) {
			return $this->product['data']['attributes']['name'];
		}
	}


    public function getDisplayOptionstype() {
        if ( isset( $this->product['data']['attributes'] ) ) {
            return $this->product['data']['attributes']['display-options-type'];
        }
    }

	/**
	 * @return mixed
	 */
	public function getDescription() {
		if ( isset( $this->product['data'] ) ) {
			return $this->product['data']['attributes']['description'];
		}
	}

	/**
	 * @return array
	 */
	public function getCategories() {
		$categories        = array();
		$filter_categories = $this->parseIncluded( self::REMOTE_NAME_CATEGORIES );

		if ( ! empty( $filter_categories ) && is_array( $filter_categories ) ) {
			foreach ( $filter_categories as $remote_category ) {
				if ( isset( $remote_category['id'] ) ) {
					$local_category = $local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $remote_category['id'] );
					array_push( $categories, $local_category );
				}
			}
		}

		return $categories;
	}

	/**
	 * @return array
	 */
	public function getTags() {
		$tags        = array();
		$filter_tags = $this->parseIncluded( self::REMOTE_NAME_TAGS );

		if ( ! empty( $filter_tags ) && is_array( $filter_tags ) ) {
			foreach ( $filter_tags as $remote_tag ) {
				array_push( $tags, $remote_tag['attributes']['name'] );
			}
		}

		return $tags;
	}

	/**
	 * @return string
	 */
	public function getMainSku() {
		$id_master_variant = '';
		$sku               = '';

		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key == self::REMOTE_NAME_MASTER_VARIANT ) {
					$id_master_variant = $relationship['data']['id'];
				}
			}
		}

		$info_include = $this->parseIncludedById( $id_master_variant, self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $info_include['attributes']['sku'] ) ) {
			$sku = $info_include['attributes']['sku'];
		}

		return $sku;
	}

	/**
	 *
	 * @return array
	 */
	public function getMainPrice(): array {
		$data = array();
		$data['price'] = '';
		if ( ! empty( $this->product['data']['attributes']['price'] ) ) {
			$data['price'] = $this->product['data']['attributes']['price'];
		}

		$data['sale-price'] = '';
		if ( ! empty( $this->product['data']['attributes']['sale-price'] ) ) {
			$data['sale-price'] = $this->product['data']['attributes']['sale-price'];
		}

		if ( ! empty( $this->product['data']['attributes']['price-range']['min_price'] ) ) {
			$data['range']['min_price'] = $this->product['data']['attributes']['price-range']['min_price'];
		}

		if ( ! empty( $this->product['data']['attributes']['price-range']['max_price'] ) ) {
			$data['range']['max_price'] = $this->product['data']['attributes']['price-range']['max_price'];
		}

		return $data;
	}

	/**
	 * @return array|mixed
	 */
	public function getRangeCurrentPrice(): array {
		if ( ! empty( $this->getVariants() ) ) {
			$obj_min = new SplMinHeap();
			$obj_max = new SplMaxHeap();
			foreach ( $this->getVariants() as $variants ) {
				foreach ( $variants as $variant ) {
					$obj_max->insert( $variant['attributes']['attributes']['price'] );
					$obj_min->insert( $variant['attributes']['attributes']['sale-price'] );
				}
			}

			$data['sale-price'] = $obj_min->top() ?? '';
			$data['price']      = $obj_max->top() ?? '';
		} else {
			$data = $this->getMainPrice();
		}

		return $data;
	}


	/**
	 * @return array
	 */
	public function getTieredPriceRange(): array {
		$data = array();
		if ( ! empty( $this->getVariants() ) ) {
			$price = array();
			foreach ( $this->getVariants() as $variants ) {
				foreach ( $variants as $key => $variant ) {
					$price[ $key ] = $variant['attributes']['attributes']['price-quantity-modifier'];
				}
			}
		} else {
			$master = $this->getMasterVariant();
			$price  = $master['attributes']['price-quantity-modifier'];
		}


		$price = empty($price) ? [0] : $price;
		$tiered_prices        = $this->getTiredPrices();
		$data['min_price']    = min( (array) $price ) + $this->getMinTieredPrice( $tiered_prices );
		$data['max_price']    = max( (array) $price ) + $this->getMinTieredPrice( $tiered_prices );
		$data['min_quantity'] = $this->getMinTieredQuantity( $tiered_prices );

		return $data;
	}


    /**
     * @param array $variant
     * @param int   $items_number
     * @return float
     */
    public function calculateTieredPrice( array $variant, int $items_number ): float {
        $tiered_prices_ranges = $this->getTiredPrices();

        $price = 0;
        if ( isset( $variant['attributes'] ) && ! empty( $tiered_prices_ranges ) ) {
            foreach ( $tiered_prices_ranges as $range ) {
                if ( ( $range['attributes']['min-quantity'] <= $items_number ) && ( $items_number <= $range['attributes']['max-quantity'] ) && isset( $range['attributes'], $variant['attributes'] ) ) {
					$price = $range['attributes']['flat-price'] + $variant['attributes']['price-quantity-modifier'];
				}
            }

            if ( $items_number >= $tiered_prices_ranges[ count( $tiered_prices_ranges ) - 1 ]['attributes']['max-quantity'] ) {
                $price = $tiered_prices_ranges[ count( $tiered_prices_ranges ) - 1 ]['attributes']['flat-price'] + $variant['attributes']['price-quantity-modifier'];
            } elseif ( isset( $tiered_prices_ranges[0]['attributes'] ) && $items_number <= $tiered_prices_ranges[0]['attributes']['min-quantity'] ) {
                $price = $tiered_prices_ranges[0]['attributes']['flat-price'] + $variant['attributes']['price-quantity-modifier'];
            }
        }

        return $price;
    }

	/**
	 * @param $tiered_prices
	 *
	 * @return float
	 */
	public function getMinTieredQuantity( $tiered_prices ): float {
		return $tiered_prices[0]['attributes']['min-quantity'] ?? 0;
	}

	/**
	 * @param $tiered_prices
	 *
	 * @return float
	 */
	public function getMinTieredPrice( $tiered_prices ): float {
		return $tiered_prices[0]['attributes']['flat-price'] ?? 0;
	}

	/**
	 * @return false|int
	 */
	public function getIdMasterVariant() {
		$id_master_variant = false;
		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key == self::REMOTE_NAME_MASTER_VARIANT ) {
					$id_master_variant = $relationship['data']['id'];
				}
			}
		}

		return $id_master_variant;
	}


	/**
	 * @return array
	 */
	public function getMasterVariant() {
		$id_master_variant = '';
		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key == self::REMOTE_NAME_MASTER_VARIANT ) {
					$id_master_variant = $relationship['data']['id'];
				}
			}
		}

		return $this->parseIncludedById( $id_master_variant, self::REMOTE_NAME_VARIANTS );
	}

	/**
	 * @return array
	 */
	public function getPreparedVariants() {
		$variants = array();
		$this->filter_variants = $this->parseIncluded( self::REMOTE_NAME_VARIANTS );
        $options = $this->getAttributesOptions();

		if ( ! empty( $this->filter_variants ) && is_array( $this->filter_variants ) ) {
			foreach ( $this->filter_variants as $key => $remote_variant ) {
				if ( ! $remote_variant['attributes']['master'] ) {
					foreach ( $remote_variant['attributes']['options'] as $item ) {
						$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_name( $item['name'] );
						$term = get_term_by( 'name', $item['value'], $taxonomy->slug ?? '' );
						if ( isset( $taxonomy->slug, $term->slug ) ) {
							$variants[ $key ][ $taxonomy->slug ][ $term->slug ]['name'] = $item['value'];
							$variants[ $key ][ $taxonomy->slug ][ $term->slug ]['slug'] = $term->slug;
							if ( isset( $options[ $taxonomy->slug ][ $term->slug ]['color'] ) ) {
								$variants[ $key ][ $taxonomy->slug ][ $term->slug ]['color'] = $options[ $taxonomy->slug ][ $term->slug ]['color'];
							}
							if ( isset( $options[ $taxonomy->slug ][ $term->slug ]['image'] ) ) {
								$variants[ $key ][ $taxonomy->slug ][ $term->slug ]['image'] = $options[ $taxonomy->slug ][ $term->slug ]['image'];
							}
							if ( isset( $options[ $taxonomy->slug ][ $term->slug ]['default'] ) ) {
								$variants[ $key ][ $taxonomy->slug ][ $term->slug ]['default'] = $options[ $taxonomy->slug ][ $term->slug ]['default'];
							}
						}
					}
				}
			}
		}

		foreach ( $variants as $key => $variant ) {
			foreach ( $variant as $k => $item ) {
				$variants[ $key ][ $k ][ key( $item ) ]['sort'] = $options[ $k ][ key( $item ) ]['sort'];
			}
		}


		return $variants;
	}

	/**
	 * @return array
	 */
	public function getVariants() {
		$variants = array();
		$this->filter_variants = $this->parseIncluded( self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $this->filter_variants ) && is_array( $this->filter_variants ) ) {
			foreach ( $this->filter_variants as $remote_variant ) {
				if ( is_array( $remote_variant['attributes']['options'] ) && ! $remote_variant['attributes']['master'] ) {
					foreach ( $remote_variant['attributes']['options'] as $option ) {

						if ( ! isset( $variants[ $option['name'] ] ) ) {
							$variants[ $option['name'] ] = array();
						}

						if ( ! in_array( $option['value'], $variants[ $option['name'] ] ) ) {
							$variants[ $option['name'] ][ $option['value'] ]['name']       = $option['value'];
							$variants[ $option['name'] ][ $option['value'] ]['attributes'] = $remote_variant;
						}
					}
				}
			}
		}

		return $variants;
	}

	/**
	 * @param array $params
	 *
	 * @return false | int
	 * @example ['Gray', '32']
	 */
	public function getVariantIdByParams( array $params ) {

		$params = array_map(
			function ( $value ) {
				return strtolower( $value );
			},
			$params
		);

		$id_filter_variant = false;
		$filter_variants = $this->parseIncluded( self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $filter_variants ) ) {
			foreach ( $filter_variants as $filter_variant ) {
				$id_filter_variant = false;
				if ( ! empty( $filter_variant['attributes']['options'] ) ) {
					foreach ( $filter_variant['attributes']['options'] as $option ) {
						$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_name( $option['name'] );
						$term     = get_term_by( 'name', $option['value'], $taxonomy->slug ?? '' );
						if ( isset( $term ) && in_array( $term->slug, $params, true ) ) {
							$id_filter_variant = $filter_variant['id'];
						} else {
							$id_filter_variant = false;
							break;
						}
					}

					if ( ! empty( $id_filter_variant ) ) {
						return $id_filter_variant;
					}
				}
			}
		}

		return $id_filter_variant;
	}

    /**
     * @param $params
     * @param $id_variant
     * @return array|false
     */
	public function getVariantInfo( $params = array(), $id_variant = false ): array {
		$data = array();
		if ( empty( $id_variant ) ) {
			if ( empty( $params ) ) {
				return array();
			}
			$id_variant = $this->getVariantIdByParams( $params );
		}

		if ( ! empty( $id_variant ) ) {
			$obj_variant = $this->parseIncludedById( $id_variant, self::REMOTE_NAME_VARIANTS );
		}

		if ( isset( $obj_variant['attributes'] ) ) {
			$data['attributes'] = $obj_variant['attributes'];
		}

		if ( isset( $obj_variant['relationships'] ) ) {
			foreach ( $obj_variant['relationships'] as $key => $relationship ) {
				if ( isset( $relationship['data']['id'], $relationship['data']['type'] ) ) {
					$data[ $key ] = $this->parseIncludedById( $relationship['data']['id'], $relationship['data']['type'] );
				}
			}
		}

		$data['remote_variant_id'] = $id_variant;

		return $data;
	}

	/**
	 * @return array
	 */
	public function getImages() {
		$filter_variants = $this->parseIncluded( self::REMOTE_NAME_VARIANTS );

		$data = array();

		if ( ! empty( $filter_variants ) ) {
			foreach ( $filter_variants as $filter_variant ) {
				if ( isset( $filter_variant['attributes']['image-url'] ) ) {
					$data[ $filter_variant['id'] ] = $filter_variant['attributes']['image-url'];
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function getImagesInclude() {
		$ids = array();

		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] as $key => $image ) {
				$ids[ $this->product['data']['id'] ][ $key ] = $image['id'];
			}
		}

		if ( isset( $this->product['included'] ) ) {
			foreach ( $this->product['included'] as $item ) {
				if ( $item['type'] === 'options' ) {
					if ( ! empty( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] ) ) {
						foreach ( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] as $key => $image_item ) {
							$ids[ $item['id'] ][ $key ] = $image_item['id'];
						}
					}
				}
			}
		}

		return $this->parse_included_obj_by_ids( $this->product, $this->formatImageArray( $ids ), self::REMOTE_NAME_IMAGES );
	}

	/**
	 * @param $option
	 *
	 * @return array
	 */
	public function getImageByOption( $option ) {
		$ids = array();
		if ( isset( $this->product['included'] ) ) {
			foreach ( $this->product['included'] as $item ) {
				if (
					$item['type'] === 'options' &&
					$item['attributes']['value'] === $option &&
					! empty( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] )
				) {
					foreach ( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] as $key => $image_item ) {
						$ids[ $item['id'] ][ $key ] = $image_item['id'];
					}
				}
			}
		}

		return $this->parse_included_obj_by_ids( $this->product, $this->formatImageArray( $ids ), self::REMOTE_NAME_IMAGES );
	}


	/**
	 * @param array $ids
	 *
	 * @return array
	 */
	private function formatImageArray( array $ids ) {
		$mapped_ids = array();
		foreach ( $ids as $id ) {
			if ( ! empty( $id ) ) {
				foreach ( $id as $item ) {
					if ( ! empty( $item ) ) {
						$mapped_ids[ $item ] = $item;
					}
				}
			}
		}

		return $mapped_ids;
	}


	/**
	 * @return false
	 */
	public function getStatusRange() {
		$status = false;
		if ( isset( $this->product['data']['attributes'] ) ) {
			$status = $this->product['data']['attributes']['display-price-range'];
		}

		return $status;
	}

	/**
	 * @return array
	 */
	public function getAllImagesRelation() {
		$properties = $this->getImagesInclude();
		$data       = array();
		foreach ( $properties as $property ) {
			$data[] = $property['attributes'];
		}

		return $data;
	}

	/**
	 * @param string $option_name
	 *
	 * @return false
	 */
	public function hasAttributeImages( string $option_name ) {
		$result = false;
		if ( isset( $this->product['included'] ) ) {
			$remote_included = $this->product['included'];

			foreach ( $remote_included as $item ) {
				if ( $item['type'] === 'properties' && $item['attributes']['name'] === $option_name ) {
					$result = $item['attributes']['has-property-images'];
				}
			}
		}

		return $result;
	}

	/**
	 * @param $type
	 *
	 * @return array
	 */
	protected function parseIncluded( $type ) {
		$remote_included = null;
		if ( isset( $this->product['included'] ) ) {
			$remote_included = $this->product['included'];
		}

		if ( isset( $this->parseInclude[ $type ] ) && ! empty( $this->parseInclude[ $type ] ) ) {
			return $this->parseInclude[ $type ];
		}

		if ( ! empty( $remote_included ) ) {
			$data = array();
			foreach ( $remote_included as $remote_include ) {
				if ( $remote_include['type'] == $type ) {
					$data[] = $remote_include;
				}
			}
		}

		$this->parseInclude[ $type ] = $data ?? array();

		return $data ?? array();
	}

	/**
	 * @param $id
	 *
	 * @param $type
	 *
	 * @return array
	 */
	protected function parseIncludedById( $id, $type = false ) {
		$remote_included = $this->product['included'] ?? null;
		$data            = array();
		if ( ! empty( $remote_included ) ) {
			foreach ( $remote_included as $remote_include ) {
				if ( ! empty( $type ) ) {
					if ( $remote_include['id'] == $id && $remote_include['type'] == $type ) {
						$data = $remote_include;
					}
				} elseif ( $remote_include['id'] == $id ) {
						$data = $remote_include;
				}
			}
		}

		return $data;
	}



	/**
	 * @return array
	 */
	public function getUpSellProducts() {
		return $this->get_up_sell_products_main( $this->product ?? array() );
	}

	/**
	 * @return array
	 */
	public function getCrossSellProducts() {
		return $this->get_cross_sell_products_main( $this->product ?? array() );
	}

	/**
	 * @return array
	 */
	public function getDescriptiveProperties() {
		$id_relationships = array();

		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][ self::REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES ];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parse_included_obj_by_ids( $this->product, $id_relationships, self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
	}

	/**
	 * @return array
	 */
	public function getAttributeProperties() {

		$id_relationships = array();
		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][ self::REMOTE_NAME_VARIANT_ATTRIBUTES ];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parse_included_obj_by_ids( $this->product, $id_relationships, self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
	}

	/**
	 * @return array
	 */
	public function getDescriptiveOption() {
		$properties = $this->getDescriptiveProperties();

		$data = array();
		foreach ( $properties as $property ) {
			$options = wp_list_pluck( $property['relationships']['options']['data'], 'id' );
			if ( is_array( $options ) ) {
				foreach ( $options as $option ) {
					$option_obj                                = $this->parse_included_obj_by_id( $this->product, $option, 'options' );
					$data[ $property['attributes']['name'] ][] = $option_obj['attributes']['value'];
				}
			}
		}

		return $data;
	}

    /**
     * @return bool
     */
    public function isTieredPrice(): bool {
		$is_tiered_price = false;
        if ( isset( $this->product['data']['attributes'], $this->product['data']['attributes']['tiered-price'] ) ) {
	        $is_tiered_price = $this->product['data']['attributes']['tiered-price'];
        }

		return $is_tiered_price;
    }

    /**
     * @return array
     */
    public function getTiredPrices(): array {
        $result = array();
        if ( $this->isTieredPrice() ) {
            $data_parse = $this->product['data']['relationships'][ self::QUANTITY_PRICE_BREAKS ];
            $relationships_ids = wp_list_pluck( $data_parse['data'], 'id', 'id' );
            $result = $this->parse_included_obj_by_ids( $this->product, $relationships_ids, self::QUANTITY_PRICE_BREAKS );
        }

        return $this->calculateTierDiscount( $result );
    }

    /**
     * @param array $prices
     * @return array
     */
    private function calculateTierDiscount( array $prices ): array {
        foreach ( $prices as $key => $price ) {
            $firstTierPrice = $prices[0]['attributes']['flat-price'];

            if ( ! ( $firstTierPrice && $price['attributes']['flat-price'] ) ) {
                $prices[ $key ]['attributes']['discount'] = '-';
            }

            $discount = $firstTierPrice - $price['attributes']['flat-price'];
            if ( $discount < 0 ) {
                $prices[ $key ]['attributes']['discount'] = '-';

            }

            if ( $key === 0 ) {
                $prices[0]['attributes']['discount'] = '-';
            } else {
                $prices[ $key ]['attributes']['discount'] = round( ( $discount / $firstTierPrice ) * 100, 2 ) . '% ' . ( '($' . round( $discount, 2 ) . ' per unit' . ')' );
            }
        }

        return $prices;
    }

    /**
     * @return array
     */
	public function getAttributesOptions() {
		$properties = $this->getAttributeProperties();

		$data = array();
		foreach ( $properties as $property ) {
			$taxonomy = Prodigy_Product_Attributes::get_attribute_taxonomies_by_name( $property['attributes']['name'] );
			$options = wp_list_pluck( $property['relationships']['options']['data'], 'id' );
			if ( is_array( $options ) ) {
				foreach ( $options as $key => $option ) {
					$option_obj = $this->parse_included_obj_by_id( $this->product, $option, 'options' );
					$term = get_term_by( 'name', $option_obj['attributes']['value'], $taxonomy->slug ?? '' );
					if ( isset( $taxonomy, $term ) ) {
						$data[ $taxonomy->slug ][ $term->slug ]['name'] = $option_obj['attributes']['value'];
						if ( $property['attributes']['with-visual-swatch'] && $option_obj['attributes']['image-url'] ) {
							$data[ $taxonomy->slug ][ $term->slug ]['image'] = $option_obj['attributes']['image-url'];
						} elseif ( $property['attributes']['with-visual-swatch'] && $option_obj['attributes']['color'] ) {
							$data[ $taxonomy->slug ][ $term->slug ]['color'] = $option_obj['attributes']['color'];
						}
						$data[ $taxonomy->slug ][ $term->slug ]['default'] = $option_obj['attributes']['default'];
						$data[ $taxonomy->slug ][ $term->slug ]['sort']    = $key;
					}
				}
			}
		}

		return $data;
	}

    /**
     * @param $product_id
     * @return array
     */
	public function getSubscriptions( $product_id = '' ) {
		$conditions_data   = array();
		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( ! empty( $product_id ) && $key == self::REMOTE_NAME_VARIANTS ) {
					foreach ( $relationship['data'] as $key => $variant ) {
						if ( $product_id == $variant['id'] ) {
							$product_id = $variant['id'];
						}
						break;
					}
				} elseif ( empty( $product_id ) && $key == self::REMOTE_NAME_MASTER_VARIANT ) {
					$product_id = $relationship['data']['id'];
					break;
				}
			}
			if ( ! empty( $product_id ) ) {
				$info_include = $this->parseIncludedById( $product_id, self::REMOTE_NAME_VARIANTS );
				$plans        = $info_include['relationships']['subscription-plan'] ?? array();

				if ( isset( $plans['data']['id'] ) ) {
					$include_conditions                   = $this->parseIncludedById( $plans['data']['id'], self::SUBSCRIPTION_PLANS );
					$conditions                           = $include_conditions['relationships']['subscription-conditions']['data'] ?? array();
					$conditions_data['subscription-only'] = $include_conditions['attributes']['subscription-only'];

					foreach ( $conditions as $key => $item ) {
						if ( $item['type'] === 'subscription-conditions' ) {
							$conditions_data[ $key ] = $this->parseIncludedById( $item['id'] );
						}
					}
				}
			}
		}

		return $conditions_data;
	}


    /**
     * @param string $key
     * @param int    $value
     *
     * @return array|object|void|null
     */
    public static function get_product_meta_by_remote_id( string $key, int $value ) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = %s and meta_value= %d ",
                array( $key, $value )
            )
        );
    }

    /**
     * @param string $type
     * @return array
     */
    public function get_products( string $type ): array {
        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->posts} as posts 
                    LEFT JOIN {$wpdb->postmeta} as pm ON posts.id=pm.post_id
                    WHERE pm.meta_key='prodigy_remote_product_id' and posts.post_type=%s
                  ",
                Prodigy::get_prodigy_product_type()
            ),
            ARRAY_A
        );

        $products = array();
        if ( $type === self::PRODUCTS_IDS ) {
            foreach ( $result as $item ) {
                $products[ $item['meta_value'] ] = $item['meta_value'];
            }
        }

        if ( $type === self::PRODUCTS_NAMES ) {
            foreach ( $result as $item ) {
                $products[ $item['post_title'] ] = $item['post_title'];
            }
        }

        return $products;
    }

    /**
     * @param string $taxonomy
     * @param string $meta_key
     * @return array
     */
    public function get_taxonomies( string $taxonomy, string $meta_key, string $type = 'id' ): array {
        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->term_taxonomy} as tt 
                    LEFT JOIN {$wpdb->termmeta} as tm ON tt.term_id=tm.term_id
                    LEFT JOIN {$wpdb->terms} as t ON t.term_id=tt.term_id
                    WHERE tt.taxonomy=%s and tm.meta_key=%s",
                $taxonomy,
                $meta_key
            ),
            ARRAY_A
        );

        $categories = array();

        if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type == 'id' ) {
            foreach ( $result as $item ) {
                $categories[ $item['meta_value'] ] = $item['meta_value'];
            }
        }

        if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type == 'name' ) {
            foreach ( $result as $item ) {
                $categories[ $item['meta_value'] ] = $item['name'];
            }
        }

        if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type == 'slug' ) {
            foreach ( $result as $item ) {
                $categories[ $item['meta_value'] ] = $item['slug'];
            }
        }

        if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type == 'parent' ) {
            foreach ( $result as $item ) {
                $categories[ $item['parent'] ] = $item['parent'];
            }
        }

        if ( $taxonomy === Prodigy::get_prodigy_tag_type() ) {
            foreach ( $result as $item ) {
                $categories[ $item['name'] ] = $item['name'];
            }
        }

        return $categories;
    }

	/**
	 * @return int|null
	 */
	public static function get_random_product() {
		$api_client        = new Prodigy_Api_Client();
		$product_url       = Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		$url               = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url;
		$products_response = $api_client->get_remote_content( $url );
		$body              = wp_remote_retrieve_body( $products_response );
		$object            = json_decode( $body, true );

		$local_parent_product_id = null;
		if ( isset( $object['data'][0]['id'] ) ) {
			$local_parent_product_info = Prodigy_Product_Attributes::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, (int) $object['data'][0]['id'] );
			$local_parent_product_id   = $local_parent_product_info->post_id;
		}

		return $local_parent_product_id;
	}

    /**
     * @param int $limit
     * @return array|null
     */
    public static function get_random_products( int $limit = 5 ): ?array {
        $params = array(
            'post_type'      => Prodigy::get_prodigy_product_type(),
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
        );

        $query = new \WP_Query( $params );
        if ( $query->have_posts() ) {
            return $query->posts;
        }

        return null;
    }
}
