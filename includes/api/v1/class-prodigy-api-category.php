<?php
namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Models\Prodigy_Categories;
use Prodigy\Includes\Prodigy;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Category
 */
class Prodigy_Api_Category extends Prodigy_Api_Main {

	/**
	 * @var object Prodigy_Categories
	 */
	public $model;


	/**
	 * Prodigy_Api_Category constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->model = new Prodigy_Categories();
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
	}

	/**
	 * Register REST API routes
	 */
	public function platform_register_route() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_CATEGORIES_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'               => array(
						'default'  => null,
						'type'     => 'integer',
						'required' => true,
					),
					'name'             => array(
						'default'  => null,
						'required' => true,
						'type'     => 'string',
					),
					'slug'             => array(
						'default'           => null,
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => array( $this, 'validate_category_slug_for_create' ),
					),
					'meta_title'       => array(
						'default'  => null,
						'required' => false,
						'type'     => 'string',
					),
					'meta_description' => array(
						'default'  => null,
						'required' => false,
						'type'     => 'string',
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_CATEGORIES_PATH . '/' . '(?P<id>\d+)',
			array(
				'methods'             => 'PATCH',
				'callback'            => array( $this, 'update' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'   => array(
						'default'           => null,
						'type'              => 'integer',
						'validate_callback' => array( $this, 'is_isset_category' ),
					),
					'name' => array(
						'default'  => null,
						'required' => false,
						'type'     => 'string',
					),
					'slug' => array(
						'default'           => null,
						'required'          => false,
						'type'              => 'string',
						'validate_callback' => array( $this, 'validate_category_slug_for_update' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_CATEGORIES_PATH . '/' . '(?P<id>\d+)',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id' => array(
						'default'  => null,
						'type'     => 'integer',
						'required' => true,
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_BATCH_CATEGORIES_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'batches_create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'categories' => array(
						'validate_callback' => array( $this->model, 'validate_categories' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_BATCH_CATEGORIES_PATH,
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'batches_delete' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_CATALOG_PATH . '/reset',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'reset_catalog_cache' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
			)
		);
	}

	/**
	 * @return WP_REST_Response
	 */
	public function reset_catalog_cache(): WP_REST_Response {
		$this->cache->reset_catalog();
		return new WP_REST_Response( array(), '204' );
	}

	/**
	 * @param int $category_id
	 *
	 * @return object|null
	 */
	public function isset_category( int $category_id ) {
		return Prodigy_Product_Attributes::get_term_id_by_meta_key(
			'prodigy_hosted_category_relation',
			$category_id
		);
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 */
	public function batches_create( WP_REST_Request $request_params ): WP_REST_Response {
		$response = $this->model->add_categories( $request_params['categories'] );

		return new WP_REST_Response( $response, 200 );
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 */
	public function batches_delete( WP_REST_Request $request_params ): WP_REST_Response {
		if ( isset( $request_params['id'] ) ) {
			$categories = $request_params['id'];
			$response   = array();
			$status     = array();
			foreach ( $categories as $key => $category_id ) {
				$local_category     = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $category_id );
				$is_delete_category = $this->model->delete( $local_category );

				if ( $is_delete_category ) {
					$status = 204;
					$this->cache->reset_catalog();
				} else {
					$response[ $key ]['data']['success'] = false;
					$response[ $key ]['data']['message'] = 'Taxonomy contains values';
					$status                              = 422;
				}
			}
		} else {
			$response['data']['error']   = 'Bad request';
			$response['data']['success'] = false;
			$status                      = 400;
		}

		return new WP_REST_Response( $response, $status );
	}

	/**
	 * @param mixed $category_id
	 *
	 * @return bool
	 */
	public function is_isset_category( $category_id ): bool {
		$local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $category_id );

		return ! empty( $local_category );
	}

	/**
	 * @param WP_REST_Request $category
	 *
	 * @return WP_REST_Response
	 */
	public function create( WP_REST_Request $category ): WP_REST_Response {
		$local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $category['id'] );
		if ( $local_category ) {
			$result = $this->model->update( $category, (array) $local_category );
		} else {
			$result = $this->model->add( $category );
		}

		$response       = array();
		$response['id'] = $category['id'];
		if ( is_wp_error( $result ) ) {
			$response['success'] = false;
			$response['message'] = $result->get_error_message();
			$response['code']    = 422;
		} else {
			$this->cache->reset_catalog();
			update_term_meta( $result['term_id'], 'prodigy_hosted_category_relation', $category['id'] );
			$response['success'] = true;
			$response['code']    = 200;
		}

		return new WP_REST_Response( $response, $response['code'] );
	}

	/**
	 * @param WP_REST_Request $category
	 * @return WP_REST_Response
	 */
	public function update( WP_REST_Request $category ): WP_REST_Response {
		$remote_id      = $category->get_url_params()['id'];
		$local_category = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $remote_id );
		$result         = $this->model->update( $category, (array) $local_category );

		$response               = array();
		$response['data']['id'] = $remote_id;
		if ( is_wp_error( $result ) ) {
			$response['data']['success'] = false;
			$response['data']['message'] = $result->get_error_message();
			$response_code               = 422;
		} else {
			$response_code               = 200;
			$response['data']['success'] = true;
		}

		return new WP_REST_Response( $response, $response_code );
	}

	/**
	 * @param WP_REST_Request $category
	 *
	 * @return WP_REST_Response
	 */
	public function delete( WP_REST_Request $category ): WP_REST_Response {
		$remote_id          = $category->get_url_params()['id'];
		$local_category     = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $remote_id );
		$is_delete_category = $this->model->delete( $local_category );
		do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $remote_id . 'sync validation', 'info' );

		$response['data']['id'] = $remote_id;
		if ( is_wp_error( $is_delete_category ) ) {
			$response['data']['success'] = false;
			$response['data']['message'] = $is_delete_category->get_error_message();
			$response_code               = 422;
		} else {
			$this->cache->reset_catalog();
			$response_code               = 200;
			$response['data']['success'] = true;
		}

		return new WP_REST_Response( $response, $response_code );
	}



	/**
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function validate_category_slug_for_update( string $slug ): bool {
		return self::is_valid_name_slug( $slug );
	}


	/**
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function validate_category_slug_for_create( string $slug ): bool {
			return self::is_valid_name_slug( $slug );
	}
}
