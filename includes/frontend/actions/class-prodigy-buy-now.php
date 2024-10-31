<?php
namespace Prodigy\Includes\Frontend\Actions;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\Includes\Prodigy_User;

/**
 * Prodigy buy now action
 *
 * @version    3.0.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Buy_Now {

	/** @var int  */
	const NUMBER_OF_ITEMS = 1;

	/** @var Prodigy_Api_Client $api_client */
	private $api_client;

	/** @var Prodigy_User $user */
	private $user;

	/**
	 * @param Prodigy_Api_Client $api_client
	 * @param Prodigy_User       $user
	 */
	public function __construct( Prodigy_Api_Client $api_client, Prodigy_User $user ) {
		$this->api_client = $api_client;
		$this->user       = $user;

		add_action( 'init', array( $this, 'custom_url_structure' ), 999 );
		add_action( 'template_redirect', array( $this, 'custom_action_listener' ), 999 );
		add_filter( 'query_vars', array( $this, 'custom_query_vars' ), 999 );
	}

	/**
	 * Add rewrite rule for the custom URL structure (buy-now?product-id)
	 *
	 * @return void
	 */
	public function custom_url_structure() {
		add_rewrite_rule( '^buy-now/?', 'index.php?custom_action=buy_now', 'top' );
		flush_rewrite_rules();
	}

	/**
	 * @param array $vars
	 *
	 * @return array
	 */
	public function custom_query_vars( array $vars ): array {
		$vars[] = 'custom_action';
		return $vars;
	}

	/**
	 * @throws \Exception
	 */
	public function custom_action_listener() {
		$custom_action = get_query_var( 'custom_action' );
		if ( $custom_action === 'buy_now' && isset( $_GET['product-id'] ) ) {
			$product_id = filter_var( wp_unslash( $_GET['product-id'] ), FILTER_VALIDATE_INT );

			$product_data   = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $product_id );
			$product        = new Prodigy_Product_Parser( $product_data );
			$master_variant = $product->get_master_variant();

			$user_session = '';
			if ( isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) {
				$user_session = sanitize_key( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) );
			}

			$cart        = new Prodigy_Cart();
			$order_token = $cart->get_token_for_current_order( $user_session );

			if ( $order_token !== null ) {
				$api_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::ORDER_URL . $order_token;
				$this->api_client->delete_remote_content( $api_url );
			}

			$item['remote_product_id'] = $master_variant['id'];
			$item['count']             = self::NUMBER_OF_ITEMS;
			$request                   = $cart->set_cart_prepare_request( $item );

			$cart_response = Prodigy_Request_Maker::get_instance()->do_init_order_request( $request );
			if ( ! isset( $cart_response['errors'] ) ) {
				$cart->create_order( $cart_response, $user_session );
				$order_token = $cart_response['data']['attributes']['token'];
			} elseif ( $cart_response['code'] !== \WP_Http::OK ) {
				wp_safe_redirect( home_url( '404' ) );
				exit;
			}

			$order        = Prodigy_Cart::get_order_includes( $order_token );
			$checkout_url = Prodigy_Cart::get_checkout_url( $order, $order_token );

			wp_safe_redirect( $checkout_url );
			exit;
		}
	}
}
