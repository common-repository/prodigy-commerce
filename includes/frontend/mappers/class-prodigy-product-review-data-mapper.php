<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Prodigy_Cart;

/**
 * Prodigy product review data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Review_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options = array() ): array {
		global $wpdb;
		global $post_id;

		$options['author_name_value']  = '';
		$options['author_email_value'] = '';
		if (
			isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) &&
			get_option( 'show_comments_cookies_opt_in' )
		) {
			$user_info = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}prodigy_user_info WHERE user_session_hash=%s;",
					sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) )
				)
			);

			$options['author_name_value']  = ! empty( $user_info->is_show ) ? $user_info->name : '';
			$options['author_email_value'] = ! empty( $user_info->is_show ) ? $user_info->email : '';
		}

		$product               = $options['product']    = $GLOBALS['prodigy_product'];
		$options['post_title'] = $product->get_field( 'post_title' );
		$options['post_id']    = $product->get_field( 'ID' );

		$options['rating_count'] = $product->get_count_rating();
		$options['review_count'] = $product->get_count_reviews();
		$options['average']      = $product->get_average_rating();
		$full_size               = array_values(
			array(
				'width'  => 1600,
				'height' => 1600,
				'crop'   => 1,
			)
		);

		$options['thumburl_info'] = wp_get_attachment_image_src( $product->get_meta_field( '_thumbnail_id' ), $full_size );
		if ( is_array( $options['thumburl_info'] ) ) {
			$options['thumburl'] = array_shift( $options['thumburl_info'] );
		}

		$options['images'] = $product->get_images();

		$options['rating_title'] = $args['general_tabs_review_rating_title_default_text'] ?? 'Average Customer Ratings';

		return $options;
	}
}
