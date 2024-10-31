<?php

/**
 * Prodigy filters shortcode class
 *
 * @version    2.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Content\Prodigy_Catalog_Filters_Parser;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Left_Categories_Filters
 */
class Prodigy_Short_Code_Categories_Filter extends Prodigy_Main_Short_Code {

	private $cat_current_id;
	private $request_attrs;
	private $show_level_depth = 0;

	const LEVEL = 1;

	/**
	 * Prodigy_Short_Code_Left_Categories_Filters constructor.
	 */
	public function __construct() {
		add_shortcode( 'prodigy_categories_filter', array( $this, 'output' ) );
	}

	/**
	 * @param array $categories
	 * @return mixed
	 */
	public function sortByPosition( $categories ) {
		usort(
			$categories,
			function( $a, $b ) {
				return $a['position'] - $b['position'];
			}
		);
		return $categories;
	}

	/**
	 * @param       $categories
	 * @param       $parent_id_category
	 * @param false              $sub_menu_button
	 * @param false              $sub_level
	 *
	 * @return string
	 */
	protected function get_list_sub_categories( $categories, $parent_id_category, $sub_menu_button = false, $sub_level = false ) {

		$this->show_level_depth ++;

		$collapse      = '';
		$id_collapse   = '';
		$class_show    = '';
		$line_menu     = '';
		$aria_expanded = 'false';

		if ( $sub_menu_button ) {
			if ( $parent_id_category != $this->cat_current_id ) {
				$class_show    = 'show';
				$aria_expanded = 'true';
			}

			$collapse    = 'collapse ' . $class_show;
			$id_collapse = 'id="collapse_' . $parent_id_category . '_1"';
		}

		$sub_categories = $this->get_subcategory( $categories, $parent_id_category );
		$sub_categories = $this->sortByPosition( $sub_categories );

		if ( empty( $sub_categories ) ) {
			return $line_menu;
		}

		if ( ! empty( $sub_level ) && ! empty( $this->request_attrs['max_depth'] ) && $this->request_attrs['max_depth'] < $this->show_level_depth ) {
			return $line_menu;
		}

		if ( $sub_menu_button ) {
			$line_menu .= '
            <button class="prodigy-filter__card-btn prodigy-icon-btn" 
            data-toggle="collapse"
             data-target="#collapse_' . $parent_id_category . '_' . $sub_level . '"
              aria-expanded="' . $aria_expanded . '"
               aria-controls="collapse_' . $parent_id_category . '_' . $sub_level . '">
               <i class="icon-arrow-down"></i>
               </button>';
		}

		$line_menu .= '<ul class="prodigy-filter__card-list ' . $collapse . '" ' . $id_collapse . '>';

		foreach ( $sub_categories as $value ) {
			$sub_sub_categories = $this->get_subcategory( $categories, $value['id'] );

			$line_sub_menu = '';
			if ( ! empty( $sub_sub_categories ) ) {
				/*
				 * Recursively create a sub category
				 */
				$line_sub_menu = $this->get_list_sub_categories( $categories, $value['id'], true, self::LEVEL );
			}

			$category_term = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $value['id'] );
			$url = get_category_link( $category_term->term_id ?? '' );

			$line_menu .= '<li class="prodigy-filter__card-list-item"  id="sub_cat_' . esc_attr( $value['id'] ) . '">';
			$line_menu .= '<a class="filter-category-id-js" href="' . $url . '" data-category="' . $value['id'] . '">';
			$line_menu .= esc_attr( $value['name'] );
			$line_menu .= '</a>';

			if ( isset( $this->request_attrs['show_product_count'] ) ) {
				if ( $this->bool_mapper[ $this->request_attrs['show_product_count'] ] ) {
					$line_menu .= ' <span class="filter__card-count">(' . esc_attr( $value['count'] ) . ')</span>';
				}
			}

			if ( ! empty( $line_sub_menu ) ) {
				$line_menu .= $line_sub_menu;
			}
			$line_menu .= '</li>';
		}

		$line_menu .= '</ul>';

