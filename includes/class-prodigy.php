<?php
namespace Prodigy\Includes;

use Elementor\Plugin as ElementorPlugin;
use Prodigy\Admin\Prodigy_Admin;
use Prodigy\Admin\Prodigy_Admin_Attributes_List;
use Prodigy\Admin\Prodigy_Admin_Categories_List;
use Prodigy\Admin\Prodigy_Admin_Notification;
use Prodigy\Admin\Prodigy_Admin_Products_List;
use Prodigy\Admin\Prodigy_Admin_Settings;
use Prodigy\Includes\Api\V1\Prodigy_Api_Attributes;
use Prodigy\Includes\Api\V1\Prodigy_Api_Batch_Taxonomies;
use Prodigy\Includes\Api\V1\Prodigy_Api_Category;
use Prodigy\Includes\Api\V1\Prodigy_Api_Import;
use Prodigy\Includes\Api\V1\Prodigy_Api_Product;
use Prodigy\Includes\Api\V1\Prodigy_Api_Product_Review;
use Prodigy\Includes\Api\V1\Prodigy_Api_Settings;
use Prodigy\Includes\Api\V1\Prodigy_Api_Tags;
use Prodigy\Includes\Api\V1\Prodigy_Api_Taxonomies;
use Prodigy\Includes\Api\V1\Prodigy_Install_Demo_Content;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Frontend\Actions\Prodigy_Buy_Now;
use Prodigy\Includes\Frontend\Blocks\Prodigy_Blocks;
use Prodigy\Includes\Frontend\Pages\Prodigy_Cart_Page;
use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Frontend\Pages\Prodigy_Product_Page;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Frontend\Prodigy_Public;
use Prodigy\Includes\Frontend\Shortcodes\Pages\Prodigy_Short_Code_Cart_Page;
use Prodigy\Includes\Frontend\Shortcodes\Pages\Prodigy_Short_Code_Thank_You;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Active_Filter;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Attributes_Filter;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Banner;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Breadcrumbs_List;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Cart;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Categories;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Categories_Filter;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Category_Link;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_My_Account;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Price_Filter;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Products;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Related_Products;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Search;
use Prodigy\Includes\Helpers\Prodigy_Ajax;
use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Helpers\Prodigy_Helper_Hosted_System;
use Prodigy\Includes\Migrations\Prodigy_Migration;
use Prodigy\Includes\Support\Addons\Elementor\Builder\Module;
use Prodigy\Includes\Support\Addons\Elementor\Classes\Prodigy_Manager;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;
use Prodigy\Includes\Support\Prodigy_Themes_Support;
use Prodigy\Includes\Synchronization\Content\Prodigy_Process_Factory;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;
use Prodigy\Includes\Widgets\Prodigy_Active_Filters_Widget;
use Prodigy\Includes\Widgets\Prodigy_Cart_Widget;
use Prodigy\Includes\Widgets\Prodigy_Categories_Widget;
use Prodigy\Includes\Widgets\Prodigy_Filters_Widget;
use Prodigy\Includes\Widgets\Prodigy_My_Account_Widget;
use Prodigy\Includes\Widgets\Prodigy_Price_Filter_Widget;
use Prodigy\Includes\Widgets\Prodigy_Search_Widget;

