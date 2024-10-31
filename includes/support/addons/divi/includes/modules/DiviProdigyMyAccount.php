<?php

/**
 * DIVI_Categories
 */
class Divi_Prodigy_My_Account extends ET_Builder_Module {

	const GENERAL_ALIGNMENT_LEFT = 'justify-content: flex-start !important;';
	const GENERAL_ALIGNMENT_RIGHT = 'justify-content: flex-end !important;';
	const GENERAL_ALIGNMENT_CENTER = 'justify-content: center !important;';
	const GENERAL_ALIGNMENT_START = 'justify-content: flex-start !important;';

	const WIDGET_TYPE_SLIDER = 'slider';
	const WIDGET_TYPE_DROPDOWN = 'dropdown';

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->slug             = 'divi_prodigy_my_account';
		$this->vb_support       = 'on';
		$this->name             = esc_html( 'Prodigy My Account' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/My_Account.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content' => et_builder_i18n( 'Content' ),
					'general' => et_builder_i18n( 'General' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'general'                     => et_builder_i18n( 'General' ),
					'link'                        => et_builder_i18n( 'Link' ),
					'icon_badge'                  => et_builder_i18n( 'Icon Badge' ),
					'menu_container'              => et_builder_i18n( 'Menu Container' ),
					'dropdown_heading'            => et_builder_i18n( 'Dropdown Heading' ),
					'dropdown_heading_user_name'  => et_builder_i18n( 'Dropdown Heading Username' ),
					'dropdown_heading_user_email' => et_builder_i18n( 'Dropdown Heading Useremail' ),
					'dropdown_footer'             => et_builder_i18n( 'Dropdown Footer' ),
					'slide_title'                 => et_builder_i18n( 'Slide Title' ),
					'slide_close'                 => et_builder_i18n( 'Slide Close' ),
					'account_item'                => et_builder_i18n( 'Account Item' ),
					'slide_footer'                => et_builder_i18n( 'Slide Footer' ),
					'slide_footer_user_name'      => et_builder_i18n( 'Slide Footer Username' ),
					'slide_footer_user_email'     => et_builder_i18n( 'Slide Footer Useremail' ),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'      => array(
				'link' => array(
					'label' => et_builder_i18n( 'Link' ),
					'css'   => array(
						'main'                 => "{$this->main_css_element} .prodigy-navbar-account__wrap .prodigy-navbar-user__status,  #et-boc .et-l div .prodigy-navbar-account__wrap .prodigy-navbar-user__status",
						'hover'                => "{$this->main_css_element} .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status, #et-boc .et-l div .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status",
						'color'                => "{$this->main_css_element} .prodigy-navbar-account__wrap .prodigy-navbar-user__status, #et-boc .et-l div .prodigy-navbar-account__wrap .prodigy-navbar-user__status",
						'color_hover'          => "{$this->main_css_element} .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status, #et-boc .et-l div .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status",
						'letter_spacing'       => "{$this->main_css_element} .prodigy-navbar-account__wrap .prodigy-navbar-user__status,  #et-boc .et-l div .prodigy-navbar-account__wrap .prodigy-navbar-user__status",
						'letter_spacing_hover' => "{$this->main_css_element} .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status,  #et-boc .et-l div .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status",
						'important'            => 'all',
					),
				),
			),
			'form_field' => array(
				'menu_container'              => array(
					'label'                  => esc_html__( 'Menu Container', 'et_builder' ),
					'border_styles'          => array(
						'menu_container' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .et-l div .prodigy-account__menu, .prodigy-account__menu, #et-boc .et-l div .prodigy-account__menu",
									'border_radii'  => "{$this->main_css_element} .et-l div .prodigy-account__menu, .prodigy-account__menu, #et-boc .et-l div .prodigy-account__menu, .et-l div .prodigy-account__block, #et-boc .et-l div .prodigy-account__block, .prodigy-account__block",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-account__menu, .et-l .prodigy-account__menu, #et-boc .et-l div .prodigy-account__menu",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'background_color'       => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
					'overflow'               => false,
					'box_shadow'             => false,
				),
				'icon_badge'                  => array(
					'label'                  => esc_html__( 'Icon Badge', 'et_builder' ),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-navbar-account .prodigy-navbar-user, #et-boc .et-l div .prodigy-navbar-account .prodigy-navbar-user",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'border_styles'          => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'slide_title'                 => array(
					'label'                  => esc_html__( 'Slide Title', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title, .prodigy-navbar-user__slide-title",
							'hover'                => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title:hover, .prodigy-navbar-user__slide-title:hover",
							'color'                => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title, .prodigy-navbar-user__slide-title",
							'color_hover'          => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title:hover, .prodigy-navbar-user__slide-title:hover",
							'letter_spacing'       => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title, .prodigy-navbar-user__slide-title",
							'letter_spacing_hover' => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-user__slide-title:hover, .prodigy-navbar-user__slide-title:hover",
							'important'            => 'all',
						),
						'hide_text_align' => false,
						'important'       => 'all',
					),
					'box_shadow'             => false,
					'background_color'       => false,
					'important'              => 'all',
				),
				'account_item'                => array(
					'label'                  => esc_html__( 'Account Item', 'et_builder' ),
					'border_styles'          => array(
						'account_item' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-account__menu-item, .et-l .prodigy-account__menu-item",
									'border_radii'  => "{$this->main_css_element} .prodigy-account__menu-item, .et-l .prodigy-account__menu-item",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
						),
					),
					'margin_padding'         => array(
						'css' => array(
							'margin'    => "{$this->main_css_element} .prodigy-account__menu-item, .et-l .prodigy-account__menu-item",
							'padding'   => "{$this->main_css_element} .prodigy-account__menu-item, .et-l .prodigy-account__menu-item",
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
							'main'                 => "{$this->main_css_element} .prodigy-account__menu-item",
							'hover'                => "{$this->main_css_element} .prodigy-account__menu-item:hover",
							'color'                => "{$this->main_css_element} .prodigy-account__menu-item",
							'color_hover'          => "{$this->main_css_element} .prodigy-account__menu-item:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-account__menu-item",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-account__menu-item:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'slide_footer'                => array(
					'label'                  => esc_html__( 'Slide Footer', 'et_builder' ),
					'border_styles'          => array(
						'slide_footer' => array(
							'css'               => array(
								'main'      => array(
									'border_styles' => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info, .et-l div .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info, .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info.prodigy-account__menu-footer-user-info",
									'border_radii'  => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info, .et-l div .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info, .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-footer-user-info.prodigy-account__menu-footer-user-info",
									'important'     => 'all',
								),
								'important' => 'all',
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'important'         => 'all',
						),
						'important'    => 'all',
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-account__menu-footer-user-info, .et-l .prodigy-account__menu-footer-user-info",
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
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'slide_footer_user_name'      => array(
					'label'                  => esc_html__( 'Slide Footer Username', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name",
							'hover'                => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name:hover",
							'color'                => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name",
							'color_hover'          => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__name:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'slide_footer_user_email'     => array(
					'label'                  => esc_html__( 'Slide Footer Useremail', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email",
							'hover'                => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email:hover",
							'color'                => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email",
							'color_hover'          => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-account__menu-footer-user-info .prodigy-data-user__email:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'dropdown_heading'            => array(
					'label'                  => esc_html__( 'Dropdown Heading', 'et_builder' ),
					'border_styles'          => array(
						'dropdown_heading' => array(
							'css'               => array(
								'main'      => array(
									'border_styles' => "{$this->main_css_element} #et-boc .et-l div .prodigy-account__menu-header-dropdown, .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown, .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown",
									'border_radii'  => "{$this->main_css_element} #et-boc .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown, .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown, .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown",
									'important'     => 'all',
								),
								'important' => 'all',
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'important'         => 'all',
						),
						'important'        => 'all',
					),
					'margin_padding'         => array(
						'css' => array(
							'padding'   => "{$this->main_css_element} #et-boc .et-l div .prodigy-account__menu-header-dropdown, .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown, .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown",
							'margin'    => "{$this->main_css_element} #et-boc .et-l div .prodigy-account__menu-header-dropdown, .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown, .prodigy-dropdown-account__wrap .prodigy-account__menu-header-dropdown",
							'important' => 'all',
						),
					),
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'dropdown_heading_user_name'  => array(
					'label'                  => esc_html__( 'Dropdown Heading Username', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name",
							'hover'                => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name:hover",
							'color'                => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name",
							'color_hover'          => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__name:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'dropdown_heading_user_email' => array(
					'label'                  => esc_html__( 'Dropdown Heading Useremail', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email",
							'hover'                => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email:hover",
							'color'                => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email",
							'color_hover'          => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-account__menu-header-dropdown .prodigy-data-user__email:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'dropdown_footer'             => array(
					'label'                  => esc_html__( 'Dropdown Footer', 'et_builder' ),
					'border_styles'          => array(
						'dropdown_footer' => array(
							'css'               => array(
								'main'      => array(
									'border_styles' => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .et-l div .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer",
									'border_radii'  => "{$this->main_css_element} #et-boc .et-l div .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .et-l div .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer",
									'important'     => 'all',
								),
								'important' => 'all',
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'important'         => 'all',
						),
						'important'       => 'all',
					),
					'margin_padding'         => array(
						'css' => array(
							'padding'   => "{$this->main_css_element} .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .prodigy-dropdown-account__wrap .prodigy-account__menu-footer",
							'margin'    => "{$this->main_css_element} .et-l div .prodigy-dropdown-account__wrap .prodigy-account__menu-footer, .prodigy-dropdown-account__wrap .prodigy-account__menu-footer",
							'important' => 'all',
						),
					),
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => false,
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
			'my_account_style_link_value' => array(
				'label'            => esc_html__( 'Title', 'dicm-divi-custom-modules' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'default'          => 'Account',
				'toggle_slug'      => 'general',
				'computed_affects' => array(
					'__content',
				),
			),

			'my_account_style_widget' => array(
				'label'            => 'Widget Type',
				'toggle_slug'      => 'general',
				'option_category'  => 'basic_option',
				'default'          => '',
				'type'             => 'select',
				'options'          => array(
					self::WIDGET_TYPE_SLIDER   => 'Slider',
					self::WIDGET_TYPE_DROPDOWN => 'Dropdown',
				),
				'computed_affects' => array(
					'__content',
				),
			),

			'__content' => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'Divi_Prodigy_My_Account', 'get_view' ),
				'computed_depends_on' => array(
					'my_account_style_link_value',
					'my_account_style_widget',
					'general_alignment',
					'select_fonticon',
				),
			),
		);

		$tab                    = 'advanced';
		$custom_advanced_fields = array(
			'general_alignment'            => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					self::GENERAL_ALIGNMENT_LEFT   => 'Left',
					self::GENERAL_ALIGNMENT_CENTER => 'Center',
					self::GENERAL_ALIGNMENT_RIGHT  => 'Right',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'general',
				'default'     => self::GENERAL_ALIGNMENT_START,
			),
			'bottom_margin'                => array(
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
			'select_fonticon'              => array(
				'label'               => esc_html__( 'Select Font Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'tab_slug'            => $tab,
				'toggle_slug'         => 'link',
				'computed_affects'    => array(
					'__content',
				),
			),
			'text_transition_duration'     => array(
				'label'          => esc_html__( 'Text Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '300',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'link',
			),
			'icon_position'                => array(
				'label'       => esc_html__( 'Icon Position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'unset' => 'After',
					'13'    => 'Before',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'link',
				'default'     => '1',
			),
			'icon_spacing'                 => array(
				'label'          => esc_html__( 'Title spacing', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'link',
			),
			'icon_size'                    => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'link',
			),
			'link_text_color_hover'        => array(
				'label'       => 'Text Color Hover',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'link',
			),
			'menu_container_bg_color'      => array(
				'label'       => 'Background color',
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_container',
			),
			'badge_icon_color'             => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#a6abbc',
				'toggle_slug' => 'icon_badge',
			),
			'badge_icon_color_hover'       => array(
				'label'       => esc_html__( 'Icon color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#a6abbc',
				'toggle_slug' => 'icon_badge',
			),
			'badge_background_color'       => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#ebebeb',
				'toggle_slug' => 'icon_badge',
			),
			'badge_background_color_hover' => array(
				'label'       => esc_html__( 'Background color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#ebebeb',
				'toggle_slug' => 'icon_badge',
			),

			'badge_border_color'                      => array(
				'label'       => esc_html__( 'Border color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'icon_badge',
			),
			'badge_border_color_hover'                => array(
				'label'       => esc_html__( 'Border color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'currentColor',
				'toggle_slug' => 'icon_badge',
			),
			'badge_border_type'                       => array(
				'label'       => esc_html__( 'Border Type', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'border-style: solid !important;'  => 'solid',
					'border-style: none !important;'   => 'none',
					'border-style: groove !important;' => 'groove',
					'border-style: dashed !important;' => 'dashed',
					'border-style: double !important;' => 'double',
					'border-style: dotted !important;' => 'dotted',
					'border-style: ridge !important;'  => 'ridge',
					'border-style: inset !important;'  => 'inset',
					'border-style: outset !important;' => 'outset',
				),
				'tab_slug'    => $tab,
				'default'     => 'border-style: solid !important;',
				'toggle_slug' => 'icon_badge',
			),
			'badge_border_width'                      => array(
				'label'          => esc_html__( 'Border Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'icon_badge',
			),
			'badge_border_radius'                     => array(
				'label'          => esc_html__( 'Border Radius', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '50',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'icon_badge',
			),
			'badge_transition_duration'               => array(
				'label'          => esc_html__( 'Badge Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '300',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'icon_badge',
			),
			'badge_icon_transition_duration'          => array(
				'label'          => esc_html__( 'Icon Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '300',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'icon_badge',
			),
			'slide_title_text_color'                  => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_title',
			),
			'slide_title_margin_bottom'               => array(
				'label'          => esc_html__( 'Margin bottom', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '36',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_title',
			),
			'slide_title_border_color'                => array(
				'label'       => esc_html__( 'Border color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#e9eaee',
				'toggle_slug' => 'slide_title',
			),
			'slide_title_border_style'                => array(
				'label'       => esc_html__( 'Border Type', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'border-bottom-style: solid !important;'  => 'solid',
					'border-bottom-style: none !important;'   => 'none',
					'border-bottom-style: groove !important;' => 'groove',
					'border-bottom-style: dashed !important;' => 'dashed',
					'border-bottom-style: double !important;' => 'double',
					'border-bottom-style: dotted !important;' => 'dotted',
					'border-bottom-style: ridge !important;'  => 'ridge',
					'border-bottom-style: inset !important;'  => 'inset',
					'border-bottom-style: outset !important;' => 'outset',
				),
				'tab_slug'    => $tab,
				'default'     => 'border-bottom-style: solid !important;',
				'toggle_slug' => 'slide_title',
			),
			'slide_title_border_width'                => array(
				'label'          => esc_html__( 'Border Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_title',
			),
			'close_icon_size'                         => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_close',
			),
			'close_icon_color'                        => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_close',
			),
			'close_icon_color_hover'                  => array(
				'label'       => esc_html__( 'Icon color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_close',
			),
			'close_icon_transition_duration'          => array(
				'label'          => esc_html__( 'Icon Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '300',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'slide_close',
			),
			'account_item_alignment'                  => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'justify-content: flex-start !important;'    => 'Left',
					'justify-content: center !important;'        => 'Center',
					'justify-content: flex-end !important;'      => 'Right',
					'justify-content: space-between !important;' => 'Between',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'account_item',
				'default'     => 'justify-content: flex-start !important;',
			),
			'account_item_icon_position'              => array(
				'label'       => esc_html__( 'Icon Position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'flex-direction: row !important;'         => 'Before',
					'flex-direction: row-reverse !important;' => 'After',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'account_item',
				'default'     => 'flex-direction: row !important;',
			),
			'account_item_icon_spacing'               => array(
				'label'          => esc_html__( 'Icon spacing', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'account_item',
			),
			'account_item_icon_size'                  => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'account_item',
			),
			'account_item_text_color'                 => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'account_item',
			),
			'account_item_text_color_hover'           => array(
				'label'       => esc_html__( 'Text color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'account_item',
			),
			'account_item_icon_color'                 => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'account_item',
			),
			'account_item_icon_color_hover'           => array(
				'label'       => esc_html__( 'Icon color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'account_item',
			),
			'account_item_bg_color'                   => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'account_item',
			),
			'account_item_bg_color_hover'             => array(
				'label'       => esc_html__( 'Background color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'account_item',
			),
			'account_item_border_color_hover'         => array(
				'label'       => esc_html__( 'Border color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'account_item',
			),
			'account_item_transition_duration'        => array(
				'label'          => esc_html__( 'Item Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '300',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'account_item',
			),
			'slide_footer_alignment'                  => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'justify-content: flex-start !important;'    => 'Left',
					'justify-content: center !important;'        => 'Center',
					'justify-content: flex-end !important;'      => 'Right',
					'justify-content: space-between !important;' => 'Between',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'slide_footer',
				'default'     => 'justify-content: flex-start !important;',
			),
			'slide_footer_icon_position'              => array(
				'label'       => esc_html__( 'Icon Position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'flex-direction: row !important;'         => 'Before',
					'flex-direction: row-reverse !important;' => 'After',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'slide_footer',
				'default'     => 'flex-direction: row !important;',
			),
			'slide_footer_icon_spacing'               => array(
				'label'          => esc_html__( 'Icon spacing', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_footer',
			),
			'slide_footer_icon_size'                  => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_footer',
			),
			'slide_footer_icon_color'                 => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_footer',
			),
			'slide_footer_badge_background_color'     => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#ebebeb',
				'toggle_slug' => 'slide_footer',
			),
			'slide_footer_badge_border_color'         => array(
				'label'       => esc_html__( 'Border color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'slide_footer',
			),
			'slide_footer_badge_border_type'          => array(
				'label'       => esc_html__( 'Border Type', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'border-style: solid !important;'  => 'solid',
					'border-style: none !important;'   => 'none',
					'border-style: groove !important;' => 'groove',
					'border-style: dashed !important;' => 'dashed',
					'border-style: double !important;' => 'double',
					'border-style: dotted !important;' => 'dotted',
					'border-style: ridge !important;'  => 'ridge',
					'border-style: inset !important;'  => 'inset',
					'border-style: outset !important;' => 'outset',
				),
				'tab_slug'    => $tab,
				'default'     => 'border-style: solid !important;',
				'toggle_slug' => 'slide_footer',
			),
			'slide_footer_badge_border_width'         => array(
				'label'          => esc_html__( 'Border Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_footer',
			),
			'slide_footer_badge_border_radius'        => array(
				'label'          => esc_html__( 'Border Radius', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '50',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'slide_footer',
			),
			'slide_footer_user_name_text_color'       => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_footer_user_name',
			),
			'slide_footer_user_email_text_color'      => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'slide_footer_user_email',
			),
			'dropdown_heading_alignment'              => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'justify-content: flex-start !important;'    => 'Left',
					'justify-content: center !important;'        => 'Center',
					'justify-content: flex-end !important;'      => 'Right',
					'justify-content: space-between !important;' => 'Between',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'dropdown_heading',
				'default'     => 'justify-content: flex-start !important;',
			),
			'dropdown_heading_icon_position'          => array(
				'label'       => esc_html__( 'Icon Position', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'flex-direction: row !important;'         => 'Before',
					'flex-direction: row-reverse !important;' => 'After',
				),
				'tab_slug'    => $tab,
				'toggle_slug' => 'dropdown_heading',
				'default'     => 'flex-direction: row !important;',
			),
			'dropdown_heading_icon_spacing'           => array(
				'label'          => esc_html__( 'Icon spacing', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'dropdown_heading',
			),
			'dropdown_heading_icon_size'              => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'dropdown_heading',
			),
			'dropdown_heading_icon_color'             => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'dropdown_heading',
			),
			'dropdown_heading_badge_background_color' => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#ebebeb',
				'toggle_slug' => 'dropdown_heading',
			),
			'dropdown_heading_badge_border_color'     => array(
				'label'       => esc_html__( 'Border color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'dropdown_heading',
			),
			'dropdown_heading_badge_border_type'      => array(
				'label'       => esc_html__( 'Border Type', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'border-style: solid !important;'  => 'solid',
					'border-style: none !important;'   => 'none',
					'border-style: groove !important;' => 'groove',
					'border-style: dashed !important;' => 'dashed',
					'border-style: double !important;' => 'double',
					'border-style: dotted !important;' => 'dotted',
					'border-style: ridge !important;'  => 'ridge',
					'border-style: inset !important;'  => 'inset',
					'border-style: outset !important;' => 'outset',
				),
				'tab_slug'    => $tab,
				'default'     => 'border-style: solid !important;',
				'toggle_slug' => 'dropdown_heading',
			),
			'dropdown_heading_badge_border_width'     => array(
				'label'          => esc_html__( 'Border Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'dropdown_heading',
			),
			'dropdown_heading_badge_border_radius'    => array(
				'label'          => esc_html__( 'Border Radius', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '50',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'dropdown_heading',
			),
			'dropdown_heading_user_name_text_color'   => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'dropdown_heading_user_name',
			),
			'dropdown_heading_user_email_text_color'  => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#303036',
				'toggle_slug' => 'dropdown_heading_user_email',
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
		if ( $this->props['general_alignment'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account__wrap',
					'declaration' => esc_html( $this->props['general_alignment'] ),
				)
			);
		}

		if ( $this->props['bottom_margin'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account__wrap',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['bottom_margin'] )
					),
				)
			);
		}

		if ( $this->props['icon_position'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						'order: %1$s !important;',
						esc_html( $this->props['icon_position'] )
					),
				)
			);
		}

		if ( $this->props['icon_spacing'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $this->props['icon_spacing'] )
					),
				)
			);
		}

		if ( $this->props['icon_size'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account .prodigy-navbar-user > .prodigy-navbar-account__icon',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['icon_size'] )
					),
				)
			);
		}

		if ( $this->props['link_text_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account__wrap:hover .prodigy-navbar-user__status',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['link_text_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['badge_icon_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-navbar-user',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['badge_icon_color'] )
					),
				)
			);
		}

		if ( $this->props['badge_icon_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-navbar-user:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['badge_icon_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['badge_background_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account .prodigy-navbar-user',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['badge_background_color'] )
					),
				)
			);
		}

		if ( $this->props['badge_background_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account:hover .prodigy-navbar-user',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['badge_background_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['badge_border_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['badge_border_color'] )
					),
				)
			);
		}

		if ( $this->props['badge_border_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['badge_border_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['badge_border_type'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						esc_html( $this->props['badge_border_type'] )
					),
				)
			);
		}

		if ( $this->props['badge_border_width'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-width: %1$spx !important;',
						esc_html( $this->props['badge_border_width'] )
					),
				)
			);
		}

		if ( $this->props['badge_border_radius'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-radius: %1$spx !important;',
						esc_html( $this->props['badge_border_radius'] )
					),
				)
			);
		}

		if ( $this->props['text_transition_duration'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account__wrap .prodigy-navbar-user__status',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['text_transition_duration'] )
					),
				)
			);
		}

		if ( $this->props['badge_transition_duration'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account > .prodigy-navbar-user',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['badge_transition_duration'] )
					),
				)
			);
		}

		if ( $this->props['slide_title_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%  #et-boc .et-l div .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title, .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slide_title_text_color'] )
					),
				)
			);
		}

		if ( $this->props['close_icon_size'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account-slide__header-close',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['close_icon_size'] )
					),
				)
			);
		}

		if ( $this->props['close_icon_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account-slide__header-close',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['close_icon_color'] )
					),
				)
			);
		}

		if ( $this->props['close_icon_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account-slide__header-close:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['close_icon_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['close_icon_transition_duration'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account-slide__header-close',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['close_icon_transition_duration'] )
					),
				)
			);
		}

		if ( $this->props['slide_title_margin_bottom'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-body',
					'declaration' => sprintf(
						'padding-top: %1$spx !important;',
						esc_html( $this->props['slide_title_margin_bottom'] )
					),
				)
			);
		}

		if ( $this->props['slide_title_border_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after',
					'declaration' => sprintf(
						'border-bottom-color: %1$s !important;',
						esc_html( $this->props['slide_title_border_color'] )
					),
				)
			);
		}

		if ( $this->props['slide_title_border_width'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after',
					'declaration' => sprintf(
						'border-bottom-width: %1$spx !important;',
						esc_html( $this->props['slide_title_border_width'] )
					),
				)
			);
		}

		if ( $this->props['slide_title_border_style'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after',
					'declaration' => sprintf(
						esc_html( $this->props['slide_title_border_style'] )
					),
				)
			);
		}

		if ( $this->props['account_item_alignment'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item',
					'declaration' => esc_html( $this->props['account_item_alignment'] ),
				)
			);
		}

		if ( $this->props['account_item_icon_position'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item',
					'declaration' => esc_html( $this->props['account_item_icon_position'] ),
				)
			);
		}

		if ( $this->props['account_item_icon_spacing'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $this->props['account_item_icon_spacing'] )
					),
				)
			);
		}

		if ( $this->props['account_item_icon_size'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item svg',
					'declaration' => sprintf(
						'width: %1$spx !important; height: %1$spx !important;',
						esc_html( $this->props['account_item_icon_size'] )
					),
				)
			);
		}

		if ( $this->props['account_item_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item .prodigy-account__menu-item-name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['account_item_text_color'] )
					),
				)
			);
		}

		if ( $this->props['account_item_text_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item:hover .prodigy-account__menu-item-name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['account_item_text_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['account_item_icon_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item .prodigy-custom-fill',
					'declaration' => sprintf(
						'fill: %1$s !important;',
						esc_html( $this->props['account_item_icon_color'] )
					),
				)
			);
		}

		if ( $this->props['account_item_icon_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item:hover .prodigy-custom-fill',
					'declaration' => sprintf(
						'fill: %1$s !important;',
						esc_html( $this->props['account_item_icon_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['account_item_bg_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['account_item_bg_color'] )
					),
				)
			);
		}

		if ( $this->props['account_item_bg_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['account_item_bg_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['account_item_border_color_hover'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['account_item_border_color_hover'] )
					),
				)
			);
		}

		if ( $this->props['account_item_transition_duration'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-item, .prodigy-account__menu-item-name, .prodigy-custom-fill',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['account_item_transition_duration'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_alignment'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info',
					'declaration' => esc_html( $this->props['slide_footer_alignment'] ),
				)
			);
		}

		if ( $this->props['slide_footer_icon_position'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info',
					'declaration' => esc_html( $this->props['slide_footer_icon_position'] ),
				)
			);
		}

		if ( $this->props['slide_footer_icon_spacing'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $this->props['slide_footer_icon_spacing'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_icon_size'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info svg',
					'declaration' => sprintf(
						'width: %1$spx !important; height: %1$spx !important;',
						esc_html( $this->props['slide_footer_icon_size'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_icon_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-custom-fill',
					'declaration' => sprintf(
						'fill: %1$s !important;',
						esc_html( $this->props['slide_footer_icon_color'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_badge_background_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-navbar-user',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['slide_footer_badge_background_color'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_badge_border_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['slide_footer_badge_border_color'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_badge_border_type'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-navbar-user',
					'declaration' => sprintf(
						esc_html( $this->props['slide_footer_badge_border_type'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_badge_border_width'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-width: %1$spx !important;',
						esc_html( $this->props['slide_footer_badge_border_width'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_badge_border_radius'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-radius: %1$spx !important;',
						esc_html( $this->props['slide_footer_badge_border_radius'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_user_name_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info p.prodigy-data-user__name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slide_footer_user_name_text_color'] )
					),
				)
			);
		}

		if ( $this->props['slide_footer_user_email_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-footer-user-info p.prodigy-data-user__email',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['slide_footer_user_email_text_color'] )
					),
				)
			);
		}

		if ( $this->props['menu_container_bg_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['menu_container_bg_color'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_alignment'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown > div',
					'declaration' => esc_html( $this->props['dropdown_heading_alignment'] ),
				)
			);
		}

		if ( $this->props['dropdown_heading_icon_position'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown > div',
					'declaration' => esc_html( $this->props['dropdown_heading_icon_position'] ),
				)
			);
		}

		if ( $this->props['dropdown_heading_icon_spacing'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown > div',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $this->props['dropdown_heading_icon_spacing'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_icon_size'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown svg',
					'declaration' => sprintf(
						'width: %1$spx !important; height: %1$spx !important;',
						esc_html( $this->props['dropdown_heading_icon_size'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_icon_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-custom-fill',
					'declaration' => sprintf(
						'fill: %1$s !important;',
						esc_html( $this->props['dropdown_heading_icon_color'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_badge_background_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-navbar-user',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['dropdown_heading_badge_background_color'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_badge_border_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['dropdown_heading_badge_border_color'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_badge_border_type'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-navbar-user',
					'declaration' => sprintf(
						esc_html( $this->props['dropdown_heading_badge_border_type'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_badge_border_width'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-width: %1$spx !important;',
						esc_html( $this->props['dropdown_heading_badge_border_width'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_badge_border_radius'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown .prodigy-navbar-user',
					'declaration' => sprintf(
						'border-radius: %1$spx !important;',
						esc_html( $this->props['dropdown_heading_badge_border_radius'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_user_name_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown p.prodigy-data-user__name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['dropdown_heading_user_name_text_color'] )
					),
				)
			);
		}

		if ( $this->props['dropdown_heading_user_email_text_color'] !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-account__menu-header-dropdown p.prodigy-data-user__email',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['dropdown_heading_user_email_text_color'] )
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
		$icon_data = explode( '||', $args['select_fonticon'] ?? null );
		if ( ! empty( $args['my_account_icon_url'] ) ) {
			$attr['icon_type'] = 'svg';
		}

		$attr['icon_class'] = $args['my_account_icon'] ?? 'icon icon-user';

		if ( isset( $icon_data[1], $icon_data[0], $icon_data[2] ) ) {
			$attr['icon_type']   = $icon_data[1];
			$attr['icon_utf']    = $icon_data[0];
			$attr['icon_weight'] = $icon_data[2];
		}
		$attr['heading_text'] = $args['my_account_style_link_value'] ?? 'Account';

		if ( $args['my_account_style_widget'] === self::WIDGET_TYPE_DROPDOWN ) {
			$attr['container_class'] = 'prodigy-dropdown-account__wrap';
			if ( $args['general_alignment'] === self::GENERAL_ALIGNMENT_START ) {
				$attr['container_class'] .= ' prodigy-dropdown-account__drop-right';
			}
			if ( $args['general_alignment'] === self::GENERAL_ALIGNMENT_CENTER ) {
				$attr['container_class'] .= ' prodigy-dropdown-account__drop-center';
			}
		}

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
		$args   = $widget->set_widget_parameters( $args );

		return $widget->render_view( $args );
	}

	/**
	 * @param array $attr
	 *
	 * @return string
	 */
	public function render_view( array $attr ): string {
		ob_start();
		do_action( 'prodigy_shortcode_template_my_account', $attr );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}


	/**
	 * @param array $attrs
	 * @param string $content
	 * @param string $render_slug
	 *
	 * @return string
	 */
	public function render( $attrs, $content, $render_slug ): string {
		$this->custom_adjustments( $render_slug );
		$args = $this->set_widget_parameters( $this->props );

		return $this->render_view( $args );
	}
}

new Divi_Prodigy_My_Account();
