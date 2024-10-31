<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Prodigy extends ThemeBuilder\Conditions\Condition_Base {

	public static function get_type() {
		return 'prodigy';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_name() {
		return 'prodigy_product';
	}

	public function get_label() {
		return 'Prodigy Products';
	}

	public function register_sub_conditions() {
        $product_archive = new Product_Archive();
		$product_single  = new ProdigyPost(
			array(
				'post_type' => \Prodigy\Includes\Prodigy::get_prodigy_product_type(),
			)
		);

		$this->register_sub_condition( $product_archive );
		$this->register_sub_condition( $product_single );
	}

	public function check( $args = null ) {
		if ( is_singular( \Prodigy\Includes\Prodigy::get_prodigy_product_type() ) ) {
			return is_user_logged_in();
		}

		return false;
	}
}
