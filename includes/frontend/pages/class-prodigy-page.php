<?php
namespace Prodigy\Includes\Frontend\Pages;

require_once wp_normalize_path( ABSPATH ) . 'wp-load.php';
require_once ABSPATH . 'wp-includes/pluggable.php';
defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Page
 *
 * @package Prodigy\Includes\Frontend\Pages
 */
class Prodigy_Page {
	const PRODIGY_CART_PAGE  = 'prodigy_cart_page_id';
	const PRODIGY_SHOP_PAGE  = 'prodigy_shop_page_id';
	const PRODIGY_THANK_PAGE = 'prodigy_thank_page_id';
	const PRODIGY_PAGE_STATUS_PUBLISH = 'publish';

	const PAGE_TYPE_THANK = 'thank';
	const PAGE_TYPE_CART = 'cart';
	const PAGE_TYPE_SHOP = 'shop';


	public $pages_list = array(
		'Thank you' => self::PAGE_TYPE_THANK,
		'Cart' => self::PAGE_TYPE_CART,
		'Shop' => self::PAGE_TYPE_SHOP,
	);

	/**
	 * @param array $page_ids
	 *
	 * @return void
	 */
	public function prodigy_pages_update_options( array $page_ids ) :void {
		foreach ($this->pages_list as $key=>$page) {
			if ( isset( $page_ids[$key] ) ) {
				update_option( 'prodigy_' . $page . '_page_id', $page_ids[$key] ?? '' );
			}
		}
	}


	/**
	 * @param string $page_name
	 *
	 * @return object|\WP_Post|null
	 */
	public function get_page_by_name( string $page_name ) {
		$prodigy_page_id = get_option( 'prodigy_' . $page_name . '_page_id' );

		return get_post($prodigy_page_id);
	}

	/**
	 * @param int $page_id
	 */
	public static function set_default_page_settings( $page_id ) {
		add_post_meta( $page_id, 'site-post-title', 'disabled' );
		add_post_meta( $page_id, 'site-sidebar-layout', 'no-sidebar' );
	}

	/**
	 * @param array $prodigy_pages
	 * @return array
	 */
	public function create_pages( array $prodigy_pages ) {
		$content_short_cart = false;
		$page_ids           = array();
		foreach ( $prodigy_pages as $page_data ) {
			$prodigy_page = $this->get_page_by_name( $page_data['name'] );
			if ( ! empty( $prodigy_page ) && in_array($page_data['name'], [self::PAGE_TYPE_CART, self::PAGE_TYPE_THANK], true) ) {
				$is_content = strpos( $prodigy_page->post_content, $page_data['content'] );
				if ( !$is_content ) {
					$content_short_cart = true;
				}
			}

			if ( empty( $prodigy_page ) ) {
				$post_data = array(
					'post_content' => $page_data['content'] ?? '',
					'post_title'   => $page_data['title'] ?? '',
					'post_name'    => $page_data['name'] ?? '',
					'post_type'    => 'page',
					'post_status'  => self::PRODIGY_PAGE_STATUS_PUBLISH,
				);

				$post = wp_insert_post( $post_data, true );
				if ( is_wp_error( $post ) ) {
					echo $post->get_error_message();
				}
				$page_ids[ $post_data['post_title'] ] = $post;
			} elseif (
				isset( $prodigy_page->post_status ) &&
				$prodigy_page->post_status !== self::PRODIGY_PAGE_STATUS_PUBLISH
			) {
				$post_data = array(
					'ID'          => $prodigy_page->ID ?? '',
					'post_status' => self::PRODIGY_PAGE_STATUS_PUBLISH,
				);

				$post = wp_update_post( $post_data, true );
				if ( is_wp_error( $post ) ) {
					echo $post->get_error_message();
				}
			}

			if ( $content_short_cart && in_array($page_data['name'], [self::PAGE_TYPE_CART, self::PAGE_TYPE_THANK], true) ) {
				$post_data = array(
					'ID'           => $prodigy_page->ID ?? '',
					'post_content' => $page_data['content'] ?? '',
				);

				$post = wp_update_post( $post_data, true );
				if ( is_wp_error( $post ) ) {
					echo $post->get_error_message();
				}
			}

			if ( isset( $prodigy_page->post_title, $prodigy_page->ID ) ) {
				$page_ids[ $prodigy_page->post_title ] = $prodigy_page->ID;
			}
		}

		return $page_ids;
	}

}
