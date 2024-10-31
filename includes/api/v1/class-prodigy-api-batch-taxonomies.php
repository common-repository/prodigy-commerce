<?php

namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Models\Prodigy_Attribute_Taxonomies;
use Prodigy\Includes\Models\Prodigy_Attributes;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use WP_REST_Request;
use WP_REST_Response;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Api_Batch_Taxonomies
 */
class Prodigy_Api_Batch_Taxonomies extends Prodigy_Api_Main {

	/**
	 * @var Prodigy_Taxonomies
	 */
	public Prodigy_Taxonomies $model;

	const BATCHES_TAXONOMIES = 'taxonomies/batches';

	/**
	 * Prodigy_Api_Taxonomies constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->model = new Prodigy_Taxonomies();
		add_action( 'rest_api_init', array( $this, 'platform_register_route_batches_tax' ) );
	}

	/**
	 * Register REST API routes
	 */
	public function platform_register_route_batches_tax() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			'taxonomies/batches',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'createOrUpdate' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
					do_action( 'logger', $request, 'error' );
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'taxonomies' => array(
						'default'           => null,
						'type'              => 'array',
						'required'          => true,
						'validate_callback' => array( $this->model, 'validate_taxonomies_for_create' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::BATCHES_TAXONOMIES,
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
			)
		);
	}

	/**
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function delete( WP_REST_Request $request ): WP_REST_Response {
		if ( isset( $request['id'] ) ) {
			$taxonomies     = $request['id'];

			foreach ( $taxonomies as $key => $taxonomy_id ) {
				if ( isset( $request['slug'] ) ) {
					$slug = $request['slug'];
				} else {
					$attributes_info = Prodigy_Attribute_Taxonomies::get_by_remote_id( (int) $taxonomy_id );
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
					$this->cache->reset_catalog();
					$response = array();
					$status   = 204;
				} else {
					$response[ $key ]['data']['success']              = false;
					$response[ $key ]['data']['slug']                 = $slug;
					$response[ $key ]['data']['message']              = 'Taxonomy contains values';
					$response[ $key ]['data']['attributes']['values'] = wp_list_pluck( $terms, 'slug' );
					$status[ $key ]                                   = 422;
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
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function createOrUpdate( WP_REST_Request $request ): WP_REST_Response {

		$taxonomies = $request['taxonomies'];

		$attributes_obj = new Prodigy_Attributes();

		$result_attributes = array();

		foreach ( $taxonomies as $taxonomy ) {
			$result_taxonomy = false;

			if ( ! taxonomy_exists( $taxonomy['slug'] ) ) {
				$result_taxonomy = $this->model->add( $taxonomy );
			}

			if ( ! is_wp_error( $result_taxonomy ) ) {
				$result_attributes[ $taxonomy['slug'] ]['data']    = $attributes_obj->add_collection( $taxonomy['attributes'], $taxonomy['slug'] );
				$result_attributes[ $taxonomy['slug'] ]['success'] = true;
			} else {
				$result_attributes[ $taxonomy['slug'] ]['success'] = false;
				$result_attributes[ $taxonomy['slug'] ]['error']   = $result_taxonomy->get_error_message();
			}
		}

		$response['data']['success']    = true;
		$response['data']['taxonomies'] = $result_attributes;

		$status = 200;

		$this->cache->reset_catalog();

		return new WP_REST_Response( $response, $status );
	}
}
