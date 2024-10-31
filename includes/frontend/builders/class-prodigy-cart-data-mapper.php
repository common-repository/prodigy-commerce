<?php
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;

/**
 * Prodigy cart page data mapper
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Cart_Data_Mapper extends Prodigy_Main_Data_Mapper {
	public function get_default_parameters( array $atts ): array {
		$cart_products = array();
		$gallery_thumb = false;

		$cart        = new Prodigy_Cart();
		$order_token = $cart->get_token_for_current_order( $this->user_cookie );
		if ( $order_token ) {
			$order_data = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$order      = new Prodigy_Order_Parser( $order_data );
			$cart_items = $order->get_line_items();
			$is_product_deleted = $order->is_order_item_deleted();
		}

		if ( ! empty( $cart_items ) ) {
			foreach ( $cart_items as $item ) {
				$remote_product_id = $item['attributes']['variant-id'];
				$quantity          = $item['attributes']['quantity'];
				$actual_price      = $item['attributes']['price'];
				$item_total        = $item['attributes']['total'];
				$image_url         = $item['attributes']['image-url'];
				$name              = $item['attributes']['name'];

				$local_parent_product_info = Prodigy_Product_Parser::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, (int) $item['attributes']['product-id'] );
				$local_parent_product_id   = $local_parent_product_info->post_id;
				$option_variants           = $item['attributes']['options'];

				$cart_products[ $remote_product_id ]                            = $item;
				$cart_products[ $remote_product_id ]['remote_product_id']       = $remote_product_id;
				$cart_products[ $remote_product_id ]['count_items']             = $quantity;
				$cart_products[ $remote_product_id ]['actual_price']            = $actual_price;
				$cart_products[ $remote_product_id ]['total_price']             = $item_total;
				$cart_products[ $remote_product_id ]['image_url']               = $image_url;
				$cart_products[ $remote_product_id ]['name']                    = $name;
				$cart_products[ $remote_product_id ]['local_parent_product_id'] = $local_parent_product_id;
				$cart_products[ $remote_product_id ]['option_variants']         = $option_variants;
				$cart_products[ $remote_product_id ]['logo_options']            = $item['attributes']['logos'];
			}
		}

		$customizer_general_options = get_option( 'prodigy_general_options' );

		return array(
			'heading_text'                 => $atts['cart_style_heading_text'] ?? 'Shopping Cart',
			'empty_cart_text'              => $atts['cart_style_empty_text'] ?? 'No products added yet',
			'cart_products'                => $cart_products ?? array(),
			'gallery_thumb'                => $gallery_thumb,
			'is_dropdown'                  => $atts['dropdown'] ?? true,
			'is_deleted_product'           => $is_product_deleted ?? false,
			'cart_widget_option'           => $customizer_general_options['prodigy_enable_cart_widget'] ?? false,
			'count_classname'              => $atts['count_classname'] ?? 'prodigy-navbar-cart__count',
			'attr_shortcode'               => $atts,
			'cart_icon_type'               => $atts['cart_icon_type'] ?? '',
			'cart_content_icon_hide_empty' => $atts['cart_content_icon_hide_empty'] ?? '',
			'container_class'              => $atts['container_class'] ?? '',
		);
	}
}
