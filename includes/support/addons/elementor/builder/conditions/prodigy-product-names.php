<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use Prodigy\Includes\Content\Prodigy_Product_Parser;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Prodigy_Product_Names extends ThemeBuilder\Conditions\Condition_Base {


	/** @var object Prodigy_Product_Parser */
	private $product;

	public function __construct( array $data = array() ) {
		$this->product = new Prodigy_Product_Parser();
		parent::__construct( $data );
	}

	protected function register_controls() {
		$this->add_control(
			'prodigy_product_names',
			array(
				'section'  => 'settings',
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => $this->product::get_products( Prodigy_Product_Parser::PRODUCTS_NAMES ),
			)
		);
	}

	public function get_name() {
		return 'prodigy_product_names';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_label() {
		return __( 'In Product Names', 'elementor-pro' );
	}

	/**
	 * @param array $args
	 * @return bool
	 */
	public function check( $args ) {
		$is_product = false;
		if ( isset( $args['id'] ) && is_single() ) {
			global $post;
			$title   = get_post( $post )->post_title;
			$product = prodigy_get_post_by_title( $args['id'], \Prodigy\Includes\Prodigy::get_prodigy_product_type() );
			if ( ! empty( $product ) ) {
				$is_product = $title == $product->post_title;
			}
		}

		return $is_product;
	}
}
