<?php
namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Models\Prodigy_Tags;
use Prodigy\Includes\Prodigy;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Category
 */
class Prodigy_Api_Tags extends Prodigy_Api_Main {

	/** @var object Prodigy_Tags  */
	public $model;

	/**
	 * Prodigy_Api_Category constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->model = new Prodigy_Tags();
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
	}

	/**
	 * Register REST API routes
	 */
	public function platform_register_route() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAGS_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'   => array(
						'default'  => null,
						'type'     => 'integer',
						'required' => true,
					),
					'name' => array(
						'default'  => null,
						'required' => true,
						'type'     => 'string',
					),
					'slug' => array(
						'default'           => null,
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => array( $this, 'validate_tag_slug_for_create' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAGS_PATH . '(?P<id>\d+)',
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
						'validate_callback' => array( $this, 'is_isset_tag' ),
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
						'validate_callback' => array( $this, 'validate_tag_slug_for_update' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAGS_PATH . '(?P<id>\d+)',
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
			self::API_BATCH_TAGS_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'batches_create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'tags' => array(
						'validate_callback' => array( $this, 'validate_batch_tags' ),
					),
				),
			)
		);
	}

	/**
	 * @param $param
	 * @param $request
	 * @param $key
	 *
	 * @return false
	 */
	public function validate_batch_tags( $param, $request, $key ): bool {
		if ( ! empty( $param ) ) {
			foreach ( $param as $tags ) {
				if (
					! is_string( $tags['slug'] ) &&
					$this->validate_tag_slug_for_create( $tags['slug'] )
				) {
					return false;
				}

				if (
					! isset( $tags['name'] ) &&
					empty(
						$tags['name'] &&
						! is_string( $tags['name'] )
					) ) {
						return false;
				}

				if (
					( ! isset( $tags['id'] ) && empty( $tags['id'] ) ) ||
					! is_int( $tags['id'] )
				) {
					return false;
				}
			}
		}
	}



	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_REST_Response
	 */
	public function batches_create( WP_REST_Request $request_params ): WP_REST_Response {
		$response = $this->model->add_tags( $request_params['tags'] );

		return new WP_REST_Response( $response, 200 );
	}

	/**
	 * @param mixed $id
	 *
	 * @return bool
	 */
	public function is_isset_tag( $id ): bool {
		$local_tag = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_tag_remote_id', (int) $id );

		return ! empty( $local_tag );
	}

	/**
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function validate_tag_slug_for_create( string $slug ): bool {
		$is_valid_slug = self::is_valid_name_slug( $slug );
		$is_isset_slug = empty( get_term_by( 'slug', $slug, Prodigy::get_prodigy_tag_type() ) );

		return ( $is_valid_slug && $is_isset_slug );
	}

	/**
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function validate_tag_slug_for_update( string $slug ): bool {
		return self::is_valid_name_slug( $slug );
	}

	/**
	 * @param WP_REST_Request $tag
	 *
	 * @return WP_REST_Response
	 */
	public function delete( WP_REST_Request $tag ) {
		$remote_id     = $tag->get_url_params()['id'];
		$local_tag     = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_tag_remote_id', (int) $remote_id );
		$is_delete_tag = wp_delete_term( $local_tag->term_id, Prodigy::get_prodigy_tag_type() );

		$response_code = 200;
		$response      = array();
		if ( is_wp_error( $is_delete_tag ) ) {
			$response['data']['success'] = false;
			$response['data']['id']      = $remote_id;
			$response['data']['message'] = $is_delete_tag->get_error_message();
			$response_code               = 422;
		} else {
			$response['data']['success'] = true;
			$response['data']['id']      = $remote_id;
		}

		return new WP_REST_Response( $response, $response_code );
	}

	/**
	 * @param WP_REST_Request $tag
	 *
	 * @return WP_REST_Response
	 */
	public function update( WP_REST_Request $tag ): WP_REST_Response {
		$remote_id = $tag->get_url_params()['id'];

		$local_tag = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_TAG_RELATION, (int) $remote_id );
		$result    = false;
		if ( $local_tag ) {
			$result = $this->model->update( $tag, (array) $local_tag );
		}

		$response = array();
		if ( is_wp_error( $result ) ) {
			$response['data']['success'] = false;
			$response['data']['id']      = $remote_id;
			$response['data']['message'] = $result->get_error_message();
			$response_code               = 422;
		} else {
			$response_code               = 200;
			$response['data']['success'] = true;
			$response['data']['id']      = $remote_id;
		}

		return new WP_REST_Response( $response, $response_code );
	}

	/**
	 * @param WP_REST_Request $tag
	 *
	 * @return WP_REST_Response
	 */
	public function create( WP_REST_Request $tag ): WP_REST_Response {
		$local_tag = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_TAG_RELATION, (int) $tag['id'] );
		if ( $local_tag ) {
			$result = $this->model->update( $tag, (array) $local_tag );
		} else {
			$result = $this->model->add( $tag );
		}

		$response = array();
		if ( is_wp_error( $result ) ) {
			$response['success'] = false;
			$response['id']      = $tag['id'];
			$response['message'] = $result->get_error_message();
			$response['code']    = 422;
		} else {
			update_term_meta( $result['term_id'], 'prodigy_hosted_category_relation', $tag['id'] );
			$response['success'] = true;
			$response['id']      = $tag['id'];
			$response['code']    = 200;
		}

		return new WP_REST_Response( $response, $response['code'] );
	}
}
