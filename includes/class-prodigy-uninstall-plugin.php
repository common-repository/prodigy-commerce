<?php

namespace Prodigy\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Uninstall_Plugin
 */
class Prodigy_Uninstall_Plugin {


	/**
	 * Return a list tables.
	 *
	 * @return array
	 */
	public static function get_tables() {
		global $wpdb;

		$tables = array(
			"{$wpdb->prefix}prodigy_orders",
			"{$wpdb->prefix}prodigy_user_info",
			"{$wpdb->prefix}prodigy_attribute_taxonomy",
		);

		return $tables;
	}

	/**
	 * Drop tables.
	 *
	 * @return void
	 */
	public static function drop_tables() {
		global $wpdb;

		$tables = self::get_tables();

		if ( ! is_array( $tables ) || empty( $tables ) ) {
			return;
		}

		$wpdb->query( 'SET FOREIGN_KEY_CHECKS = 0' );

		$tables_to_drop = implode( ', ', array_map( 'esc_sql', $tables ) );

		$result = $wpdb->query( $wpdb->prepare( 'DROP TABLE IF EXISTS %s', $tables_to_drop ) );

		$wpdb->query( 'SET FOREIGN_KEY_CHECKS = 1' );
	}


	/**
	 * @return array|object|\stdClass[]|null
	 */
	public static function delete_products() {
		global $wpdb;

		return $wpdb->get_results(
			"DELETE p, pm FROM {$wpdb->posts} as p 
                JOIN {$wpdb->postmeta} as pm ON pm.post_id=p.id
                WHERE p.post_type='prodigy-product'
              "
		);
	}

	/**
	 * clear categories
	 */
	public static function delete_categories() {
		global $wpdb;

		$result_terms = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s or taxonomy = %s",
				array( 'prodigy-product-category', 'prodigy-product-tag' )
			)
		);

		if ( ! empty( $result_terms ) ) {
			foreach ( $result_terms as $result_term ) {
				$wpdb->delete( $wpdb->terms, array( 'term_id' => $result_term->term_id ), array( '%d' ) );
				$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $result_term->term_id ), array( '%d' ) );
				$wpdb->delete(
					$wpdb->termmeta,
					array(
						'term_id'  => $result_term->term_id,
						'meta_key' => 'prodigy_hosted_category_relation',
					),
					array( '%d', '%s' )
				);
			}

			$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => 'prodigy-product-category' ) );
			$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => 'prodigy-product-tag' ) );
		}
	}

	/**
	 * @param $term
	 */
	public static function delete_prodigy_terms_by_term( $term ) {

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
				$wpdb->delete(
					$wpdb->termmeta,
					array(
						'term_id'  => $result_term->term_id,
						'meta_key' => 'prodigy_tag_remote_id',
					),
					array( '%d', '%s' )
				);
			}
		}

		unregister_taxonomy( $term );

		$wpdb->get_results(
			"DELETE FROM {$wpdb->term_taxonomy} WHERE term_id IN (
                select wpt.term_id
                from {$wpdb->termmeta} wpt
                where meta_key IN ('prodigy_attribute_value_remote_id' ))"
		);
		$wpdb->get_results(
			"DELETE FROM {$wpdb->terms} WHERE term_id IN (
				select wpt.term_id
                from {$wpdb->termmeta} wpt
                where meta_key IN ('prodigy_attribute_value_remote_id'))"
		);
		$wpdb->get_results(
			"DELETE FROM {$wpdb->term_taxonomy} WHERE taxonomy IN (
                select wppat.slug
                from {$wpdb->prefix}prodigy_attribute_taxonomy wppat)"
		);
		$wpdb->get_results(
			"DELETE FROM {$wpdb->termmeta} WHERE meta_key IN ('prodigy_attribute_value_remote_id', 'prodigy_tag_remote_id')"
		);
		$wpdb->get_results(
			"truncate table {$wpdb->prefix}prodigy_attribute_taxonomy"
		);
	}

	/**
	 *
	 */
	public static function delete_attributes_terms() {
		global $wpdb;

		$prodigy_attribute_taxonomy = $wpdb->prefix . 'prodigy_attribute_taxonomy';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES like %s ', '%' . $prodigy_attribute_taxonomy . '%' ) ) == $prodigy_attribute_taxonomy ) {
			$result = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}prodigy_attribute_taxonomy"
			);

			if ( ! empty( $result ) ) {
				foreach ( $result as $attr ) {
					self::delete_prodigy_terms_by_term( $attr->slug );
				}
			}
		}
	}

	/**
	 * clear prodigy pages
	 */
	public static function delete_pages() {

		$prodigy_pages = array(
			'cart',
			'thank-you',
			'shop',
		);

		foreach ( $prodigy_pages as $prodigy_slug ) {
			$args      = array(
				'name'        => $prodigy_slug,
				'post_type'   => 'page',
				'numberposts' => 1,
			);
			$info_post = get_posts( $args );
			wp_trash_post( $info_post[0]->ID );
		}
	}
}
