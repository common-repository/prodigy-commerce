<?php

/**
 * Prodigy cart page class
 *
 * @version    2.7.0
 */
namespace Prodigy\Includes\Frontend\Pages;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Cart_Error_Handler;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Prodigy_Cart_Page
 */
class Prodigy_Cart_Page extends Prodigy_Page {

	const PAGE_NAME         = 'Cart';
	const FLATSOME_CART_URL = 'shopping-cart';
	const DEFAULT_CART_URL  = 'cart';


	/** @var Prodigy_Cart $cart */
	private $cart;

	/**
	 * @var Prodigy_Api_Client
	 */
	private $api_client;

	/** @var string */
	private $user_session;

	private $order_token;

	/**
	 * @var Prodigy_Order_Parser
	 */
	protected $order;

	/**
	 * @var Prodigy_Cache
	 */
	private $cache;


	/** @var Cart_Error_Handler */
	private $cart_error_handler;

	/**
	 * Prodigy_Cart_Page constructor.
	 *
	 * @throws \Exception
	 */
	public function __construct() {
		$this->cart               = new Prodigy_Cart();
		$this->api_client         = new Prodigy_Api_Client();
		$this->cache              = new Prodigy_Cache();
		$this->cart_error_handler = new Cart_Error_Handler();

		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_url( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		if ( isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) {
			$prodigy_user       = htmlspecialchars( $cart_cookie, ENT_QUOTES );
			$this->user_session = $prodigy_user;
		}

		$this->order_token = $this->cart->get_token_for_current_order( $this->user_session ?? '' );

		$current_uri = parse_url( $request_uri, PHP_URL_PATH );

		if ( substr_count( $current_uri, 'api-listener' ) ) {
			$this->callback_api_listener();
		}

		add_action( 'wp_ajax_prodigy-remote-get-template-cart', array( $this, 'prodigy_remote_get_template_cart' ) );
		add_action(
			'wp_ajax_nopriv_prodigy-remote-get-template-cart',
			array(
				$this,
				'prodigy_remote_get_template_cart',
			)
		);

		add_action( 'wp_head', array( $this, 'myplugin_ajaxurl' ) );
		add_action( 'wp_ajax_prodigy-add-remote-cart', array( $this, 'prodigy_add_product_to_remote_cart' ) );
		add_action( 'wp_ajax_nopriv_prodigy-add-remote-cart', array( $this, 'prodigy_add_product_to_remote_cart' ) );
		add_action( 'wp_ajax_prodigy-load-cart-data', array( $this, 'prodigy_get_cart_data_ajax' ) );
		add_action( 'wp_ajax_nopriv_prodigy-load-cart-data', array( $this, 'prodigy_get_cart_data_ajax' ) );
		add_action( 'wp_ajax_prodigy-remove-item-cart', array( $this, 'prodigy_ajax_remove_item_from_cart' ) );
		add_action( 'wp_ajax_nopriv_prodigy-remove-item-cart', array( $this, 'prodigy_ajax_remove_item_from_cart' ) );
		add_action( 'wp_ajax_prodigy-update-item-cart', array( $this, 'prodigy_update_cart' ) );
		add_action( 'wp_ajax_nopriv_prodigy-update-item-cart', array( $this, 'prodigy_update_cart' ) );
		add_action( 'wp_ajax_prodigy-check-empty-cart', array( $this, 'prodigy_check_empty_cart' ) );
		add_action( 'wp_ajax_nopriv_prodigy-check-empty-cart', array( $this, 'prodigy_check_empty_cart' ) );
		add_action(
			'wp_ajax_prodigy-is-replace-subscription-item',
			array(
				$this,
				'is_need_replace_subscription_item',
			)
		);
		add_action(
			'wp_ajax_nopriv_prodigy-is-replace-subscription-item',
			array(
				$this,
				'is_need_replace_subscription_item',
			)
		);
	}

	/**
	 * check subscription popup
	 */
	public function is_need_replace_subscription_item() {
		$result['show_subscription_popup'] = false;
		$remote_product_id                 = isset( $_POST['remote_product_id'] ) ? sanitize_key( wp_unslash( $_POST['remote_product_id'] ) ) : '';
		$subscription_id                   = isset( $_POST['subscription_id'] ) ? sanitize_key( wp_unslash( $_POST['subscription_id'] ) ) : '';
		$one_time_order                    = isset( $_POST['one_time_order'] ) ? sanitize_key( wp_unslash( $_POST['one_time_order'] ) ) : '';
		if ( isset( $this->order_token ) ) {
			$order_data                        = Prodigy_Request_Maker::get_instance()->do_order_request( $this->order_token );
			$this->order                       = new Prodigy_Order_Parser( $order_data );
			$exist_items                       = $this->order->get_line_items();
			$result['show_subscription_popup'] = false;

			foreach ( $exist_items as $item ) {
				if ( ! empty( $remote_product_id ) && $remote_product_id == $item['attributes']['variant-id'] ) {
					if (
						isset( $item['subscriptions']['id'] ) &&
						$subscription_id !== $item['subscriptions']['id'] &&
						$one_time_order !== 'true'
					) {
						$result['show_subscription_popup'] = true;
						echo wp_json_encode( $result );
						wp_die();
					}

					if ( ! isset( $item['subscriptions'] ) && ! empty( $subscription_id ) ) {
						$result['show_subscription_popup'] = true;
						echo wp_json_encode( $result );
						wp_die();
					}

					if ( isset( $item['subscriptions']['id'] ) && $subscription_id == $item['subscriptions']['id'] ) {
						$result['show_subscription_popup'] = false;
						echo wp_json_encode( $result );
						wp_die();
					}

					if (
						( ! isset( $item['subscriptions']['id'] ) && $one_time_order == 'false' ) ||
						( isset( $item['subscriptions']['id'] ) && $one_time_order == 'true' ) ||
						( isset( $item['subscriptions']['id'] ) && $subscription_id == $item['subscriptions']['id'] )
					) {
						$result['show_subscription_popup'] = true;
						echo wp_json_encode( $result );
						wp_die();
					}
				} else {
					$result['show_subscription_popup'] = false;
				}
			}
		}

		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * Check product by removed
	 */
	public function prodigy_check_empty_cart() {
		$products = get_option( 'prodigy_cart_removed_products' );

		echo wp_json_encode( empty( $cart_items_in_cart_table ) && empty( $products ) );
		wp_die();
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

		if ( $line_item_response['code'] === \WP_Http::NO_CONTENT ) {
			$update_order = $this->update_order_data();
			$this->cache->reset_order( $this->order_token );
			if ( ! $update_order ) {
				$this->cart_error_handler->log_error( sprintf( __( 'Order is not updated for product %s', 'prodigy' ), $remote_id ) );
				$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_ORDER_NOT_UPDATED );
			}
			wp_send_json_success();
		} elseif ( $line_item_response['code'] === \WP_Http::UNPROCESSABLE_ENTITY ) {
			$result['error']   = \WP_Http::UNPROCESSABLE_ENTITY;
			$result['message'] = $line_item_response['errors'][0]['detail'];
			wp_send_json_error( $result );
		} else {
			$this->cart_error_handler->log_error( $line_item_response->errors . __( 'Line item:', 'prodigy' ) . $line_item_id );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_SEND_PRODUCT_TO_API );
			wp_send_json_error( $result, \WP_Http::INTERNAL_SERVER_ERROR );
		}

		wp_die();
	}

