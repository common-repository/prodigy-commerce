<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product tags data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Tags_Data_Mapper extends Prodigy_Main_Data_Mapper {

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
		$options['tags']            = ! empty( $product ) ? $product->get_remote_tags() : array();
		$options['tags_count']      = count( (array) $options['tags'] );
		$customizer_product_options = get_option( 'prodigy_product_settings' );

		$options['enable_product_tags'] = isset( $options['meta_show_tags'] )
			? ( $options['meta_show_tags'] === 'yes' )
			: ( $customizer_product_options['prodigy_product_tags'] ?? true );

		return $options;
	}
}
