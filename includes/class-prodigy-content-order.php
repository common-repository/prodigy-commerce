<?php

namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Content_Order
 *
 * @version 2.0.0
 */
class Prodigy_Content_Order extends Prodigy_Main_Content {

	const REMOTE_TYPE_LINE_ITEMS = 'line-items';

	const CHECKOUT_STATE_CONFIRMATION = 'confirmation';

	/**
	 * @var $order
	 */
	private $order;

	/**
	 * Status order
	 *
	 * @var string $checkout_state
	 */
	private $checkout_state;

	/**
	 * @param string $order_token
	 */
	public function initOrder( string $order_token ) {
		$order = $this->cache->get_order( $order_token );
		if ( ! empty( $order ) ) {
			$this->order = $order;
		} else {
			$order_url       = prodigy_is_frontend() ? Prodigy_Api_Client::ORDER_URL : Prodigy_Api_Client::ORDER_ADMIN_URL;
			$api_url         = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $order_url . '/' . $order_token;
			$request_url     = add_query_arg( array( 'include' => 'line-items.subscription-condition,cross-sell-products,up-sell-products' ), $api_url );
			$obj_remote      = $this->api_client->get_remote_content( $request_url );
			$body            = wp_remote_retrieve_body( $obj_remote );
			$obj_data_remote = json_decode( $body, 1 );
			$this->cache->set_order( $order_token, $obj_data_remote ?? array() );
			$this->order = $obj_data_remote;
		}

		$this->checkout_state = isset( $this->order['data'] ) ? $this->order['data']['attributes']['checkout-state'] : '';
	}

	/**
	 * @return array
	 */
	public function getUpSellProducts() {
		return $this->get_up_sell_products_main( $this->order ?? array() );
	}

	/**
	 * @return array
	 */
	public function getSubscriptions( $product_id = '' ) {
		$conditions_data = array();
		if ( isset( $this->order['data']['relationships'] ) ) {
			if ( isset( $this->order['data']['relationships'] ) && ! empty( $this->order['data']['relationships'] ) ) {
				$data_parse       = $this->order['data']['relationships'][self::REMOTE_TYPE_LINE_ITEMS];
				$id_relationships = wp_list_pluck( $data_parse->data, 'id', 'id' );
			}
			$result = $this->parse_included_obj_by_ids( $this->order, $id_relationships );
			foreach ( $this->order['data']['relationships']['line-items'] as $key => $relationship ) {
				foreach ( $relationship->data as $key => $variant ) {
					if ( $product_id == $variant->id ) {
						$product_id = $variant->id;
					}
					break;
				}
			}
		}

		return $conditions_data;
	}

	/**
	 * @param $id
	 *
	 * @param $type
	 *
	 * @return array
	 */
	protected function parseIncludedById( $id, $type = false ) {
		$remote_included = $this->product->included ?? null;
		$data            = array();
		if ( ! empty( $remote_included ) ) {
			foreach ( $remote_included as $remote_include ) {

				if ( ! empty( $type ) ) {
					if ( $remote_include->id == $id && $remote_include->type == $type ) {
						$data = $remote_include;
					}
				} else {
					if ( $remote_include->id == $id ) {
						$data = $remote_include;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	public function getCrossSellProducts() {
		return $this->get_cross_sell_products_main( $this->order ?? array() );
	}

	/**
	 * @return array
	 */
	public function getLineItems() {
		$id_relationships = array();

		if ( isset( $this->order['data']['relationships'] ) && ! empty( $this->order['data']['relationships'] ) ) {
			$data_parse       = $this->order['data']['relationships'][self::REMOTE_TYPE_LINE_ITEMS];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		if ( $this->checkout_state == self::CHECKOUT_STATE_CONFIRMATION ) {
			$info_include = array();
		} else {
			$info_include = $this->parse_included_obj_by_ids( $this->order, $id_relationships, self::REMOTE_TYPE_LINE_ITEMS );
		}

		foreach ( $info_include as $key => $item ) {
			foreach ( $this->order['included'] as $included_item ) {
				if ( isset( $item['relationships']['subscription-condition']['data']['id'] ) ) {
					if ( $item['relationships']['subscription-condition']['data']['id'] === $included_item['id'] ) {
						$info_include[ $key ]['subscriptions'] = $included_item;
					}
				}
			}
		}

		return $info_include;
	}

	/**
	 * @return false|object
	 */
	public function getAttributes() {
		return $this->order['data']['attributes'] ?? false;
	}

	/**
	 * @return bool
	 */
	public function isOrderItemDeleted() {
		$result = false;
		if ( isset( $this->order['data']['attributes'] ) && $this->order['data']['attributes']['item-was-deleted'] ) {
			$result = true;
		}

		return $result;
	}

}
