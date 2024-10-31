<?php

use Prodigy\Includes\Frontend\Mappers\Prodigy_Cart_Page_Data_Mapper;

/**
 * Divi_Prodigy_Cart_Page class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Divi_Prodigy_Cart_Page extends ET_Builder_Module {

	/**
	 * Module initializer.
	 *
	 * @return void
	 */
	public function init() {
		$this->slug             = 'divi_prodigy_cart_page';
		$this->vb_support       = 'on';
		$this->name             = esc_html( 'Prodigy Cart Page' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = trailingslashit( PRODIGY_PLUGIN_PATH ) . 'includes/support/addons/divi/icons/Cart_Page.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(),
			),
			'advanced' => array(
				'toggles' => array(
					'products_table'                 => esc_html__( 'Products Table' ),
					'products_rows'                  => esc_html__( 'Products Rows' ),
					'product_image'                  => esc_html__( 'Product Image' ),
					'product_title'                  => esc_html__( 'Product Title' ),
					'sku'                            => esc_html__( 'SKU' ),
					'attribute_name'                 => esc_html__( 'Attribute Name' ),
					'attribute_value'                => esc_html__( 'Attribute Value' ),
					'subscription_label'             => esc_html__( 'Subscription Label' ),
					'subscription_conditions'        => esc_html__( 'Subscription Conditions' ),
					'subscription_conditions_value'  => esc_html__( 'Subscription Conditions Value' ),
					'subscription_tooltip'           => esc_html__( 'Subscription Tooltip' ),
					'remove_link'                    => esc_html__( 'Remove Link' ),
					'price'                          => esc_html__( 'Price' ),
					'quantity_count'                 => esc_html__( 'Quantity Count' ),
					'quantity_counter_button'        => esc_html__( 'Quantity Counter Button' ),
					'total'                          => esc_html__( 'Total' ),
					'subtotal'                       => esc_html__( 'Subtotal' ),
					'subtotal_text'                  => esc_html__( 'Subtotal Text' ),
					'subtotal_value'                 => esc_html__( 'Subtotal Value' ),
					'subtotal_divider'               => esc_html__( 'Subtotal Divider' ),
					'proceed_to_checkout_button'     => esc_html__( 'Proceed To Checkout Button' ),
					'continue_shopping_button'       => esc_html__( 'Continue Shopping Button' ),
					'continue_shopping_empty_button' => esc_html__( 'Continue Shopping(Empty) Button' ),
				),
			),
		);

		$this->advanced_fields = array(
			'form_field' => array(
				'subtotal_value'                 => array(
					'label'                  => esc_html__( 'Subscription Conditions Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "$this->main_css_element span.prodigy-cart__total-value",
							'hover'                => "$this->main_css_element span.prodigy-cart__total-value",
							'color'                => "$this->main_css_element span.prodigy-cart__total-value",
							'color_hover'          => "$this->main_css_element span.prodigy-cart__total-value",
							'letter_spacing'       => "$this->main_css_element span.prodigy-cart__total-value",
							'letter_spacing_hover' => "$this->main_css_element span.prodigy-cart__total-value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subtotal_text'                  => array(
					'label'                  => esc_html__( 'Subscription Conditions Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "$this->main_css_element span.prodigy-cart__total-text",
							'hover'                => "$this->main_css_element span.prodigy-cart__total-text",
							'color'                => "$this->main_css_element span.prodigy-cart__total-text",
							'color_hover'          => "$this->main_css_element span.prodigy-cart__total-text",
							'letter_spacing'       => "$this->main_css_element span.prodigy-cart__total-text",
							'letter_spacing_hover' => "$this->main_css_element span.prodigy-cart__total-text",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'remove_link'                    => array(
					'label'                  => esc_html__( 'Subscription Conditions Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'hover'                => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'color'                => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'color_hover'          => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'letter_spacing'       => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'letter_spacing_hover' => "{$this->main_css_element} a.prodigy-cart__remove.prodigy-cart__remove-item, #et-boc .et-l a.prodigy-cart__remove.prodigy-cart__remove-item",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subscription_conditions_value'  => array(
					'label'                  => esc_html__( 'Subscription Conditions Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'hover'                => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'color'                => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'color_hover'          => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-subscription-condition-value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subscription_conditions'        => array(
					'label'                  => esc_html__( 'Subscription Conditions', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-subscription-condition",
							'hover'                => "{$this->main_css_element} .prodigy-subscription-condition",
							'color'                => "{$this->main_css_element} .prodigy-subscription-condition",
							'color_hover'          => "{$this->main_css_element} .prodigy-subscription-condition",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-subscription-condition",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-subscription-condition",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'product_title'                  => array(
					'label'                  => esc_html__( 'Product Title', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'hover'                => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'color'                => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'color_hover'          => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'letter_spacing'       => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'letter_spacing_hover' => "{$this->main_css_element}  a.prodigy-cart__table-info-title-link, #et-boc .et-l a.prodigy-cart__table-info-title-link",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'sku'                            => array(
					'label'                  => esc_html__( 'SKU', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .sku",
							'hover'                => "{$this->main_css_element} .sku",
							'color'                => "{$this->main_css_element} .sku",
							'color_hover'          => "{$this->main_css_element} .sku",
							'letter_spacing'       => "{$this->main_css_element} .sku",
							'letter_spacing_hover' => "{$this->main_css_element} .sku",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'products_table'                 => array(
					'label'                  => esc_html__( 'Products Table', 'et_builder' ),
					'border_styles'          => array(
						'products_table' => array(
							'label_prefix'      => 'Products Table',
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-cart__table th[class*='cell'], .et-l .prodigy-cart__table-product-cell,.et-l .prodigy-cart__table-desc-cell,.et-l .prodigy-cart__table-price-cell,.et-l .prodigy-cart__table-quantity-cell",
									'border_radii'  => "{$this->main_css_element} .prodigy-cart__table th[class*='cell'].prodigy-cart__table th[class*='cell'], .et-l .prodigy-cart__table-product-cell,.et-l .prodigy-cart__table-desc-cell,.et-l .prodigy-cart__table-price-cell,.et-l .prodigy-cart__table-quantity-cell",
									'important'     => 'all',
								),
								'important'     => 'all',
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'use_radius'        => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-cart__table th[class*='cell'], .et-l .prodigy-cart__table-product-cell,.et-l .prodigy-cart__table-desc-cell,.et-l .prodigy-cart__table-price-cell,.et-l .prodigy-cart__table-quantity-cell",
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
							'main'                 => "{$this->main_css_element} .prodigy-cart__table th",
							'hover'                => "{$this->main_css_element} .prodigy-cart__table th",
							'color'                => "{$this->main_css_element} .prodigy-cart__table th",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__table th",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__table th",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__table th",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => array(
						'css' => array(
							'main'      => "{$this->main_css_element} div.prodigy-cart__table",
							'hover'     => "{$this->main_css_element} div.prodigy-cart__table",
							'important' => 'all',
						),
					),
					'background_color'       => false,
				),
				'products_rows'                  => array(
					'label'                  => esc_html__( 'Product Rows', 'et_builder' ),
					'border_styles'          => array(
						'products_rows' => array(
							'label_prefix'      => 'Product Rows',
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td",
									'border_radii'  => "{$this->main_css_element} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td",
									'important'     => 'all',
								),
								'important'     => 'all',

							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'use_radius'        => false,
						),
					),
					'margin_padding'         => array(
						'css'        => array(
							'padding' => "{$this->main_css_element} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td",
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
							'main'                 => "{$this->main_css_element} .prodigy-cart__table td",
							'hover'                => "{$this->main_css_element} .prodigy-cart__table td",
							'color'                => "{$this->main_css_element} .prodigy-cart__table td",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__table td",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__table td",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__table td",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'product_image'                  => array(
					'label'                  => esc_html__( 'Product Image', 'et_builder' ),
					'border_styles'          => array(
						'product_image' => array(
							'label_prefix'      => 'Product Image',
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} div.prodigy-cart__placeholder,#et-boc .et-l div div.prodigy-cart__placeholder, .et-l div .prodigy-cart__placeholder",
									'border_radii'  => "{$this->main_css_element} div.prodigy-cart__placeholder,#et-boc .et-l div div.prodigy-cart__placeholder, .et-l div .prodigy-cart__placeholder",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
							'use_border_styles' => false,
							'use_radius'        => false,
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
				'attribute_name'                 => array(
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
							'main'                 => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'hover'                => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'color'                => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-name",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
				),
				'attribute_value'                => array(
					'label'                  => esc_html__( 'Attribute Value', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => false,
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'hover'                => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'color'                => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart-item__info-variants-attr-value",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subscription_label'             => array(
					'label'                  => esc_html__( 'Subscription label', 'et_builder' ),
					'border_styles'          => array(
						'subscription_label' => array(
							'label_prefix'      => 'Label',
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
							'padding'   => "{$this->main_css_element} .prodigy-custom-template div.prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'important' => 'padding',
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
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag:hover, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag:hover, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-cart-item__tag:hover, #et-boc .et-l div .prodigy-custom-template .prodigy-cart-item__tag:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subscription_tooltip'           => array(
					'label'                  => et_builder_i18n( 'Subscription Tooltip' ),
					'border_styles'          => array(
						'subscription_tooltip' => array(
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
					'text_color'             => false,
					'focus_background_color' => false,
					'focus_text_color'       => false,
					'use_focus_color'        => false,
					'use_focus_text_color'   => false,
					'box_shadow'             => false,
					'font_field'             => array(
						'css'              => array(
							'main'                 => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'hover'                => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'color'                => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'color_hover'          => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'letter_spacing'       => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'letter_spacing_hover' => "{$this->main_css_element} span.prodigy-tooltip__message, #et-boc .et-l span.prodigy-tooltip__message",
							'important'            => 'all',
						),
						'box_shadow'       => false,
						'background_color' => false,
					),
				),
				'price'                          => array(
					'label'                  => esc_html__( 'Price', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
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
							'main'                 => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'hover'                => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'color'                => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'quantity_count'                 => array(
					'label'                  => esc_html__( 'Quantity Count', 'et_builder' ),
					'border_styles'          => array(
						'quantity_count' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input.prodigy-main-input__total-count,#et-boc .et-l div .prodigy-counter > input.prodigy-counter__total.prodigy-main-input.prodigy-main-input__total-count",
									'border_radii'  => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input.prodigy-main-input__total-count,#et-boc .et-l div .prodigy-counter > input.prodigy-counter__total.prodigy-main-input.prodigy-main-input__total-count",
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
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'hover'                => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'color'                => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'color_hover'          => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'letter_spacing'       => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'letter_spacing_hover' => "{$this->main_css_element} input.prodigy-counter__total.prodigy-main-input",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'quantity_counter_button'        => array(
					'label'                  => esc_html__( 'Quantity Counter Button', 'et_builder' ),
					'border_styles'          => array(
						'quantity_counter_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
									'border_radii'  => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
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
					'font_field'             => array(
						'css'             => array(
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-main-button--counter",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'total'                          => array(
					'label'                  => esc_html__( 'Total', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
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
							'main'                 => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'hover'                => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'color'                => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'color_hover'          => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-cart__total-price.prodigy-cart__total-cell",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
				),
				'subtotal'                       => array(
					'label'                  => esc_html__( 'Subtotal', 'et_builder' ),
					'border_styles'          => false,
					'margin_padding'         => array(
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-cart__total-info",
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
				'subtotal_divider'               => array(
					'label'                  => esc_html__( 'Subtotal Divider', 'et_builder' ),
					'margin_padding'         => false,
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
				'proceed_to_checkout_button'     => array(
					'label'                  => esc_html__( 'Proceed To Checkout Button', 'et_builder' ),
					'border_styles'          => array(
						'proceed_to_checkout_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element}  .prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout.mt-12",
									'border_radii'  => "{$this->main_css_element}  .prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout.mt-12",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'label'      => esc_html__( 'Text', 'et_builder' ),
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-main-button.prodigy-main-button__checkout",
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
							'main'                 => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'hover'                => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'color'                => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'color_hover'          => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'letter_spacing'       => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'letter_spacing_hover' => "{$this->main_css_element} button.prodigy-main-button.prodigy-main-button__checkout, #et-boc .et-l div .prodigy-main-button.prodigy-main-button__checkout",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
					'text-transform'         => false,
				),
				'continue_shopping_button'       => array(
					'label'                  => esc_html__( 'Continue Shopping Button', 'et_builder' ),
					'border_styles'          => array(
						'continue_shopping_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-main-button.prodigy-main-button.prodigy-subtotal__btn-continue, #et-boc .et-l div .prodigy-main-button.prodigy-main-button.prodigy-subtotal__btn-continue.prodigy-main-button--outline",
									'border_radii'  => "{$this->main_css_element} .prodigy-main-button.prodigy-main-button.prodigy-subtotal__btn-continue, #et-boc .et-l div .prodigy-main-button.prodigy-main-button.prodigy-subtotal__btn-continue.prodigy-main-button--outline",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'label'      => esc_html__( 'Text', 'et_builder' ),
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-main-button.prodigy-subtotal__btn-continue",
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
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-subtotal__btn-continue:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
					'text_transform'         => false,
				),
				'continue_shopping_empty_button' => array(
					'label'                  => esc_html__( 'Continue Shopping(Empty) Button', 'et_builder' ),
					'border_styles'          => array(
						'continue_shopping_empty_button' => array(
							'css'               => array(
								'main' => array(
									'border_styles' => "{$this->main_css_element} .prodigy-main-button.prodigy-empty-cart__link, #et-boc .et-l div .prodigy-main-button.prodigy-empty-cart__link",
									'border_radii'  => "{$this->main_css_element} .prodigy-main-button.prodigy-empty-cart__link, #et-boc .et-l div .prodigy-main-button.prodigy-empty-cart__link",
									'important'     => 'all',
								),
							),
							'use_focus_borders' => false,
						),
					),
					'margin_padding'         => array(
						'label'      => esc_html__( 'Text', 'et_builder' ),
						'css'        => array(
							'padding'   => "{$this->main_css_element} .prodigy-main-button.prodigy-empty-cart__link",
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
							'main'                 => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link",
							'hover'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link:hover",
							'color'                => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link",
							'color_hover'          => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link:hover",
							'letter_spacing'       => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link",
							'letter_spacing_hover' => "{$this->main_css_element} .prodigy-custom-template .prodigy-main-button.prodigy-empty-cart__link:hover",
							'important'            => 'all',
						),
						'hide_text_align' => true,
					),
					'box_shadow'             => false,
					'background_color'       => false,
					'text_transform'         => false,
				),
			),
		);
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		$basic_fields = array(
			'load'    => array(),
			'__posts' => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'Divi_Prodigy_Cart_Page',
					'get_view',
				),
				'computed_depends_on' => array(
					'load',
				),
			),
		);

		$tab                    = 'advanced';
		$custom_advanced_fields = array(

			'products_rows_mobile_gap'          => array(
				'label'          => esc_html__( 'Products Rows Mobile Gap', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '40',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'products_rows',
			),

			'attribute_name_right_margin'                 => array(
			    'label'          => esc_html__( 'Right margin', 'et_builder' ),
			    'type'           => 'range',
			    'tab_slug'       => $tab,
			    'toggle_slug'    => 'attribute_name',
			    'range_settings' => array(
			    	'min'  => '0',
			    	'max'  => '100',
			    	'step' => '1',
			    ),
			    'default'        => '4',
		    ),

			'attribute_name_bottom_margin'                => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'attribute_name',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '4',
			),

			'attribute_value_bottom_margin'               => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'attribute_value',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '4',
			),

			'subtotal_text_color'                         => array(
				'label'       => esc_html__( 'Subtotal Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal_text',
			),

			'subtotal_text_value'                         => array(
				'label'       => esc_html__( 'Subtotal Text Value Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal_value',
			),

			'quantity_counter_button_text_color'          => array(
				'label'       => esc_html__( 'Quantity Counter Button Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_counter_button',
			),

			'quantity_count_color'                        => array(
				'label'       => esc_html__( 'Quantity Count Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_count',
			),

			'price_text_color'                            => array(
				'label'       => esc_html__( 'Price Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'price',
			),

			'total_price_text_color'                      => array(
				'label'       => esc_html__( 'Total Price Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'total',
			),

			'remove_link_color'                           => array(
				'label'       => esc_html__( 'Remove Link Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'remove_link',
			),

			'subscription_tooltip_color'                  => array(
				'label'       => esc_html__( 'Subscription Tooltip Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_tooltip',
			),

			'subscription_value_color'                    => array(
				'label'       => esc_html__( 'Subscription Value Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_value',
			),

			'subscription_conditions_color'               => array(
				'label'       => esc_html__( 'Subscription Condition Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_condition',
			),

			'subscription_label_color'                    => array(
				'label'       => esc_html__( 'Subscription Label Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_label',
			),

			'subscription_label_background_color'         => array(
				'label'       => esc_html__( 'Subscription Label Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_label',
			),

			'products_table_title_color'                  => array(
				'label'       => esc_html__( 'Column Title Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'products_table',
			),

			'attribute_name_color'                        => array(
				'label'       => esc_html__( 'Attribute Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'attribute_name',
			),

			'attribute_value_color'                       => array(
				'label'       => esc_html__( 'Attribute Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'attribute_value',
			),

			'title_link_color'                            => array(
				'label'       => esc_html__( 'Link Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'product_title',
			),
			'title_link_color_hover'                      => array(
				'label'       => esc_html__( 'Link Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'product_title',
			),
			'title_bottom_margin'                         => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'product_title',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '4',
			),
			'sku_text_color'                              => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'sku',
			),
			'sku_bottom_margin'                           => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'sku',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '4',
			),
			'subscription_title_bottom_margin'            => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'subscription_label',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '8',
			),

			'subscription_conditions_value_bottom_margin' => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'subscription_conditions_value',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '8',
			),

			'subscription_conditions_bottom_margin'       => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'subscription_conditions',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '8',
			),
			'subscription_conditions_right_margin'        => array(
				'label'          => esc_html__( 'Right margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'subscription_conditions',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '4',
			),
			'subscription_tooltip_bottom_margin'          => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'subscription_tooltip',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '8',
			),
			'subscription_tooltip_background_color'       => array(
				'label'       => esc_html__( 'Tooltip Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_tooltip',
			),

			'subscription_tooltip_icon_font_size'         => array(
				'label'       => esc_html__( 'Tooltip Icon Size', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '14',
				'toggle_slug' => 'subscription_tooltip',
			),

			'subscription_tooltip_icon_color'             => array(
				'label'       => esc_html__( 'Icon Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_tooltip',
			),
			'subscription_tooltip_icon_color_hover'       => array(
				'label'       => esc_html__( 'Icon Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subscription_tooltip',
			),

			'subscription_tooltip_icon_duration'          => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '100',
				),
				'toggle_slug'    => 'subscription_tooltip',
			),

			'remove_link_bottom_margin'                   => array(
				'label'          => esc_html__( 'Bottom margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'toggle_slug'    => 'remove_link',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'        => '0',
			),

			'quantity_count_background_color'             => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_count',
			),

			'quantity_count_width'                        => array(
				'label'       => esc_html__( 'Width', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'quantity_count',
			),
			'quantity_count_height'                       => array(
				'label'       => esc_html__( 'Height', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'quantity_count',
			),

			'quantity_counter_button_width'               => array(
				'label'       => esc_html__( 'Width', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'quantity_counter_button',
			),
			'quantity_counter_button_height'              => array(
				'label'       => esc_html__( 'Height', 'et_builder' ),
				'type'        => 'range',
				'tab_slug'    => $tab,
				'default'     => '40',
				'toggle_slug' => 'quantity_counter_button',
			),
			'quantity_counter_button_background'          => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_counter_button',
			),
			'quantity_counter_button_background_hover'    => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_counter_button',
			),
			'quantity_counter_button_background_disabled' => array(
				'label'       => esc_html__( 'Background Color Disabled', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'quantity_counter_button',
			),

			'quantity_counter_button_duration'            => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '100',
				),
				'toggle_slug'    => 'quantity_counter_button',
			),

			'subtotal_divider_color'                      => array(
				'label'       => esc_html__( 'Subtotal Divider Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal_divider',
			),

			'subtotal_mobile_divider_color'               => array(
				'label'       => esc_html__( 'Mobile Divider Top Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'subtotal_divider',
			),

			'subtotal_divider_width'                      => array(
				'label'          => esc_html__( 'Subtotal Divider Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'subtotal_divider',
			),

			'subtotal_mobile_divider_width'               => array(
				'label'          => esc_html__( 'Mobile Divider Top Width', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
				),
				'toggle_slug'    => 'subtotal_divider',
			),

			'subtotal_divider_margin_bottom'              => array(
				'label'          => esc_html__( 'Subtotal Divider Margin', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '12',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'    => 'subtotal_divider',
			),

			'proceed_to_checkout_button_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'proceed_to_checkout_button',
			),

			'proceed_to_checkout_button_background_color_hover' => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'proceed_to_checkout_button',
			),
			'proceed_to_checkout_button_text_color'       => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'proceed_to_checkout_button',
			),
			'proceed_to_checkout_button_text_color_hover' => array(
				'label'       => esc_html__( 'Text Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'proceed_to_checkout_button',
			),

			'proceed_to_checkout_button_duration'         => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '100',
				),
				'toggle_slug'    => 'proceed_to_checkout_button',
			),

			'continue_shopping_button_background_color'   => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_button',
			),

			'continue_shopping_button_background_color_hover' => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_button',
			),
			'continue_shopping_button_text_color'         => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_button',
			),
			'continue_shopping_button_text_color_hover'   => array(
				'label'       => esc_html__( 'Text Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_button',
			),

			'continue_shopping_button_duration'           => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '100',
				),
				'toggle_slug'    => 'continue_shopping_button',
			),

			'continue_shopping_empty_button_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_empty_button',
			),

			'continue_shopping_empty_button_background_color_hover' => array(
				'label'       => esc_html__( 'Background Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_empty_button',
			),
			'continue_shopping_empty_button_text_color'   => array(
				'label'       => esc_html__( 'Text Color', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_empty_button',
			),
			'continue_shopping_empty_button_text_color_hover'       => array(
				'label'       => esc_html__( 'Text Color Hover', 'et_builder' ),
				'type'        => 'color',
				'tab_slug'    => $tab,
				'toggle_slug' => 'continue_shopping_empty_button',
			),

			'continue_shopping_empty_button_duration'     => array(
				'label'          => esc_html__( 'Transition Duration', 'et_builder' ),
				'type'           => 'range',
				'tab_slug'       => $tab,
				'default'        => '200',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1500',
					'step' => '100',
				),
				'toggle_slug'    => 'continue_shopping_empty_button',
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

		if ( '' !== $this->props['products_rows_mobile_gap'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-table-cell__count-wrap',
					'declaration' => sprintf(
						'padding-bottom: %1$spx !important;',
						esc_html( $this->props['products_rows_mobile_gap'] )
					),
				)
			);
		}

		if ( '' !== $this->props['attribute_name_right_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__info-variants-attr-name',
					'declaration' => sprintf(
						'margin-right: %1$spx !important;',
						esc_html( $this->props['attribute_name_right_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['attribute_name_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__info-variants-attr-name',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['attribute_name_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['attribute_value_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__info-variants-attr-value',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['attribute_value_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_text_value'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% span.prodigy-cart__total-value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subtotal_text_value'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% span.prodigy-cart__total-text',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subtotal_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['total_price_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart__total-price.prodigy-cart__total-cell',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['total_price_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['price_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart__total-price:not(.prodigy-cart__total-cell)',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['price_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_count_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input.prodigy-counter__total.prodigy-main-input',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['quantity_count_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button--counter',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['quantity_counter_button_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['remove_link_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart__remove',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['remove_link_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_tooltip_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-tooltip__message',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_conditions_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-subscription-condition',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_conditions_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_value_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-subscription-condition-value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_value_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_label_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_label_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['products_table_title_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart__table th',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['products_table_title_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['attribute_name_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__info-variants-attr-name',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['attribute_name_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['attribute_value_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__info-variants-attr-value',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['attribute_value_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['title_link_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-cart__table-info-title a',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['title_link_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['title_link_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-cart__table-info-title a:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['title_link_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['title_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-cart__table-info-title',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['title_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['sku_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .sku',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['sku_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['sku_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .sku',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['sku_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_title_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-custom-template .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_title_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_conditions_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-subscription-condition',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_conditions_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_conditions_value_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-subscription-condition-value',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_conditions_value_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_conditions_right_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-subscription-condition',
					'declaration' => sprintf(
						'margin-right: %1$spx !important;',
						esc_html( $this->props['subscription_conditions_right_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_tooltip_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-tooltip',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subscription_tooltip_bottom_margin'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_label_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart-item__tag',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subscription_label_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_tooltip_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-tooltip__message',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_tooltip_icon_font_size'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-tooltip .icon.icon-info',
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
					'selector'    => '%%order_class%% .prodigy-tooltip .icon.icon-info',
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
					'selector'    => '%%order_class%% .prodigy-tooltip .icon.icon-info:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['subscription_tooltip_icon_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subscription_tooltip_icon_duration'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-tooltip .icon.icon-info',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['subscription_tooltip_icon_duration'] )
					),
				)
			);
		}

		if ( '' !== $this->props['remove_link_bottom_margin'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-cart__remove.prodigy-cart__remove-item',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['remove_link_bottom_margin'] )
					),
				)
			);
		}
		if ( '' !== $this->props['quantity_count_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input.prodigy-counter__total',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['quantity_count_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_count_width'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input.prodigy-counter__total',
					'declaration' => sprintf(
						'width: %1$spx !important;',
						esc_html( $this->props['quantity_count_width'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_count_height'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input.prodigy-counter__total',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['quantity_count_height'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_width'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter',
					'declaration' => sprintf(
						'width: %1$spx !important;',
						esc_html( $this->props['quantity_counter_button_width'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_height'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter',
					'declaration' => sprintf(
						'height: %1$spx !important;',
						esc_html( $this->props['quantity_counter_button_height'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['quantity_counter_button_background'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_background_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['quantity_counter_button_background_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_background_disabled'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter:disabled',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['quantity_counter_button_background_disabled'] )
					),
				)
			);
		}

		if ( '' !== $this->props['quantity_counter_button_duration'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button--counter',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['quantity_counter_button_duration'] )
					),
				)
			);
		}

		if ( '' !== $this->props['proceed_to_checkout_button_duration'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button__checkout',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['proceed_to_checkout_button_duration'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_divider_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-divider-block.prodigy-divider-block--light',
					'declaration' => sprintf(
						'border-bottom-color: %1$s !important;border-bottom-style: solid !important;',
						esc_html( $this->props['subtotal_divider_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_mobile_divider_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-cart__total-info',
					'declaration' => sprintf(
						'border-top-color: %1$s !important;',
						esc_html( $this->props['subtotal_mobile_divider_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_divider_width'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-divider-block.prodigy-divider-block--light',
					'declaration' => sprintf(
						'border-bottom-width: %1$spx !important;',
						esc_html( $this->props['subtotal_divider_width'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_mobile_divider_width'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-cart__total-info',
					'declaration' => sprintf(
						'border-top-width: %1$spx !important;',
						esc_html( $this->props['subtotal_mobile_divider_width'] )
					),
				)
			);
		}

		if ( '' !== $this->props['subtotal_divider_margin_bottom'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% div.prodigy-divider-block.prodigy-divider-block--light',
					'declaration' => sprintf(
						'margin-bottom: %1$spx !important;',
						esc_html( $this->props['subtotal_divider_margin_bottom'] )
					),
				)
			);
		}

		if ( '' !== $this->props['proceed_to_checkout_button_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button__checkout',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['proceed_to_checkout_button_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['proceed_to_checkout_button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button__checkout:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['proceed_to_checkout_button_background_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['proceed_to_checkout_button_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button__checkout',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['proceed_to_checkout_button_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['proceed_to_checkout_button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-main-button__checkout:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['proceed_to_checkout_button_text_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_button_background_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-subtotal__btn-continue',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['continue_shopping_button_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-subtotal__btn-continue:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['continue_shopping_button_background_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_button_text_color'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-subtotal__btn-continue',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['continue_shopping_button_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-subtotal__btn-continue:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['continue_shopping_button_text_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_button_duration'] ) {
			ET_Builder_Element::set_style(
                $render_slug,
                array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-subtotal__btn-continue',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['continue_shopping_button_duration'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_empty_button_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-empty-cart__link',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['continue_shopping_empty_button_background_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_empty_button_background_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-empty-cart__link:hover',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $this->props['continue_shopping_empty_button_background_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_empty_button_text_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-empty-cart__link',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['continue_shopping_empty_button_text_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_empty_button_text_color_hover'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-empty-cart__link:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $this->props['continue_shopping_empty_button_text_color_hover'] )
					),
				)
			);
		}

		if ( '' !== $this->props['continue_shopping_empty_button_duration'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .prodigy-main-button.prodigy-empty-cart__link',
					'declaration' => sprintf(
						'transition-duration: %1$sms !important;',
						esc_html( $this->props['continue_shopping_empty_button_duration'] )
					),
				)
			);
		}
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

		return $widget->render_view();
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

		return $this->render_view();
	}

	/**
	 * @return string
	 */
	public function render_view(): string {
		ob_start();
		do_action( 'prodigy_get_template_cart_page', array( 'is_quantity_title' => false ) );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

new Divi_Prodigy_Cart_Page();
