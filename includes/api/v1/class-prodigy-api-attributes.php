<?php
namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Models\Prodigy_Attributes;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Attributes
 */
class Prodigy_Api_Attributes extends Prodigy_Api_Main {

	/**
	 * Prodigy_Api_Category constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
	}

	/**
	 * Register REST API routes
	 */
	public function platform_register_route() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_ATTRIBUTES_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'            => array(
						'default'           => null,
						'type'              => 'integer',
						'required'          => true,
						'validate_callback' => function ( $param ) {
							return ! Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_attribute_value_remote_id', (int) $param );
						},
					),
					'name'          => array(
						'default'  => null,
						'required' => true,
						'type'     => 'string',
					),
					'slug'          => array(
						'default'           => null,
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request ) {
							return ! term_exists( $param, $request['taxonomy_slug'] );
						},
					),
					'taxonomy_slug' => array(
						'default'  => null,
						'required' => false,
						'type'     => 'string',
					),
					'taxonomy_id'   => array(
						'default'  => null,
						'required' => false,
						'type'     => 'integer',
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_ATTRIBUTES_PATH . '(?P<id>\d+)',
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
						'required'          => true,
						'validate_callback' => function ( $param, $request ) {
							return (bool) Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_attribute_value_remote_id', (int) $request->get_url_params()['id'] );
						},
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
						'validate_callback' => function ( $param, $request ) {
							return ! term_exists( $param, $request['taxonomy_slug'] );
						},
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_ATTRIBUTES_PATH . '(?P<id>\d+)',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id' => array(
						'default'           => null,
						'type'              => 'integer',
						'required'          => true,
						'validate_callback' => function ( $param, $request ) {
							return (bool) Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_attribute_value_remote_id', (int) $request->get_url_params()['id'] );
						},
					),
				),
			)
		);
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function create( WP_REST_Request $request ): WP_REST_Response {
		$attributes_obj = new Prodigy_Attributes();
		$remote_id      = $request['id'];
		$name           = $request['name'];
		$slug           = $request['slug'];

		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', 'Update taxonomies ' . $request['name'], 'info' );
		}

		if ( isset( $request['taxonomy_slug'] ) ) {
			$taxonomy_slug = $request['taxonomy_slug'];
		} else {
			$attributes_info = $attributes_obj->get_by_remote_id( $request['taxonomy_id'] );
			$taxonomy_slug   = $attributes_info->slug;
		}

		if ( empty( taxonomy_exists( $taxonomy_slug ) ) ) {

			$response['data']['success']       = false;
			$response['data']['taxonomy_slug'] = $taxonomy_slug;
			$response['data']['message']       = 'Taxonomy does not exist';

			return new WP_REST_Response( $response, 422 );
		}

		$data = wp_insert_term(
			$name,
			$taxonomy_slug,
			array( 'slug' => $slug )
		);

		$response = array();
		if ( is_wp_error( $data ) ) {

			$response['data']['success']          = false;
			$response['data']['attribute']        = $slug;
			$response['data']['attribute_exists'] = $data->get_error_data();
			$response['data']['message']          = $data->get_error_message();
			$status                               = 422;

		} else {
			$this->cache->reset_catalog();
			add_term_meta( $data['term_id'], 'prodigy_attribute_value_remote_id', $remote_id, true );
			$response['data']['success'] = true;
			$response['data']['id']      = $remote_id;
			$status                      = 201;
		}

		return new WP_REST_Response( $response, $status );
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function update( WP_REST_Request $request ): WP_REST_Response {
		$name          = $request['name'];
		$slug          = $request['slug'];
		$taxonomy_slug = $request['taxonomy_slug'];
		$remote_id     = $request->get_url_params()['id'];

		$updated_data = array();
		if ( ! empty( $name ) ) {
			$updated_data['name'] = $name;
		}

		if ( ! empty( $slug ) ) {
			$updated_data['slug'] = $slug;
		}

		$attr_term = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_attribute_value_remote_id', (int) $remote_id );

		if ( empty( $attr_term ) ) {
			$response['data']['success'] = false;
			$response['data']['message'] = 'Attribute is invalid';
			$status                      = 422;

			return new WP_REST_Response( $response, $status );
		}

		$data = wp_update_term( $attr_term->term_id, $taxonomy_slug, $updated_data );

		$response               = array();
		$response['data']['id'] = $remote_id;
		if ( is_wp_error( $data ) ) {
			$response['data']['error']   = true;
			$response['data']['message'] = $data->get_error_message();
			$status                      = 422;
		} else {
			$response['data']['success'] = true;
			$status                      = 200;
		}

		return new WP_REST_Response( $response, $status );
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function delete( WP_REST_Request $request ): WP_REST_Response {
		$remote_id     = $request->get_url_params()['id'];
		$taxonomy_slug = $request['taxonomy_slug'];
		$term_info     = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_attribute_value_remote_id', (int) $remote_id );
		$is_delete     = wp_delete_term( $term_info->term_id, $taxonomy_slug );

		$response                    = array();
		$response['data']['attr_id'] = $remote_id;
		if ( is_wp_error( $is_delete ) ) {
			$response['data']['error']   = true;
			$response['data']['message'] = $is_delete->get_error_message();
			$status                      = 422;
		} elseif ( empty( $is_delete ) ) {
			$response['data']['error']   = true;
			$response['data']['message'] = 'Error deleting attribute';
			$status                      = 422;
		} else {
			$this->cache->reset_catalog();
			$response = array();
			$status   = 204;
		}

		return new WP_REST_Response( $response, $status );
	}
}
