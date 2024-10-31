<?php

/**
 * Prodigy products shortcode class
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Products_Short_Code
 */
class Prodigy_Short_Code_Products extends Prodigy_Main_Short_Code {

	public $mapper = array(
		'true' => true,
		'yes'  => true,
		'on'   => true,
		'off'  => false,
		true   => true,
		''     => false,
	);

	public $display_mapper = array(
		'on'     => 'slider',
		'off'    => 'grid',
		'slider' => 'slider',
		'grid'   => 'grid',
	);

	public $arrows_mapper = array(
		'on'  => 'yes',
		'off' => 'no',
		''    => 'no',
		'yes' => 'yes',
	);

	/**
	 * Prodigy_Short_Code_Products constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_shortcode( 'prodigy_products', array( $this, 'output' ) );
	}

	/**
	 * @param $attr
	 * @param null $content
	 *
	 * @return string
	 */
	function output( $attr, $content = null ) {
		$attr = $this->set_parameters( (array) $attr );
		ob_start();
		$this->render_view( $attr );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * @param array $attsFromWidget
	 *
	 * @return array
	 */
	public function set_parameters( array $attsFromWidget ): array {

		$defaultAtts = array(
			'product_ids'           => '',
			'category_ids'          => '',
			'product_names'         => '',
			'columns'               => '4',
			'limit'                 => - 1,
			'tags'                  => '',
			'orderby'               => 'id',
			'on_sale'               => false,
			'sale'                  => 'yes',
			'category'              => 'yes',
			'rating'                => 'yes',
			'order'                 => 'ASC',
			'number_items_per_page' => '9',
			'display'               => 'slider',
			'slider_hide_arrows'    => '',
			'image_ratio'           => '',
		);

		$attrDiff = array_diff_key( $defaultAtts, $attsFromWidget );

		foreach ( (array) $attsFromWidget as $key => $item ) {
			if ( empty( $item ) && key_exists( $key, $defaultAtts ) ) {
				$attsFromWidget[ $key ] = $defaultAtts[ $key ];
			}
		}
		$attsChecked                     = array_merge( $attsFromWidget, $attrDiff );

		$attr                            = shortcode_atts( $attsChecked, $attsChecked, 'products' );
		$attr['category']                = ! empty( $attr['category'] ) ? $this->mapper[ $attr['category'] ] : false;
		$attr['rating']                  = ! empty( $attr['rating'] ) ? $this->mapper[ $attr['rating'] ] : false;
		$attr['sale']                    = ! empty( $attr['sale'] ) ? $this->mapper[ $attr['sale'] ] : false;
		$attr['display']                 = isset( $attr['display'] ) ? $this->display_mapper[ $attr['display'] ] : false;
		$attr['slider_hide_arrows']      = isset( $attr['slider_hide_arrows'] ) ? $this->arrows_mapper[ $attr['slider_hide_arrows'] ] : 'no';
		$attr['products_sale_classname'] = 'prodigy-product-list__item-label';

		return $attr;
	}

	/**
	 * @param array $params
	 *
	 * @return void
	 */
	public function render_view( array $params ): void {
		do_action( 'prodigy_get_template_products', $params );
	}
}
