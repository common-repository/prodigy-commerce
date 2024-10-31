<?php
namespace Prodigy\Includes\Models;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Prodigy;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tags
 */
class Prodigy_Tags {

	const TAG_TERM_GROUP = 2;

	/**
	 * @param array $tags
	 *
	 * @return array|WP_Error
	 */
	public function add_tags( array $tags ) {

		$tags_ids   = array();
		$remote_ids = array();
		$response   = array();

		foreach ( $tags as $tag ) {

			$new_term_id = false;

			$remote_info_relation = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_TAG_RELATION, (int) $tag['id'] );

			if ( ! empty( $remote_info_relation ) ) {
				$data = $this->update( $tag, (array) $remote_info_relation );
			} else {
				$data = $this->add( $tag );
			}

			if ( is_wp_error( $data ) ) {

				if ( $data->error_data && isset( $data->error_data['term_exists'] ) && $data->get_error_data() ) {
					$new_term_id = $data->get_error_data();
				} else {
					// if necessary Collect errors for response
					return new WP_Error( 'create_tag_error', $data->get_error_message(), array( 'status' => 422 ) );
				}
			}

			$new_term_id = ! empty( $new_term_id ) ? $new_term_id : $data['term_id'];
			$term_result = $this->add_relationship_remote_tags( $new_term_id, $tag['id'] );

			if ( is_wp_error( $term_result ) ) {

				// if necessary Collect errors for response
				return new WP_Error( 'create_tag_error', $term_result->get_error_message(), array( 'status' => 422 ) );
			} elseif ( empty( $term_result ) ) {
				$tag_info = Prodigy_Product_Attributes::get_term_id_by_meta_key( Prodigy::PRODIGY_HOSTED_TAG_RELATION, (int) $tag['id'] );
				if ( ! $tag_info ) {
					return new WP_Error( 'create_tag_error', 'Error is adding tag', array( 'status' => 422 ) );
				}
			}

			array_push( $tags_ids, $new_term_id );
			array_push( $remote_ids, $tag['id'] );

			$response = array(
				'tags_ids'   => $tags_ids,
				'remote_ids' => $remote_ids,
			);
		}

		return $response;
	}

	/**
	 * @param $data
	 *
	 * @return array|int[]|WP_Error
	 */
	public function add( $data ) {
		return wp_insert_term(
			$data['name'],
			Prodigy::get_prodigy_tag_type(),
			array(
				'slug'       => $data['slug'],
				'term_group' => self::TAG_TERM_GROUP,
			)
		);
	}

	/**
	 * @param $data
	 * @param $where
	 *
	 * @return array|WP_Error
	 */
	public function update( $data, array $where ) {
		return wp_update_term(
			$where['term_id'],
			Prodigy::get_prodigy_tag_type(),
			array(
				'slug'       => $data['slug'],
				'name'       => $data['name'],
				'term_group' => self::TAG_TERM_GROUP,
			)
		);
	}

	/**
	 * @param int $term_id
	 * @param int $remote_tag_id
	 *
	 * @return bool|int|WP_Error
	 */
	public function add_relationship_remote_tags( int $term_id, int $remote_tag_id ) {
		return add_term_meta( $term_id, Prodigy::PRODIGY_HOSTED_TAG_RELATION, $remote_tag_id, true );
	}
}
