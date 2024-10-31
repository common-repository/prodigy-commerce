<?php

use Prodigy\Includes\Frontend\Mappers\Prodigy_Categories_Data_Mapper;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Prodigy;

/**
 * Divi_Prodigy_Categories class
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Categories extends ET_Builder_Module {

	/** @var $product Prodigy_Product_Parser */
	public $product;

	/** @var $categories_mapper Prodigy_Categories_Data_Mapper */
	public $categories_mapper;

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->slug              = 'divi_prodigy_categories';
		$this->vb_support        = 'on';
		$this->name              = esc_html( 'Prodigy Categories' );
		$this->icon_path         = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Categories.svg';
		$this->categories_mapper = new Prodigy_Categories_Data_Mapper();

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'categories_selection' => et_builder_i18n( 'Selection' ),
					'main_content'         => et_builder_i18n( 'Content' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'general'       => et_builder_i18n( 'General' ),
					'box'           => et_builder_i18n( 'Box' ),
					'slider'        => et_builder_i18n( 'Slider' ),
					'slider_arrows' => et_builder_i18n( 'Slider Arrows' ),
					'overlay'       => esc_html__( 'Overlay', 'et_builder' ),
					'image'         => esc_html__( 'Image', 'et_builder' ),
					'title'         => esc_html__( 'Title', 'et_builder' ),
					'product_count' => esc_html__( 'Product Count', 'et_builder' ),
				),
			),
		);
		$this->advanced_fields        = array(
			'fonts'      => array(
				'title'         => array(
					'label' => et_builder_i18n( 'Title' ),
					'css'   => array(
						'main'                 => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name",
						'hover'                => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name:hover",
						'color'                => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name",
						'color_hover'          => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name:hover",
						'letter_spacing'       => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name",
						'letter_spacing_hover' => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name:hover",
						'important'            => 'all',
					),
				),
				'product_count' => array(
					'label' => et_builder_i18n( 'Product Count' ),
					'css'   => array(
						'main'        => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name-amount",
						'color'       => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name-amount",
						'color_hover' => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-title-name-amount:hover",
						'important'   => 'all',
					),
				),
			),
			'text'       => false,
			'form_field' => array(
				'box'           => array(
					'label'            => esc_html__( 'Box', 'et_builder' ),
					'border_styles'    => false,
					'margin_padding'   => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'background_color' => false,
				),
				'slider_arrows' => array(
					'label'                  => esc_html__( 'Slider', 'et_builder' ),
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
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap",
							'hover'     => "{$this->main_css_element} div.prodigy-categories .prodigy-categories__card-wrap:hover, div.prodigy-categories-slider .prodigy-categories__card-wrap:hover",
							'important' => 'all',
						),
					),
				),
				'image'         => array(
					'label'                  => esc_html__( 'Slider', 'et_builder' ),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => false,
					'margin_padding'         => false,
					'box_shadow'             => false,
					'border_styles'          => false,
				),
				'overlay'       => array(
					'label'                  => esc_html__( 'Box', 'et_builder' ),
					'margin_padding'         => false,
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'font_field'             => false,
					'box_shadow'             => false,
					'border_styles'          => false,
				),
			),
		);

		$this->main_css_element = '%%order_class%%';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		$basic_fields = array(
			'category_ids'       => array(
				'label'            => 'By Category Names',
				'type'             => 'multi_select',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'default'          => '',
				'options'          => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'slug' ),
				'computed_affects' => array(
					'__posts',
				),
			),

			'parent_ids'         => array(
				'label'            => 'By Parent Names',
				'type'             => 'multi_select',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'options'          => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'slug' ),
				'description'      => 'Write all Parent IDs separated with comma',
				'computed_affects' => array(
					'__posts',
				),
			),
			'limit'              => array(
				'label'            => 'Limit',
				'type'             => 'text',
				'description'      => 'Limits the number of categories returned.  For example, if the other attributes specified in the shortcode match 8 categories and the limit attribute is set to 4, then only the first 4 matching categories will be displayed.',
				'default_on_front' => '8',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'show_if'          => array(
					'display' => 'slider',
				),
				'computed_affects' => array(
					'__posts',
				),
			),
			'display'            => array(
				'label'            => 'Display',
				'type'             => 'select',
				'options'          => array(
					'slider' => 'Slider',
					'grid'   => 'Grid',
				),
				'default_on_front' => 'slider',
				'description'      => 'Determines if products will be displayed in slider or grid view.  Acceptable values are:  slider, grid.  Default it slider.',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'columns'            => array(
				'label'            => 'Columns',
				'type'             => 'text',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'description'      => 'Determines the number of category columns per row that will be displayed.  The default value is 4 columns per row if not specified.',
				'default_on_front' => '3',
				'computed_affects' => array(
					'__posts',
				),
			),

			'rows'               => array(
				'label'            => 'Rows',
				'type'             => 'text',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'default_on_front' => '3',
				'show_if'          => array(
					'display' => 'grid',
				),
				'computed_affects' => array(
					'__posts',
				),
			),

			'orderby'            => array(
				'label'            => 'Order By',
				'type'             => 'select',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'options'          => array(
					'id'    => 'ID',
					'title' => 'Title',
				),
				'default_on_front' => 'id',
				'description'      => 'Allows you specify the order in which the categories will be displayed.  Acceptable values are: id, title.  Default value is id.',
				'computed_affects' => array(
					'__posts',
				),
			),
			'order'              => array(
				'label'            => 'Order',
				'type'             => 'select',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'options'          => array(
					'ASC'  => 'ASC',
					'DESC' => 'DESC',
				),
				'description'      => 'Determines if the sort order will be ascending or descending.  Acceptable values are: ASC, DESC',
				'default_on_front' => 'ASC',
				'computed_affects' => array(
					'__posts',
				),
			),
			'show_product_count' => array(
				'label'            => 'Show products count',
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => 'Yes',
					'off' => 'No',
				),
				'default_on_front' => 'on',
				'description'      => 'Determines if the count of products will be shown in the image overlay.  Acceptable values are:  true, false.  Default value is true.',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__posts',
				),
			),
			'__posts'            => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'Divi_Prodigy_Categories',
					'get_view',
				),
				'computed_depends_on' => array(
					'category_ids',
					'parent_ids',
					'category_slugs',
					'limit',
					'columns',
					'rows',
					'display',
					'show_product_count',
					'order',
					'orderby',
					'slider_hide_arrows',
					'aspect_ratio_width',
					'aspect_ratio_height',
				),
			),
		);

		$tab = 'advanced';
		$custom_advanced_fields   = array(
			'general_column_margin'               => array(
				'label'          => esc_html__( 'Column margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
				'default'        => '24',
			),
			'general_row_margin'                  => array(
				'label'          => esc_html__( 'Row margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
				'default'        => '24',
			),
			'general_slider_y_padding'            => array(
				'label'          => esc_html__( 'Slider Y padding', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
				'default'        => '24',
				'show_if'        => array(
					'display' => 'slider',
				),
			),
			'general_slider_x_padding'            => array(
				'label'          => esc_html__( 'Slider X padding', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
				'default'        => '0',
				'show_if'        => array(
					'display' => 'slider',
				),
			),
			'general_grid_padding'                => array(
				'label'          => esc_html__( 'Grid padding', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'general',
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
				),
				'default'        => '24',
				'show_if'        => array(
					'display' => 'grid',
				),
			),
			'slider_hide_arrows'                  => array(
				'label'            => esc_html__( 'Hide arrows', 'et_builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'toggle_slug'      => 'slider_arrows',
				'tab_slug'         => $tab,
				'description'      => 'Hide the arrow controls until the slider is hovered',
				'default'          => 'off',
				'computed_affects' => array(
					'__posts',
				),
			),
			'slider_arrow_width'                  => array(
				'label'       => esc_html__( 'Width', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_height'                 => array(
				'label'       => esc_html__( 'Height', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_font_size'              => array(
				'label'       => esc_html__( 'Font Size', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '36',
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_background_color'       => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_hover_background_color' => array(
				'label'       => esc_html__( 'Background color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'slider_arrow_color'                  => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'slider_arrows',
			),
			'box_background_color'                => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'box',
			),
			'overlay_text_position'               => array(
				'label'       => esc_html__( 'Text position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'absolute' => 'Overlay',
					'relative' => 'Below',
				),
				'default'     => 'absolute',
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
			),
			'overlay_position_horizontal'         => array(
				'label'       => esc_html__( 'Overlay Position Horizontal', 'et_builder' ),
				'type'        => 'select',
				'description' => 'Determines the position of the overlay with the category link',
				'options'     => array(
					'left: 0 !important;right: 0 !important;'    => 'Center',
					'right: 24px !important; left: auto !important;' => 'Right',
					'left: 24px !important; right: auto !important;' => 'Left',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
				'default'     => 'left: 0 !important;right: 0 !important;',
			),
			'overlay_position_vertical'           => array(
				'label'       => esc_html__( 'Overlay Position Vertical', 'et_builder' ),
				'type'        => 'select',
				'description' => 'Determines the position of the overlay with the category link',
				'options'     => array(
					'top: 24px !important;bottom: auto !important;' => 'Top',
					'bottom: 50% !important; transform: translateY(50%) !important;'  => 'Center',
					'bottom: 24px !important;' => 'Bottom',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
				'default'     => 'bottom: 24px !important;',
			),
			'overlay_background_color'            => array(
				'label'       => 'Background Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
			),
			'overlay_background_hover_color'      => array(
				'label'       => 'Background Color on hover',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
			),
			'overlay_width'                       => array(
				'label'          => esc_html__( 'Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'overlay',
				'range_settings' => array(
					'min' => '0',
					'max' => '1000',
				),
			),
			'overlay_text_padding_top'            => array(
				'label'          => esc_html__( 'Text padding top', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'range_settings' => array(
					'min' => '0',
					'max' => '200',
				),
				'default'        => '26',
				'toggle_slug'    => 'overlay',
			),
			'overlay_text_padding_bottom'         => array(
				'label'          => esc_html__( 'Text padding bottom', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'overlay',
				'default'        => '26',
				'range_settings' => array(
					'min' => '0',
					'max' => '200',
				),
			),
			'aspect_ratio_width'                  => array(
				'label'            => 'Aspect ratio width',
				'type'             => 'range',
				'tab_slug'         => $tab,
				'toggle_slug'      => 'image',
				'default'          => '3',
				'range_settings'   => array(
					'min' => '0',
					'max' => '10',
				),
				'computed_affects' => array(
					'__posts',
				),
			),
			'aspect_ratio_height'                 => array(
				'label'            => 'Aspect ratio height',
				'type'             => 'range',
				'tab_slug'         => $tab,
				'toggle_slug'      => 'image',
				'default'          => '4',
				'range_settings'   => array(
					'min' => '0',
					'max' => '10',
				),
				'computed_affects' => array(
					'__posts',
				),
			),

		);

		return array_merge( $basic_fields, $custom_advanced_fields );
	}

	/**
	 * @param string $render_slug
	 *
	 * @return void
	 */
	public function custom_adjustments( $render_slug ) {
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%%',
				'declaration' => 'pointer-events: none;',
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .prodigy-categories-slider',
				'declaration' => 'pointer-events: all; position: relative; z-index: -1;',
			)
		);

		if ( '' !== $this->props['general_column_margin'] ) {
			$margin = $this->props['general_column_margin'] / -2;
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories-slider .slick-list',
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
					'selector'    => '%%order_class%% .prodigy-product-list__grid',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $margin )
					),
                )
            );
		}

		if ( '' !== $this->props['general_row_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__grid',
					'declaration' => sprintf(
						'row-gap: %1$spx !important;',
						esc_html( $this->props['general_row_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['general_slider_y_padding'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories-slider .slick-track',
					'declaration' => sprintf(
						'padding-top: %1$spx !important;padding-bottom: %1$spx !important;',
						esc_html( $this->props['general_slider_y_padding'] )
					),
                )
            );
		}

		if ( '' !== $this->props['general_slider_x_padding'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories-slider .slick-list',
					'declaration' => sprintf(
						'padding-left: %1$spx !important;padding-right: %1$spx !important;',
						esc_html( $this->props['general_slider_x_padding'] )
					),
                )
            );
		}

		if ( '' !== $this->props['general_grid_padding'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-product-list__grid',
					'declaration' => sprintf(
						'padding: %1$spx !important;',
						esc_html( $this->props['general_grid_padding'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav',
					'declaration' => sprintf(
						'width: %1$spx;',
						esc_html( $this->props['slider_arrow_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_height'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav',
					'declaration' => sprintf(
						'height: %1$spx;',
						esc_html( $this->props['slider_arrow_height'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_font_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav',
					'declaration' => sprintf(
						'font-size: %1$spx;',
						esc_html( $this->props['slider_arrow_font_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['slider_arrow_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_hover_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-related__products-nav:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['slider_arrow_hover_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['slider_arrow_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% button.prodigy-related__products-nav',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slider_arrow_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['box_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-categories__card-wrap',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['box_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_text_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => sprintf(
						'position: %1$s !important;',
						esc_html( $this->props['overlay_text_position'] )
					),
                )
            );
			if ( $this->props['overlay_text_position'] === 'relative' ) {
				ET_Builder_Element::set_style(
                    $render_slug,
                    array(
						'selector'    => '%%order_class%% .prodigy-categories__card-title',
						'declaration' => sprintf(
							'position: %1$s !important;transform: translateY(24px) !important;',
							esc_html( $this->props['overlay_text_position'] )
						),
                    )
                );
			}
		}

		if ( '' !== $this->props['overlay_position_horizontal'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => esc_html( $this->props['overlay_position_horizontal'] ),
                )
            );
		}

		if ( '' !== $this->props['overlay_position_vertical'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => esc_html( $this->props['overlay_position_vertical'] ),
                )
            );
		}

		if ( '' !== $this->props['overlay_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['overlay_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_background_hover_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-wrap:hover .prodigy-categories__card-title',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['overlay_background_hover_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => sprintf(
						'width: %1$spx !important',
						esc_html( $this->props['overlay_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_text_padding_top'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => sprintf(
						'padding-top: %1$spx !important;',
						esc_html( $this->props['overlay_text_padding_top'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_text_padding_bottom'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-categories__card-title',
					'declaration' => sprintf(
						'padding-bottom: %1$spx !important;',
						esc_html( $this->props['overlay_text_padding_bottom'] )
					),
                )
            );
		}

		if ( '' !== $this->props['aspect_ratio_height'] && '' !== $this->props['aspect_ratio_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-categories a.prodigy-categories__card',
					'declaration' => 'aspect-ratio:' . $this->props['aspect_ratio_width'] / $this->props['aspect_ratio_height'] . '!important',
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
		if ( empty( $attr['show_product_count'] ) ) {
			$attr['show_product_count'] = 'on';
		}
		$attr['show_product_count'] = $this->categories_mapper->show_product_count_mapper[ $attr['show_product_count'] ];
		$attr['title_classname']    = 'prodigy-categories__card-title';
		$attr['slider_hide_arrows'] = isset( $attr['slider_hide_arrows'] ) ? $this->categories_mapper->arrows_mapper[ $attr['slider_hide_arrows'] ] : 'no';

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
		$parameters = $widget->set_widget_parameters( $args );

		return $widget->render_view( $parameters );
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
	public function render_view( array $args ): string {
		ob_start();
		do_action( 'prodigy_get_template_categories', $args );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

new Divi_Prodigy_Categories();
