<?php
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\Includes\Prodigy_User;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy cart shortcode class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Short_Code_Cart {

	/**
	 * Shortcode name
	 *
	 * @var string
	 */
	const NAME = 'prodigy_cart_widget';

	/**
	 * @var Prodigy_Cache
	 */
	public $cache;

	/** @var Prodigy_User */
	public $user;

	/** @var Prodigy_Api_Client */
	public $api_client;

	/** @var Prodigy_Cookies */
	public $cookie_helper;

	/** @var Prodigy_Cart */
	public $cart;

	/**
	 * String to bool mapper
	 *
	 * @var array
	 */
	public $cart_dropdown_mapper = array(
		'false' => false,
		'true'  => true,
	);

	/**
	 * Set hooks
	 */
	public function __construct() {
		$this->api_client    = new Prodigy_Api_Client();
		$this->cookie_helper = new Prodigy_Cookies();
		$this->cache         = new Prodigy_Cache();
		$this->user          = new Prodigy_User( $this->api_client, $this->cookie_helper );
		$this->cart          = new Prodigy_Cart();
		add_action( 'wp_ajax_prodigy-get-checkout-url', array( $this, 'prodigy_generate_checkout_url' ) );
		add_action( 'wp_ajax_nopriv_prodigy-get-checkout-url', array( $this, 'prodigy_generate_checkout_url' ) );

		add_shortcode( self::NAME, array( $this, 'output' ) );
	}


	/**
	 * @throws \Exception
	 */
	public function prodigy_generate_checkout_url() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}

		$cart_cookie = isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '';
		if ( ! empty( $cart_cookie ) ) {
			$prodigy_user = htmlspecialchars( $cart_cookie, ENT_QUOTES );
		}

		$order_token             = $this->cart->get_token_for_current_order( $prodigy_user ?? '' );
		$order                   = Prodigy_Cart::get_order_includes( $order_token );
		$options['checkout_url'] = Prodigy_Cart::get_checkout_url( $order, $order_token );

		wp_send_json_success( $options );
	}

	/**
	 * @param array $atts
	 *
	 * @return array
	 */
	public function set_widget_parameters( $atts ): array {
		$params = array();
		if ( isset( $atts['dropdown'] ) ) {
			$params['dropdown'] = $this->cart_dropdown_mapper[ $atts['dropdown'] ];
		}
		return $params;
	}

	/**
	 * @param array       $atts
	 * @param string|null $content
	 *
	 * @return false|string
	 */
	public function output( $atts, string $content = null ) {
		$attr = $this->set_widget_parameters( $atts );
		$this->render_view( $attr );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * @param array $atts
	 *
	 * @return void
	 */
	public function render_view( array $atts ): void {
		ob_start();
		do_action( 'prodigy_shortcode_template_cart', $atts );
		wp_reset_postdata();
	}
}
