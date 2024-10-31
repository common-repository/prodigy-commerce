<?php
namespace Prodigy\Includes\Models;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Prodigy;
use stdClass;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Products
 */
class Prodigy_Products {

	public $category;
	public $tag;

	const PRODUCT_META_TITLE = 'prodigy_product_meta_title';

	/**
	 * Products constructor.
	 */
	public function __construct() {
		$this->category = new Prodigy_Categories();
		$this->tag      = new Prodigy_Tags();
	}

	/**
	 * @param array $products
	 */
	public function add_products( $products ) {
		foreach ( $products as $product ) {
			$this->add_product( $product );
		}
	}

	/**
	 * @param array $products
	 * @return bool
	 */
	public function validate_products( $products ) {
		return true;
	}

	/**
	 * @param array $parameters
	 * @return bool
	 */
	public function validate_products_params( $parameters ) {
		$result = true;
		if ( ! empty( $parameters ) ) {
			foreach ( $parameters as $parameter ) {
				if ( ! isset( $parameter['id'] ) ) {
					$result = false;
					break;
				}
			}
		} else {
			$result = false;
		}

		return $result;
	}

	/**
	 * @param array $request_params
	 *
	 * @return int|WP_Error
	 */
	public function add_product( array $request_params ) {
		$description      = $request_params['meta_description'] ?? '';
		$meta_title       = $request_params['meta_title'] ?? '';
		$title            = $request_params['name'] ?? '';
		$slug             = $request_params['slug'];
		$remote_id        = $request_params['id'];
		$categories_posts = array();
		$tags_posts       = array();

		do_action( 'logger', $request_params, 'error' );

		if ( ! empty( $request_params['categories'] ) && is_array( $request_params['categories'] ) ) {
			$categories_posts = $this->category->add_categories( $request_params['categories'] );

			if ( isset( $categories_posts->errors ) && PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' synchronization categories', 'error' );
				do_action( 'logger', $categories_posts->errors, 'error' );
				return new WP_Error( 'sync_category_error', $categories_posts->errors, array( 'status' => 422 ) );
			}
		}

		$categoriesIds = self::getAncestorsByIds( $categories_posts['categories_ids'] ?? array(), Prodigy::get_prodigy_category_type() );

		if ( isset( $request_params['tags'] ) && ! empty( $request_params['tags'] ) && is_array( $request_params['tags'] ) ) {
			$tags_posts = $this->tag->add_tags( $request_params['tags'] );
		}

		if ( is_wp_error( $tags_posts ) ) {
			return new WP_Error( 'sync_product_error', $tags_posts->get_error_message(), array( 'status' => 422 ) );
		}

		$post_data = array(
			'post_title'    => wp_strip_all_tags( $title ),
			'post_content'  => wp_strip_all_tags( $description ),
			'post_name'     => wp_strip_all_tags( $slug ),
			'post_type'     => Prodigy::get_prodigy_product_type(),
			'post_status'   => 'publish',
			'post_category' => $categoriesIds,
			'tags_input'    => $tags_posts['tags_ids'] ?? '',
		);

		$postWP = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, $request_params['id'] );

		if ( $postWP ) {
			$post_data['ID'] = $postWP->post_id;
			$post_id         = wp_update_post( $post_data, true );
		} else {
			$post_id = wp_insert_post( $post_data, true );
		}

		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'create_product_error', $post_id->get_error_message(), array( 'status' => 422 ) );
		}

		/*
		 * update relationship post->ID => id product HS
		 */
		update_post_meta( $post_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, $remote_id );

		update_post_meta( $post_id, self::PRODUCT_META_TITLE, $meta_title );

		$term_taxonomy_ids = wp_set_object_terms( $post_id, $categoriesIds, Prodigy::get_prodigy_category_type() );
		$tags_taxonomy_ids = wp_set_object_terms( $post_id, $tags_posts['tags_ids'] ?? '', Prodigy::get_prodigy_tag_type() );

		if ( is_wp_error( $term_taxonomy_ids ) ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $post_id . 'add synchronization categories', 'error' );
		}

		if ( is_wp_error( $tags_taxonomy_ids ) ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $post_id . 'add synchronization tags', 'error' );
		}

		return $post_id;
	}

	/**
	 * @param array  $objectData
	 * @param string $type
	 * @return array
	 */
	public static function getAncestorsByIds( array $objectData, string $type ): array {
		if ( empty( $objectData ) ) {
			return array();
		}
		$parentsMerge = array();
		foreach ( $objectData as $objectId ) {
			$parentsMerge = array_merge( $parentsMerge, get_ancestors( $objectId, $type ) );
		}

		return array_unique( array_merge( $objectData, $parentsMerge ) );
	}

	/**
	 * @param string $img_names
	 * @return array
	 */
	public static function prodigy_get_products_id_by_title( string $img_names ): array {
		global $wpdb;
		$img_ids_by_names = array();
		$clean_string     = html_entity_decode( $img_names );
		$product_name     = explode( ',', $clean_string );
		if ( is_array( $product_name ) ) {
			foreach ( $product_name as $key => $product ) {
				$product = $wpdb->get_row(
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->posts} where post_title=%s and post_type=%s",
						array( $product, Prodigy::get_prodigy_product_type() )
					)
				);

				if ( isset( $product ) ) {
					$img_ids_by_names[ $key ] = $product->ID ?? '';
				}
			}
		}

		return $img_ids_by_names;
	}


	/**
	 * @param $name
	 *
	 * @return array|false|object|stdClass|void
	 */
	public static function getProductByName( string $name ) {
		global $wpdb;
		$product = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->posts} where post_name=%s and post_type=%s",
				array( trim( $name ), Prodigy::get_prodigy_product_type() )
			)
		);

		return $product ?? false;
	}

	public static function belongsCategory( int $productId, int $categoryId ) {
		global $wpdb;
		$relation = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->term_relationships} where object_id=%d and term_taxonomy_id=%d",
				array( $productId, $categoryId )
			)
		);

		return $relation ?? false;
	}
}
