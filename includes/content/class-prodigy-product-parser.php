<?php

namespace Prodigy\Includes\Content;

use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use SplMaxHeap;
use SplMinHeap;

defined( 'ABSPATH' ) || exit;

/**
 * Class RemoteProduct
 *
 * @version 2.0.0
 */
class Prodigy_Product_Parser extends Prodigy_Main_Content {
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
	const QUANTITY_PRICE_BREAKS                      = 'quantity-price-breaks';

	/**
	 * Product personalization type
	 */
	const PERSONALIZATION_TYPE_FLAT = 'flat';

	/**
	 * Product personalization type
	 */
	const PERSONALIZATION_TYPE_PERCENT = 'percentage';

	public static $personalization_type_mapper = array(
		self::PERSONALIZATION_TYPE_FLAT    => '$',
		self::PERSONALIZATION_TYPE_PERCENT => '%',
	);

	/**
	 * Response relation logo-options type of data
	 */
	const LOGO_OPTIONS = 'logo-options';

	/**
	 * Response relation logo type of data
	 */
	const LOGO = 'logos';

	/**
	 * Response relation logo-locations type of data
	 */
	const LOGO_LOCATIONS = 'logo-locations';

	/**
	 * Response relation option type of data
	 */
	const OPTIONS = 'options';

	/**
	 * Response relation option type of data
	 */
	const PERSONALIZATIONS = 'personalizations';

	/**
	 * Response relation option type of data
	 */
	const PERSONALIZATION_FIELDS = 'personalization-fields';


	const MAX_RANGE_LIMIT = 99999;

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

	public $filter_variants;

	/**
	 * @param array $product
	 */
	public function __construct( array $product ) {
		parent::__construct();
		$this->product = $product;
	}

	/**
	 * @return string
	 */
	public function get_title(): string {
		$title = '';
		if ( isset( $this->product['data'] ) ) {
			$title = $this->product['data']['attributes']['name'];
		}

		return $title;
	}


	/**
	 * @return string
	 */
	public function get_display_options_type(): string {
		$type = '';
		if ( isset( $this->product['data']['attributes'] ) ) {
			$type = $this->product['data']['attributes']['display-options-type'];
		}

		return $type;
	}

	/**
	 * @return string
	 */
	public function get_description(): string {
		$description = '';
		if ( isset( $this->product['data'] ) ) {
			$description = $this->product['data']['attributes']['description'];
		}

		return $description;
	}

	/**
	 * @return array
	 */
	public function get_categories(): array {
		$categories        = array();
		$filter_categories = $this->parse_included( self::REMOTE_NAME_CATEGORIES );

		if ( ! empty( $filter_categories ) ) {
			foreach ( $filter_categories as $remote_category ) {
				if ( isset( $remote_category['id'] ) ) {
					$local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $remote_category['id'] );
					$categories[]   = $local_category;
				}
			}
		}