defined( 'ABSPATH' ) || exit;
require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * The core plugin class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy {

	const PLUGIN_NAME                       = 'prodigy';
	const PRODIGY_POST_TYPE_DEFAULT         = 'prodigy-product';
	const PRODIGY_VARIATION_POST_TYPE       = 'prodigy_variation';
	const PRODIGY_TAXONOMY_CATEGORY_DEFAULT = 'prodigy-product-category';
	const PRODIGY_TAXONOMY_TAG_DEFAULT      = 'prodigy-product-tag';
	const PRODIGY_FIRST_CONNECTED_PRODUCT   = 'pg_first_connected_product';
	const PRODIGY_HOSTED_CATEGORY_RELATION  = 'prodigy_hosted_category_relation';
	const PRODIGY_HOSTED_TAG_RELATION       = 'prodigy_tag_remote_id';
	const APPEARANCE_MENUS_CHECKED_FIRST    = 3;

	const PRODIGY_DEFAULT_PRODUCT_SLUG  = 'product';
	const PRODIGY_DEFAULT_CATEGORY_SLUG = 'product-category';
	const PRODIGY_DEFAULT_TAG_SLUG      = 'product-tag';

	const PAGE_PRODIGY_ATTRIBUTES = '_page_prodigy_attributes';
	const PAGE_PRODIGY_SETTINGS   = '_page_prodigy_settings';
	const PAGE_PRODIGY_CATEGORIES = '_page_prodigy_categories';
	const PAGE_PRODIGY_PRODUCTS   = '_page_prodigy_products';

	const PRODIGY_REMOTE_PRODUCT_ID   = 'prodigy_remote_product_id';
	const PRODIGY_REMOTE_ATTRIBUTE_ID = 'prodigy_attribute_value_remote_id';

	/**
	 * The unique identifier of this plugin.
	 */
	protected $plugin_name;

	protected $api_client;

	protected $loader;

	protected $prodigy_pages;

	/** @var Prodigy_User */
	private $user;

	/** @var Prodigy_Helper_Hosted_System */
	private $hs_helper;

	private static $widgets = array(
		Prodigy_Active_Filters_Widget::class,
		Prodigy_Cart_Widget::class,
		Prodigy_Categories_Widget::class,
		Prodigy_Filters_Widget::class,
		Prodigy_My_Account_Widget::class,
		Prodigy_Price_Filter_Widget::class,
		Prodigy_Search_Widget::class,
	);


	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		$this->api_client    = new Prodigy_Api_Client();
		$this->plugin_name   = self::PLUGIN_NAME;
		$this->prodigy_pages = new Prodigy_Page();
		$this->hs_helper     = new Prodigy_Helper_Hosted_System();
		$this->user          = new Prodigy_User( $this->api_client, new Prodigy_Cookies() );
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->set_elementor();

		add_action( 'init', array( $this, 'load_instances' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_tags' ) );
		add_action( 'init', array( $this, 'includes' ) );
		add_action( 'init', array( $this, 'load_global_scripts' ) );
		add_action( 'init', array( $this, 'start_sync_process' ) );
		add_action( 'init', array( $this, 'set_prodigy_header_menu' ) );
		add_action( 'init', array( $this, 'prodigy_register_elementor' ) );
		add_action( 'init', array( $this, 'update_plugin_version' ) );
		add_action( 'init', array( $this, 'prodigy_set_cart_session' ) );
		add_action( 'init', array( $this, 'set_auth_user_logic' ) );

		add_action( 'widgets_init', array( $this, 'prodigy_register_widgets' ) );
		add_action( 'admin_notices', array( new Prodigy_Admin_Notification(), 'display_admin_notice' ) );
		add_action( 'admin_init', array( $this, 'sync_content' ), 999 );
		add_action( 'prodigy_after_register_post_type', array( $this, 'maybe_flush_rewrite_rules' ) );

		// Enable shortcodes in text widgets
		add_filter( 'widget_text', 'do_shortcode' );
		add_action( 'activated_plugin', array( $this, 'prodigy_activation_redirect' ) );
		add_filter(
			'get_user_option_metaboxhidden_nav-menus',
			array(
				$this,
				'custom_display_appearance_menus',
			),
			10,
			3
		);
		add_action( 'after_switch_theme', array( $this, 'customize_current_theme' ) );
		add_action( 'divi_extensions_init', array( $this, 'divi_initialize_extension' ) );

		add_filter( 'allowed_redirect_hosts', array( $this, 'allowed_prodigy_redirect_urls' ) );
	}

	/**
	 * Allow Hosted System domain
	 *
	 * @param array $hosts
	 *
	 * @return array
	 */
	public function allowed_prodigy_redirect_urls( array $hosts ): array {
		$hosts[] = sprintf(
			'%1$s.%2$s',
			get_option( 'pg_url_domain_hosted_system' ),
			PRODIGY_CHECKOUT_DOMAIN
		);

		return $hosts;
	}

	/**
	 * Init elementor engine
	 *
	 * @return void
	 */
	public function set_elementor() {
		if ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) && did_action( 'elementor/loaded' ) ) {
			add_action( 'elementor/init', array( $this, 'init_elementor' ) );
			add_action( 'elementor/init', array( $this, 'prodigy_elementor_source' ) );
		}
	}

	/**
	 * @throws \Exception
	 */
	public function set_auth_user_logic() {
		if ( isset( $_POST['action'] ) && $_POST['action'] === 'prodigy-user-logout' ) {
			return;
		}

		$user_logged_in        = Prodigy_User::is_logged_in();
		$require_login         = $this->user->get_require_login_option() === Prodigy_User::REQUIRE_LOGIN_VALUE;
		$session_token_missing = ! isset( $_GET['session_token'] );

		if ( ( $session_token_missing && ! $user_logged_in && ! $require_login ) || is_wp_api_request() ) {
			return;
		}

		if ( $user_logged_in ) {
			$this->user->get_user_info_from_hosted_system();
		}

		$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		if ( ! $user_logged_in ) {
			if ( $require_login && Prodigy_User::is_frontend_authentication_required( $uri ) ) {
				$this->set_user_require_authentication();
			} else {
				$this->process_login_redirect();
			}
		}
	}


	/**
	 * @return void
	 * @throws \Exception
	 */
	public function process_login_redirect() {
		if ( Prodigy_User::is_logged_in() ) {
			return;
		}

		if ( isset( $_GET['session_token'] ) ) {
			$this->user->authorization( $_GET['session_token'] );
			Prodigy_User::redirect_to_current_page();
		}
	}


	/**
	 * @return void
	 * @throws \Exception
	 */
	public function set_user_require_authentication() {
		if ( Prodigy_User::is_logged_in() ) {
			return;
		}

		if ( isset( $_GET['session_token'] ) ) {
			$this->process_login_redirect();
		}

		$url = Prodigy_User::get_hosted_system_login_url();
		$this->hs_helper->redirect_to_hosted_system( $url );
	}

	public function divi_initialize_extension() {
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/divi/includes/Divi.php';
	}

	public function update_plugin_version() {
		$migration = new Prodigy_Migration();
		$migration->runUpgradeProcess();
	}

	public function init_elementor() {
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/prodigy.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/product-archive.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/shop-page.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/documents/product-archive.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/documents/product.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/module.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/prodigy-post.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/prodigy-product-names.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/prodigy-taxonomy.php';
		require_once PRODIGY_PLUGIN_PATH . 'includes/support/addons/elementor/builder/conditions/prodigy-sub-taxonomy.php';

		new Module();
	}

	/**
	 * Start content synchronization process
	 *
	 * @return void
	 * @throws Demo\Exception\Prodigy_Demo_Content_Exception
	 */
	public function start_sync_process() {
		if ( isset( $_GET['page'] ) && $_GET['page'] === 'prodigy-setup' ) {
			return;
		}

		$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		if ( $uri === '/favicon.ico' ) {
			return;
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$sync_type_to_start           = get_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE );
		$sync_type_to_start_auto_sync = get_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE_AUTO_SYNC );

		$sync = new Prodigy_Synchronization();
		if ( $sync_type_to_start === Prodigy_Synchronization::PRODIGY_DEMO_PROCESS ) {
			$sync->run_sync_process( Prodigy_Api_Client::SYNC_DEMO_URL, Prodigy_Synchronization::PRODIGY_DEMO_PROCESS );
			delete_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE );

			return;
		}

		if ( $sync_type_to_start === Prodigy_Synchronization::PRODIGY_MANUAL_PROCESS ) {
			$sync->run_sync_process( Prodigy_Api_Client::SYNC_CONTENT_URL, Prodigy_Synchronization::PRODIGY_MANUAL_PROCESS );
			delete_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE );

			return;
		}

		if ( $sync_type_to_start_auto_sync === Prodigy_Synchronization::PRODIGY_AUTO_SYNC ) {
			$sync->run_sync_process( Prodigy_Api_Client::SYNC_CONTENT_URL, Prodigy_Synchronization::PRODIGY_AUTO_SYNC );
			delete_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE_AUTO_SYNC );

			return;
		}
	}


	/**
	 * refresh permalinks after change entity slugs
	 *
	 * @return void
	 */
	public static function maybe_flush_rewrite_rules() {
		if ( get_option( 'prodigy_queue_flush_rewrite_rules' ) === 'yes' ) {
			update_option( 'prodigy_queue_flush_rewrite_rules', 'no' );
			flush_rewrite_rules();
		}
	}

	public function sync_content() {
		new Prodigy_Process_Factory();
	}

	public function prodigy_register_elementor() {
		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			require_once 'support/addons/elementor/prodigy.php';
		}
	}

	/**
	 * Rewrite elementor templates library
	 */
	public function prodigy_elementor_source() {
		include 'support/addons/elementor/classes/prodigy-manager.php';
		include 'support/addons/elementor/classes/prodigy-api.php';
		include 'support/addons/elementor/classes/prodigy-custom-source.php';

		ElementorPlugin::instance()->templates_manager = new Prodigy_Manager( ElementorPlugin::instance()->templates_manager );
	}

	/**
	 * Register widgets
	 */
	public function prodigy_register_widgets() {
		if ( isset( self::$widgets ) ) {
			foreach ( self::$widgets as $widget ) {
				register_widget( new $widget() );
			}
		}
	}

	/**
	 * set cart widget for Astra theme
	 */
	public function set_prodigy_header_menu() {
		new Prodigy_Themes_Support();
	}

	/**
	 *
	 * Set specify styles for current theme
	 */
	public static function customize_current_theme() {
		new Prodigy_Themes_Support();
	}

	/**
	 * @throws \Exception
	 */
	public function load_instances() {
		/**
		 * Upgrade
		 */
		new Prodigy_Migration();

		if ( is_admin() ) {
			/** Admin part */
			new Prodigy_Admin_Products_List();
			new Prodigy_Admin_Categories_List();
			new Prodigy_Admin_Settings();
			new Prodigy_Admin_Attributes_List();
			new Prodigy_Install_Demo_Content();
		}

		/** Frontend part */
		new Prodigy_Product_Page();
		new Prodigy_Cart_Page();
		new Prodigy_Shop_Page();

		new Prodigy_Buy_Now( $this->api_client, $this->user );

		/** Shortcodes part */
		new Prodigy_Short_Code_Cart();
		new Prodigy_Short_Code_Attributes_Filter();
		new Prodigy_Short_Code_Price_Filter();
		new Prodigy_Short_Code_Active_Filter();
		new Prodigy_Short_Code_Breadcrumbs_List();
		new Prodigy_Short_Code_Categories();
		new Prodigy_Short_Code_Categories_Filter();
		new Prodigy_Short_Code_Category_Link();
		new Prodigy_Short_Code_My_Account();
		new Prodigy_Short_Code_Products();
		new Prodigy_Short_Code_Related_Products();
		new Prodigy_Short_Code_Search();
		new Prodigy_Short_Code_Cart_Page();
		new Prodigy_Short_Code_Thank_You();
		new Prodigy_Short_Code_Banner();

		/** Main part */
		new Prodigy_Customizer();
		new Prodigy_Blocks();
		new Prodigy_Wizard();

		/** API */
		new Prodigy_Api_Attributes();
		new Prodigy_Api_Category();
		new Prodigy_Api_Product();
		new Prodigy_Api_Tags();
		new Prodigy_Api_Taxonomies();
		new Prodigy_Product_Comments();
		new Prodigy_Api_Product_Review();
		new Prodigy_Api_Batch_Taxonomies();
		new Prodigy_Api_Import();
		new Prodigy_Api_Settings();

		/** Helpers */
		new Prodigy_Ajax();
	}

	/**
	 * Load global JS
	 */
	public function load_global_scripts() {
		wp_register_script(
			'global',
			dirname( plugin_dir_url( __FILE__ ) ) . '/web/global/global.js',
			array( 'jquery' ),
			PRODIGY_VERSION
		);
		wp_enqueue_script( 'global' );

		wp_localize_script(
			'global',
			'data',
			array(
				'site_url'         => get_site_url(),
				'url'              => admin_url( 'admin-ajax.php' ),
				'nonce'            => wp_create_nonce( 'prodigyajax-nonce' ),
				'post_type'        => self::get_prodigy_product_type(),
				'plugin_directory' => get_prodigy_plugin_directory_name(),
			)
		);
	}


	/**
	 * Get actual post slug
	 *
	 * @return false|mixed|void
	 */
	public static function get_prodigy_product_slug() {
		return get_option( 'pg_product_type_slug', self::PRODIGY_DEFAULT_PRODUCT_SLUG );
	}

	/**
	 * Get actual taxonomy slug
	 *
	 * @return false|mixed|void
	 */
	public static function get_prodigy_category_slug() {
		return get_option( 'pg_category_type_slug', self::PRODIGY_DEFAULT_CATEGORY_SLUG );
	}

	/**
	 * Get actual tag slug
	 *
	 * @return false|mixed|void
	 */
	public static function get_prodigy_tag_slug() {
		return get_option( 'pg_tag_type_slug', self::PRODIGY_DEFAULT_TAG_SLUG );
	}

	/**
	 * Get current prodigy product type (slug)
	 *
	 * @return string
	 */
	public static function get_prodigy_product_type() {
		return self::PRODIGY_POST_TYPE_DEFAULT;
	}

	/**
	 * Get current prodigy category type (slug)
	 *
	 * @return string
	 */
	public static function get_prodigy_category_type() {
		return self::PRODIGY_TAXONOMY_CATEGORY_DEFAULT;
	}

	/**
	 * Get current prodigy tag type (slug)
	 *
	 * @return string
	 */
	public static function get_prodigy_tag_type() {
		return self::PRODIGY_TAXONOMY_TAG_DEFAULT;
	}

	/**
	 * After installing the plugin, set the default field "Product categories" to active appearance->menus->screen-options
	 *
	 * @param $result
	 * @param $option
	 * @param $user
	 *
	 * @return array
	 */
	public function custom_display_appearance_menus( $result, $option, $user ) {
		$current_type_category = self::get_prodigy_category_type();
		if ( get_option( 'pg_appearance_menus_checked_first' ) < self::APPEARANCE_MENUS_CHECKED_FIRST ) {
			$prodigy_appearance_menus = (int) get_option( 'pg_appearance_menus_checked_first' );

			?>
			<script type="text/javascript">
				let type_category = <?php echo esc_html( $current_type_category ); ?>;
				jQuery(document).ready(function ($) {
					$('#add-' + type_category + '-hide').attr('checked', true);
				});
			</script>
			<?php

			if ( ! empty( $result ) && is_array( $result ) && in_array( 'add-' . $current_type_category, $result ) ) {
				$result = array_diff( $result, array( 'add-' . $current_type_category ) );
				update_user_meta( $user->ID, 'metaboxhidden_nav-menus', $result );
			}

			update_option( 'pg_appearance_menus_checked_first', ++$prodigy_appearance_menus );
		}

		return $result;
	}


	/**
	 * Redirect on wizard after activated plugin
	 *
	 * @param $plugin
	 */
	public function prodigy_activation_redirect( $plugin ) {
		if ( $plugin === PRODIGY_PLUGIN_DIRECTORY_NAME . '/prodigy-commerce.php' ) {
			$nonce = wp_create_nonce( 'wizard-form' );

			$redirect_url = admin_url( 'index.php?page=prodigy-setup&_wpnonce=' . $nonce );

			wp_redirect( sanitize_url( $redirect_url ) );
			exit;
		}
	}


	/**
	 * @return void
	 * @throws \Exception
	 */
	public function prodigy_set_cart_session() {
		$uri           = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$shop_page_uri = parse_url( $uri, PHP_URL_PATH );
		if ( ! is_admin() && ! substr_count( $shop_page_uri, 'api-listener' ) ) {
			// set cart session
			$cart         = new Prodigy_Cart();
			$user_session = ! empty( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ? sanitize_url( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ) ) : null;
			$cart->set_user_session( $user_session );
		}
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url(): string {
		return untrailingslashit( plugins_url( '/', PRODIGY_PLUGIN_FILE ) );
	}

	public function includes() {

		// Wizard.
		if ( isset( $_GET['page'] ) && $_GET['page'] === 'prodigy-setup' ) {
			require_once PRODIGY_PLUGIN_PATH . 'includes/class-prodigy-admin-setup-wizard.php';
		}

		if ( isset( $_GET['prodigy-clear-wizard'] ) && $_GET['prodigy-clear-wizard'] == 1 ) {
			update_option( 'pg_step_wizard', 1 );
		}
	}

	/**
	 * Register prodigy post type
	 */
	public function register_post_types() {
		add_post_type_support( self::get_prodigy_product_type(), 'thumbnail' );

		$labels = array(
			'menu_name' => __( 'Prodigy', 'prodigy' ),
			'all_items' => __( 'Products', 'prodigy' ),
			'name'      => __( 'Prodigy Products', 'prodigy' ),
		);

		register_post_type(
			self::PRODIGY_POST_TYPE_DEFAULT,
			array(
				'labels'       => $labels,
				'description'  => '',
				'public'       => true,
				'hierarchical' => false,
				'supports'     => array( 'title', 'excerpt', 'thumbnail', 'comments' ),
				'taxonomies'   => array( self::PRODIGY_TAXONOMY_CATEGORY_DEFAULT ),
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => self::get_prodigy_product_slug() ),
				'query_var'    => true,
				'menu_icon'    => 'dashicons-prodigy-logo',
			)
		);

		register_post_type(
			self::PRODIGY_VARIATION_POST_TYPE,
			array(
				'label'        => __( 'Variations', 'prodigy' ),
				'public'       => false,
				'hierarchical' => false,
				'supports'     => false,
				'rewrite'      => false,
			)
		);

		do_action( 'prodigy_after_register_post_type' );
	}

	/**
	 * Register prodigy taxonomies.
	 */
	public function register_taxonomies() {

		if ( ! is_blog_installed() ) {
			return;
		}

		if ( taxonomy_exists( self::get_prodigy_category_type() ) ) {
			return;
		}

		$labels = array(
			'name'              => __( 'Prodigy Product Categories', 'prodigy' ),
			'singular_name'     => __( 'Prodigy Category', 'prodigy' ),
			'menu_name'         => __( 'Categories', 'prodigy' ),
			'search_items'      => __( 'Search Categories', 'prodigy' ),
			'all_items'         => __( 'All Categories', 'prodigy' ),
			'parent_item'       => __( 'Parent Category', 'prodigy' ),
			'parent_item_colon' => __( 'Parent Category', 'prodigy' ),
			'edit_item'         => __( 'Edit Category', 'prodigy' ),
			'update_item'       => __( 'Update Category', 'prodigy' ),
			'add_new_item'      => __( 'Add New Category', 'prodigy' ),
			'new_item_name'     => __( 'New Category Name', 'prodigy' ),
			'not_found'         => __( 'No Categories Found', 'prodigy' ),
		);

		$args = array(
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'label'             => __( 'Categories', 'prodigy' ),
			'labels'            => $labels,
			'capabilities'      => array(
				'pg_manage_terms' => 'pg_manage_product_terms',
			),
			'rewrite'           => array(
				'slug' => self::get_prodigy_category_slug(),
			),
		);

		register_taxonomy( self::PRODIGY_TAXONOMY_CATEGORY_DEFAULT, array( self::PRODIGY_POST_TYPE_DEFAULT ), $args );

		$attributes = Prodigy_Product_Attributes::get_attribute_taxonomies();

		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $attribute ) {

				$args = array(
					'hierarchical'      => false,
					'show_ui'           => false,
					'show_admin_column' => false,
					'query_var'         => true,
				);

				register_taxonomy( $attribute->slug, array( self::PRODIGY_POST_TYPE_DEFAULT ), $args );
			}
		}
	}

	/**
	 *  Register prodigy tags
	 */
	public function register_tags() {

		$labels = array(
			'name'                       => __( 'Prodigy Product Tags', 'prodigy' ),
			'singular_name'              => __( 'Prodigy Tag', 'prodigy' ),
			'menu_name'                  => __( 'Tags', 'prodigy' ),
			'search_items'               => __( 'Search Tags', 'prodigy' ),
			'all_items'                  => __( 'All Tags', 'prodigy' ),
			'edit_item'                  => __( 'Edit Tag', 'prodigy' ),
			'update_item'                => __( 'Update Tag', 'prodigy' ),
			'add_new_item'               => __( 'Add New Tag', 'prodigy' ),
			'new_item_name'              => __( 'New Tag Name', 'prodigy' ),
			'popular_items'              => __( 'Popular Tags', 'prodigy' ),
			'separate_items_with_commas' => __( 'Separate tags with commas', 'prodigy' ),
			'add_or_remove_items'        => __( 'Add or remove tags', 'prodigy' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags', 'prodigy' ),
			'not_found'                  => __( 'No tags found', 'prodigy' ),
		);

		$args = array(
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'label'             => __( 'Product tags', 'prodigy' ),
			'labels'            => $labels,
			'capabilities'      => array(
				'pg_manage_terms' => 'pg_manage_product_terms',
			),
			'rewrite'           => array(
				'slug' => self::get_prodigy_tag_slug(),
			),
		);

		register_taxonomy( self::PRODIGY_TAXONOMY_TAG_DEFAULT, array( self::PRODIGY_POST_TYPE_DEFAULT ), $args );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Prodigy_Loader. Orchestrates the hooks of the plugin.
	 * - Prodigy_Admin. Defines all hooks for the admin area.
	 * - Prodigy_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * prodigy trait sidebar
		 */
		require_once PRODIGY_PLUGIN_PATH . 'includes/helpers/traits/trait-prodigy-sidebar.php';

		/**
		 * prodigy enums
		 */
		require_once PRODIGY_PLUGIN_PATH . 'includes/helpers/enums/prodigy-enums.php';

		/**
		 * prodigy global functions
		 */
		require_once PRODIGY_PLUGIN_PATH . 'includes/helpers/prodigy-core-functions.php';

		/**
		 *  Add support template functions
		 */
		require_once PRODIGY_PLUGIN_PATH . 'includes/frontend/prodigy-template-functions.php';
		/**
		 * Set template hooks
		 */
		require_once PRODIGY_PLUGIN_PATH . 'includes/frontend/prodigy-template-hooks.php';

		$this->loader = new Prodigy_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Prodigy_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Prodigy_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Prodigy_Admin( $this->get_plugin_name(), PRODIGY_VERSION );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Prodigy_Public( $this->get_plugin_name() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Prodigy_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Get prodigy pages list
	 *
	 * @return array
	 */
	public static function get_pages_list() {
		$screen_ids = array(
			self::get_prodigy_product_type(),
			self::get_prodigy_category_type(),
			self::get_prodigy_tag_type(),
			'edit-' . self::get_prodigy_product_type(),
			'edit-' . self::get_prodigy_category_type(),
			'edit-' . self::get_prodigy_tag_type(),
			self::get_prodigy_product_type() . self::PAGE_PRODIGY_ATTRIBUTES,
			self::get_prodigy_product_type() . self::PAGE_PRODIGY_SETTINGS,
			self::get_prodigy_product_type() . self::PAGE_PRODIGY_CATEGORIES,
			self::get_prodigy_product_type() . self::PAGE_PRODIGY_PRODUCTS,
		);

		return $screen_ids;
	}

	public static function refresh_permalink() {
		global $wp_rewrite;

		// Flush the rules and tell it to write htaccess
		$wp_rewrite->flush_rules( true );
	}
}
