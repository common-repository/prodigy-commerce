<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @version      2.0.2
 * @package prodigy/public
 */

namespace Prodigy\Includes\Frontend;

use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Options;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Prodigy
 * @subpackage Prodigy/public
 * @author     test <test@gmail.com>
 */
class Prodigy_Public {
	const PUBLIC_SCRIPT_DATA_NAME       = 'settings';
	const PRICE_FILTER_SCRIPT_DATA_NAME = 'params';
	const MY_ACCOUNT_SCRIPT_DATA_NAME   = 'options';
	const CART_SCRIPT_DATA_NAME         = 'data';


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;
	/** @var object Prodigy_Cache */
	protected $cache;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;
		$this->version     = PRODIGY_VERSION;
		$this->cache       = new Prodigy_Cache();
		add_action( 'wp_head', array( $this, 'set_ajaxurl_to_script' ) );
		add_action( 'wp_head', array( $this, 'add_analytics' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'my_theme_enqueue_styles' ), 99 );
		add_action( 'init', array( $this, 'template_loader' ) );
	}

	public function template_loader() {
		add_filter( 'template_include', array( __CLASS__, 'prodigy_template_loader' ), 200 );
		add_filter( 'comments_template', array( __CLASS__, 'comments_template_loader' ) );
	}


	/**
	 * @return string
	 */
	public static function get_theme_template_path(): string {
		return apply_filters( 'prodigy_theme_template_path', 'prodigy_shop/' );
	}

	/**
	 * @return bool
	 */
	public static function is_divi_template(): bool {
		return false;
	}

	/**
	 * @return bool
	 */
	public static function has_block_template(): bool {
		return false;
	}

	/**
	 * @return bool
	 */
	public static function skip(): bool {
		if ( is_embed() ) {
			return true;
		}

		if ( Prodigy_Layouts_Manager::is_elementor_template() ) {
			return true;
		}

		if ( self::is_divi_template() ) {
			return true;
		}

		if ( self::has_block_template() ) {
			return true;
		}

		return false;
	}


	/**
	 * @param null|string $template
	 *
	 * @return string
	 */
	public static function prodigy_template_loader( ?string $template ): ?string {

		if ( self::skip() ) {
			return $template;
		}

		$default_file = self::get_default_file();

		if ( $default_file ) {
			$search_files = self::get_template_loader_files( $default_file );
			$template     = locate_template( $search_files );

			if ( ! $template ) {
				$template = PRODIGY_PLUGIN_PATH . 'templates/partials/' . $default_file;
			}
		}

		return $template;
	}

	/**
	 * Get the default filename for a template
	 *
	 * @return string
	 */
	public static function get_default_file(): string {
		$default_file = '';
		if ( is_singular( Prodigy::get_prodigy_product_type() ) ) {
			$default_file = 'single-product.php';
		}

		return $default_file;
	}

	/**
	 * @param string $default_file
	 *
	 * @return array
	 */
	public static function get_template_loader_files( string $default_file ) {
		if ( is_singular( Prodigy::get_prodigy_product_type() ) ) {
			$object       = get_queried_object();
			$name_decoded = urldecode( $object->post_name );
			if ( $name_decoded !== $object->post_name ) {
				$templates[] = "single-product-{$name_decoded}.php";
			}
			$templates[] = "single-product-{$object->post_name}.php";
		}

		if ( is_prodigy_product_taxonomy() ) {
			$object = get_queried_object();

			$templates[] = 'taxonomy-' . $object->taxonomy . '-' . $object->slug . '.php';
			$templates[] = self::get_theme_template_path() . 'taxonomy-' . $object->taxonomy . '-' . $object->slug . '.php';
			$templates[] = 'taxonomy-' . $object->taxonomy . '.php';
			$templates[] = self::get_theme_template_path() . 'taxonomy-' . $object->taxonomy . '.php';
		}

		$templates[] = $default_file;
		$templates[] = self::get_theme_template_path() . $default_file;

		return array_unique( $templates );
	}

	/**
	 * Load comments template.
	 *
	 * @param string $template template to load.
	 *
	 * @return string
	 */
	public static function comments_template_loader( string $template ): string {
		if ( get_post_type() !== Prodigy::get_prodigy_product_type() ) {
			return $template;
		}

		$check_dirs = array(
			trailingslashit( get_stylesheet_directory() ) . PRODIGY_PLUGIN_DIRECTORY_NAME . '/',
			trailingslashit( get_template_directory() ) . PRODIGY_PLUGIN_DIRECTORY_NAME . '/',
			trailingslashit( get_stylesheet_directory() . self::get_theme_template_path() ),
			trailingslashit( get_template_directory() ),
			trailingslashit( PRODIGY_PLUGIN_PATH ) . 'templates/v2',
		);

		foreach ( $check_dirs as $dir ) {
			if ( file_exists( trailingslashit( $dir ) . 'single-products-reviews.php' ) ) {
				return trailingslashit( $dir ) . 'single-products-reviews.php';
			}
		}

		return $template;
	}

	/**
	 * @return void
	 */
	public function add_analytics() {
		$enabled = get_option( 'pg_enable_google_analytics' );
		$code    = get_option( 'pg_google_analytics_code' );

		if ( $enabled && $code ) {
			// Enqueue the Google Analytics script
			add_action(
				'wp_enqueue_scripts',
				function () use ( $code ) {
					wp_enqueue_script( 'google-analytics', 'https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $code ), array(), null, true );
					$inline_script = '
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag("js", new Date());
                gtag("config", "' . esc_js( $code ) . '");
                gtag("config", "' . esc_js( $code ) . '", {
                    "linker": {
                        "domains": ["' . esc_url( get_home_url() ) . '", "prodigycommerce.com"],
                    }
                });
            ';
					wp_add_inline_script( 'google-analytics', $inline_script );
				}
			);
		}
	}



	// register public style after all
	function my_theme_enqueue_styles() {
		wp_enqueue_style(
			'styles',
			Prodigy::plugin_url() . '/assets/templates/css/styles.css',
			array(),
			$this->version,
			'all'
		);

		switch ( wp_get_theme()->get_template() ) {
			case 'astra':
				wp_enqueue_style(
					'astra_theme',
					Prodigy::plugin_url() . '/assets/templates/css/astra_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'twentynineteen':
				wp_enqueue_style(
					'twenty_nineteen_theme',
					Prodigy::plugin_url() . '/assets/templates/css/twenty_nineteen_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'twentytwenty':
				wp_enqueue_style(
					'twenty_twenty_theme',
					Prodigy::plugin_url() . '/assets/templates/css/twenty_twenty_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'twentyseventeen':
				wp_enqueue_style(
					'twenty_seventeen_theme',
					Prodigy::plugin_url() . '/assets/templates/css/twenty_seventeen_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'hello-elementor':
				wp_enqueue_style(
					'hello_elementor_theme',
					Prodigy::plugin_url() . '/assets/templates/css/hello_elementor_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'oceanwp':
				wp_enqueue_style(
					'oceanwp_theme',
					Prodigy::plugin_url() . '/assets/templates/css/oceanwp_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'Divi':
				wp_enqueue_style(
					'divi_theme',
					Prodigy::plugin_url() . '/assets/templates/css/divi_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'flatsome':
				wp_enqueue_style(
					'flatsome_theme',
					Prodigy::plugin_url() . '/assets/templates/css/flatsome_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
			case 'twentytwentyone':
				wp_enqueue_style(
					'twenty_twenty_one_theme',
					Prodigy::plugin_url() . '/assets/templates/css/twenty_twenty_one_theme.css',
					array(),
					$this->version,
					'all'
				);
				break;
		}
	}

	/**
	 * Set ajax_url in scripts
	 */
	function set_ajaxurl_to_script() {
		echo '<script type="text/javascript">
           var ajax_url = "' . esc_url( admin_url( 'admin-ajax.php' ) ) . '";
         </script>';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'photoswipe',
			Prodigy::plugin_url() . '/web/templates/css/photoswipe/photoswipe.css',
			array(),
			$this->version,
			'all'
		);
		wp_enqueue_style(
			'photoswipe-skin',
			Prodigy::plugin_url() . '/web/templates/css/photoswipe/default-skin/default-skin.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_style(
			'slick',
			Prodigy::plugin_url() . '/web/templates/css/slick/slick.css',
			array(),
			$this->version
		);
		wp_enqueue_style(
			'slick.theme',
			Prodigy::plugin_url() . '/web/templates/css/slick/slick-theme.css',
			array(),
			$this->version
		);

		wp_enqueue_style(
			'dd',
			Prodigy::plugin_url() . '/web/templates/css/dd/dd.min.css',
			array(),
			$this->version
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'public',
			Prodigy::plugin_url() . '/assets/templates/js/public.js',
			array( 'jquery' ),
			$this->version
		);

		$product_type  = Prodigy::get_prodigy_product_type();
		$category_type = Prodigy::get_prodigy_category_type();

		$customizer_shop_options      = get_option( 'prodigy_shop_settings' );
		$customizer_product_columns   = $customizer_shop_options['prodigy_shop_products_per_row'] ?? Prodigy_Customizer::PRODIGY_PRODUCTS_NUMBER_COLUMNS;
		$google_analytics_code        = get_option( 'pg_google_analytics_code' );
		$is_enable_google_analytics   = get_option( 'pg_enable_google_analytics' );
		$elementor_add_to_cart_widget = get_option( 'elementor_add_to_cart_options' );
		$is_show_certain_bulk_block   = $elementor_add_to_cart_widget['prg_default_enable_multiple_quantity'] === 'yes';
		$number_certain_bulk_block    = $elementor_add_to_cart_widget['prg_default_enable_multiple_quantity_options'];

		$scriptData = array(
			'nonce'                      => wp_create_nonce( 'store-nonce' ),
			'is_deleted_product'         => get_option( 'is_product_deleted' ),
			'plugin_directory_name'      => get_prodigy_plugin_directory_name(),
			'pg_google_track_id'         => ! empty( $google_analytics_code ) && (int) $is_enable_google_analytics,
			'shop_page_url'              => Prodigy_Page::prodigy_get_shop_url(),
			'product_type'               => $product_type,
			'category_type'              => $category_type,
			'captcha_site_key'           => get_option( 'pg_captcha_site_key' ),
			'is_captcha'                 => get_option( 'pg_captcha_launch' ),
			'customizer_product_columns' => $customizer_product_columns,
			'site_url'                   => get_home_url(),
			'is_show_certain_bulk_block' => $is_show_certain_bulk_block,
			'number_certain_bulk_block'  => $number_certain_bulk_block,
			'redemption_store'           => Prodigy_Options::get_redemption_store_status(),
		);

		wp_localize_script( 'public', self::PUBLIC_SCRIPT_DATA_NAME, $scriptData );

		wp_enqueue_script(
			'swiper-bundle.min',
			Prodigy::plugin_url() . '/web/templates/js/swiper-bundle.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script(
			'photoswipe.min',
			Prodigy::plugin_url() . '/web/templates/js/photoswipe.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script(
			'photoswipe-ui-default.min',
			Prodigy::plugin_url() . '/web/templates/js/photoswipe-ui-default.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script(
			'jquery.magnific-popup.min',
			Prodigy::plugin_url() . '/web/templates/js/jquery.magnific-popup.min.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_enqueue_script(
			'jquery.inputmask.bundle.min',
			Prodigy::plugin_url() . '/web/libraries/inputmask/js/jquery.inputmask.bundle.min.js',
			array( 'jquery' )
		);

		wp_enqueue_style(
			'inputmask',
			Prodigy::plugin_url() . '/web/libraries/inputmask/css/inputmask.css'
		);

		wp_enqueue_script(
			'popper.min',
			Prodigy::plugin_url() . '/web/templates/js/popper.min.js',
			array(),
			$this->version,
			true
		);
		wp_enqueue_script( 'bootstrap.min', Prodigy::plugin_url() . '/web/templates/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'slick.min', Prodigy::plugin_url() . '/web/templates/js/slick.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery.formstyler.min', Prodigy::plugin_url() . '/web/templates/js/jquery.formstyler.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'dd.min', Prodigy::plugin_url() . '/web/templates/js/dd.min.js', array( 'jquery' ), $this->version, false );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