		return $categories;
	}

	/**
	 * @return array
	 */
	public function get_tags(): array {
		$tags        = array();
		$filter_tags = $this->parse_included( self::REMOTE_NAME_TAGS );

		if ( ! empty( $filter_tags ) ) {
			foreach ( $filter_tags as $remote_tag ) {
				$tags[] = $remote_tag['attributes']['name'];
			}
		}

		return $tags;
	}

	/**
	 * @return string
	 */
	public function get_main_sku(): string {
		$id_master_variant = '';
		$sku               = '';

		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key === self::REMOTE_NAME_MASTER_VARIANT ) {
					$id_master_variant = $relationship['data']['id'];
				}
			}
		}

		$info_include = $this->parse_included_by_id( (int) $id_master_variant, self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $info_include['attributes']['sku'] ) ) {
			$sku = $info_include['attributes']['sku'];
		}

		return $sku;
	}

	/**
	 * Get the charge amount
	 *
	 * @return string
	 */
	public function get_charge_amount(): string {
		return $this->product['data']['attributes']['setup-charge-amount'] ?? '';
	}

	/**
	 *
	 * @return array
	 */
	public function get_main_price(): array {
		$data          = array();
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
	public function get_range_current_price(): array {
		if ( ! empty( $this->get_variants() ) ) {
			$obj_min = new SplMinHeap();
			$obj_max = new SplMaxHeap();
			foreach ( $this->get_variants() as $variants ) {
				foreach ( $variants as $variant ) {
					$obj_max->insert( $variant['attributes']['attributes']['price'] );
					$obj_min->insert( $variant['attributes']['attributes']['sale-price'] );
				}
			}

			$data['sale-price'] = $obj_min->top() ?? '';
			$data['price']      = $obj_max->top() ?? '';
		} else {
			$data = $this->get_main_price();
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function get_personalizations_fields(): array {
		$personalization_fields      = array();
		$personalization_ids         = array();
		$relation_of_personalization = $this->parse_included( self::PERSONALIZATIONS );

		if ( isset( $relation_of_personalization[0] ) ) {
			foreach ( $relation_of_personalization[0]['relationships']['personalization-fields']['data'] as $key => $relationship ) {
				if ( $relationship['type'] === self::PERSONALIZATION_FIELDS ) {
					$personalization_ids[ $key ] = $relationship['id'];
				}
			}
		}

		foreach ( $personalization_ids as $id ) {
			$personalization_fields['personalization_id'] = $relation_of_personalization[0]['id'];
			$personalization_fields[ $id ]                = $this->parse_included_by_id( (int) $id, self::PERSONALIZATION_FIELDS );
			$personalization_fields['title']              = $relation_of_personalization[0]['attributes']['title'];
			$personalization_fields['modifier-type']      = $relation_of_personalization[0]['attributes']['price-modifier-type'];
			$personalization_fields['modifier-value']     = $relation_of_personalization[0]['attributes']['price-modifier-value'];
		}

		return $personalization_fields;
	}


	/**
	 * @return array
	 */
	public function get_tiered_price_range(): array {
		$data = array();
		if ( ! empty( $this->get_variants() ) ) {
			$price = array();
			foreach ( $this->get_variants() as $variants ) {
				foreach ( $variants as $key => $variant ) {
					$price[ $key ] = $variant['attributes']['attributes']['price-quantity-modifier'];
				}
			}
		} else {
			$master = $this->get_master_variant();
			$price  = $master['attributes']['price-quantity-modifier'] ?? array();
		}

		$price                = empty( $price ) ? array( 0 ) : $price;
		$tiered_prices        = $this->get_tired_prices();
		$data['min_price']    = min( (array) $price ) + $this->get_min_tiered_price( $tiered_prices );
		$data['max_price']    = max( (array) $price ) + $this->get_min_tiered_price( $tiered_prices );
		$data['min_quantity'] = $this->get_min_tiered_quantity( $tiered_prices );

		return $data;
	}


	/**
	 * @param array $variant
	 * @param int   $items_number
	 * @return float
	 */
	public function calculate_tiered_price( array $variant, int $items_number ): float {
		$tiered_prices_ranges = $this->get_tired_prices();

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
	 * @param array $tiered_prices
	 *
	 * @return float
	 */
	public function get_min_tiered_quantity( array $tiered_prices ): float {
		return $tiered_prices[0]['attributes']['min-quantity'] ?? 0;
	}

	/**
	 * @param array $tiered_prices
	 *
	 * @return float
	 */
	public function get_min_tiered_price( array $tiered_prices ): float {
		return $tiered_prices[0]['attributes']['flat-price'] ?? 0;
	}

	/**
	 * @return false|int
	 */
	public function get_id_master_variant() {
		$id_master_variant = false;
		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key === self::REMOTE_NAME_MASTER_VARIANT ) {
					$id_master_variant = $relationship['data']['id'];
				}
			}
		}

		return $id_master_variant;
	}

	/**
	 * @return array
	 */
	public function get_master_variant_logos(): array {
		return $this->get_logos_by_option();
	}


	/**
	 * @return array
	 */
	public function get_master_variant(): array {
		return $this->parse_included_by_id( (int) $this->get_id_master_variant(), self::REMOTE_NAME_VARIANTS );
	}

	/**
	 * @return array
	 */
	public function get_prepared_variants(): array {
		$variants = array();

		$this->filter_variants = $this->parse_included( self::REMOTE_NAME_VARIANTS );

		if ( isset( $this->product['data']['attributes']['default-logo-option-id'] ) ) {
			$default_logo_options_info = $this->parse_logos_options_by_type_and_relation_id( $this->product, $this->product['data']['attributes']['default-logo-option-id'], self::LOGO_OPTIONS );
			$default_logo_option_id    = $default_logo_options_info[ $this->product['data']['attributes']['default-logo-option-id'] ]['option_id'];
			$default_logo_option       = $this->parse_included_by_id( (int) $default_logo_option_id, self::OPTIONS );
		}

		$options = $this->get_attributes_options();

		if ( ! empty( $this->filter_variants ) && is_array( $this->filter_variants ) ) {
			foreach ( $this->filter_variants as $key => $remote_variant ) {
				if ( ! $remote_variant['attributes']['master'] ) {
					foreach ( $remote_variant['attributes']['options'] as $item ) {
						if ( isset( $item['option_slug'] ) ) {
							$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['attribute'] = $item['property_slug'];
							$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['name']      = $item['value'];
							$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['slug']      = $item['option_slug'];
							$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['option_id'] = $options[ $item['property_slug'] ][ $item['option_slug'] ]['option_id'] ?? 0;

							if ( isset( $options[ $item['property_slug'] ][ $item['option_slug'] ]['color'] ) ) {
								$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['color'] = $options[ $item['property_slug'] ][ $item['option_slug'] ]['color'];
							}
							if ( isset( $options[ $item['property_slug'] ][ $item['option_slug'] ]['image'] ) ) {
								$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['image'] = $options[ $item['property_slug'] ][ $item['option_slug'] ]['image'];
							}

							if ( isset( $default_logo_option_id, $default_logo_option ) ) {
								$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['default'] = $default_logo_option['attributes']['slug'] === $item['option_slug'];
							}

							if ( isset( $options[ $item['property_slug'] ][ $item['option_slug'] ]['logos'] ) ) {
								$variants[ $key ][ $item['property_slug'] ][ $item['option_slug'] ]['logos'] = $options[ $item['property_slug'] ][ $item['option_slug'] ]['logos'];
							}
						}
					}
				}
			}
		}

		foreach ( $variants as $key => $variant ) {
			foreach ( $variant as $k => $item ) {
				if ( isset( $k, $key, $variants[ $key ][ $k ][ key( $item ) ], $options[ $k ][ key( $item ) ] ) ) {
					$variants[ $key ][ $k ][ key( $item ) ]['sort'] = $options[ $k ][ key( $item ) ]['sort'];
				}
			}
		}

		return $variants;
	}


	/**
	 * @return array
	 */
	public function get_option_variants_intersect(): array {
		$option_intersect = array();
		$options          = $this->get_prepared_variants();
		foreach ( $options as $key => $color ) {
			foreach ( $color as $attr => $item ) {
				$slug                              = key( $item );
				$option_intersect[ $key ][ $attr ] = $slug;
			}
		}

		return $option_intersect;
	}

	/**
	 * @return array
	 */
	public function get_variants(): array {
		$variants              = array();
		$this->filter_variants = $this->parse_included( self::REMOTE_NAME_VARIANTS );

		if ( ! empty( $this->filter_variants ) ) {
			foreach ( $this->filter_variants as $remote_variant ) {
				if ( is_array( $remote_variant['attributes']['options'] ) && ! $remote_variant['attributes']['master'] ) {
					foreach ( $remote_variant['attributes']['options'] as $option ) {

						if ( ! isset( $variants[ $option['name'] ] ) ) {
							$variants[ $option['name'] ] = array();
						}

						if ( isset( $option['value'], $option['name'] ) && ! in_array( $option['value'], $variants[ $option['name'] ], true ) ) {
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
	public function get_variant_id_by_params( array $params ) {
		$params = array_map(
			static function ( $value ) {
				return strtolower( $value['name'] ?? $value );
			},
			$params
		);

		$filter_variants = $this->parse_included( self::REMOTE_NAME_VARIANTS );

		foreach ( $filter_variants as $filter_variant ) {
			if ( ! empty( $filter_variant['attributes']['options'] ) ) {
				$matches = true;
				foreach ( $filter_variant['attributes']['options'] as $option ) {
					if ( ! in_array( $option['option_slug'], $params, true ) ) {
						$matches = false;
						break;
					}
				}
				if ( $matches ) {
					return $filter_variant['id'];
				}
			}
		}

		return null;
	}

	/**
	 * @param array $params
	 * @param int   $id_variant

	 * @return array|false
	 */
	public function get_variant_info( array $params = array(), int $id_variant = 0 ): array {
		$data = array();
		if ( empty( $id_variant ) ) {
			if ( empty( $params ) ) {
				return array();
			}
			$id_variant = $this->get_variant_id_by_params( $params );
		}

		if ( ! empty( $id_variant ) ) {
			$obj_variant = $this->parse_included_by_id( $id_variant, self::REMOTE_NAME_VARIANTS );
		}

		if ( isset( $obj_variant['attributes'] ) ) {
			$data['attributes'] = $obj_variant['attributes'];
		}

		if ( isset( $obj_variant['relationships'] ) ) {
			foreach ( $obj_variant['relationships'] as $key => $relationship ) {
				if ( isset( $relationship['data']['id'], $relationship['data']['type'] ) ) {
					$data[ $key ] = $this->parse_included_by_id( (int) $relationship['data']['id'], $relationship['data']['type'] );
				}
			}
		}

		$data['remote_variant_id'] = $id_variant;

		return $data;
	}

	/**
	 * @return array
	 */
	public function get_images(): array {
		$filter_variants = $this->parse_included( self::REMOTE_NAME_VARIANTS );

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
	public function get_images_include(): array {
		$ids = array();

		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] as $key => $image ) {
				$ids[ $this->product['data']['id'] ][ $key ] = $image['id'];
			}
		}

		if ( isset( $this->product['included'] ) ) {
			foreach ( $this->product['included'] as $item ) {
				if ( ( $item['type'] === 'options' ) && ! empty( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] ) ) {
					foreach ( $item['relationships'][ self::REMOTE_NAME_IMAGES ]['data'] as $key => $image_item ) {
						$ids[ $item['id'] ][ $key ] = $image_item['id'];
					}
				}
			}
		}

		return $this->parse_included_obj_by_ids( $this->format_image_array( $ids ), $this->product, self::REMOTE_NAME_IMAGES );
	}

	/**
	 * @param string $option
	 *
	 * @return array
	 */
	public function get_image_by_option( string $option ): array {
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

		return $this->parse_included_obj_by_ids( $this->format_image_array( $ids ), $this->product ?? array(), self::REMOTE_NAME_IMAGES );
	}


	/**
	 * @param array $ids
	 *
	 * @return array
	 */
	private function format_image_array( array $ids ): array {
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
	public function get_status_range(): bool {
		$status = false;
		if ( isset( $this->product['data']['attributes'] ) ) {
			$status = $this->product['data']['attributes']['display-price-range'];
		}

		return $status;
	}

	/**
	 * @return array
	 */
	public function get_all_images_relation(): array {
		$properties = $this->get_images_include();
		$data       = array();
		foreach ( $properties as $property ) {
			$data[ $property['id'] ] = $property['attributes'];
		}

		return $data;
	}

	/**
	 * @param string $type
	 *
	 * @return array
	 */
	protected function parse_included( string $type ): array {
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
				if ( $remote_include['type'] === $type ) {
					$data[] = $remote_include;
				}
			}
		}

		$this->parseInclude[ $type ] = $data ?? array();

		return $data ?? array();
	}

	/**
	 * @param int    $id
	 * @param string $type
	 *
	 * @return array|mixed
	 */
	protected function parse_included_by_id( int $id, string $type = '' ) {
		$remote_included = $this->product['included'] ?? null;
		$data            = array();
		if ( ! empty( $remote_included ) ) {
			foreach ( $remote_included as $remote_include ) {
				if ( ! empty( $type ) ) {
					if ( (int) $remote_include['id'] === $id && $remote_include['type'] === $type ) {
						$data = $remote_include;
					}
				} elseif ( (int) $remote_include['id'] === $id ) {
					$data = $remote_include;
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function get_up_sell_products(): array {
		return $this->get_up_sell_products_main( $this->product ?? array() );
	}

	/**
	 * @return array
	 */
	public function get_cross_sell_products(): array {
		return $this->get_cross_sell_products_main( $this->product ?? array() );
	}

	/**
	 * @param string $attribute_type
	 *
	 * @return array
	 */
	public function get_attribute_properties( string $attribute_type ): array {
		$id_relationships = array();
		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][ $attribute_type ];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parse_included_obj_by_ids( $id_relationships, $this->product ?? array(), self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
	}

	/**
	 * @return array
	 */
	public function get_descriptive_option(): array {
		$properties = $this->get_attribute_properties( self::REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES );

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
	 * @return array
	 */
	public function get_descriptive_properties(): array {
		$id_relationships = array();

		if ( isset( $this->product['data']['relationships'] ) && ! empty( $this->product['data']['relationships'] ) ) {
			$data_parse       = $this->product['data']['relationships'][ self::REMOTE_NAME_DESCRIPTIVE_ATTRIBUTES ];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		return $this->parse_included_obj_by_ids( $id_relationships, $this->product, self::REMOTE_NAME_INCLUDE_DESCRIPTIVE_ATTRIBUTES );
	}

	/**
	 * @return bool
	 */
	public function is_tiered_price(): bool {
		return $this->product['data']['attributes']['tiered-price'] ?? false;
	}

	/**
	 * @return array
	 */
	public function get_tired_prices(): array {
		$result = array();
		if ( $this->is_tiered_price() ) {
			$data_parse        = $this->product['data']['relationships'][ self::QUANTITY_PRICE_BREAKS ];
			$relationships_ids = wp_list_pluck( $data_parse['data'], 'id', 'id' );
			$result            = $this->parse_included_obj_by_ids( $relationships_ids, $this->product, self::QUANTITY_PRICE_BREAKS );
		}

		return $this->calculate_tier_discount( $result );
	}

	/**
	 * @param array $prices
	 * @return array
	 */
	private function calculate_tier_discount( array $prices ): array {
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
	 * @param int   $default_logo_option_id
	 * @param array $options
	 *
	 * @return array
	 */
	private function sort_options( int $default_logo_option_id, array $options ): array {
		foreach ( $options as $key => $option ) {
			if ( (int) $option === $default_logo_option_id ) {
				$index = $key;
			}
		}
		if ( isset( $index ) ) {
			$element = $options[ $index ];
			array_splice( $options, $index, 1 );
			array_splice( $options, 0, 0, $element );
		}

		return $options;
	}

	/**
	 * @return array
	 */
	public function get_attributes_options(): array {
		$data                   = array();
		$default_logo_option_id = 0;
		$attributes             = $this->get_attribute_properties( self::REMOTE_NAME_VARIANT_ATTRIBUTES );

		if ( isset( $this->product['data']['attributes']['default-logo-option-id'] ) ) {
			$default_logo_options_info = $this->parse_logos_options_by_type_and_relation_id( $this->product, $this->product['data']['attributes']['default-logo-option-id'], self::LOGO_OPTIONS );
			$default_logo_option_id    = $default_logo_options_info[ $this->product['data']['attributes']['default-logo-option-id'] ]['option_id'];
		}

		foreach ( $attributes as $attribute ) {
			$options     = wp_list_pluck( $attribute['relationships']['options']['data'], 'id' );
			$is_variants = ! empty( $this->product['data']['relationships']['variants']['data'] );
			if ( is_array( $options ) && $is_variants ) {
				if ( isset( $default_logo_option_id ) ) {
					$options = $this->sort_options( $default_logo_option_id, $options );
				}

				foreach ( $options as $option_key => $option_value_id ) {
					$option_obj   = $this->parse_included_obj_by_id( $this->product, $option_value_id, 'options' );
					$logo_options = $this->get_logo_by_option_id( $option_value_id );

					$option_images = array();
					if ( isset( $option_obj['relationships']['images']['data'] ) ) {
						foreach ( $option_obj['relationships']['images']['data'] as $key => $image ) {
							$option_images[ $key ] = $this->parse_included_obj_by_id( $this->product, $image['id'], 'images' );
							if ( isset( $option_images[ $key ]['attributes']['filename'] ) ) {
								unset( $option_images[ $key ]['attributes']['filename'] );
							}
						}
					}

					if ( isset( $attribute['attributes']['slug'], $option_obj['attributes']['slug'] ) ) {
						$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['name'] = $option_obj['attributes']['value'];
						if ( $attribute['attributes']['with-visual-swatch'] && $option_obj['attributes']['image-url'] ) {
							$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['image'] = $option_obj['attributes']['image-url'];
						} elseif ( $attribute['attributes']['with-visual-swatch'] && $option_obj['attributes']['color'] ) {
							$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['color'] = $option_obj['attributes']['color'];
						}
						$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['default'] = $option_obj['attributes']['default'];
						$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['sort']    = $option_key;
						if ( ! empty( $logo_options ) ) {
							$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['logos'] = $logo_options;
						}
						if ( ! empty( $option_images ) ) {
							$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['images'] = $this->add_logos_for_image( $option_images, $logo_options );
						}
						$data[ $attribute['attributes']['slug'] ][ $option_obj['attributes']['slug'] ]['option_id'] = $option_value_id;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * @param array $images
	 * @param array $images_logos
	 *
	 * @return array
	 */
	private function add_logos_for_image( array $images, array $images_logos ): array {
		foreach ( $images as $key => $image ) {
			foreach ( $images_logos as $logo_key => $logo ) {
				if ( (int) $image['id'] === $logo['image_id'] ) {
					$images[ $key ]['logos'][ $logo_key ] = $logo;
				}
			}
		}

		return $images;
	}

	/**
	 * @param int $option_id
	 *
	 * @return array
	 */
	public function get_logo_by_option_id( int $option_id ): array {
		$prepared_logos         = $this->get_logos_by_option();
		$logo_options           = array();
		$default_logo_option_id = $this->product['data']['attributes']['default-logo-option-id'] ?? 0;

		foreach ( $prepared_logos as $key => $logo ) {
			if ( isset( $logo['option_id'] ) && $logo['option_id'] === $option_id ) {
				$logo_options[ $key ] = $logo;
			}
		}

		if ( isset( $logo_options[ $default_logo_option_id ] ) ) {
			$logo_options = array( $default_logo_option_id => $logo_options[ $default_logo_option_id ] ) + $logo_options;
		}

		return $logo_options;
	}


	/**
	 * @return array
	 */
	public function get_logos_by_option(): array {
		$logos          = array();
		$logo_relations = $this->get_logo_option_relations();
		if ( isset( $logo_relations[ self::LOGO_OPTIONS ] ) ) {
			foreach ( $logo_relations[ self::LOGO_OPTIONS ] as $item ) {
				$logo_info                          = $this->parse_logos_options_by_type_and_relation_id( $this->product, $item['id'], self::LOGO_OPTIONS );
				$logos[ $item['id'] ]               = reset( $logo_info );
				$logos[ $item['id'] ]['is_default'] = $this->product['data']['attributes']['default-logo-option-id'] == $item['id'];
			}
		}

		return $logos;
	}

	/**
	 * @param array  $product
	 * @param int    $relation_id
	 * @param string $type
	 *
	 * @return array
	 */
	private function parse_logos_options_by_type_and_relation_id( array $product, int $relation_id = 0, string $type = '' ): array {
		$relation_id = $relation_id ?? 0;
		$includes    = $product['included'];

		if ( empty( $includes ) ) {
			return array();
		}
		$logo_relation_ids = $this->get_logo_ids_from_includes( $includes, $relation_id, $type );

		$logo = array();
		if ( ! empty( $logo_relation_ids ) ) {
			foreach ( $logo_relation_ids as $relation_id => $item ) {
				foreach ( $includes as $remote_include ) {
					if (
						isset( $item['logo-location-id'] ) &&
						(int) $remote_include['id'] === $item['logo-location-id'] &&
						$remote_include['type'] === self::LOGO_LOCATIONS
					) {
						$logo[ $relation_id ]['location'] = $remote_include['attributes'];
					}
					if (
						isset( $item['logo-id'] ) &&
						(int) $remote_include['id'] === $item['logo-id'] &&
						$remote_include['type'] === self::LOGO
					) {
						$logo[ $relation_id ]['logo'] = $remote_include['attributes'];
					}
					$logo[ $relation_id ]['option_id']   = $item['option-id'];
					$logo[ $relation_id ]['image_id']    = $item['image-id'];
					$logo[ $relation_id ]['logo_id']     = $item['logo-id'];
					$logo[ $relation_id ]['location_id'] = $item['logo-location-id'];
				}
			}
		}

		return $logo;
	}

	/**
	 * @return array
	 */
	public function get_logo_option_relations(): array {
		$logo_relations = array();
		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( $key === self::LOGO_OPTIONS ) {
					$logo_relations[ $key ] = $relationship['data'];
				}
			}
		}

		return $logo_relations;
	}

	/**
	 * @return array
	 */
	public function get_logos(): array {
		$logos = $this->parse_included( self::LOGO );

		usort(
			$logos,
			static function ( $a, $b ) {
				if ( $a['attributes']['position'] == $b['attributes']['position'] ) {
					return 0;
				}

				if ( $a['attributes']['position'] < $b['attributes']['position'] ) {
					return - 1;
				}

				return 1;
			}
		);

		return $logos;
	}


	/**
	 * @return array
	 */
	public function get_logo_locations(): array {
		$locations = $this->parse_included( self::LOGO_LOCATIONS );

		usort(
			$locations,
			static function ( $a, $b ) {
				if ( $a['attributes']['position'] == $b['attributes']['position'] ) {
					return 0;
				}

				if ( $a['attributes']['position'] < $b['attributes']['position'] ) {
					return - 1;
				}

				return 1;
			}
		);

		return $locations;
	}

	/**
	 * @param int $product_id
	 *
	 * @return array
	 */
	public function get_subscriptions( int $product_id = 0 ): array {
		$conditions_data = array();
		if ( isset( $this->product['data']['relationships'] ) ) {
			foreach ( $this->product['data']['relationships'] as $key => $relationship ) {
				if ( ! empty( $product_id ) && $key === self::REMOTE_NAME_VARIANTS ) {
					foreach ( $relationship['data'] as $variant ) {
						if ( (int) $product_id === (int) $variant['id'] ) {
							$product_id = $variant['id'];
						}
						break;
					}
				} elseif ( empty( $product_id ) && $key === self::REMOTE_NAME_MASTER_VARIANT ) {
					$product_id = $relationship['data']['id'];
					break;
				}
			}
			if ( ! empty( $product_id ) ) {
				$info_include = $this->parse_included_by_id( (int) $product_id, self::REMOTE_NAME_VARIANTS );
				$plans        = $info_include['relationships']['subscription-plan'] ?? array();

				if ( isset( $plans['data']['id'] ) ) {
					$include_conditions                   = $this->parse_included_by_id( $plans['data']['id'], self::SUBSCRIPTION_PLANS );
					$conditions                           = $include_conditions['relationships']['subscription-conditions']['data'] ?? array();
					$conditions_data['subscription-only'] = $include_conditions['attributes']['subscription-only'];

					foreach ( $conditions as $key => $item ) {
						if ( $item['type'] === 'subscription-conditions' ) {
							$conditions_data[ $key ] = $this->parse_included_by_id( $item['id'] );
						}
					}
				}
			}
		}

		return $conditions_data;
	}




	/**
	 * @param string $type
	 * @return array
	 */
	public static function get_products( string $type ): array {
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
	 * @param string $type
	 *
	 * @return array
	 */
	public static function get_taxonomies( string $taxonomy, string $meta_key, string $type = 'id' ): array {
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

		if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type === 'id' ) {
			foreach ( $result as $item ) {
				$categories[ $item['meta_value'] ] = $item['meta_value'];
			}
		}

		if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type === 'name' ) {
			foreach ( $result as $item ) {
				$categories[ $item['meta_value'] ] = $item['name'];
			}
		}

		if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type === 'slug' ) {
			foreach ( $result as $item ) {
				$categories[ $item['meta_value'] ] = $item['slug'];
			}
		}

		if ( $taxonomy === Prodigy::get_prodigy_category_type() && $type === 'parent' ) {
			foreach ( $result as $item ) {
				$categories[ $item['parent'] ] = $item['parent'];
			}
		}

		if ( $taxonomy === Prodigy::get_prodigy_tag_type() ) {
			foreach ( $result as $item ) {
				$categories[ $item['name'] ] = $item['name'];
			}
		}

		return $categories ?? array();
	}
}
