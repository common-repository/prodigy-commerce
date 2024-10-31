<?php

namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Catalog_Filters_Parser;
use Prodigy\Includes\Content\Prodigy_Catalog_Products_Parser;
use Prodigy\includes\content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy_Product_Attributes;
use Prodigy\Includes\Widgets\Prodigy_Filters_Widget;

/**
 * Prodigy filters data mapper
 *
 * @version    2.8.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Filter_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Collected GET params
	 *
	 * @var array
	 */
	private $get_request = array();

	/**
	 * Minimum quantity of items to show in filter
	 */
	const SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS = 1;

	/**
	 * @param array $filters
	 *
	 * @return array
	 */
	public function get_request_existing_attributes( array $filters ): array {
		$result = array();

		foreach ( $filters as $attribute ) {
			if ( ! empty( $this->get_request['attr']['attr'] ) && array_key_exists( $attribute['id'], $this->get_request['attr']['attr'] ) ) {
				$result[ $attribute['id'] ] = $this->get_request['attr']['attr'][ $attribute['id'] ];
			}
		}

		return $result;
	}


	/**
	 * @param array  $filters
	 * @param string $attribute
	 * @param string $attr_value
	 *
	 * @return string|string[]
	 */
	public function http_build_by_attr( array $filters, string $attribute, string $attr_value ) {
		$list['attr'] = $this->get_request_existing_attributes( $filters );

		if ( array_key_exists( $attribute, $list['attr'] ) ) {
			$attr_values = explode( '%3B', $list['attr'][ $attribute ] );
			$attr_values[] = $attr_value;
			$new_attr_values = array_unique( $attr_values );
			$list['attr'][ $attribute ] = implode( '%3B', $new_attr_values );
		} else {
			$list['attr'][ $attribute ] = $attr_value;
		}
		if ( ( is_prodigy_product_taxonomy() || is_page( 'shop' ) ) && isset( $_SERVER['REQUEST_URI'] ) ) {
			$path_redirect = sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) );
		} else {
			$path_redirect = prodigy_get_shop_url();
		}

		$path_redirect = remove_query_arg( array( 'search' ), $path_redirect );
		$path_redirect = remove_query_arg( array( 'pg' ), $path_redirect );
		$list_args     = add_query_arg( $list, $path_redirect );

		return str_replace( ';', '%3B', $list_args );
	}

	/**
	 * @param array $filters
	 *
	 * @return array
	 */
	public function get_output_attrs( array $filters ): array {
		$output_filter = array();

		if ( ! empty( $filters ) ) {
			foreach ( $filters as $filter ) :
				if ( isset( $filter['values'] ) ) {
					foreach ( $filter['values'] as $attribute_values ) :
						if ( $attribute_values['count'] < self::SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS ) {
							continue;
						}
						$output_filter[ $attribute_values['name'] ] = $this->http_build_by_attr( $filters, $filter['id'], $attribute_values['name'] );
					endforeach;
				}
			endforeach;
		}

		return $output_filter;
	}


	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public function prepare_params( array $params ): array {
		unset( $params['action'], $params['_'] );

		return $params;
	}

	/**
	 * @param array $atts
	 *
	 * @return array
	 */
	public function get_default_parameters( array $atts = array() ): array {
		$query = '';
		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'attributes-filter' ) ) {
			$query = $_GET ?? array();
		}

		$params          = $this->prepare_params( $_GET ?? array() );
		$products_parser = new Prodigy_Catalog_Products_Parser();
		$query_params = $products_parser->set_query_catalog_params( $params );
		$category     = $products_parser->get_catalog_category_param( $params['tax_slug'] ?? '', $params['tax_name'] ?? '' );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$query = $products_parser->catalog_query_builder( $query_params, (int) $products_parser->get_number_per_page() );



		$filters      = Prodigy_Request_Maker::get_instance()->do_catalog_filters_request( $query );
		$filterParser = new Prodigy_Catalog_Filters_Parser();
		$filter       = $filterParser::get_attributes( $filters );

		$data = array();
		if ( ! empty( $filter ) ) {
			$data = array(
				'filters' => $filter,
				'query'   => $query ?? '',
			);
		}

		if ( ! empty( $atts['attribute_ids'] ) || ! empty( $atts['attribute_names'] ) ) {
			$atts = array_merge(
				array(
					'attribute_ids'   => array(),
					'attribute_names' => array(),
				),
				$atts
			);

			if ( ! empty( $atts['attribute_ids'] ) ) {
				$ids                   = array_filter( array_map( 'trim', explode( ',', $atts['attribute_ids'] ) ) );
				$atts['attribute_ids'] = array();
				foreach ( $ids as $key => $attribute_id ) {
					$attribute = Prodigy_Product_Attributes::get_attribute_taxonomies_by_remote_id( (int) $attribute_id );
					if ( ! empty( $attribute ) ) {
						$atts['attribute_ids'][ $key ] = $attribute->id;
					}
				}
			}

			if ( ! empty( $atts['attribute_names'] ) ) {
				$names                 = array_filter( array_map( 'trim', explode( ',', $atts['attribute_names'] ) ) );
				$atts['attribute_ids'] = array();
				foreach ( $names as $key => $attribute_name ) {
					$attribute = Prodigy_Product_Attributes::get_info_prodigy_attr_taxonomy_by_slug( $attribute_name );
					if ( ! empty( $attribute ) ) {
						$atts['attribute_ids'][ $key ] = $attribute->id;
					}
				}
			}
		} else {
			$list_attrs              = Prodigy_Product_Attributes::get_attribute_taxonomies();
			$atts['attribute_ids']   = wp_list_pluck( $list_attrs, 'id' );
			$atts['attribute_names'] = array();
		}

		if ( ! empty( $atts ) ) {
			$prepared_data       = array();
			if ( isset( $data['filters'] ) ) {
				$prepared_data = $this->apply_widget_settings( $data['filters'], $atts['attribute_ids'] );
			}

			$request_attr = $data['query'] ?? null;

			$this->get_request['attr'] = $request_attr ?? array();
			$params                    = array(
				'filters'        => $prepared_data,
				'active_filters' => false,
				'get_request'    => $this->get_request['attr'],
				'filters_output' => $this->get_output_attrs( $data['filters'] ?? array() ),
				'current_object' => get_queried_object(),
				'attr_shortcode' => $atts,
				'display'        => $atts['attrs_content_type'] ?? 'accordion',
			);
		} else {
			$params = array(
				'filters'        => array(),
				'current_object' => array(),
				'get_request'    => array(),
				'active_filters' => array(),
				'filters_output' => array(),
				'display'        => 'accordion',
			);
		}

		$params['attribute_ids']               = $atts['attribute_ids'] ?? '';
		$params['elementor_filter_mode']       = $atts['elementor_filter_mode'] ?? '';
		$params['heading_text']                = $atts['heading_text'] ?? 'Filter by';
		$params['heading_active_text']         = $atts['heading_active_filter'] ?? 'Active Filters';
		$params['count_show_attributes_value'] = $atts['count_show_attributes_value'] ?? Prodigy_Filters_Widget::DEFAULT_VISIBLE_AMOUNT;
		$params['vision_section_amount']       = $atts['vision_section_amount'] ?? Prodigy_Filters_Widget::DEFAULT_EXPANDED_AMOUNT;
		$params['idWidget']                    = $atts['idWidget'] ?? 'filter';
		$params['attrs_content_prod_count']    = $atts['attrs_content_prod_count'] ?? 'yes';
		$params['layout'] = ( isset( $params['display'] ) && $params['display'] === 'accordion' ) ? 'shortcode/filter-accordion.php' : 'shortcode/filter-list.php';

		return $params;
	}

	/**
	 * @param array $data
	 * @param array $list_attributes
	 *
	 * @return array
	 */
	public function apply_widget_settings( array $data, array $list_attributes = null ): array {
		$new_data          = array();
		$mapped_attributes = array();
		$attributes        = array();

		if ( $list_attributes ) {
			$attributes = $list_attributes;
		} else {
			$settings = get_option( 'widget_filters_prodigy_widget' );
			foreach ( $settings as $setting ) {
				if ( isset( $setting['list_attributes'] ) ) {
					$attributes = $setting['list_attributes'];
				}
			}
		}

		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $attribute_id ) {
				$attribute_value                                  = Prodigy_Product_Attributes::get_attribute_taxonomies_by_id( $attribute_id );
				$mapped_attributes[ $attribute_value->remote_id ] = $attribute_id;
			}
		}

		if ( ! empty( $data ) ) {
			foreach ( $data as $key => $item ) {
				if ( isset( $mapped_attributes[ $item['id'] ] ) ) {
					$new_data[ $key ] = $item;
					$attribute = Prodigy_Product_Attributes::get_attribute_taxonomies_by_remote_id( $item['id'] );
					if ( isset( $attribute ) ) {
						$new_data[ $key ]['slug'] = $attribute->slug;
					}
				}
			}
		}

		// Unset empty values.
		if ( ! empty( $new_data ) ) {
			foreach ( $new_data as $key => $attribute ) {
				foreach ( $attribute['values'] as $key_val => $value ) {
					if ( empty( $value['count'] ) ) {
						unset( $new_data[ $key ]['values'][ $key_val ] );
					}
				}
			}
		}

		return $new_data;
	}
}
