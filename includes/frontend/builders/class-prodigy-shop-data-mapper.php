<?php

namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;


defined( 'ABSPATH' ) || exit;

/**
 * Prodigy shop page data mapper
 *
 * @version    2.8.9
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Shop_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public function get_default_parameters( array $params ): array {
		$customizer_shop_options = get_option( 'prodigy_shop_settings' );
		$elementor_options                = $params['elementor_options'] ?? get_option( 'pg_elementor_archive_widget', array() );
		$params['is_life_preview']        = isset( $params['elementor_options'] );
		$params['elementor_conditions']   = get_option( 'elementor_pro_theme_builder_conditions' );
		$params['has_elementor_template'] = ! empty( $elementor_conditions['archive'] );

		$params['customizer_general_options'] = get_option( 'prodigy_general_options' );
		$params['customizer_shop_options']    = get_option( 'prodigy_shop_settings' );
		$params['prodigy_shop_sidebar']       = $customizer_shop_options['prodigy_shop_sidebar'] ?? true;

		$params['image_ratio']    = Prodigy_Customizer::get_images_ratio();
		$params['products']       = $params['content']['products'] ?? $elementor_options['products'];
		$params['pagination']     = $params['content']['pagination'] ?? $elementor_options['pagination'] ?? '';
		$params['is_show_search'] = $customizer_shop_options['prodigy_shop_search_bar'] ?? true;

		if ( Prodigy_Layouts_Manager::is_elementor_template() && ! empty( $elementor_options['style_archive_products_image_aspect_ratio']['width'] ) && ! empty( $elementor_options['style_archive_products_image_aspect_ratio']['height'] ) ) {
			$params['image_ratio'] = ( $elementor_options['style_archive_products_image_aspect_ratio']['height'] / $elementor_options['style_archive_products_image_aspect_ratio']['width'] ) * 100;
		}

		$params['product_list_classname'] = 'prodigy-product-list';
		$params['sale_classname']         = 'prodigy-product-list__item-label';

		if ( ! isset( $elementor_options['idWidget'] ) ) {
			$params['product_list_classname'] .= ' ';
		} else {
			if ( isset( $elementor_options['style_archive_products_sale_position_vertical'] ) && $elementor_options['style_archive_products_sale_position_vertical'] === 'bottom' ) {
				$params['sale_classname'] .= ' prodigy-product-list__item-label--bottom';
			}
			if ( isset( $elementor_options['style_archive_products_sale_position_horizontal'] ) && $elementor_options['style_archive_products_sale_position_horizontal'] === 'right' ) {
				$params['sale_classname'] .= ' prodigy-product-list__item-label--right';
			}
		}

		if ( $params['is_life_preview'] || $params['has_elementor_template'] || wp_doing_ajax() ) {
			$params['enable_quick_view'] = ! isset( $elementor_options['content_archive_products_content_quick_view'] ) || $elementor_options['content_archive_products_content_quick_view'] === 'yes';
		} else {
			$params['enable_quick_view'] = ! isset( $customizer_shop_options['prodigy_shop_products_quick_view'] ) || $customizer_shop_options['prodigy_shop_products_quick_view'];
		}

		if ( $params['is_life_preview'] || $params['has_elementor_template'] || wp_doing_ajax() ) {
			$params['enable_rating'] = ! isset( $elementor_options['content_archive_products_content_rating'] ) || $elementor_options['content_archive_products_content_rating'] === 'yes';
		} else {
			$params['enable_rating'] = ! isset( $customizer_shop_options['prodigy_shop_products_rating'] ) || $customizer_shop_options['prodigy_shop_products_rating'];
		}

		if ( $params['is_life_preview'] || $params['has_elementor_template'] || wp_doing_ajax() ) {
			$params['enable_sale_badge'] = ! isset( $elementor_options['content_archive_products_content_sale'] ) || $elementor_options['content_archive_products_content_sale'] === 'yes';
		} else {
			$params['enable_sale_badge'] = ! isset( $customizer_shop_options['prodigy_shop_products_sale'] ) || $customizer_shop_options['prodigy_shop_products_sale'];
		}

		$params['enable_category'] = ( $elementor_options['content_archive_products_content_category'] ?? 'yes' ) === 'yes';
		$params['page_object']     = get_queried_object();

		return $params;
	}

}
