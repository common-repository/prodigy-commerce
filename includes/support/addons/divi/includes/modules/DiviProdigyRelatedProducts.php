<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Divi_Prodigy_Related_Products class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Related_Products extends ET_Builder_Module {

	/** @var $mapper array */
    public $mapper = array(
        'true' => true,
        'yes'  => true,
        'on'   => true,
        'off'  => false,
        true   => true,
        ''     => false,
    );

	/** @var $display_mapper array */
    public $display_mapper = array(
        'on'     => 'slider',
        'off'    => 'grid',
        'slider' => 'slider',
        'grid'   => 'grid',
    );

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
    public function init() {
		$this->slug             = 'divi_prodigy_related_products';
		$this->vb_support       = 'on';
		$this->name             = 'Prodigy Related Products';
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Related_Products.svg';

        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'products_selection' => 'Products Selection',
                    'content'            => 'Content',
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'general'       => esc_html__( 'General', 'et_builder' ),
                    'heading'       => esc_html__( 'Heading', 'et_builder' ),
                    'box'           => esc_html__( 'Box', 'et_builder' ),
                    'slider'        => esc_html__( 'Slider', 'et_builder' ),
                    'image'         => esc_html__( 'Image', 'et_builder' ),
                    'category'      => esc_html__( 'Category', 'et_builder' ),
                    'title'         => esc_html__( 'Title', 'et_builder' ),
                    'price'         => esc_html__( 'Price', 'et_builder' ),
                    'rating'        => esc_html__( 'Rating', 'et_builder' ),
                    'sale_badge'    => esc_html__( 'Sale Badge', 'et_builder' ),
                    'slider_arrows' => esc_html__( 'Slider Arrows', 'et_builder' ),
                ),
            ),
        );

        $this->advanced_fields = array(
            'form_field' => array(
                'heading'       => array(
                    'label'                  => esc_html__( 'Heading', 'et_builder' ),
                    'border_styles'          => array(
                        'heading' => array(
                            'css'               => array(
                                'main' => array(
                                    'border_styles' => "{$this->main_css_element} h3.prodigy-related__products-title, #et-boc .et-l div > h3.prodigy-related__products-title, .et-l div > h3.prodigy-related__products-title",
                                    'border_radii'  => "{$this->main_css_element} h3.prodigy-related__products-title, #et-boc .et-l div > h3.prodigy-related__products-title, .et-l div > h3.prodigy-related__products-title",
                                    'important'     => 'all',
                                ),
                            ),
                            'use_focus_borders' => false,
                        ),
                    ),
                    'margin_padding'         => array(
                        'css'        => array(
                            'padding'   => "{$this->main_css_element} h3.prodigy-related__products-title",
                            'important' => 'all',
                        ),
                        'use_margin' => false,
                    ),
                    'text_color'             => false,
                    'background_color'       => false,
                    'use_margin'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'font_field'             => array(
						'css'              => array(
							'main'                 => "$this->main_css_element h3.prodigy-related__products-title, #et-boc .et-l div h3.prodigy-related__products-title",
							'hover'                => "$this->main_css_element h3.prodigy-related__products-title:hover, #et-boc .et-l div h3.prodigy-related__products-title:hover",
							'color'                => "$this->main_css_element h3.prodigy-related__products-title, #et-boc .et-l div h3.prodigy-related__products-title",
							'color_hover'          => "$this->main_css_element h3.prodigy-related__products-title:hover, #et-boc .et-l div h3.prodigy-related__products-title:hover",
							'letter_spacing'       => "$this->main_css_element h3.prodigy-related__products-title, #et-boc .et-l div h3.prodigy-related__products-title",
							'letter_spacing_hover' => "$this->main_css_element h3.prodigy-related__products-title:hover, #et-boc .et-l div h3.prodigy-related__products-title:hover",
							'important'            => 'all',
						),
                        'hide_text_align'  => false,
                        'hide_text_shadow' => false,
					),
                    'box_shadow'             => array(
                        'css' => array(
                            'main'      => "{$this->main_css_element} h3.prodigy-related__products-title",
                            'hover'     => "{$this->main_css_element} h3.prodigy-related__products-title:hover",
                            'important' => 'all',
                        ),
                    ),
                ),
                'box'           => array(
                    'label'                  => esc_html__( 'Box', 'et_builder' ),
                    'border_styles'          => array(
                        'box' => array(
                            'css'               => array(
                                'main' => array(
                                    'border_styles' => "{$this->main_css_element} .prodigy-product-list__item > div.prodigy-product-list__item-container,#et-boc .et-l div > div.prodigy-product-list__item-container",
                                    'border_radii'  => "{$this->main_css_element} .prodigy-product-list__item > div.prodigy-product-list__item-container,#et-boc .et-l div > div.prodigy-product-list__item-container",
                                    'important'     => 'all',
                                ),
                            ),
                            'use_focus_borders' => false,
                        ),
                    ),
                    'margin_padding'         => array(
                        'css'        => array(
                            'padding'   => "{$this->main_css_element} .prodigy-product-list__item > div.prodigy-product-list__item-container",
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
                            'main'      => "{$this->main_css_element} .prodigy-product-list__item > div.prodigy-product-list__item-container",
                            'hover'     => "{$this->main_css_element} .prodigy-product-list__item > div.prodigy-product-list__item-container:hover",
                            'important' => 'all',
                        ),
                    ),
                    'background_color'       => false,
                ),
                'image'         => array(
                    'label'                  => esc_html__( 'Image', 'et_builder' ),
                    'border_styles'          => array(
                        'image' => array(
                            'css'               => array(
                                'main' => array(
                                    'border_styles' => "{$this->main_css_element} .prodigy-product-list__item-container > div.prodigy-product-list__link-wrp, #et-boc .et-l div > div.prodigy-product-list__link-wrp",
                                    'border_radii'  => "{$this->main_css_element} .prodigy-product-list__item-container > div.prodigy-product-list__link-wrp, #et-boc .et-l div > div.prodigy-product-list__link-wrp",
                                    'important'     => 'all',
                                ),
                            ),
                            'use_focus_borders' => false,
                        ),
                    ),
                    'margin_padding'         => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'font_field'             => false,
                    'box_shadow'             => false,
                    'background_color'       => false,
                ),
                'category'      => array(
                    'label'                  => esc_html__( 'Category', 'et_builder' ),
                    'border_styles'          => false,
                    'margin_padding'         => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'font_field'             => array(
                        'css'              => array(
                            'main'                 => "$this->main_css_element p.prodigy-product-list__item-category, #et-boc .et-l div p.prodigy-product-list__item-category",
                            'hover'                => "$this->main_css_element p.prodigy-product-list__item-category:hover, #et-boc .et-l div p.prodigy-product-list__item-category:hover",
                            'color'                => "$this->main_css_element p.prodigy-product-list__item-category, #et-boc .et-l div p.prodigy-product-list__item-category",
                            'color_hover'          => "$this->main_css_element p.prodigy-product-list__item-category:hover, #et-boc .et-l div p.prodigy-product-list__item-category:hover",
                            'letter_spacing'       => "$this->main_css_element p.prodigy-product-list__item-category, #et-boc .et-l div p.prodigy-product-list__item-category",
                            'letter_spacing_hover' => "$this->main_css_element p.prodigy-product-list__item-category:hover, #et-boc .et-l div p.prodigy-product-list__item-category:hover",
                            'important'            => 'all',
                        ),
                        'hide_text_align'  => true,
                        'hide_text_shadow' => false,
                    ),
                    'box_shadow'             => false,
                    'background_color'       => false,
                ),
                'title'         => array(
                    'label'                  => esc_html__( 'Title', 'et_builder' ),
                    'border_styles'          => false,
                    'margin_padding'         => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'font_field'             => array(
                        'css'              => array(
                            'main'                 => "$this->main_css_element h3.prodigy-product-list__item-title > a, #et-boc .et-l div h3.prodigy-product-list__item-title > a",
                            'hover'                => "$this->main_css_element h3.prodigy-product-list__item-title > a:hover, #et-boc .et-l div h3.prodigy-product-list__item-title > a:hover",
                            'color'                => "$this->main_css_element h3.prodigy-product-list__item-title > a, #et-boc .et-l div h3.prodigy-product-list__item-title > a",
                            'color_hover'          => "$this->main_css_element h3.prodigy-product-list__item-title > a:hover, #et-boc .et-l div h3.prodigy-product-list__item-title > a:hover",
                            'letter_spacing'       => "$this->main_css_element h3.prodigy-product-list__item-title > a, #et-boc .et-l div h3.prodigy-product-list__item-title > a",
                            'letter_spacing_hover' => "$this->main_css_element h3.prodigy-product-list__item-title > a:hover, #et-boc .et-l div h3.prodigy-product-list__item-title > a:hover",
                            'important'            => 'all',
                        ),
                        'hide_text_align'  => true,
                        'hide_text_shadow' => false,
                    ),
                    'box_shadow'             => false,
                    'background_color'       => false,
                ),
                'price'         => array(
                    'label'                  => esc_html__( 'Price', 'et_builder' ),
                    'border_styles'          => false,
                    'margin_padding'         => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'font_field'             => array(
                        'css'              => array(
                            'main'                 => "$this->main_css_element div.prodigy-product-list__item-price, #et-boc .et-l div div.prodigy-product-list__item-price",
                            'hover'                => "$this->main_css_element div.prodigy-product-list__item-price:hover, #et-boc .et-l div div.prodigy-product-list__item-price:hover",
                            'color'                => "$this->main_css_element div.prodigy-product-list__item-price, #et-boc .et-l div div.prodigy-product-list__item-price",
                            'color_hover'          => "$this->main_css_element div.prodigy-product-list__item-price:hover, #et-boc .et-l div div.prodigy-product-list__item-price:hover",
                            'letter_spacing'       => "$this->main_css_element div.prodigy-product-list__item-price, #et-boc .et-l div div.prodigy-product-list__item-price",
                            'letter_spacing_hover' => "$this->main_css_element div.prodigy-product-list__item-price:hover, #et-boc .et-l div div.prodigy-product-list__item-price:hover",
                            'important'            => 'all',
                        ),
                        'hide_text_align'  => true,
                        'hide_text_shadow' => false,
                    ),
                    'box_shadow'             => false,
                    'background_color'       => false,
                ),
                'sale_badge'    => array(
                    'label'                  => esc_html__( 'Sale Badge', 'et_builder' ),
                    'background_color'       => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'font_field'             => array(
                        'css'              => array(
                            'main'      => "{$this->main_css_element} div.prodigy-product-list__item-label > span",
                            'important' => 'all',
                        ),
                        'hide_text_align'  => true,
                        'hide_text_shadow' => true,
                    ),
                    'margin_padding'         => false,
                    'box_shadow'             => false,
                    'border_styles'          => false,
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
                    'font_field'             => false,
                    'margin_padding'         => false,
                    'text_color'             => false,
                    'focus_background_color' => false,
                    'focus_text_color'       => false,
                    'use_focus_color'        => false,
                    'use_focus_text_color'   => false,
                    'box_shadow'             => false,
                    'background_color'       => false,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function get_fields() {
        $general_fileds = array(
            'type'     => array(
                'label'            => 'Type',
                'type'             => 'select',
                'toggle_slug'      => 'products_selection',
                'option_category'  => 'basic_option',
                'options'          => array(
                    'up-sell'    => __( 'Up-sell' ),
                    'cross-sell' => __( 'Cross-sell' ),
                    'both'       => __( 'Both' ),
                ),
                'default_on_front' => 'up-sell',
                'computed_affects' => array(
                    '__posts',
                ),
            ),
            'orderby'  => array(
                'label'            => 'Order By',
                'type'             => 'select',
                'toggle_slug'      => 'content',
                'option_category'  => 'basic_option',
                'options'          => array(
                    'id'     => 'Product ID',
                    'date'   => 'Date',
                    'title'  => 'Title',
                    'price'  => 'Price',
                    'rating' => 'Avg Rating',
                ),
                'default_on_front' => 'id',
                'computed_affects' => array(
                    '__posts',
                ),
            ),

            'order'    => array(
                'label'            => 'Order',
                'type'             => 'select',
                'toggle_slug'      => 'content',
                'option_category'  => 'basic_option',
                'options'          => array(
                    'asc'  => 'ASC',
                    'desc' => 'DESC',
                ),
                'default_on_front' => 'asc',
                'computed_affects' => array(
                    '__posts',
                ),
            ),
            'limit'    => array(
                'label'            => 'Limit',
                'type'             => 'text',
                'default_on_front' => - 1,
                'toggle_slug'      => 'content',
                'option_category'  => 'basic_option',
                'show_if'          => array(
                    'display' => 'slider',
                ),
                'computed_affects' => array(
                    '__posts',
                ),
            ),
            'display'  => array(
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
            'columns'  => array(
                'label'            => 'Columns',
                'type'             => 'text',
                'toggle_slug'      => 'content',
                'option_category'  => 'basic_option',
                'default_on_front' => '3',
                'computed_affects' => array(
                    '__posts',
                ),
            ),
            'content_archive_products_content_items_number'    => array(
                'label'            => 'Number of items',
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
            'category' => array(
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
            'rating'   => array(
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
            'sale'     => array(
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

            '__posts'  => array(
                'type'                => 'computed',
                'computed_callback'   => array(
                    'Divi_Prodigy_Related_Products',
                    'get_view',
                ),
                'computed_depends_on' => array(
                    'type',
                    'heading_text_value',
                    'orderby',
                    'order',
                    'limit',
                    'display',
                    'columns',
                    'content_archive_products_content_items_number',
                    'rating',
                    'category',
                    'sale',
                    'image_aspect_ratio_width',
                    'image_aspect_ratio_height',
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
            'general_column_margin'                   => array(
                'label'          => esc_html__( 'Column margin', 'et_builder' ),
                'type'           => 'range',
                'tab_slug'       => $tab,
                'toggle_slug'    => 'general',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'default'        => '24',
            ),
            'general_bottom_margin'                   => array(
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
            ),
            'general_bottom_padding'                  => array(
                'label'          => esc_html__( 'Bottom Padding', 'et_builder' ),
                'type'           => 'range',
                'tab_slug'       => $tab,
                'default'        => '0',
                'toggle_slug'    => 'general',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
            ),
            'general_top_padding'                     => array(
                'label'          => esc_html__( 'Top Padding', 'et_builder' ),
                'type'           => 'range',
                'tab_slug'       => $tab,
                'default'        => '0',
                'toggle_slug'    => 'general',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
            ),
            'heading_text_value'                      => array(
                'label'            => 'Heading Text Value',
                'type'             => 'text',
                'tab_slug'         => $tab,
                'toggle_slug'      => 'heading',
                'default'          => 'Related Products',
                'computed_affects' => array(
                    '__posts',
                ),
            ),
            'heading_background_color'                => array(
				'label'       => 'Background Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'heading',
			),
            'heading_text_color'                      => array(
				'label'       => 'Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'heading',
			),
            'heading_bottom_margin'                   => array(
                'label'          => esc_html__( 'Heading Bottom Margin', 'et_builder' ),
                'type'           => 'range',
                'tab_slug'       => $tab,
                'default'        => '16',
                'toggle_slug'    => 'heading',
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
            ),
            'box_background_color'                    => array(
				'label'       => 'Background Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'box',
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
            'image_spacing'                           => array(
                'label'       => esc_html__( 'Spacing', 'et_builder' ),
                'type'        => 'range',
                'tab_slug'    => $tab,
                'toggle_slug' => 'image',
            ),
            'category_spacing'                        => array(
                'label'       => esc_html__( 'Spacing', 'et_builder' ),
                'type'        => 'range',
                'tab_slug'    => $tab,
                'toggle_slug' => 'category',
            ),
            'category_text_color'                     => array(
				'label'       => 'Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'category',
			),
            'title_spacing'                           => array(
                'label'       => esc_html__( 'Spacing', 'et_builder' ),
                'type'        => 'range',
                'tab_slug'    => $tab,
                'toggle_slug' => 'title',
            ),
            'title_text_color'                        => array(
				'label'       => 'Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'title',
			),
            'title_text_color_hover'                  => array(
				'label'       => 'Text Color Hover',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'title',
			),
            'price_text_color'                        => array(
				'label'       => 'Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'price',
			),
            'sale_price_text_color'                   => array(
				'label'       => 'Sale Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'price',
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

        );

        return array_merge( $general_fileds, $custom_advanced_fields );
    }

	/**
	 * @param string $render_slug
	 *
	 * @return void
	 */
	public function custom_adjustments( $render_slug ) {
        if ( '' !== $this->props['general_alignment'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-product-list__item-container',
					'declaration' => esc_html( $this->props['general_alignment'] ),
                )
            );
        }

        if ( '' !== $this->props['general_column_margin'] ) {
            $margin = $this->props['general_column_margin'] / -2;
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider-container >div.slick-list',
					'declaration' => sprintf(
						'margin: 0 %1$spx !important;',
						esc_html( $margin )
					),
                )
            );
            $margin = $this->props['general_column_margin'] / 2;
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider div.prodigy-product-list__item.slick-slide',
					'declaration' => sprintf(
						'margin: 0 %1$spx !important;',
						esc_html( $margin )
					),
                )
            );
            $margin = $this->props['general_column_margin'];
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .related-products__container >div.prodigy-product-list__grid',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $margin )
					),
                )
            );
        }

        if ( '' !== $this->props['general_bottom_margin'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-custom-template',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['general_bottom_margin'] )
					),
                )
            );
        }

        if ( '' !== $this->props['general_bottom_padding'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider div.prodigy-product-list__item.slick-slide',
					'declaration' => sprintf(
						'padding-bottom: %1$spx !important;',
						esc_html( $this->props['general_bottom_padding'] )
					),
                )
            );
        }

        if ( '' !== $this->props['general_top_padding'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-homepage__slider div.prodigy-product-list__item.slick-slide',
					'declaration' => sprintf(
						'padding-top: %1$spx !important;',
						esc_html( $this->props['general_top_padding'] )
					),
                )
            );
        }

        if ( '' !== $this->props['heading_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-related__products-title',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['heading_background_color'] )
					),
                )
            );
		}

        if ( '' !== $this->props['heading_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-related__products-title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['heading_text_color'] )
					),
                )
            );
		}

        if ( '' !== $this->props['heading_bottom_margin'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-related__products-title',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['heading_bottom_margin'] )
					),
                )
            );
        }

        if ( '' !== $this->props['box_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__item > div.prodigy-product-list__item-container',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['box_background_color'] )
					),
                )
            );
		}

        if ( '' !== $this->props['image_aspect_ratio_height'] && '' !== $this->props['image_aspect_ratio_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-product-list__link-wrp',
					'declaration' => 'padding-top: calc(100% * ' . $this->props['image_aspect_ratio_height'] / $this->props['image_aspect_ratio_width'] . ') !important;',
                )
            );
		}

        if ( '' !== $this->props['image_spacing'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-product-list__link-wrp',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['image_spacing'] )
					),
                )
            );
        }

        if ( '' !== $this->props['category_spacing'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% p.prodigy-product-list__item-category',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['category_spacing'] )
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

        if ( '' !== $this->props['title_spacing'] ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-product-list__item-title ',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['title_spacing'] )
					),
                )
            );
        }

        if ( '' !== $this->props['title_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-product-list__item-title > a',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['title_text_color'] )
					),
                )
            );
		}

        if ( '' !== $this->props['title_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% h3.prodigy-product-list__item-title > a:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['title_text_color_hover'] )
					),
                )
            );
		}

        if ( '' !== $this->props['price_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-product-list__item-price:not(.prodigy-product-list__item-price--sale)',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['price_text_color'] )
					),
                )
            );
		}

        if ( '' !== $this->props['sale_price_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-product-list__item-price.prodigy-product-list__item-price--sale',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['sale_price_text_color'] )
					),
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
    }

    /**
     * @param array $attr
     *
     * @return array
     */
    public function set_widget_parameters( array $attr ): array {
        $attr['category'] = ! empty( $attr['category'] ) ? $this->mapper[ $attr['category'] ] : false;
        $attr['rating'] = ! empty( $attr['rating'] ) ? $this->mapper[ $attr['rating'] ] : false;
        $attr['sale'] = ! empty( $attr['sale'] ) ? $this->mapper[ $attr['sale'] ] : false;
        $attr['display'] = isset( $attr['display'] ) ? $this->display_mapper[ $attr['display'] ] : false;
        $attr['style_content_heading_text'] = $attr['heading_text_value'];

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
     * @return string
     */
    public function render_view( $args ): string {
        ob_start();
        do_action( 'prodigy_shortcode_related_products', $args );
        wp_reset_postdata();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

new Divi_Prodigy_Related_Products();
