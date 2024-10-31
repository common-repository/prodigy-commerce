<?php

use Prodigy\Includes\Frontend\Mappers\Prodigy_Products_Data_Mapper;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Divi_Prodigy_Products class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Products extends ET_Builder_Module {

	/** @var $product Prodigy_Product_Parser */
	public $product;

	/** @var $products_data_mapper Prodigy_Products_Data_Mapper */
	public $products_data_mapper;

	/** @var $mapper array */
	public $mapper = array(
		'true' => true,
		'yes'  => true,
		'on'   => true,
		'off'  => false,
		true   => true,
		''     => false,
	);

	/** @var array */
	public $display_mapper = array(
		'on'     => 'slider',
		'off'    => 'grid',
		'slider' => 'slider',
		'grid'   => 'grid',
	);

	/** @var array */
	public $arrows_mapper = array(
		'on'  => 'yes',
		'off' => 'no',
		''    => 'no',
		'yes' => 'yes',
	);

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->products_data_mapper = new Prodigy_Products_Data_Mapper();
		$this->slug                 = 'divi_prodigy_products';
		$this->vb_support           = 'on';
		$this->name                 = 'Prodigy Products';
		$this->main_css_element     = '%%order_class%%';
		$this->icon_path            = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Products.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'products_selection' => 'Products Selection',
					'content'            => 'Content',
				),
			),
			'advanced' => array(
				'toggles' => array(
					'general'                => et_builder_i18n( 'General' ),
					'box'                    => et_builder_i18n( 'Box' ),
					'slider_arrows'          => et_builder_i18n( 'Slider Arrows' ),
					'title'                  => esc_html__( 'Title', 'et_builder' ),
					'image'                  => esc_html__( 'Image', 'et_builder' ),
					'category'               => esc_html__( 'Category', 'et_builder' ),
					'rating'                 => esc_html__( 'Rating', 'et_builder' ),
					'price'                  => esc_html__( 'Price', 'et_builder' ),
					'sale_badge'             => esc_html__( 'Sale Badge', 'et_builder' ),
					'pagination'             => esc_html__( 'Pagination', 'et_builder' ),
					'pagination_item'        => esc_html__( 'Pagination icon', 'et_builder' ),
					'pagination_active_item' => esc_html__( 'Pagination active icon', 'et_builder' ),
				),
			),
		);
		$this->advanced_fields        = array(
			'form_field' => array(
				'box'           => array(
					'label'                  => esc_html__( 'Box', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-product-list__item-container",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item-container",
							'hover'     => "{$this->main_css_element} .prodigy-product-list__item-container:hover",
							'important' => 'all',
						),
					),
					'background_color'       => false,
				),
				'slider_arrows' => array(
					'label'                  => esc_html__( 'Slider Arrows', 'et_builder' ),
					'border_styles'          => array(
						'slider_arrows' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-related__products-nav.slick-arrow, #et-boc .et-l div .prodigy-related__products-nav.slick-arrow",
									'border_radii'  => "{$this->main_css_element} .prodigy-related__products-nav.slick-arrow, #et-boc .et-l div .prodigy-related__products-nav.slick-arrow",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'font_field'             => array(
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'category'      => array(
					'label'                  => esc_html__( 'Category', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => array(
						'css'              => array(
							'main'      => "{$this->main_css_element} #et-boc .et-l div p.prodigy-product-list__item-category, p.prodigy-product-list__item-category",
							'important' => 'all',
						),
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-category",
							'hover'     => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-category:hover",
							'important' => 'all',
						),
					),
					'border_styles'          => false,
				),
				'title'         => array(
					'label'                  => esc_html__( 'Title', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => array(
						'css'              => array(
							'main'                 => "{$this->main_css_element} h3.prodigy-product-list__item-title a",
							'hover'                => "{$this->main_css_element} h3.prodigy-product-list__item-title:hover a",
							'color'                => "{$this->main_css_element} h3.prodigy-product-list__item-title a",
							'color_hover'          => "{$this->main_css_element} h3.prodigy-product-list__item-title:hover a",
							'letter_spacing'       => "{$this->main_css_element} h3.prodigy-product-list__item-title a",
							'letter_spacing_hover' => "{$this->main_css_element} h3.prodigy-product-list__item-title:hover a",
							'important'            => 'all',
						),
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-title",
							'hover'     => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-title:hover",
							'important' => 'all',
						),
					),
					'border_styles'          => false,
				),
				'price'         => array(
					'label'                  => esc_html__( 'Price', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => array(
						'css'              => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-price",
							'important' => 'all',
						),
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-price",
							'hover'     => "{$this->main_css_element} .prodigy-product-list__item-container .prodigy-product-list__item-price:hover",
							'important' => 'all',
						),
					),
					'border_styles'          => false,
				),
				'sale_badge'    => array(
					'label'                  => esc_html__( 'Sale Badge', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => array(
						'css'              => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item .prodigy-product-list__item-label > span",
							'important' => 'all',
						),
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item > .prodigy-product-list__item-label",
							'hover'     => "{$this->main_css_element} .prodigy-product-list__item > .prodigy-product-list__item-label:hover",
							'important' => 'all',
						),
					),
					'border_styles'          => false,
				),
				'pagination'    => array(
					'label'                  => esc_html__( 'Pagination', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => array(
						'css'              => array(
							'main'      => "{$this->main_css_element} .prodigy-product-list__item .prodigy-product-list__item-label > span",
							'important' => 'all',
						),
						'hide_text_align'  => true,
						'hide_text_shadow' => true,
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-product-list__item-container",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'box_shadow'             => false,
					'border_styles'          => array(
						'css' => array(
							'main' => "{$this->main_css_element} .prodigy-category-link-wrapper",
						),
					),
				),
			),
		);
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		$general_fields = array(
			'on_sale'               => array(
				'label'            => 'On sale',
				'type'             => 'select',
				'options'          => array(
					'false' => 'All',
					'true'  => 'On Sale',
				),
				'default_on_front' => 'false',
				'toggle_slug'      => 'products_selection',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'category_ids'          => array(
				'label'            => 'By Category Names',
				'type'             => 'multi_select',
				'toggle_slug'      => 'products_selection',
				'option_category'  => 'basic_option',
				'default_on_front' => '',
				'options'          => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'name' ),
				'computed_affects' => array(
					'__posts',
				),
			),
			'product_names'         => array(
				'label'            => 'By Product Names',
				'type'             => 'multi_select',
				'toggle_slug'      => 'products_selection',
				'option_category'  => 'basic_option',
				'options'          => Prodigy_Product_Parser::get_products( 'names' ),
				'default_on_front' => '',
				'computed_affects' => array(
					'__posts',
				),
			),
			'tags'                  => array(
				'label'            => 'By Tag Names',
				'type'             => 'multi_select',
				'toggle_slug'      => 'products_selection',
				'option_category'  => 'basic_option',
				'default_on_front' => '',
				'options'          => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_tag_type(), Prodigy::PRODIGY_HOSTED_TAG_RELATION ),
				'computed_affects' => array(
					'__posts',
				),
			),
			'orderby'               => array(
				'label'            => 'Order By',
				'type'             => 'select',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'options'          => array(
					'id'         => 'ID',
					'name'       => 'Title',
					'price'      => 'Price',
					'created_at' => 'Date',
					'rating'     => 'Rating',
				),
				'description'      => 'Allows you specify the order in which the products will be displayed.  Acceptable values are: id, title, price, date, rating',
				'default_on_front' => 'id',
				'computed_affects' => array(
					'__posts',
				),
			),
			'order'                 => array(
				'label'            => 'Order',
				'type'             => 'select',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'options'          => array(
					'ASC'  => 'ASC',
					'DESC' => 'DESC',
				),
				'description'      => 'Determines if the sort order will be ascending or descending.  Acceptable values are: ASC, DESC',
				'default_on_front' => 'desc',
				'computed_affects' => array(
					'__posts',
				),
			),
			'columns'               => array(
				'label'            => 'Columns',
				'type'             => 'text',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'description'      => 'Determines the number of product columns per row that will be displayed.  The default value is 4 columns per row if not specified.',
				'default_on_front' => '3',
				'computed_affects' => array(
					'__posts',
				),
			),
			'number_items_per_page' => array(
				'label'            => 'Number items per page',
				'type'             => 'text',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'default_on_front' => '3',
				'show_if'          => array(
					'display' => 'grid',
				),
				'computed_affects' => array(
					'__posts',
				),
			),
			'limit'                 => array(
				'label'            => 'Limit',
				'type'             => 'text',
				'description'      => 'Limits the number of products returned.  For example, if the other attributes specified in the shortcode match 8 products and the limit attribute is set to 4, then only the first 4 matching products will be displayed.',
				'default_on_front' => - 1,
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'display'               => array(
				'label'            => 'Display',
				'type'             => 'select',
				'options'          => array(
					'slider' => 'Slider',
					'grid'   => 'Grid',
				),
				'default_on_front' => 'slider',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'category'              => array(
				'label'            => 'Category',
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => 'On',
					'off' => 'Off',
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'rating'                => array(
				'label'            => 'Rating',
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => 'On',
					'off' => 'Off',
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'sale'                  => array(
				'label'            => 'Sale',
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => 'On',
					'off' => 'Off',
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'content',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'__posts'               => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'Divi_Prodigy_Products',
					'get_view',
				),
				'computed_depends_on' => array(
					'product_ids',
					'category_ids',
					'product_names',
					'orderby',
					'order',
					'columns',
					'rows',
					'limit',
					'tags',
					'on_sale',
					'display',
					'category',
					'rating',
					'sale',
					'slider_hide_arrows',
					'number_items_per_page',
				),
			),
		);

		$tab                    = 'advanced';
		$custom_advanced_fields = array(
			'general_alignment'                       => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'align-items: flex-start !important;' => 'Left',
					'align-items: center !important;'     => 'Center',
					'align-items: flex-end !important;'   => 'Right',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'general',
				'default'     => 'align-items: flex-start !important;',
			),
			'column_margin'                           => array(
				'label'          => esc_html__( 'Column Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
			),
			'row_margin'                              => array(
				'label'          => esc_html__( 'Row Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'display' => 'grid',
				),
			),
			'bottom_margin'                           => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'display' => 'grid',
				),
			),
			'vertical_padding'                        => array(
				'label'          => esc_html__( 'Vertical Padding', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'display' => 'grid',
				),
			),
			'slider_bottom_margin'                    => array(
				'label'          => esc_html__( 'Slider Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'display' => 'slider',
				),
			),
			'slider_vertical_padding'                 => array(
				'label'          => esc_html__( 'Slider Vertical Padding', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'display' => 'slider',
				),
			),
			'box_background_color'                    => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'box',
			),
			'box_background_color_hover'              => array(
				'label'       => esc_html__( 'Background color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'box',
			),
			'slider_hide_arrows'                      => array(
				'label'            => esc_html__( 'Hide arrows', 'et_builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => 'Yes',
					'off' => 'No',
				),
				'toggle_slug'      => 'slider_arrows',
				'tab_slug'         => $tab,
				'description'      => 'Hide the arrow controls until the slider is hovered',
				'default'          => 'off',
				'computed_affects' => array(
					'__posts',
				),
			),
			'slider_arrow_width'                      => array(
				'label'       => esc_html__( 'Width', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_height'                     => array(
				'label'       => esc_html__( 'Height', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_font_size'                  => array(
				'label'       => esc_html__( 'Font Size', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '36',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_background_color'           => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_background_color_hover'     => array(
				'label'       => esc_html__( 'Background color on hover', 'et_builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_color'                      => array(
				'label'       => esc_html__( 'Arrow color', 'et_builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_color_hover'                => array(
				'label'       => esc_html__( 'Arrow color on hover', 'et_builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'image_aspect_ratio_width'                => array(
				'label'            => 'Aspect ratio width',
				'type'             => 'range',
				'tab_slug'         => $tab,
				'toggle_slug'      => 'image',
				'default'          => '3',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'computed_affects' => array(
					'__posts',
				),
			),
			'image_aspect_ratio_height'               => array(
				'label'            => 'Aspect ratio height',
				'type'             => 'range',
				'tab_slug'         => $tab,
				'toggle_slug'      => 'image',
				'default'          => '4',
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'computed_affects' => array(
					'__posts',
				),
			),
			'rating_star_color'                       => array(
				'label'       => 'Rating Star Color',
				'type'        => 'color-alpha',
				'tab_slug'    => $tab,
				'toggle_slug' => 'rating',
			),
			'rating_empty_star_color'                 => array(
				'label'       => 'Rating Empty Star Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'rating',
			),
			'rating_star_size'                        => array(
				'label'          => 'Star Size',
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'rating',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
			),
			'rating_spacing'                          => array(
				'label'          => 'Rating Spacing',
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'rating',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),
			'sale_badge_width'                        => array(
				'label'       => esc_html__( 'Width', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '45',
				'toggle_slug' => 'sale_badge',
			),
			'sale_badge_height'                       => array(
				'label'       => esc_html__( 'Height', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '45',
				'toggle_slug' => 'sale_badge',
			),
			'sale_badge_position_vertical'            => array(
				'label'       => esc_html__( 'Sale Badge Position Vertical', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'top: 10px !important;' => 'Top',
					'top: unset !important;bottom: 50% !important; transform: translateY(50%) !important;' => 'Center',
					'top: unset !important;bottom: 10px !important;'                                       => 'Bottom',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'sale_badge',
			),

			'sale_badge_position_horizontal'          => array(
				'label'       => esc_html__( 'Sale Badge Position Horizontal', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'right: auto !important;' => 'Left',
					'left: 50% !important; transform: translateX(-50%) !important;' => 'Center',
					'right: -6px !important; left: auto !important;'                => 'Right',
				),
				'tab_slug'    => $tab,
				'default'     => 'left: -6px !important; right: auto !important;',
				'toggle_slug' => 'sale_badge',
			),

			'sale_badge_position_vertical_distance'   => array(
				'label'          => esc_html__( 'Sale Badge Position Vertical Distance', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '',
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'toggle_slug'    => 'sale_badge',
			),

			'sale_badge_position_horizontal_distance' => array(
				'label'          => esc_html__( 'Sale Badge Position Horizontal Distance', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '',
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'toggle_slug'    => 'sale_badge',
			),

			'sale_badge_text_color'                   => array(
				'label'       => 'Sale Badge Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'sale_badge',
			),

			'sale_badge_background_color'             => array(
				'label'       => 'Sale Badge Background Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'sale_badge',
			),

			'category_text_color'                     => array(
				'label'       => 'Category Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'category',
			),

			'price_text_color'                        => array(
				'label'       => 'Price Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'price',
			),

			'pagination_alignment'                    => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'align-items: flex-start !important;' => 'Left',
					'align-items: center !important;'     => 'Center',
					'align-items: flex-end !important;'   => 'Right',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'general',
				'default'     => 'align-items: flex-start !important;',
			),

			'pagination_top_margin'                   => array(
				'label'          => esc_html__( 'Pagination Top Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '40',
				'toggle_slug'    => 'pagination',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'pagination_space_between'                => array(
				'label'          => 'Space Between',
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'pagination',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),
		);

		return array_merge( $general_fields, $custom_advanced_fields );
	}

	/**
	 * @param string $render_slug The module slug.
	 *
	 * @return void
	 */
	public function custom_adjustments( $render_slug ) {

		if ( '' !== $this->props['general_alignment'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-container',
					'declaration' => esc_html( $this->props['general_alignment'] ),
                )
            );
		}

		if ( '' !== $this->props['pagination_alignment'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-container',
					'declaration' => esc_html( $this->props['pagination_alignment'] ),
                )
            );
		}

		if ( '' !== $this->props['column_margin'] ) {
			$margin = $this->props['column_margin'] / 2;
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider .slick-slide',
					'declaration' => sprintf(
						'margin: 0 %1$spx !important;',
						esc_html( $margin )
					),
                )
            );

			$margin = $this->props['column_margin'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .feature-products__container .prodigy-product-list__grid',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $margin )
					),
                )
            );
		}

		if ( '' !== $this->props['row_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .feature-products__container .prodigy-product-list__grid',
					'declaration' => sprintf(
						'row-gap: %1$spx !important;',
						esc_html( $this->props['row_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-feature-products-slider.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_vertical_padding'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider-container .slick-track',
					'declaration' => sprintf(
						'padding: %1$spx 0 !important;',
						esc_html( $this->props['slider_vertical_padding'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-feature-products-slider.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['slider_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['vertical_padding'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-feature-products-slider.prodigy-custom-template',
					'declaration' => sprintf(
						'padding: %1$spx 0 !important;',
						esc_html( $this->props['vertical_padding'] )
					),
                )
            );
		}

		if ( '' !== $this->props['bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .feature-products__container.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['box_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-container',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['box_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['box_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-container:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['box_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow',
					'declaration' => sprintf(
						'width: %1$spx !important;',
						esc_html( $this->props['slider_arrow_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_height'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['slider_arrow_height'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_font_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['slider_arrow_font_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['slider_arrow_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['slider_arrow_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slider_arrow_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav.slick-arrow:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slider_arrow_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['image_aspect_ratio_height'] && '' !== $this->props['image_aspect_ratio_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__link-wrp',
					'declaration' => 'padding-top: calc(100% * ' . $this->props['image_aspect_ratio_height'] / $this->props['image_aspect_ratio_width'] . ') !important;',
                )
            );
		}

		if ( '' !== $this->props['rating_star_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating__item',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['rating_star_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['rating_empty_star_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['rating_empty_star_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['rating_star_size'] ) {
			$size = $this->props['rating_star_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating__item:before',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
			$size = $this->props['rating_star_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating__item',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
			$size = $this->props['rating_star_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating',
					'declaration' => sprintf(
						'width: calc(%1$spx * 5); height: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
			$size = $this->props['rating_star_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating .prodigy-star-rating:before',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
		}

		if ( '' !== $this->props['rating_spacing'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-rating',
					'declaration' => sprintf(
						'margin-bottom: %1$spx;',
						esc_html( $this->props['rating_spacing'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'width: %1$spx !important;',
						esc_html( $this->props['sale_badge_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_height'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['sale_badge_height'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_position_vertical'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%%  .prodigy-product-list__item-label',
					'declaration' => esc_html( $this->props['sale_badge_position_vertical'] ),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_position_horizontal'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%%  .prodigy-product-list__item-label',
					'declaration' => esc_html( $this->props['sale_badge_position_horizontal'] ),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_position_vertical_distance'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%%  .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'top: %1$spx !important;',
						esc_html( $this->props['sale_badge_position_vertical_distance'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_position_horizontal_distance'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%%  .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'left: %1$spx !important;right: auto !important;',
						esc_html( $this->props['sale_badge_position_horizontal_distance'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['sale_badge_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['sale_badge_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-label',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['sale_badge_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['category_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% p.prodigy-product-list__item-category',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['category_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['price_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item-price',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['price_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['pagination_top_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-feature-products-slider.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-top: %1$spx !important;',
						esc_html( $this->props['pagination_top_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['pagination_space_between'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-feature-products-slider.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-top: %1$spx !important;',
						esc_html( $this->props['pagination_space_between'] )
					),
                )
            );
		}
	}

	/**
	 * @param array $attr
	 *
	 * @return array
	 */
	public function set_widget_parameters( array $attr ): array {
		$attr['category']                        = ! empty( $attr['category'] ) ? $this->mapper[ $attr['category'] ] : false;
		$attr['rating']                          = ! empty( $attr['rating'] ) ? $this->mapper[ $attr['rating'] ] : false;
		$attr['sale']                            = ! empty( $attr['sale'] ) ? $this->mapper[ $attr['sale'] ] : false;
		$attr['display']                         = isset( $attr['display'] ) ? $this->display_mapper[ $attr['display'] ] : false;
		$attr['slider_hide_arrows']              = isset( $attr['slider_hide_arrows'] ) ? $this->arrows_mapper[ $attr['slider_hide_arrows'] ] : 'no';
		$attr['products_sale_classname']         = 'prodigy-product-list__item-label';

		return $attr;
	}

	/**
	 * @param array $args
	 * @param array $conditional_tags
	 * @param array $current_page
	 *
	 * @return string
	 */
	public static function get_view( $args = array(), $conditional_tags = array(), $current_page = array() ): string {
		$widget = new self();
		$args = $widget->set_widget_parameters( $args );

		return $widget->render_view( $args );
	}

	/**
	 * @param array  $attrs
	 * @param string $content
	 * @param string $render_slug
	 *
	 * @return string
	 */
	public function render( $attrs, $content, $render_slug ): string {
		$this->custom_adjustments( $render_slug );
		$parameters = $this->set_widget_parameters( $this->props );

		return $this->render_view( $parameters );
	}

	/**
	 * @param array $args
	 *
	 * @return string
	 */
	public function render_view( $args ): string {
		ob_start();
		do_action( 'prodigy_get_template_products', $args );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

new Divi_Prodigy_Products();
