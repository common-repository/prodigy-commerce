<?php

/**
 * Setup Wizard Class
 *
 * @version    2.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes;

use Prodigy\Includes\Helpers\Traits\TraitProdigySidebar;
use Prodigy\Includes\Content\Prodigy_Api_Client;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Authentication
 */
if ( ! is_user_logged_in() ) {
	auth_redirect();
	exit();
}

/**
 * Prodigy_Admin_Setup_Wizard class.
 */
class Prodigy_Admin_Setup_Wizard {
	use TraitProdigySidebar;

	const LENGTH_CHARACTERS_TOKEN  = 30;
	const NAME_TOKEN_HOSTED_SYSTEM = 'pg_token_hosted_system';
	const SYNC_CONTENT_FALSE       = 'no';

	/**
	 * Current step
	 *
	 * @var int
	 */
	private $step = 1;

	/**
	 * Connected to hosted system
	 *
	 * @var bool
	 */
	private $is_connected = false;

	/**
	 * Steps for the setup wizard
	 *
	 * @var array
	 */
	private array $steps = array(
		1 => 'connect_wizard_content',
		2 => 'install_demo_content',
	);

	/**
	 * @var array
	 */
	private array $page_header_steps;

	/**
	 * @var array
	 */
	private array $page_header_content;

	/**
	 * @var void
	 */
	private $url_domain_hosted_system;

	/**
	 * @var void
	 */
	private $domain_hosted_system;

	/**
	 * @var bool
	 */
	private $is_created_products;

	/**
	 * @var bool
	 */
	private $is_created_categories;

	/**
	 * @var int
	 */
	private $saved_step;

	/**
	 * @var array
	 */
	private $ignore_statuses_product = array( 'auto-draft', 'draft' );

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$this->page_header_steps = array(
			1 => __( 'Connection', 'prodigy' ),
			2 => __( 'Demo Content', 'prodigy' ),
		);

		$this->page_header_content = array(
			1 => __( 'Data Synchronization', 'prodigy' ),
			2 => __( 'Prodigy Demo Content', 'prodigy' ),
		);

		/*
		 * Get token from hosted system
		 */
		$new_token = isset( $_GET['token'] ) ? filter_var( wp_unslash( $_GET['token'] ), FILTER_SANITIZE_STRIPPED ) : null;

		if ( ! empty( $new_token ) ) {
			$store_connector = new Prodigy_Connection();
			if ( $store_connector->is_store_already_connected( $new_token ) ) {
				return;
			}

			if ( $store_connector->has_connected_store() ) {
				$store_connector->disconnect_store();
				$this->clear_content_for_old_store();
			}

			$store_connector->connect_store( $new_token, new Prodigy_Api_Client() );

			$this->sync_analytics_key();
			$this->clear_store_settings();
		}

		/*
		 * Clear data before to connect to hosted system
		 */
		if ( ! empty( $_GET['clear'] ) ) {
			$this->clear_data_before_connect();
		}

