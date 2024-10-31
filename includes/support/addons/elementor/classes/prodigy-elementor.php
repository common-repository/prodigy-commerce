<?php

use Elementor\Plugin;
use Elementor\Plugin as Elementor;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorActiveFilters;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorBrowseCategories;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorFilterPrice;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorFilters;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorProducts;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorSorting;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Cart\ElementorCartPage;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorCart;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorCategories;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorCategory;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorMyAccount;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorRelatedProducts;
use Prodigy\includes\support\addons\elementor\widgets\ElementorSearch;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorThankYouPage;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorAddToCart;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorBreadcrumbs;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorImages;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorMeta;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorPriceRange;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorRating;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorShortDescription;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorTabs;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorTitle;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * Addons For Elementor plugin.
 *
 * @package WordPress
 * @subpackage PAE
 */
class ProdigyElementor {

	public $version;
	private $file;

	protected $plugin_url;
	private $plugin_path;

	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct( $file ) {
		global $prodigy_css_path;

		$this->version = '';
		$this->file    = $file;

		/* Plugin URL/path settings. */
		$this->plugin_url  = str_replace( '/classes', '', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		$this->plugin_path = str_replace( 'classes', '', plugin_dir_path( __FILE__ ) );

		$prodigy_css_path = site_url( '/wp-content/plugins/prodigy-wp-plugin/includes/support/addons/elementor/css/', '' );
	}

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	public function init() {
		// Register Widget Styles
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'pae_editor_enqueue_scripts' ) );

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/register', array( $this, 'init_widgets' ) );
		$this->set_main_prodigy_category();
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );
	}

	public function set_main_prodigy_category() {
		Elementor::$instance->elements_manager->add_category(
			'prodigy-addons',
			array(
				'title' => __( 'Prodigy Commerce' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	public function pae_editor_enqueue_scripts() {
		wp_enqueue_style(
			'prdg-icon',
			$this->safe_url( PRODIGY_PLUGIN_URL . 'includes/support/addons/elementor/css/prgicon.css' ),
			false
		);
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.' ),
			'<strong>' . esc_html__( 'Prodigy Addons for Elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.' ),
			'<strong>' . esc_html__( 'Prodigy Addons for Elementor' ) . '</strong>',
			'<strong><a href="https://elementor.com/?ref=14615">' . esc_html__( 'Elementor Page Builder' ) . '</a></strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'prodigy-product',
			array(
				'title' => __( 'Prodigy Product' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		// Include Widget files
		$saved_options = get_option( 'pg_save_data' );

		require_once $this->plugin_path . '/widgets/products.php';
		wp_enqueue_script( 'slick.min', Prodigy::plugin_url() . '/web/templates/js/slick.min.js', array( 'jquery' ), PRODIGY_VERSION, false );
		Plugin::instance()->widgets_manager->register( new \Prodigy\Includes\Support\Addons\Elementor\Widgets\ElementorProducts() );

		require_once $this->plugin_path . '/widgets/my-account.php';
		Plugin::instance()->widgets_manager->register( new ElementorMyAccount() );

		if ( isset( $saved_options['categories'] ) ) {
			require_once $this->plugin_path . '/widgets/categories.php';

			Plugin::instance()->widgets_manager->register( new ElementorCategories() );
		}

		require_once $this->plugin_path . '/widgets/cart.php';
		Plugin::instance()->widgets_manager->register( new ElementorCart() );

		require_once $this->plugin_path . '/widgets/cart-page.php';
		Plugin::instance()->widgets_manager->register( new ElementorCartPage() );

		require_once $this->plugin_path . '/widgets/thank-you-page.php';
		Plugin::instance()->widgets_manager->register( new ElementorThankYouPage() );


		require_once $this->plugin_path . '/widgets/search.php';
		Plugin::instance()->widgets_manager->register( new ElementorSearch() );

		/*
		 * Archive
		 */
		if ( isset( $saved_options['category'] ) ) {
			require_once $this->plugin_path . '/widgets/category.php';

			Plugin::instance()->widgets_manager->register( new ElementorCategory() );
		}

		require_once $this->plugin_path . '/widgets/archive/breadcrumbs.php';
		Plugin::instance()->widgets_manager->register( new \Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive\ElementorBreadcrumbs() );

		require_once $this->plugin_path . '/widgets/archive/sorting.php';
		Plugin::instance()->widgets_manager->register( new ElementorSorting() );

		require_once $this->plugin_path . '/widgets/archive/filters.php';
		Plugin::instance()->widgets_manager->register( new ElementorFilters() );

		require_once $this->plugin_path . '/widgets/archive/products.php';
		Plugin::instance()->widgets_manager->register( new ElementorProducts() );

		require_once $this->plugin_path . '/widgets/archive/filter-price.php';
		Plugin::instance()->widgets_manager->register( new ElementorFilterPrice() );

		require_once $this->plugin_path . '/widgets/archive/categories.php';
		Plugin::instance()->widgets_manager->register( new ElementorBrowseCategories() );

		require_once $this->plugin_path . '/widgets/archive/active-filters.php';
		Plugin::instance()->widgets_manager->register( new ElementorActiveFilters() );

		/*
		 * Single Product
		 */
		require_once $this->plugin_path . '/widgets/product/breadcrumbs.php';
		Plugin::instance()->widgets_manager->register( new ElementorBreadcrumbs() );

		require_once $this->plugin_path . '/widgets/product/title.php';
		Plugin::instance()->widgets_manager->register( new ElementorTitle() );

		require_once $this->plugin_path . '/widgets/product/short-description.php';
		Plugin::instance()->widgets_manager->register( new ElementorShortDescription() );

		require_once $this->plugin_path . '/widgets/product/price-range.php';
		Plugin::instance()->widgets_manager->register( new ElementorPriceRange() );

		require_once $this->plugin_path . '/widgets/product/rating.php';
		Plugin::instance()->widgets_manager->register( new ElementorRating() );

		require_once $this->plugin_path . '/widgets/product/add-to-cart.php';
		Plugin::instance()->widgets_manager->register( new ElementorAddToCart() );

		require_once $this->plugin_path . '/widgets/product/images.php';
		Plugin::instance()->widgets_manager->register( new ElementorImages() );

		require_once $this->plugin_path . '/widgets/product/meta.php';
		Plugin::instance()->widgets_manager->register( new ElementorMeta() );

		require_once $this->plugin_path . '/widgets/product/tabs.php';
		Plugin::instance()->widgets_manager->register( new ElementorTabs() );

		require_once $this->plugin_path . '/widgets/product/related-products.php';
		Plugin::instance()->widgets_manager->register( new ElementorRelatedProducts() );
	}

	/**
	 * activation function.
	 *
	 * @access public
	 * @return void
	 */
	public function activation() {
		$this->register_plugin_version();

		if ( get_option( 'pg_save_data' ) === false ) {
			$vc_default_options = array(
				'products'   => 'on',
				'categories' => 'on',
				'category'   => 'on',
			);

			update_option( 'pg_save_data', $vc_default_options );
		}
	}

	/**
	 * register_plugin_version function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_plugin_version() {
		if ( $this->version != '' ) {
			update_option( 'pa_elementor' . '-version', $this->version );
		}
	}


	/**
	 * Generate safe url
	 *
	 * @since v3.0.0
	 */
	public function safe_url( $url ) {
		if ( is_ssl() ) {
			$url = wp_parse_url( $url );

			if ( ! empty( $url['host'] ) ) {
				$url['scheme'] = 'https';
			}

			return $this->unparse_url( $url );
		}

		return $url;
	}

	public function unparse_url( $parsed_url ) {
		$scheme   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
		$port     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
		$user     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
		$pass     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass'] : '';
		$pass     = ( $user || $pass ) ? "$pass@" : '';
		$path     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
		$query    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
		$fragment = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';

		return "$scheme$user$pass$host$port$path$query$fragment";
	}
}
