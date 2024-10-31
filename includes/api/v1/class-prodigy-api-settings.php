<?php

namespace Prodigy\Includes\Api\V1;

use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Settings
 */
class Prodigy_Api_Settings extends Prodigy_Api_Main {

	/**
	 * CloudPlatform constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register routes
	 */
	public function register_routes() {

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_SETTINGS_PATH,
			array(
				'methods'             => 'PUT',
				'callback'            => array( $this, 'update' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
			)
		);
	}

	/**
	 *
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 */
	public function update( WP_REST_Request $request_params ): WP_REST_Response {

		if ( isset( $request_params['apps'] ) && isset( $request_params['apps']['google_analytics'] ) ) {
			$google_analytics = $request_params['apps']['google_analytics'];
			update_option( 'pg_google_analytics_code', $google_analytics );
		}
		$response['data']['success'] = true;

		return new WP_REST_Response( $response, 201 );
	}
}
