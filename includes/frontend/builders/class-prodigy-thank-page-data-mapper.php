<?php
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;

/**
 * Prodigy thank you page data mapper
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Thank_Page_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$order_token = isset( $_GET['order_token'] ) ? filter_var( $_GET['order_token'], FILTER_UNSAFE_RAW ) : false;
		if ( $order_token ) {
			$order_data          = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$order_info          = new Prodigy_Order_Parser( $order_data );
			$attrs               = $order_info->get_attributes();
			$up_sell_product_ids = $order_info->get_cross_sell_products();
			$products            = get_format_related_products( $up_sell_product_ids );
		}

		return array(
			'up_sell_product_ids' => $products ?? [],
			'list_ids'            => '',
			'order_info'          => $order_info ?? '',
			'order_remote'        => $attrs['number'] ?? 'Test',
			'message'             => $options['heading_text'] ?? 'Thank you for your order.',
			'divi_editor'         => $options['divi_editor'] ?? false,
			'is_approval'         => isset( $_GET['approval-needed'] )
		);
	}
}