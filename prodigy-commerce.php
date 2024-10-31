<?php

/**
 * Plugin Name:       Prodigy Commerce
 * Plugin URI:        https://prodigycommerce.com
 * Description:       Provides a comprehensive set of tools to build unparalleled eCommerce experiences on WordPress.
 * Version:           3.0.8
 * Author:            Prodigy Commerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prodigy
 *
 * @package           Prodigy
 */

use Prodigy\Includes\Prodigy_Activator;
use Prodigy\Includes\Prodigy_Deactivator;

const PRODIGY_VERSION = '3.0.8';

if ( file_exists( plugin_dir_path( __FILE__ ) . 'env.ini' ) ) {
	$ini_array = parse_ini_file( 'env.ini', true );
}

$prodigy_environment     = 'production';
$prodigy_api_domain      = 'api.prodigycommerce.com';
$prodigy_main_domain     = 'app.prodigycommerce.com';
$prodigy_checkout_domain = 'prodigycommerce.com';
$prodigy_protocol_domain = 'https://';
$prodigy_debug_mode      = false;

if ( ! empty( $ini_array ) && key_exists( 'env_section', $ini_array ) ) {

	if ( isset( $ini_array['env_section'] ) ) {
		$ini_section = $ini_array['env_section'];
		if ( key_exists( 'APP_ENV', $ini_section ) ) {
			$prodigy_environment = $ini_section['APP_ENV'];
		}
		if ( key_exists( 'APP_API_DOMAIN', $ini_section ) ) {
			$prodigy_api_domain = $ini_section['APP_API_DOMAIN'];
		}
		if ( key_exists( 'APP_MAIN_DOMAIN', $ini_section ) ) {
			$prodigy_main_domain = $ini_section['APP_MAIN_DOMAIN'];
		}
		if ( key_exists( 'APP_PROTOCOL_DOMAIN', $ini_section ) ) {
			$prodigy_protocol_domain = $ini_section['APP_PROTOCOL_DOMAIN'] ?? $prodigy_protocol_domain;
		}
		if ( key_exists( 'APP_CHECKOUT_DOMAIN', $ini_section ) ) {
			$prodigy_checkout_domain = $ini_section['APP_CHECKOUT_DOMAIN'];
		}
		if ( key_exists( 'APP_DEBUG_MODE', $ini_section ) ) {
			$prodigy_debug_mode = $ini_section['APP_DEBUG_MODE'];
		}
	}
}

if ( ! defined( 'PRODIGY_PLUGIN_PATH' ) ) {
	define( 'PRODIGY_ENVIRONMENT', $prodigy_environment );
	define( 'PRODIGY_CHECKOUT_DOMAIN', $prodigy_checkout_domain );
	define( 'PRODIGY_API_DOMAIN', $prodigy_api_domain );
	define( 'PRODIGY_MAIN_DOMAIN', $prodigy_main_domain );
	define( 'PRODIGY_PROTOCOL_DOMAIN', $prodigy_protocol_domain );
	define( 'PRODIGY_DEBUG_MODE', $prodigy_debug_mode );
	define( 'PRODIGY_PLUGIN_PATH', __DIR__ . '/' );
	define( 'PRODIGY_PLUGIN_DIRECTORY_NAME', get_prodigy_plugin_directory_name() );
	define( 'PRODIGY_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}
require_once PRODIGY_PLUGIN_PATH . 'autoload.php';
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define PRODIGY_PLUGIN_FILE.
if ( ! defined( 'PRODIGY_PLUGIN_FILE' ) ) {
	define( 'PRODIGY_PLUGIN_FILE', __FILE__ );
}

// Define PRODIGY_WIZARD_PATH.
if ( ! defined( 'PRODIGY_WIZARD_PATH' ) ) {
	define( 'PRODIGY_WIZARD_PATH', 'web/wizard/' );
}

if ( ! function_exists( 'getallheaders' ) ) {
	/**
	 * Set headers
	 *
	 * @return array
	 */
	function getallheaders(): array {
		$headers = array();
		foreach ( $_SERVER as $name => $value ) {
			if ( substr( $name, 0, 5 ) === 'HTTP_' ) {
				$headers[ str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) ) ] = $value;
			}
		}

		return $headers;
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-prodigy-activator.php
 */
function activate_prodigy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prodigy-activator.php';
	new Prodigy_Activator();
}

/**
 * Get plugin directory name
 *
 * @return string
 */
function get_prodigy_plugin_directory_name(): string {
	return plugin_basename( __DIR__ );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-prodigy-deactivator.php
 */
function deactivate_prodigy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prodigy-deactivator.php';
	Prodigy_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_prodigy' );
register_deactivation_hook( __FILE__, 'deactivate_prodigy' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_prodigy() {
	$plugin = new Prodigy\Includes\Prodigy();
	$plugin->run();
}

run_prodigy();
