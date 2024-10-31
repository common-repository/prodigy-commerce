<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorTabs extends \Elementor\Widget_Base {
	const CONTENT_DESCRIPTION_TAB = 'general_tabs_controls_content_description';
	const ADDITIONAL_TAB          = 'general_tabs_controls_content_additional_info';
	const REVIEW_TAB              = 'general_tabs_controls_content_reviews';
	const TIERED_PRICES_TAB        = 'general_tabs_controls_content_tiered_prices';
	const TAB_VALUE_NEGATIVE_OPTION = 'no';
	const TAB_VALUE_POSITIVE_OPTION = 'yes';

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'pae-tabs';
	}

	/**
	 * Get widget price-range.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Product Data Tabs', 'prodigy' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'prgicon prgicon-product-data-tabs';
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
		 * Content
		 */
		$this->start_controls_section(
			'prg_content_general_tabs',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_general_tabs_controls_content',
			array(
				'label'     => __( 'Tabs', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_' . self::CONTENT_DESCRIPTION_TAB,
			array(
				'label'        => __( 'Description', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_' . self::ADDITIONAL_TAB,
			array(
				'label'        => __( 'Additional Information', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_' . self::REVIEW_TAB,
			array(
				'label'        => __( 'Reviews', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'prodigy' ),
				'label_on'     => __( 'Show', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

        $this->add_control(
            'prg_' . self::TIERED_PRICES_TAB,
            array(
                'label'        => __( 'QTY and Price Breaks', 'prodigy' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __( 'Hide', 'prodigy' ),
                'label_on'     => __( 'Show', 'prodigy' ),
                'default'      => 'no',
                'return_value' => 'yes',
            )
        );

		$this->end_controls_section();

		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_general_tabs_description',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_controls_style_general_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 40,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 40,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_label',
			array(
				'label'     => __( 'Tabs List', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 10,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-list' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-tabs__tabs-link, .prodigy-product__accordion-subtitle',
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

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_mobile_typography',
				'label'          => __( 'Typography(mobile)', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__accordion-subtitle',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'em',
							'size' => 1.8,
						),
					),
					'letter_spacing' => array(
						'default' => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'word_spacing'   => array(
						'default' => array(
							'unit' => 'em',
							'size' => 0,
						),
					),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_border_type',
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
					'{{WRAPPER}} .prodigy-tabs__tabs-list' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
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
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_general_tabs_border_type' => array(
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
					'{{WRAPPER}} .prodigy-tabs__tabs-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_border_type' => array(
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
					'{{WRAPPER}} .prodigy-tabs__tabs-list' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ul.prodigy-tabs__tabs-list' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_padding',
			array(
				'label'      => __( 'Tabs Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_active_link_border_color',
			array(
				'label'     => __( 'Active Link Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link.active' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_active_link_border_width',
			array(
				'label'      => __( 'Active Link Border Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link.active' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_tabs_tabs' );

		$this->start_controls_tab(
			'prg_general_tabs_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_normal_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__accordion-subtitle' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_normal_text_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_general_tabs_active',
			array(
				'label' => __( 'Active', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_active_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link.active' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_active_text_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tabs__tabs-link.active' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Description
		 */
		$this->start_controls_section(
			'prg_general_tabs_description_label',
			array(
				'label'     => __( 'Description', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
                    'prg_' . self::CONTENT_DESCRIPTION_TAB => array( 'yes' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_description_alignment',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'desktop_default' => 'left',
				'tablet_default'  => 'left',
				'mobile_default'  => 'left',
				'options'         => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} #tab-description .prodigy-tabs__desc' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_description_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} #tab-description .prodigy-tabs__desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_description_text',
			array(
				'label'     => __( 'Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_description_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-tabs__desc p, .prodigy-product__card-desc p, .prodigy-tabs__desc *, .prodigy-tabs__desc',
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
			'prg_general_tabs_description_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} #tab-description .prodigy-tabs__desc p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-card__desc p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_description_text_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} #tab-description .prodigy-tabs__desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);
		$this->end_controls_section();

		/*
		 * Additional Info
		 */
		$this->start_controls_section(
			'prg_general_tabs_additional',
			array(
				'label'     => __( 'Additional Info', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_' . self::ADDITIONAL_TAB => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_label',
			array(
				'label'     => __( 'General', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_additional_alignment',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'desktop_default' => 'left',
				'tablet_default'  => 'left',
				'mobile_default'  => 'left',
				'options'         => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} .prodigy-product__additional' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_additional_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__additional' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_additional_tabs' );

		$this->start_controls_tab(
			'prg_general_additional_label',
			array(
				'label' => __( 'Title', 'prodigy' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_additional_label_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__additional-col-title',
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

		$this->add_control(
			'prg_general_tabs_additional_label_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_additional_label_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_label_padding_border',
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
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_label_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_general_tabs_additional_label_padding_border' => array(
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
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_label_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_label_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_additional_label_padding_border' => array(
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
					'{{WRAPPER}} .prodigy-product__additional-col-title' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_general_tabs_additional_values',
			array(
				'label' => __( 'Value', 'prodigy' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_additional_values_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__additional-col-value',
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
						'default' => 500,
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
			'prg_general_tabs_additional_values_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_additional_values_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '10',
					'right'    => '8',
					'bottom'   => '10',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_values_padding_border',
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
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_values_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_general_tabs_additional_values_padding_border' => array(
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
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_values_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_additional_values_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_additional_values_padding_border' => array(
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
					'{{WRAPPER}} .prodigy-product__additional-col-value' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Reviews
		 */
		$this->start_controls_section(
			'prg_general_tabs_reviews',
			array(
				'label'     => __( 'Reviews', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
                    'prg_' . self::REVIEW_TAB => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_reviews_general',
			array(
				'label'     => __( 'General', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_reviews_general_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_title',
			array(
				'label'     => __( 'Reviews Rating Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_title_default_text',
			array(
				'label'   => __( 'Text Value', 'prodigy' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Average Customer Rating',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_rating_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .review-rating-title',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 25,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 25,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 25,
						),
					),
					'font_weight'    => array(
						'default' => 700,
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
			'prg_general_tabs_review_rating_title_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .review-rating-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_rating_title_margin_bottom',
			array(
				'label'      => __( 'Margin Bottom', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .review-rating-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_stars',
			array(
				'label'     => __( 'Reviews Rating Stars', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_stars_color',
			array(
				'label'      => __( 'Stars Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating__item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_empty_stars_color',
			array(
				'label'      => __( 'Empty Stars Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e5e5e5',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_rating__star_size',
			array(
				'label'          => __( 'Star Size', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 32,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 32,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 32,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating' => 'width: calc({{SIZE}}{{UNIT}} * 5); height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating:before' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating__item' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating__item:before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_rating_star_margin_right',
			array(
				'label'          => __( 'Margin Right', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-reviews-ratings__rating .prodigy-star-rating' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_average',
			array(
				'label'     => __( 'Rating Average', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_rating_average_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-reviews-ratings__average',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 20,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 20,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 20,
						),
					),
					'font_weight'    => array(
						'default' => 700,
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
			'prg_general_tabs_review_rating_average_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__average' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_count',
			array(
				'label'     => __( 'Reviews Count', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_count_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-reviews-ratings__count',
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
			'prg_general_tabs_review_count_text_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__count' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_count_margin_left',
			array(
				'label'          => __( 'Margin Left', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-reviews-ratings__count' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button',
			array(
				'label'     => __( 'Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-reviews-ratings__btn',
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
			'prg_general_tabs_review_button_border_type',
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
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_border_width',
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
					'prg_general_tabs_review_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_button_padding',
			array(
				'label'          => __( 'Text Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_hover_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_tabs_review_button_tabs' );

		$this->start_controls_tab(
			'prg_general_tabs_review_button_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_normal_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_normal_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_normal_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_general_tabs_review_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-reviews-ratings__btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_general_tabs_review_button_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_hover_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-reviews-ratings__btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_button_hover_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_general_tabs_review_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-reviews-ratings__btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_general_tabs_review_rating_box',
			array(
				'label'     => __( 'Review Rating Box', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_border_type',
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
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_border_width',
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
					'prg_general_tabs_review_rating_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_rating_box_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_tabs_review_rating_box_button_tabs' );

		$this->start_controls_tab(
			'prg_general_tabs_review_rating_box_button_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .prodigy-reviews-ratings',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_normal_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_normal_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_general_tabs_review_rating_box_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-reviews-ratings:hover',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-reviews-ratings:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_rating_box_hover_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-reviews-ratings:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Review Item
		 */
		$this->start_controls_section(
			'prg_general_tabs_review_item',
			array(
				'label' => __( 'Review Item', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_info_inner',
			array(
				'label'     => __( 'Review Info Inner', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_item_info_inner_margin_right',
			array(
				'label'          => __( 'Margin Right', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-review__info-inner' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_author',
			array(
				'label'     => __( 'Review Author', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_author_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-review__author',
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
						'default' => 700,
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
			'prg_general_tabs_review_author_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__author' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_author_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-review__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_date',
			array(
				'label'     => __( 'Review Date', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_date_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-review__date',
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
			'prg_general_tabs_review_date_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__date' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_date_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-review__avatar-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_stars',
			array(
				'label'     => __( 'Stars', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_stars_color',
			array(
				'label'      => __( 'Stars Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating__item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_empty_stars_color',
			array(
				'label'      => __( 'Empty Stars Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e5e5e5',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_item_stars_size',
			array(
				'label'          => __( 'Star Size', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating' => 'width: calc({{SIZE}}{{UNIT}} * 5); height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating:before' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating__item' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating__item:before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_item_stars_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-review__item .prodigy-star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_review_text',
			array(
				'label'     => __( 'Review Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_review_item_review_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-review__text',
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
			'prg_general_tabs_review_item_review_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-review__text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_review_item_review_text_margin_bottom',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 22,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-review > .depth-1' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box',
			array(
				'label'     => __( 'Review Item Box', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_border_type',
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
					'{{WRAPPER}} .prodigy-review__item' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '1',
					'left'     => '0',
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_general_tabs_review_item_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-review__item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__item' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '32',
					'right'    => '0',
					'bottom'   => '32',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-review__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_general_tabs_review_item_box_tabs' );

		$this->start_controls_tab(
			'prg_general_tabs_review_item_box_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'prodigy' ),
				'name'     => 'block_box_shadow',
				'selector' => '{{WRAPPER}} .prodigy-review__item',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-review__item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_review_item_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-review__item' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_general_tabs_review_item_box_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'prodigy' ),
				'name'     => 'block_box_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-review__item:hover',
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-review__item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_review_item_box_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_review_item_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-review__item:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Tiered Price Item
		 */
		$this->start_controls_section(
			'prg_general_tabs_tiered_item',
			array(
				'label' => __( 'Tiered Price', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_info',
			array(
				'label'     => __( 'Tiered Price Info Text', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_alignment',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'desktop_default' => 'left',
				'tablet_default'  => 'left',
				'mobile_default'  => 'left',
				'options'         => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} .prodigy-tab__tiered-info' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .prodigy-product__accordion-card .prodigy-tab__tiered-info' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_tiered_item_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-tabs__desc > .prodigy-tab__tiered-info, .prodigy-product__accordion-card .prodigy-tab__tiered-info',
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
			'prg_general_tabs_tiered_item_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tab__tiered-info' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-tab__tiered-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-tab__tiered-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__accordion-card .prodigy-tab__tiered-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table',
			array(
				'label'     => __( 'Price Table', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_table_margin',
			array(
				'label'          => __( 'Table Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_border_type',
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
					'{{WRAPPER}} .prodigy-table__bulk-qty-description' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head' => 'border-bottom-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell' => 'border-bottom-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .flex-1:nth-child(2), .prodigy-table__bulk-qty-description-head .flex-1:nth-child(2)' => 'border-block-style: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .d-md-none' => 'border-right-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_border_width',
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
					'prg_general_tabs_border_type' => array(
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
					'{{WRAPPER}} .prodigy-table__bulk-qty-description' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell:not(:last-child):not(:only-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .flex-1:nth-child(2), .prodigy-table__bulk-qty-description-head .flex-1:nth-child(2)' => 'border-block-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .d-md-none' => 'border-right-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'condition'  => array(
					'prg_general_tabs_border_type' => array(
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
					'{{WRAPPER}} .prodigy-table__bulk-qty-description' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .flex-1:nth-child(2), .prodigy-table__bulk-qty-description-head .flex-1:nth-child(2)' => 'border-block-color: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell .d-md-none' => 'border-right-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_header',
			array(
				'label'     => __( 'Price Table Header', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_tiered_item_table_header_typography',
				'label'          => __( 'Header Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-table__bulk-qty-description-head > div, .prodigy-table__bulk-qty-description > .prodigy-table__bulk-qty-description-cell .d-md-none.prodigy-table__bulk-qty-description-head-sm',
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
						'default' => 700,
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
			'prg_general_tabs_tiered_item_table_header_text_color',
			array(
				'label'      => __( 'Header Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head > div' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description > .prodigy-table__bulk-qty-description-cell .d-md-none.prodigy-table__bulk-qty-description-head-sm' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_header_bg_color',
			array(
				'label'      => __( 'Header Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#f4f5f6',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description > .prodigy-table__bulk-qty-description-cell .d-md-none.prodigy-table__bulk-qty-description-head-sm' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_table_header_padding',
			array(
				'label'          => __( 'Header Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '16',
					'right'    => '8',
					'bottom'   => '16',
					'left'     => '8',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '16',
					'right'    => '8',
					'bottom'   => '16',
					'left'     => '8',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '16',
					'right'    => '8',
					'bottom'   => '16',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_table_header_cell_padding',
			array(
				'label'          => __( 'Header Cell Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '6',
					'right'    => '8',
					'bottom'   => '6',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-table__bulk-head-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head-sm' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_header_cell_mobile_width',
			array(
				'label'      => __( 'Header Cell Width (Mobile)', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'size' => 30,
					'unit' => '%',
				),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-head-sm' => 'flex-basis: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_table_row',
			array(
				'label'     => __( 'Price Table Row', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_table_row_padding',
			array(
				'label'          => __( 'Table Row Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '16',
					'right'    => '8',
					'bottom'   => '16',
					'left'     => '8',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '16',
					'right'    => '8',
					'bottom'   => '16',
					'left'     => '8',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_general_tabs_tiered_item_table_row_cell_typography',
				'label'          => __( 'Row Cell Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-table__bulk-body-cell > span:not(.prodigy-table__bulk-qty-description-head)',
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
			'prg_general_tabs_tiered_item_row_cell_text_color',
			array(
				'label'      => __( 'Row Cell Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-table__bulk-body-cell span:not(.prodigy-table__bulk-qty-description-head)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_general_tabs_tiered_item_row_cell_bg_color',
			array(
				'label'      => __( 'Row Cell Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-table__bulk-qty-description-cell' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-table__bulk-body-cell > span:not(.d-md-none)' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_general_tabs_tiered_item_table_row_cell_padding',
			array(
				'label'          => __( 'Row Cell Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-table__bulk-body-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 *
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		update_option( $this->get_id(), $settings );

		$sett_prg = array();
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$sett_prg[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$sett_prg['idWidget']           = $this->get_id();
		$sett_prg['default_product_id'] = Prodigy_Product_Template_Builder::get_random_product();
		$sett_prg['general_tabs_controls_content_tiered_prices'] = self::TAB_VALUE_POSITIVE_OPTION === $sett_prg[ self::TIERED_PRICES_TAB ];
		$sett_prg['general_tabs_controls_content_description'] = self::TAB_VALUE_POSITIVE_OPTION === $sett_prg[ self::CONTENT_DESCRIPTION_TAB ];
		$sett_prg['general_tabs_controls_content_additional_info'] = self::TAB_VALUE_POSITIVE_OPTION === $sett_prg[ self::ADDITIONAL_TAB ];
		$sett_prg['general_tabs_controls_content_reviews'] = self::TAB_VALUE_POSITIVE_OPTION === $sett_prg[ self::REVIEW_TAB ];

		do_action( 'prodigy_after_single_product_tabs', array( 'settings' => $sett_prg ) );
	}
}
