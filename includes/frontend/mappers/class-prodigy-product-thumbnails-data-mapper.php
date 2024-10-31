<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product thumbnails data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Thumbnails_Data_Mapper extends Prodigy_Main_Data_Mapper {

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
		if ( wp_doing_ajax() && isset( $options['images'] ) ) {
			$options['attachments'] = $options['images'];
		} elseif ( isset( $product ) || ( wp_doing_ajax() && ! isset( $options['images'] ) ) ) {
			$options['attachments']       = $product->get_images();
			$options['post_thumbnail_id'] = false;
		}

		return $options;
	}
}
