<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorMyAccount extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'pae-my-account';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return __( 'My Account', 'prodigy' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'prgicon prgicon-my-account';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories() {
		return array( 'prodigy-addons' );
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_my_account_style',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_my_account_dropdown_style',
			array(
				'label'   => __( 'Widget Type', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'slide'    => __( 'Slide', 'prodigy' ),
					'dropdown' => __( 'Dropdown', 'prodigy' ),
				),
				'default' => 'dropdown',
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em', '%' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit' => '%',
					'size' => '100',
				),
				'tablet_default' => array(
					'unit' => '%',
					'size' => '100',
				),
				'mobile_default' => array(
					'unit' => '%',
					'size' => '100',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'start',
				'tablet_default' => 'start',
				'mobile_default' => 'start',
				'options'        => array(
					'start'  => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'end'    => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Link
		 */

		$this->start_controls_section(
			'prg_my_account_style_link',
			array(
				'label' => __( 'Button', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_my_account_style_text_visibility',
			array(
				'label'          => __( 'Text Visibility', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'block',
				'options'        => array(
					'block'    => __( 'Visible', 'prodigy' ),
					'none'     => __( 'Hidden', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user__status' => 'display: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_my_account_style_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-navbar-user__status',
				'condition'      => array(
					'prg_my_account_style_text_visibility' => 'block',
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

		$this->add_responsive_control(
			'prg_my_account_style_button',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1.5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner > .prodigy-navbar-account' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-navbar-user' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-navbar-user > i' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-navbar-user__status' => 'transition-duration: {{SIZE}}s !important',
				),
			)
		);

		$this->start_controls_tabs( 'prg_my_account_style_button_tabs' );

		$this->start_controls_tab(
			'prg_my_account_style_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_my_account_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_my_account_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_type',
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_my_account_style_button_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_width_hover',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_my_account_style_button_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_my_account_style_button_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_border_type_hover',
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_button_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_my_account_style_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer)' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_my_account_style_link_tabs' );

		$this->start_controls_tab(
			'prg_my_account_style_link_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_my_account_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_type',
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
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer)' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_my_account_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer)' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user__status' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_icon_color',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account > .prodigy-navbar-user > i' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ebebeb',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account > span.prodigy-navbar-user' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_my_account_style_link_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_width_hover',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_my_account_style_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-account .prodigy-navbar-user' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_type_hover',
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-account .prodigy-navbar-user' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_my_account_style_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover > .prodigy-navbar-account .prodigy-navbar-user' => 'border-color: {{VALUE}} !importat',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-user+.prodigy-navbar-user__status' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-user__status' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_icon_color_hover',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-user > i' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner:hover .prodigy-navbar-account > .prodigy-navbar-user' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_my_account_style_button_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-user',
					'library' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_button_icon_padding',
			array(
				'label'          => __( 'Icon Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '15',
					'right'    => '8',
					'bottom'   => '15',
					'left'     => '8',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '15',
					'right'    => '8',
					'bottom'   => '15',
					'left'     => '8',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '15',
					'right'    => '8',
					'bottom'   => '15',
					'left'     => '8',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_button_icon_size',
			array(
				'label'          => __( 'Icon Size', 'prodigy' ),
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
					'size' => '24',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user:not(.prodigy-navbar-user--head):not(.prodigy-navbar-user--footer) i' => 'font-size: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_button_icon_position',
			array(
				'label'          => __( 'Icon Position', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'row'         => __( 'Before', 'prodigy' ),
					'row-reverse' => __( 'After', 'prodigy' ),
				),
				'default'        => 'row',
				'tablet_default' => 'row',
				'mobile_default' => 'row',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner .prodigy-navbar-account' => 'flex-direction: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_button_icon_spacing',
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap-inner > .prodigy-navbar-account' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Content
		*/
		$this->start_controls_section(
			'prg_content_account_style',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_content_account_style_main_separator',
			array(
				'label'     => __( 'Main', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_main_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'start',
				'tablet_default' => 'start',
				'mobile_default' => 'start',
				'options'        => array(
					'start'         => __( 'Left', 'prodigy' ),
					'center'        => __( 'Center', 'prodigy' ),
					'end'           => __( 'Right', 'prodigy' ),
					'space-between' => __( 'Between', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'justify-content: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_main_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_style_main_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_main_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu'   => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-account__block ' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-account__block:before ' => 'border-bottom-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_my_account_style_main_bg_backdrop_color',
			array(
				'label'      => __( 'Backdrop Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'rgba(0, 0, 0, 0.5)',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-navbar-account__wrap--open .prodigy-account__block + .prodigy-account-right__slide-menu-backdrop' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_separator',
			array(
				'label'     => __( 'Slider Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_alignment',
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
					'{{WRAPPER}} .prodigy-navbar-user__slide-title' => 'text-align: {{VALUE}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_text',
			array(
				'label'     => __( 'Text Value', 'prodigy' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Account',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_account_style_heading_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-navbar-user__slide-title',
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
						'default' => 400,
					),
					'text_transform' => array(
						'default' => 'uppercase',
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
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-navbar-user__slide-title' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_heading_bottom_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user__slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_heading_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
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
				'default'        => array(
					'size' => 36,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 36,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 36,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap:not(.prodigy-dropdown-account__wrap) .prodigy-account__menu-body' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_heading_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'size' => '1',
				),
				'condition'  => array(
					'prg_content_account_heading_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after' => 'height: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_heading_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_content_account_heading_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_heading_border_type',
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
					'{{WRAPPER}} .prodigy-account__menu-header-slide .prodigy-navbar-user__slide-title-wrap:after' => 'border-bottom-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info',
			array(
				'label'     => __( 'Dropdown Header', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-body' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'start',
				'tablet_default' => 'start',
				'mobile_default' => 'start',
				'options'        => array(
					'start'         => __( 'Left', 'prodigy' ),
					'center'        => __( 'Center', 'prodigy' ),
					'end'           => __( 'Right', 'prodigy' ),
					'space-between' => __( 'Between', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown div' => 'justify-content: {{VALUE}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_account_style_heading_user_info_name_typography',
				'label'          => __( 'Name Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-account__menu-header-dropdown .prodigy-data-user__name',
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
						'default' => 600,
					),
					'text_transform' => array(
						'default' => 'capitalize',
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
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_name_color',
			array(
				'label'     => __( 'Name Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown .prodigy-data-user__name' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_name_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit' => 'px',
					'size' => '8',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown .prodigy-data-user__name' => 'margin-bottom: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_account_style_heading_user_info_email_typography',
				'label'          => __( 'Email Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-account__menu-header-dropdown .prodigy-data-user__email',
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
					'text_transform' => array(
						'default' => 'lowercase',
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
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_email_color',
			array(
				'label'     => __( 'Email Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown .prodigy-data-user__email' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_content_account_style_heading_user_info_border_type' => array(
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
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_border_type',
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
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '0',
					'right'  => '0',
					'bottom' => '1',
					'left'   => '0',
				),
				'condition'  => array(
					'prg_content_account_style_heading_user_info_border_type' => array(
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
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_dropdown_heading_user_info_icon',
			array(
				'label'     => __( 'Dropdown Header Icon', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_icon_position',
			array(
				'label'          => __( 'Icon Position', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'row',
				'tablet_default' => 'row',
				'mobile_default' => 'row',
				'options'        => array(
					'row'         => __( 'Before', 'prodigy' ),
					'row-reverse' => __( 'After', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown div' => 'flex-direction: {{VALUE}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_icon_padding',
			array(
				'label'          => __( 'Icon Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_icon_size',
			array(
				'label'          => __( 'Icon Size', 'prodigy' ),
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
					'size' => '24',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head svg' => 'height: {{SIZE}}{{UNIT}} !important; width: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_heading_user_info_icon_gap_size',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
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
					'size' => '16',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-header-dropdown div' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_content_account_style_heading_user_info_icon_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_border_type',
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_content_account_style_heading_user_info_icon_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_color',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head svg .prodigy-custom-fill' => 'fill: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_heading_user_info_icon_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ebebeb',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--head' => 'background-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_close_separator',
			array(
				'label'     => __( 'Close Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_close_size',
			array(
				'label'      => __( 'Icon Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account-slide__header-close.icon.icon-close ' => 'font-size: {{SIZE}}{{UNIT}} !important',
					'condition' => array(
						'prg_my_account_dropdown_style' => array( 'slide' ),
					),
				),
			)
		);

		$this->start_controls_tabs( 'prg_content_account_style_close_tabs' );

		$this->start_controls_tab(
			'prg_content_account_style_close_tab_normal',
			array(
				'label'     => __( 'Normal', 'prodigy' ),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_close_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account-slide__header-close:before' => 'color: {{VALUE}} !important',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_content_account_style_close_tab_hover',
			array(
				'label'     => __( 'Hover', 'prodigy' ),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_close_color_hover',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account-slide__header-close:hover:before' => 'color: {{VALUE}} !important',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_my_account_dropdown_footer_separator',
			array(
				'label'     => __( 'Dropdown Footer', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_dropdown_footer_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_dropdown_footer_margin_top',
			array(
				'label'          => __( 'Top Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit' => 'px',
					'size' => '8',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-dropdown-account__wrap .prodigy-account__menu-body' => 'padding-bottom: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_dropdown_footer_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '1',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'condition'  => array(
					'prg_my_account_dropdown_footer_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_dropdown_footer_border_type',
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_dropdown_footer_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_my_account_dropdown_footer_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_dropdown_footer_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-account__wrap.prodigy-dropdown-account__wrap .prodigy-account__menu-footer' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'dropdown' ),
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_separator',
			array(
				'label'     => __( 'Account Item', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_item_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_item_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_account_style_item_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-account__menu-item-name',
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
					'text_transform' => array(
						'default' => 'capitalize',
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
			'prg_content_account_style_item_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1.5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-item-name' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-account__menu-item' => 'transition-duration: {{SIZE}}s !important',
				),
			)
		);

		$this->start_controls_tabs( 'prg_content_account_style_item_tabs' );

		$this->start_controls_tab(
			'prg_content_account_style_item_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'condition'  => array(
					'prg_content_account_style_item_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_content_account_style_item_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-item' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_type',
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
					'{{WRAPPER}} .prodigy-account__menu-item' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_text_color',
			array(
				'label'     => __( 'Text Color', 'prodigy'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item .prodigy-account__menu-item-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_remove_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_width_hover',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'condition'  => array(
					'prg_content_account_style_item_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_content_account_style_item_border_type_hover' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-item:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_border_type_hover',
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
					'{{WRAPPER}} .prodigy-account__menu-item:hover' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item:hover .prodigy-account__menu-item-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_my_account_item_icon_style_separator',
			array(
				'label'     => __( 'Item Icon', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_item_icon_spacing',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
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
					'size' => '16',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'column-gap: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_account_style_item_icon_position',
			array(
				'label'          => __( 'Icon Position', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'row',
				'tablet_default' => 'row',
				'mobile_default' => 'row',
				'options'        => array(
					'row'         => __( 'Before', 'prodigy' ),
					'row-reverse' => __( 'After', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-item' => 'flex-direction: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_icon_size',
			array(
				'label'      => __( 'Icon Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-item svg ' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_icon_transition',
			array(
				'label'      => __( 'Transition Duration', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1.5,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-item .icon' => 'transition-duration: {{SIZE}}s !important',
					'{{WRAPPER}} .prodigy-account__menu-item svg .prodigy-custom-fill' => 'transition-duration: {{SIZE}}s !important',
				),
			)
		);

		$this->start_controls_tabs( 'prg_content_account_style_icon_item_tabs' );

		$this->start_controls_tab(
			'prg_content_account_style_icon_item_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_icon_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-account__menu-item svg .prodigy-custom-fill' => 'fill: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_content_account_style_icon_item_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_content_account_style_item_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-item:hover .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-account__menu-item:hover svg .prodigy-custom-fill' => 'fill: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_my_account_footer_separator',
			array(
				'label'     => __( 'Slider Footer', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'start',
				'tablet_default' => 'start',
				'mobile_default' => 'start',
				'options'        => array(
					'start'         => __( 'Left', 'prodigy' ),
					'center'        => __( 'Center', 'prodigy' ),
					'end'           => __( 'Right', 'prodigy' ),
					'space-between' => __( 'Between', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'justify-content: {{VALUE}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_my_account_footer_style_name_typography',
				'label'          => __( 'Name Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-account__menu-footer-user-info .prodigy-data-user__name',
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
						'default' => 600,
					),
					'text_transform' => array(
						'default' => 'capitalize',
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
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_name_color',
			array(
				'label'     => __( 'Name Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info .prodigy-data-user__name' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_name_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'        => array(
					'unit' => 'px',
					'size' => '8',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '8',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info .prodigy-data-user__name' => 'margin-bottom: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_my_account_footer_style_email_typography',
				'label'          => __( 'Email Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-account__menu-footer-user-info .prodigy-data-user__email',
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
					'text_transform' => array(
						'default' => 'lowercase',
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
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_email_color',
			array(
				'label'     => __( 'Email Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info .prodigy-data-user__email' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_my_account_footer_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_border_type',
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
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'   => 'px',
					'top'    => '1',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'condition'  => array(
					'prg_my_account_footer_border_type' => array(
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
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_separator',
			array(
				'label'     => __( 'Slider Footer Icon', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_item_position',
			array(
				'label'          => __( 'Icon Position', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'row',
				'tablet_default' => 'row',
				'mobile_default' => 'row',
				'options'        => array(
					'row'         => __( 'Before', 'prodigy' ),
					'row-reverse' => __( 'After', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'flex-direction: {{VALUE}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_icon',
			array(
				'label'          => __( 'Icon Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_icon_size',
			array(
				'label'          => __( 'Icon Size', 'prodigy' ),
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
					'size' => '24',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '24',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_my_account_footer_style_gap_size',
			array(
				'label'          => __( 'Icon Spacing', 'prodigy' ),
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
					'size' => '16',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => '16',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-account__menu-footer-user-info' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_my_account_footer_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'border-color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_border_type',
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'border-style: {{SIZE}}',
				),
				'condition' => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_my_account_footer_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_border_radius',
			array(
				'label'      => esc_html( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_icon_color',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer svg .prodigy-custom-fill' => 'fill: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->add_control(
			'prg_my_account_footer_style_icon_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ebebeb',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-user.prodigy-navbar-user--footer' => 'background-color: {{VALUE}} !important',
				),
				'condition'  => array(
					'prg_my_account_dropdown_style' => array( 'slide' ),
				),
			)
		);

		$this->end_controls_section();
	}


	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function set_widget_options( array $settings ): array {
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$attr['my_account_icon'] = $settings['prg_my_account_style_button_icon']['value'];
		$attr['my_account_icon_url'] = $settings['prg_my_account_style_button_icon']['value']['url'] ?? '';

		$attr['icon_type'] = 'icon';
		if ( ! empty( $settings['prg_my_account_icon_url'] ) ) {
			$attr['icon_type'] = 'svg';
		}
		$attr['icon_class'] = empty( $settings['prg_my_account_style_button_icon']['value'] ) ? 'icon icon-user' : $settings['prg_my_account_style_button_icon']['value'];
		$attr['icon_svg_class'] = 'icon-img';

		if ( $settings['prg_my_account_dropdown_style'] === 'dropdown' ) {
			$attr['container_class'] = 'prodigy-dropdown-account__wrap';
			if ( $attr['my_account_style_alignment'] === 'start' ) {
				$attr['container_class'] .= ' prodigy-dropdown-account__drop-right';
			}
			if ( $settings['prg_my_account_style_alignment'] === 'center' ) {
				$attr['container_class'] .= ' prodigy-dropdown-account__drop-center';
			}
		}

		$attr['heading_text'] = $settings['prg_content_account_style_heading_text'] ?? 'Account';

		return $attr;
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$attr = $this->set_widget_options( $settings );

		$this->render_view( $attr );
	}

	/**
	 * @param array $params
	 *
	 * @return void
	 */
	public function render_view( array $params ) {
		do_action( 'prodigy_shortcode_template_my_account', $params );
	}
}
