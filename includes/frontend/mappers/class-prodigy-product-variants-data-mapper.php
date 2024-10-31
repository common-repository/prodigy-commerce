<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product variants data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Variants_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product          = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$variants         = array();
		if ( ! empty( $product ) && ! empty( $product->get_remote_variants() ) ) {
			$variants = $product->get_variant_options();
		}

		$parameters = array();
		$i          = 0;
		foreach ( $variants as $key => $option ) {
			$parameters[ $i++ ] = $key;
		}
		$prepared_variants               = ! empty( $product ) ? $product->get_prepared_variants() : array();
		$product_options                 = ! empty( $product ) ? $product->get_variant_options() : array();
		$logos                           = ! empty( $product ) ? $product->get_logos() : array();
		$logo_locations                  = ! empty( $product ) ? $product->get_logo_locations() : array();
		$is_enable_logo                  = ! isset( $options['elementor_settings']['product_logo_tool_enable_option'] ) || $options['elementor_settings']['product_logo_tool_enable_option'] === 'yes';
		$is_enable_logo_swatches         = ! isset( $options['elementor_settings']['product_logo_tool_enable_swatches'] ) || $options['elementor_settings']['product_logo_tool_enable_swatches'] === 'yes';
		$is_logo_tool_multiple_locations = ! isset( $options['elementor_settings']['product_logo_tool_multiple_locations'] ) || $options['elementor_settings']['product_logo_tool_multiple_locations'] === 'yes';
		$master_logos                    = $product->get_master_variant_logos();
		$customizer_shop_options         = get_option( 'prodigy_product_settings' );

		if ( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) {
			$show_bulk = isset( $options['elementor_settings'] ) && $options['elementor_settings']['general_allow_multiple_quantity'] === 'yes';
		} else {
			$show_bulk = isset( $customizer_shop_options['prodigy_product_control_bulk'] ) && $customizer_shop_options['prodigy_product_control_bulk'];
		}

		$tiered_prices                = $product->get_tiered_prices();
		$elementor_add_to_cart_widget = get_option( 'elementor_add_to_cart_options' );
		$variant_options_intersect    = $product->get_option_variants_intersect() ?? array();

		return array(
			'variant_options_intersect'       => $variant_options_intersect,
			'prepared_variants'               => $prepared_variants,
			'product_options'                 => $product_options,
			'logos'                           => $logos,
			'logo_locations'                  => $logo_locations,
			'options'                         => $parameters,
			'product'                         => $product,
			'variants'                        => $variants,
			'show_bulk'                       => $show_bulk,
			'settings'                        => $settings['elementor_settings'] ?? array(),
			'tiered_min_quantity_text'        => $tiered_prices[0]['attributes']['min-quantity'] ?? '',
			'is_tiered_prices'                => ! empty( $tiered_prices ),
			'is_enable_logo'                  => $is_enable_logo,
			'is_enable_logo_swatches'         => $is_enable_logo_swatches,
			'master_logos'                    => $master_logos,
			'is_logo_tool_multiple_locations' => $is_logo_tool_multiple_locations,
			'add_to_cart_widget'              => $elementor_add_to_cart_widget,
		);
	}
}
