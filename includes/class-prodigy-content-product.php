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
class Prodigy_Content_Product extends Prodigy_Main_Content {

	const REMOTE_NAME_CATEGORIES                     = 'categories';
	const REMOTE_NAME_TAGS                           = 'tags';
	const REMOTE_NAME_VARIANTS                       = 'variants';
	const REMOTE_NAME_MASTER_VARIANT                 = 'master-variant';
	const REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES         = 'descriptive-attributes';
	const REMOTE_NAME_VARIANT_ATTRIBUTES             = 'variant-attributes';
	const REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES = 'properties';
	const REMOTE_NAME_IMAGES                         = 'images';
	const SUBSCRIPTION_PLANS                         = 'subscription-plans';

	public static $variant_post_type = Prodigy::PRODIGY_VARIATION_POST_TYPE;


	/**
	 * @var $product
	 */
	private $product;

	/**
	 *
	 * @var $prepare_remote_variants
	 */
	private $prepare_remote_variants;

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
	 * Prodigy_Content_Product constructor.
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
	 * @param null   $id_remote_product
	 * @param string $includes
	 *
	 * @return mixed
	 */
	public function getProduct(
		$id_remote_product = null,
		$includes = 'tags,categories,tax-information,master-variant.dimension,master-variant.inventory,variants.dimension,variants.inventory,cross-sell-products,up-sell-products,descriptive-attributes.options.images,variant-attributes.options.images,images,master-variant.subscription-plan.subscription-conditions,variants.subscription-plan.subscription-conditions'
	) {
		$product = $this->cache->get_product( (int) $id_remote_product );
		if ( ! empty( $product ) ) {
			$object = $product;
		} else {
			$api_url            = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::PRODUCTS_URL . '/' . $id_remote_product . '?include=' . $includes;
			$product_obj_remote = $this->api_client->get_remote_content( $api_url );
			$response_code = $product_obj_remote['code'] ?? '';
			if ( $response_code === 404 && isset($id_remote_product) ) {
				$this->remove_deleted_product($id_remote_product);
				return;
			}

			$body               = wp_remote_retrieve_body( $product_obj_remote );
			$obj_data_remote    = json_decode( $body, 1 );
			$this->cache->set_product( $id_remote_product, $obj_data_remote );
			$object = $obj_data_remote;
		}

		$this->product = $object;

		return $this->product;
	}

