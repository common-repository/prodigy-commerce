<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product price data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Price_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		$product_template            = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                     = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$options['main_price']       = ! empty( $product ) ? $product->get_remote_main_price() : 0;
		$tiered_price_range          = $product->get_tiered_price_range();
		$options['is_tiered_prices'] = ! empty( $tiered_price_range['min_price'] ) && ! empty( $tiered_price_range['max_price'] ) && ! empty( $tiered_price_range['min_quantity'] );
		$options['product']          = ! empty( $product ) ? $product : array();

		return $options;
	}
}
