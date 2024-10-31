<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;

/**
 * Prodigy cart page data mapper
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Cart_Page_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/** @var Prodigy_Cart  */
	public $cart;

	public function __construct() {
		parent::__construct();
		$this->cart = new Prodigy_Cart();
	}

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$order_token = $this->cart->get_token_for_current_order( $this->user_cookie );

		if ( $order_token ) {
			$order_data = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$order      = new Prodigy_Order_Parser( $order_data );

			$is_product_deleted = $order->is_order_item_deleted();
			$cart_items         = $order->get_line_items();
			$order_attributes   = $order->get_attributes();

			$up_sell_product_ids = $order->get_cross_sell_products();
			$up_sell_product_ids = get_format_related_products( $up_sell_product_ids );

			$params                                = $this->format_data( $cart_items );
			$cart_params['common_number_of_items'] = $params['common_number_of_items'];
			unset( $params['common_number_of_items'] );
			$cart_params['items'] = $params;
		}

		return array(
			'is_quantity_number' => $options['is_quantity_title'] ?? true,
			'is_product_deleted' => $is_product_deleted ?? false,
			'cart_items'         => $cart_params ?? array(),
			'order_attributes'   => $order_attributes ?? array(),
			'related_products'   => $up_sell_product_ids['data'] ?? array(),
		);
	}

	public function format_data( array $cart_items ) :array {
		$common_number_of_items = 0;
		foreach ( $cart_items as $key => $item_line ) {
			$common_number_of_items += $item_line['attributes']['quantity'];
			$local_parent_product_info = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id(
				Prodigy::PRODIGY_REMOTE_PRODUCT_ID,
				(int) $item_line['attributes']['product-id'] ?? ''
			);
			$cart_items[ $key ]['product_name'] = $item_line['attributes']['name'] ?? '';
			$cart_items[ $key ]['product_img'] = $item_line['attributes']['versions-image-url'] ?? '';
			$cart_items[ $key ]['product_sku'] = $item_line['attributes']['sku'] ?? '';
			$cart_items[ $key ]['option_variants'] = $item_line['attributes']['options'] ?? '';
			$cart_items[ $key ]['logo_options'] = $item_line['attributes']['options'] ?? '';
			$cart_items[ $key ]['local_url'] = esc_url( get_permalink( $local_parent_product_info->post_id ) );
			$cart_items[ $key ]['image_src'] = ! empty( $cart_items[ $key ] ) ? $cart_items[ $key ]['product_img'] : '';
			$cart_items[ $key ]['product_id'] = $item_line['attributes']['variant-id'] ?? '';
			$cart_items[ $key ]['item_price'] = $item_line['attributes']['price'] ?? '';
			$cart_items[ $key ]['item_quantity'] = $item_line['attributes']['quantity'] ?? '';
			$cart_items[ $key ]['item_total'] = $item_line['attributes']['total'] ?? 0;
			$cart_items[ $key ]['inventory'] = $item_line['attributes']['inventory'] ?? '';

			$cart_items[ $key ]['data_analytics']['id']            = $item_line['attributes']['variant-id'] ?? '';
			$cart_items[ $key ]['data_analytics']['name']          = $item_line['attributes']['name'] ?? '';
			$cart_items[ $key ]['data_analytics']['list_name']     = $item_line['attributes']['sku'] ?? '';
			$cart_items[ $key ]['data_analytics']['variant']       = $item_line['attributes']['name'] ?? '';
			$cart_items[ $key ]['data_analytics']['quantity']      = $item_line['attributes']['quantity'] ?? 0;
			$cart_items[ $key ]['data_analytics']['list_position'] = $item_line['attributes']['variant-id'] ?? '';
			$cart_items[ $key ]['data_analytics']['price']         = Prodigy_Formatting::prodigy_price_format( $item_line['attributes']['price'] ?? 0 );
		}

		$cart_items['common_number_of_items'] = $common_number_of_items;

		return $cart_items;
	}

}