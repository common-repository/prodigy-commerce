<?php
namespace Prodigy\Includes\Frontend\Shortcodes\Pages;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Cart_Error_Handler;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy cart page shortcode class
 *
 * @version    2.7.0
 */
class Prodigy_Short_Code_Cart_Page {

	/**
	 * Shortcode name
	 *
	 * @var string
	 */
	const NAME = 'prodigy_cart';


	/** @var Prodigy_Cart  */
	private $cart;

	/** @var Prodigy_Order_Parser  */
	protected $order;

	/** @var Prodigy_Api_Client */
	protected $api_client;

	protected $order_token;

	/** @var Prodigy_Cache  */
	protected $cache;

	/** @var Cart_Error_Handler */
	private $cart_error_handler;

	/**
	 * Prodigy_Short_Code_Cart_Page constructor.
	 */
	public function __construct() {
		$this->cart               = new Prodigy_Cart();
		$this->api_client         = new Prodigy_Api_Client();
		$this->order_token        = $this->cart->get_token_for_current_order( $this->user_session ?? '' );
		$this->cache              = new Prodigy_Cache();
		$this->cart_error_handler = new Cart_Error_Handler();
		add_shortcode( self::NAME, array( $this, 'output' ) );
	}

	/**
	 *
	 * @return array
	 */
	public function is_line_items(): array {
		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';

		if ( empty( $cart_cookie ) ) {
			return array();
		}

		$cart        = new Prodigy_Cart();
		$order_token = $cart->get_token_for_current_order( $cart_cookie );

		if ( ! $order_token ) {
			return array();
		}

		$order_data = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );

