<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Synchronization\Content\Prodigy_Process_Factory;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;

/**
 * Prodigy admin products class
 *
 * @version 2.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Products_List extends Prodigy_Admin_Page {

	/**
	 * Sync.
	 *
	 * @var Prodigy_Synchronization $sync
	 */
	public Prodigy_Synchronization $sync;

	/**
	 * Process factory.
	 *
	 * @var Prodigy_Process_Factory $process_factory
	 */
	public Prodigy_Process_Factory $process_factory;

	const PRODIGY_PRODUCTS_PAGE = 'prodigy_products';

	/**
	 * Prodigy_Admin_Menu constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->sync            = new Prodigy_Synchronization();
		$this->process_factory = new Prodigy_Process_Factory();
		add_action( 'admin_menu', array( $this, 'add_prodigy_products_menu' ), 10 );
		add_action( 'wp_ajax_prodigy-get-products-content', array( $this, 'prodigy_get_products_content' ) );
		add_action( 'wp_ajax_prodigy-start-sync-process', array( $this, 'prodigy_start_manual_sync_process' ) );
		add_action( 'wp_ajax_prodigy-check-sync-status', array( $this, 'check_sync_status' ) );
	}

	/**
	 * Start manual process
	 *
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function prodigy_start_manual_sync_process(): void {
		if ( ! check_ajax_referer( 'ajax-nonce', 'nonce' ) ) {
			return;
		}

		$this->process_factory->delete_queue_key( 'prodigy_set_synchronization_process_types' );
		$is_save_sync_options = $this->sync->run_sync_process( Prodigy_Api_Client::SYNC_CONTENT_URL, Prodigy_Synchronization::PRODIGY_MANUAL_PROCESS );
		if ( ! $is_save_sync_options && PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' Sync settings saving error', 'error' );
		}
	}

	/**
	 * @return void
	 */
	public function check_sync_status() {
		$status                       = get_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS );
		$is_need_to_show_notification = get_option( Prodigy_Synchronization::PRODIGY_NEEDS_SYNC_NOTIFICATION );
		if ( $status === 'success' && $is_need_to_show_notification ) {
			$this->reset_sync_process_options();
			wp_send_json_success( compact( 'status' ), 200 );
		} elseif ( $status === 'error' ) {
			$this->reset_sync_process_options();
			wp_send_json_error( compact( 'status' ), 404 );
		}
	}

	/**
	 * @return void
	 */
	public function reset_sync_process_options(): void {
		delete_option( Prodigy_Synchronization::PRODIGY_NEEDS_SYNC_NOTIFICATION );
		delete_option( Prodigy_Synchronization::PRODIGY_SYNC_MESSAGE_OPTION );
		delete_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS );
		delete_option( Prodigy_Synchronization::PRODIGY_SYNCHRONIZATION_TYPE );
	}

	/**
	 * Create products submenu
	 */
	public function add_prodigy_products_menu() {
		global $submenu;
		unset( $submenu[ 'edit.php?post_type=' . Prodigy::PRODIGY_POST_TYPE_DEFAULT ][15], $submenu[ 'edit.php?post_type=' . Prodigy::PRODIGY_POST_TYPE_DEFAULT ][16] );

		add_submenu_page(
			'',
			__( 'Prodigy Products', 'prodigy' ),
			__( 'Products list', 'prodigy' ),
			'edit_pages',
			self::PRODIGY_PRODUCTS_PAGE,
			array( $this, 'get_products_page' )
		);
	}


	/**
	 * @return void
	 */
	public function prodigy_get_products_content() {
		if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}
		$query = http_build_query( $_GET ) ?? '';
		parse_str( $query, $params );
		$product_url       = Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		$url               = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url;
		$product_params    = $this->parse_product_params( $query );
		$request_url       = add_query_arg( $product_params, $url );
		$products_response = $this->api_client->get_remote_content( $request_url );
		$products          = json_decode( wp_remote_retrieve_body( $products_response ), false );

		$total_count = $products->data[0]->attributes->{'products-count'} ?? 0;

		$base_url = admin_url();
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$base_url = remove_query_arg( 'pg', sanitize_url( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) );
		}

		$page              = sanitize_key( wp_unslash( $_GET['pg'] ?? 1 ) );
		$pagination_params = array(
			'pages'       => ! empty( $products->data ) ? Prodigy_Pagination::calculate_count_pages( (int) $total_count, (int) self::COUNT_ITEMS_ON_PAGE ) : 1,
			'url'         => $base_url,
			'page'        => Prodigy_Pagination::get_current_page( $product_params ),
			'page_number' => $page,
		);
		$sort              = '';

		if ( ! empty( $params['sort'] ) ) {
			if ( strripos( $params['sort'], '_asc' ) ) {
				$sort = 'asc';
			} else {
				$sort = 'desc';
			}
		}

		$result = array(
			'products'   => $products->data ?? null,
			'template'   => Prodigy_Template::prodigy_get_template_html(
				'prodigy-admin-products-list.php',
				array(
					'products' => $products->data ?? null,
					'search'   => $params['search'] ?? '',
					'count'    => $products->data[0]->attributes->{'products-count'} ?? 0,
					'sort'     => $sort ?? 'asc',
				),
				'admin'
			),
			'pagination' => Prodigy_Template::prodigy_get_template_html( 'shop/pagination.php', array( 'data' => $pagination_params ) ),
		);

		wp_send_json_success( $result );
	}

	/**
	 * @param string $query
	 *
	 * @return array
	 */
	public function parse_product_params( string $query ): array {
		if ( ! empty( $query ) ) {
			parse_str( urldecode( $query ), $request_attr );
		}

		if ( isset( $request_attr ) && ! empty( $request_attr['search'] ) ) {
			$params['search'] = $request_attr['search'];
		} elseif ( ! empty( $request_attr ) ) {
			$params['page']['size']   = self::COUNT_ITEMS_ON_PAGE;
			$params['page']['number'] = $request_attr['pg'] ?? 1;
		}

		if ( isset( $request_attr['sort'] ) ) {
			$patterns[0]    = '/_asc/';
			$patterns[1]    = '/_desc/';
			$replacements   = '';
			$sort           = preg_replace( $patterns, $replacements, $request_attr['sort'] );
			$params['sort'] = $sort;
		} else {
			$params['sort'] = '-created_at';
		}
		$params['admin'] = true;

		return $params;
	}

	/**
	 * Init the products page.
	 */
	public function get_products_page() {
		$this->render_view();
	}

	/**
	 * Render view from page
	 */
	public function render_view(): void {
		$products   = array();
		$empty_view = true;
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/prodigy-admin-products-list.php';
	}
}
