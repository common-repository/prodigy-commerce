<?php
/**
 * Prodigy category shortcode class
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
 * Class Prodigy_Short_Code_Category_Link
 */
class Prodigy_Short_Code_Category_Link extends Prodigy_Main_Short_Code {

	/** @var object $category_mapper Prodigy_Categories_Data_Mapper  */
	public $category_mapper;

	public static $defaultAtts = array(
		'category_id'         => '',
		'category_slug'       => '',
		'show_count_products' => 'true',
		'opacity'             => 0.5,
		'category_image'      => '',
		/** center, top, bottom */
		'image_position'      => 'center',
		'height'              => '325px',
	);

	/**
	 * Prodigy_Short_Code_Products constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->category_mapper = new Prodigy_Categories_Data_Mapper();
		add_shortcode( 'prodigy_category_link', array( $this, 'output' ) );
	}


	/**
	 * @param array $attrFromWidget
	 *
	 * @return array
	 */
	public function set_parameters( array $attrFromWidget) :array {
		$attrDiff = array_diff_key( self::$defaultAtts, (array) $attrFromWidget );

		foreach ( (array) $attrFromWidget as $key => $item ) {
			if ( empty( $item ) && key_exists( $key, self::$defaultAtts ) ) {
				$attrFromWidget[ $key ] = self::$defaultAtts[ $key ];
			}
		}

		$attr = array_merge( $attrFromWidget, $attrDiff );

		$attr['link_classname'] = 'prodigy-category-link';

		if ( isset( $remote_id ) ) {
			$category_response = $this->category_mapper->get_category( (int) $remote_id );
		}

		if ( isset( $category_response, $category_response['data'] ) ) {
			$category       = $this->category_mapper->format_data( $category_response['data'] );
			$attr['category_image'] = $category['img_url'];
		} else {
			$category = array();
		}

		return $attr;
	}

	/**
	 * @param string $attr
	 * @param null   $content
	 * @param string $name
	 *
	 * @return string
	 */
	function output( $attr, $name, $content = null ) :string {
		$params = $this->set_parameters( (array) $attr );

		return $this->render_view($params);
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function render_view( array $params) :string {
		ob_start();
		do_action( 'prodigy_get_template_category_link', $params );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}
