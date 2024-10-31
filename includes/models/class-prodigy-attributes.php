<?php

namespace Prodigy\Includes\Models;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Prodigy;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Prodigy_Attributes
 */
class Prodigy_Attributes {

	const TABLE = 'prodigy_attribute_taxonomy';

	/**
	 * @param array  $data
	 *
	 * @param string $taxonomy
	 *
	 * @return int|WP_Error
	 */
	public function add( array $data, string $taxonomy ) {
		global $wpdb;

		if ( empty( taxonomy_exists( $taxonomy ) ) ) {
			$response['data']['success']       = false;
			$response['data']['taxonomy_slug'] = $taxonomy;
			$response['data']['message']       = 'Taxonomy does not exist';

			return new WP_Error( 'create_attribute_error', 'Taxonomy does not exist', array( 'status' => 422 ) );
		}

		// begin transaction
		$wpdb->query( 'START TRANSACTION' );

		$result_term = wp_insert_term(
			$data['name'],
			$taxonomy,
			array( 'slug' => $data['slug'] )
		);

		if ( is_wp_error( $result_term ) ) {
			$wpdb->query( 'ROLLBACK' );

			return $result_term;
		}

		$result_sync = add_term_meta( $result_term['term_id'], Prodigy::PRODIGY_REMOTE_ATTRIBUTE_ID, $data['id'], true );

		if ( is_wp_error( $result_sync ) ) {
			$wpdb->query( 'ROLLBACK' );

			return $result_sync;
		}

		$wpdb->query( 'COMMIT' );

		return $result_term['term_id'];
	}

	/**
	 * @param array  $new_data
	 * @param int    $term_id
	 * @param string $taxonomy
	 *
	 * @return int|WP_Error
	 */
	public function update( array $new_data, int $term_id, string $taxonomy ) {
		global $wpdb;

		if ( empty( taxonomy_exists( $taxonomy ) ) ) {
			$response['data']['success']       = false;
			$response['data']['taxonomy_slug'] = $taxonomy;
			$response['data']['message']       = 'Taxonomy does not exist';

			return new WP_Error( 'create_attribute_error', 'Taxonomy does not exist', array( 'status' => 422 ) );
		}

		$result_term = wp_update_term(
			$term_id,
			$taxonomy,
			array(
				'slug' => $new_data['slug'],
				'name' => $new_data['name'],
			)
		);

		if ( is_wp_error( $result_term ) ) {
			return $result_term;
		}

		return $result_term['term_id'];
	}

	/**
	 * @param int    $remote_id
	 * @param string $slug
	 *
	 * @return bool|WP_Error
	 */
	public function delete( int $remote_id, string $slug ) {

		$attributes_obj    = new Prodigy_Attribute_Taxonomies();
		$result_attributes = $attributes_obj->delete_by_remote_id( $remote_id );

		if ( empty( $result_attributes ) ) {
			return new WP_Error( 'delete_attribute_taxonomies_error', 'Error is deleting taxonomies', array( 'status' => 422 ) );
		}

		$result_unregister = unregister_taxonomy( $slug );

		if ( is_wp_error( $result_unregister ) ) {
			return $result_unregister;
		}

		return unregister_taxonomy( $slug );
	}

	/**
	 * @param array  $list_attributes
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	public function add_collection( array $list_attributes, string $taxonomy ): array {

		$data = array();

		foreach ( $list_attributes as $attribute ) {

			$remote_id_info = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_REMOTE_ATTRIBUTE_ID, $attribute['id'] );
			$local_slug     = $attribute['slug'];

			if ( ! term_exists( $local_slug, $taxonomy ) && empty( $remote_id_info ) ) {
				$result_attributes = $this->add( $attribute, $taxonomy );
			} elseif ( isset( $remote_id_info->term_id ) ) {
				$result_attributes = $this->update( $attribute, $remote_id_info->term_id, $taxonomy );
			}

			if ( ! empty( $result_attributes ) ) {
				if ( is_wp_error( $result_attributes ) ) {
					$data[ $attribute['id'] ]['success']         = false;
					$data[ $attribute['id'] ]['wp_attribute_id'] = false;
					$data[ $attribute['id'] ]['error']           = $result_attributes->get_error_message();
				} else {
					$id                                  = $result_attributes;
					$data[ $attribute['id'] ]['success'] = true;
					$data[ $attribute['id'] ]['wp_attribute_id'] = (int) $id;
				}
			}
		}

		return $data;
	}


	/**
	 * @param int $id
	 *
	 * @return object|null
	 */
	public static function get_by_remote_id( int $id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE;

		return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM {$table_name} WHERE remote_id = %d', $id ) );
	}


	/**
	 * @param string $taxonomy
	 * @param string $slug
	 *
	 * @return array|object|\stdClass|null
	 */
	public static function get_attributes_by_different_slugs( string $taxonomy, string $slug ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->terms} as tr 
				 LEFT JOIN {$wpdb->term_taxonomy} as tt ON (tr.term_id = tt.term_id)
				 WHERE tr.slug=%s
				 AND tt.taxonomy=%s
				 ",
				array(
					$slug,
					$taxonomy,
				)
			)
		);
	}
}
