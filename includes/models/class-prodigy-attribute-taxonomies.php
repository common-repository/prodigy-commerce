<?php

namespace Prodigy\Includes\Models;

use stdClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Attribute_Taxonomies
 */
class Prodigy_Attribute_Taxonomies {

	/**
	 * @param array $data
	 *
	 * @return false|int
	 */
	public function add( array $data ) {

		global $wpdb;

		if ( isset( $data['id'] ) ) {
			$slug      = $data['slug'];
			$name      = $data['name'];
			$order_by  = 0;
			$public    = 1;
			$remote_id = $data['id'];

			$wpdb->query(
				$wpdb->prepare(
					"INSERT ignore INTO {$wpdb->prefix}prodigy_attribute_taxonomy (`slug`, `name`, `order_by`, `public`, `remote_id`) values (%s, %s, %d, %d, %d)",
					$slug,
					$name,
					$order_by,
					$public,
					$remote_id
				)
			);
		}

		return $wpdb->insert_id ?? false;
	}


	/**
	 * @param array $data
	 *
	 * @param array $where_data
	 *
	 * @return false|int
	 */
	public function update( array $data, array $where_data ) {

		global $wpdb;

		if ( isset( $data['slug'] ) ) {
			$update_data['slug'] = $data['slug'];
		}

		if ( isset( $data['name'] ) ) {
			$update_data['name'] = $data['name'];
		}

		if ( empty( $update_data ) ) {
			return false;
		}

		if ( ! isset( $where_data['id'] ) && ! isset( $where_data['remote_id'] ) ) {
			return false;
		}

		return $wpdb->update( $wpdb->prefix . Prodigy_Attributes::TABLE, $update_data, $where_data );
	}

	/**
	 * @param int $id
	 *
	 * @return bool|int
	 */
	public function delete_by_remote_id( int $id ) {
		global $wpdb;

		return $wpdb->delete( $wpdb->prefix . Prodigy_Attributes::TABLE, array( 'remote_id' => $id ), array( '%d' ) );
	}

	/**
	 * @param int $id
	 *
	 * @return bool
	 */
	public static function remote_id_exists( int $id ): bool {
		global $wpdb;

		$table_name = $wpdb->prefix . Prodigy_Attributes::TABLE;
		$query      = "SELECT * FROM {$table_name} WHERE remote_id = %d";

		return (bool) $wpdb->get_row( $wpdb->prepare( $query, $id ) );
	}

	/**
	 * @param int $id
	 *
	 * @return object|null
	 */
	public static function get_by_remote_id( int $id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . Prodigy_Attributes::TABLE;
		$query      = "SELECT * FROM {$table_name} WHERE remote_id = %d";

		return $wpdb->get_row( $wpdb->prepare( $query, $id ) );
	}


	/**
	 * @param $id
	 * @param $type
	 *
	 * @return array|object|stdClass|void|null
	 */
	public static function getCategory( $id, $type ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->term_taxonomy} where term_id=%d and taxonomy=%s ",
				array( (int) $id, $type )
			)
		);
	}

	static $categories = array();

	/**
	 * @param $id
	 * @param $type
	 *
	 * @return array
	 */
	public static function getParentCategories( $id, $type ) {
		$category = self::getCategory( $id, $type );

		if ( isset( $category ) && isset( $category->parent ) && ! empty( $category->parent ) ) {
			self::$categories[] = $category->parent;

			$parent = self::getCategory( $category->parent, $type );

			if ( isset( $parent ) && isset( $parent->parent ) && ! empty( $parent->parent ) ) {
				self::$categories[] = $parent->parent;
				self::getParentCategories( $parent->parent, $type );
			}
		}

		return self::$categories;
	}
}
