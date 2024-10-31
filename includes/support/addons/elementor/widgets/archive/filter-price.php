<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.8.0
 */
class ElementorFilterPrice extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @return string Widget name.
	 * @access public
	 */
	public function get_name() {
		return 'pae-filter-price';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @return string Widget title.
	 * @access public
	 */
	public function get_title() {
		return __( 'Price Filter', 'prodigy' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @return string Widget icon.
	 * @access public
	 */
	public function get_icon() {
		return 'prgicon prgicon-price-filter';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @return array Widget categories.
	 * @access public
	 */
	public function get_categories() {
		return array( 'prodigy-elements-archive' );
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 * @access protected
	 */
	protected function register_controls() {
		/*
		 * TAB style
		 */
		$this->start_controls_section(
			'prg_content_type_gen',
			array(
				'label' => __( 'General Price Filter', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_price_style_bottom_margin',
			array(
				'label'          => __( 'Filter Item Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 50,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 30,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-filter__item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Heading
		 */
		$this->start_controls_section(
			'prg_price_style_heading',
			array(
				'label' => __( 'Heading', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_price_style_heading_text',
			array(
				'label'   => __( 'Text value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Price Filter',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_price_style_heading_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} h3.prodigy-filter__title',
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
						'default' => 'uppercase',
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.4,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.4,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.4,
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
			'prg_price_style_heading_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} h3.prodigy-filter__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_price_style_heading_alignment',
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
					'{{WRAPPER}} h3.prodigy-filter__title' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_price_style_heading_margin_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of heading and slider',
				'default'        => array(
					'size' => 40,
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
					'{{WRAPPER}} h3.prodigy-filter__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Slider Bar
		 */
		$this->start_controls_section(
			'prg_slider_bar_style_heading',
			array(
				'label' => __( 'Slider Bar', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_slider_bar_style_filled_text_color',
			array(
				'label'      => __( 'Filled Bar Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__range .irs--flat .irs-bar' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_slider_bar_style_empty_bar_color',
			array(
				'label'      => __( 'Empty Bar Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__range .irs--flat .irs-line' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_slider_bar_style_boundaries_color',
			array(
				'label'      => __( 'Boundaries Color ', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__range .irs--flat .irs-handle > i:first-child' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Field Label
		 */
		$this->start_controls_section(
			'prg_field_label_style_heading',
			array(
				'label' => __( 'Field Label', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_field_label_style_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-filter__field-label',
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
			'prg_field_label_style_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__field-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_field_label_style_alignment',
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
					'{{WRAPPER}} .prodigy-filter__field-label' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_field_label_style_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of label and field',
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
					'{{WRAPPER}} .prodigy-filter__field-label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Field
		 */
		$this->start_controls_section(
			'prg_field_style_heading',
			array(
				'label' => __( 'Field', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_field_style_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-filter__field-input',
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
			'prg_field_style_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__field-input' => 'min-height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_field_style_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
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
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__field-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'prg_field_style_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#bfc2cc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__field-input' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_field_style_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__field-input' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Button
		 */
		$this->start_controls_section(
			'prg_button_style',
			array(
				'label' => __( 'Button', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_button_style_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button',
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
			'prg_button_style_border_type',
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
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
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
					'prg_button_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_border_padding',
			array(
				'label'      => __( 'Text Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '12',
					'bottom'   => '8',
					'left'     => '12',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_transition',
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
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_button_style_tabs' );

		$this->start_controls_tab(
			'prg_button_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_button_style_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_button_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_button_style_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_button_style_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_style_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_button_style_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-price .prodigy-main-button:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function set_widget_options( array $settings ): array {
		update_option( $this->get_id(), $settings );
		$attr = array();
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) === 'prg_' && ! is_array( $setting ) ) {
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		update_option( 'pg_elementor_price_filter', $attr );

		return $attr;
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
	    $params = $this->set_widget_options($settings);
        do_action('prodigy_shortcode_template_price_filter', $params);
    }
}
