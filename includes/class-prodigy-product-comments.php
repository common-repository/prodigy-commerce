<?php

/**
 * Prodigy product comments class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Product_Comments
 */
class Prodigy_Product_Comments {

	const PRODIGY_RATING = 'prodigy_rating';

	/**
	 * Prodigy_Product_Comments constructor.
	 */
	public function __construct() {
		add_filter( 'comments_open', array( $this, 'prodigy_comments_open' ), 10, 2 );
		add_action( 'comment_post', array( $this, 'add_prodigy_product_rating' ), 1 );

		// Set comment type.
		add_filter( 'preprocess_comment', array( $this, 'update_comment_type' ), 10, 1 );
	}

	/**
	 * Validation request params
	 *
	 * @return bool
	 */
	private static function is_validate_add_comments(): bool {
		$result = true;
		$user   = wp_get_current_user();
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'comment_nonce' ) ) {
			$rating          = isset( $_POST['rating'] ) ? sanitize_key( wp_unslash( $_POST['rating'] ) ) : '';
			$comment         = isset( $_POST['comment'] ) ? sanitize_text_field( wp_unslash( $_POST['comment'] ) ) : '';
			$comment_post_ID = isset( $_POST['comment_post_ID'] ) ? sanitize_key( wp_unslash( $_POST['comment_post_ID'] ) ) : '';
			$email           = isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '';
			$author          = isset( $_POST['author'] ) ? sanitize_text_field( wp_unslash( $_POST['author'] ) ) : '';

			if ( isset( $rating, $user->roles[0] ) && $user->roles[0] !== 'administrator' && empty( $rating ) ) {
				$result = false;
			}
			if ( empty( $comment ) ) {
				$result = false;
			}

			if ( empty( $comment_post_ID ) ) {
				$result = false;
			}

			if ( ! is_user_logged_in() ) {
				if ( empty( $author ) ) {
					$result = false;
				}

				if ( empty( $email ) ) {
					$result = false;
				}
			}
		}

		return $result;
	}

	/**
	 * Function validation request params
	 */
	public static function custom_validate_comments() {
		$is_enable_rating = get_option( 'pg_product_rating' );
		if ( ! empty( $is_enable_rating ) ) {
			if ( empty( self::is_validate_add_comments() ) ) {
				wp_die( esc_html( '<strong>Error:</strong> you must fill all fields.' ) );
			}
		}
	}

	/**
	 * @param int $post_id
	 *
	 * @return string|null
	 */
	public static function get_count_comments( $post_id ) {
		global $wpdb;
		return $wpdb->get_var(
			$wpdb->prepare(
				"
                SELECT COUNT(*) FROM $wpdb->comments
                WHERE comment_parent = 0
                AND comment_post_ID = %d
                AND comment_approved = '1'
            ",
				$post_id
			)
		);
	}

	/**
	 * @param int $post_id
	 *
	 * @return string|null
	 */
	public static function get_count_comments_by_rating( $post_id ) {
		global $wpdb;
		return $wpdb->get_var(
			$wpdb->prepare(
				"
                SELECT COUNT(*) FROM $wpdb->comments as comments
                LEFT JOIN $wpdb->commentmeta as cometa ON comments.comment_ID = cometa.comment_id
                WHERE comments.comment_parent = 0
                AND cometa.meta_value <> 0
                AND comments.comment_post_ID = %d
				AND comments.comment_approved = '1'
            ",
				$post_id
			)
		);
	}



	/**
	 * Rating field
	 *
	 * @param int $comment_id
	 */
	public function add_prodigy_product_rating( $comment_id ) {
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'comment_nonce' ) ) {
			$rating = isset( $_POST['rating'] ) ? sanitize_key( wp_unslash( $_POST['rating'] ) ) : 0;
			if ( isset( $rating, $_POST['comment_post_ID'] ) && Prodigy::get_prodigy_product_type() === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {
				if ( ! $rating || $rating > 5 || $rating < 0 ) {
					return;
				}

				add_comment_meta( $comment_id, self::PRODIGY_RATING, intval( $rating ), true );
			}
		}
	}

	/**
	 * Get product rating count for a product
	 *
	 * @param int $post_id
	 * @return int[]
	 */
	public static function get_counts_rating_product( $post_id ) {
		global $wpdb;

		$counts     = array();
		$raw_counts = $wpdb->get_var(
			$wpdb->prepare(
				"
			SELECT cm.meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta as cm
			LEFT JOIN $wpdb->comments as c ON cm.comment_id = c.comment_ID
			WHERE cm.meta_key = 'prodigy_rating'
			AND c.comment_post_ID = %d
			AND c.comment_approved = '1'
			AND cm.meta_value > 0
			GROUP BY meta_value
		",
				$post_id
			)
		);

		$raw_counts = array();
		if ( ! empty( $raw_counts ) ) {
			foreach ( $raw_counts as $count ) {
				$counts[ $count->meta_value ] = absint( $count->meta_value_count );
			}
		}

		return $counts;
	}


	/**
	 * Get product rating for a product.
	 *
	 * @param int $post_id
	 * @return float
	 */
	public static function get_rating_average_product( $post_id ) {
		global $wpdb;

		$count = self::get_count_comments_by_rating( $post_id );

		if ( $count ) {
			$ratings = $wpdb->get_var(
				$wpdb->prepare(
					"
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'prodigy_rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
			",
					$post_id
				)
			);
			$average = number_format( $ratings / $count, 1, '.', '' );
		} else {
			$average = 0;
		}

		update_post_meta( $post_id, 'product_average_rating', $average );

		return $average;
	}

	/**
	 * Get product review count for a product
	 *
	 * @param int $post_id
	 * @return int
	 */
	public static function get_count_review_product( $post_id ) {
		global $wpdb;

		$count = $wpdb->get_var(
			$wpdb->prepare(
				"
			SELECT COUNT(*) FROM $wpdb->comments
			WHERE comment_parent = 0
			AND comment_post_ID = %d
			AND comment_approved = '1'
		    ",
				$post_id
			)
		);

		return $count;
	}

	/**
	 * See if comments are open.
	 *
	 * @param  bool $open
	 * @param  int  $post_id
	 * @return bool
	 */
	public static function prodigy_comments_open( $open, $post_id ) {
		if ( Prodigy::get_prodigy_product_type() === get_post_type( $post_id ) && ! post_type_supports( Prodigy::get_prodigy_product_type(), 'comments' ) ) {
			$open = false;
		}

		return $open;
	}

	/**
	 * Update comment type of product reviews.
	 *
	 * @since 3.5.0
	 * @param array $comment_data Comment data.
	 * @return array
	 */
	public static function update_comment_type( $comment_data ) {

		$is_admin = current_user_can( 'manage_options' );
		if ( $is_admin ) {
			return $comment_data;
		}

		/*
		 * validation
		 */
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'comment_nonce' ) ) {
			self::custom_validate_comments();
			if ( ! $is_admin && isset( $_POST['comment_post_ID'], $comment_data['comment_type'] ) && Prodigy::get_prodigy_product_type() === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {
				$comment_data['comment_type'] = 'review';

				if ( isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ], $_POST['author'] ) && sanitize_text_field( wp_unslash( $_POST['author'] ) ) ) {
					global $wpdb;

					$author_name = $wpdb->get_row( $wpdb->prepare( "SELECT id, name FROM {$wpdb->prefix}prodigy_user_info WHERE user_session_hash=%s;", sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) ) );

					if ( empty( $author_name ) ) {
						$wpdb->insert(
							$wpdb->prefix . 'prodigy_user_info',
							array(
								'user_session_hash' => isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '',
								'name'              => isset( $_POST['author'] ) ? sanitize_text_field( wp_unslash( $_POST['author'] ) ) : '',
								'email'             => isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '',
								'is_show'           => (int) ! empty( sanitize_text_field( wp_unslash( $_POST['wp-comment-cookies-consent'] ) ) ),
							),
							array( '%s', '%s', '%s', '%d' )
						);
					} else {
						$wpdb->update(
							$wpdb->prefix . 'prodigy_user_info',
							array(
								'user_session_hash' => isset( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : '',
								'name'              => isset( $_POST['author'] ) ? sanitize_text_field( wp_unslash( $_POST['author'] ) ) : '',
								'email'             => isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '',
								'is_show'           => (int) ! empty( sanitize_text_field( wp_unslash( $_POST['wp-comment-cookies-consent'] ) ) ),
							),
							array( 'id' => $author_name->id ),
							array( '%s', '%s', '%s', '%d' )
						);
					}
				}
			}
		}

		return $comment_data;
	}
}
