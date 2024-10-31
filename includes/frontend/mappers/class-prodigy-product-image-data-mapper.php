<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

/**
 * Prodigy product image data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Image_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		$product_template       = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product                = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$options['attachments'] = array();
		if ( isset( $options['settings']['images'] ) ) {
			$options['attachments'] = $options['settings']['images'] ?? array();
			$post_thumbnail_info    = $options['settings']['images'] ?? array();
		}

		if ( isset( $product ) ) {
			$options['attachments']       = $product->get_images() ?? array();
			$post_thumbnail_info          = $product->get_images() ?? array();
			$options['post_thumbnail_id'] = false;
		}

		if ( is_array( $options['attachments'] ) && ! empty( $post_thumbnail_info ) ) {
			$options['post_thumbnail_id'] = array_shift( $post_thumbnail_info );
		}

		// Check quick view modal window
		$options['is_quick_view'] = $GLOBALS['quick_view'] ?? false;

		$options['gallery_classname'] = 'prodigy-product__gallery-container images-gallery-js prodigy-order-2 prodigy-order-md-0';
		if ( ! isset( $options['idWidget'] ) ) {
			$options['gallery_classname'] .= ' col-md-6';
		} else {
			if ( $options['style_thumbnails_position'] === 'top' ) {
				$options['gallery_classname'] .= ' prodigy-product__gallery-container--top';
			}
			if ( $options['style_thumbnails_position'] === 'left' ) {
				$options['gallery_classname'] .= ' prodigy-product__gallery-container--left';
			}
			if ( $options['style_thumbnails_position'] === 'right' ) {
				$options['gallery_classname'] .= ' prodigy-product__gallery-container--right';
			}
		}

		if ( isset( $options['post_thumbnail_id'] ) && ! $options['post_thumbnail_id'] ) {
			$options['gallery_classname'] .= ' prodigy-product__gallery--no-image';
		}

		$options['price'] = 0;
		if ( isset( $product ) ) {
			$options['price'] = $product->get_remote_main_price();
		}

		$options['image_ratio'] = Prodigy_Customizer::get_images_ratio();

		$options['show_thumbnails'] = true;
		if ( isset( $options['settings']['idWidget'] ) ) {
			$options['show_thumbnails'] = $options['settings']['content_thumbnails'] === 'yes';
		}

		$options['ratio'] = ( $options['style_image_ratio_active_image']['width'] ?? 3 ) / ( $options['style_image_ratio_active_image']['height'] ?? 4 );

		return $options;
	}
}
