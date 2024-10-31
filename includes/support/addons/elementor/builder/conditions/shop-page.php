<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Shop_Page extends ThemeBuilder\Conditions\Condition_Base {

	public static function get_type() {
		return 'singular';
	}

	public function get_name() {
		return 'shop_page';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_label() {
		return __( 'Shop Page', 'elementor-pro' );
	}

	public function check( $args ) {
		return is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) );
	}
}
