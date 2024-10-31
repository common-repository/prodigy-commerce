<?php
/**
 * Addons: Prodigy Addons For Elementor
 * Description: Prodigy Addons gives you multi plugins all in one. It's very powerful for any theme.
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$prodigy_css_path = site_url( '/wp-content/plugins/prodigy-wp-plugin/includes/support/addons/elementor/css/', '' );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'classes/prodigy-elementor.php';

$pae          = new ProdigyElementor( __FILE__ );
$pae->version = '1.0';
$pae->init();

if ( \Prodigy\Includes\Frontend\Prodigy_Layouts_Manager::is_elementor_live_preview() ||
    \Prodigy\Includes\Frontend\Prodigy_Layouts_Manager::is_elementor_template()
) {
    $container_option = get_option('elementor_experiment-container');
    $nested_elements_option = get_option('elementor_experiment-nested-elements');
    $global_styleguide_option = get_option('elementor_experiment-e_global_styleguide');
    $menu_option = get_option('elementor_experiment-mega-menu');
    if ('active' !== $container_option) {
        update_option('elementor_experiment-container', 'active');
    }

    if ('active' !== $nested_elements_option) {
        update_option('elementor_experiment-nested-elements', 'active');
    }

    if ('active' !== $global_styleguide_option) {
        update_option('elementor_experiment-e_global_styleguide', 'active');
    }

    if ('active' !== $menu_option) {
        update_option('elementor_experiment-mega-menu', 'active');
    }
}
