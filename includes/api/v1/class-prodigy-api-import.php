<?php
namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Import
 *
 * @package Prodigy\Includes\Api\V1
 */
class Prodigy_Api_Import extends Prodigy_Api_Main {

	const TYPE = 'synchronization-processes';

	/** @var object Prodigy_Synchronization  */
	public $sync;

	/**
	 * CloudPlatform constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->sync = new Prodigy_Synchronization();
		add_action( 'rest_api_init', array( $this, 'register_route_product' ) );
	}

	/**
	 * Register REST API routes
	 */
	public function register_route_product() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_IMPORT,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'validate_callback' => array( $this, 'validate_data' ),
				),
			)
		);
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function create( WP_REST_Request $request_params ): WP_REST_Response {
		$result = $this->sync->run_import_process( $request_params['data'] );

		$response = array();
		if ( ! $result ) {
			$response['success'] = false;
			$response['message'] = 'Start process failed!';
			$response['code']    = 422;
		} else {
			$this->cache->reset_catalog();
			$response['success'] = true;
			$response['code']    = 200;
		}

		return new WP_REST_Response( $response, $response['code'] );
	}

	/**
	 * @param array $types
	 *
	 * @return false
	 */
	public function validate_data( array $types ): bool {
		if ( ! empty( $types ) ) {
			foreach ( $types as $content ) {
				if (
					! isset( $content['id'] ) &&
					empty( $content['id'] ) &&
					filter_var( $content['id'], FILTER_VALIDATE_INT )
				) {
					return false;
				}

				if (
					! is_string( $content['type'] ) &&
					$content['type'] === self::TYPE
				) {
					return false;
				}

				if (
					isset( $content['attributes'] ) &&
					! $this->validate_attributes( $content['attributes'] )
				) {
					return false;
				}
			}
		}
	}

	/**
	 * @param array $attributes
	 *
	 * @return false
	 */
	public function validate_attributes( array $attributes ): bool {
		foreach ( $attributes as $attribute ) {
			if (
				! isset( $attribute['entity-type'] ) &&
				! is_string( $attribute['entity-type'] )
			) {
				return false;
			}

			if (
				! is_string( $attribute['completed'] ) &&
				! is_bool( $attribute['completed'] )
			) {
				return false;
			}

			if (
				isset( $content['total-count'] ) &&
				! is_integer( $content['total-count'] )
			) {
				return false;
			}

			if (
				! isset( $attribute['url'] ) &&
				! filter_var( $attribute['url'], FILTER_VALIDATE_URL )
			) {
				return false;
			}
		}
	}
}
