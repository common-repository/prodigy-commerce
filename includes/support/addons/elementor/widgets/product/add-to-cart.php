<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorAddToCart extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'pae-add-to-cart';
	}

	/**
	 * Get widget price-range.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Add To Cart', 'prodigy' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'prgicon prgicon-add-to-cart';
	}

	/**
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'prodigy-elements-single' );
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function register_controls() {
		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_general_add_to_cart',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_general_allow_multiple_quantity',
			array(
				'label'        => __( 'Allow Multiple Quantity', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'render_type'  => 'template',
			)
		);


		$this->add_control(
			'prg_enable_multiple_quantity_text',
			array(
				'label'   => __( 'Enable Multiple Quantity text', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Enable Multiple Quantity',
			)
		);

		$this->add_control(
			'prg_disable_multiple_quantity_text',
			array(
				'label'   => __( 'Disable Multiple Quantity text', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Disable Multiple Quantity',
			)
		);


		$this->add_control(
			'prg_default_enable_multiple_quantity',
			array(
				'label'        => __( 'Default Enable Multiple Quantity', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'prodigy' ),
				'label_on'     => __( 'On', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'render_type'  => 'template',
			)
		);


		$this->add_responsive_control(
			'prg_default_enable_multiple_quantity_options',
			array(
				'label'     => __( 'Default Enable Multiple Quantity attribute', 'prodigy' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'0'  => __( 'first Option for Variants', 'prodigy' ),
					'1' => __( 'second Option for Variants', 'prodigy' ),
					'2'  => __( 'third Option for Variants', 'prodigy' ),
				),
				'default'   => 'first',
				'condition' => array(
					'prg_default_enable_multiple_quantity' => 'yes',
				),
			)
		);


		$this->add_control(
			'prg_general_add_to_cart_show_price',
			array(
				'label'        => __( 'Show Price', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'prg_general_add_to_cart_show_availability',
			array(
				'label'        => __( 'Show Availability', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'render_type'  => 'template',
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'flex-start',
				'tablet_default' => 'flex-start',
				'mobile_default' => 'flex-start',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo)' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__prop-wrap'                        => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__stock'                            => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__values'                           => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_margin_bottom_attributes',
			array(
				'label'          => __( 'Attributes Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 16,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_margin_bottom_price',
			array(
				'label'          => __( 'Price Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__prop-txt-price' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_availability_text_margin_bottom',
			array(
				'label'          => __( 'Availability Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => - 20,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => - 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => - 20,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__prop-wrap:last-of-type' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_margin_bottom',
			array(
				'label'          => __( 'Quantity Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 20,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__values' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_margin_bottom_alert',
			array(
				'label'          => __( 'Alerts Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 16,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscription-alert'   => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_add_to_cart_margin_bottom_subscr_content',
			array(
				'label'          => __( 'Subscriptions Content Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Attributes
		 */
		$this->start_controls_section(
			'prg_add_to_cart_attribute',
			array(
				'label' => __( 'Attributes Dropdown View', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_text',
			array(
				'label'     => __( 'Attribute Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_attribute_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-text:not(.prodigy-product__logo-text)',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-text:not(.prodigy-product__logo-text)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_attribute_text_margin_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr-text:not(.prodigy-no-select):not(.prodigy-product__logo-text)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select',
			array(
				'label'     => __( 'Attribute Value Select', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_default_text',
			array(
				'label'   => __( 'Text', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Choose an option',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_attribute_value_select_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-main-select.attribute_values, .ms-dd-header .ms-dd-label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 15,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.attribute_values, .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-header .ms-dd-label' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_attribute_value_select_typography_value',
				'label'          => __( 'Option Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-main-select.attribute_values option, .ms-options .ms-dd-label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 15,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_main_select_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd-header' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_color_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.attribute_values, .prodigy-product__attr-item:not(.prodigy-product__logo-item) .ms-dd-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.attribute_values, .prodigy-product__attr-item:not(.prodigy-product__logo-item) .ms-dd-header, .prodigy-product__attr-item a.ms-list-option' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.attribute_values'                                      => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__attr-item:not(.prodigy-product__logo-item) .ms-dd-header' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_color_value',
			array(
				'label'      => __( 'Option Value Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#666666',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.attribute_values option' => 'color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'Options Tabs' );

		$this->start_controls_tab(
			'prg_add_to_cart_options_bg_color_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_options_item_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .ms-dd .ms-list-option' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_color_value',
			array(
				'label'      => __( 'Option Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item:not(.prodigy-product__logo-item) .ms-options .ms-dd-label' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_dropdown_block_border_radius',
			array(
				'label'      => __( 'Dropdown Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ms-dd ul.ms-options' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_add_to_cart_options_item_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_options_item_bg_color_tab_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'selectors'  => array(
					'{{WRAPPER}} .ms-dd .ms-list-option:not(.prodigy-attr__default-value):hover' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_color_hover_value',
			array(
				'label'      => __( 'Option Text Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .ms-dd .ms-list-option:not(.prodigy-attr__default-value):hover .ms-dd-label' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_add_to_cart_options_item_tab_selected',
			array(
				'label' => __( 'Selected', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_options_item_bg_color_tab_selected',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) li.ms-list-option.option-selected.enabled.attached' => 'background: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_color_selected_value',
			array(
				'label'      => __( 'Option Text Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'white',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) li.ms-list-option.option-selected:not(.prodigy-attr__default-value) .ms-dd-label' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_swatch',
			array(
				'label'     => __( 'Visual Swatch', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_attribute_value_select_options_swatch_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_attribute_value_select_options_swatch_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_attribute_value_select_options_swatch_border_radius',
			array(
				'label'          => __( 'Border Radius', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_swatch_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_add_to_cart_attribute_value_select_color_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'border-color: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_options_swatch_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_attribute_value_select_color_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__attr:not(.prodigy-product__logo) .ms-dd .ms-dd-option-image' => 'border-style: {{SIZE}} !important',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Tag View
		 */
		$this->start_controls_section(
			'prg_add_to_cart_swatches_attribute',
			array(
				'label' => __( 'Attributes Tag View', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_main_row_styling',
			array(
				'label'     => __( 'Attribute Row', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_swatches_item_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) > .prodigy-product__attr-item--no-select-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_main_min_height',
			array(
				'label'      => __( 'Minimum Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 72,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) > .prodigy-product__attr-item--no-select-value' => 'min-height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_main_gap',
			array(
				'label'      => __( 'Spacing', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-tags' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_no_select_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => esc_attr( 'solid' ),
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_main_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_attributes_quantity_count_no_select_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_main_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_text',
			array(
				'label'     => __( 'Attribute Name Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_swatches_attribute_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text.prodigy-no-select',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text.prodigy-no-select' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_selected_text_color',
			array(
				'label'      => __( 'Selected Name Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text--name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_value_text',
			array(
				'label'     => __( 'Attribute Value Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_swatches_attribute_value_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-item--no-select:not(.prodigy-product__attr-item--logo-select) .prodigy-product__attr-item--no-select-value input.prodigy-product__btn-no-select',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatch_item_button',
			array(
				'label'     => __( 'Attribute Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_add_to_cart_swatch_item_button_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '12',
					'bottom'   => '0',
					'left'     => '12',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '12',
					'bottom'   => '0',
					'left'     => '12',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '12',
					'bottom'   => '0',
					'left'     => '12',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} input[type="button"].prodigy-product__btn-no-select'            => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn > input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_values_gap',
			array(
				'label'      => __( 'Values Horizontal Gap', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__btn-wrap:not(.prodigy-tooltip)' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_values_row_gap',
			array(
				'label'      => __( 'Values Vertical Gap', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__btn-wrap:not(.prodigy-tooltip)' => 'row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_values_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'swatches_tabs' );

		$this->start_controls_tab(
			'prg_add_to_cart_swatches_item_button_bg_color_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_value_normal_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select-value input.prodigy-product__btn-no-select' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} input[type="button"].prodigy-product__btn-no-select' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_butto_tab_normal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn > input[type="button"].prodigy-product__btn-no-select' => 'border-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_butto_tab_normal_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn > input[type="button"].prodigy-product__btn-no-select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_normal_border_color_tab',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn > input[type="button"].prodigy-product__btn-no-select' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subscription_tabs_header_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_value_hover_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn:hover input.prodigy-product__btn-no-select' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_bg_color_tab_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn:hover > input[type="button"].prodigy-product__btn-no-select' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_butto_tab_hover_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn:hover > input[type="button"].prodigy-product__btn-no-select' => 'border-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_tab_hover_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn:hover > input[type="button"].prodigy-product__btn-no-select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_border_color_tab_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-radio__no-swatch-btn:hover > input[type="button"].prodigy-product__btn-no-select' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'swatches_tabs_header_tab_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_attribute_value_checked_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_bg_color_tab_checked',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_butto_tab_checked_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'border-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_butto_tab_checked_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_border_color_tab_checked',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_tab_checked_border_outline_type',
			array(
				'label'     => __( 'Outline Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'outline-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_tab_checked_border_outline_width',
			array(
				'label'      => __( 'Outline Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => '1',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'outline-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_tab_checked_border_outline_offset',
			array(
				'label'      => __( 'Outline Offset', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => '1',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select[type="button"]' => 'outline-offset: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_swatches_item_button_border_outline_color_tab_checked',
			array(
				'label'      => __( 'Outline Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__no-swatch-btn > input:checked ~ input.prodigy-product__btn-no-select[type="button"]' => 'outline-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button',
			array(
				'label'     => __( 'Visual Swatch', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn), input[type="image"].prodigy-product__swatch:not(.prodigy-product__logo-swatch)' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn)' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_main_border',
			array(
				'label'     => __( 'Border', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'prg_add_to_cart_visual_swatches_item_button_outline_border_color' );

		$this->start_controls_tab(
			'prg_add_to_cart_visual_swatches_item_button_border_color_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_tab_normal_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch:not(.prodigy-product__logo-swatch)'   => 'border-width: {{VALUE}}',
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:not([type=image]) + label' => 'border-width: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_tab_normal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch:not(.prodigy-product__logo-swatch)'   => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:not([type=image]) + label' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch:not(.prodigy-product__logo-swatch)'   => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:not([type=image]) + label' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'swatches_tabs_main_border_color_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_offset',
			array(
				'label'      => __( 'Outline Border Offset', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:checked + label' => 'outline-offset: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_outline_width',
			array(
				'label'      => __( 'Outline Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => '1',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:checked + label' => 'outline-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_tab_checked_border_type',
			array(
				'label'     => __( 'Outline Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:checked + label' => 'outline-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_color_checked',
			array(
				'label'      => __( 'Checked Outline Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn) > input:checked + label' => 'outline-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_add_to_cart_visual_swatches_item_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn:not(.prodigy-radio__swatch-logo-btn)' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Personalization
		 */
		$this->start_controls_section(
			'prg_personalization',
			array(
				'label' => __( 'Personalization', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_personalization_general',
			array(
				'label'     => __( 'General', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'prg_personalization_general_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_personalization_general_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_general_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_general_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'border-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_general_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_personalization_general_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'border-color: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_general_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_general_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__container' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_title',
			array(
				'label'     => __( 'Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_personalization_title_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'left',
				'options'        => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__title' => 'text-align: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_personalization_title_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_personalization_title_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_personalization_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-personalization__title',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_prg_personalization_title_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_label',
			array(
				'label'     => __( 'Label', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_personalization_label_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'left',
				'options'        => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__label' => 'text-align: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'prg_personalization_label_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__field-name'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-personalization__is-required' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_personalization_label_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-personalization__field-name, .prodigy-personalization__is-required',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_prg_personalization_label_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field',
			array(
				'label'     => __( 'Field', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_personalization_field_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '10',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '10',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '10',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__field .prodigy-main-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_personalization_field_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-personalization__field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_personalization_field_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-personalization__field .prodigy-main-input',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__field .prodigy-main-input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_ph_color',
			array(
				'label'      => __( 'Placeholder Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__field .prodigy-main-input::placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => 'px',
				'default'    => array(
					'size' => 60,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__field  .prodigy-personalization__input.prodigy-main-input' => 'min-height: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->start_controls_tabs( 'Field Tabs' );

		$this->start_controls_tab(
			'prg_personalization_field_border_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_personalization_field_border_type_normal',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input' => 'border-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_color_border_normal',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'condition'  => array(
					'prg_personalization_field_border_type_normal' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input' => 'border-color: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_bg_color_normal',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__field .prodigy-main-input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_personalization_field_border_tab_focus',
			array(
				'label' => __( 'Focus', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_personalization_field_border_type_focus',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input:focus' => 'border-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_color_border_focus',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000000',
				'condition'  => array(
					'prg_personalization_field_border_type_focus' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input:focus' => 'border-color: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_bg_color_focus',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input:focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_personalization_field_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_personalization_field_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-personalization__input.prodigy-main-input' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Logo Tool
		 */
		$this->start_controls_section(
			'prg_product_logo_tool_styles',
			array(
				'label' => __( 'Logo Tool', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block',
			array(
				'label'     => __( 'Logo Tool Enable', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_option',
			array(
				'label'        => __( 'Enable Logo Tool', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'render_type'  => 'template',
			)
		);


		$this->add_control(
			'prg_product_logo_tool_multiple_locations',
			array(
				'label'        => __( 'Support multiple locations', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_swatches',
			array(
				'label'        => __( 'Enable Logo Swatches', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'render_type'  => 'template',
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_block_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'space-between',
				'tablet_default' => 'space-between',
				'mobile_default' => 'space-between',
				'options'        => array(
					'start'         => __( 'Left', 'prodigy' ),
					'center'        => __( 'Center', 'prodigy' ),
					'end'           => __( 'Right', 'prodigy' ),
					'space-between' => __( 'Between', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'justify-content: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_block_order',
			array(
				'label'          => __( 'Order', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'row',
				'tablet_default' => 'row',
				'mobile_default' => 'row',
				'options'        => array(
					'row'         => __( 'Normal', 'prodigy' ),
					'row-reverse' => __( 'Reverse', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'flex-direction: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_block_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-logo-tool__text',
				'fields_options' => array(
					'typography'      => array( 'default' => 'yes' ),
					'font_size'       => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'     => array(
						'default' => 400,
					),
					'text_decoration' => array(
						'default' => 'none',
					),
					'line_height'     => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing'  => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_title_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_gap',
			array(
				'label'      => __( 'Spacing', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_background_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_block_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '12',
					'bottom'   => '20',
					'left'     => '12',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '12',
					'bottom'   => '20',
					'left'     => '12',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '12',
					'bottom'   => '20',
					'left'     => '12',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_block_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_block_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_product_logo_tool_enable_block_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__toggler-block' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_toggler',
			array(
				'label'     => __( 'Toggler', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_toggler_border_width',
			array(
				'label'      => __( 'Toggler Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__icon' => 'border-width: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_product_logo_tool_enable_block_color' );

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_block_color_normal',
			array(
				'label' => __( 'Toggler Off', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_normal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-logo-tool__icon' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_normal_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_product_logo_tool_enable_block_normal_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__icon' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_normal_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__icon' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_normal_bg_ball_color',
			array(
				'label'      => __( 'Switcher Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__icon:before' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_block_color_checked',
			array(
				'label' => __( 'Toggler On', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_checked_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-logo-tool__input:checked + .prodigy-logo-tool__icon' => 'border-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_checked_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_product_logo_tool_enable_block_normal_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__input:checked + .prodigy-logo-tool__icon' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_checked_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__input:checked + .prodigy-logo-tool__icon' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_block_checked_bg_ball_color',
			array(
				'label'      => __( 'Switcher Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-logo-tool__input:checked + .prodigy-logo-tool__icon:before' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_product_logo_tool_enable_select_block',
			array(
				'label'     => __( 'Logo Select(Tag)', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_main_margin_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 16,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select-value.prodigy-product__logo-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_margin_bottom',
			array(
				'label'          => __( 'Text Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr-text:not(.prodigy-no-select).prodigy-product__logo-text' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_min_height',
			array(
				'label'      => __( 'Minimum Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 72,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select > .prodigy-product__attr-item--no-select-value' => 'min-height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			),
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => esc_attr( 'solid' ),
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-style: {{VALUE}}',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches'                 => 'yes',
					'prg_product_logo_tool_enable_select_block_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value:not(.prodigy-radio__btn-wrap > .prodigy-product__attr-item--no-select-value)' => 'border-block-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_text',
			array(
				'label'     => __( 'Logo Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_select_block_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-text.prodigy-product__logo-text',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-text.prodigy-product__logo-text' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_text_text_color',
			array(
				'label'      => __( 'Selected Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text.prodigy-no-select' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_name_text',
			array(
				'label'     => __( 'Selected Logo Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_select_block_logo_name_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text.prodigy-no-select',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_name_text_color',
			array(
				'label'      => __( 'Selected Logo Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item--no-select.prodigy-product__attr-item--logo-select .prodigy-product__attr-item--no-select-value .prodigy-product__attr-text--name' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button',
			array(
				'label'     => __( 'Logo Image', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 100,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 100,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 84,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn' => 'width: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 100,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 100,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 84,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn' => 'height: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn'     => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn > *' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch.prodigy-product__logo-swatch' => 'background-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_column_gap',
			array(
				'label'      => __( 'Values Horizontal Gap', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__logo-btn-wrap' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_row_gap',
			array(
				'label'      => __( 'Values Vertical Gap', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template prodigy-radio__logo-btn-wrap' => 'row-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border',
			array(
				'label'     => __( 'Border', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'prg_product_logo_tool_enable_select_block_logo_image_button_border_color' );

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_normal',
			array(
				'label'     => __( 'Normal', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_normal_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch.prodigy-product__logo-swatch' => 'border-width: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_normal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch.prodigy-product__logo-swatch' => 'border-style: {{VALUE}}',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_normal_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches'                                                       => 'yes',
					'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_normal_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template input.prodigy-product__btn-no-select.prodigy-product__swatch.prodigy-product__logo-swatch' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_checked',
			array(
				'label'     => __( 'Checked', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_checked_border_offset',
			array(
				'label'      => __( 'Outline Border Offset', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn > input:checked + label' => 'outline-offset: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_checked_outline_width',
			array(
				'label'      => __( 'Outline Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => '1',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn > input:checked + label' => 'outline-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_checked_border_type',
			array(
				'label'     => __( 'Outline Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn > input:checked + label' => 'outline-style: {{VALUE}}',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_logo_image_button_border_color_checked_color_checked',
			array(
				'label'      => __( 'Checked Outline Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches'     => 'yes',
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-radio__swatch-btn.prodigy-radio__swatch-logo-btn > input:checked + label' => 'outline-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown',
			array(
				'label'     => __( 'Logo Select(Dropdown)', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option',
			array(
				'label'     => __( 'Logo Option', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option_border_radius',
			array(
				'label'          => __( 'Border Radius', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo:not(.prodigy-product__logo-location) .ms-dd .ms-options .ms-list-option' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd ul.ms-options'                                                    => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!'                                            => 'yes',
					'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo:not(.prodigy-product__logo-location) .ms-options .ms-list-option' => 'border-color: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo:not(.prodigy-product__logo-location) .ms-options .ms-list-option' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_option_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo:not(.prodigy-product__logo-location) .ms-options .ms-list-option' => 'border-style: {{SIZE}} !important',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_text',
			array(
				'label'     => __( 'Logo Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_select_block_dropdown_text_typography',
				'label'          => esc_html( 'Typography' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__attr-text.prodigy-product__logo-text',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-text.prodigy-product__logo-text' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_dropdown_text_margin_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr-text:not(.prodigy-no-select).prodigy-product__logo-text' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_value_select',
			array(
				'label'     => __( 'Logo Value Select', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_value_default_text',
			array(
				'label'     => __( 'Text', 'prodigy' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Choose Logo',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_select_block_dropdown_value_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect, .prodigy-product__logo .ms-dd-header .ms-dd-label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 15,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_value_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect, .prodigy-product__logo .ms-dd .ms-dd-header .ms-dd-label' => 'color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_logo_tool_enable_select_block_dropdown_value_typography_value',
				'label'          => __( 'Option Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect option, .prodigy-product__logo .ms-options .ms-dd-label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 15,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_main_select_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd-header' => 'background-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_select_color_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect, .prodigy-product__attr-item.prodigy-product__logo-item .ms-dd-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_value_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect, .prodigy-product__attr-item.prodigy-product__logo-item .ms-dd-header, .prodigy-product__attr-item.prodigy-product__logo-item a.ms-list-option' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_value_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect'                         => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__attr-item.prodigy-product__logo-item .ms-dd-header' => 'border-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_color_val',
			array(
				'label'      => __( 'Option Value Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#666666',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-select.prodigy-main-logoselect option' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'Logo Tabs' );

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_select_block_dropdown_option_bg_color_tab_normal',
			array(
				'label'     => __( 'Normal', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_block_greyscale',
			array(
				'label'      => __( 'Greyscale', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd li.ms-list-option' => 'filter: grayscale({{SIZE}})',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-list-option' => 'background-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_color_value',
			array(
				'label'      => __( 'Logo Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item.prodigy-product__logo-item .ms-options .ms-list-option:not(.option-selected):not(.disabled) .ms-dd-label' => 'color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_block_border_radius',
			array(
				'label'      => __( 'Dropdown Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item.prodigy-product__logo-item .ms-dd-header' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_select_block_dropdown_option_item_tab_hover',
			array(
				'label'     => __( 'Hover', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_block_greyscale_hover',
			array(
				'label'      => __( 'Greyscale', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd li.ms-list-option:hover' => 'filter: grayscale({{SIZE}})',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_bg_color_tab_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-list-option:hover' => 'background-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_color_hover_value',
			array(
				'label'      => __( 'Logo Text Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-list-option:hover .ms-dd-label' => 'color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_select_block_dropdown_selected',
			array(
				'label'     => __( 'Selected', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_block_greyscale_selected',
			array(
				'label'     => __( 'Greyscale', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo li.ms-list-option.option-selected.enabled' => 'filter: grayscale({{SIZE}})',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_bg_color_tab_selected',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo li.ms-list-option.option-selected.enabled' => 'background: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_color_selected_value',
			array(
				'label'      => __( 'Logo Text Color Selected', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item.prodigy-product__logo-item .ms-options .ms-list-option.option-selected.enabled .ms-dd-label' => 'color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_product_logo_tool_enable_disable_block_dropdown_option_bg_color_tab_normal',
			array(
				'label'     => __( 'Disabled', 'prodigy' ),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_disable_block_dropdown_option_block_greyscale',
			array(
				'label'      => __( 'Greyscale', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd li.ms-list-option.disabled' => 'filter: grayscale({{SIZE}})',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_disable_block_dropdown_option_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-list-option.disabled' => 'background-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_disable_block_dropdown_option_color_value',
			array(
				'label'      => __( 'Logo Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr-item.prodigy-product__logo-item .ms-options .ms-list-option.disabled .ms-dd-label' => 'color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_image',
			array(
				'label'     => __( 'Logo Image', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_image_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 64,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 64,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 64,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-options .ms-dd-option-image' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_image_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 64,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 64,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 64,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-options .ms-dd-option-image' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-dd-option-image' => 'background-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_border_radius',
			array(
				'label'          => __( 'Border Radius', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-dd-option-image' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!'                                     => 'yes',
					'prg_product_logo_tool_enable_select_block_dropdown_option_logo_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-dd-option-image' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-dd-option-image' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'  => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_product_logo_tool_enable_select_block_dropdown_option_logo_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__attr.prodigy-product__logo .ms-dd .ms-dd-option-image' => 'border-style: {{SIZE}} !important',
				),
				'condition' => array(
					'prg_product_logo_tool_enable_swatches!' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Bulk
		 */
		$this->start_controls_section(
			'prg_multiple_quantity_enable',
			array(
				'label' => __( 'Bulk', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_multiple_quantity_attribute_title',
			array(
				'label'     => __( 'Bulk Attribute Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_multiple_quantity_attribute_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__title > span',
				'fields_options' => array(
					'typography'      => array( 'default' => 'yes' ),
					'font_size'       => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'     => array(
						'default' => 400,
					),
					'text_decoration' => array(
						'default' => 'none',
					),
					'line_height'     => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing'  => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_attribute_title_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_attribute_title_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_attribute_title_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_multiple_quantity_attribute_title_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_attribute_title_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_multiple_quantity_attribute_title_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_multiple_quantity_attribute_title_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__title > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);


		$this->add_control(
			'prg_multiple_quantity_enable_button',
			array(
				'label'     => __( 'Multiple Quantity Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_multiple_quantity_enable_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-unstyled__btn',
				'fields_options' => array(
					'typography'      => array( 'default' => 'yes' ),
					'font_size'       => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'     => array(
						'default' => 400,
					),
					'text_decoration' => array(
						'default' => 'underline',
					),
					'text_transform'  => array(
						'default' => 'capitalize',
					),
					'line_height'     => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing'  => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_multiple_quantity_enable_button_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_multiple_quantity_enable_button_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_multiple_quantity_enable_button_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'multiple_quantity_enable_button_style_tabs' );

		$this->start_controls_tab(
			'prg_multiple_quantity_enable_button_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'prg_multiple_quantity_enable_button_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-unstyled__btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_multiple_quantity_enable_button_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-unstyled__btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_general_tabs_bulk_table',
			array(
				'label'     => __( 'Bulk Table', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_table_margin',
			array(
				'label'          => __( 'Table Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-bulk__wrap'  => 'margin-bottom: 0',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head'                                                                                      => 'border-bottom-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:only-child'                                                                                => 'border-top-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:last-child, .prodigy-bulk__table-cell:nth-child(6n), .prodigy-bulk__table-cell:only-child' => 'border-right-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell'                                                                                           => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_table_last_cell_width',
			array(
				'label'          => __( 'Cell Width', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::HIDDEN,
				'default'        => '16.66',
				'tablet_default' => '33.33',
				'mobile_default' => '33.33',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell' => 'min-width: {{VALUE}}%',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_table_border_width',
			array(
				'label'          => __( 'Border Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit' => 'px',
					'size' => 1,
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => 1,
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => 1,
				),
				'condition'      => array(
					'prg_general_tabs_bulk_table_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),

				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head'                                                                                      => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:only-child'                                                                                => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:last-child, .prodigy-bulk__table-cell:nth-child(6n), .prodigy-bulk__table-cell:only-child' => 'border-right-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell'                                                                                           => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:not(:only-child):not(:last-child):not(:nth-child(6n)):not(:nth-child(3n))'                 => 'border-right: 0',
					'{{WRAPPER}} .prodigy-bulk__table-cell:nth-child(n + 7)'                                                                          => 'border-top: 0;',
					'{{WRAPPER}} .prodigy-bulk__table-cell:nth-child(n + 7):last-child:not(:nth-child(6n)):not(:nth-child(3n + 3))'                   => 'min-width: calc({{prg_general_tabs_bulk_table_last_cell_width.VALUE}}% + var(--b-width))',
					'{{WRAPPER}} .prodigy-bulk__table-cell'                                                                                           => '--b-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_bulk_table_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head'                                                                                      => 'border-bottom-color: {{VALUE}} ',
					'{{WRAPPER}} .prodigy-bulk__table-cell:only-child'                                                                                => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell:last-child, .prodigy-bulk__table-cell:nth-child(8n), .prodigy-bulk__table-cell:only-child' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk__table-cell'                                                                                           => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header',
			array(
				'label'     => __( 'Bulk Table Header', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_table_header_typography',
				'label'          => __( 'Header Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__attr-name',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_table_header_color_typography',
				'label'          => __( 'Color Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__attr-name > span',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_text_color',
			array(
				'label'      => __( 'Header Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__attr-name, .prodigy-bulk__attr-name > span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_bg_color',
			array(
				'label'      => __( 'Header Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#f4f5f6',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_table_header_padding',
			array(
				'label'          => __( 'Header Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_color_badge',
			array(
				'label'     => __( 'Color Badge', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_color_badge_size_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tablet_default' => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'mobile_default' => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_color_badge_size_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'unit'           => array( 'px' ),
				'default'        => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tablet_default' => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'mobile_default' => array(
					'size' => '20',
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_color_badge_border_radius',
			array(
				'label'          => __( 'Border Radius', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'size' => '50',
				),
				'tablet_default' => array(
					'size' => '50',
				),
				'mobile_default' => array(
					'size' => '50',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_color_badge_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_color_badge_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1,
				),
				'condition'  => array(
					'prg_general_tabs_color_badge_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'border-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_color_badge_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#49463D',
				'condition'  => array(
					'prg_general_tabs_bulk_table_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__attr-color' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip',
			array(
				'label'     => __( 'Header Tooltip', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_table_header_tooltip_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 12,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__table-cell-head .prodigy-tooltip__message',
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'border-style: {{OPTION}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '0',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_general_tabs_bulk_table_header_tooltip_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_background_color',
			array(
				'label'     => __( 'Tooltip Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#445668',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_table_header_tooltip_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-head  .prodigy-tooltip__message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_row',
			array(
				'label'     => __( 'Quantity', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_item_table_row_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '8',
					'right'    => '4',
					'bottom'   => '8',
					'left'     => '4',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_row_gap',
			array(
				'label'      => __( 'Gap', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'size' => '8',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-body' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_table_row_cell_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk-input, .prodigy-bulk-input::placeholder',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_row_cell_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_row_cell_placeholder_text_color',
			array(
				'label'      => __( 'Placeholder Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#B6B5B1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-input::placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_row_cell_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__table-cell-body' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-bulk-input'            => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_stock_indicator',
			array(
				'label'     => __( 'Stock Indicator', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_item_table_stock_indicator_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__stock-indicator',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 11,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 11,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 11,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 12,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_item_table_stock_indicator_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'options'        => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__stock-indicator' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_stock_indicator_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#445668',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__stock-indicator-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_item_table_stock_indicator_qty_typography',
				'label'          => __( 'QTY Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__stock-indicator-qty',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 11,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 11,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 11,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 12,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_stock_indicator_qty_margin_left',
			array(
				'label'      => __( 'QTY Left Margin', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__stock-indicator-qty' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_item_table_stock_indicator_qty_color',
			array(
				'label'      => __( 'QTY Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#445668',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__stock-indicator-qty' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block',
			array(
				'label'     => __( 'Calculations', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_calc_block_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '16',
					'right'    => '4',
					'bottom'   => '16',
					'left'     => '4',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '16',
					'right'    => '4',
					'bottom'   => '16',
					'left'     => '4',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '16',
					'right'    => '4',
					'bottom'   => '16',
					'left'     => '4',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_calc_block_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#fcdd7c',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'border-style: {{OPTION}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '0',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_general_tabs_bulk_calc_block_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_calc_block_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk__total-wrap' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_calc_block_qty_typography',
				'label'          => __( 'QTY Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__total-qty-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_calc_block_subtotal_typography',
				'label'          => __( 'Subtotal Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__subtotal-save-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_calc_block_value_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__total-qty-price, .prodigy-bulk__subtotal-save-price *:not(.prodigy-bulk__subtotal-save-price-msg):not(.prodigy-bulk__subtotal-save-price-msg > *)',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 600,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_calc_block_save_typography',
				'label'          => __( 'Save Message Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk__subtotal-save-price-msg',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window',
			array(
				'label'     => __( 'Modal', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_modal_window_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .modal-content.prodigy-bulk-modal__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .modal-content.prodigy-bulk-modal__content' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_modal_window_header_typography',
				'label'          => __( 'Title Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk-modal__body-title > h4',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 24,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'font_weight'    => array(
						'default' => 600,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.5,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.5,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.5,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_header_color',
			array(
				'label'      => __( 'Title Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__body-title > h4' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_close_button_size',
			array(
				'label'      => __( 'Close Button Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon.prodigy-bulk__total-wrap' => 'font-size: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_close_button_color',
			array(
				'label'      => __( 'Close Button Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__icon-close' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_close_button_bg_color',
			array(
				'label'      => __( 'Close Button Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__icon-close' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_modal_window_paragraph_typography',
				'label'          => __( 'Content Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk-modal__body p',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.5,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.5,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.5,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_window_paragraph_color',
			array(
				'label'      => __( 'Content Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__body p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_cancel_btn',
			array(
				'label'     => __( 'Modal Cancel Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_cancel_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'border-style: {{OPTION}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_attributes_cancel_button_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_cancel_button_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => '',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_attributes_cancel_button_tabs' );

		$this->start_controls_tab(
			'prg_attributes_cancel_button_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'prg_attributes_cancel_button_style_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_cancel_button_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button--outline:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn',
			array(
				'label'     => __( 'Modal Action Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_bulk_modal_action_btn_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'border-style: {{OPTION}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_general_tabs_bulk_modal_action_btn_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_bulk_modal_action_btn_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => '',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_tabs_bulk_modal_action_btn_tabs' );

		$this->start_controls_tab(
			'prg_general_tabs_bulk_modal_action_btn_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline)' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'prg_general_tabs_bulk_modal_action_btn_style_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline):hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline):hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_bulk_modal_action_btn_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-bulk-modal__footer .prodigy-main-button:not(.prodigy-main-button--outline):hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Price
		 */
		$this->start_controls_section(
			'prg_attributes_price_control',
			array(
				'label' => __( 'Price', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_add_to_cart_label_price_typography',
				'label'          => __( 'Price Label Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__prop-wrap:first-child .prodigy-product__prop-text',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_label_price_color',
			array(
				'label'      => __( 'Price Label Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__prop-wrap:first-child .prodigy-product__prop-text' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_add_to_cart_label_price_color_default',
				'label'          => __( 'Default Text Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__prop-txt-price.prodigy-product__prop-txt-price-default',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_add_to_cart_label_price_color_default',
			array(
				'label'      => __( 'Default Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__prop-txt-price.prodigy-product__prop-txt-price-default' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_price_control_regular_price_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .sale-price-container',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 800,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_price_control_regular_price_color',
			array(
				'label'      => __( 'Value Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .sale-price-container' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_price_control_regular_price_margin',
			array(
				'label'          => __( 'Price Left Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .sale-price-container'                    => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__prop-txt-price-default' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Stock
		 */
		$this->start_controls_section(
			'prg_attributes_stock_control',
			array(
				'label' => __( 'Stock', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_stock_control_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__stock, .prodigy-product__prop-txt-aval.prodigy-product__prop-default-info',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_stock_control__color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__stock'         => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-product__prop-txt-aval' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_attributes_stock_control_label_color',
			array(
				'label'      => __( 'Label Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__prop-wrap:nth-child(2) .prodigy-product__prop-text' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_stock_control_label_typography',
				'label'          => __( 'Label Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__prop-wrap:nth-child(2) .prodigy-product__prop-text',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);


		$this->end_controls_section();

		/*
		 * Subscriptions Alert
		 */
		$this->start_controls_section(
			'prg_product_subscription',
			array(
				'label' => __( 'Subscriptions Alert', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_alert_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscription-alert .prodigy-cart-dropdown__alert-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_alert_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscription-alert' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_alert_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subscription-alert' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_alert_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-info',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_alert_icon_position',
			array(
				'label'     => __( 'Icon Position', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'prodigy' ),
					'right' => __( 'After', 'prodigy' ),
				),
				'condition' => array(
					'prg_product_subscription_alert_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_icon_spacing',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscription-alert' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_subscription_alert_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Subscriptions Tab
		 */
		$this->start_controls_section(
			'prg_product_subscription_tabs',
			array(
				'label' => __( 'Subscriptions Tabs', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_padding',
			array(
				'label'          => __( 'Tab Item Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '8',
					'bottom'   => '12',
					'left'     => '8',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '8',
					'bottom'   => '12',
					'left'     => '8',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '8',
					'bottom'   => '12',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_content_padding',
			array(
				'label'          => __( 'Tab Content Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '10',
					'bottom'   => '12',
					'left'     => '10',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '10',
					'bottom'   => '12',
					'left'     => '10',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '10',
					'bottom'   => '12',
					'left'     => '10',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-content .tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_item_sale_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subscriptions-content .tab-pane' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_item_sale_alignment',
			array(
				'label'          => __( 'Heading Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'flex-start',
				'tablet_default' => 'flex-start',
				'mobile_default' => 'flex-start',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item .prodigy-main-radio' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_subscription_tabs_header',
			array(
				'label'     => __( 'Heading Background Color', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'subscription_tabs_header' );

		$this->start_controls_tab(
			'subscription_tabs_header_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_header_background_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item:not(.active)' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subscription_tabs_header_tab_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_header_background_color_checked',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.active' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_header_title_typography',
				'label'          => __( 'Header Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-tab__item .prodigy-main-radio__label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 24,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'subscription_tabs_header_text',
			array(
				'label'     => __( 'Heading Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'subscription_tabs_header_text_color' );

		$this->start_controls_tab(
			'subscription_tabs_header_text_color_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_header_text_color',
			array(
				'label'      => __( 'Heading Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item:not(.active)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subscription_tabs_header_text_color_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_header_text_color_checked',
			array(
				'label'      => __( 'Heading Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.active' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'subscription_tabs_main_border',
			array(
				'label'     => __( 'Main Border', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'subscription_tabs_main_border_color' );

		$this->start_controls_tab(
			'subscription_tabs_main_border_color_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_main_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active)'                                            => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active) + .prodigy-subscriptions-content .tab-pane' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subscription_tabs_main_border_color_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_main_border_color_checked',
			array(
				'label'      => __( 'Checked Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link.active'                                            => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link.active + .prodigy-subscriptions-content .tab-pane' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_product_subscription_tabs_item_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-subscriptions-content .tab-pane'  => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		// label

		$this->add_control(
			'prg_radio_button_style_tabs_radio',
			array(
				'label'     => __( 'Heading Radio Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'radio_button_style_tabs' );

		$this->start_controls_tab(
			'radio_button_style_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_radio_button_style_tabs_radio_color',
			array(
				'label'      => __( 'Radio Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active) .prodigy-main-radio > .prodigy-main-radio__icon--off.icon-radio-off' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'radio_button_style_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_radio_button_style_tabs_radio_color_hover',
			array(
				'label'      => __( 'Radio Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active) .prodigy-main-radio:hover > .prodigy-main-radio__icon--off.icon-radio-off' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active) .prodigy-main-radio:hover > .prodigy-main-radio__label'                    => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_product_subscription_tabs_item_radio_button_active_color',
			array(
				'label'     => __( 'Active Radio Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link.active .prodigy-main-radio > .prodigy-main-radio__icon--on.icon-radio-on' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_title',
			array(
				'label'     => __( 'Tab Item Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-tab__item-title',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_title_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_margin_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 4,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_item_regular_price',
			array(
				'label'     => __( 'Tab Item Regular Price', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_item_regular_price_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-tab__item-price',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 16,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 16,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 16,
						),
					),
					'font_weight'    => array(
						'default' => 700,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_subscription_price_border_type',
			array(
				'label'     => __( 'Subscription Pice Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-wrap.prodigy-subscriptions-tab--price' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_subscription_price_border_color',
			array(
				'label'      => __( 'Subscription Pice Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-wrap.prodigy-subscriptions-tab--price' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_subscription_price_border_width ',
			array(
				'label'      => __( 'Subscription Pice Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-wrap.prodigy-subscriptions-tab--price' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_subscription_price_border_radius',
			array(
				'label'      => __( 'Subscription Pice Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-wrap.prodigy-subscriptions-tab--price' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_item_regular_price_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_item_regular_price_margin_right',
			array(
				'label'          => __( 'Margin Right', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' . 'em' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-price' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_item_sale',
			array(
				'label'     => __( 'Tab Item Sale Price', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_item_sale_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-tab__item-sale',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 16,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 16,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 16,
						),
					),
					'font_weight'    => array(
						'default' => 700,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_item_sale_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-tab__item-sale' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_content_cell',
			array(
				'label'     => __( 'Tab Content Cell', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_content_cell_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-content__table-cell .prodigy-subscriptions-content__table-cell-title',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 24,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_content_cell_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-content__table-cell .prodigy-subscriptions-content__table-cell-title' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_tabs_content_cell_padding_right',
			array(
				'label'          => __( 'Padding Right', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' . 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-content__table-cell .prodigy-subscriptions-content__table-cell-title' => 'padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_content_radio',
			array(
				'label'     => __( 'Tab Content Radio Field', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_tabs_content_radio_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio__label',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 24,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->start_controls_tabs( 'subscription_tabs_radio_tabs' );

		$this->start_controls_tab(
			'subscription_tabs_radio_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_content_radio_color',
			array(
				'label'      => __( 'Radio Field Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio__label'                                                       => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio__icon'                                                        => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-tab__item.nav-link:not(.active)+.prodigy-subscriptions-content .tab-pane .prodigy-main-radio * ' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subscription_tabs_radio_tab_checked',
			array(
				'label' => __( 'Checked', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_product_subscription_tabs_content_radio_color_checked',
			array(
				'label'      => __( 'Radio Field Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio__field:checked ~ .prodigy-main-radio__label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio__field:checked ~ .prodigy-main-radio__icon'  => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_product_subscription_tabs_content_cell_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-subscriptions-content__table .prodigy-main-radio:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Confirmation message
		 */
		$this->start_controls_section(
			'prg_product_subscription_confirmation_message',
			array(
				'label' => __( 'Confirmation Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_product_subscription_confirmation_message_text',
			array(
				'label'   => __( 'Text value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'has been added to your cart.',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_subscription_confirmation_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__alert-added .prodigy-cart-dropdown__alert-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_confirmation_message_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-added' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_confirmation_message_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#93c3344d',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-added' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_confirmation_message_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-check',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'prg_product_subscription_confirmation_message_icon_position',
			array(
				'label'     => __( 'Icon Position', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'prodigy' ),
					'right' => __( 'After', 'prodigy' ),
				),
				'condition' => array(
					'prg_product_subscription_confirmation_message_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_subscription_confirmation_message_icon_spacing',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-added' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_subscription_confirmation_message_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Info message
		 */
		$this->start_controls_section(
			'prg_product_info_message',
			array(
				'label' => __( 'Info Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_info_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__alert--info .prodigy-cart-dropdown__alert-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_info_message_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--info' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_info_message_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--info' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_info_message_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-error',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'prg_product_info_message_icon_position',
			array(
				'label'     => __( 'Icon Position', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'prodigy' ),
					'right' => __( 'After', 'prodigy' ),
				),
				'condition' => array(
					'prg_product_info_message_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_info_message_icon_spacing',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--info' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_info_message_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Error message
		 */
		$this->start_controls_section(
			'prg_product_error_message',
			array(
				'label' => __( 'Error Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_product_error_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__alert-error .prodigy-cart-dropdown__alert-txt',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_product_error_message_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-error' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_error_message_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#93c3344d',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-error' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_product_error_message_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-error',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'prg_product_error_message_icon_position',
			array(
				'label'     => __( 'Icon Position', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'prodigy' ),
					'right' => __( 'After', 'prodigy' ),
				),
				'condition' => array(
					'prg_product_error_message_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_product_error_message_icon_spacing',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 8,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert-error' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_product_error_message_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Add To Cart Button
		 */
		$this->start_controls_section(
			'prg_attributes_add_to_cart',
			array(
				'label' => __( 'Button (Add to Cart)', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_add_to_cart_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__values-submit',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 600,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_attributes_add_to_cart_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_add_to_cart_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '8',
					'bottom'   => '0',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_add_to_cart_margin',
			array(
				'label'          => __( 'Margin Left', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'add_to_cart_style_tabs' );

		$this->start_controls_tab(
			'add_to_cart_style_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_style_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_style_tabs_disabled',
			array(
				'label' => __( 'Disabled', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_text_color_disabled',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#49463D',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__values-submit:disabled' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_background_color_disabled',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E9EAEE',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit:disabled' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_attributes_add_to_cart_border_color_disabled',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__values-submit:disabled' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		/*
		 * View Cart Button
		 */
		$this->start_controls_section(
			'prg_attributes_view_cart',
			array(
				'label' => __( 'Button (View Cart)', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_show',
			array(
				'label'        => __( 'Show/Hide Button', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'render_type'  => 'template',
			)
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_view_cart_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart__view-cart-link',
				'condition'      => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 600,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_attributes_view_cart_show'          => 'yes',
					'prg_attributes_add_to_cart_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_view_cart_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '8',
					'bottom'   => '0',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attributes_view_cart_margin',
			array(
				'label'          => __( 'Margin Left', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'transition-duration: {{SIZE}}s',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'view_cart_style_tabs' );

		$this->start_controls_tab(
			'view_cart_style_tabs_normal',
			array(
				'label'     => __( 'Normal', 'prodigy' ),
				'condition' => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'prg_attributes_view_cart_style_tabs_hover',
			array(
				'label'     => __( 'Hover', 'prodigy' ),
				'condition' => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link:hover' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_background_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link:hover' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_attributes_view_cart_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__view-cart-link:hover' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_attributes_view_cart_show' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		/*
		 * Quantity
		 */
		$this->start_controls_section(
			'prg_attributes_quantity',
			array(
				'label' => __( 'Quantity', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count',
			array(
				'label'     => __( 'Count', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_quantity_count_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} input.prodigy-counter__total',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 60,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => esc_attr( 'solid' ),
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'count_style_tabs' );

		$this->start_controls_tab(
			'count_style_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#bfc2cc',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'count_style_tabs_focus',
			array(
				'label' => __( 'Focus', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_color_focus',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total:focus' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_bg_color_focus',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total:focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_count_border_color_focus',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'condition'  => array(
					'prg_attributes_quantity_count_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total:focus' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_attributes_quantity_btns',
			array(
				'label'     => __( 'Counter Buttons', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attributes_quantity_btns_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} button.prodigy-main-button--counter',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => 600,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.3,
						),
					),
					'letter_spacing' => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 0,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 34,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'solid'  => esc_attr( 'solid' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'none'   => esc_attr( 'none' ),
					'hidden' => esc_attr( 'hidden' ),
				),
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_width ',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_attributes_quantity_btns_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'counter_btns_style_tabs' );

		$this->start_controls_tab(
			'counter_btns_style_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#bfc2cc',
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attributes_quantity_btns_border_type' => array(
						'dotted',
						'dashed',
						'solid',
						'double',
						'groove',
						'ridge',
						'inset',
						'outset',
						'hidden',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'counter_btns_style_tabs_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_color_hover',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} button.prodigy-main-button--counter:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'counter_btns_style_tabs_disabled',
			array(
				'label' => __( 'Disabled', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_bg_color_disabled',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter:disabled' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_attributes_quantity_btns_border_color_disabled',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} button.prodigy-main-button--counter:disabled' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render widget
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		update_option( $this->get_id(), $settings );
		update_option( 'elementor_add_to_cart_options', $settings );

		$sett_prg = array();
		foreach ( $settings as $key => $setting ) {
			if ( strpos( $key, 'prg_' ) === 0 && ! is_array( $setting ) ) {
				$sett_prg[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$sett_prg['idWidget'] = $this->get_id();

		do_action( 'prodigy_product_summary_second', array( 'elementor_settings' => $sett_prg ) );
	}
}
