<?php
/**
 * Prodigy themes class
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes\Support;

use Prodigy\Includes\Frontend\Pages\Prodigy_Cart_Page;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Cart;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_My_Account;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Search;
use Prodigy\Includes\Helpers\Prodigy_Cookies;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_User;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Main
 *
 * @package Prodigy\Includes\Support
 */
class Prodigy_Themes_Support {

	const FLATSOME_THEME_NAME = 'flatsome';
	const PRODIGY_ASTRA_THEME = 'astra';
	const PRODIGY_DIVI_THEME  = 'Divi';


	/** @var Prodigy_Cookies  */
	public $cookie_helper;

	/**
	 * String to bool mapper
	 *
	 * @var array
	 */
	private static $menu_widget_items = array(
		Prodigy_Short_Code_Cart::NAME,
		Prodigy_Short_Code_My_Account::NAME,
		Prodigy_Short_Code_Search::NAME,
	);

	/**
	 * Set hooks
	 */
	public function __construct() {
		add_filter( 'wp_nav_menu_items', array( $this, 'add_widgets_in_menu' ), 10, 2 );
		$this->set_default_cart_url();
		$this->cookie_helper = new Prodigy_Cookies();
	}

	/**
	 * Set cart widget on WP menu
	 *
	 * @param string    $menu
	 * @param \stdClass $args
	 *
	 * @return string
	 */
	public function add_widgets_in_menu( string $menu, \stdClass $args ): string {
		$customizer_general_options = get_option( 'prodigy_general_options', array() );
		$require_login              = get_option( 'require_login_option' );
		$my_account_key             = array_search( Prodigy_Short_Code_My_Account::NAME, self::$menu_widget_items, true );
		if ( $my_account_key !== false && $require_login === Prodigy_User::REQUIRE_LOGIN_DISABLED_VALUE ) {
			unset( self::$menu_widget_items[ $my_account_key ] );
		}

		foreach ( self::$menu_widget_items as $item ) {
			$widget_option   = $customizer_general_options[ 'prodigy_enable' . strstr( $item, '_' ) ] ?? false;
			$widget_location = $customizer_general_options[ $item . '_locations' ] ?? array();

			$is_widget_location = is_string( $widget_location ) ?
				$widget_location === $args->theme_location :
				in_array( $args->theme_location, $widget_location, true );

			if ( $is_widget_location && $widget_option ) {
				$menu_item = do_shortcode( '[' . $item . ' dropdown=true type="button"]' );
				$menu     .= $menu_item;
			}
		}

		return $menu;
	}

	/**
	 * @return bool
	 */
	public function set_default_cart_url(): bool {
		global $wpdb;

		$item_name = wp_get_theme()->get_template() === self::FLATSOME_THEME_NAME ? Prodigy_Cart_Page::FLATSOME_CART_URL : Prodigy_Cart_Page::DEFAULT_CART_URL;

		return $wpdb->update( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->posts,
			array( 'post_name' => $item_name ),
			array( 'post_title' => Prodigy_Cart_Page::PAGE_NAME ),
			array( '%s' ),
			array( '%s' )
		);
	}
}
