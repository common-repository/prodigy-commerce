<?php

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

global $wpdb;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


if (file_exists(plugin_dir_path( __FILE__ ) . "env.ini")) {
	$path = plugin_dir_path( __FILE__ ) . "env.ini";
	$ini_array = parse_ini_file( "env.ini", true );
}

$prodigy_api_domain     = 'api.prodigycommerce.com';
$prodigy_protocol_domain = 'https://';



if ( isset($ini_array) && ! empty( $ini_array ) && key_exists( 'env_section', $ini_array ) ) {
	if (isset($ini_array['env_section'])) {
		$ini_section = $ini_array['env_section'];
		if ( key_exists( 'APP_API_DOMAIN', $ini_section ) ) {
			$prodigy_api_domain = $ini_section['APP_API_DOMAIN'];
		}
		if ( key_exists( 'APP_PROTOCOL_DOMAIN', $ini_section ) ) {
			$prodigy_protocol_domain = $ini_section['APP_PROTOCOL_DOMAIN'];
		}
	}
}

if ( !defined( 'PRODIGY_PLUGIN_PATH' ) ) {
	define( 'PRODIGY_API_DOMAIN', $prodigy_api_domain );
	define( 'PRODIGY_PROTOCOL_DOMAIN', $prodigy_protocol_domain );
}


/**
 * clear prodigy
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-prodigy-uninstall-plugin.php';
Prodigy\Includes\Prodigy_Uninstall_Plugin::delete_products();
Prodigy\Includes\Prodigy_Uninstall_Plugin::delete_categories();
Prodigy\Includes\Prodigy_Uninstall_Plugin::delete_attributes_terms();

/**
 * disconnection hosted system
 */
if ( ! empty(get_option( 'pg_store_key') ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/content/class-prodigy-api-client.php';
    $prodigy_api_client = new Prodigy\Includes\Content\Prodigy_Api_Client();
    /**
     * only work https to https
     */
    $api_url  = $prodigy_api_client::API_PROTOCOL . PRODIGY_API_DOMAIN . $prodigy_api_client::API_CONNECTION_URL;
    @$prodigy_api_client->delete_remote_content($api_url);
    delete_option( 'pg_store_key');
}

$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%prodigy%' OR option_name LIKE '%pg%'" );

// Tables.
Prodigy\Includes\Prodigy_Uninstall_Plugin::drop_tables();

delete_option('sidebars_widgets');
delete_option( 'widget_active_filters_prodigy_widget');
delete_option( 'widget_filters_prodigy_widget');
delete_option( 'widget_categories_prodigy_widget');
delete_option( 'widget_prodigy_price_filter_widget');

// Clear cache.
wp_cache_flush();