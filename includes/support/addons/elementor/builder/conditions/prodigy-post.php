<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions as ThemeBuilderCondition;
use Prodigy\Includes\Prodigy as ProdigyPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ProdigyPost extends ThemeBuilderCondition\Post {

	public function register_sub_conditions() {
		$args       = array(
			'object_type' => array( \Prodigy\Includes\Prodigy::get_prodigy_product_type() ),
		);
		$taxonomies = get_taxonomies( $args );

		foreach ( $taxonomies as $key => $item ) {
			if ( in_array( $item, array( ProdigyPlugin::get_prodigy_category_type(), ProdigyPlugin::get_prodigy_tag_type() ) ) ) {
				$taxonomies[ $key ] = get_taxonomy( $item );
			}
		}

		$post_taxonomies = wp_filter_object_list(
			$taxonomies,
			array(
				'public'            => true,
				'show_in_nav_menus' => true,
			)
		);

		foreach ( $post_taxonomies as $slug => $object ) {

			$in_taxonomy = new ProdigyTaxonomy(
				array(
					'object' => $object,
				)
			);

			$this->register_sub_condition( $in_taxonomy );

			if ( $object->hierarchical ) {
				$in_sub_term = new ProdigySubTaxonomy(
					array(
						'object' => $object,
					)
				);

				$this->register_sub_condition( $in_sub_term );
			}
		}
	}

	public function get_all_label() {
		return 'All Prodigy Products';
	}
}
