<?php

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Active_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Cart_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Cart_Page_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Categories_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Category_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_My_Account_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Price_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Add_To_Cart_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Attributes_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Breadcrumbs_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Image_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Price_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Rating_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Review_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Short_Description_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Sku_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Subscriptions_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Tags_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Thumbnails_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Title_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Product_Variants_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Products_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Related_Products_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Search_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Shop_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Shop_Mobile_Sortable_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Shop_Sortable_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Thank_Page_Data_Mapper;
use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Public;
use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Helpers\Prodigy_Helper_Hosted_System;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\Includes\Prodigy_Product_Comments;
use Prodigy\Includes\Prodigy_User;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorTabs;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Main_Data_Mapper;
use Prodigy\Includes\Prodigy_Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// deactivate new block editor
function phi_theme_support() {
	remove_theme_support( 'widgets-block-editor' );
}

add_action( 'after_setup_theme', 'phi_theme_support' );


/**
 * Global
 */
if ( ! function_exists( 'prodigy_output_content_wrapper' ) ) {
	/**
	 * Output the start of the page wrapper.
	 */
	function prodigy_output_content_wrapper() {
		Prodigy_Template::prodigy_get_template( 'global/wrapper-start.php' );
	}
}

if ( ! function_exists( 'prodigy_output_content_wrapper_end' ) ) {
	function prodigy_output_content_wrapper_end() {
		Prodigy_Template::prodigy_get_template( 'global/wrapper-end.php' );
	}
}


if ( ! function_exists( 'prodigy_product_get_captcha' ) ) {
	function prodigy_product_get_captcha() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?&render=explicit', array(), null, true );
			}
		);
	}
}


/**
 * Template shortcode search
 */
if ( ! function_exists( 'prodigy_get_template_shortcode_search' ) ) {
	function prodigy_get_template_shortcode_search( $settings ) {
		$mapper = new Prodigy_Search_Data_Mapper();
		$params = $mapper->get_default_parameters( $settings );
		Prodigy_Template::prodigy_get_template( 'shortcode/search.php', $params );
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_thank_you' ) ) {
	/**
	 * @throws Exception
	 */
	function prodigy_get_template_shortcode_thank_you( $data ) {
		$data['order_token'] = isset( $_GET['order_token'] ) ? sanitize_text_field( wp_unslash( $_GET['order_token'] ) ) : false;
		$is_redemption_store = isset( $_GET['is_redemption_store'] ) ? sanitize_key( wp_unslash( $_GET['is_redemption_store'] ) ) : '';
		$mapper              = new Prodigy_Thank_Page_Data_Mapper();
		$params              = $mapper->get_default_parameters( $data );

		wp_enqueue_script(
			'feature-products',
			plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/feature-products.js' ) . 'feature-products.js',
			array( 'jquery' ),
			PRODIGY_VERSION
		);

		Prodigy_Template::prodigy_get_template( 'shortcode/thank-you.php', $params );

		if ( $is_redemption_store ) {
			$cart = new Prodigy_Cart();
			$cart->update_status_orders(
				$data['order_token'],
				Prodigy_Cart::PRODIGY_ORDER_COMPLETED
			);

			$api_client = new Prodigy_Api_Client();
			$user       = new Prodigy_User( $api_client, new Prodigy_Cookies() );
			$user->logout();
		}
	}
}

if ( ! function_exists( 'prodigy_get_template_product_subscriptions' ) ) {
	function prodigy_get_template_product_subscriptions( $data ) {
		$mapper     = new Prodigy_Product_Subscriptions_Data_Mapper();
		$parameters = $mapper->get_default_parameters( $data );
		Prodigy_Template::prodigy_get_template( 'single-product/subscriptions.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_price_filter' ) ) {
	function prodigy_get_template_shortcode_price_filter( $data ) {
		$mapper = new Prodigy_Price_Filter_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );

		wp_enqueue_script(
			'ion.rangeSlider.min',
			Prodigy::plugin_url() . '/web/templates/js/ion.rangeSlider.min.js',
			array( 'jquery' )
		);

		wp_enqueue_script(
			'price-filter',
			plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/price-filter.js' ) . 'price-filter.js',
			array(
				'jquery',
				'public',
			),
			PRODIGY_VERSION
		);
		wp_localize_script( 'price-filter', Prodigy_Public::PRICE_FILTER_SCRIPT_DATA_NAME, $params );
		Prodigy_Template::prodigy_get_template( 'shortcode/price-filter.php', $params );
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_my_account' ) ) {
	/**
	 * @param array $data
	 *
	 * @return void
	 * @throws Exception
	 */
	function prodigy_get_template_shortcode_my_account( array $data ): void {
		$mapper = new Prodigy_My_Account_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );

		wp_enqueue_script(
			'my-account',
			plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/my-account.js' ) . 'my-account.js',
			array( 'jquery' ),
			PRODIGY_VERSION,
			true
		);

		$scriptData = array(
			'nonce' => wp_create_nonce( 'store-nonce' ),
		);

		wp_localize_script( 'my-account', Prodigy_Public::MY_ACCOUNT_SCRIPT_DATA_NAME, $scriptData );

		Prodigy_Template::prodigy_get_template( 'shortcode/my-account.php', $params );
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_categories_filter' ) ) {
	function prodigy_get_template_shortcode_categories_filter( $data ) {
		Prodigy_Template::prodigy_get_template( 'shortcode/categories-filter.php', $data );
	}
}


if ( ! function_exists( 'prodigy_get_template_shortcode_cart' ) ) {
	function prodigy_get_template_shortcode_cart( $data ) {
		$mapper = new Prodigy_Cart_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );

		wp_enqueue_script(
			'cart-widget',
			plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/cart-widget.js' ) . 'cart-widget.js',
			array( 'jquery' ),
			PRODIGY_VERSION
		);

		$scriptData = array(
			'dropdown' => (int) $params['is_dropdown'],
			'nonce'    => wp_create_nonce( 'store-nonce' ),
		);

		wp_localize_script( 'cart-widget', Prodigy_Public::CART_SCRIPT_DATA_NAME, $scriptData );

		if ( isset( $params['attr_shortcode']['cart_content_gen_type'] )
			&& $params['attr_shortcode']['cart_content_gen_type'] === 'dropdown-cart'
		) {
			Prodigy_Template::prodigy_get_template( 'shortcode/cart.php', $params );
		} elseif ( isset( $params['attr_shortcode']['cart_content_gen_type'] )
					&& $params['attr_shortcode']['cart_content_gen_type'] === 'slide-cart'
		) {
			Prodigy_Template::prodigy_get_template( 'shortcode/cart-modal-slide.php', $params );
		} else {
			Prodigy_Template::prodigy_get_template( 'shortcode/cart.php', $params );
		}
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_breadcrumbs' ) ) {
	function prodigy_get_template_shortcode_breadcrumbs( $data ) {
		Prodigy_Template::prodigy_get_template( 'shortcode/breadcrumbs.php', $data );
	}
}

if ( ! function_exists( 'prodigy_get_template_shortcode_attributes_filter_layout' ) ) {
	function prodigy_get_template_shortcode_attributes_filter_layout( $data = array() ) {
		$mapper = new Prodigy_Filter_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );
		Prodigy_Template::prodigy_get_template( 'shortcode/filter-layout.php', $params );
	}
}


if ( ! function_exists( 'prodigy_get_template_shortcode_active_filters' ) ) {
	function prodigy_get_template_shortcode_active_filters( $data ) {
		$mapper = new Prodigy_Active_Filter_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );

		wp_enqueue_script(
			'active-filter',
			plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/active-filter.js' ) . 'active-filter.js',
			array( 'jquery' ),
			PRODIGY_VERSION
		);
		wp_localize_script(
			'active-filter',
			'prodigy_active_filter',
			array( 'current_type_tag' => Prodigy::get_prodigy_tag_type() )
		);

		Prodigy_Template::prodigy_get_template( 'shortcode/active-filters.php', $params );
	}
}

