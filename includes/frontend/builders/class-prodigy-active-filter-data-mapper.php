<?php
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Models\Prodigy_Attribute_Taxonomies;

/**
 * Prodigy filters data mapper
 *
 * @version    2.8.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Active_Filter_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $attr
	 *
	 * @return array
	 */
	public function get_default_parameters( array $attr ): array {
		$args_request = self::get_all_values_attr();
		$params = array(
			'args_request'        => $args_request,
			'attr_shortcode'      => $attr,
			'show_attribute_name' => $attr['show_attribute_name'] ?? ''
		);

		$params['idwidget']                = $attr['attr_shortcode']['idwidget'] ?? '';
		$params['heading_active_filter']   = $attr['attr_shortcode']['active_filters_style_heading_text'] ?? 'Active Filter';
		$params['current_url']             = wp_parse_url( $_SERVER['REQUEST_URI'] );
		$params['path_clear']              = $current_url['path'] ?? '/';
		$params['customizer_shop_options'] = get_option( 'prodigy_shop_settings' );
		$params['elementor_conditions']    = get_option( 'elementor_pro_theme_builder_conditions' );

		if ( Prodigy_Layouts_Manager::is_elementor_live_preview() || Prodigy_Layouts_Manager::is_elementor_template() ) {
			$params['is_show_active_filter_name'] = isset( $attr['attr_shortcode']['active_filters_show_attribute_name'] ) && $attr['attr_shortcode']['active_filters_show_attribute_name'] === 'yes';
		} else {
			$params['is_show_active_filter_name'] = $args['show_attribute_name'] ?? '';
		}

		return $params;
	}

    /**
     * @param array $list
     * @return array|bool
     */
    public function array_flatten( array $list ) {

	    $result = array();
        foreach ( $list as $key => $value ) {
            if ( is_array( $value ) ) {
                $result = array_merge( $result, $this->array_flatten( $value ) );
            } else {
                $result[ $key ] = $value;
            }
        }

        return $result;
    }

	/**
	 * @return array
	 */
	public static function get_all_values_attr(): array {
		if ( ! isset( $_GET['attr'] ) && ! isset( $_GET['price_min'], $_GET['price_max'] ) ) {
			return array();
		}

		$result = array();
		if ( isset( $_GET['attr'] ) || isset( $_GET['price_min'], $_GET['price_max'] ) ) {
			$get_list_args = $_GET['attr'] ?? array();

			if ( isset( $_GET['price_min'], $_GET['price_max'] ) ) {
				$get_list_args['Price'] = '$' . sanitize_text_field( prodigy_price_format( $_GET['price_min'] ) ) . ' - $' . sanitize_text_field( prodigy_price_format( $_GET['price_max'] ) );
			}

			foreach ( $get_list_args as $id => $value ) {
				$id        = sanitize_text_field( $id );
				$attribute = Prodigy_Attribute_Taxonomies::get_by_remote_id( (int) $id );
				$value     = sanitize_text_field( $value );
				$values    = explode( ';', $value );

				foreach ( $values as $key => $value_name ) {
					$term                                                    = get_term_by( 'slug', $value_name, $attribute->slug ?? '' );
					$result[ $attribute->name ?? '' ][ $id ][ $key ]['name'] = sanitize_text_field( $term->name ?? $value_name );
					$result[ $attribute->name ?? '' ][ $id ][ $key ]['slug'] = sanitize_text_field( $value_name );
				}
			}

			return $result;
		}
	}

	/**
	 * Get elementor settings for widget
	 *
	 * @return false|mixed|null
	 */
	public static function get_widget_settings() {
		if ( Prodigy_Layouts_Manager::is_elementor_live_preview() || Prodigy_Layouts_Manager::is_elementor_template() ) {
			$id_filter_widget = $_GET['filter_widget_id'] ?? '';

			return get_option( $id_filter_widget );
		}

		return unserialize( get_option( 'prodigy_active_shortcode_settings' ) );
	}

}