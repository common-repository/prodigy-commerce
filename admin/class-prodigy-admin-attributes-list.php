<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Models\Prodigy_Attribute_Taxonomies;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Pagination;

/**
 * Prodigy admin attributes class
 *
 * @version 2.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Attributes_List extends Prodigy_Admin_Page {

	const ATTRIBUTES_PAGE = 'prodigy_attributes';
	const PATH_PROPERTIES = '/properties';

	/** @var object $product_attributes Prodigy_Product_Attributes */
	public $product_attributes;

	/**
	 * Prodigy_Admin_Menu constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'admin_menu', array( $this, 'add_prodigy_attributes_menu' ) );
		add_action( 'wp_ajax_prodigy-get-attributes-content', array( $this, 'prodigy_get_attributes_content' ) );
		$this->product_attributes = new Prodigy_Product_Attributes();
	}


	/**
	 * @return void
	 */
	public function prodigy_get_attributes_content() {
		if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}

		$query = http_build_query( $_GET ) ?? '';
		parse_str( $query, $params );

		$attribute_params    = $this->parse_attribute_params( $query, self::COUNT_ITEMS_ON_PAGE );
		$product_url         = Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		$api_url             = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . self::PATH_PROPERTIES;
		$request_url         = add_query_arg( $attribute_params, $api_url );
		$response_attributes = $this->api_client->get_remote_content( $request_url );
		$data_attributes     = json_decode( wp_remote_retrieve_body( $response_attributes ), true );
		$attributes          = $this->prepare_attributes( $data_attributes ?? array() );

		$base_url = admin_url();
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$base_url = remove_query_arg( 'pg', sanitize_url( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) );
		}

		$pagination_params = array(
			'pages'       => isset( $attributes['meta']['total_count'] ) ? Prodigy_Pagination::calculate_count_pages( (int) $attributes['meta']['total_count'], self::COUNT_ITEMS_ON_PAGE ) : 1,
			'url'         => $base_url,
			'page'        => Prodigy_Pagination::get_current_page( $attribute_params ),
			'page_number' => sanitize_url( wp_unslash( $_GET['pg'] ?? 1 ) ),
		);

		if ( ! empty( $params['sort'] ) ) {
			if ( strripos( $params['sort'], '_asc' ) ) {
				$sort = 'asc';
			} else {
				$sort = 'desc';
			}
		}

		$result = array(
			'attributes' => $attributes,
			'template'   => Prodigy_Template::prodigy_get_template_html(
				'prodigy-admin-attributes-list.php',
				array(
					'attributes' => $attributes,
					'search'     => $params['search'] ?? '',
					'sort'       => $sort ?? '',
					'count'      => $attributes['meta']['total_count'] ?? 0,
				),
				'admin'
			),
			'pagination' => Prodigy_Template::prodigy_get_template_html( 'shop/pagination.php', array( 'data' => $pagination_params ) ),
		);

		wp_send_json_success( $result );
	}

	/**
	 * @param array $attributes
	 *
	 * @return array
	 */
	private function prepare_attributes( array $attributes ): array {
		if ( ! isset( $attributes['data'] ) ) {
			return array();
		}
		foreach ( $attributes['data'] as $key => $attribute ) {
			$attributes['data'][ $key ]['is_synced'] = Prodigy_Attribute_Taxonomies::remote_id_exists( $attribute['id'] );
		}

		return $attributes;
	}

	/**
	 * @param string $query
	 * @param int    $count_items_per_page
	 *
	 * @return array
	 */
	public function parse_attribute_params( string $query, int $count_items_per_page ): array {
		if ( ! empty( $query ) ) {
			parse_str( urldecode( $query ), $request_attr );
		}

		if ( ! empty( $request_attr['search'] ) ) {
			$attribute_params['search'] = $request_attr['search'];
		}

		if ( isset( $request_attr['sort'] ) ) {
			$patterns[0]              = '/_asc/';
			$patterns[1]              = '/_desc/';
			$replacements             = '';
			$sort                     = preg_replace( $patterns, $replacements, $request_attr['sort'] );
			$attribute_params['sort'] = $sort;
		} else {
			$attribute_params['sort'] = 'name';
		}

		$attribute_params['page']['size']   = $count_items_per_page;
		$attribute_params['page']['number'] = $request_attr['pg'] ?? 1;

		$attribute_params['admin'] = true;

		return $attribute_params;
	}

	/**
	 * Create attributes submenu
	 */
	public function add_prodigy_attributes_menu() {
		add_submenu_page(
			'edit.php?post_type=' . Prodigy::get_prodigy_product_type(),
			__( 'Prodigy Attributes', 'prodigy' ),
			__( 'Attributes', 'prodigy' ),
			'edit_pages',
			self::ATTRIBUTES_PAGE,
			array( $this, 'get_attributes_page' )
		);
	}

	/**
	 * Init the attributes page.
	 */
	public function get_attributes_page() {
		$this->render_view();
	}

	/**
	 * Render the attributes list.
	 */
	public function render_view() {
		$empty_view = true;
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/prodigy-admin-attributes-list.php';
	}
}
