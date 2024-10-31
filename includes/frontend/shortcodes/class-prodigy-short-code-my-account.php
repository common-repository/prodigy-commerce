<?php

namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy_User;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy my account shortcode class
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Short_Code_My_Account {

	/**
	 * Shortcode name
	 *
	 * @var string
	 */
	const NAME          = 'prodigy_my_account';
	const DEFAULT_TITLE = 'Account';

	/**
	 * Display type
	 *
	 * @var string
	 */
	const DISPLAY_DROPDOWN = 'dropdown';

	/**
	 * Display type
	 *
	 * @var string
	 */
	const DISPLAY_SLIDER = 'slider';

	/** @var Prodigy_User */
	public $user;

	/** @var Prodigy_Api_Client */
	public $api_client;

	/** @var Prodigy_Cookies */
	public $cookie_helper;

	/**
	 * String to bool mapper
	 *
	 * @var array
	 */
	public $type_mapper = array(
		'false' => false,
		'true'  => true,
	);

	/**
	 * Set hooks
	 */
	public function __construct() {
		$this->api_client    = new Prodigy_Api_Client();
		$this->cookie_helper = new Prodigy_Cookies();
		$this->user          = new Prodigy_User( $this->api_client, $this->cookie_helper );
		add_shortcode( self::NAME, array( $this, 'output' ) );

		add_action( 'wp_ajax_prodigy-user-logout', array( $this, 'launch_logout' ) );
		add_action( 'wp_ajax_nopriv_prodigy-user-logout', array( $this, 'launch_logout' ) );

		add_action( 'wp_ajax_prodigy-user-login', array( $this, 'user_login' ) );
		add_action( 'wp_ajax_nopriv_prodigy-user-login', array( $this, 'user_login' ) );
	}

	/**
	 * @throws \Exception
	 */
	public function user_login() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}

		$options['login_url'] = Prodigy_User::get_hosted_system_login_url();
		wp_send_json_success( $options );
	}

	/**
	 * @return void
	 */
	public function launch_logout() {
		$this->user->logout();
		wp_send_json_success( array( 'success' => true ) );
	}

	/**
	 * @param array $atts
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function set_widget_parameters( array $atts ): array {
		$atts['is_dropdown'] = false;
		if ( isset( $atts['display'] ) && $atts['display'] === self::DISPLAY_DROPDOWN ) {
			$atts['is_dropdown']     = true;
			$atts['container_class'] = 'prodigy-dropdown-account__wrap';
		}

		$atts['heading_text'] = $atts['title'] ?? self::DEFAULT_TITLE;

		return $atts;
	}


	/**
	 * @param array       $atts
	 * @param string|null $content
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function output( $atts, string $content = null ): string {
		$attr = $this->set_widget_parameters( (array) $atts );
		$this->render_view( $attr );
		$content = ob_get_clean();

		return $content;
	}

	/**
	 * @param array $atts
	 *
	 * @return void
	 */
	public function render_view( array $atts ): void {
		ob_start();
		do_action( 'prodigy_shortcode_template_my_account', $atts );
		wp_reset_postdata();
	}
}
