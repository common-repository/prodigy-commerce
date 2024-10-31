<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product description data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Short_Description_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		$product_template           = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                    = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$customizer_product_options = get_option( 'prodigy_product_settings' );
		$options['content']         = ! empty( $product ) ? $product->get_remote_description() :
			'description description description description description description description description description description
         description description description description description description description description description description
          description description description description description description description description description';
		$options['product']         = ! empty( $product ) ? $product : array();

		$options['show_description'] = $customizer_product_options['prodigy_product_description'] ?? true;
		if ( isset( $options['settings']['idwidget'] ) ) {
			$options['settings']                 = get_option( $options['settings']['idwidget'] );
			$options['content_truncate_chars']   = $options['settings']['prg_content_description_truncate_chars']['size'] ?? 0;
			$options['style_anchor_type']        = 'link';
			$options['show_description']         = true;
			$options['content_description_show'] = isset( $options['settings']['prg_content_description_show'] ) && $options['settings']['prg_content_description_show'] === 'yes';
			$options['is_huge_description']      = ( strlen( $options['content'] ) > $options['content_truncate_chars'] && $options['content_description_show'] );
		}

		return $options;
	}
}