		if (
			! empty( $_GET['redirect_hosted_system'] ) &&
			( isset( $_GET['_wpnonce'] ) || wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'wizard-form' ) )
		) {
			$this->redirect_to_hosted_system();
		}

		$this->is_connected             = get_option( 'pg_store_key' );
		$this->saved_step               = get_option( 'pg_step_wizard' );
		$this->domain_hosted_system     = get_option( 'pg_domain_hosted_system', __( 'Store name domain hosted', 'prodigy' ) );
		$this->url_domain_hosted_system = get_option( 'pg_url_domain_hosted_system', __( 'Store url domain hosted', 'prodigy' ) );
		$this->is_created_products      = $this->is_created_products();
		$this->is_created_categories    = $this->is_created_categories();
		$this->set_step();

		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wizard_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, 'setup_wizard' ) );
		add_action( 'admin_init', array( $this, 'get_terms_prodigy' ) );
	}

	public function clear_content_for_old_store() {
		Prodigy_Uninstall_Plugin::delete_products();
		Prodigy_Uninstall_Plugin::delete_categories();
		Prodigy_Uninstall_Plugin::delete_attributes_terms();
	}

	/**
	 * Set google analytics key
	 */
	public function sync_analytics_key() {
		$api_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::GET_SOCIAL_ACCOUNTS_URL;
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', $api_url, 'analytic url' );
		}
		$api_client    = new Prodigy_Api_Client();
		$result        = $api_client->get_remote_content( $api_url );
		$response_body = json_decode( wp_remote_retrieve_body( $result ), true );
		$code          = $response_body['data']['attributes']['external-key'] ?? '';
		update_option( 'pg_google_analytics_code', $code );
	}

	/**
	 * reset demo settings for new store
	 */
	public function clear_store_settings() {
		delete_option( 'prodigy_demo_content' );
	}


	/**
	 * Add admin menus/screens.
	 */
	public function admin_menus() {
		add_dashboard_page( '', '', 'manage_options', 'prodigy-setup', '' );
	}

	/**
	 * check exist categories
	 *
	 * @return bool
	 */
	public function is_created_categories(): bool {

		$count_cats = wp_count_terms( Prodigy::get_prodigy_category_type() );

		/*
		 * ignore default category
		 */
		if ( $count_cats == 1 ) {
			$count_cats = 0;
		}

		return (bool) $count_cats;
	}

	/**
	 * check exist products
	 *
	 * @return bool
	 */
	public function is_created_products(): bool {
		$count = 0;

		$count_posts = wp_count_posts( Prodigy::get_prodigy_product_type() );

		if ( ! $count_posts ) {
			return (bool) $count;
		}

		foreach ( $count_posts as $key => $val ) {
			if ( in_array( $key, $this->ignore_statuses_product, true ) ) {
				continue;
			}

			if ( $val > 0 ) {
				$count = $val;
				break;
			}
		}

		return (bool) $count;
	}

	/**
	 * clear products, categories and attributes and redirect to dashboard
	 *
	 * @return string|void
	 */
	public function clear_data_before_connect() {

		if ( get_option( 'pg_story_key' ) ) {
			$nonce = wp_create_nonce( 'wizard-form' );
			return admin_url( 'index.php?page=prodigy-setup&_wpnonce=' . $nonce );
		}

		$this->clear_pg_content();
		$nonce = wp_create_nonce( 'wizard-form' );
		return admin_url( 'index.php?page=prodigy-setup&_wpnonce=' . $nonce );
	}

	/**
	 * clear products, categories and attributes
	 *
	 * @return string|void
	 */
	public function clear_pg_content() {

		if ( get_option( 'pg_story_key' ) ) {
			$nonce = wp_create_nonce( 'wizard-form' );
			return admin_url( 'index.php?page=prodigy-setup&_wpnonce=' . $nonce );
		}

		$this->clear_content_for_old_store();
	}

	/**
	 * Show the setup wizard.
	 */
	public function setup_wizard() {
		if ( isset( $_GET['token'] ) ) {
			$nonce = isset( $_GET[ esc_attr( 'amp;_wpnonce' ) ] ) ? sanitize_text_field( wp_unslash( $_GET[ esc_attr( 'amp;_wpnonce' ) ] ) ) : '';
		} else {
			$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
		}

		if ( ! isset( $nonce ) || ! wp_verify_nonce( sanitize_key( $nonce ), 'wizard-form' ) ) {
			return;
		}

		if ( empty( $_GET['page'] ) || 'prodigy-setup' !== $_GET['page'] ) {
			return;
		}

		$step_template = $this->get_template_content_wizard();

		$this->setup_wizard_header();
		$this->$step_template();
		$this->setup_wizard_footer();

		exit;
	}

	/**
	 * Wrapper for set_time_limit to see if it is enabled.
	 *
	 * @param int $limit Time limit.
	 */
	public function pg_set_time_limit( $limit = 0 ) {
		if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.safe_modeDeprecatedRemoved
            @set_time_limit( $limit ); // @codingStandardsIgnoreLine
		}
	}

	/**
	 * set step for wizard
	 */
	public function set_step() {
		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'wizard-form' ) ) {
			return;
		}

		if ( esc_url_raw( wp_unslash( isset( $_GET['step'] ) ) ) && $this->is_connected ) {
			$this->step = sanitize_text_field( wp_unslash( $_GET['step'] ) );
		}
	}

	/**
	 * @return string
	 */
	public function get_url_login_hosted_system(): string {
		return wp_nonce_url( admin_url( 'index.php?page=prodigy-setup&redirect_hosted_system=1' ), 'wizard-form' );
	}

	public function redirect_to_hosted_system() {

		$sync_content = get_option( 'pg_indicator_sync_content' );

		if ( $sync_content == self::SYNC_CONTENT_FALSE ) {
			$this->clear_pg_content();
		}

		$this->set_token_for_hosted_system();
		$nonce  = wp_create_nonce( 'wizard-form' );
		$params = array(
			'redirect_url' => wp_nonce_url( admin_url( 'index.php?page=prodigy-setup&_wpnonce=' . $nonce ), 'wizard-form' ),
		);

		$url = PRODIGY_PROTOCOL_DOMAIN . PRODIGY_MAIN_DOMAIN . '/plugin_connection_stores?' . http_build_query( $params );

		wp_redirect( $url );

		exit;
	}

	/**
	 * @return bool
	 */
	public function set_token_for_hosted_system(): bool {
		return update_option( self::NAME_TOKEN_HOSTED_SYSTEM, substr( sha1( wp_rand() ), 0, self::LENGTH_CHARACTERS_TOKEN ), false );
	}

	/**
	 * @return string
	 */
	public function get_template_content_wizard(): string {
		$step = $this->steps[1];

		if ( $this->is_connected ) {
			$step = $this->steps[ $this->step ];
		}

		return $step;
	}

	/**
	 * Setup Wizard Header.
	 */
	public function setup_wizard_header() {
		set_current_screen();
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/wizard/prodigy-wizard-header-page.php';
	}

	/**
	 * Setup Wizard Footer.
	 */
	public function setup_wizard_footer() {
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/wizard/prodigy-wizard-footer-page.php';
	}


	/**
	 * Register/enqueue scripts and styles for the Setup Wizard.
	 *
	 * Hooked onto 'admin_enqueue_scripts'.
	 */
	public function wizard_enqueue_scripts() {

		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_enqueue_script( 'wizard', Prodigy::plugin_url() . '/assets/admin/wizard/js/wizard.js', array( 'jquery' ), PRODIGY_VERSION, true );
		wp_enqueue_style( 'wizard', Prodigy::plugin_url() . '/assets/admin/wizard/css/wizard.css', array(), PRODIGY_VERSION );
	}


	public function get_terms_prodigy() {
		return get_terms(
			array(
				'taxonomy'   => Prodigy::get_prodigy_category_type(),
				'hide_empty' => false,
				'parent'     => 0,
			)
		);
	}

	/**
	 * STEP 1
	 * Output the content for the current step.
	 */
	public function connect_wizard_content() {
		update_option( 'pg_step_wizard', 1 );
		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/wizard/prodigy-wizard-step1-page.php';
	}

	/**
	 * STEP FINISH
	 * Output the content for the current step.
	 */
	public function install_demo_content() {
		update_option( 'pg_step_wizard', 2 );
		update_option( 'pg_install_demo_content_wizard', 0 );

		require_once PRODIGY_PLUGIN_PATH . 'admin/partials/wizard/prodigy-wizard-step2-page.php';
	}
}

new Prodigy_Admin_Setup_Wizard();