		return ( new Prodigy_Order_Parser( $order_data ) )->get_line_items();
	}


	/**
	 * @return string
	 */
	public function output(): string {
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
		ob_start();
		do_action( 'prodigy_get_template_cart_page', array( 'is_quantity_title' => false ) );

		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}


	/**
	 * @param int $line_item_id
	 *
	 * @return array
	 */
	private function remove_line_item_from_cart( int $line_item_id ): array {
		$result               = array();
		$is_empty_cart_before = $this->is_line_items();

		do_action(
			'logger',
			array(
				'path'                 => __LINE__ . __METHOD__ . __CLASS__,
				'is_empty_cart_before' => $is_empty_cart_before ?? '',
			),
			'info'
		);

		if ( isset( $this->order_token, $line_item_id ) ) {
			$api_url               = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::LINE_ITEM_URL . $line_item_id . '?order_token=' . $this->order_token;
			$delete_remote_product = $this->api_client->delete_remote_content( $api_url );
		}

		do_action(
			'logger',
			array(
				'path'                  => __LINE__ . __METHOD__ . __CLASS__,
				'delete_remote_product' => $delete_remote_product ?? '',
			),
			'info'
		);

		if ( ! isset( $delete_remote_product->errors ) ) {
			$is_empty_cart = $this->is_line_items();

			do_action(
				'logger',
				array(
					'path'          => __LINE__ . __METHOD__ . __CLASS__,
					'is_empty_cart' => $is_empty_cart,
				),
				'info'
			);

			if ( empty( $is_empty_cart ) ) {
				$api_url      = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::ORDER_URL . $this->order_token;
				$delete_order = $this->api_client->delete_remote_content( $api_url );
				if ( isset( $delete_order->errors ) || $delete_order === false ) {
					$error_message = $delete_order->errors ?? 'Delete order error';
					$status        = $delete_order->errors ?? 'error';
					$this->cart_error_handler->log_error( $error_message );
					$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_API_ORDER_NOT_DELETED );
				} elseif ( isset( $this->order_token ) ) {
					$this->cart->delete_local_order( $this->order_token );
				}
			}

			if ( isset( $this->order_token ) ) {
				$this->cache->reset_order( $this->order_token );
			}
		} else {
			$this->cart_error_handler->log_error( $delete_remote_product->errors, Cart_Error_Handler::ERROR_TYPE_DB );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_DELETE_ITEM_FROM_DB );
		}

		return $result;
	}

	/**
	 * Ajax Remove item from cart
	 */
	public function prodigy_ajax_remove_item_from_cart() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'store-nonce' ) ) {
			return false;
		}

		$line_item_id = isset( $_POST['line_item_id'] ) ? sanitize_key( wp_unslash( $_POST['line_item_id'] ) ) : '';
		$result       = $this->remove_line_item_from_cart( $line_item_id );

		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * @return string
	 */
	public function update_order_data() {
		$api_url    = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::ORDER_URL . $this->order_token . '?include=line-items';
		$order_data = $this->api_client->get_remote_content( $api_url );

		$result = false;
		if ( ! empty( $order_data ) ) {
			$result = $this->cart->update_order_data_in_storage( $this->order_token, $this->user_session, wp_json_encode( $order_data ) );
		}

		if ( (bool) $result ) {
			$this->cache->reset_order( $this->order_token );
		}

		return (bool) $result;
	}

	/**
	 * Update cart
	 */
	public function prodigy_update_cart() {

		$line_item_id = isset( $_POST['line_item_id'] ) ? sanitize_key( wp_unslash( $_POST['line_item_id'] ) ) : '';
		$remote_id    = isset( $_POST['remote_id'] ) ? sanitize_key( wp_unslash( $_POST['remote_id'] ) ) : '';
		$count        = isset( $_POST['count'] ) ? sanitize_key( wp_unslash( $_POST['count'] ) ) : '';

		$result                                   = null;
		$remote_product_data['remote_product_id'] = $remote_id;
		$remote_product_data['token']             = $this->order_token;
		$remote_product_data['count']             = $count;
		update_option( 'current_order', $this->order_token );

		$line_item_request  = $this->cart->prepare_line_item_request( $remote_product_data, $count );
		$api_url            = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::LINE_ITEM_URL . $line_item_id;
		$line_item_response = $this->api_client->patch_remote_content(
			$api_url,
			$line_item_request
		);

		if ( ! isset( $line_item_response->errors ) ) {

			$update_order = $this->update_order_data();
			$this->cache->reset_order( $this->order_token );
			if ( ! $update_order ) {
				$this->cart_error_handler->log_error( sprintf( __( 'Order is not updated for product %s', 'prodigy' ), $remote_id ) );
				$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_ORDER_NOT_UPDATED );
			}
		} else {
			$this->cart_error_handler->log_error( $line_item_response->errors . __( 'Line item:', 'prodigy' ) . $line_item_id );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_SEND_PRODUCT_TO_API );
		}

		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * Send query to hosted system
	 */
	public function prodigy_add_product_to_remote_cart() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'store-nonce' ) ) {
			return false;
		}

		$is_subscription_replaced = isset( $_POST['is_subscription_replaced'] ) ? sanitize_key( wp_unslash( $_POST['is_subscription_replaced'] ) ) : '';

		if ( $is_subscription_replaced && isset( $this->order_token ) ) {
			$order_data = Prodigy_Request_Maker::get_instance()->do_order_request( $this->order_token );
			$cart_items = new Prodigy_Order_Parser( $order_data );

			foreach ( $cart_items as $line_item ) {
				if ( isset( $_POST['remote_product_id'] ) && $line_item->attributes->{'variant-id'} == $_POST['remote_product_id'] ) {
					$this->remove_line_item_from_cart( $line_item->id );
				}
			}
		}

		$remote_product_id = null;
		if ( isset( $_POST['remote_product_id'] ) ) {
			$remote_product_id = filter_var( sanitize_text_field( wp_unslash( $_POST['remote_product_id'] ) ), FILTER_VALIDATE_INT );
		}

		if ( isset( $this->user_session ) && isset( $remote_product_id ) && ! empty( $remote_product_id ) ) {
			if ( isset( $this->order_token ) ) {
				$is_order_deleted = $this->cart->is_deleted_order( $this->order_token );

				if ( $is_order_deleted ) {
					$request = $this->cart->set_cart_prepare_request( $_POST );
				} else {
					$request = $this->cart->set_cart_prepare_request( $_POST, $this->order_token );
				}
			} else {
				$request = $this->cart->set_cart_prepare_request( $_POST );
			}

			do_action(
				'logger',
				array(
					'path'    => __LINE__ . __METHOD__ . __CLASS__,
					'request' => $request,
				),
				'info'
			);

			$is_empty_cart = $this->is_line_items();

			if ( empty( $is_empty_cart ) && isset( $this->order_token ) && ! empty( $this->order_token ) ) {
				unset( $request['order_token'] );
				$this->cart->delete_local_order( $this->order_token );
			}

			/* init order and push item in current order */
			$api_url       = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::CART_URL;
			$cart_response = $this->api_client->patch_remote_content( $api_url, $request );
			do_action(
				'logger',
				array(
					'path'          => __LINE__ . __METHOD__ . __CLASS__,
					'cart_response' => $cart_response,
				),
				'info'
			);
			if ( isset( $cart_response->errors ) ) {
				$this->cart_error_handler->log_error( $cart_response->errors . ' ' . __( 'Token:', 'prodigy' ) . $this->order_token );
				$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_INIT_ORDER_ERROR );
			} elseif ( empty( $cart_response ) ) {
				$this->cart_error_handler->log_error( __( 'Init order error for token:', 'prodigy' ) . $this->order_token );
				$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_CART_RESPONSE_EMPTY );
			} else {
				// if check current order
				if ( isset( $this->order_token ) ) {
					$is_order_deleted = $this->cart->is_deleted_order( $this->order_token );

					if ( $is_order_deleted ) {
						$save_order = $this->cart->create_order( $cart_response, $this->user_session );
						$this->cache->reset_order( $this->order_token );
						if ( ! $save_order ) {
							$this->cart_error_handler->log_error( __( 'Do not add product to the cart, empty user session ', 'prodigy' ) . $this->cart->order_data_table );
							$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_SET_ORDER );
						}
					}
				}

				if ( ! isset( $this->order_token ) ) {
					$save_order = $this->cart->create_order( $cart_response, $this->user_session );
					if ( ! $save_order ) {
						$this->cart_error_handler->log_error( __( 'Do not add product to the cart, empty user session ', 'prodigy' ) . $this->cart->order_data_table );
						$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_SET_ORDER );
					}
				}

				if ( isset( $this->order_token ) ) {
					$this->update_order_data();
					$this->cache->reset_order( $this->order_token );
				}
			}
		} else {
			$this->cart_error_handler->log_error( sprintf( __( 'Do not set item in %1$s or product %2$s', 'prodigy' ), $this->user_session, $remote_product_id ) );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_ADD_ITEM_TO_ORDER );
		}

		if ( ! isset( $result['error'] ) ) {
			$result['status'] = 'success';
		}

		echo wp_json_encode( $result );
		wp_die();
	}

	public function prodigy_get_cart_data_ajax() {
		defined( 'ABSPATH' ) || exit;
		$cart        = new Prodigy_Cart();
		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';
		$order_token = $cart->get_token_for_current_order( $cart_cookie );

		$cart_items = array();
		if ( $order_token ) {
			$order_data        = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$remote_order_info = new Prodigy_Order_Parser( $order_data );
			$cart_items        = $remote_order_info->get_line_items();
		}

		$cart_products = array();
		$count_items   = 0;
		$total_price   = 0;

		if ( ! empty( $cart_items ) ) {
			foreach ( $cart_items as $item ) {

				$remote_product_id = $item->attributes->{'variant-id'};
				$quantity          = $item->attributes->{'quantity'};
				$actual_price      = $item->attributes->{'price'};
				$item_total        = $item->attributes->{'total'};
				$image_url         = $item->attributes->{'image-url'};
				$name              = $item->attributes->{'name'};

				$local_parent_product_info = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, (int) $item->attributes->{'product-id'} );
				$local_parent_product_id   = $local_parent_product_info->post_id;
				$option_variants           = $item->attributes->options;

				$cart_products[ $remote_product_id ]                          = new stdClass();
				$cart_products[ $remote_product_id ]->remote_product_id       = $remote_product_id;
				$cart_products[ $remote_product_id ]                          = $item;
				$cart_products[ $remote_product_id ]->count_items             = $quantity;
				$cart_products[ $remote_product_id ]->actual_price            = $actual_price;
				$cart_products[ $remote_product_id ]->total_price             = $item_total;
				$cart_products[ $remote_product_id ]->image_url               = $image_url;
				$cart_products[ $remote_product_id ]->name                    = $name;
				$cart_products[ $remote_product_id ]->local_parent_product_id = $local_parent_product_id;
				$cart_products[ $remote_product_id ]->option_variants         = $option_variants;

				$count_items += $quantity;
				$total_price += $item_total;
			}
		}

		$cart_content = Prodigy_Template::prodigy_get_template_html(
			'cart-items.php',
			array(
				'cart_products' => $cart_products,
				'is_dropdown'   => true,
				'total_price'   => $total_price,
			)
		);

		$result = array(
			'cart_items'       => $cart_content,
			'cart_items_count' => $count_items,
			'total_price'      => $total_price,
			'status'           => 'success',
		);
		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 *  Set ajaxurl path
	 */
	public function myplugin_ajaxurl() {
		echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
         </script>';
	}
}