/**
 * Render feed_categories shortcode
 */
if ( ! function_exists( 'prodigy_shortcode_get_template_feed_categories' ) ) {
	function prodigy_shortcode_get_template_feed_categories( $data ) {
		Prodigy_Template::prodigy_get_template( 'shortcode/feed_categories.php', $data );
	}
}

if ( ! function_exists( 'prodigy_shortcode_get_template_banner' ) ) {
	function prodigy_shortcode_get_template_banner( $data ) {
		Prodigy_Template::prodigy_get_template( 'shortcode/banner.php', $data );
	}
}

/**
 * Render our_categories shortcode
 */
if ( ! function_exists( 'prodigy_get_template_category_link' ) ) {
	function prodigy_get_template_category_link( $data ) {
		$mapper = new Prodigy_Category_Data_Mapper();
		$params = $mapper->get_default_parameters( $data );
		Prodigy_Template::prodigy_get_template( 'shortcode/category_link.php', $params );
	}
}

/**
 * Render cart shortcode (page)
 */
if ( ! function_exists( 'prodigy_get_template_cart_page' ) ) {
	function prodigy_get_template_cart_page( $params ) {
		$mapper         = new Prodigy_Cart_Page_Data_Mapper();
		$default_params = $mapper->get_default_parameters( $params );

		Prodigy_Template::prodigy_get_template( 'shortcode/pages/cart/common.php', $default_params );
	}
}

/**
 * Render subscription shortcode (page)
 */
if ( ! function_exists( 'prodigy_get_template_shortcode_subscription' ) ) {
	function prodigy_get_template_shortcode_subscription( $data ) {
		Prodigy_Template::prodigy_get_template( 'shortcode/theme/subscription.php', $data );
	}
}

/**
 * Render products widgets template
 */
