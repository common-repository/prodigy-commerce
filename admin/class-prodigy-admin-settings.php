<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Frontend\Pages\Prodigy_Page as Page;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Helper_Hosted_System;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Synchronization\Content\Prodigy_Process_Factory;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;

/**
 * Prodigy admin settings class
 *
 * @version 1.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Settings extends Prodigy_Admin_Page {
	/*
	* Tab actions
	*/
	const ACTION_GENERAL  = 'general';
	const ACTION_PRODUCTS = 'product';
	const ACTION_CACHE    = 'cache';
	const ACTION_PAGES    = 'pages';
	const ACTION_APPS     = 'apps';

	const SETTING_TABS = array(
		self::ACTION_GENERAL,
		self::ACTION_PRODUCTS,
		self::ACTION_CACHE,
		self::ACTION_PAGES,
		self::ACTION_APPS,
	);

	/*
	 * Menu slug
	 */
	const SETTINGS_PAGE = 'prodigy_settings';

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

	/**
	 * Cache.
	 *
	 * @var object Prodigy_Cache
	 */
	public $cache;

	/**
	 * Prodigy_Admin_Menu constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->cache           = new Prodigy_Cache();
		$this->sync            = new Prodigy_Synchronization();
		$this->process_factory = new Prodigy_Process_Factory();
		add_action( 'admin_menu', array( $this, 'add_prodigy_settings_menu' ), 11 );
		add_action( 'admin_enqueue_scripts', array( $this, 'prodigy_meta_box_load_style' ) );
		add_action( 'wp_ajax_update-store-info', array( $this, 'update_info_store' ) );
		add_action(
			'wp_ajax_prodigy-settings-start-manual-sync-process',
			array( $this, 'prodigy_start_manual_sync_process' )
		);
		add_action( 'wp_ajax_prodigy-cache-clear', array( $this, 'prodigy_cache_clear' ) );
		add_action( 'wp_ajax_prodigy-get-pages', array( $this, 'prodigy_get_pages_autoload' ) );
	}

	/**
	 * @return void
	 */
	public function prodigy_get_pages_autoload(): void {
		global $wpdb;

		if ( ! isset( $_GET['q'], $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}

		$search_parameter = sanitize_key( wp_unslash( $_GET['q'] ) );
		$pages            = $wpdb->get_results( $wpdb->prepare( "SELECT wp.id, wp.post_title FROM $wpdb->posts wp WHERE post_type='page' and post_status='publish' and post_title like %s ", '%' . $search_parameter . '%' ) );

		foreach ( $pages as $key => $page ) {
			$pages['items'][ $key ]['id']   = $page->id;
			$pages['items'][ $key ]['text'] = $page->post_title . ' (' . $page->id . ')';
		}

		wp_send_json_success( $pages );
	}

	/**
	 * Clear cache completely.
	 */
	public function prodigy_cache_clear(): void {
		if ( ! isset( $_POST['is_clear'], $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}

		$if_cleared = $this->cache->clear();
		if ( $if_cleared ) {
			wp_send_json_success();
		}
	}

	/**
	 * @return void
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function prodigy_start_manual_sync_process(): void {
		if ( ! isset( $_POST['sync'], $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
			return;
		}

		$this->process_factory->delete_queue_key( 'prodigy_set_synchronization_process_types' );
		$is_save_sync_options = $this->sync->run_sync_process( Prodigy_Api_Client::SYNC_CONTENT_URL, Prodigy_Synchronization::PRODIGY_MANUAL_PROCESS );
		if ( ! $is_save_sync_options && PRODIGY_DEBUG_MODE ) {
			do_action(
				'logger',
				__LINE__ . __METHOD__ . __CLASS__ . ' Sync settings saving error',
				'error'
			);
		}
	}

	/**
	 *  Load common scripts for meta boxes
	 */
	public function prodigy_meta_box_load_style(): void {
		$screen       = get_current_screen();
		$current_page = $screen->id ?? '';

		if ( in_array( $current_page, Prodigy::get_pages_list(), true ) ) {
			wp_enqueue_media();
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script(
				'jquery.validation.min',
				dirname( plugin_dir_url( __FILE__ ) ) . '/web/admin/js/jquery.validation.min.js',
				array( 'jquery' ),
				PRODIGY_VERSION,
				false
			);

			wp_enqueue_script(
				'jquery.inputmask.bundle.min',
				dirname( plugin_dir_url( __FILE__ ) ) . '/web/libraries/inputmask/js/jquery.inputmask.bundle.min.js',
				array( 'jquery' ),
				PRODIGY_VERSION,
				false
			);

			wp_enqueue_style(
				'inputmask',
				dirname( plugin_dir_url( __FILE__ ) ) . '/web/libraries/inputmask/css/inputmask.css',
				array(),
				PRODIGY_VERSION
			);
		}

		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		$screen       = get_current_screen();
		$current_page = $screen->id ?? '';

		if ( in_array( $current_page, Prodigy::get_pages_list(), true ) ) {
			wp_enqueue_script(
				'tag-it.min',
				dirname( plugin_dir_url( __FILE__ ) ) . '/web/admin/js/tag-it.min.js',
				array( 'jquery' ),
				PRODIGY_VERSION,
				true
			);
		}
	}

	/**
	 * Update info store from hosted system
	 */
	public function update_info_store(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'You don\'t have access', 403 );
		}

		$subdomain = get_option( 'pg_url_domain_hosted_system' );

		if ( empty( $subdomain ) ) {
			wp_send_json_error( esc_html__( 'No connection', 'prodigy' ), 422 );
		}

		$api_url       = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::API_CONNECTION_URL;
		$request_store = $this->api_client->get_remote_content( $api_url );

		if ( array_key_exists( 'error', $request_store ) ) {
			wp_send_json_error( $request_store['message'], $request_store['code'] );
		}

		$status_code = (int) wp_remote_retrieve_response_code( $request_store );

		if ( 200 === $status_code ) {
			$result_body = json_decode( wp_remote_retrieve_body( $request_store ), false );

			update_option( 'pg_domain_hosted_system', $result_body->data->attributes->name );
			update_option( 'pg_url_domain_hosted_system', $result_body->data->attributes->subdomain );

			$data['pg_domain_hosted_system']     = get_option( 'pg_domain_hosted_system' );
			$data['pg_url_domain_hosted_system'] = esc_url( Prodigy_Helper_Hosted_System::get_url_home() );
			$data['message']                     = esc_html__( 'Data updated successfully', 'prodigy' );
			wp_send_json_success( $data );
		} else {
			$errors  = $this->api_client->get_list_errors( $request_store );
			$message = wp_remote_retrieve_response_message( $request_store ) . '. ' . implode( ', ', $errors );
			wp_send_json_error( $message, $status_code );
		}

		wp_die();
	}

	/**
	 * Create settings submenu
	 */
	public function add_prodigy_settings_menu(): void {
		$menu_setting_page = add_submenu_page(
			'edit.php?post_type=' . Prodigy::get_prodigy_product_type(),
			esc_html__( 'Prodigy Settings', 'prodigy' ),
			esc_html__( 'Settings', 'prodigy' ),
			'edit_pages',
			self::SETTINGS_PAGE,
			array( $this, 'display_page' )
		);

		add_action( 'load-' . $menu_setting_page, array( $this, 'save_settings' ) );
	}


	/**
	 * Render view for page
	 */
	public static function display_page(): void {
		$settings = array(
			'current_tab' => self::get_current_tab(),
			'tabs'        => self::get_settings_fields(),
		);

		extract( $settings );
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/prodigy-admin-settings-page.php';
	}

	/**
	 * @return void
	 */
	public function save_settings(): void {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'admin-settings' ) ) {
			return;
		}

		$request_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
		if ( ! empty( $_POST ) && $request_page === self::SETTINGS_PAGE ) {
			if ( $this->save_fields() ) {
				Prodigy_Admin_Notification::display_success( esc_html__( 'Your settings have been saved', 'prodigy' ) );
			}
		}
	}

	/**
	 * @param array $field
	 *
	 * @return void
	 */
	private function save_field( array $field ): void {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'admin-settings' ) ) {
			return;
		}

		$is_checkbox = $field['type'] === 'checkbox';
		$name        = $field['name'] ?? $field['id'];
		$value       = isset( $_POST[ $name ] ) ? sanitize_key( wp_unslash( $_POST[ $name ] ) ) : '';

		if ( ! isset( $_POST[ $name ] ) && ! $is_checkbox ) {
			return;
		}
		if ( $is_checkbox ) {
			$value = intval( 'on' === $value );
		}

		$value = Prodigy_Formatting::prodigy_sanitize_field( $value, $field['type'] );
		update_option( $field['id'], $value );

		if ( isset( $field['fields'] ) && is_array( $field['fields'] ) ) {
			foreach ( $field['fields'] as $field ) {
				$this->save_field( $field );
			}
		}
	}

	/**
	 * Save Settings
	 *
	 * @return bool
	 */
	public function save_fields(): bool {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ), 'admin-settings' ) ) {
			return false;
		}

		$result          = false;
		$tab_current     = self::get_current_tab();
		$settings_fields = self::get_settings_fields();
		$settings_fields = $settings_fields[ $tab_current ];
		if ( ! isset( $settings_fields['fields'] ) ) {
			return false;
		}

		$settings_fields = $settings_fields['fields'];
		foreach ( $settings_fields as $field ) {
			$this->save_field( $field );
			$result = true;
		}

		wp_cache_flush();

		$current_product_type = Prodigy::get_prodigy_product_type();
		$new_product_type     = get_option( 'pg_product_type_slug' );

		$current_category_type = Prodigy::get_prodigy_category_type();
		$new_category_type     = get_option( 'pg_category_type_slug' );

		$current_tag_type = Prodigy::get_prodigy_tag_type();
		$new_tag_type     = get_option( 'pg_tag_type_slug' );

		$redirect_setting = false;
		if ( isset( $_POST['prodigy_cart_page_id'], $_POST['prodigy_thank_page_id'] ) ) {
			if ( $_POST['prodigy_thank_page_id'] === $_POST['prodigy_cart_page_id'] ) {
				update_option( 'prodigy_cart_page_id', '' );
				$redirect_setting = true;
			}
		}

		if ( ! empty( $new_product_type ) && $current_product_type !== $new_product_type ) {
			wp_cache_flush();
			update_option( 'pg_product_type_slug', $new_product_type );
			$redirect_setting = true;
		}

		if ( ! empty( $new_category_type ) && $current_category_type !== $new_category_type ) {
			wp_cache_flush();
			update_option( 'pg_category_type_slug', $new_category_type );
			$redirect_setting = true;
		}

		if ( ! empty( $new_tag_type ) && $current_tag_type !== $new_tag_type ) {
			wp_cache_flush();
			update_option( 'pg_tag_type_slug', $new_tag_type );
			$redirect_setting = true;
		}

		update_option( 'prodigy_queue_flush_rewrite_rules', 'yes' );

		if ( $redirect_setting ) {
			self::redirect_to_settings( isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : $new_product_type );
		}

		return $result;
	}

	/**
	 * @param string $tab
	 *
	 * @return void
	 */
	public static function redirect_to_settings( string $tab ): void {
		Prodigy_Admin_Notification::display_success( esc_html__( 'Your settings have been saved', 'prodigy' ) );
		$admin_url = prodigy_get_admin_url(
			'edit.php',
			array(
				'post_type' => Prodigy::get_prodigy_product_type(),
				'page'      => self::SETTINGS_PAGE,
				'tab'       => $tab,
				'_wpnonce'  => wp_create_nonce( 'admin-tab' ),
			)
		);

		wp_safe_redirect( $admin_url );
		exit;
	}

	/**
	 * List of pages for setting store display
	 *
	 * @return array|false
	 */
	public static function get_post_pages() {
		return get_pages();
	}

	/**
	 * @return string
	 */
	public static function get_current_tab(): string {
		global $tab_current;

		if ( $tab_current ) {
			return $tab_current;
		}

		if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'admin-tab' ) ) {
			$request_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
			$tab_current = ! in_array(
				$request_tab,
				self::SETTING_TABS,
				true
			) ? self::ACTION_GENERAL : sanitize_title(
				wp_unslash( $request_tab ),
				true
			);
		} else {
			$tab_current = self::ACTION_GENERAL;
		}

		return $tab_current;
	}

	/**
	 * Get page option.
	 *
	 * @param string $page_id
	 *
	 * @return array
	 */
	public static function get_page_option( string $page_id ): array {
		$page = get_post( $page_id );
		if ( ! empty( $page ) && ( $page->post_status === 'publish' || $page->post_status === 'draft' ) ) {
			$page_title = $page->post_title ?? '';
			return array( $page_id => "$page_title ($page_id)" );
		}

		return array();
	}

	/**
	 * @return array[]
	 */
	private static function get_settings_fields(): array {
		$cart_page_id     = Prodigy_Page::prodigy_get_page_id( Page::PAGE_TYPE_CART );
		$cart_page_option = self::get_page_option( $cart_page_id );

		$thank_page_id     = Prodigy_Page::prodigy_get_page_id( Page::PAGE_TYPE_THANK );
		$thank_page_option = self::get_page_option( $thank_page_id );

		$shop_page_id     = Prodigy_Page::prodigy_get_page_id( Page::PAGE_TYPE_SHOP );
		$shop_page_option = self::get_page_option( $shop_page_id );

		return array(
			self::ACTION_GENERAL  => array(
				'title'    => esc_html__( 'General', 'prodigy' ),
				'template' => array(
					'is_connected'         => (bool) get_option( 'pg_store_key' ),
					'domain_hosted_system' => get_option( 'pg_domain_hosted_system', 'Store name domain hosted' ),
				),
			),
			self::ACTION_PRODUCTS => array(
				'title'  => esc_html__( 'Products', 'prodigy' ),
				'fields' => array(
					array(
						'type'  => 'section_title',
						'label' => esc_html__( 'Shop pages', 'prodigy' ),
						'id'    => 'prodigy_shop_section_title',
					),
					array(
						'label'   => esc_html__( 'Shop page', 'prodigy' ),
						'type'    => 'dropdown',
						'id'      => 'prodigy_shop_page_id',
						'class'   => 'prodigy-init-page-select',
						'value'   => $shop_page_id,
						'options' => $shop_page_option,
					),
					array(
						'label'       => esc_html__( 'Customize Product page URL', 'prodigy' ),
						'type'        => 'text',
						'class'       => 'prodigy-type-slug-js',
						'id'          => 'pg_product_type_slug',
						'value'       => Prodigy::get_prodigy_product_slug(),
						'placeholder' => Prodigy::get_prodigy_product_type(),
					),
					array(
						'label'       => esc_html__( 'Customize Category page URL', 'prodigy' ),
						'type'        => 'text',
						'class'       => 'prodigy-type-slug-js',
						'id'          => 'pg_category_type_slug',
						'value'       => Prodigy::get_prodigy_category_slug(),
						'placeholder' => Prodigy::get_prodigy_category_type(),
					),
					array(
						'label'       => esc_html__( 'Customize Tag page URL', 'prodigy' ),
						'type'        => 'text',
						'class'       => 'prodigy-type-slug-js',
						'id'          => 'pg_tag_type_slug',
						'value'       => Prodigy::get_prodigy_tag_slug(),
						'placeholder' => Prodigy::get_prodigy_tag_type(),
					),
					array(
						'label'   => esc_html__( 'Add to cart behaviour', 'prodigy' ),
						'type'    => 'radio',
						'class'   => 'prodigy-main-radio',
						'id'      => 'pg_add_cart_behaviour',
						'options' => array(
							'redirect_to_cart' => esc_html__(
								'Redirect to the cart page after successful addition',
								'prodigy'
							),
							'current_page'     => esc_html__(
								'Update cart widget and remain on current page',
								'prodigy'
							),
						),
					),
					array(
						'label'   => esc_html__( 'Cart expiration time', 'prodigy' ),
						'type'    => 'dropdown',
						'class'   => 'prodigy-plugin-settings__select mb-12 expiration-time-js',
						'id'      => 'pg_cart_expiration_time',
						'options' => array(
							'1'      => esc_html__( '1 hour', 'prodigy' ),
							'5'      => esc_html__( '5 hour', 'prodigy' ),
							'24'     => esc_html__( '24 hour', 'prodigy' ),
							'48'     => esc_html__( '48 hour', 'prodigy' ),
							'168'    => esc_html__( '1 week (168h)', 'prodigy' ),
							'672'    => esc_html__( '4 weeks (672h)', 'prodigy' ),
							'custom' => esc_html__( 'Custom value', 'prodigy' ),
						),
						'fields'  => array(
							array(
								'label'       => '',
								'type'        => 'text',
								'class'       => 'prodigy-plugin-settings__input expiration-custom-js hidden',
								'id'          => 'pg_custom_expiration_time',
								'placeholder' => esc_attr__( 'from 1h to 9999h', 'prodigy' ),
							),
						),
					),
					array(
						'type'  => 'section_title',
						'label' => esc_html__( 'Reviews', 'prodigy' ),
						'id'    => 'prodigy_reviews_section_title',
					),
					array(
						'label' => esc_html__( 'Enable reviews', 'prodigy' ),
						'text'  => esc_html__( 'Enable product reviews', 'prodigy' ),
						'type'  => 'checkbox',
						'class' => 'main-checkbox__input',
						'id'    => 'pg_product_review',
					),
					array(
						'label' => esc_html__( 'Product ratings', 'prodigy' ),
						'text'  => esc_html__( 'Enable star rating on reviews', 'prodigy' ),
						'type'  => 'checkbox',
						'class' => 'main-checkbox__input',
						'id'    => 'pg_product_rating',
					),
					array(
						'label' => esc_html__( 'Captcha comments', 'prodigy' ),
						'text'  => esc_html__( 'Enable captcha comments', 'prodigy' ),
						'type'  => 'checkbox',
						'class' => 'main-checkbox__input captcha-launch-js',
						'id'    => 'pg_captcha_launch',
					),
					array(
						'label'         => esc_html__( 'Captcha site key', 'prodigy' ),
						'type'          => 'text',
						'wrapper-class' => 'captcha-block-js',
						'id'            => 'pg_captcha_site_key',
					),
					array(
						'label'         => esc_html__( 'Captcha secret key', 'prodigy' ),
						'description'   => esc_html__(
							'Please make sure you accurately copy and paste the Captcha site key and secret key into the fields above',
							'prodigy'
						),
						'type'          => 'text',
						'wrapper-class' => 'captcha-block-js',
						'id'            => 'pg_captcha_secret_key',
					),
				),
			),
			self::ACTION_CACHE    => array(
				'title'  => esc_html__( 'Cache', 'prodigy' ),
				'fields' => array(
					array(
						'type'  => 'section_title',
						'label' => esc_html__( 'Plugin cache', 'prodigy' ),
						'id'    => 'prodigy_cache_section_title',
					),
					array(
						'label' => esc_html__( 'Enable caching', 'prodigy' ),
						'text'  => esc_html__( 'Enable caching', 'prodigy' ),
						'type'  => 'checkbox',
						'class' => 'main-checkbox__input',
						'id'    => Prodigy_Cache::CACHE_STATE_OPTION,
					),
					array(
						'label'   => esc_html__( 'Cache expiration time', 'prodigy' ),
						'type'    => 'dropdown',
						'class'   => 'prodigy-plugin-settings__select mb-12 pg-cache-expiration-time-js ',
						'id'      => Prodigy_Cache::EXPIRATION_TIME_OPTION,
						'options' => array(
							'60'     => esc_html__( '1 minute', 'prodigy' ),
							'300'    => esc_html__( '5 minutes', 'prodigy' ),
							'900'    => esc_html__( '15 minutes', 'prodigy' ),
							'1800'   => esc_html__( '30 minutes', 'prodigy' ),
							'3600'   => esc_html__( '1 hour', 'prodigy' ),
							'custom' => esc_html__( 'Custom value', 'prodigy' ),
						),
						'value'   => get_option( Prodigy_Cache::EXPIRATION_TIME_OPTION ),
						'fields'  => array(
							array(
								'label'       => '',
								'type'        => 'text',
								'class'       => 'prodigy-plugin-settings__input pg-cache-expiration-custom-js hidden',
								'id'          => Prodigy_Cache::CUSTOM_EXPIRATION_TIME_OPTION,
								'placeholder' => esc_attr__( 'from 1h to 9999h', 'prodigy' ),
							),
						),
					),
				),
			),
			self::ACTION_PAGES    => array(
				'title'  => esc_html__( 'Pages', 'prodigy' ),
				'fields' => array(
					array(
						'type'  => 'section_title',
						'label' => esc_html__( 'Pages setup', 'prodigy' ),
						'id'    => 'prodigy_pages_section_title',
					),
					array(
						'label'   => esc_html__( 'Cart page', 'prodigy' ),
						'type'    => 'dropdown',
						'class'   => 'prodigy-init-page-select',
						'id'      => 'prodigy_cart_page_id',
						'value'   => $cart_page_id,
						'options' => $cart_page_option,
					),
					array(
						'label'   => esc_html__( 'Thank you page', 'prodigy' ),
						'type'    => 'dropdown',
						'class'   => 'prodigy-init-page-select',
						'id'      => 'prodigy_thank_page_id',
						'value'   => $thank_page_id,
						'options' => $thank_page_option,
					),
				),
			),
			self::ACTION_APPS     => array(
				'title'  => esc_html__( 'Apps', 'prodigy' ),
				'fields' => array(
					array(
						'type'  => 'section_title',
						'label' => esc_html__( 'Google Analytics', 'prodigy' ),
						'id'    => 'prodigy_apps_section_title',
					),
					array(
						'label' => esc_html__( 'Enable GA', 'prodigy' ),
						'text'  => esc_html__( 'Enable Google Analytics', 'prodigy' ),
						'type'  => 'checkbox',
						'class' => 'main-checkbox__input',
						'id'    => 'pg_enable_google_analytics',
					),
					array(
						'type'  => 'hidden',
						'id'    => 'pg_enable_google_analytics_hidden',
						'value' => '1',
					),
				),
			),
		);
	}
}
