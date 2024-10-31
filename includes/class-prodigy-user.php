<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Helpers\Prodigy_Cookies;

/**
 * Class for user Authentication process
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_User {

	const AUTHORIZATION_COOKIE_NAME    = 'wordpress_prodigy_user_auth_token';
	const ACCESS_COOKIE_NAME           = 'wordpress_prodigy_user_access_token';
	const REFRESH_COOKIE_NAME          = 'wordpress_prodigy_user_refresh_token';
	const USER_INFO_COOKIE_NAME        = 'wordpress_prodigy_user_name';
	const USER_INFO_COOKIE_EMAIL       = 'wordpress_prodigy_user_email';
	const USER_INFO_COOKIE_LAST_NAME   = 'wordpress_prodigy_user_last_name';
	const USER_INFO_COOKIE_PHONE       = 'wordpress_prodigy_user_phone';
	const REQUIRE_LOGIN_VALUE          = 'required';
	const REQUIRE_LOGIN_DISABLED_VALUE = 'disabled';
	const CUSTOMER_BALANCE_OPTION      = 'prodigy-user-customer-balance-option';
	const SUBSCRIPTION_OPTION          = 'prodigy-user-subscription-option';

	/** @var Prodigy_Api_Client */
	private $api_client;

	/** @var Prodigy_Cookies */
	public $cookie_helper;

	/**
	 * @param Prodigy_Api_Client $api_client
	 * @param Prodigy_Cookies    $cookie
	 */
	public function __construct(
		Prodigy_Api_Client $api_client,
		Prodigy_Cookies $cookie
	) {
		$this->cookie_helper = $cookie;
		$this->api_client    = $api_client;
	}

	/**
	 * @return string
	 */
	public function get_require_login_option(): string {
		$settings_response = Prodigy_Request_Maker::get_instance()->do_settings_request();
		update_option( 'require_login_option', $settings_response['data']['attributes']['accounts'] ?? '' );

		return $settings_response['data']['attributes']['accounts'] ?? '';
	}


	/**
	 * Get user info from Hosted System
	 *
	 * @return void
	 */
	public function get_user_info_from_hosted_system() {
		$url      = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::HS_CUSTOMER_MAIN_INFO_URL;
		$response = $this->api_client->get_remote_content( $url );
		$body     = wp_remote_retrieve_body( $response );
		$data     = json_decode( $body, true );

		if ( ! isset( $response['code'] ) ) {
			return;
		}

		if ( $response['code'] === \WP_Http::OK ) {
			$this->set_additional_user_info(
				$data['data']['attributes']['customer-balance-amount'],
				(bool) $data['data']['attributes']['subscriptions-present']
			);
		}

		if ( $response['code'] === \WP_Http::UNAUTHORIZED ) {
			$this->logout();
		}
	}


	/**
	 * @param string $paired_token
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function authorization( string $paired_token ) {
		$url      = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::USER_SESSION_TOKEN_URL . '/' . $paired_token;
		$response = $this->api_client->get_remote_content( $url );
		$body     = wp_remote_retrieve_body( $response );
		$data     = json_decode( $body, true );

		if ( ! isset( $response['code'] ) ) {
			return;
		}

		if ( $response['code'] === \WP_Http::OK && isset( $data['meta']['jwt'] ) ) {
			$this->login( $data['meta']['jwt'] );
			$this->set_user_info( $data['data']['attributes'], $data['meta']['jwt']['access_expires_at'] );
			$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$this->clear_url( $request_uri );
			$this->set_additional_user_info(
				$data['data']['attributes']['customer-balance-amount'],
				(bool) $data['data']['attributes']['subscriptions-present']
			);
		}
	}

	/**
	 * @param string $currentUrl
	 *
	 * @return void
	 */
	public function clear_url( string $currentUrl ) {
		$urlComponents = wp_parse_url( $currentUrl );
		parse_str( $urlComponents['query'] ?? '', $queryParams );
		unset( $queryParams['session_token'] );
		$newQueryString = http_build_query( $queryParams );
		$newUrl         = $urlComponents['host'] ?? '' . $urlComponents['path'];
		if ( ! empty( $newQueryString ) ) {
			$newUrl .= '?' . $newQueryString;
		}

		wp_redirect( $newUrl );
		exit;
	}

	/**
	 * @param array  $data_attributes
	 * @param string $expiration
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function set_user_info( array $data_attributes, string $expiration = null ): bool {
		$expiration_time    = $this->cookie_helper->calculate_expiration_time( $expiration );
		$is_set_name_cookie = $this->cookie_helper->set_cookie(
			self::USER_INFO_COOKIE_LAST_NAME,
			$data_attributes['last-name'] ?? '',
			$expiration_time
		);

		$is_set_last_name_cookie = $this->cookie_helper->set_cookie(
			self::USER_INFO_COOKIE_NAME,
			$data_attributes['first-name'] ?? '',
			$expiration_time
		);

		$is_set_email_cookie = $this->cookie_helper->set_cookie(
			self::USER_INFO_COOKIE_EMAIL,
			$data_attributes['email'] ?? '',
			$expiration_time
		);

		$is_set_phone_cookie = $this->cookie_helper->set_cookie(
			self::USER_INFO_COOKIE_PHONE,
			$data_attributes['phone'] ?? '',
			$expiration_time
		);

		return $is_set_name_cookie && $is_set_last_name_cookie && $is_set_email_cookie && $is_set_phone_cookie;
	}

	/**
	 * @param float|bool $balance
	 * @param bool       $subscription
	 *
	 * @return void
	 */
	public function set_additional_user_info( $balance, bool $subscription ) {
		update_option( self::CUSTOMER_BALANCE_OPTION, isset( $balance ) ? (float) $balance : false );
		update_option( self::SUBSCRIPTION_OPTION, $subscription );
	}

	/**
	 * @return bool
	 */
	public static function is_logged_in(): bool {
		return isset( $_COOKIE[ self::AUTHORIZATION_COOKIE_NAME ], $_COOKIE[ self::ACCESS_COOKIE_NAME ] );
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function login( array $data ): bool {

		if ( ! isset( $data['refresh'], $data['access'], $data['csrf'] ) ) {
			return false;
		}

		$is_set_refresh_cookie = $this->cookie_helper->set_cookie(
			self::REFRESH_COOKIE_NAME,
			$data['refresh'],
			$this->cookie_helper->calculate_expiration_time( $data['refresh_expires_at'] )
		);

		$is_set_access_cookie = $this->cookie_helper->set_cookie(
			self::ACCESS_COOKIE_NAME,
			$data['access'],
			$this->cookie_helper->calculate_expiration_time( $data['access_expires_at'] )
		);

		$is_set_jwt_cookie = $this->cookie_helper->set_cookie(
			self::AUTHORIZATION_COOKIE_NAME,
			$data['csrf'],
			$this->cookie_helper->calculate_expiration_time( $data['access_expires_at'] )
		);

		return $is_set_refresh_cookie && $is_set_access_cookie && $is_set_jwt_cookie;
	}

	/**
	 * Generate url for Hosted System
	 *
	 * @return string
	 */
	public static function get_hosted_system_login_url(): string {
		$store_subdomain = get_option( 'pg_url_domain_hosted_system' );

		return Prodigy_Api_Client::API_PROTOCOL . $store_subdomain . '.' . PRODIGY_CHECKOUT_DOMAIN . Prodigy_Api_Client::HS_CUSTOMER_LOGIN_URL;
	}

	/**
	 * @return void
	 * @throws \Exception
	 */
	public function logout() {
		$this->hosted_system_logout();
		$this->cookie_helper->remove_cookie( self::AUTHORIZATION_COOKIE_NAME );
		$this->cookie_helper->remove_cookie( self::ACCESS_COOKIE_NAME );
		$this->cookie_helper->remove_cookie( self::USER_INFO_COOKIE_EMAIL );
		$this->cookie_helper->remove_cookie( self::USER_INFO_COOKIE_NAME );
		$this->cookie_helper->remove_cookie( self::USER_INFO_COOKIE_LAST_NAME );
		$this->cookie_helper->remove_cookie( self::REFRESH_COOKIE_NAME );
	}

	/**
	 * @return void
	 */
	public static function redirect_to_current_page() {
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$redirect_url = sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) );
			wp_safe_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Logout on Hosted System
	 *
	 * @return bool
	 */
	public function hosted_system_logout(): bool {
		$refresh_key           = $this->cookie_helper->get_cookie( self::REFRESH_COOKIE_NAME );
		$url                   = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::HS_LOGOUT_URL;
		$request_disconnection = $this->api_client->delete_remote_content( $url, array( 'X-Refresh-Token' => $refresh_key ) );
		$response_code         = wp_remote_retrieve_response_code( $request_disconnection );
		if ( $response_code === \WP_Http::NO_CONTENT ) {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', 'store successfully logout with token ' . $refresh_key . ' Response code ' . $response_code, 'info' );
			}

			return true;
		}

		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', 'store unsuccessfully logout error code' . $response_code, 'error' );
		}

		return false;
	}

	/**
	 * @param string $url
	 *
	 * @return bool
	 */
	public static function is_frontend_authentication_required( string $url ): bool {
		if ( wp_doing_ajax() ) {
			return false;
		}

		$result = false;
		$array  = array(
			Prodigy::get_prodigy_category_slug(),
			Prodigy::get_prodigy_tag_slug(),
			Prodigy::get_prodigy_product_slug(),
			Prodigy_Page::PAGE_TYPE_SHOP,
			Prodigy_Page::PAGE_TYPE_CART,
			Prodigy_Page::PAGE_TYPE_THANK,
		);

		$path = wp_parse_url( $url, PHP_URL_PATH );

		if ( $path === '/' ) {
			$result = true;
		}

		foreach ( $array as $value ) {
			if ( str_contains( $path, $value ) ) {
				$result = true;
			}
		}

		return $result && ( ! isset( $_SERVER['HTTP_SEC_FETCH_DEST'] ) || $_SERVER['HTTP_SEC_FETCH_DEST'] !== 'iframe' );
	}
}
