<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use Prodigy\Includes\Content\Prodigy_Product_Parser;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Prodigy_Product_Ids extends ThemeBuilder\Conditions\Condition_Base {

	/** @var object Prodigy_Product_Parser */
	private $product;

	public function __construct( array $data = array() ) {
		$this->product = new Prodigy_Product_Parser();
		parent::__construct( $data );
	}

	protected function register_controls() {
		$this->add_control(
			'prodigy_product_ids',
			array(
				'section'  => 'settings',
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options'  => $this->product::get_products( Prodigy_Product_Parser::PRODUCTS_IDS ),
			)
		);
	}

	public function get_name() {
		return 'prodigy_product_ids';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_label() {
		return __( 'In Product IDs', 'elementor-pro' );
	}

	/**
	 * @param array $args
	 * @return bool
	 */
	public function check( $args ) {
		$is_product = false;
		if ( isset( $args['id'] ) && is_single() ) {
			$local_product = Prodigy_Product_Parser::get_product_meta_by_remote_id( 'prodigy_remote_product_id', $args['id'] );
		}
		if ( ! empty( $local_product ) ) {
			$is_product = url_to_postid( get_permalink() ) == $local_product->post_id;
		}

		return $is_product;
	}
}