if ( ! function_exists( 'prodigy_get_template_products' ) ) {
	function prodigy_get_template_products( $options ) {
		$products_data_mapper = new Prodigy_Products_Data_Mapper();
		$params               = $products_data_mapper->get_default_parameters( $options );
		if ( $params['display'] === Prodigy_Main_Data_Mapper::SLIDER ) {
			Prodigy_Template::prodigy_get_template( 'shortcode/products.php', $params );
		} else {
			$item_per_page = 0;
			$page          = sanitize_key( wp_unslash( $_GET['pg'] ?? 1 ) );
			if ( $params['display'] === Prodigy_Main_Data_Mapper::GRID ) {
				$item_per_page = ! empty( $options['content_archive_products_content_items_number'] )
					? $options['content_archive_products_content_items_number']
					: Prodigy_Shop_Page::NUMBER_ITEMS_PER_PAGE;
			}

			$params['pagination'] = $products_data_mapper->get_pagination( (int) $page, $item_per_page, $params['products'] );
			Prodigy_Template::prodigy_get_template( 'shortcode/products_grid.php', $params );
		}
	}
}

/**
 * Render categories widgets
 */
if ( ! function_exists( 'prodigy_get_template_categories' ) ) {
	/**
	 * @param $settings
	 *
	 * @return void
	 * @throws \Random\RandomException
	 */
	function prodigy_get_template_categories( $settings = array() ) {
		$categories_data_mapper = new Prodigy_Categories_Data_Mapper();
		$params                 = $categories_data_mapper->get_default_parameters( $settings );
		if ( $params['display'] === Prodigy_Main_Data_Mapper::SLIDER ) {
			Prodigy_Template::prodigy_get_template( 'shortcode/categories.php', $params );
			wp_enqueue_script( 'categories', plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/categories.js' ) . 'categories.js', array( 'jquery' ), PRODIGY_VERSION );
		} else {
			Prodigy_Template::prodigy_get_template( 'shortcode/categories_grid.php', $params );
		}
	}
}

/**
 * Render products shortcode
 */
if ( ! function_exists( 'prodigy_get_template_shortcode_products' ) ) {
	function prodigy_get_template_shortcode_products( $data ) {
		$data_mapper = new Prodigy_Related_Products_Data_Mapper();
		$options     = $data_mapper->get_default_parameters( (array) $data );

		if ( isset( $data['display'] ) && $data['display'] === 'grid' ) {
			Prodigy_Template::prodigy_get_template( 'shortcode/related-grid-products.php', $options );
		} else {
			Prodigy_Template::prodigy_get_template( 'shortcode/related-slider-products.php', $options );
			wp_enqueue_script( 'feature-products', plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/feature-products.js' ) . 'feature-products.js', array( 'jquery' ), PRODIGY_VERSION );
		}
	}
}


if ( ! function_exists( 'prodigy_get_thank_you_page' ) ) {
	function prodigy_get_thank_you_page() {
		echo do_shortcode( '[prodigy_thank_you_page]' );
	}
}

if ( ! function_exists( 'prodigy_mobile_sortable' ) ) {
	/**
	 * @param $settings
	 *
	 * @return void
	 */
	function prodigy_mobile_sortable( $settings = array() ) {
		$categories_data_mapper = new Prodigy_Shop_Mobile_Sortable_Data_Mapper();
		$params                 = $categories_data_mapper->get_default_parameters( $settings );
		Prodigy_Template::prodigy_get_template( 'shop/mobile-sortable.php', $params );
	}
}

if ( ! function_exists( 'prodigy_shop_get_breadcrumbs_template' ) ) {
	function prodigy_shop_get_breadcrumbs_template() {
		echo do_shortcode( '[prodigy_breadcrumbs_list]' );
	}
}

if ( ! function_exists( 'prodigy_get_active_filters' ) ) {
	function prodigy_get_active_filters( $instance ) {
		if ( ! empty( $instance ) ) {
			$str = http_build_query( $instance, '', ' ' );
			echo do_shortcode( '[prodigy_active_filter ' . $str . ']' );
		}
	}
}

if ( ! function_exists( 'prodigy_shop_get_template_sortable' ) ) {
	/**
	 * @param $settings
	 *
	 * @return void
	 */
	function prodigy_shop_get_template_sortable( $settings = array() ) {
		$categories_data_mapper = new Prodigy_Shop_Sortable_Data_Mapper();
		$params                 = $categories_data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'shop/sortable.php', $params );
	}
}

if ( ! function_exists( 'prodigy_shop_get_content_template' ) ) {
	function prodigy_shop_get_content_template( $content ) {
		Prodigy_Template::prodigy_get_template( 'shop/content.php', $content );
	}
}

if ( ! function_exists( 'prodigy_shop_get_quick_template' ) ) {
	function prodigy_shop_get_quick_template() {
		Prodigy_Template::prodigy_get_template( 'shop/quick-view.php' );
	}
}


if ( ! function_exists( 'prodigy_get_template_without_result_template' ) ) {
	function prodigy_get_template_without_result_template() {
		Prodigy_Template::prodigy_get_template( 'shop/no-search-results.php' );
	}
}


if ( ! function_exists( 'prodigy_get_template_products_loop' ) ) {
	function prodigy_get_template_products_loop( $content ) {
		$data_mapper = new Prodigy_Shop_Data_Mapper();
		$data        = $data_mapper->get_default_parameters( $content );
		Prodigy_Template::prodigy_get_template( 'shop/products-loop.php', $data );
	}
}


if ( ! function_exists( 'prodigy_get_template_products_loop_rating' ) ) {
	function prodigy_get_template_products_loop_rating( $data ) {
		Prodigy_Template::prodigy_get_template( 'shop/products-loop-rating.php', $data );
	}
}

if ( ! function_exists( 'prodigy_get_pagination_template' ) ) {
	function prodigy_get_pagination_template() {
		Prodigy_Template::prodigy_get_template( 'shop/pagination.php' );
	}
}

if ( ! function_exists( 'prodigy_shop_sidebar_template' ) ) {
	/**
	 * Render shop sidebar
	 *
	 * @return void
	 */
	function prodigy_shop_sidebar_template() {
		$customizer_shop_options = get_option( 'prodigy_shop_settings' );
		$prodigy_shop_sidebar    = $customizer_shop_options['prodigy_shop_sidebar_display'] ?? Prodigy_Customizer::PRODIGY_SHOW_SIDEBAR;
		$options                 = compact( 'prodigy_shop_sidebar' );

		if ( $prodigy_shop_sidebar ) {
			Prodigy_Template::prodigy_get_template( 'shop/sidebar.php', $options );
		}
	}
}

if ( ! function_exists( 'prodigy_photoswipe' ) ) {
	function prodigy_photoswipe() {
		Prodigy_Template::prodigy_get_template( 'single-product/photoswipe.php' );
	}
}

if ( ! function_exists( 'prodigy_product_template_short_description' ) ) {
	/**
	 * Output the start of the page wrapper.
	 */
	function prodigy_product_template_short_description( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Short_Description_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/short-description.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_product_template_title' ) ) {
	/**
	 * Output the product title.
	 *
	 * @param $settings
	 *
	 * @throws DOMException
	 */
	function prodigy_product_template_title() {
		$data_mapper = new Prodigy_Product_Title_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( array() );
		Prodigy_Template::prodigy_get_template( 'single-product/title.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_product_template_range_price' ) ) {
	/**
	 * Output the product price range.
	 */
	function prodigy_product_template_range_price( $settings = array() ) {
		if ( Prodigy_Options::get_redemption_store_status() ) {
			$data_mapper = new Prodigy_Product_Price_Data_Mapper();
			$parameters  = $data_mapper->get_default_parameters();
			Prodigy_Template::prodigy_get_template( 'single-product/range-price.php', $parameters );
		}
	}
}

if ( ! function_exists( 'prodigy_product_template_quick_view_title' ) ) {
	/**
	 * Output the product quick view title.
	 */
	function prodigy_product_template_quick_view_title() {
		Prodigy_Template::prodigy_get_template( 'single-product/quick_view_title.php' );
	}
}


if ( ! function_exists( 'prodigy_product_template_variants' ) ) {
	/**
	 * Output the product variants.
	 */
	function prodigy_product_template_variants( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Variants_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/variants-layout.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_product_get_logo_template' ) ) {
	/**
	 * @param array $params
	 *
	 * @return void
	 */
	function prodigy_product_get_logo_template( array $params ) {
		Prodigy_Template::prodigy_get_template( 'single-product/logo/product-logo.php', $params );
	}
}

if ( ! function_exists( 'prodigy_product_template_meta' ) ) {
	/**
	 * Output the product meta.
	 */
	function prodigy_product_template_meta() {
		Prodigy_Template::prodigy_get_template( 'single-product/meta.php' );
	}
}

if ( ! function_exists( 'prodigy_product_template_add_to_cart' ) ) {
	/**
	 * Output the product cart.
	 */
	function prodigy_product_template_add_to_cart( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Add_To_Cart_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/add-to-cart.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_product_template_additional_info' ) ) {
	/**
	 * Output the product sku.
	 */
	function prodigy_product_template_additional_info( $settings = array() ) {
		Prodigy_Template::prodigy_get_template( 'single-product/product-additional-info.php', $settings );
	}
}

if ( ! function_exists( 'prodigy_product_template_sku' ) ) {
	/**
	 * Output the product sku.
	 */
	function prodigy_product_template_sku( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Sku_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/product-sku.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_product_template_tags' ) ) {
	/**
	 * Output the product tags.
	 */
	function prodigy_product_template_tags( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Tags_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/product-tags.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_single_product_breadcrumbs_template' ) ) {
	/**
	 * Output the breadcrumbs.
	 */
	function prodigy_single_product_breadcrumbs_template( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Breadcrumbs_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/breadcrumbs.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_show_product_images' ) ) {
	/**
	 * Output the product image.
	 */
	function prodigy_show_product_images( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Image_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/product-image.php', $parameters );
	}
}

if ( ! function_exists( 'prodigy_show_product_thumbnails' ) ) {
	/**
	 * Output the product thumbnails.
	 */
	function prodigy_show_product_thumbnails( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Thumbnails_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/product-thumbnails.php', $parameters );
	}
}

if ( ! function_exists( 'max_srcset_image_width_func' ) ) {

	/**
	 * Output the product tabs.
	 */
	function max_srcset_image_width_func() {
		return 1;
	}
}

if ( ! function_exists( 'prodigy_output_product_data_tabs' ) ) {

	/**
	 * Output the product tabs.
	 */
	function prodigy_output_product_data_tabs( $settings = array() ) {
		Prodigy_Template::prodigy_get_template( 'single-product/tabs/tabs.php', $settings );
	}
}

if ( ! function_exists( 'prodigy_product_description_tab' ) ) {

	/**
	 * Output the description tab description.
	 */
	function prodigy_product_description_tab() {
		Prodigy_Template::prodigy_get_template( 'single-product/tabs/description.php' );
	}
}

if ( ! function_exists( 'prodigy_product_additional_information_tab' ) ) {

	/**
	 * Output the attributes tab additional information.
	 */
	function prodigy_product_additional_information_tab() {
		Prodigy_Template::prodigy_get_template( 'single-product/tabs/additional-information.php' );
	}
}

if ( ! function_exists( 'prodigy_product_comments_tab' ) ) {

	/**
	 * Output the attributes tab additional information.
	 */
	function prodigy_product_comments_tab( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Review_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-products-reviews.php', $parameters );
	}
}


if ( ! function_exists( 'prodigy_product_tiered_prices_tab' ) ) {
	/**
	 * Output the tiered prices information.
	 */
	function prodigy_product_tiered_prices_tab( $settings = array() ) {
		Prodigy_Template::prodigy_get_template( 'single-product/tabs/tiered_prices.php', $settings );
	}
}

if ( ! function_exists( 'is_prodigy_product_taxonomy' ) ) {

	/**
	 * Is_prodigy_product_taxonomy - Returns true when viewing a product taxonomy archive.
	 *
	 * @return bool
	 */
	function is_prodigy_product_taxonomy() {
		return is_tax( get_object_taxonomies( Prodigy::get_prodigy_product_type() ) );
	}
}

if ( ! function_exists( 'prodigy_default_product_tabs' ) ) {

	/**
	 * @param $params
	 *
	 * @return array|void
	 */
	function prodigy_default_product_tabs( $params ) {
		if ( empty( $GLOBALS['prodigy_product'] ) && ! empty( $params['product'] ) ) {
			$GLOBALS['prodigy_product'] = $params['product'];
		}

		$product = $GLOBALS['prodigy_product'];

		if ( ! empty( $product ) ) {
			$description = $product->get_remote_description();
			$tabs        = array();
			// Description tab - shows product content.
			if ( $description ) {
				$tabs['description'] = array(
					'title'    => __( 'Description', 'prodigy' ),
					'priority' => 10,
					'callback' => 'prodigy_product_description_tab',
					'settings' => $params['settings'] ?? ElementorTabs::TAB_VALUE_NEGATIVE_OPTION,
				);
			}

			$tabs['additional_information'] = array(
				'title'    => __( 'Additional information', 'prodigy' ),
				'priority' => 20,
				'callback' => 'prodigy_product_additional_information_tab',
				'settings' => $params['settings'] ?? ElementorTabs::TAB_VALUE_NEGATIVE_OPTION,
			);

			$count           = Prodigy_Product_Comments::get_count_comments( $product->get_field( 'ID' ) );
			$tabs['reviews'] = array(
				/* translators: %s: reviews count */
				'title'    => sprintf( __( 'Reviews (%d)', 'prodigy' ), $count ?? 0 ),
				'priority' => 30,
				'callback' => 'prodigy_product_comments_tab',
				'settings' => $params['settings'] ?? ElementorTabs::TAB_VALUE_NEGATIVE_OPTION,
			);

			if ( ( defined( 'ELEMENTOR_VERSION' )
					&& \Elementor\Plugin::$instance->editor->is_edit_mode() ) ||
				$product->tiered_prices
			) {
				$tabs['tiered_prices'] = array(
					'title'    => __( 'QTY and Price Breaks', 'prodigy' ),
					'priority' => 40,
					'callback' => 'prodigy_product_tiered_prices_tab',
					'settings' => $params['settings'] ?? ElementorTabs::TAB_VALUE_NEGATIVE_OPTION,
				);
			}

			return $tabs;
		}
	}
}

if ( ! function_exists( 'prodigy_comments' ) ) {

	/**
	 * Output the Review comments template.
	 *
	 * @param WP_Comment $comment
	 * @param array      $args
	 * @param int        $depth
	 */
	function prodigy_comments( $comment, $args, $depth ) {
		$GLOBALS['prodigy_comment'] = $comment;
		Prodigy_Template::prodigy_get_template(
			'single-product/review.php',
			array(
				'comment' => $comment,
				'args'    => $args,
				'depth'   => $depth,
			)
		);
	}
}

if ( ! function_exists( 'prodigy_display_product_attributes' ) ) {
	/**
	 * Outputs a list of product attributes for a product.
	 */
	function prodigy_display_product_attributes( $settings = array() ) {
		$data_mapper = new Prodigy_Product_Attributes_Data_Mapper();
		$parameters  = $data_mapper->get_default_parameters( (array) $settings );
		Prodigy_Template::prodigy_get_template( 'single-product/product-attributes.php', $parameters );
	}
}


if ( ! function_exists( 'prodigy_product_template_review_rating' ) ) {
	/**
	 * Display the reviewers star rating
	 *
	 * @return void
	 */
	function prodigy_product_template_review_rating() {
		if ( post_type_supports( Prodigy::get_prodigy_product_type(), 'comments' ) ) {
			Prodigy_Template::prodigy_get_template( 'single-product/review-rating.php' );
		}
	}
}

if ( ! function_exists( 'prodigy_product_template_rating' ) ) {

	/**
	 * Output the product rating.
	 */
	function prodigy_product_template_rating( $settings = array() ) {

		if ( post_type_supports( Prodigy::get_prodigy_product_type(), 'comments' ) ) {
			$data_mapper = new Prodigy_Product_Rating_Data_Mapper();
			$parameters  = $data_mapper->get_default_parameters( (array) $settings );
			Prodigy_Template::prodigy_get_template( 'single-product/rating.php', $parameters );
		}
	}
}


if ( ! function_exists( 'prodigy_review_display_meta' ) ) {
	/**
	 * Display the review authors meta (name, verified owner, review date)
	 *
	 * @return void
	 */
	function prodigy_review_display_meta() {
		Prodigy_Template::prodigy_get_template( 'single-product/review-meta.php' );
	}
}

if ( ! function_exists( 'prodigy_review_display_comment_text' ) ) {

	/**
	 * Display the review content.
	 */
	function prodigy_review_display_comment_text() {
		echo '<div class="prodigy-product-review__text">';
		comment_text();
		echo '</div>';
	}
}

/**
 * Get HTML for ratings.
 *
 * @param float $rating
 *
 * @return string
 */
function pg_get_rating_html( $rating ) {
	$html = '<div class="prodigy-star-rating">' . pg_get_star_rating_html( $rating ) . '</div>';

	return apply_filters( 'prodigy_product_get_rating_html', $html, $rating );
}

/**
 * Get HTML for star rating.
 *
 * @param float $rating
 *
 * @return string
 */
function pg_get_star_rating_html( $rating ) {
	$html = '<span class="prodigy-star-rating__item" style="width:' . ( ( roundToHalf( $rating ) / 5 ) * 100 ) . '%"></span>';

	return apply_filters( 'pg_get_star_rating_html', $html, $rating );
}

/**
 * @param int $x
 *
 * @return float
 */
function roundToHalf( $x ) {
	if ( ! $x ) {
		return 0;
	}

	return ceil( $x / 0.5 ) * 0.5;
}


if ( ! function_exists( 'prodigy_review_display_gravatar' ) ) {
	/**
	 * Display the review authors gravatar
	 *
	 * @param array $comment
	 *
	 * @return void
	 */
	function prodigy_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, apply_filters( 'prodigy_review_gravatar_size', '60' ), '' );
	}
}


/**
 * @param array $attachment
 * @param int   $image_id
 *
 * @return string
 */
function prodigy_get_remote_gallery_image_html( array $attachment, int $image_id ): string {
	$width        = $attachment['cropping-params']['w'] ?? '800';
	$height       = $attachment['cropping-params']['h'] ?? '1000';
	$view_box     = 0 . ' ' . 0 . ' ' . $width . ' ' . $height;
	$image_url    = $attachment['cropped-url'] ?? '';
	$image_retina = $attachment['versions']['catalog_retina'] ?? '';

	$image = '<svg style="vertical-align: middle; height: 100%" viewBox="' . $view_box . '" xmlns="http://www.w3.org/2000/svg">
		<desc>"' . esc_html__( 'Product', 'prodigy' ) . '"</desc>
			<image class="thumb-gallery-image-js" style="height: 100%; width: 100%" href="' . $image_url . '" data-image-id="' . $image_id . '" loading="lazy" />

			<image class="thumb-gallery-logo-js" href="" data-image-id="' . $image_id . '" height="0" width="0" x="0" y="0" style="" loading="lazy"></image>
		</svg>';

	return '<div class="swiper-slide"><div class="prodigy-product__gallery-img p-0">' . $image . '</div></div>';
}

/**
 * @param array $line_item
 *
 * @return string
 */
function get_cart_item_logo_image_template( array $line_item ): string {
	if ( empty( $line_item['image_src'] ) ) {
		return '<i class="icon icon-image"></i>';
	}

	$width    = $line_item['attributes']['image-cropping-params']['w'] ?? '800';
	$height   = $line_item['attributes']['image-cropping-params']['h'] ?? '1000';
	$view_box = 0 . ' ' . 0 . ' ' . $width . ' ' . $height;

	$svg = sprintf(
		'<svg style="vertical-align: middle; height: 100%%" viewBox="%s" xmlns="http://www.w3.org/2000/svg">
            <desc>%s</desc>
            <image style="width: 100%%; height: 100%%;" href="%s" loading="lazy"></image>',
		esc_attr( $view_box ),
		esc_html__( 'Product', 'prodigy' ),
		esc_url( $line_item['attributes']['image-url'] ?? '' )
	);

	if ( ! empty( $line_item['attributes']['logos'] ) ) {
		foreach ( $line_item['attributes']['logos'] as $logo ) {
			if ( $logo['logo']['visible'] ) {
				$transformX = $logo['location']['x'] + ( $logo['location']['width'] / 2 );
				$transformY = $logo['location']['y'] + ( $logo['location']['height'] / 2 );
				$svg       .= sprintf(
					'<image href="%s" height="%s" width="%s" x="%s" y="%s" style="transform-origin: %spx %spx; transform: rotate(%sdeg) rotateY(%sdeg) rotateX(%sdeg);" loading="lazy"></image>',
					esc_url( $logo['logo']['original-url'] ?? '' ),
					esc_attr( $logo['location']['height'] ?? '' ),
					esc_attr( $logo['location']['width'] ?? '' ),
					esc_attr( $logo['location']['x'] ?? '' ),
					esc_attr( $logo['location']['y'] ?? '' ),
					esc_attr( $transformX ),
					esc_attr( $transformY ),
					esc_attr( $logo['location']['angle'] ?? '' ),
					esc_attr( $logo['location']['rotation-y'] ?? '' ),
					esc_attr( $logo['location']['rotation-x'] ?? '' )
				);
			}
		}
	}
	$svg .= '</svg>';

	return $svg;
}

/**
 * @param array $product
 *
 * @return string
 */
function get_shop_product_logo_image_template( array $product ): string {
	if ( empty( $product['versions-image-url']['cropped'] ) ) {
		return '';
	}

	$width    = $product['image-cropping-params']['w'] ?? '1000';
	$height   = $product['image-cropping-params']['h'] ?? '1000';
	$view_box = 0 . ' ' . 0 . ' ' . $width . ' ' . $height;

	$svg = sprintf(
		'<svg class="prodigy-product-list__item-preview-img" style="vertical-align: middle;height: 100%%" viewBox="%s" xmlns="http://www.w3.org/2000/svg">
            <desc>%s</desc>
            <image style="width: 100%%;height: 100%%" href="%s" loading="lazy"></image>',
		esc_attr( $view_box ),
		esc_html__( 'Product', 'prodigy' ),
		esc_url( $product['versions-image-url']['cropped'] ?? '' )
	);

	if (
		! empty( $product['logo-location'] ) &&
		! empty( $product['logo'] ) &&
		! empty( $product['image-cropping-params'] )
	) {
		if ( isset( $product['logo-location']['x'], $product['logo-location']['width'] ) ) {
			$transformX = $product['logo-location']['x'] + ( $product['logo-location']['width'] / 2 );
		}
		if ( isset( $product['logo-location']['y'], $product['logo-location']['height'] ) ) {
			$transformY = $product['logo-location']['y'] + ( $product['logo-location']['height'] / 2 );
		}

		$svg .= sprintf(
			'<image href="%s" height="%s" width="%s" x="%s" y="%s" style="transform-origin: %spx %spx; transform: rotate(%sdeg) rotateY(%sdeg) rotateX(%sdeg);" loading="lazy"></image></svg>',
			esc_url( $product['logo']['original_url'] ?? '' ),
			esc_attr( $product['logo-location']['height'] ?? '' ),
			esc_attr( $product['logo-location']['width'] ?? '' ),
			esc_attr( $product['logo-location']['x'] ?? '' ),
			esc_attr( $product['logo-location']['y'] ?? '' ),
			esc_attr( $transformX ?? 0 ),
			esc_attr( $transformY ?? 0 ),
			esc_attr( $product['logo-location']['angle'] ?? '' ),
			esc_attr( $product['logo-location']['rotation_y'] ?? '' ),
			esc_attr( $product['logo-location']['rotation_x'] ?? '' )
		);
	}

	return $svg;
}

/**
 * @param array $attachment
 * @param int   $image_id
 *
 * @return string
 */

function prodigy_get_remote_gallery_thumb_html( array $attachment, int $image_id ): string {
	$width        = $attachment['cropping-params']['w'] ?? '800';
	$height       = $attachment['cropping-params']['h'] ?? '1000';
	$view_box     = 0 . ' ' . 0 . ' ' . $width . ' ' . $height;
	$image_url    = $attachment['cropped-url'] ?? '';
	$image_retina = $attachment['versions']['catalog_retina'] ?? '';

	$image = '<div class="prodigy-product__gallery-img p-0">
				<img class="d-none" alt="' . esc_html__( 'Product', 'prodigy' ) . '" data-large_image_width="' . $width . '" data-large_image_height="' . $height . '" src="' . $image_url . '" data-large_image="' . $image_retina . '" />
				<svg style="vertical-align: middle;" viewBox="' . $view_box . '" xmlns="http://www.w3.org/2000/svg" >
					<image class="main-gallery-image-js" style="width: 100%" data-image-id="' . $image_id . '" href="' . $image_url . '"></image>
					<image class="prodigy-product__gallery-logo-js" data-image-id="' . $image_id . '" data-id="logo-id" href="" height="200" width="200" x="363" y="235" style="transform-origin: 463px 352.5px; transform: rotate(-24deg) rotateY(45deg) rotateX(45deg);"></image>
				</svg>
			  </div>';

	return '<div class="swiper-slide">' . $image . '</div>';
}


/**
 * @param int    $category_id
 * @param object $post
 *
 * @return bool
 */
function has_post_category( int $category_id, $post ): bool {
	return has_term( $category_id, Prodigy::get_prodigy_category_type(), $post );
}

/**
 * @param int    $tag_id
 * @param object $post
 *
 * @return bool
 */
function has_post_tag( int $tag_id, $post ): bool {
	return has_term( $tag_id, Prodigy::get_prodigy_tag_type(), $post );
}

function get_format_related_products( $products ) {
	$products_data = array();

	if ( ! empty( $products ) ) {

		foreach ( $products as $key => $product ) {
			$local_product = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $product['id'] );

			$products_data['data'][ $key ]['id']                    = (int) $product['id'];
			$products_data['data'][ $key ]['name']                  = $product['attributes']['name'] ?? '';
			$products_data['data'][ $key ]['regular_price']         = $product['attributes']['price'] ?? '';
			$products_data['data'][ $key ]['sale_price']            = $product['attributes']['sale-price'] ?? '';
			$products_data['data'][ $key ]['versions-image-url']    = $product['attributes']['versions-image-url'] ?? '';
			$products_data['data'][ $key ]['rating']                = $product['attributes']['rating'] ?? '';
			$products_data['data'][ $key ]['logo-location']         = $product['attributes']['logo-location'] ?? '';
			$products_data['data'][ $key ]['logo']                  = $product['attributes']['logo'] ?? '';
			$products_data['data'][ $key ]['image-cropping-params'] = $product['attributes']['image-cropping-params'] ?? '';
			if ( isset( $local_product->post_id ) ) {
				$products_data['data'][ $key ]['local_url'] = esc_url( get_permalink( $local_product->post_id ) );
			}

			$categories                                = explode( ',', $product['attributes']['categories-list'] ?? '' );
			$products_data['data'][ $key ]['category'] = $categories[0] ?? '';
		}
		$products_data['products-count'] = $product['attributes']['products-count'] ?? '';
	}

	return $products_data;
}

if ( ! function_exists( 'get_active_product_tab' ) ) {
	/**
	 * Set tabs
	 *
	 * @param array $tabs
	 * @param array $settings
	 *
	 * @return array
	 */
	function get_active_product_tab( array $tabs, array $settings = array() ): array {
		$available_tabs = array_filter(
			array(
				'tiered_price'    => isset( $tabs['tiered_prices'] ) && isset( $settings['general_tabs_controls_content_tiered_prices'] ) && $settings['general_tabs_controls_content_tiered_prices'],
				'description'     => isset( $tabs['description'] ) && ( isset( $settings['general_tabs_controls_content_description'] ) && $settings['general_tabs_controls_content_description'] ),
				'additional_info' => isset( $tabs['additional_information'] ) && ( isset( $settings['general_tabs_controls_content_additional_info'] ) && $settings['general_tabs_controls_content_additional_info'] ),
				'reviews'         => isset( $tabs['reviews'] ) && ( isset( $settings['general_tabs_controls_content_reviews'] ) && $settings['general_tabs_controls_content_reviews'] ),
			)
		);

		if ( empty( $available_tabs ) || isset( $available_tabs['description'] ) ) {
			$tabs['description']['active']                          = true;
			$tabs['description']['prodigy_product_description_tab'] = true;
		}

		if ( isset( $available_tabs['tiered_price'] ) ) {
			$tabs['tiered_prices']['prodigy_product_tiered_prices_tab'] = true;
		}

		if ( isset( $available_tabs['additional_info'] ) ) {
			$tabs['additional_information']['prodigy_product_additional_information_tab'] = true;
		}

		if ( isset( $available_tabs['reviews'] ) ) {
			$tabs['reviews']['prodigy_product_comments_tab'] = true;
		}

		return $tabs;
	}
}
