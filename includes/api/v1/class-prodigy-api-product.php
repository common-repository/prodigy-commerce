<?php

namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Frontend\Mappers\Prodigy_Related_Products_Data_Mapper;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Models\Prodigy_Products;
use WP_Error;
use WP_Post;
use WP_REST_Request;
use WP_REST_Response;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Models\Prodigy_Tags;
use Prodigy\Includes\Models\Prodigy_Categories;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Product
 */
class Prodigy_Api_Product extends Prodigy_Api_Main {

	/** @var object Prodigy_Products  */
	private $model;

	/** @var mixed  */
	private $order;

	/**
	 * CloudPlatform constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->model = new Prodigy_Products();
		$this->order = get_option( 'current_order' );
		add_action( 'rest_api_init', array( $this, 'register_route_product' ) );
	}

	/**
	 * Register routes.
	 */
	public function register_route_product() {
		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_PRODUCTS_PATH,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'createOrUpdate' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'id'         => array(
						'default'     => null,
						'type'        => 'integer',
						'required'    => true,
						'description' => 'product with selected id already present',
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
					'categories' => array(
						'default'           => null,
						'required'          => false,
						'validate_callback' => array( $this, 'validate_callback_categories' ),
					),
					'tags'       => array(
						'default'           => null,
						'required'          => false,
						'validate_callback' => array( $this, 'validate_callback_tags' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_PRODUCTS_PATH . '/' . '(?P<id>\d+)',
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
							return (bool) $this->exists_relationship_product_id( (int) $request->get_url_params()['id'] );
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
						'validate_callback' => array( $this, 'validation_slug' ),
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_PRODUCTS_PATH . '/' . '(?P<id>\d+)',
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
						'validate_callback' => function ( $param, $request, $key ) {
							return (bool) $this->exists_relationship_product_id( (int) $request->get_url_params()['id'] );
						},
					),
				),
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			self::API_PRODUCTS_PATH . '/bulk',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'products_bulk_hiding' ),
				'permission_callback' => function ( WP_REST_Request $request ) {
					return $this->is_authorization( $request->get_header( 'x-Authorization' ) );
				},
				'args'                => array(
					'products' => array(
						'validate_callback' => array( $this->model, 'validate_products_params' ),
					),
				),
			)
		);
	}

	/**
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function products_bulk_hiding( WP_REST_Request $request ) {
		$products = $request['products'];

		foreach ( $products as $product ) {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', 'Product hidden ' . $product['id'], 'info' );
			}

			if ( isset( $product['id'] ) ) {
				$this->cache->reset_product( $product['id'] );
			}
			$this->cache->reset_catalog();
		}

		return new WP_REST_Response( array(), 204 );
	}

	/**
	 * @param $categories
	 * @param $request
	 * @param $key
	 *
	 * @return bool
	 */
	public function validate_callback_categories( $categories, $request, $key ): bool {
		$result = true;

		if ( empty( $categories ) || ! is_array( $categories ) ) {
			return $result;
		}

		foreach ( $categories as $category ) {

			if ( ! isset( $category['slug'] ) && empty( $category['slug'] ) ) {
				$result = false;
				break;
			}

			if ( ! isset( $category['name'] ) && empty( $category['name'] ) ) {
				$result = false;
				break;
			}

			if ( ( ! isset( $category['id'] ) && empty( $category['id'] ) ) || ! is_int( $category['id'] ) ) {
				$result = false;
				break;
			}
		}

		return $result;
	}

	/**
	 * @param $tags
	 * @param $request
	 * @param $key
	 *
	 * @return bool
	 */
	public function validate_callback_tags( $tags, $request, $key ) {

		$result = true;

		if ( empty( $tags ) || ! is_array( $tags ) ) {
			return $result;
		}

		foreach ( $tags as $tag ) {

			if ( ! isset( $tag['slug'] ) && empty( $tag['slug'] ) ) {
				$result = false;
				break;
			}

			if ( ! isset( $tag['name'] ) && empty( $tag['name'] ) ) {
				$result = false;
				break;
			}

			if ( ( ! isset( $tag['id'] ) && empty( $tag['id'] ) ) || ! is_int( $tag['id'] ) ) {
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
	 * @return false
	 */
	public function validation_slug( $param, $request, $key ) {
		$args = array(
			'name'        => $param,
			'post_type'   => Prodigy::get_prodigy_product_type(),
			'numberposts' => 1,
		);

		return empty( get_posts( $args ) );
	}

	/**
	 * @param string $slug
	 *
	 * @return bool|WP_Post
	 */
	public function get_product( string $slug ) {
		$args = array(
			'name'        => $slug,
			'post_type'   => Prodigy::get_prodigy_product_type(),
			'numberposts' => 1,
		);

		$posts = get_posts( $args );

		return ! empty( $posts ) ? $posts[0] : false;
	}

	/**
	 *
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function createOrUpdate( WP_REST_Request $request_params ) {
		global $wpdb;

		$meta_title       = $request_params['meta_title'] ?? '';
		$description      = $request_params['meta_description'] ?? '';
		$title            = $request_params['name'];
		$slug             = $request_params['slug'];
		$remote_id        = $request_params['id'];
		$categories_posts = array();
		$tags_posts       = array();
		$terms_commit     = true;

		// Begin transaction.
		$wpdb->query( 'START TRANSACTION' );

		if ( isset( $request_params['categories'] ) && ! empty( $request_params['categories'] ) && is_array( $request_params['categories'] ) ) {
			$obj_category      = new Prodigy_Categories();
			$categories_result = $obj_category->add_categories( $request_params['categories'] );

			if ( empty( $categories_result ) || is_wp_error( $categories_result ) ) {
				$terms_commit = false;
			} else {
				$categories_posts = $categories_result;
			}
		}

		if ( isset( $request_params['tags'] ) && ! empty( $request_params['tags'] ) && is_array( $request_params['tags'] ) ) {
			$obj_tag     = new Prodigy_Tags();
			$tags_result = $obj_tag->add_tags( $request_params['tags'] );
			if ( empty( $tags_result ) && is_wp_error( $tags_result ) ) {
				$terms_commit = false;
			} else {
				$tags_posts = $tags_result;
			}
		}

		$local_product = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $remote_id );
		$post_data     = array(
			'post_content' => wp_strip_all_tags( $description ),
			'post_title'   => wp_strip_all_tags( $title ),
			'post_name'    => wp_strip_all_tags( $slug ),
			'post_type'    => Prodigy::get_prodigy_product_type(),
			'post_status'  => 'publish',
		);

		if ( isset( $local_product->post_id ) ) {
			$post_data['ID'] = $local_product->post_id;

			$post_id              = wp_update_post( $post_data, true );
			$remote_sync_relation = get_post_meta( $post_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );

			if ( empty( $remote_sync_relation ) || ( (int) $remote_sync_relation !== (int) $remote_id ) ) {
				$wpdb->query( 'ROLLBACK' );

				return new WP_Error( 'create_product_error', 'Synchronization error, remote id is not exists', array( 'status' => 422 ) );
			}
		} else {
			$post_id = wp_insert_post( $post_data, true );
			// Update relationship post->ID => id product HS.
			$remote_sync_relation = add_post_meta( $post_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, $remote_id, true );
		}

		update_post_meta( $post_id, 'prodigy_product_meta_title', $meta_title );

		if ( is_wp_error( $post_id ) ) {
			$wpdb->query( 'ROLLBACK' );

			return new WP_Error( 'create_product_error', $post_id->get_error_message(), array( 'status' => 422 ) );
		}

		if ( ! empty( $categories_posts ) ) {
			wp_set_object_terms( $post_id, $categories_posts['categories_ids'], Prodigy::get_prodigy_category_type() );
		}

		if ( ! empty( $tags_posts ) ) {
			wp_set_object_terms( $post_id, $tags_posts['tags_ids'], Prodigy::get_prodigy_tag_type() );
		}

		if ( $remote_sync_relation && $terms_commit && is_int( $post_id ) ) {
			$wpdb->query( 'COMMIT' );
		} else {
			$wpdb->query( 'ROLLBACK' );

			return new WP_Error( 'create_product_error', 'Product sync error.', array( 'status' => 400 ) );
		}

		/*
		 * prepare response
		 */
		$this->cache->reset_product( $remote_id );
		$related_products_key = md5( wp_json_encode( array_merge( array( (string) $remote_id ), array( Prodigy_Related_Products_Data_Mapper::UP_SELL ) ) ) );
		$this->cache->reset_related_products( $related_products_key );
		$this->cache->reset_catalog();
		$this->cache->reset_order( $this->order );
		$response['data']['success'] = true;
		$response['data']['id']      = $post_id;

		return new WP_REST_Response( $response, 201 );
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function update( WP_REST_Request $request_params ) {
		$title            = $request_params['name'] ?? '';
		$slug             = $request_params['slug'] ?? '';
		$remote_id        = $request_params->get_url_params()['id'];
		$categories_posts = array();
		$tags_posts       = array();

		$post_mete_info = $this->exists_relationship_product_id( (int) $remote_id );

		if ( isset( $request_params['categories'] ) && ! empty( $request_params['categories'] ) ) {
			$obj_category      = new Prodigy_Categories();
			$categories_result = $obj_category->add_categories( $request_params['categories'] );
		}

		if ( isset( $request_params['tags'] ) && ! empty( $request_params['tags'] ) ) {
			$obj_tag     = new Prodigy_Tags();
			$tags_result = $obj_tag->add_tags( $request_params['tags'] );
		}

		$post_data['ID']          = $post_mete_info->post_id;
		$post_data['post_status'] = 'publish';

		if ( ! empty( $title ) ) {
			$post_data['post_title'] = wp_strip_all_tags( $title );
		}

		if ( ! empty( $slug ) ) {
			$post_data['post_name'] = wp_strip_all_tags( $slug );
		}

		if ( ! empty( $categories_posts ) ) {
			$post_data['post_category'] = $categories_posts;
		}

		if ( ! empty( $tags_posts ) ) {
			$post_data['tags_input'] = $tags_posts;
		}

		$post_id = wp_update_post( $post_data, true );

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'update_product_error', $post_id->get_error_message(), array( 'status' => 422 ) );
		} else {
			$this->cache->reset_product( $remote_id );
			$this->cache->reset_catalog();
			return new WP_REST_Response( array(), 204 );
		}
	}

	/**
	 * @param WP_REST_Request $request_params
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function delete( WP_REST_Request $request_params ) {
		$remote_id      = $request_params->get_url_params()['id'];
		$post_meta_info = $this->exists_relationship_product_id( (int) $remote_id );

		$result      = wp_delete_post( $post_meta_info->post_id, true );
		$result_meta = delete_post_meta( $post_meta_info->post_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID );
		$this->cache->reset_product( $remote_id );
		$this->cache->reset_catalog();
		$this->cache->reset_order( $this->order );

		if ( empty( $result ) && ! empty( $result_meta ) ) {
			return new WP_Error( 'delete_product_error', 'Error removing product from database', array( 'status' => 422 ) );
		}

		return new WP_REST_Response( array(), 204 );
	}
}
