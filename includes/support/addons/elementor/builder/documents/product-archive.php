<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Documents;

use ElementorPro\Modules\ThemeBuilder\Documents\Archive;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Archive extends Archive {

	public function get_name() {
		return 'product-archive-prodigy';
	}

	public static function get_type() {
		return 'product-archive-prodigy';
	}

	public static function get_class_full_name() {
		return get_called_class();
	}

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location']       = 'archive';
		$properties['condition_type'] = 'product_archive';

		return $properties;
	}

	protected static function get_site_editor_type() {
		return 'product-archive-prodigy';
	}

	public static function get_title() {
		return __( 'Prodigy Archive' );
	}

	public static function get_plural_title() {
		return __( 'Prodigy Archives' );
	}

	protected static function get_site_editor_icon() {
		return 'eicon-products';
	}

	/**
	 * Fix for thumbnail name that is different from editor type.
	 *
	 * @return string
	 */
	protected static function get_site_editor_thumbnail_url() {
		return ELEMENTOR_ASSETS_URL . 'images/app/site-editor/products.svg';
	}

	protected static function get_site_editor_tooltip_data() {
		return array(
			'title'     => __( 'What is a Products Archive Template?', 'elementor-pro' ),
			'content'   => __( 'A products archive template allows you to easily design the layout and style of your shop page or other product archive pages - those pages that show a list of products, which may be filtered by terms such as categories, tags, etc.', 'elementor-pro' ),
			'tip'       => __( 'You can create multiple products archive templates, and assign each to different categories of products. This gives you the freedom to customize the appearance for each type of product being shown.', 'elementor-pro' ),
			'docs'      => 'https://go.elementor.com/app-theme-builder-products-archive',
			'video_url' => 'https://www.youtube.com/embed/cQLeirgkguA',
		);
	}

	public function get_container_attributes() {
		$attributes           = parent::get_container_attributes();
		$attributes['class'] .= ' product';

		return $attributes;
	}


	public function __construct( array $data = array() ) {
		parent::__construct( $data );
	}

	protected function register_controls() {
		parent::register_controls();

		$this->update_control(
			'preview_type',
			array(
				'default' => 'post_type_archive/product',
			)
		);
	}

	protected function get_remote_library_config() {
		$config             = parent::get_remote_library_config();
		$config['category'] = 'prodigy archive';

		return $config;
	}



	protected static function get_editor_panel_categories() {
		$categories = array(
			'prodigy-elements-archive' => array(
				'title' => __( 'Prodigy Archive' ),
			),
			// Move to top as active.
			'prodigy-elements'         => array(
				'title'  => __( 'Prodigy' ),
				'active' => true,
			),
		);

		$categories += parent::get_editor_panel_categories();

		unset( $categories['theme-elements-archive'] );

		return $categories;
	}

}
