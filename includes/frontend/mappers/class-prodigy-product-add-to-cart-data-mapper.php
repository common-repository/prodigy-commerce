<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Prodigy_Elementor_Template_Loader;
use Prodigy\Includes\Prodigy_Options;

/**
 * Prodigy cart data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Add_To_Cart_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$product_template             = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                      = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$params['subscriptions']      = $product->get_subscriptions();
		$params['price']              = $product->get_remote_main_price();
		$params['personalizations']   = $product->get_personalizations_fields();
		$params['personalization_id'] = $params['personalizations']['personalization_id'] ?? null;

		$params['content_truncate_chars'] = isset( $options['elementor_settings']['prg_content_description_truncate_chars']['size'] ) ?
			$options['elementor_settings']['prg_content_description_truncate_chars']['size'] + 3
			: '';

		$params['content_description_show'] = $options['elementor_settings']['prg_content_description_show'] ?? '';
		$params['style_anchor_type']        = $options['elementor_settings']['prg_style_anchor_type'] ?? '';
		$params['is_quick_view']            = $GLOBALS['quick_view'] ?? false;

		$params['confirm_icon_type'] = 'icon';
		if ( ! empty( $options['elementor_settings']['product_subscription_confirmation_message_icon']['value']['url'] ) ) {
			$params['confirm_icon_type'] = 'svg';
		}

		$params['confirm_icon_class'] = $options['elementor_settings']['product_subscription_confirmation_message_icon']['value'] ?? 'icon icon-check';
		$params['confirm_svg_class']  = 'icon-img';
		if ( isset( $options['elementor_settings'] ) && $options['elementor_settings']['product_subscription_confirmation_message_icon_position'] === 'right' ) {
			$params['confirm_icon_class'] .= ' order-last';
			$params['confirm_svg_class']  .= ' order-last';
		}

		$params['add_to_cart_message'] = $options['elementor_settings']['product_subscription_confirmation_message_text'] ?? 'has been added to your cart.';

		$params['additional_data_string'] = '';
		if ( ! empty( $product->get_remote_variants() ) ) {
			$params['additional_data_string'] = 'Select ' . Prodigy_Product_Attributes::concat_attribute_names( $product->get_variant_options() );
		}

		$customizer_product_options = get_option( 'prodigy_product_settings' );
		$is_live_mode               = Prodigy_Elementor_Template_Loader::is_live_mode( $options['elementor_settings'] ?? null );
		$is_use_product_template    = Prodigy_Elementor_Template_Loader::is_use_product_template();

		if ( $is_live_mode || $is_use_product_template ) {
			$params['is_show_view_cart_button'] = ! isset( $options['elementor_settings']['attributes_view_cart_show'] ) || $options['elementor_settings']['attributes_view_cart_show'] === 'yes';
		} else {
			$params['is_show_view_cart_button'] = ! isset( $customizer_product_options['prodigy_product_view_cart'] ) || $customizer_product_options['prodigy_product_view_cart'];
		}

		$params['main_price']   = ! empty( $product ) ? $product->get_remote_main_price() : 0;
		$params['stock_status'] = $product->get_remote_master_variant_info()['inventory']['attributes']['stock'] ?? 'in_stock';

		$params['is_elementor_show_price']        = $options['elementor_settings']['general_add_to_cart_show_price'] ?? '';
		$params['is_elementor_show_availability'] = $options['elementor_settings']['general_add_to_cart_show_availability'] ?? '';
		$params['product']                        = $product;
		$params['subscriptions']                  = $product->get_subscriptions();
		$params['is_redemption_store']            = Prodigy_Options::get_redemption_store_status();

		return $params;
	}
}
