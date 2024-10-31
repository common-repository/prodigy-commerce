<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Documents;

use Elementor\Controls_Manager;
use ElementorPro\Modules\ThemeBuilder\Documents\Single_Base;
use ElementorPro\Plugin;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product extends Single_Base {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location']       = 'single';
		$properties['condition_type'] = Prodigy::PRODIGY_POST_TYPE_DEFAULT;

		return $properties;
	}

	public function get_name() {
		return 'product-prodigy';
	}

	public static function get_type() {
		return 'product-prodigy';
	}

	protected static function get_site_editor_type() {
		return 'product-prodigy';
	}

	public static function get_title() {
		return __( 'Prodigy Product' );
	}

	public static function get_plural_title() {
		return __( 'Prodigy Products' );
	}

	protected static function get_site_editor_icon() {
		return 'eicon-single-product';
	}

	protected static function get_site_editor_tooltip_data() {
		return array(
			'title'     => __( 'What is a Single Product Template?', 'elementor-pro' ),
			'content'   => __( 'A single product template allows you to easily design the layout and style of WooCommerce single product pages, and apply that template to various conditions that you assign.', 'elementor-pro' ),
			'tip'       => __( 'You can create multiple single product templates, and assign each to different types of products, enabling a custom design for each group of similar products.', 'elementor-pro' ),
			'docs'      => 'https://go.elementor.com/app-theme-builder-product',
			'video_url' => 'https://www.youtube.com/embed/PjhoB1RWkBM',
		);
	}

	public function get_depended_widget() {
		return Plugin::elementor()->widgets_manager->get_widget_types( 'woocommerce-product-data-tabs' );
	}

	public function get_container_attributes() {
		$attributes = parent::get_container_attributes();

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
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'single/product',
			)
		);

		$latest_posts = get_posts(
			array(
				'posts_per_page' => 1,
				'post_type'      => 'product',
			)
		);

		if ( ! empty( $latest_posts ) ) {
			$this->update_control(
				'preview_id',
				array(
					'default' => $latest_posts[0]->ID,
				)
			);
		}
	}

	protected function get_remote_library_config() {
		$config = parent::get_remote_library_config();

		$config['category'] = 'prodigy product';

		return $config;
	}

	/**
	 * Fix for thumbnail name that is different from editor type.
	 *
	 * @return string
	 */
	protected static function get_site_editor_thumbnail_url() {
		return ELEMENTOR_ASSETS_URL . 'images/app/site-editor/product.svg';
	}

	protected static function get_editor_panel_categories() {
		$categories = array(
			'prodigy-elements-single' => array(
				'title' => __( 'Prodigy Product' ),

			),
			// Move to top as active.
			'prodigy-elements'        => array(
				'title'  => __( 'Prodigy' ),
				'active' => true,
			),
		);

		$categories += parent::get_editor_panel_categories();

		unset( $categories['theme-elements-single'] );

		return $categories;
	}
}
