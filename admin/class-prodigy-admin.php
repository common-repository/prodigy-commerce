<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @version 1.0.0
 * @package prodigy/admin
 */

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\includes\synchronization\Prodigy_Synchronization;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Prodigy_Admin {
	/**
	 * The cart instance.
	 *
	 * @var Prodigy_Cart
	 */
	public Prodigy_Cart $cart;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( string $version ) {
		$this->version = $version;
		$this->cart    = new Prodigy_Cart();

		add_action( 'in_admin_header', array( $this, 'screen_option_menus' ) );
	}

	/**
	 * We clear screen option of unnecessary tags
	 */
	public function screen_option_menus() {
		global $wp_meta_boxes;

		$current_screen = get_current_screen();

		if ( isset( $current_screen->id ) && 'nav-menus' === $current_screen->id ) {

			$list            = Prodigy_Product_Attributes::get_attribute_taxonomies();
			$def_list_option = $wp_meta_boxes[ $current_screen->id ]['side']['default'];
			if ( ! empty( $list ) ) {
				foreach ( $list as $value ) {
					$slug = 'add-' . $value->slug;
					if ( array_key_exists( $slug, $def_list_option ) ) {
						unset( $wp_meta_boxes[ $current_screen->id ]['side']['default'][ $slug ] );
					}
				}
			}
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp_prodigy_plugin', Prodigy::plugin_url() . '/assets/admin/css/admin.css', array(), $this->version );
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$screen       = get_current_screen();
		$current_page = $screen ? $screen->id : '';

		if ( in_array( $current_page, Prodigy::get_pages_list(), true ) ) {

			wp_enqueue_script(
				'admin',
				Prodigy::plugin_url() . '/assets/admin/js/admin.js',
				array( 'jquery' ),
				PRODIGY_VERSION
			);

			wp_script_add_data( 'defer', 'async', true );

			wp_localize_script(
				'admin',
				'admin_data',
				array(
					'dir'                       => dirname( plugin_dir_url( __FILE__ ) ) . '/web/',
					'plugin_directory_name'     => get_prodigy_plugin_directory_name(),
					'is_have_sync_notification' => get_option( Prodigy_Synchronization::PRODIGY_NEEDS_SYNC_NOTIFICATION ),
					'sync_notification_message' => get_option( Prodigy_Synchronization::PRODIGY_SYNC_MESSAGE_OPTION ),
					'nonce'                     => wp_create_nonce( 'ajax-nonce' ),
				)
			);
		}
	}
}
