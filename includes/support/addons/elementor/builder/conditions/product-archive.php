<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Prodigy as ProdigyPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Archive extends ThemeBuilder\Conditions\Condition_Base {

	private $post_type;
	private $post_taxonomies;

	public function __construct( array $data = array() ) {
		$this->post_type       = ProdigyPlugin::PRODIGY_POST_TYPE_DEFAULT;
		$taxonomies            = get_object_taxonomies( $this->post_type, 'objects' );
		$this->post_taxonomies = wp_filter_object_list(
			$taxonomies,
			array(
				'public'            => true,
				'show_in_nav_menus' => true,
			)
		);

		parent::__construct( $data );
	}

	public static function get_type() {
		return 'archive';
	}

	public function get_name() {
		return 'product_archive';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_label() {
		return __( 'Product Archive', 'elementor-pro' );
	}

	public function get_all_label() {
		return __( 'All Product Archives', 'elementor-pro' );
	}

	public function register_sub_conditions() {
		$this->register_sub_condition( new Shop_page() );

		foreach ( $this->post_taxonomies as $slug => $object ) {
			if ( in_array( $object->name, array( ProdigyPlugin::get_prodigy_category_type(), ProdigyPlugin::get_prodigy_tag_type() ) ) ) {
				$condition = new ThemeBuilder\Conditions\Taxonomy(
					array(
						'object' => $object,
					)
				);
				$this->register_sub_condition( $condition );
			}
		}
	}

	public function check( $args ): bool {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		return Prodigy_Shop_Page::is_archive_page_url( $uri );
	}
}
