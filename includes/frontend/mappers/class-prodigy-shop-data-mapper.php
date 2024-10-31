<?php

namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

/**
 * Prodigy shop page data mapper
 *
 * @version    2.8.9
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Shop_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$customizer_shop_options         = get_option( 'prodigy_shop_settings' );
		$elementor_filter_widget_options = get_option( 'pg_elementor_filter_widget', array() );
		$options['elementor_options']    = array_merge( $elementor_filter_widget_options, $options['elementor_options'] ?? array() );
		if ( wp_doing_ajax() ) {
			$elementor_product_widget_options = get_option( 'pg_elementor_archive_widget', array() );
			$options['elementor_options']     = array_merge( $elementor_filter_widget_options, $elementor_product_widget_options );
		}

		$options['customizer_general_options'] = get_option( 'prodigy_general_options' );
		$options['customizer_shop_options']    = get_option( 'prodigy_shop_settings' );
		$options['prodigy_shop_sidebar']       = $customizer_shop_options['prodigy_shop_sidebar'] ?? true;

		$options['image_ratio']    = Prodigy_Customizer::get_images_ratio();
		$options['products']       = $options['content']['products'] ?? $options['elementor_options']['products'] ?? '';
		$options['pagination']     = $options['content']['pagination'] ?? $options['elementor_options']['pagination'] ?? '';
		$options['is_show_search'] = $customizer_shop_options['prodigy_shop_search_bar'] ?? true;

		if ( Prodigy_Layouts_Manager::is_using_archive_elementor_templates() && ! empty( $options['elementor_options']['style_archive_products_image_aspect_ratio']['width'] ) && ! empty( $options['elementor_options']['style_archive_products_image_aspect_ratio']['height'] ) ) {
			$options['image_ratio'] = ( $options['elementor_options']['style_archive_products_image_aspect_ratio']['height'] / $options['elementor_options']['style_archive_products_image_aspect_ratio']['width'] ) * 100;
		}

		$options['product_list_classname'] = 'prodigy-product-list';
		$options['sale_classname']         = 'prodigy-product-list__item-label';

		if ( ! isset( $options['elementor_options']['idWidget'] ) ) {
			$options['product_list_classname'] .= ' ';
		} else {
			if ( isset( $options['elementor_options']['style_archive_products_sale_position_vertical'] ) && $options['elementor_options']['style_archive_products_sale_position_vertical'] === 'bottom' ) {
				$options['sale_classname'] .= ' prodigy-product-list__item-label--bottom';
			}
			if ( isset( $options['elementor_options']['style_archive_products_sale_position_horizontal'] ) && $options['elementor_options']['style_archive_products_sale_position_horizontal'] === 'right' ) {
				$options['sale_classname'] .= ' prodigy-product-list__item-label--right';
			}
		}

		if ( Prodigy_Layouts_Manager::is_using_archive_elementor_templates() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) {
			$options['enable_quick_view'] = ! isset( $options['elementor_options']['content_archive_products_content_quick_view'] ) || $options['elementor_options']['content_archive_products_content_quick_view'] === 'yes';
		} else {
			$options['enable_quick_view'] = ! isset( $customizer_shop_options['prodigy_shop_products_quick_view'] ) || $customizer_shop_options['prodigy_shop_products_quick_view'];
		}

		if ( Prodigy_Layouts_Manager::is_using_archive_elementor_templates() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) {
			$options['enable_rating'] = ! isset( $options['elementor_options']['content_archive_products_content_rating'] ) || $options['elementor_options']['content_archive_products_content_rating'] === 'yes';
		} else {
			$options['enable_rating'] = ! isset( $customizer_shop_options['prodigy_shop_products_rating'] ) || $customizer_shop_options['prodigy_shop_products_rating'];
		}

		if ( Prodigy_Layouts_Manager::is_using_archive_elementor_templates() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) {
			$options['enable_sale_badge'] = ! isset( $options['elementor_options']['content_archive_products_content_sale'] ) || $options['elementor_options']['content_archive_products_content_sale'] === 'yes';
		} else {
			$options['enable_sale_badge'] = ! isset( $customizer_shop_options['prodigy_shop_products_sale'] ) || $customizer_shop_options['prodigy_shop_products_sale'];
		}

		$options['enable_category'] = ( $options['elementor_options']['content_archive_products_content_category'] ?? 'yes' ) === 'yes';
		$options['page_object']     = get_queried_object();

		return $options;
	}
}
