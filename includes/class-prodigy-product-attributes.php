<?php

/**
 * Prodigy product attributes class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Product_attributes
 */
class Prodigy_Product_Attributes {

	public static $table_name = 'prodigy_attribute_taxonomy';

	/**
	 * @return array
	 */
	public static function get_attribute_taxonomies() {
		global $wpdb;
		$table_name           = $wpdb->prefix . self::$table_name;
		$attribute_taxonomies = false;
		$like                 = '%' . $wpdb->prefix . self::$table_name . '%';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like ) ) == $table_name ) {
			$attribute_taxonomies = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy"
			);
		}
		$new_attributes = array();
		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $key => $attribute_taxonomy ) {
				if ( $attribute_taxonomy->slug ) {
					$new_attributes[ $key ] = $attribute_taxonomy;
				}
			}
		}

		return $new_attributes;
	}

	public static function truncate_attrs_taxonomy() {
		global $wpdb;

		$wpdb->query(
			$wpdb->prepare(
				"TRUNCATE TABLE {$wpdb->prefix}prodigy_attribute_taxonomy"
			)
		);

		return true;
	}


	/**
	 * @param $term
	 */
	public static function delete_prodigy_terms( $term ) {
		global $wpdb;
		$result_terms = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s",
				array( $term )
			)
		);

		if ( ! empty( $result_terms ) ) {
			foreach ( $result_terms as $result_term ) {
				$wpdb->delete( $wpdb->terms, array( 'term_id' => $result_term->term_id ), array( '%d' ) );
				$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $result_term->term_id ), array( '%d' ) );
				$wpdb->delete( $wpdb->termmeta, array( 'term_id' => $result_term->term_id ), array( '%d' ) );
			}
		}

		$wpdb->get_results(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->prefix}prodigy_attribute_taxonomy where slug = %s",
				$term
			)
		);

		$term_taxonomy = $wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => $term ) );

		return $term_taxonomy;
	}

	/**
	 * @param string $slug
	 *
	 * @return array|null
	 */
	public function select_attribute_taxonomy_like_slug( string $slug ): array {
		global $wpdb;

		$search_text = '%' . $slug . '%';
		$table       = $wpdb->prefix . self::$table_name;
		$like        = '%' . $wpdb->prefix . self::$table_name . '%';
		$result      = array();
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like ) ) === $table ) {
			$result = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where slug like %s",
					$search_text
				)
			);
		}

		return $result;
	}

	/**
	 * @param int $id
	 *
	 * @return object|null
	 */
	public static function get_attribute_taxonomies_by_id( int $id ) {
		global $wpdb;

		$attribute_taxonomies = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where id = %d",
				$id
			)
		);

		return $attribute_taxonomies;
	}

	/**
	 * @param string $slug
	 *
	 * @return object|null
	 */
	public static function get_attribute_taxonomies_by_slug( string $slug ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where slug = %s",
				$slug
			)
		);
	}

	/**
	 * @param string $name
	 *
	 * @return object|null
	 */
	public static function get_attribute_taxonomies_by_name( string $name ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where name = %s",
				$name
			)
		);
	}

	/**
	 * @param int $remote_id
	 *
	 * @return object|null
	 */
	public static function get_attribute_taxonomies_by_remote_id( int $remote_id ) {
		global $wpdb;

		$attribute_taxonomies = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where remote_id = %d",
				$remote_id
			)
		);

		return $attribute_taxonomies;
	}

	/**
	 * @param string $slug
	 *
	 * @return object|null
	 */
	public static function get_info_prodigy_attr_taxonomy_by_slug( string $slug ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy where slug = %s",
				$slug
			)
		);
	}

	/**
	 * @param string $key
	 * @param int    $value
	 *
	 * @return object|null
	 */
	public static function get_term_id_by_meta_key( string $key, int $value ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->termmeta} WHERE meta_key = %s and meta_value= %d ",
				array( $key, $value )
			)
		);
	}

	/**
	 * @param array  $value_ids
	 * @param string $placeholder
	 *
	 * @return string
	 */
	public static function where_in_sanitize( $value_ids, $placeholder = '%d' ) {
		if ( is_array( $value_ids ) ) {
			$how_many     = count( $value_ids );
			$placeholders = array_fill( 0, $how_many, $placeholder );
			$placeholders = implode( ', ', $placeholders );
		} else {
			$placeholders = '';
		}

		return $placeholders;
	}

	/**
	 * @param array $attribute_list
	 *
	 * @return string
	 */
	public static function concat_attribute_names( array $attribute_list ): string {
		$string = '';
		$count  = 0;
		foreach ( $attribute_list as $key => $attribute ) {
			$taxonomy = self::get_attribute_taxonomies_by_slug( $key );
			if ( ! empty( $taxonomy ) ) {
				$count ++;
				$string .= count( $attribute_list ) >= $count + 1 ? $taxonomy->name . ' and ' : $taxonomy->name;
			}
		}

		return $string;
	}
}