	/**
	 * Ajax Remove item from cart
	 */
	public function prodigy_ajax_remove_item_from_cart() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'store-nonce' ) ) {
			return false;
		}

		$line_item_id = filter_var( wp_unslash( $_POST['line_item_id'] ), FILTER_VALIDATE_INT );
		$result       = $this->remove_line_item_from_cart( $line_item_id );

		echo wp_json_encode( $result );
		wp_die();
	}

	public function prodigy_get_cart_data_ajax() {
		$cart        = new Prodigy_Cart();
		$order_token = $cart->get_token_for_current_order( sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ?? '' ) );

		if ( $order_token ) {
			$order_data        = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$remote_order_info = new Prodigy_Order_Parser( $order_data );
			$cart_items        = $remote_order_info->get_line_items();
			$order_attributes  = $remote_order_info->get_attributes();
		}

		$cart_products = array();
		$count_items   = 0;

		if ( ! empty( $cart_items ) ) {
			foreach ( $cart_items as $key => $item ) {
				$remote_product_id = $item['attributes']['variant-id'];
				$quantity          = $item['attributes']['quantity'];
				$actual_price      = $item['attributes']['price'];
				$image_url         = $item['attributes']['image-url'];
				$name              = $item['attributes']['name'];

				$local_parent_product_info = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, (int) $item['attributes']['product-id'] );
				$local_parent_product_id   = $local_parent_product_info->post_id ?? 0;
				$option_variants           = $item['attributes']['options'];

				$cart_products[ $key ]                            = $item;
				$cart_products[ $key ]['remote_product_id']       = $remote_product_id;
				$cart_products[ $key ]['count_items']             = $quantity;
				$cart_products[ $key ]['actual_price']            = $actual_price;
				$cart_products[ $key ]['image_url']               = $image_url;
				$cart_products[ $key ]['name']                    = $name;
				$cart_products[ $key ]['local_parent_product_id'] = $local_parent_product_id;
				$cart_products[ $key ]['option_variants']         = $option_variants;
				$cart_products[ $key ]['logo_options']            = $item['attributes']['logos'];

				$count_items += $quantity;
			}
		}

		$cart_content = Prodigy_Template::prodigy_get_template_html(
			'cart-items.php',
			array(
				'cart_products' => $cart_products,
				'is_dropdown'   => true,
				'total_price'   => $order_attributes['total'] ?? 0,
			)
		);
		$result       = array(
			'cart_items'       => $cart_content,
			'cart_items_count' => $count_items,
			'total_price'      => $order_attributes['total'] ?? 0,
			'status'           => 'success',
		);
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

		if ( isset( $_POST['is_bulk'] ) ) {
			$is_bulk_option = sanitize_key( wp_unslash( $_POST['is_bulk'] ) );
			$is_bulk        = filter_var( $is_bulk_option, FILTER_VALIDATE_BOOLEAN );
		}

		$is_subscription_replaced = false;
		if ( isset( $_POST['is_subscription_replaced'] ) ) {
			$is_subscription_replaced_parameter_ = sanitize_key( wp_unslash( $_POST['is_subscription_replaced'] ) );
			$is_subscription_replaced            = filter_var( $is_subscription_replaced_parameter_, FILTER_VALIDATE_BOOLEAN );
		}

		if ( $is_subscription_replaced && isset( $this->order_token ) ) {
			$order_data  = Prodigy_Request_Maker::get_instance()->do_order_request( $this->order_token );
			$this->order = new Prodigy_Order_Parser( $order_data );
			$cart_items  = $this->order->get_line_items();
			foreach ( $cart_items as $line_item ) {
				if ( isset( $_POST['remote_product_id'] ) && $line_item['attributes']['variant-id'] == $_POST['remote_product_id'] ) {
					$this->remove_line_item_from_cart( $line_item['id'] );
				}
			}
		}

		$remote_product_id = null;
		if ( isset( $_POST['remote_product_id'] ) ) {
			$remote_product_id = filter_var( sanitize_text_field( wp_unslash( $_POST['remote_product_id'] ) ), FILTER_VALIDATE_INT );
		}

		if ( isset( $this->user_session ) && ! empty( $remote_product_id ) ) {
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

			if ( empty( $is_empty_cart ) && ! empty( $this->order_token ) ) {
				unset( $request['order_token'] );
				$this->cart->delete_local_order( $this->order_token );
			}

			$cart_response = Prodigy_Request_Maker::get_instance()->do_init_order_request( $request );
			do_action(
				'logger',
				array(
					'path'          => __LINE__ . __METHOD__ . __CLASS__,
					'cart_response' => $cart_response,
				),
				'info'
			);

		} elseif ( $is_bulk ) {
			if ( isset( $this->order_token ) ) {
				$request = $this->cart->set_cart_prepare_request( $_POST, $this->order_token );
			} else {
				$request = $this->cart->set_cart_prepare_request( $_POST );
			}

			$cart_response = Prodigy_Request_Maker::get_instance()->do_init_order_request( $request );
		} else {
			$this->cart_error_handler->log_error( sprintf( __( 'Do not set item in %1$s or product %2$s', 'prodigy' ), $this->user_session, $remote_product_id ) );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_ADD_ITEM_TO_ORDER );
		}

		if ( isset( $cart_response['errors'] ) ) {
			if ( $cart_response['code'] === \WP_Http::UNPROCESSABLE_ENTITY ) {
				$result['message']    = $cart_response['errors'][0]['detail'];
				$result['error_code'] = \WP_Http::UNPROCESSABLE_ENTITY;
				wp_send_json_error( $result['message'], $result['error_code'] );
			}

			$this->cart_error_handler->log_error( $cart_response['errors'][0]['detail'] . ' ' . __( 'Token:', 'prodigy' ) . $this->order_token );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_INIT_ORDER_ERROR );
		} elseif ( empty( $cart_response ) ) {
			$this->cart_error_handler->log_error( __( 'Init order error for token:', 'prodigy' ) . $this->order_token );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_CART_RESPONSE_EMPTY );
		} else {
			// if check current order
			$this->updateOrder( $cart_response );
		}

		if ( ! isset( $result['error'] ) ) {
			$result['status'] = 'success';
		}

		echo wp_json_encode( $result );
		wp_die();
	}


	public function updateOrder( $cart_response ) {
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


	/**
	 * @throws \Exception
	 */
	public function callback_api_listener() {
		$order_token      = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( $_GET['token'] ) ) : '';
		$redemption_store = isset( $_GET['redemption_store'] ) ? sanitize_key( wp_unslash( $_GET['redemption_store'] ) ) : '';

		if ( isset( $order_token ) ) {
			if ( ! isset( $this->user_session ) ) {
				$order = $this->cart->get_in_process_order_for_token( $order_token );
				if ( ! empty( $order ) ) {
					$this->cart->set_user_session( $order['local_user_hash'] );
				}
			}

			$api_url        = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::ORDER_URL . $order_token . '?include=line-items';
			$order_response = $this->api_client->get_remote_content( $api_url );
			$order_response = json_decode( wp_remote_retrieve_body( $order_response ), true );

			if ( ! empty( $order_response ) ) {
				if ( $order_response['data']['attributes']['checkout-state'] === 'confirmation' ) {
					/**
					 * update status to completed
					 */
					$this->cart->update_status_orders(
						$order_token,
						Prodigy_Cart::PRODIGY_ORDER_COMPLETED
					);

					$redirect_url = Prodigy_Page::prodigy_get_thank_url() . '?order_token=' . $order_token;
				} elseif ( $order_response['data']['attributes']['checkout-state'] === 'payment' && isset( $_GET['approval-needed'] ) ) {
					/**
					 * update status to completed
					 */
					$this->cart->update_status_orders(
						$order_token,
						Prodigy_Cart::PRODIGY_ORDER_COMPLETED
					);

					$redirect_url = Prodigy_Page::prodigy_get_thank_url() . '?order_token=' . $order_token . '&approval-needed=true';
				} else {
					$redirect_url = Prodigy_Page::prodigy_get_cart_url() . '?order_token=' . $order_token;
				}
				wp_safe_redirect( $redirect_url );
				exit;
			}
			$redirect_url = Prodigy_Page::prodigy_get_thank_url() . '?order_token=' . $order_token;

			if ( $order_token && $redemption_store ) {
				$redirect_url = add_query_arg( 'is_redemption_store', $redemption_store, $redirect_url );
			}

			wp_safe_redirect( $redirect_url );
			exit;
		}
	}


	/**
	 * check empty cart
	 *
	 * @return array
	 * @version 2.0.0
	 */
	public function is_line_items() {
		$cart        = new Prodigy_Cart();
		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';
		$order_token = $cart->get_token_for_current_order( $cart_cookie );

		$items = array();
		if ( $order_token ) {
			$order_data = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$order      = new Prodigy_Order_Parser( $order_data );
			$items      = $order->get_line_items();
		}

		return $items;
	}

	/**
	 *  Set ajaxurl path
	 */
	public function myplugin_ajaxurl() {
		echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
         </script>';
	}


	/**
	 * @param int $line_item_id
	 *
	 * @return array
	 */
	private function remove_line_item_from_cart( int $line_item_id ): array {
		$result = array();
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

		if ( ! isset( $delete_remote_product['errors'] ) ) {
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
				if ( isset( $delete_order['errors'] ) ) {
					$error_message = $delete_order['errors'] ?? 'Delete order error';
					$this->cart_error_handler->log_error( $error_message );
					$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_API_ORDER_NOT_DELETED );
				} elseif ( isset( $this->order_token ) ) {
					$this->cart->delete_local_order( $this->order_token );
				}
			}

			if ( isset( $this->order_token ) ) {
				$this->cache->reset_order( $this->order_token );
			}
		} elseif ( $delete_remote_product['code'] === \WP_Http::UNPROCESSABLE_ENTITY ) {
			$result['error']   = \WP_Http::UNPROCESSABLE_ENTITY;
			$result['message'] = $delete_remote_product['errors'][0]['detail'];
			wp_send_json_error( $result );
		} else {
			$this->cart_error_handler->log_error( $delete_remote_product['errors'], Cart_Error_Handler::ERROR_TYPE_DB );
			$result['error'] = $this->cart_error_handler->get_error_message_for_response( Cart_Error_Handler::ERROR_DELETE_ITEM_FROM_DB );
		}

		return $result;
	}

	/**
	 * @return bool
	 */
	public function update_order_data(): bool {
		$api_url    = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::ORDER_URL . $this->order_token . '?include=line-items';
		$order_data = $this->api_client->get_remote_content( $api_url );

		$result = false;
		if ( ! empty( $order_data ) ) {
			$result = $this->cart->update_order_data_in_storage( $this->order_token, $this->user_session, (array) wp_json_encode( $order_data ) );
		}

		if ( (bool) $result ) {
			$this->cache->reset_order( $this->order_token );
		}

		return (bool) $result;
	}

	/**
	 * Cart page generate html
	 *
	 * @version 2.0.0
	 */
	public function prodigy_remote_get_template_cart() {
		$cart        = new Prodigy_Cart();
		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';
		$order_token = $cart->get_token_for_current_order( $cart_cookie );

		if ( $order_token ) {
			$order_data          = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$remote_order_info   = new Prodigy_Order_Parser( $order_data );
			$rr                  = $remote_order_info->get_line_items();
			$up_sell_product_ids = $remote_order_info->get_cross_sell_products();
			$up_sell_product_ids = get_format_related_products( $up_sell_product_ids );
		}
		/**
		 * empty cart
		 */
		if ( ! isset( $rr ) ) {
			wp_send_json_error();
		}

		$params['display']  = 'slider';
		$params['products'] = $up_sell_product_ids ?? '';

		/**
		 * get template for ajax render container cart
		 */
		$result = array(
			'cart'                   => Prodigy_Template::prodigy_get_template_html( 'shortcode/pages/cart/item.php', array( $params ) ),
			'cross_products'         => Prodigy_Template::prodigy_get_template_html( 'shortcode/related-slider-products.php', $params ),
			'is_show_cross_products' => (bool) $up_sell_product_ids ?? '',
		);

		wp_send_json_success( $result );
	}
}
