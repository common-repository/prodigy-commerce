<?php

use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Prodigy;

/**
 * Divi_Prodigy_Category class
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Category extends ET_Builder_Module {

	/** @var $product Prodigy_Product_Parser */
	public $product;

	/** @var $categories array */
	public $categories;

	const CLASS_NAME = 'prodigy-category-link';

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->categories = Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'slug' );
		$this->slug       = 'divi_prodigy_category';
		$this->vb_support = 'on';
		$this->name       = esc_html( 'Prodigy Category' );
		$this->icon_path  = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Category.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'categories_selection' => et_builder_i18n( 'Selection' ),
					'image'                => et_builder_i18n( 'Image' ),
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
					'css'             => array(
						'main'        => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link .prodigy-category-link__title",
						'font'        => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link .prodigy-category-link__title",
						'color'       => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link .prodigy-category-link__title",
						'plugin_main' => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link .prodigy-category-link__title",
						'important'   => 'all',
					),
					'use_alignment'   => false,
					'box_shadow'      => true,
					'use_text_shadow' => true,
				),
				'product_count' => array(
					'css'                 => array(
						'main'      => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link__products",
						'font'      => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link__products",
						'color'     => "{$this->main_css_element} div.prodigy-category-link-wrapper .prodigy-category-link__products",
						'important' => 'all',
					),
					'hide_text_alignment' => true,
					'box_shadow'          => true,
				),
			),
			'text'       => false,
			'form_field' => array(
				'box'     => array(
					'label'                  => esc_html__( 'Box', 'et_builder' ),
					'border_styles'          => array(
						'css' => array(
							'main' => "{$this->main_css_element} .prodigy-category-link-wrapper",
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-category-link-wrapper",
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
							'main'      => "{$this->main_css_element} .prodigy-category-link-wrapper",
							'hover'     => "{$this->main_css_element} .prodigy-category-link-wrapper:hover",
							'important' => 'all',
						),
					),
					'background_color'       => false,
				),
				'overlay' => array(
					'label'                  => esc_html__( 'Overlay', 'et_builder' ),
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
			'category_id'         => array(
				'label'            => 'By category name',
				'type'             => 'select',
				'default_on_front' => array_values( $this->categories )[0] ?? '',
				'options'          => $this->categories,
				'description'      => 'Accepts a single Category Name slug to display',
				'toggle_slug'      => 'categories_selection',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__content',
				),
			),
			'category_image'      => array(
				'label'              => esc_html__( 'Background image', 'et_builder' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'        => 'categories_selection',
				'option_category'    => 'basic_option',
				'computed_affects'   => array(
					'__content',
				),
			),
			'show_count_products' => array(
				'label'            => 'Show products number',
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
					'__content',
				),
			),
			'__content'           => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'DIVI_Prodigy_Category', 'get_view' ),
				'computed_depends_on' => array(
					'category_id',
					'category_image',
					'show_count_products',
				),
			),
		);

		$tab = 'advanced';
		$custom_advanced_fields   = array(
			'image_height'                => array(
				'label'          => esc_html__( 'Height', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '325',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '1,',
				),
				'toggle_slug'    => 'image',
			),
			'image_position'              => array(
				'label'       => esc_html__( 'Image position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'top'    => 'Top',
					'center' => 'Center',
					'bottom' => 'Bottom',
				),
				'default'     => 'center',
				'tab_slug'    => $tab,
				'toggle_slug' => 'image',
			),
			'box_background_color'        => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'box',
			),
			'overlay_text_position'       => array(
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
			'overlay_width'               => array(
				'label'          => esc_html__( 'Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'overlay',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
				),
			),
			'overlay_text_padding_top'    => array(
				'label'          => esc_html__( 'Text padding top', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'default'        => '26',
				'toggle_slug'    => 'overlay',
			),

			'overlay_text_padding_bottom' => array(
				'label'          => esc_html__( 'Text padding bottom', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'overlay',
				'default'        => '26',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
				),
			),

			'overlay_position_horizontal' => array(
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
			'overlay_position_vertical'   => array(
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
			'overlay_background_color'    => array(
				'label'       => 'Background Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'overlay',
			),
			'title_spacing'               => array(
				'label'       => esc_html__( 'Title spacing', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'toggle_slug' => 'title',
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
		if ( '' !== $this->props['image_height'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper .prodigy-category-link__img',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['image_height'] )
					),
                )
            );
		}

		if ( '' !== $this->props['image_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper .prodigy-category-link__img',
					'declaration' => sprintf(
						'background-position-y: %1$s !important;',
						esc_html( $this->props['image_position'] )
					),
                )
            );
		}

		if ( '' !== $this->props['box_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['box_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper .prodigy-category-link',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['overlay_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper .prodigy-category-link',
					'declaration' => sprintf(
						'max-width: %1$spx !important;',
						esc_html( $this->props['overlay_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_text_padding_top'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-category-link',
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
					'selector'    => '%%order_class%% .prodigy-category-link',
					'declaration' => sprintf(
						'padding-bottom: %1$spx !important;',
						esc_html( $this->props['overlay_text_padding_bottom'] )
					),
                )
            );
		}

		if ( '' !== $this->props['overlay_text_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-category-link-wrapper .prodigy-category-link',
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
						'selector'    => '%%order_class%% .prodigy-category-link-wrapper .prodigy-category-link',
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
					'selector'    => '%%order_class%% .prodigy-category-link-wrapper .prodigy-category-link',
					'declaration' => esc_html( $this->props['overlay_position_horizontal'] ),
                )
            );
		}

		if ( '' !== $this->props['overlay_position_vertical'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-category-link-wrapper .prodigy-category-link',
					'declaration' => esc_html( $this->props['overlay_position_vertical'] ),
                )
            );
		}

		if ( '' !== $this->props['title_spacing'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% div.prodigy-category-link-wrapper .prodigy-category-link__title',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['title_spacing'] )
					),
                )
            );
		}
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function set_widget_parameters( array $args ): array {
		$args['link_classname'] = self::CLASS_NAME;

		return $args;
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
     * @param array $attr
     *
     * @return string
     */
    public function render_view( array $attr ): string {
        ob_start();
        do_action( 'prodigy_get_template_category_link', $attr );
        wp_reset_postdata();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

new Divi_Prodigy_Category();
