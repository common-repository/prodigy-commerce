<?php

use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Product_Comments;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Page as Page_Helper;

/** remove wp_ob_end_flush errors */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

add_filter( 'template_redirect', 'reset_plugin_template' );
add_filter( 'comment_form_defaults', 'prodigy_isa_comment_reform' );
add_action( 'comment_form', 'prodigy_comment_nonce_to_form' );
add_action( 'widgets_init', 'prodigy_register_shop_sidebar' );
add_action( 'admin_menu', 'hide_the_add_new_menu_item' );
add_filter( 'body_class', 'body_cart_page_classes', 11 );
add_action( 'transition_comment_status', 'my_approve_comment_callback', 10, 3 );


/**
 * Its help for problems with cookie settings
 *
 * @return void
 */
function reset_plugin_template() {
	ob_start( null, 0, 0 );
}

/**
 * Change standard review title
 *
 * @param  array $arg
 *
 * @return array
 */
function prodigy_isa_comment_reform( array $arg ): array {

	if ( Prodigy_Template::prodigy_is_blog() ) {
		$arg['title_reply'] = __( 'Leave a Comment' );
	}
	if ( isset( $GLOBALS['prodigy_product'] ) ) {
		$product = $GLOBALS['prodigy_product'];
		if ( $product ) {

			$title = sprintf(
				// translators: %1$s is the product name.
				__( 'My Review for %1$s', 'prodigy' ),
				$product->get_field( 'post_title' )
			);
			$arg['title_reply'] = $title;
		}
	}
	return $arg;
}

/**
 * Show a shop page content on selected page.
 */
function prodigy_container_shop_block() {

	// Don't display the description on search results page.
	if ( is_search() ) {
		return;
	}

	$info_shop_page = Page_Helper::prodigy_get_page_id( 'shop' );

	/*
	 * if page is not "shop" then don't display the content page
	 */
	if ( empty( $info_shop_page ) ) {
		return;
	}

	$shop_page = false;
	$part      = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : array();

	if ( ! Prodigy_Template::prodigy_check_shop_page() && ! strpos( $part, 'shop' ) ) {
		$shop_page = get_post( $info_shop_page );
	}

	if ( $shop_page && Prodigy_Shop_Page::is_archive_page_url( $part ) ) {
		$page_content = Prodigy_Formatting::prodigy_format_content( $shop_page->post_content );
		if ( $page_content ) {
			echo '<div class="container prodigy-container-description">' . esc_attr( $page_content ) . '</div>';
		}
	}
}

/**
 * Add sidebar for shop page

 * @return void
 */
function prodigy_register_shop_sidebar() {
	register_sidebar(
		array(
			'id'            => 'prodigy_shop_sidebar',
			'name'          => 'Shop Sidebar',
			'description'   => 'Left sidebar for prodigy widgets',
			'before_widget' => '<div class="prodigy-filter__main">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="prodigy-filter__title">',
			'after_title'   => '</h3>',
		)
	);
}

/**
 * Hide certain item of menu

 * @return void
 */
function hide_the_add_new_menu_item() {
	global $submenu;
	unset( $submenu[ 'edit.php?post_type=' . Prodigy::get_prodigy_product_type() ][10] );
}

/**
 * @param  array  $sidebars_widgets
 *
 * @return array
 */

/**
 * @param  array $classes
 *
 * @return array
 */
function body_cart_page_classes( array $classes ): array {
	global $wp;

	$current_page_id = get_queried_object_id();
	$post_type       = get_post_type( $current_page_id );

	$prodigy_pages = array(
		Page_Helper::prodigy_get_page_id( 'cart' )  => Prodigy_Page::PRODIGY_CART_PAGE,
		Page_Helper::prodigy_get_page_id( 'thank' ) => Prodigy_Page::PRODIGY_THANK_PAGE,
		Page_Helper::prodigy_get_page_id( 'shop' )  => Prodigy_Page::PRODIGY_SHOP_PAGE,
	);

	if ( Prodigy_Template::is_prodigy_shop() ) {
		$classes[] = 'tax-prodigy-product-shop';
	}

	if ( isset( $prodigy_pages[ $current_page_id ] ) || $post_type === Prodigy::PRODIGY_POST_TYPE_DEFAULT || Prodigy_Template::is_prodigy_shop() ) {
		$classes[] = 'prodigy-wrapper-container';
	} else {
		$classes[] = '';
	}

	if ( isset( $prodigy_pages[ $current_page_id ] ) && $prodigy_pages[ $current_page_id ] === Prodigy_Page::PRODIGY_CART_PAGE ) {
		$classes[] = 'prodigy-entry-content-width';
	}

	$current_screen = get_post();
	if ( isset( $current_screen->post_type ) && $current_screen->post_type === 'elementor_library' ) {
		$classes[] = 'prodigy-elementor-wrapper';
	}

	$pagesIn = array(
		Prodigy_Page::PAGE_TYPE_SHOP,
		Prodigy_Page::PAGE_TYPE_THANK,
	);

	if ( empty( $wp->request ) ) {
		$classes[] = '';
	} elseif ( in_array( $wp->request, $pagesIn, true ) ) {
		$classes[] = '';
	} elseif ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) {

		if ( did_action( 'elementor/loaded' ) ) {
			if ( in_array( 'elementor-template-full-width', $classes, true ) ) {
				$classes[] = 'prodigy-elementor-wrapper';
			}
		}
	}

	if ( in_array( 'elementor-template-full-width', $classes, true ) ) {
		$classes[] = 'prodigy-elementor-wrapper';
	}

	return $classes;
}

/**
 * @param  string     $new_status  New comment status.
 * @param  string     $old_status  Previous comment status.
 * @param  WP_Comment $comment  Comment object.
 */
function my_approve_comment_callback( string $new_status, string $old_status, WP_Comment $comment ) {
	if ( $old_status !== $new_status ) {
		$api_client        = new Prodigy_Api_Client();
		$average_rating    = Prodigy_Product_Comments::get_rating_average_product( $comment->comment_post_ID );
		$rating_url        = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::SEND_RATING_URL;
		$remote_product_id = get_post_meta( $comment->comment_post_ID, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );
		$url               = str_replace( ':product_id', $remote_product_id, $rating_url );
		$params            = array( 'rating' => $average_rating );
		$api_client->put_remote_content( $url, $params );
	}
}

/**
 * Add nonce for comment form
 *
 * @return void
 */
function prodigy_comment_nonce_to_form() {
	wp_nonce_field( 'comment_nonce' );
}