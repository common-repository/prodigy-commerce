<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Helpers\Prodigy_Formatting;

/**
 * Prodigy sku data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Sku_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$product_template           = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                    = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$params['main_sku']         = ! empty( $product ) ? $product->get_remote_main_sku() : '';
		$params['categories']       = ! empty( $product ) ? $product->get_remote_categories() : array();
		$params['tags']             = ! empty( $product ) ? $product->get_remote_tags() : array();
		$params['count_categories'] = count( ( is_countable( $params['categories'] ) ? $params['categories'] : array() ) );
		$params['count_tags']       = count( ( is_countable( $params['tags'] ) ? $params['tags'] : array() ) );
		$customizer_product_options = get_option( 'prodigy_product_settings' );

		$params['enable_product_sku'] = isset( $options['meta_show_sku'] )
			? ( $options['meta_show_sku'] === 'yes' )
			: ( $customizer_product_options['prodigy_product_sku'] ?? true );

		$params['enable_product_categories'] = isset( $options['meta_show_categories'] )
			? ( $options['meta_show_categories'] === 'yes' )
			: ( $customizer_product_options['prodigy_product_categories'] ?? true );

		$params['enable_product_tags'] = isset( $options['meta_show_tags'] )
			? ( $options['meta_show_tags'] === 'yes' )
			: ( $customizer_product_options['prodigy_product_tags'] ?? true );

		$params['charge_amount'] = Prodigy_Formatting::prodigy_price_format( $product->get_charge_amount() );

		return $params;
	}
}
