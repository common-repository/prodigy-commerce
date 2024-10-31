<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;

/**
 * Prodigy admin categories class
 *
 * @version 2.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Categories_List extends Prodigy_Admin_Page {

	const PRODIGY_CATEGORIES_PAGE = 'prodigy_categories';

	/**
	 * Prodigy_Admin_Menu constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'admin_menu', array( $this, 'add_prodigy_categories_menu' ) );
		add_action( 'wp_ajax_prodigy-get-categories-content', array( $this, 'prodigy_get_categories_content' ) );
	}

	/**
	 * Get categories list
	 */
	public function prodigy_get_categories_content() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}

		$query = isset( $_POST['query'] ) ? esc_url_raw( wp_unslash( $_POST['query'] ) ) : '';
		parse_str( $query, $params );
		$category_url        = Prodigy_Api_Client::CATEGORY_ADMIN_URL;
		$api_url             = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $category_url;
		$query_params        = $this->parse_category_params( $query );
		$request_url         = add_query_arg(
			array(
				$query_params,
				'include' => 'parent,children',
			),
			$api_url
		);
		$response_categories = $this->api_client->get_remote_content( $request_url );
		$categories          = json_decode( wp_remote_retrieve_body( $response_categories ), true );

		$mapped_categories = array();
		if ( ! empty( $categories ) ) {
			$mapped_categories = $this->prepare_categories_tree( $categories['data'] );
		}

		$result = array(
			'data'       => $categories['data'] ?? null,
			'categories' => Prodigy_Template::prodigy_get_template_html(
				'prodigy-admin-categories-list.php',
				array(
					'categories' => $mapped_categories,
					'search'     => $params['search'] ?? '',
					'count'      => $categories['meta']['total_categories_count'] ?? 0,
				),
				'admin'
			),
		);

		wp_send_json_success( $result );
	}

	/**
	 * @param array      $categories
	 * @param int        $depth
	 * @param array|null $ids
	 * @param array      $result
	 *
	 * @return array
	 */
	public function prepare_categories( array $categories, int $depth = 0, array $ids = null, array $result = array() ): array {
		$query = isset( $_POST['query'] ) ? esc_url_raw( wp_unslash( $_POST['query'] ) ) : '';
		parse_str( $query, $params );
		foreach ( $categories as $category ) {
			$cat_info     = array(
				'category' => array_merge(
					$category['attributes'],
					array(
						'id'        => $category['id'],
						'is_synced' => $this->is_category_synced( (int) $category['id'] ),
					)
				),
			);
			$children_ids = array();
			if ( ! empty( $category['relationships']['children']['data'] ) ) {
				foreach ( $category['relationships']['children']['data'] as $child ) {
					$children_ids[] = $child['id'];
				}
			}

			if ( ! empty( $params['search'] ) && ( $ids === null || in_array( $category['id'], $ids, true ) ) ) {
				$cat_info['children']                          = $this->prepare_categories( $categories, $category['attributes']['depth'], $children_ids, $result );
				$result[ $category['attributes']['position'] ] = $cat_info;
			} elseif ( $category['attributes']['depth'] === $depth && ( $ids === null || in_array( $category['id'], $ids, true ) ) ) {
				$cat_info['children']                          = $this->prepare_categories( $categories, $depth + 1, $children_ids );
				$result[ $category['attributes']['position'] ] = $cat_info;
			}
		}
		ksort( $result );

		return $result;
	}
	/**
	 * @param array $categories
	 *
	 * @return array
	 */
	public function prepare_categories_tree( array $categories ): array {
		$root_categories = array();
		foreach ( $categories as $category ) {
			if ( 0 === $category['attributes']['depth'] ) {
				$root_categories[ $category['id'] ]              = $category;
				$root_categories[ $category['id'] ]['is_synced'] = $this->is_category_synced( (int) $category['id'] );
			}
		}

		foreach ( $categories as $category ) {
			if ( 0 === $category['attributes']['position'] ) {
				$root_categories[ $category['id'] ]              = $category;
				$root_categories[ $category['id'] ]['is_synced'] = $this->is_category_synced( (int) $category['id'] );
			}
		}

		$new_categories['root']     = $root_categories;
		$new_categories['prepared'] = $this->prepare_categories( $categories );

		return $new_categories;
	}

	/**
	 * @param int $category_id
	 *
	 * @return bool
	 */
	private function is_category_synced( int $category_id ): bool {
		return (bool) Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', $category_id );
	}

	/**
	 * @param string $query
	 *
	 * @return array
	 */
	public function parse_category_params( string $query ): array {
		if ( ! empty( $query ) ) {
			parse_str( urldecode( $query ), $request_attr );
		}

		if ( ! empty( $request_attr['search'] ) ) {
			$params['search'] = $request_attr['search'];
		}

		$params['sort']  = '-created_at';
		$params['admin'] = true;

		return $params;
	}

	/**
	 * Create products submenu
	 */
	public function add_prodigy_categories_menu() {

		add_submenu_page(
			'edit.php?post_type=' . Prodigy::get_prodigy_product_type(),
			__( 'Prodigy Categories', 'prodigy' ),
			__( 'Categories', 'prodigy' ),
			'edit_pages',
			self::PRODIGY_CATEGORIES_PAGE,
			array( $this, 'get_categories_page' )
		);
	}

	/**
	 * Init the attributes page.
	 */
	public function get_categories_page() {
		$this->render_view();
	}

	/**
	 * Render view from page
	 */
	public function render_view() {
		$empty_view = true;
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/prodigy-admin-categories-list.php';
	}
}
