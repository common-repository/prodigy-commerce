<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product attributes data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Attributes_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		$product_template              = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                       = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$variant                       = $product->get_remote_master_variant_info();
		$options['descriptive_option'] = $product->get_descriptive_option();

		$options['prodigy_additional_weight']      = $variant['dimension']['attributes']['weight-value'] ?? '';
		$options['prodigy_additional_weight_unit'] = $variant['dimension']['attributes']['weight-unit'] ?? '';
		$options['is_shippable']                   = $variant['dimension']['attributes']['shippable'] ?? '';

		$options['prodigy_additional_height']    = $variant['dimension']['attributes']['height-value'] ?? '';
		$options['prodigy_additional_width']     = $variant['dimension']['attributes']['width-value'] ?? '';
		$options['prodigy_additional_depth']     = $variant['dimension']['attributes']['depth-value'] ?? '';
		$options['prodigy_additional_size_unit'] = $variant['dimension']['attributes']['size-unit'] ?? '';

		$options['show_additional']        = (
			$options['prodigy_additional_height'] &&
			$options['prodigy_additional_width'] &&
			$options['prodigy_additional_depth'] &&
			$options['prodigy_additional_size_unit'] &&
			$options['is_shippable']
		);
		$options['show_additional_weight'] = ( $options['prodigy_additional_weight'] && $options['prodigy_additional_size_unit'] );

		return $options;
	}
}