	/**
	 * @param int $remote_product_id
	 *
	 * @return void
	 */
	public function remove_deleted_product( int $remote_product_id ) {
		$posts = get_posts( array(
			'numberposts' => - 1,
			'post_type'   => Prodigy::get_prodigy_product_type(),
			'meta_key'    => Prodigy::PRODIGY_REMOTE_PRODUCT_ID,
			'meta_value'  => $remote_product_id,
			'limit'       => 1,
		) );

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
				if ( isset( $remote_category->id ) ) {
					$local_category = $local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $remote_category->id );
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
	 * @return mixed
	 */
	public function getMainPrice() {

		$data              = array();
		$id_master_variant = $this->getIdMasterVariant();
		$info_include      = $this->parseIncludedById( $id_master_variant, self::REMOTE_NAME_VARIANTS );

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
	public function getRangeCurrentPrice() {

		if ( ! empty( $this->getVariants() ) ) {
			$obj_min = new SplMinHeap();
			$obj_max = new SplMaxHeap();
			foreach ( $this->getVariants() as $name => $variants ) {
				foreach ( $variants as $key_id => $variant ) {
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
	public function getPreparedVariants() {
		$variants = array();

		$this->filter_variants = $this->parseIncluded( self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $this->filter_variants ) && is_array( $this->filter_variants ) ) {
			foreach ( $this->filter_variants as $key => $remote_variant ) {
				if ( ! $remote_variant['attributes']['master'] ) {
					foreach ( $remote_variant['attributes']['options'] as $key_options => $item ) {
						$variants[ $key ][ $item['name'] ] = $item['value'];
					}
				}
			}
		}

		return $variants;
	}

	/**
	 * @return array
	 */
	public function getVariants() {

		if ( ! empty( $this->prepare_remote_variants ) ) {
			return $this->prepare_remote_variants;
		}

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

		$this->prepare_remote_variants = $variants;

		return $variants;
	}

	/**
	 * @param $params
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
						if ( in_array( strtolower( $option['value'] ), $params ) ) {
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
	 * @param array $params
	 *
	 * @param bool  $id_variant
	 *
	 * @return false|object
	 */
	public function getVariantInfo( $params = array(), $id_variant = false ) {
		$data = [];
		if ( empty( $id_variant ) ) {

			if ( empty( $params ) ) {
				return false;
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
				if ( isset( $relationship['data'], $relationship['data']['id'], $relationship['data']['type'] ) ) {
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
			foreach ( $this->product['data']['relationships'][self::REMOTE_NAME_IMAGES]['data'] as $key => $image ) {
				$ids[ $this->product['data']['id'] ][ $key ] = $image['id'];
			}
		}

		if ( isset( $this->product['included'] ) ) {
			foreach ( $this->product['included'] as $item ) {
				if ( $item['type'] === 'options' ) {
					if ( ! empty( $item['relationships'][self::REMOTE_NAME_IMAGES]['data'] ) ) {
						foreach ( $item['relationships'][self::REMOTE_NAME_IMAGES]['data'] as $key => $image_item ) {
							$ids[ $item['id'] ][ $key ] = $image_item['id'];
						}
					}
				}
			}
		}

		return $this->parseIncludedObjByIds( $this->product, $this->formatImageArray( $ids ), self::REMOTE_NAME_IMAGES );
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
				if ( $item['type'] === 'options' && $item['attributes']['value'] == $option ) {
					if ( ! empty( $item['relationships'][self::REMOTE_NAME_IMAGES]['data'] ) ) {
						foreach ( $item['relationships'][self::REMOTE_NAME_IMAGES]['data'] as $key => $image_item ) {
							$ids[ $item['id'] ][ $key ] = $image_item['id'];
						}
					}
				}
			}
		}

		return $this->parseIncludedObjByIds( $this->product, $this->formatImageArray( $ids ), self::REMOTE_NAME_IMAGES );
	}


	/**
	 * @param array $ids
	 *
	 * @return array
	 */
	private function formatImageArray( array $ids ) {
		$mapped_ids = array();
		foreach ( $ids as $key => $id ) {
			if ( ! empty( $id ) ) {
				foreach ( $id as $key => $item ) {
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
		$remote_included = null;
		if ( isset( $this->product['included'] ) ) {
			$remote_included = $this->product['included'];

			$result = false;
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

		$this->parseInclude[ $type ] = $data ?? [];

		return $data ?? [];
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
				} else {
					if ( $remote_include['id'] == $id ) {
						$data = $remote_include;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function getUpSellProducts() {
		return $this->getUpSellProductsMain( $this->product );
	}

	/**
	 * @return array
	 */
	public function getCrossSellProducts() {
		return $this->getCrossSellProductsMain( $this->product );
	}

	/**
	 * @return array
	 */
	public function getDescriptiveProperties() {
		$id_relationships = array();

		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][self::REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parseIncludedObjByIds( $this->product, $id_relationships, self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
	}

	/**
	 * @return array
	 */
	public function getAttributeProperties() {

		$id_relationships = array();
		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][self::REMOTE_NAME_VARIANT_ATTRIBUTES];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parseIncludedObjByIds( $this->product, $id_relationships, self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
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
					$option_obj                            = $this->parseIncludedObjById( $this->product, $option, 'options' );
					$data[ $property['attributes']['name'] ][] = $option_obj['attributes']['value'];
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function getAttributesOption() {
		$properties = $this->getAttributeProperties();

		$data = array();
		foreach ( $properties as $property ) {

			$options = wp_list_pluck( $property['relationships']['options']['data'], 'id' );

			if ( is_array( $options ) ) {
				foreach ( $options as $option ) {
					$option_obj                            = $this->parseIncludedObjById( $this->product, $option, 'options' );
					$data[ $property['attributes']['name'] ][] = $option_obj['attributes']['value'];
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function getSubscriptions( $product_id = '' ) {
		$conditions_data   = array();
		$id_master_variant = 0;
		if ( isset( $this->product['data']['relationships'] ) ) {
			$variants_id = 0;
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

}
