<?php

namespace Prodigy\Includes\Frontend;

use Prodigy\Includes\Prodigy_Elementor_Template_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Product_Item
 */
class Prodigy_Layouts_Manager {

	/**
	 * Check if current page using elementor template
	 *
	 * @return bool
	 */
	public static function is_elementor_template(): bool {
		if ( ! is_plugin_active( 'elementor-pro/elementor-pro.php' ) || ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		return Prodigy_Elementor_Template_Loader::is_elementor_page()
		       || ( Prodigy_Elementor_Template_Loader::is_include_single_template() && ! Prodigy_Elementor_Template_Loader::is_exclude_single_template() )
		       || ( Prodigy_Elementor_Template_Loader::is_include_archive_template() && ! Prodigy_Elementor_Template_Loader::is_exclude_archive_template() )
		       || ( Prodigy_Elementor_Template_Loader::is_include_shop_template() && ! Prodigy_Elementor_Template_Loader::is_exclude_shop_template() );
	}

	/**
	 * Check is using elementor redactor
	 *
	 * @return bool
	 */
	public static function is_elementor_live_preview(): bool {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		return \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

	/**
	 * Check if using archive elementor templates
	 *
	 * @return bool
	 */
	public static function is_using_archive_elementor_templates(): bool {
		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Check if using some elementor templates
	 *
	 * @return bool
	 */
	public static function is_using_elementor_templates(): bool {
		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) && ! isset( $elementor_options['single'] ) ) {
			return false;
		}

		return true;
	}
}
