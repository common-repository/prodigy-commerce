<?php

/**
 * Hosted system API client
 *
 * @version    2.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Content;

use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Prodigy_User;
use WP_Error;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Client
 */
class Prodigy_Api_Client {

	const API_PROTOCOL = PRODIGY_PROTOCOL_DOMAIN;
	const PRODUCTS_URL = '/api/v1/plugin/products';
	const CATALOG_URL = '/api/v1/plugin/catalog/filters';
	const API_CONNECTION_URL = '/api/v1/plugin/connection';
	const CATEGORY_URL = '/api/v1/plugin/categories';
	const ORDER_URL = '/api/v1/plugin/orders/';
	const CART_URL = '/api/v1/plugin/cart';
	const LINE_ITEM_URL = '/api/v1/plugin/cart/line_items/';
	const GET_SOCIAL_ACCOUNTS_URL = '/api/v1/plugin/statistic_apps/google_analytics';
	const SEND_RATING_URL = '/api/v1/plugin/products/:product_id/rating';
	const SYNC_CONTENT_URL = '/api/v1/plugin/synchronization_processes';
	const SYNC_DEMO_URL = '/api/v1/plugin/demo_contents';
	const RELATED_PRODUCTS_URL = '/api/v1/plugin/products/related_products';
	const USER_SESSION_TOKEN_URL = '/api/v1/plugin/paired_session_tokens';
	const HS_CUSTOMER_LOGIN_URL = '/customer/login';
	const HS_CUSTOMER_MAIN_INFO_URL = '/api/v1/customer/main_information';
	const HS_SETTINGS_URL = '/api/v1/plugin/settings';
	const HS_LOGOUT_URL = '/api/v1/plugin/session';
	const PRODUCTS_ADMIN_URL = '/api/v1/plugin/admin/products';
	const CATEGORY_ADMIN_URL = '/api/v1/plugin/admin/categories';
	const CATALOG_ADMIN_URL = '/api/v1/plugin/admin/catalog';
	const ORDER_ADMIN_URL = '/api/v1/plugin/admin/orders/';
	const RELATED_PRODUCTS_ADMIN_URL = '/api/v1/plugin/admin/products/related_products';

	/** @var array $request */
	private $request;

	/**
	 * Prodigy_Api_Client constructor.
	 *
	 * @param array $headers
	 * @param bool  $blocking
	 * @param int   $timeout
	 * @param bool  $sslverify
	 */
	public function __construct(
		array $headers = array( 'Content-Type' => 'application/json' ),
		bool $blocking = true,
		int $timeout = 10,
		bool $sslverify = false
	) {
		$cookie_helper              = new Prodigy_Cookies();
		$headers['x-Authorization'] = get_option( 'pg_store_key' );
		$access_token               = $cookie_helper->get_cookie( Prodigy_User::ACCESS_COOKIE_NAME );
		if ( ! empty( $access_token ) ) {
			$headers['x-Authorization-Customer'] = $access_token;
		}

		$this->request = compact( 'headers', 'blocking', 'timeout', 'sslverify' );
	}

	/**
	 *
	 * @param $response_remote
	 *
	 * @return array
	 */
	public function get_list_errors( $response_remote ): array {
		$message_error = json_decode( wp_remote_retrieve_body( $response_remote ), false );

		if ( isset( $message_error->errors ) && is_array( $message_error->errors ) ) {
			return array_column( $message_error->errors, 'detail' );
		}

		return array();
	}

	/**
	 * @param WP_Error $response
	 *
	 * @return array
	 */
	public function response_error( WP_Error $response ): array {

		return array(
			'success' => false,
			'error'   => true,
			'message' => $response->get_error_message(),
			'code'    => $response->get_error_code(),
		);
	}

	/**
	 * @param string $api_url
	 * @param array  $params
	 * @param string $headers
	 *
	 * @return array|WP_Error
	 */
	public function post_remote_content( string $api_url, array $params = array(), string $headers = '' ) {
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $api_url, 'info' );
		}
		$this->request['body']   = wp_json_encode( $params );
		$this->request['method'] = 'POST';
		$request                 = ! empty( $headers ) ? $headers : $this->request;
		$response                = wp_remote_post( $api_url, $request );

		if ( ! is_wp_error( $response ) ) {
			$result = json_decode( wp_remote_retrieve_body( $response ), true );
		} else {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
				do_action( 'logger', $response, 'error' );
			}
			$result = $this->response_error( $response );
		}
		$result['code'] = wp_remote_retrieve_response_code( $response );

		return $result;
	}

	/**
	 * @param string $api_url
	 * @param array  $params
	 * @param string $headers
	 *
	 * @return array|WP_Error
	 */
	public function patch_remote_content( string $api_url, array $params = array(), string $headers = '' ) {
		$this->request['method'] = 'PATCH';
		$this->request['body']   = wp_json_encode( $params );
		$request                 = ! empty( $headers ) ? $headers : $this->request;
		$response                = wp_remote_request( $api_url, $request );
		if ( ! is_wp_error( $response ) ) {
			$result = json_decode( wp_remote_retrieve_body( $response ), true );
		} else {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
				do_action( 'logger', $response, 'error' );
			}
			$result = $this->response_error( $response );
		}
		$result['code'] = wp_remote_retrieve_response_code( $response );

		return $result;
	}

	/**
	 * @param string $api_url
	 * @param array  $headers
	 *
	 * @return array|WP_Error
	 */
	public function delete_remote_content( string $api_url, array $headers = array() ) {
		$this->request['method'] = 'DELETE';

		if ( is_array( $headers ) ) {
			$this->request['headers'] += $headers;
		}

		$response = wp_remote_request( $api_url, $this->request );
		if ( is_wp_error( $response ) ) {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
				do_action( 'logger', $response, 'error' );
			}
			$result = $this->response_error( $response );
		} else {
			$result = $response;
		}
		$result['code'] = wp_remote_retrieve_response_code( $response );

		return $result;
	}

	/**
	 * @param string $api_url
	 * @param string $headers
	 * @param array  $params
	 *
	 * @return array|WP_Error
	 */
	public function put_remote_content( string $api_url, $params = array(), string $headers = '' ) {
		$this->request['method'] = 'PUT';
		$this->request['body']   = wp_json_encode( $params );
		$request                 = ! empty( $headers ) ? $headers : $this->request;
		$response                = wp_remote_request( $api_url, $request );

		if ( is_wp_error( $response ) ) {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
				do_action( 'logger', $response, 'error' );
			}
			$result = $this->response_error( $response );
		} else {
			$result = $response;
		}
		$result['code'] = wp_remote_retrieve_response_code( $response );

		return $result;
	}


	/**
	 * @param string $api_url
	 * @param string $headers
	 *
	 * @return array|WP_Error
	 */
	public function get_remote_content( string $api_url, string $headers = null ) {
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $api_url, 'info' );
		}
		$request  = $headers ?? $this->request;
		$response = wp_remote_get( $api_url, $request );

		if ( is_wp_error( $response ) ) {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
				do_action( 'logger', $response, 'error' );
			}
			$result = $this->response_error( $response );
		} else {
			$result = $response;
		}
		$result['code'] = wp_remote_retrieve_response_code( $response );

		return $result;
	}
}
