<?php

/**
 * Divi_Prodigy_Cart class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Cart extends ET_Builder_Module {

	/** @var $mapper array */
	public $mapper = array(
		'on'  => 'yes',
		'off' => 'no',
		''    => 'yes',
	);

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->slug             = 'divi_prodigy_cart';
		$this->vb_support       = 'on';
		$this->name             = esc_html( 'Prodigy Cart' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Cart.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'general'            => et_builder_i18n( 'General' ),
					'menu_icon'          => et_builder_i18n( 'Menu Icon' ),
					'empty_cart_message' => et_builder_i18n( 'Empty Cart Message' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'general'                          => et_builder_i18n( 'General' ),
					'menu_cart_button'                 => et_builder_i18n( 'General Cart Button' ),
					'menu_icon'                        => et_builder_i18n( 'Menu Icon' ),
					'items_indicator'                  => et_builder_i18n( 'Items Indicator' ),
					'cart_heading'                     => et_builder_i18n( 'Cart Heading' ),
					'cart_close'                       => et_builder_i18n( 'Close Cart' ),
					'cart_remove_item'                 => et_builder_i18n( 'Remove Item' ),
					'subtotal'                         => et_builder_i18n( 'Subtotal' ),
					'cart_subtotal_text'               => et_builder_i18n( 'Cart Subtotal Text' ),
					'cart_subtotal_value'              => et_builder_i18n( 'Cart Subtotal Value' ),
					'products_box'                     => et_builder_i18n( 'Products Box' ),
					'products_title'                   => et_builder_i18n( 'Products Title' ),
					'products_quantity'                => et_builder_i18n( 'Products Quantity' ),
					'products_price'                   => et_builder_i18n( 'Products Price' ),
					'products_subscription_label'      => et_builder_i18n( 'Products Subscription Label' ),
					'products_subscription_conditions' => et_builder_i18n( 'Products Subscription Condition' ),
					'products_subscription_condition_value' => et_builder_i18n( 'Products Subscription Condition Value' ),
					'products_subscription_tooltip'    => et_builder_i18n( 'Products Subscription Tooltip' ),
					'products_attribute_name'          => et_builder_i18n( 'Products Attribute Name' ),
					'products_attribute_value'         => et_builder_i18n( 'Products Attribute Value' ),
					'view_cart_button'                 => et_builder_i18n( 'Cart Button' ),
					'checkout_button'                  => et_builder_i18n( 'Checkout Button' ),
					'empty_cart_message'               => et_builder_i18n( 'Empty Cart Message' ),
				),
			),
		);

		$this->advanced_fields = array(
			'form_field' => array(
				'menu_cart_button'                      => array(
					'label'                  => esc_html__( 'Menu Cart Button', 'et_builder' ),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__toggle, #et-boc .et-l div .prodigy-cart__toggle",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'border_styles'          => false,
					'text_color'             => true,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt",
							'hover'                => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover",
							'color'                => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover, #et-boc .et-l div .prodigy-cart__toggle .prodigy-navbar-cart__txt:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),

				'items_indicator'                       => array(
					'label'                  => esc_html__( 'Items Indicator', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count",
							'hover'                => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count:hover, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count:hover",
							'color'                => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count:hover, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__toggle >span.prodigy-navbar-cart__count:hover, #et-boc .et-l div .prodigy-cart__toggle >.prodigy-navbar-cart__count:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),

				'cart_heading'                          => array(
					'label'                  => esc_html__( 'Heading', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => true,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__title:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),

				'cart_subtotal_text'                    => array(
					'label'                  => esc_html__( 'Cart Subtotal Text', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt, span.prodigy-cart-total__text",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt:hover, span.prodigy-cart-total__text:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt, span.prodigy-cart-total__text",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt:hover, span.prodigy-cart-total__text:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt, span.prodigy-cart-total__text",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-text.prodigy-widget__subtotal-txt:hover, span.prodigy-cart-total__text:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),

				'cart_subtotal_value'                   => array(
					'label'                  => esc_html__( 'Cart Subtotal Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value:hover, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value:hover, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template span.prodigy-widget__subtotal-txt-price.prodigy-cart-total__value:hover, span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),

				'subtotal'                              => array(
					'label'                  => esc_html__( 'Subtotal', 'et_builder' ),
					'border_styles'          => array(
						'subtotal' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-total.prodigy-cart-total__widget-subtotal, #et-boc .et-l div .prodigy-cart-total.prodigy-cart-total__widget-subtotal",
									'border_radii'  => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-total.prodigy-cart-total__widget-subtotal, #et-boc .et-l div .prodigy-cart-total.prodigy-cart-total__widget-subtotal",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-total",
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
				),
				'products_box'                          => array(
					'label'                  => esc_html__( 'Products Box', 'et_builder' ),
					'border_styles'          => array(
						'products_box' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-cart-item.prodigy-cart-item__widget-item, #et-boc .et-l div .prodigy-cart-item.prodigy-cart-item__widget-item",
									'border_radii'  => "{$this->main_css_element} .prodigy-cart-item.prodigy-cart-item__widget-item, #et-boc .et-l div .prodigy-cart-item.prodigy-cart-item__widget-item",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item",
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
				),
				'products_title'                        => array(
					'label'                  => esc_html__( 'Products Title', 'et_builder' ),
					'border_styles'          => false,
					'box_shadow'             => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title, #et-boc .et-l a.prodigy-cart-item__info-title",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title:hover, #et-boc .et-l a.prodigy-cart-item__info-title",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title, #et-boc .et-l a.prodigy-cart-item__info-title",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title:hover, #et-boc .et-l a.prodigy-cart-item__info-title",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title, #et-boc .et-l a.prodigy-cart-item__info-title",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item a.prodigy-cart-item__info-title:hover, #et-boc .et-l a.prodigy-cart-item__info-title",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
				'products_quantity'                     => array(
					'label'                  => esc_html__( 'Products Quantity', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item .prodigy-cart-item__info-price",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count:hover, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count:hover, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__count:hover, #et-boc .et-l .prodigy-cart-item__info-price__count",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
				),
				'products_price'                        => array(
					'label'                  => esc_html__( 'Products Price', 'et_builder' ),
					'border_styles'          => false,
					'background_color'       => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value:hover, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value:hover, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-price__value:hover, #et-boc .et-l .prodigy-cart-item__info-price__value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
				),
				'products_subscription_conditions'      => array(
					'label'                  => esc_html__( 'Products Subscription Conditions', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__condition",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'color'                => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template span.prodigy-cart-item-subscr__condition",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
				),
				'products_subscription_condition_value' => array(
					'label'                  => esc_html__( 'Products Subscription Condition Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
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
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item-subscr__value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
				),
				'products_subscription_label'           => array(
					'label'                  => esc_html__( 'Products Subscription Label', 'et_builder' ),
					'border_styles'          => array(
						'products_subscription_label' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
									'border_radii'  => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__body .prodigy-cart-item__info .prodigy-cart-item__tag",
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
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'products_subscription_tooltip'         => array(
					'label'                  => esc_html__( 'Subscription Tooltip', 'et_builder' ),
					'border_styles'          => array(
						'products_subscription_tooltip' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l .prodigy-tooltip > span.prodigy-tooltip__message,.prodigy-custom-template .prodigy-tooltip__message",
									'border_radii'  => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l .prodigy-tooltip > span.prodigy-tooltip__message,.prodigy-custom-template .prodigy-tooltip__message",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'focus_background_color' => false,
					'text_color'             => false,
					'background_color'       => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-tooltip__message",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
				),

				'products_attribute_name'               => array(
					'label'                  => esc_html__( 'Attribute Name', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__name",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),

				'products_attribute_value'              => array(
					'label'                  => esc_html__( 'Attribute Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__info-variants__value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
				'view_cart_button'                      => array(
					'label'                  => esc_html__( 'Cart Button', 'et_builder' ),
					'border_styles'          => array(
						'view_cart_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn, #et-boc .et-l div a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
									'border_radii'  => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn, #et-boc .et-l div a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'hover'                => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'color'                => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'color_hover'          => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'letter_spacing'       => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'letter_spacing_hover' => "{$this->main_css_element} a.prodigy-main-button.prodigy-main-button--outline.prodigy-cart__cart-btn",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
				'checkout_button'                       => array(
					'label'                  => esc_html__( 'Checkout Button', 'et_builder' ),
					'border_styles'          => array(
						'checkout_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} button.prodigy-main-button.prodigy-cart__checkout-btn, #et-boc .et-l div button.prodigy-main-button.prodigy-cart__checkout-btn",
									'border_radii'  => "{$this->main_css_element} button.prodigy-main-button.prodigy-cart__checkout-btn, #et-boc .et-l div button.prodigy-main-button.prodigy-cart__checkout-btn",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => false,
					'box_shadow'             => false,
					'background_color'       => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart__checkout-btn",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
				'empty_cart_message'                    => array(
					'label'                  => esc_html__( 'Empty Cart Message', 'et_builder' ),
					'border_styles'          => array(
						'empty_cart_message' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty, #et-boc .et-l div .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty",
									'border_radii'  => "{$this->main_css_element} .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty, #et-boc .et-l div .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty",
							'important' => 'all',
						),
						'use_margin' => false,
					),
					'text_color'             => true,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty, .prodigy-cart-dropdown__alert .icon.icon-info, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty:hover, .prodigy-cart-dropdown__alert .icon.icon-info:hover, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty, .prodigy-cart-dropdown__alert .icon.icon-info, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty:hover, .prodigy-cart-dropdown__alert .icon.icon-info:hover, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty, .prodigy-cart-dropdown__alert .icon.icon-info, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-dropdown__alert.prodigy-cart-dropdown__alert-empty:hover, .prodigy-cart-dropdown__alert .icon.icon-info:hover, #et-boc .et-l div .prodigy-cart-dropdown__alert .icon.icon-info:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
			),
		);
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		$basic_fields = array(
			'cart_type'               => array(
				'label'            => 'Cart Type',
				'type'             => 'select',
				'options'          => array(
					'dropdown-cart' => 'Dropdown',
					'slide-cart'    => 'Slide',
				),
				'default_on_front' => 'dropdown-cart',
				'description'      => 'You should turn on the Customizer Menu Cart if you are using this widget. To do this, proceed to the Appearance -> Customize -> Prodigy -> General',
				'toggle_slug'      => 'general',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__content',
				),
			),

			'cart_text_value'         => array(
				'type'             => 'text',
				'default_on_front' => 'SHOPPING CART',
				'toggle_slug'      => 'general',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__content',
				),
			),

			'cart_position'           => array(
				'label'            => esc_html__( 'Cart Position', 'et_builder' ),
				'type'             => 'select',
				'options'          => array(
					'justify-content: center !important;' => 'Center',
					'justify-content: flex-end !important;'         => 'Right',
					'justify-content: flex-start !important;'       => 'Left',
				),
				'toggle_slug'      => 'general',
				'option_category'  => 'basic_option',
				'default'          => 'justify-content: flex-start !important;',
				'computed_affects' => array(
					'__content',
				),
			),
			'automatically_open_cart' => array(
				'label'            => 'Automatically Open Cart',
				'type'             => 'select',
				'options'          => array(
					'1' => 'Yes',
					'0' => 'No',
				),
				'description'      => 'Open the cart every time an item is added.',
				'toggle_slug'      => 'general',
				'option_category'  => 'basic_option',
				'default_on_front' => '1',
				'computed_affects' => array(
					'__content',
				),
			),

			'select_fonticon'         => array(
				'label'               => esc_html__( 'Select Font Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'toggle_slug'         => 'menu_icon',
				'option_category'     => 'basic_option',
				'computed_affects'    => array(
					'__content',
				),
			),

			'menu_icon_position'      => array(
				'label'            => esc_html__( 'Icon Position', 'et_builder' ),
				'type'             => 'select',
				'options'          => array(
					'13' => 'Before',
					'-1' => 'After',
				),
				'toggle_slug'      => 'menu_icon',
				'option_category'  => 'basic_option',
				'default'          => '-1',
				'computed_affects' => array(
					'__content',
				),
			),

			'items_indicator'         => array(
				'label'            => 'Items Indicator',
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'menu_icon',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__content',
				),
			),

			'hide_empty'              => array(
				'label'            => esc_html__( 'Hide Empty', 'et_builder' ),
				'type'             => 'select',
				'options'          => array(
					'1' => 'Yes',
					'0' => 'No',
				),
				'toggle_slug'      => 'menu_icon',
				'option_category'  => 'basic_option',
				'default'          => '1',
				'computed_affects' => array(
					'__content',
				),
			),

			'empty_cart_message_text' => array(
				'type'             => 'text',
				'default_on_front' => 'No products added yet',
				'toggle_slug'      => 'empty_cart_message',
				'option_category'  => 'basic_option',
				'computed_affects' => array(
					'__content',
				),
			),

			'__content'               => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'Divi_Prodigy_Cart', 'get_view' ),
				'computed_depends_on' => array(
					'cart_type',
					'general_bottom_margin',
					'automatically_open_cart',
					'select_fonticon',
					'menu_icon_position',
					'items_indicator',
					'hide_empty',
					'cart_heading',
					'empty_cart_message_text',
					'cart_text_value',
				),
			),
		);

		$tab                    = 'advanced';
		$custom_advanced_fields = array(
			'general_bottom_margin'                        => array(
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

			'menu_cart_button_position'                    => array(
				'label'       => esc_html__( 'Overlay Position Horizontal', 'et_builder' ),
				'type'        => 'select',
				'description' => 'Determines the position of the overlay with the category link',
				'options'     => array(
					'left: 50% !important; transform: translateX(-50%) !important;right: auto !important;' => 'Center',
					'left:  12px !important; right: auto !important;'                                      => 'Right',
					'right: 12px !important;' => 'Left',
				),
				'tab_slug'    => $tab,
				'default'     => 'right: -12px !important;',
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_pointer_position'            => array(
				'label'       => esc_html__( 'Pointer Position Horizontal', 'et_builder' ),
				'type'        => 'select',
				'description' => 'Determines the position of the pointer on top of the dropdown',
				'options'     => array(
					'left: 50% !important; transform: translateX(-50%) !important;right: auto !important;'  => 'Center',
					'right: 32px !important;' => 'Right',
					'left: 32px !important;right: auto !important;'                                       => 'Left',
				),
				'tab_slug'    => $tab,
				'default'     => 'left: 32px !important;right: auto !important;',
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_duration'                    => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'menu_cart_button',
			),

			'menu_cart_button_icon_color'                  => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_icon_color_hover'            => array(
				'label'       => esc_html__( 'Icon color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_text_color'                  => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_text_color_hover'            => array(
				'label'       => esc_html__( 'Text color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_background_color'            => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),
			'menu_cart_button_background_color_hover'      => array(
				'label'       => esc_html__( 'Background color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'menu_cart_button',
			),

			'menu_cart_button_border_color'                => array(
				'label'       => esc_html__( 'Border color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => 'transparent',
				'toggle_slug' => 'menu_cart_button',
			),
			'menu_cart_button_border_color_hover'          => array(
				'label'       => esc_html__( 'Border color on hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'default'     => '#a6abbc',
				'toggle_slug' => 'menu_cart_button',
			),
			'menu_cart_button_border_type'                 => array(
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
				'toggle_slug' => 'menu_cart_button',
			),
			'menu_cart_button_border_width'                => array(
				'label'          => esc_html__( 'Border Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'menu_cart_button',
			),
			'menu_cart_button_border_radius'               => array(
				'label'          => esc_html__( 'Border Radius', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '20',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'menu_cart_button',
			),

			'menu_icon_spacing'                            => array(
				'label'          => esc_html__( 'Icon Spacing', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'menu_icon',
			),

			'menu_icon_size'                               => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'menu_icon',
			),

			'items_indicator_background_color'             => array(
				'label'       => esc_html__( 'Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'items_indicator',
			),

			'items_indicator_background_color_hover'       => array(
				'label'       => esc_html__( 'Background color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'items_indicator',
			),

			'items_indicator_text_color'                   => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'items_indicator',
			),

			'items_indicator_height'                       => array(
				'label'          => esc_html__( 'Height', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'items_indicator',
			),

			'items_indicator_width'                        => array(
				'label'          => esc_html__( 'Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '24',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'items_indicator',
			),
			'items_indicator_border_radius'                => array(
				'label'          => esc_html__( 'Border Radius', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '20',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'items_indicator',
			),
			'items_indicator_position_vertical'            => array(
				'label'       => esc_html__( 'Position Vertical', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'top: -14px !important;bottom: auto !important;' => 'Top',
					'bottom: -14px !important;top: auto !important;' => 'Bottom',
				),
				'tab_slug'    => $tab,
				'default'     => 'top: -14px !important;bottom: auto !important;',
				'toggle_slug' => 'items_indicator',
			),

			'items_indicator_position_vertical_distance'   => array(
				'label'          => esc_html__( 'Position Vertical Distance', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'items_indicator',
			),

			'items_indicator_position_horizontal'          => array(
				'label'       => esc_html__( 'Position Horizontal', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'left: auto !important;right: 0 !important;'   => 'Right',
					'left: 0px !important;right: auto !important;' => 'Left',
				),
				'tab_slug'    => $tab,
				'default'     => 'left: auto !important;right: 0 !important;',
				'toggle_slug' => 'items_indicator',
			),

			'items_indicator_position_horizontal_distance' => array(
				'label'          => esc_html__( 'Position Horizontal Distance', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'items_indicator',
			),

			'cart_heading_position'                        => array(
				'label'       => esc_html__( 'Alignment', 'et_builder' ),
				'type'        => 'select',
				'options'     => array(
					'text-align: center !important;' => 'Center',
					'text-align: right !important;'  => 'Right',
					'text-align: left !important;'   => 'Left',
				),
				'default'     => 'text-align: left !important;',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_heading',
			),

			'cart_heading_text_color'                      => array(
				'label'       => esc_html__( 'Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_heading',
			),

			'cart_heading_bottom_margin'                   => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'toggle_slug'    => 'cart_heading',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'cart_close_icon_size'                         => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '12',
				'toggle_slug'    => 'cart_close',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'cart_close_icon_color'                        => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_close',
			),

			'cart_close_icon_color_hover'                  => array(
				'label'       => esc_html__( 'Icon Hover color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_close',
			),

			'cart_remove_item_icon_color'                  => array(
				'label'       => esc_html__( 'Icon color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_remove_item',
			),

			'cart_remove_item_icon_size'                   => array(
				'label'          => esc_html__( 'Icon Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'toggle_slug'    => 'cart_remove_item',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'subtotal_bottom_margin'                       => array(
				'label'          => esc_html__( 'Subtotal Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'subtotal',
			),

			'subtotal_background_color'                    => array(
				'label'       => esc_html__( 'Subtotal Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal',
			),

			'subtotal_background_color_hover'              => array(
				'label'       => esc_html__( 'Subtotal Background color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal',
			),

			'subtotal_border_color_hover'                  => array(
				'label'       => esc_html__( 'Subtotal Border color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal',
			),

			'cart_subtotal_text_color'                     => array(
				'label'       => esc_html__( 'Subtotal Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_subtotal_text',
			),
			'cart_subtotal_value_color'                    => array(
				'label'       => esc_html__( 'Subtotal Value color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'cart_subtotal_value',
			),
			'products_box_background_color'                => array(
				'label'       => esc_html__( 'Products Box Background color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_box',
			),

			'products_box_background_color_hover'          => array(
				'label'       => esc_html__( 'Products Box Background color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_box',
			),

			'products_box_border_color_hover'              => array(
				'label'       => esc_html__( 'Products Box Border color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_box',
			),

			'products_title_bottom_margin'                 => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_title',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'products_title_text_color'                    => array(
				'label'       => esc_html__( 'Products Title color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_title',
			),

			'products_title_text_color_hover'              => array(
				'label'       => esc_html__( 'Products Title color hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_title',
			),

			'products_quantity_bottom_margin'              => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_quantity',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'products_quantity_text_color'                 => array(
				'label'       => esc_html__( 'Products Quantity Text color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_quantity',
			),

			'products_price_left_margin'                   => array(
				'label'          => esc_html__( 'Left Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_price',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'products_price_text_color'                    => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_price',
			),

			'subscription_label_bottom_margin'             => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_subscription_label',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'subscription_label_text_color'                => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_label',
			),

			'subscription_label_background_color'          => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_label',
			),

			'subscription_label_background_color_hover'    => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_label',
			),

			'subscription_conditions_bottom_margin'        => array(
				'label'          => esc_html__( 'Bottom Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_subscription_conditions',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'subscription_conditions_right_margin'         => array(
				'label'          => esc_html__( 'Right Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '8',
				'toggle_slug'    => 'products_subscription_conditions',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),

			'subscription_conditions_text_color'           => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_conditions',
			),

			'subscription_conditions_value_text_color'     => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_condition_value',
			),

			'subscription_tooltip_icon_font_size'          => array(
				'label'          => esc_html__( 'Icon Font Size', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'products_subscription_tooltip',
			),

			'subscription_tooltip_icon_color'              => array(
				'label'       => esc_html__( 'Icon Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_tooltip',
			),

			'subscription_tooltip_icon_color_hover'        => array(
				'label'       => esc_html__( 'Icon Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_tooltip',
			),

			'subscription_tooltip_icon_transition_duration' => array(
				'label'          => esc_html__( 'Icon Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'products_subscription_tooltip',
			),

			'subscription_tooltip_background_color'        => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_tooltip',
			),

			'subscription_tooltip_text_color'              => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_subscription_tooltip',
			),

			'products_attribute_name_margin_bottom'        => array(
				'label'          => esc_html__( 'Margin Bottom', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '0',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'products_attribute_name',
			),

			'products_attribute_name_text_color'           => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_attribute_name',
			),

			'products_attribute_name_margin_right'         => array(
				'label'          => esc_html__( 'Margin Right', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '4',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'products_attribute_name',
			),

			'products_attribute_value_text_color'          => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_attribute_value',
			),

			'view_cart_button_button_duration'             => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'view_cart_button',
			),

			'view_cart_button_bottom_margin'               => array(
				'label'          => esc_html__( 'Margin Bottom', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '16',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'view_cart_button',
			),

			'view_cart_text_color'                         => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'view_cart_button',
			),

			'view_cart_background_color'                   => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'view_cart_button',
			),

			'view_cart_text_color_hover'                   => array(
				'label'       => esc_html__( 'Text Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'view_cart_button',
			),

			'view_cart_background_color_hover'             => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'view_cart_button',
			),

			'view_cart_border_color_hover'                 => array(
				'label'       => esc_html__( 'Border Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'view_cart_button',
			),

			'checkout_cart_border_color_hover'             => array(
				'label'       => esc_html__( 'Border Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'checkout_button',
			),

			'checkout_button_button_duration'              => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '100',
				),
				'toggle_slug'    => 'checkout_button',
			),

			'checkout_button_text_color'                   => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'checkout_button',
			),

			'checkout_button_background_color'             => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'checkout_button',
			),

			'checkout_button_text_color_hover'             => array(
				'label'       => esc_html__( 'Text Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'checkout_button',
			),

			'checkout_button_background_color_hover'       => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'checkout_button',
			),

			'empty_cart_message_text_color'                => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'empty_cart_message',
			),

			'empty_cart_message_background_color'          => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'empty_cart_message',
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

		if ( '' !== $this->props['general_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['general_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_icon_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-navbar-cart__txt',
					'declaration' => sprintf(
						'order: %1$s !important;',
						esc_html( $this->props['menu_icon_position'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__menu',
					'declaration' => esc_html( $this->props['menu_cart_button_position'] ),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_pointer_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%%  .prodigy-custom-template .prodigy-cart-dropdown__main:before',
					'declaration' => esc_html( $this->props['menu_cart_button_pointer_position'] ),
                )
            );
		}

		if ( '' !== $this->props['cart_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template',
					'declaration' => esc_html( $this->props['cart_position'] ),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_duration'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['menu_cart_button_duration'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_icon_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle .prodigy-navbar-cart__icon',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_icon_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_icon_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle:hover .prodigy-navbar-cart__icon',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_icon_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle .prodigy-navbar-cart__txt',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle:hover .prodigy-navbar-cart__txt',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_text_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_border_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_border_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_border_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['menu_cart_button_border_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_cart_border_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% button.prodigy-main-button.prodigy-cart__checkout-btn:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['checkout_cart_border_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_border_type'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle',
					'declaration' => sprintf(
						esc_html( $this->props['menu_cart_button_border_type'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_border_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle',
					'declaration' => sprintf(
						'border-width: %1$spx !important;',
						esc_html( $this->props['menu_cart_button_border_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_cart_button_border_radius'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle',
					'declaration' => sprintf(
						'border-radius: %1$spx !important;',
						esc_html( $this->props['menu_cart_button_border_radius'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_icon_spacing'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__toggle',
					'declaration' => sprintf(
						'column-gap: %1$spx !important;',
						esc_html( $this->props['menu_icon_spacing'] )
					),
                )
            );
		}

		if ( '' !== $this->props['menu_icon_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-navbar-cart__icon',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['menu_icon_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['items_indicator_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart__toggle:hover span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['items_indicator_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['items_indicator_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_width'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'width: %1$spx !important;',
						esc_html( $this->props['items_indicator_width'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_height'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['items_indicator_height'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_border_radius'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'border-radius: %1$spx !important;',
						esc_html( $this->props['items_indicator_border_radius'] )
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_position_vertical'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% button.prodigy-cart__toggle .prodigy-navbar-cart__count',
					'declaration' => esc_html( $this->props['items_indicator_position_vertical'] ),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_position_vertical_distance'] && '' !== $this->props['items_indicator_position_horizontal_distance'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => sprintf(
						'transform: translate(%1$spx,%2$spx)!important;',
						$this->props['items_indicator_position_horizontal_distance'],
						$this->props['items_indicator_position_vertical_distance']
					),
                )
            );
		}

		if ( '' !== $this->props['items_indicator_position_horizontal'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-navbar-cart__count',
					'declaration' => esc_html( $this->props['items_indicator_position_horizontal'] ),
                )
            );
		}

		if ( '' !== $this->props['cart_heading_position'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__title',
					'declaration' => esc_html( $this->props['cart_heading_position'] ),
                )
            );
		}

		if ( '' !== $this->props['cart_heading_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['cart_heading_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_heading_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__title-wrap',
					'declaration' => sprintf(
						'padding-bottom: %1$spx !important;',
						esc_html( $this->props['cart_heading_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_close_icon_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-dropdown__header-close.icon.icon-close',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['cart_close_icon_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_close_icon_size'] ) {
			$size = $this->props['cart_close_icon_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-dropdown__header-close.icon.icon-close',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
			$size = $this->props['cart_close_icon_size'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-slide__close .icon.icon-close',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $size )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_close_icon_color'] ) {
			$color = $this->props['cart_close_icon_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-dropdown__header-close.icon.icon-close:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
			$color = $this->props['cart_close_icon_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-slide__close .icon.icon-close:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_close_icon_color_hover'] ) {
			$color = $this->props['cart_close_icon_color_hover'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-dropdown__header-close.icon.icon-close:hover:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
			$color = $this->props['cart_close_icon_color_hover'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-slide__close:hover .icon.icon-close:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_remove_item_icon_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__remove-btn.icon',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['cart_remove_item_icon_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_remove_item_icon_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__remove-btn.icon',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['cart_remove_item_icon_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subtotal_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-total',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subtotal_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subtotal_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-total',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subtotal_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subtotal_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-total:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subtotal_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subtotal_border_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-total:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['subtotal_border_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_subtotal_text_color'] ) {
			$color = $this->props['cart_subtotal_text_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-widget__subtotal-text',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
			$color = $this->props['cart_subtotal_text_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-cart-total.prodigy-cart-total__widget-subtotal .prodigy-cart-total__text',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
		}

		if ( '' !== $this->props['cart_subtotal_value_color'] ) {
			$color = $this->props['cart_subtotal_value_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-widget__subtotal-txt-price.prodigy-cart-total__value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
			$color = $this->props['cart_subtotal_value_color'];
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% span.prodigy-cart-total__value.prodigy-cart-total__value-subtotal-price',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $color )
					),
                )
            );
		}

		if ( '' !== $this->props['products_box_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['products_box_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_box_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['products_box_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_box_border_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['products_box_border_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_title_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item a.prodigy-cart-item__info-title',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['products_title_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_title_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item a.prodigy-cart-item__info-title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_title_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_title_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item a.prodigy-cart-item__info-title:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_title_text_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_quantity_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-price',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['products_quantity_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_quantity_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-price .prodigy-cart-item__info-price__count',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_quantity_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_price_left_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-price__value',
					'declaration' => sprintf(
						'margin-left: %1$spx !important;',
						esc_html( $this->props['products_price_left_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_price_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-price__value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_price_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_label_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_label_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_label_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_label_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_label_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subscription_label_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_label_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__tag:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subscription_label_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_conditions_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item-subscr__item:not(:last-child)',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_conditions_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_conditions_right_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item-subscr__condition',
					'declaration' => sprintf(
						'margin-right: %1$spx !important;',
						esc_html( $this->props['subscription_conditions_right_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_conditions_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item-subscr__condition',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_conditions_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_conditions_value_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template span.prodigy-cart-item-subscr__value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_conditions_value_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_icon_font_size'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip .icon',
					'declaration' => sprintf(
						'font-size: %1$spx !important;',
						esc_html( $this->props['subscription_tooltip_icon_font_size'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_icon_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip .icon',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_icon_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_icon_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip .icon:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_icon_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_icon_transition_duration'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip .icon',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['subscription_tooltip_icon_transition_duration'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip__message',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['subscription_tooltip_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-tooltip__message',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_attribute_name_margin_right'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-variants__name',
					'declaration' => sprintf(
						'margin-right: %1$spx !important;',
						esc_html( $this->props['products_attribute_name_margin_right'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_attribute_name_margin_bottom'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-variants li:not(:last-child)',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['products_attribute_name_margin_bottom'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_attribute_name_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-variants .prodigy-cart-item__info-variants__name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_attribute_name_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['products_attribute_value_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__info-variants .prodigy-cart-item__info-variants__value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_attribute_value_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['view_cart_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['view_cart_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['view_cart_text_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['view_cart_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_border_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn:hover',
					'declaration' => sprintf(
						'border-color: %1$s !important;',
						esc_html( $this->props['view_cart_border_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_button_bottom_margin'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['view_cart_button_bottom_margin'] )
					),
                )
            );
		}

		if ( '' !== $this->props['view_cart_button_button_duration'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__cart-btn',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['view_cart_button_button_duration'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_button_button_duration'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__checkout-btn',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['checkout_button_button_duration'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_button_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__checkout-btn',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['checkout_button_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_button_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__checkout-btn',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['checkout_button_background_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__checkout-btn:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['checkout_button_text_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['checkout_button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart__checkout-btn:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['checkout_button_background_color_hover'] )
					),
                )
            );
		}

		if ( '' !== $this->props['empty_cart_message_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__alert-empty',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['empty_cart_message_text_color'] )
					),
                )
            );
		}

		if ( '' !== $this->props['empty_cart_message_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-dropdown__alert-empty',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['empty_cart_message_background_color'] )
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
		if ( isset( $args['select_fonticon'] ) ) {
			$icon_data           = explode( '||', $args['select_fonticon'] );
			$args['icon_type']   = $icon_data[1] ?? '';
			$args['icon_utf']    = $icon_data[0] ?? '';
			$args['icon_weight'] = $icon_data[2] ?? '';
		}

		$args['cart_content_gen_type']             = $args['cart_type'] ?? '';
		$args['cart_content_gen_auto_open']        = $args['automatically_open_cart'] ?? '';
		$args['cart_content_icon_items_indicator'] = $this->mapper[ $args['items_indicator'] ?? '' ];
		$args['count_classname'] = 'prodigy-navbar-cart__count';

		$args['cart_content_icon_hide_empty']      = $args['hide_empty'];
		$args['heading_text']                      = $args['cart_text_value'];
		$args['empty_cart_text']                   = $args['empty_cart_message_text'];

		$args['container_class'] = 'prodigy-cart-dropdown__container';
		if ( isset( $args['cart_position'] ) ) {
			if ( $args['cart_position'] === 'left' ) {
				$args['container_class'] .= ' prodigy-cart-dropdown__container--left';
			}
			if ( $args['cart_position'] === 'center' ) {
				$args['container_class'] .= ' prodigy-cart-dropdown__container--center';
			}
			if ( $args['cart_position'] === 'right' ) {
				$args['container_class'] .= ' prodigy-cart-dropdown__container--right';
			}
		}

		$args['cart_icon_class'] = 'icon icon-cart';

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
		$args = $this->set_widget_parameters( $this->props );
		return $this->render_view( $args );
	}

	/**
	 * @param array $attr
	 *
	 * @return string
	 */
	public function render_view( array $attr ): string {
		ob_start();
		do_action( 'prodigy_shortcode_template_cart', $attr );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

new Divi_Prodigy_Cart();
