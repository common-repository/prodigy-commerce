<?php

/**
 * Prodigy categories shortcode class
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Frontend\Mappers\Prodigy_Categories_Data_Mapper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Cart
 */

class Prodigy_Short_Code_Categories extends Prodigy_Main_Short_Code {

	const COUNT_ITEMS_ON_PAGE = 4;
	const SLIDER              = 'slider';
	const GRID                = 'grid';

	public $show_product_count_mapper = array(
		'true'  => true,
		'yes'   => true,
		'on'  => true,
		'off'   => false,
		true    => true,
		''      => false,
	);

	public $arrows_mapper = array(
		'on' => 'yes',
		'off' => 'no',
		'' => 'no',
		'yes' => 'yes',
	);

	public $total_count;

	public $categories_data_mapper;

	public $count_items_per_page;

	/**
	 * Prodigy_Short_Code_Category constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->categories_data_mapper = new Prodigy_Categories_Data_Mapper();
		$this->count_items_per_page = self::COUNT_ITEMS_ON_PAGE;
		add_shortcode( 'prodigy_categories', array( $this, 'output' ) );
	}

	/**
	 * @param array $attsFromWidget
	 *
	 * @return array
	 */
	public function set_widget_parameters( array $attsFromWidget ) :array {
		$defaultAtts = array(
			'category_ids'       => '',
			'category_slugs'     => '',
			'parent_ids'         => '',
			'limit'              => '',
			'columns'            => '3',
			'rows'               => '1',
			'orderby'            => 'name',
			'order'              => 'ASC',
			'show_product_count' => 'yes',
			'display'            => self::SLIDER,
			'slider_hide_arrows' => ''
		);

		$attrDiff = array_diff_key( $defaultAtts, (array) $attsFromWidget );

		foreach ( (array) $attsFromWidget as $key => $item ) {
			if ( empty( $item ) && key_exists( $key, $defaultAtts ) ) {
				$attsFromWidget[ $key ] = $defaultAtts[ $key ];
			}
		}

		$attsChecked = array_merge( $attsFromWidget, $attrDiff );
		$attr        = shortcode_atts( $attsChecked, $attsChecked, 'product_categories' );
		$attr['slider_hide_arrows'] = isset( $attr['slider_hide_arrows'] ) ? $this->arrows_mapper[ $attr['slider_hide_arrows'] ] : 'no';
		$attr['show_product_count'] = ! empty( $attr['show_product_count'] ) ? $this->show_product_count_mapper[ $attr['show_product_count'] ] : false;
		$attr['title_classname'] = 'prodigy-categories__card-title';

		return $attr;
	}

	/**
	 * @param $attr
	 * @param $name
	 * @param $content
	 *
	 * @return false|string
	 */
	function output( $attr, $name, $content = null ) {
		$attr = $this->set_widget_parameters( (array) $attr );
		$this->render_view( $attr );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * @param array $params
	 *
	 * @return void
	 */
	public function render_view( array $params ) {
		ob_start();
		do_action( 'prodigy_get_template_categories', $params );
		wp_reset_postdata();
	}

}
