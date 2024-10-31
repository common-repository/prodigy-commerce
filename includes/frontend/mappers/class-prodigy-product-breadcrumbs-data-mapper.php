<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Prodigy;

/**
 * Prodigy breadcrumbs data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Breadcrumbs_Data_Mapper extends Prodigy_Main_Data_Mapper {

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
		$terms_cat        = get_the_terms( $product->get_field( 'ID' ), Prodigy::get_prodigy_category_type() );
		if ( ! empty( $product ) ) {
			$title = $product->get_remote_title();
			if ( empty( $title ) ) {
				$title = $product->get_field( 'post_title' );
			}
			$params['title'] = $title;
		} else {
			$params['title'] = false;
		}

		if ( ! empty( $terms_cat ) ) {
			$list_categories = wp_list_pluck( $terms_cat, 'slug' );
		}
		if ( isset( $_SERVER['HTTP_REFERER'] ) && ! empty( $list_categories ) ) {
			$request_http_referer = esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
			if ( $request_http_referer ) {
				$get_referer_category = explode( '/', wp_parse_url( $request_http_referer )['path'] );
				$intersect_category   = array_intersect( $list_categories, $get_referer_category );
			}
		}

		$params['category'] = '';
		if ( ! empty( $list_categories ) ) {
			if ( ! empty( $intersect_category ) && is_array( $intersect_category ) ) {
				$params['category'] = array_values( $intersect_category )[0];
			} else {
				$params['category'] = array_values( $list_categories )[0];
			}
		}

		$params['link_to_shop']     = get_permalink( prodigy_get_post_by_title( 'Shop' ) );
		$params['link_to_category'] = get_term_link( $params['category'], Prodigy::get_prodigy_category_type() );
		$info_category              = get_term_by( 'slug', $params['category'], Prodigy::get_prodigy_category_type() );

		if ( ! empty( $info_category->name ) ) {
			$params['category'] = $info_category->name;
		}
		$customizer_product_options = get_option( 'prodigy_product_settings' );
		$params['show_breadcrumbs'] = isset( $options['settings']['idwidget'] ) ? true : ( $customizer_product_options['prodigy_product_breadcrumbs'] ?? true );
		$params['style_curr_page']  = isset( $options['settings']['idwidget'] ) ? $options['settings']['style_curr_page'] : 'yes';

		return $params;
	}
}
