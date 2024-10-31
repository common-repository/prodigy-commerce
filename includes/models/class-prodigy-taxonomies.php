<?php

namespace Prodigy\Includes\Models;

use Prodigy\Includes\Helpers\Traits\TraitProdigySidebar;
use Prodigy\Includes\Prodigy;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Taxonomies
 */
class Prodigy_Taxonomies {
	use TraitProdigySidebar;

	private $args = array(
		'hierarchical'      => false,
		'show_ui'           => false,
		'show_admin_column' => false,
		'query_var'         => true,
	);


	/**
	 * @param $params
	 * @param $request
	 * @param $key
	 *
	 * @return int|mixed
	 */
	public function validate_taxonomies_for_create( $params, $request = array(), $key = '' ) {
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

			if ( ! isset( $param['slug'] ) && empty( $param['slug'] ) ) {
				$result = false;
				break;
			}

			if ( ! isset( $param['name'] ) && empty( $param['name'] ) ) {
				$result = false;
				break;
			}

			if ( ! isset( $param['attributes'] ) || ! is_array( $param['attributes'] ) ) {
				$result = false;
				break;
			}

			if ( ( ! isset( $param['id'] ) && empty( $param['id'] ) ) || ! is_int( $param['id'] ) ) {
				$result = false;
				break;
			}
		}

		return $result;
	}


	/**
	 * @param $params
	 * @param $request
	 * @param $key
	 *
	 * @return int|mixed
	 */
	public function validate_taxonomies_for_delete( $params, $request = array(), $key = '' ) {
		if (
			! isset( $params )
			|| ! is_array( $params )
		) {
			return false;
		}

		foreach ( $params as $param ) {
			if (
				! $param['id']
			) {
				$result = false;
				break;
			}

			if ( ( ! isset( $param['id'] ) && empty( $param['id'] ) ) || ! is_int( $param['id'] ) ) {
				$result = false;
				break;
			}
		}

		return $result;
	}


	/**
	 * @param array $taxonomies
	 *
	 * @return array
	 */
	public function add_taxonomies( array $taxonomies ): array {
		$attributes_obj        = new Prodigy_Attributes();
		$result_attributes     = array();
		$filter_attributes_ids = array();

		foreach ( $taxonomies as $taxonomy ) {
			$result_taxonomy = false;

			if ( ! taxonomy_exists( $taxonomy['slug'] ) ) {
				$result_taxonomy = $this->add( $taxonomy );
			}

			if ( ! is_wp_error( $result_taxonomy ) ) {
				$filter_attributes_ids[] = $result_taxonomy;

				$result_attributes[ $taxonomy['slug'] ]['data']    = $attributes_obj->add_collection(
					$taxonomy['attributes'],
					$taxonomy['slug']
				);
				$result_attributes[ $taxonomy['slug'] ]['success'] = true;
			} else {
				$result_attributes[ $taxonomy['slug'] ]['success'] = false;
				$result_attributes[ $taxonomy['slug'] ]['error']   = $result_taxonomy->get_error_message();
			}
		}
		$this->delete_sidebars();
		$this->set_filter_widget_settings( $filter_attributes_ids );

		return $result_attributes;
	}

	/**
	 * @param array $data
	 *
	 * @return bool|WP_Error
	 */
	public function add( array $data ) {
		$result = register_taxonomy( $data['slug'], array( Prodigy::get_prodigy_product_type() ), $this->args );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		$attributes_obj    = new Prodigy_Attribute_Taxonomies();
		$result_attributes = $attributes_obj->add( $data );

		if ( empty( $result_attributes ) ) {
			return new WP_Error( 'create_attribute_taxonomies_error', 'Error is creating taxonomies', array( 'status' => 422 ) );
		}

		return $result_attributes;
	}

	/**
	 * @param string $new
	 * @param string $old
	 *
	 * @return bool
	 */
	public function update( string $new, string $old ): bool {

		$result = true;

		if ( is_wp_error( $this->delete( $old ) ) ) {
			$result = false;
		}

		if ( is_wp_error( $this->add( array( 'slug' => $new ) ) ) ) {
			$result = false;
		}

		return $result;
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
	 * @return array
	 */
	public function getArgs(): array {
		return $this->args;
	}


	/**
	 * @param  string $taxonomy
	 * @param  string $slug
	 *
	 * @return object|null
	 */
	public static function get_taxonomy_by_different_slugs( string $taxonomy, string $slug ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->terms} as tr 
                 LEFT JOIN {$wpdb->term_taxonomy} as tt ON (tr.term_id = tt.term_id)
                 WHERE tr.slug=%s
                 AND tt.taxonomy=%s" ,
				array( $slug, $taxonomy )
			)
		);
	}


}
