<?php

namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Models\Prodigy_Attribute_Taxonomies;
use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Taxonomies
 */
class Prodigy_Api_Taxonomies extends Prodigy_Api_Main {

	/**
	 * Prodigy_Api_Taxonomies constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
	}

	/**
	 * Create and Update attributes and values (taxonomies and terms)
	 *
	 * @return void
	 */
	public function platform_register_route() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAXONOMIES_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'createOrUpdate' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'         => array(
						'default'  => null,
						'type'     => 'integer',
						'required' => true,
					),
					'name'       => array(
						'default'  => null,
						'required' => true,
						'type'     => 'string',
					),
					'slug'       => array(
						'default'  => null,
						'required' => true,
						'type'     => 'string',
					),
					'attributes' => array(
						'default'           => null,
						'required'          => true,
						'validate_callback' => array( $this, 'validate' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAXONOMIES_PATH . '/' . '(?P<id>\d+)',
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
						'validate_callback' => function ( $param, $request, $key ) {
							return Prodigy_Attribute_Taxonomies::remote_id_exists( $param );
						},
					),
					'name' => array(
						'default'           => null,
						'required'          => false,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request, $key ) {
							return ! taxonomy_exists( $param );
						},
					),
					'slug' => array(
						'default'           => null,
						'required'          => false,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request, $key ) {
							return ! taxonomy_exists( $param );
						},
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_TAXONOMIES_PATH . '/' . '(?P<id>\d+)',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'   => array(
						'default'           => null,
						'type'              => 'integer',
						'required'          => true,
						'validate_callback' => function ( $param, $request, $key ) {
							return Prodigy_Attribute_Taxonomies::remote_id_exists( $param );
						},
					),
					'slug' => array(
						'default'           => null,
						'required'          => false,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request, $key ) {
							return taxonomy_exists( $param );
						},
					),
				),
			)
		);
	}

	/**
	 * @param $params
	 * @param $request
	 * @param $key
	 *
	 * @return bool
	 */
	public function validate( $params, $request, $key ): bool {
		$result = true;

		if (
			! isset( $params )
			|| ! is_array( $params )
		) {
			return false;
		}

		foreach ( $params as $param ) {

			if (
				! $param['id']
				|| ! $param['name']
				|| ! $param['slug']
			) {
				$result = false;
				break;
			}
		}

		return $result;
	}

	/**
	 * @param $param
	 * @param $request
	 * @param $key
	 *
	 * @return int|mixed
	 */
	public function validate_attributes( $param, $request, $key ) {
		return term_exists( $param, $request['taxonomy_slug'] );
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function createOrUpdate( WP_REST_Request $request ): WP_REST_Response {
		$taxonomy_obj    = new Prodigy_Taxonomies();
		$attributes_obj  = new Prodigy_Attributes();
		$result_taxonomy = false;

		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', 'Create attribute ' . $request['slug'], 'info' );
		}

		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', 'Create attribute values ' . wp_json_encode( $request['attributes'] ), 'info' );
		}

		$taxonomy = array(
			'name' => $request['name'],
			'slug' => $request['slug'],
			'id'   => $request['id'],
		);

		if ( ! taxonomy_exists( $taxonomy['slug'] ) ) {
			$result_taxonomy = $taxonomy_obj->add( $taxonomy );
		}

		if ( ! is_wp_error( $result_taxonomy ) ) {
			$result_attributes[ $taxonomy['slug'] ]['data']    = $attributes_obj->add_collection( $request['attributes'], $request['slug'] );
			$result_attributes[ $taxonomy['slug'] ]['success'] = true;
		} else {
			$result_attributes[ $taxonomy['slug'] ]['success'] = false;
			$result_attributes[ $taxonomy['slug'] ]['error']   = $result_taxonomy->get_error_message();
		}
		$this->cache->reset_catalog();

		$response['data']['success']    = true;
		$response['data']['taxonomies'] = $result_attributes;

		$status = 200;

		return new WP_REST_Response( $response, $status );
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function update( WP_REST_Request $request ): WP_REST_Response {
		$name      = $request['name'];
		$slug      = $request['slug'];
		$remote_id = $request->get_url_params()['id'];

		$updated_data = array();
		if ( ! empty( $name ) ) {
			$updated_data['name'] = $name;
		}

		if ( ! empty( $slug ) ) {
			$updated_data['slug'] = $slug;
		}

		$taxonomy_obj    = new Prodigy_Taxonomies();
		$attributes_obj  = new Prodigy_Attributes();
		$attributes_info = $attributes_obj->get_by_remote_id( $remote_id );
        if ( isset( $attributes_info->id, $attributes_info->slug ) ) {
            $remote_id_info = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_REMOTE_ATTRIBUTE_ID, $attributes_info->id );
            $result         = $attributes_obj->update( $updated_data, $remote_id_info->term_id, $attributes_info->slug );
        }

		if ( empty( $result ) ) {
			$response['data']['success'] = false;
			$response['data']['message'] = 'Update taxonomy is invalid';
			$status                      = 422;

			return new WP_REST_Response( $response, $status );
		}

		$result_register = $taxonomy_obj->update( $slug, $attributes_info->slug );

		if ( empty( $result_register ) ) {
			$response['data']['success'] = false;
			$response['data']['message'] = 'Update or register taxonomy is invalid';
			$status                      = 422;

			return new WP_REST_Response( $response, $status );
		}

		$this->cache->reset_catalog();

		$response['data']['success'] = true;
		$response['data']['id']      = $remote_id;
		$response['data']['slug']    = $slug;
		$status                      = 200;

		return new WP_REST_Response( $response, $status );
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function delete( WP_REST_Request $request ): WP_REST_Response {
		$remote_id      = $request->get_url_params()['id'];
		if ( isset( $request['slug'] ) ) {
			$slug = $request['slug'];
		} else {
			$attributes_info = Prodigy_Attribute_Taxonomies::get_by_remote_id( (int) $remote_id );
			$slug            = $attributes_info->slug;
		}

		$terms = get_terms(
			array(
				'taxonomy'   => $slug,
				'hide_empty' => false,
			)
		);

		$is_delete = Prodigy_Product_Attributes::delete_prodigy_terms( $slug );

		if ( $is_delete ) {
			$response = array();
			$status   = 204;
			$this->cache->reset_catalog();
		} else {
			$response['data']['success']              = false;
			$response['data']['slug']                 = $slug;
			$response['data']['message']              = 'Taxonomy contains values';
			$response['data']['attributes']['values'] = wp_list_pluck( $terms, 'slug' );
			$status                                   = 422;
		}

		return new WP_REST_Response( $response, $status );
	}
}
