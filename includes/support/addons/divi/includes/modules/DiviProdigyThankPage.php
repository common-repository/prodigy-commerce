<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Divi_Prodigy_Thank_Page class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Thank_Page extends ET_Builder_Module {

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->slug             = 'divi_prodigy_thank_page';
		$this->vb_support       = 'on';
		$this->name             = 'Prodigy Thank You Page';
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Thank_You_Page.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => et_builder_i18n( 'Content' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'heading'          => esc_html__( 'Heading', 'prodigy' ),
					'content'          => esc_html__( 'Content', 'prodigy' ),
					'content_variable' => esc_html__( 'Content Variable', 'prodigy' ),
					'approval_message' => esc_html__( 'Approval Message', 'prodigy' ),
					'button'           => esc_html__( 'Button', 'prodigy' ),
				),
			),
		);

		$this->advanced_fields = array(
			'form_field' => array(
				'heading'          => array(
					'label'                  => esc_html__( 'Heading', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-thank-you-page__title",
							'hover'                => "{$this->main_css_element} .prodigy-thank-you-page__title:hover",
							'color'                => "{$this->main_css_element} .prodigy-thank-you-page__title",
							'color_hover'          => "{$this->main_css_element} .prodigy-thank-you-page__title:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-thank-you-page__title",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-thank-you-page__title:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'content'          => array(
					'label'                  => esc_html__( 'Content', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p",
							'hover'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p:hover",
							'color'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p",
							'color_hover'          => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,

					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'content_variable' => array(
					'label'                  => esc_html__( 'Variable', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold",
							'hover'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold:hover",
							'color'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold",
							'color_hover'          => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,

					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'button'           => array(
					'label'                  => esc_html__( 'Button', 'et_builder' ),
					'border_styles'          => array(
						'button' => array(
							'label_prefix'      => 'Button',
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element}  .prodigy-thank-you-page .prodigy-main-button--link.prodigy-main-button.prodigy-main-button--wide, #et-boc .et-l div .prodigy-custom-template a.prodigy-main-button.prodigy-thanks-txt__content",
									'border_radii'  => "{$this->main_css_element}  .prodigy-thank-you-page .prodigy-main-button--link.prodigy-main-button.prodigy-main-button--wide, #et-boc .et-l div .prodigy-custom-template a.prodigy-main-button.prodigy-thanks-txt__content",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => true,
							'use_radius'        => true,
						),
					),
					'margin_padding'         => array(
						'label'      => esc_html__( 'Text', 'et_builder' ),
						'css'        => array(
							'padding'   => "{$this->main_css_element} #et-boc a.prodigy-thanks-txt__content, .prodigy-thank-you-page .prodigy-main-button--link.prodigy-main-button.prodigy-main-button--wide",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'hover'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'color'                => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'color_hover'          => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-thank-you-page .prodigy-main-button--link",
							'important'            => 'all',
						),
						'hide_text_align' => true,

					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'approval_message'           => array(
					'label'                  => esc_html__( 'Approval Message', 'prodigy' ),
					'border_styles'          => array(
						'approval_message' => array(
							'label_prefix'      => __( 'Approval Message', 'prodigy' ),
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} h5.prodigy-thank-you-page__approval-message, #et-boc .et-l div h5.prodigy-thank-you-page__approval-message",
									'border_radii'  => "{$this->main_css_element} h5.prodigy-thank-you-page__approval-message, #et-boc .et-l div h5.prodigy-thank-you-page__approval-message",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => true,
							'use_radius'        => true,
						),
					),
					'margin_padding'         => array(
						'label'      => esc_html__( 'Text', 'prodigy' ),
						'css'        => array(
							'padding'   => "{$this->main_css_element} #et-boc h5.prodigy-thank-you-page__approval-message, .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'margin'   => "{$this->main_css_element} #et-boc h5.prodigy-thank-you-page__approval-message, .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'important' => 'all',
						),
					),
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'hover'                => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'color'                => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'color_hover'          => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-thank-you-page h5.prodigy-thank-you-page__approval-message",
							'important'            => 'all',
						),
						'hide_text_align' => true,

					),
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
		$basic_fields = array(
			'heading_text' => array(
				'label'            => 'Heading Text',
				'type'             => 'text',
				'toggle_slug'      => 'main_content',
				'default'          => 'Thank you for your order.',
				'computed_affects' => array(
					'__posts',
				),
			),
			'__posts'      => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'Divi_Prodigy_Thank_Page',
					'get_view',
				),
				'computed_depends_on' => array(
					'heading_text',
				),
			),
		);

		$tab                    = 'advanced';
		$custom_advanced_fields = array(
			'heading_position'              => array(
				'label'       => esc_html__( 'Heading Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'align-self: center !important;' => 'Center',
					'align-self: end !important;'    => 'Right',
					'align-self: start !important;'  => 'Left',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'heading',
				'default'     => 'align-self: center !important;',
			),

			'heading_top_margin'            => array(
				'label'          => esc_html__( 'Heading Top Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '80',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'heading',
			),

			'heading_bottom_margin'         => array(
				'label'          => esc_html__( 'Heading Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '20',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'heading',
			),

			'heading_text_color'            => array(
				'label'       => 'Heading Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'heading',
			),

			'content_position'              => array(
				'label'       => esc_html__( 'Content Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'align-self: center !important;' => 'Center',
					'align-self: end !important;'    => 'Right',
					'align-self: start !important;'  => 'Left',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'content',
				'default'     => 'align-self: center !important;',
			),

			'content_bottom_margin'         => array(
				'label'          => esc_html__( 'Content Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '40',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'content',
			),

			'content_text_color'            => array(
				'label'       => 'Content Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'content',
			),

			'content_variable_text_color'   => array(
				'label'       => 'Content Variable Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'content_variable',
			),

			'button_bottom_margin'          => array(
				'label'          => esc_html__( 'Button Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '80',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'content',
			),

			'button_background_color'       => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'button',
			),

			'button_text_color'             => array(
				'label'       => 'Button Text Color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'button',
			),

			'button_text_color_hover'       => array(
				'label'       => 'Button Text Color Hover',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'button',
			),

			'button_background_color_hover' => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'button',
			),

			'approval_message_bg_color'     => array(
				'label'       => esc_html__( 'Approval Message Background Color', 'prodigy' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'approval_message',
			),

			'approval_message_text_color'   => array(
				'label'       => esc_html__( 'Approval Message Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'approval_message',
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
		if ( '' !== $this->props['heading_position'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__title',
					'declaration' => esc_html( $this->props['heading_position'] ),
				)
			);
		}

		if ( '' !== $this->props['content_position'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thanks-txt__content',
					'declaration' => esc_html( $this->props['content_position'] ),
				)
			);
		}

		if ( '' !== $this->props['heading_top_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__title',
					'declaration' => sprintf(
						'margin-top: %1$spx !important;',
						esc_html( $this->props['heading_top_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['heading_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__title',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['heading_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['heading_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['heading_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['content_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__txt > p',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['content_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['content_variable_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__txt > p > span.font-bold',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['content_variable_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['content_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-thank-you-page__txt',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['content_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['button_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-main-button--link',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['button_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['button_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-main-button--link',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['button_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-main-button--link:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['button_background_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-main-button--link:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['button_text_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['button_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page .prodigy-main-button--link',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['button_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['approval_message_bg_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page__approval-message',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['approval_message_bg_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['approval_message_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-thank-you-page__approval-message',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['approval_message_text_color'] )
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
	public function set_widget_settings( $attr ): array {
		$props['heading_text'] = $attr['heading_text'];

		return $props;
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
		$attr   = $widget->set_widget_settings( $args );
        $attr['divi_editor'] = true;

		return $widget->render_view( $attr );
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
		$parameters = $this->set_widget_settings( $this->props );

		return $this->render_view( $parameters );
	}

	/**
	 * @param array $attr
	 *
	 * @return string
	 */
	public function render_view( $attr ): string {
		ob_start();
		do_action( 'prodigy_shortcode_template_thank_you', $attr );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

new Divi_Prodigy_Thank_Page();
