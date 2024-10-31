<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product rating data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Rating_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		$product_template         = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                  = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$options['is_quick_view'] = $GLOBALS['quick_view'] ?? false;

		$options['rating_count']         = ! empty( $product ) ? $product->get_count_rating() : 0;
		$options['review_count']         = ! empty( $product ) ? $product->get_count_reviews() : '';
		$options['average']              = ! empty( $product ) ? $product->get_average_rating() : 0;
		$options['product_variant_info'] = ! empty( $product ) ? $product->get_remote_master_variant_info() : array();
		$options['product']              = ! empty( $product ) ? $product : array();

		if ( isset( $settings['idWidget'] ) ) {
			$settings = get_option( $settings['idWidget'] );
		}

		$options['icon_type'] = 'icon';
		if ( ! empty( $settings['prg_style_rating_selected_icon']['value']['url'] ) ) {
			$options['icon_type'] = 'svg';
		}
		$options['icon_class']     = $settings['prg_style_rating_selected_icon']['value'] ?? 'icon icon-user';
		$options['icon_svg_class'] = 'icon-img';
		if ( isset( $settings['prg_style_rating_icon_align'] ) && $settings['prg_style_rating_icon_align'] === 'right' ) {
			$options['icon_class']     .= ' order-last';
			$options['icon_svg_class'] .= ' order-last';
		}

		return $options;
	}
}