		return $line_menu;
	}




	/**
	 * @param array  $categories
	 * @param int    $category_id
	 * @param string $type
	 *
	 * @return array
	 */
	public function get_subcategory( $categories, $category_id, $type = 'children' ) {
		$subcategory = array();
		foreach ( $categories as $category ) {
			if ( ( $category['id'] == $category_id ) && ! empty( $category['relationships'][ $type ]['data'] ) ) {
				$subcategories = $category['relationships'][$type]['data'];
				foreach ( $subcategories as $key => $sub_category ) {
					// TODO need to clerify about  $subcategories array structure
					if ( $type === 'children' ) {
						foreach ( $categories as $ch_category ) {
							if ( $ch_category['id'] == $sub_category['id'] ) {
								$subcategory[ $key ]['id']       = $ch_category['id'];
								$attributes                      = (array) $ch_category['attributes'];
								$subcategory[ $key ]['name']     = $attributes['name'];
								$subcategory[ $key ]['count']    = $attributes['products-count'];
								$subcategory[ $key ]['position'] = $attributes['position'];
							}
						}
					} else {
						return (int) $subcategories['id'];
					}
				}
			}
		}

		return $subcategory;
	}

	/**
	 * @param $categories
	 *
	 * @return array
	 */
	public function get_subcategories_by_parent_categories( $categories ) {
		$list_sub_categories = array();
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$list_sub_categories[ $category['id'] ] = $this->get_list_sub_categories( $categories, $category['id'] );
			}
		}

		return $list_sub_categories;
	}

	/**
	 * @param $categories
	 * @param false      $subcategory
	 *
	 * @return mixed
	 */
	public function apply_widget_settings( $categories, $subcategory = false ) {
		if ( $this->bool_mapper[ $this->request_attrs['hide_empty'] ] ) {

			if ( ! $subcategory && ! empty( $categories ) ) {
				foreach ( $categories as $key => $category ) {
					if ( empty( $category['count'] ) ) {
						unset( $categories[ $key ] );
					}
				}
			} else {
				if ( ! empty( $categories ) ) {
					foreach ( $categories as $key => $category ) {
						$category = (array) $category['attributes'];
						if ( empty( $category['products-count'] ) ) {
							unset( $categories[ $key ] );
						}
					}
				}
			}
		}

		if ( ! $subcategory ) {
			if ( $this->request_attrs['sorting'] === 'ID' && ! empty( $categories ) ) {
				usort(
					$categories,
					function ( $a, $b ) {
						if ( $a['id'] == $b['id'] ) {
							return 0;
						}
						return ( $a['id'] < $b['id'] ) ? -1 : 1;
					}
				);
			} else {
				usort(
					$categories,
					function ( $a, $b ) {
						return strcmp( $a['name'], $b['name'] );
					}
				);
			}
		}

		return $categories;
	}


	/**
	 * @param object $categories
	 *
	 * @return array
	 */
	public function get_parent_categories( $categories ) {
		$parent_categories = array();
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $key => $category ) {
				if ( empty( $category['relationships']['parent']['data'] ) ) {
					$parent_categories[ $key ]['id']       = $category['id'];
					$attributes                            = (array) $category['attributes'];
					$parent_categories[ $key ]['name']     = $attributes['name'];
					$parent_categories[ $key ]['count']    = $attributes['products-count'];
					$parent_categories[ $key ]['position'] = $attributes['position'];
				}
			}
		}

		return $parent_categories;
	}

	/**
	 * @param object $categories
	 *
	 * @return array
	 */
	public function merge_categories( $categories ) {
		$new_categories = array();
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $key => $category ) {
				$new_categories[ $key ]['id']       = $category['id'];
				$attributes                         = (array) $category['attributes'];
				$new_categories[ $key ]['name']     = $attributes['name'];
				$new_categories[ $key ]['count']    = $attributes['products-count'];
				$new_categories[ $key ]['position'] = $attributes['position'];
			}
		}

		return $new_categories;
	}

	/**
	 * @param object $categories
	 * @param int    $child_category
	 *
	 * @return int
	 */
	public function get_root_category( $categories, $child_category ) {
		$root_id = 0;
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				if ( $category['id'] == $child_category ) {
					$attributes = (array) $category['attributes'];
					$root_id    = $attributes['root-id'];
				}
			}
		}

		return (int) $root_id;
	}

	/**
	 * @param $atts
	 * @param $data
	 * @param $content
	 *
	 * @return false|string
	 */
	public function output( $atts, $data, $content = null ) {

		if ( ! empty( $atts ) ) {
			update_option( 'prodigy_categories_shortcode_settings', serialize( $atts ) );
		}

		$attsFromWidget = unserialize( get_option( 'prodigy_categories_shortcode_settings' ) );

		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'categories-filter' ) ) {
			$query = build_query( $_GET ?? [] );
		}
		$categories_response = Prodigy_Request_Maker::get_instance()->do_catalog_filters_request( $query );
		$uri = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' );
		if ( isset( $uri['path'] ) ) {
			$path = explode( '/', $uri['path'] );
			if ( isset( $path[2] ) ) {
				$term            = get_term_by( 'slug', $path[2], Prodigy::get_prodigy_category_type() );
				$active_category = $term->name ?? '';
			}
		}

		$categories = Prodigy_Catalog_Filters_Parser::get_categories( $categories_response );

		$data = array();
		if ( ! empty( $categories ) ) {
			$data = array(
				'categories'      => $categories,
				'active_category' => $active_category ?? '',
			);
		}

		$defaultAtts = array(
			'show_product_count' => '',
			'show_hierarchy'     => 'true',
			'hide_empty'         => 'true',
			'max_depth'          => '10',
			'sorting'            => 'ID',
		);

		if ( ! isset( $atts['idwidget'] ) ) {
			$defaultAtts['show_product_count'] = true;
		}

		$attrDiff = array_diff_key( $defaultAtts, (array) $attsFromWidget );

		foreach ( (array) $attsFromWidget as $key => $item ) {
			if ( empty( $item ) && key_exists( $key, $defaultAtts ) ) {
				$attsFromWidget[ $key ] = $defaultAtts[ $key ];
			}
		}

		$attsChecked = array_merge( $attsFromWidget, $attrDiff );

		$atts = shortcode_atts( $attsChecked, $attsChecked, 'prodigy_categories_filter' );

		wp_enqueue_script( 'categories-filter', plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/categories-filter.js' ) . 'categories-filter.js', array( 'jquery' ), PRODIGY_VERSION );
		ob_start();

		if ( ! empty( $atts ) && is_array( $data ) ) {
			$this->request_attrs = $atts;

			if ( isset( $data['active_category'], $data['categories'] ) ) {
				$local_category       = get_term_by( 'slug', $data['active_category'], Prodigy::get_prodigy_category_type() );
				$this->cat_current_id = false;

				if ( isset( $local_category->term_id ) ) {
					$this->cat_current_id = (int) get_term_meta( (int) $local_category->term_id, 'prodigy_hosted_category_relation', true );
				}

				$categories = $this->get_parent_categories( $data['categories'] );
				if ( $this->bool_mapper[ $this->request_attrs['show_hierarchy'] ] ) {
					$categories    = $this->apply_widget_settings( $categories );
					$subcategories = $this->get_subcategories_by_parent_categories( $this->apply_widget_settings( $data['categories'], true ) );
					$params        = array(
						'categories'      => $categories ?? null,
						'subcategories'   => $subcategories ?? null,
						'request_count'   => $this->bool_mapper[ $atts['show_product_count'] ] ?? 'false',
						'active_category' => $data['active_category'] ?? '',
						'active_id'       => $this->cat_current_id ?? null,
						'parent_id'       => $this->get_root_category( $data['categories'], (int) $this->cat_current_id ),
						'attr_shortcode'  => $atts,
					);
				} else {
					$categories = $this->merge_categories( $data['categories'] );
					$categories = $this->apply_widget_settings( $categories );
					$params     = array(
						'cat_parent_id'   => false,
						'categories'      => $categories ?? null,
						'request_count'   => $this->bool_mapper[ $atts['show_product_count'] ] ?? 'false',
						'active_category' => $data['active_category'] ?? null,
						'attr_shortcode'  => $atts,
					);
				}
			}
		} else {
			$params = array(
				'cat_parent_id'  => false,
				'categories'     => array(),
				'subcategories'  => array(),
				'request_count'  => $this->bool_mapper[ $atts['show_product_count'] ] ?? 'false',
				'attr_shortcode' => array(),
			);
		}

		if ( isset( $params ) ) {
			do_action( 'prodigy_shortcode_template_categories_filter', $params );
		}

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
