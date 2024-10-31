<?php

namespace Prodigy\Includes\Models;

use Prodigy\Includes\Api\V1\Prodigy_Api_Main;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Prodigy;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Prodigy_Categories {

	const CATEGORY_META_TITLE       = 'prodigy_category_meta_title';
	const CATEGORY_META_DESCRIPTION = 'prodigy_category_meta_description';
	const CATEGORY_META_TERM_GROUP  = 1;

	/**
	 * @param array $categories
	 *
	 * @return false
	 */
	public function validate_categories( array $categories ) {
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				if (
					$this->validate_category_slug_for_create( $category['slug'] ) &&
					! is_string( $category['slug'] )
				) {
					return false;
				}

				if (
					! isset( $category['name'] ) &&
					empty(
						$category['name'] &&
						  ! is_string( $category['name'] )
					) ) {
					return false;
				}

				if (
					! isset( $category['id'] ) &&
					empty( $category['id'] ) &&
					filter_var( $category['id'], FILTER_VALIDATE_INT )
				) {
					return false;
				}
			}
		}
	}

	/**
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function validate_category_slug_for_create( string $slug ) {
		$is_valid_slug = Prodigy_Api_Main::is_valid_name_slug( $slug );
		$is_isset_slug = empty( get_term_by( 'slug', $slug, Prodigy::get_prodigy_category_type() ) );

		return ( $is_valid_slug && $is_isset_slug );
	}

	/**
	 * @param array $categories
	 *
	 * @return WP_Error|array of ids
	 */
	public function add_categories( array $categories ) {
		$categories_ids = array();
		$remote_ids     = array();
		$response       = array();

		foreach ( $categories as $category ) {
			$new_term_id = false;

			if ( isset( $category['parent'] ) && ! empty( $category['parent'] ) ) {
				$parent_info = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $category['parent'] );
				if ( ! $parent_info ) {
					return new WP_Error( 'create_category_error', 'Error is adding category', array( 'status' => 422 ) );
				}
			}

			$remote_info_relation = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $category['id'] );

			$category['parent'] = ! empty( $category_info ) ? $category_info->term_id : 0;
			if ( ! empty( $remote_info_relation ) ) {
				$data = $this->update( $category, (array) $remote_info_relation );
			} else {
				$data = $this->add( $category );
			}

			if ( is_wp_error( $data ) ) {
				if ( $data->error_data && isset( $data->error_data['term_exists'] ) && $data->get_error_data() ) {
					$new_term_id = $data->get_error_data();
				} else {
					return new WP_Error( 'create_category_error', $data->get_error_message(), array( 'status' => 422 ) );
				}
			}

			$new_term_id = ! empty( $new_term_id ) ? $new_term_id : $data['term_id'];
			$term_result = $this->add_relationship_remote_categories( $new_term_id, $category['id'] );
			if ( is_wp_error( $term_result ) ) {
				return new WP_Error( 'create_category_error', $term_result->get_error_message(), array( 'status' => 422 ) );
			} elseif ( empty( $term_result ) ) {
				$category_info = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $category['id'] );
				if ( ! $category_info ) {
					return new WP_Error( 'create_category_error', 'Error is adding category', array( 'status' => 422 ) );
				}
			}
			array_push( $categories_ids, $new_term_id );
			array_push( $remote_ids, $category['id'] );

			$response = array(
				'categories_ids' => $categories_ids,
				'remote_ids'     => $remote_ids,
			);
		}

		$this->set_parent_categories( $categories );

		return $response;
	}

	/**
	 * @param array $categories
	 * @return void
	 */
	public function set_parent_categories( $categories ) {
		foreach ( $categories as $category ) {
			if ( isset( $category['id'], $category['parent_id'] ) ) {
				$this->set_parent_category( $category['id'], $category['parent_id'] );
			}
		}
	}


	/**
	 * @param $id
	 * @param $parent_id
	 * @return void
	 */
	public function set_parent_category( $id, $parent_id ) {
		$local_category        = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $id );
		$local_category_parent = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, (int) $parent_id );

		if ( isset( $local_category->term_id, $local_category_parent->term_id ) ) {
			wp_update_term(
				$local_category->term_id,
				Prodigy::get_prodigy_category_type(),
				array(
					'parent' => $local_category_parent->term_id,
				)
			);
		}
	}

	/**
	 * @param $category
	 * @return WP_Error|\WP_Term
	 */
	public function delete( $category ) {
		return wp_delete_term( $category->term_id, Prodigy::get_prodigy_category_type() );
	}

	/**
	 * @param $data
	 *
	 * @return array|int[]|WP_Error
	 */
	public function add( $data ) {

		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
			do_action( 'logger', $data, 'error' );
			if ( isset( $data['meta_description'], $data['meta_title'] ) ) {
				do_action( 'logger', 'description ' . __LINE__ . __METHOD__ . __CLASS__ . ' ' . $data['meta_description'], 'error' );
				do_action( 'logger', 'title ' . __LINE__ . __METHOD__ . __CLASS__ . ' ' . $data['meta_title'], 'error' );
			}
		}

		$result = wp_insert_term(
			$data['name'],
			Prodigy::get_prodigy_category_type(),
			array(
				'slug'       => $data['slug'],
				'term_group' => self::CATEGORY_META_TERM_GROUP,
			)
		);

		if ( ! is_wp_error( $result ) ) {
			if ( isset( $data['meta_title'] ) && isset( $result['term_id'] ) ) {
				update_term_meta( $result['term_id'], self::CATEGORY_META_TITLE, $data['meta_title'] );
			}

			if ( isset( $data['meta_description'] ) && isset( $result['term_id'] ) ) {
				update_term_meta( $result['term_id'], self::CATEGORY_META_DESCRIPTION, $data['meta_description'] );
			}
		}

		return $result;
	}

	/**
	 * @param $data
	 * @param array $where
	 *
	 * @return array|WP_Error
	 */
	public function update( $data, array $where ) {
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', $data, 'error' );
			if ( isset( $data['meta_title'], $data['meta_description'] ) ) {
				do_action( 'logger', 'title' . __LINE__ . __METHOD__ . __CLASS__ . ' ' . $data['meta_title'], 'error' );
				do_action( 'logger', 'description' . __LINE__ . __METHOD__ . __CLASS__ . ' ' . $data['meta_description'], 'error' );
			}
		}

		$result = wp_update_term(
			$where['term_id'],
			Prodigy::get_prodigy_category_type(),
			array(
				'slug'       => $data['slug'],
				'name'       => $data['name'],
				'term_group' => self::CATEGORY_META_TERM_GROUP,
			)
		);

		if ( ! is_wp_error( $result ) ) {
			if ( isset( $data['meta_title'] ) && isset( $result['term_id'] ) ) {
				update_term_meta( $result['term_id'], self::CATEGORY_META_TITLE, $data['meta_title'] );
			}

			if ( isset( $data['meta_description'] ) && isset( $result['term_id'] ) ) {
				update_term_meta( $result['term_id'], self::CATEGORY_META_DESCRIPTION, $data['meta_description'] );
			}
		}

		return $result;
	}

	/**
	 * @param int $term_id
	 * @param int $remote_category_id
	 *
	 * @return bool|int|WP_Error
	 */
	public function add_relationship_remote_categories( int $term_id, int $remote_category_id ) {
		return add_term_meta( $term_id, Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, $remote_category_id, true );
	}
}
