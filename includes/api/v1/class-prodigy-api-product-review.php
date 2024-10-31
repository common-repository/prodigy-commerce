<?php
namespace Prodigy\Includes\Api\V1;

use WP_REST_Request;
use Prodigy\Includes\Models\Prodigy_Reviews;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Product_Review
 *
 * @package Prodigy\Includes\Api\V1
 */
class Prodigy_Api_Product_Review extends Prodigy_Api_Main {

	/**
	 * @var Prodigy_Reviews
	 */
	public Prodigy_Reviews $model;

	/**
	 * Prodigy_Api_Product_Review constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->model = new Prodigy_Reviews();
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
	}

	/**
	 * Register REST API routes.
	 */
	public function platform_register_route() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_PRODUCTS_REVIEWS,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'reviews' => array(
						'validate_callback' => array( $this->model, 'validate_product_reviews' ),
					),
				),
			)
		);
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 */
	public function create( WP_REST_Request $request_params ): WP_REST_Response {

		$response = $this->model->add_reviews( $request_params['reviews'] );

		return new WP_REST_Response( $response, 200 );
	}
}
