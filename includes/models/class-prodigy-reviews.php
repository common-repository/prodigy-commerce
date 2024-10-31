<?php
namespace Prodigy\Includes\Models;

use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Product_Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Reviews model
 *
 * @package Prodigy\Includes\Models
 */
class Prodigy_Reviews {



	/**
	 * @param array $reviews
	 *
	 * @return false
	 */
	public function validate_product_reviews( array $reviews ) {
		foreach ( $reviews as $review ) {
			if (
				! isset( $review['product_id'] ) &&
				empty( $review['product_id'] ) &&
				filter_var( $review['product_id'], FILTER_VALIDATE_INT )
			) {
				return false;
			}

			if (
				! isset( $review['text'] ) &&
				empty( $review['text'] ) &&
				! is_string( $review['text'] )
			) {
				return false;
			}

			if (
				! isset( $review['rating'] ) &&
				empty( $review['rating'] ) &&
				filter_var( $review['rating'], FILTER_VALIDATE_INT )
			) {
				return false;
			}

			if (
				! isset( $review['reviewer'] ) &&
				empty( $review['reviewer'] ) &&
				! is_string( $review['reviewer'] )
			) {
				return false;
			}

			if (
				! isset( $review['created_at'] ) &&
				empty( $review['created_at'] ) &&
				$this->validateDate( $review['created_at'] )
			) {
				return false;
			}
		}
	}


	/**
	 * @param        $date
	 * @param string $format
	 *
	 * @return bool
	 */
	public function validateDate( $date, $format = 'Y-m-d H:i:s' ) {
		$d = \DateTime::createFromFormat( $format, $date );
		return $d && $d->format( $format ) == $date;
	}


	public function add_reviews( $params ) {
		$response = array();
		foreach ( $params as $key => $review ) {
			if ( $this->exists_relationship_product_id( $review['product_id'] ) ) {
				$local_product = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id(
					'prodigy_remote_product_id',
					$review['product_id']
				);
				$comment_data  = array(
					'comment_post_ID'  => $local_product->post_id,
					'comment_approved' => 1,
					'comment_content'  => $review['text'],
					'comment_date'     => $review['created_at'],
					'comment_author'   => $review['reviewer'],
				);
				$result        = wp_insert_comment( $comment_data );
				if ( $result ) {
					add_comment_meta( $result, Prodigy_Product_Comments::PRODIGY_RATING, intval( $review['rating'] ), true );
				}

				$response[ $key ]['success'] = ! empty( $result );
			} else {
				$response[ $key ]['success'] = false;
				$response[ $key ]['message'] = 'Undefined product ID';
			}
			$response[ $key ]['product_id'] = $review['product_id'];
		}

		return $response;
	}

	/**
	 * @param int $remote_product_id
	 *
	 * @return object
	 */
	public function exists_relationship_product_id( int $remote_product_id ) {
		return Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, $remote_product_id );
	}
}
