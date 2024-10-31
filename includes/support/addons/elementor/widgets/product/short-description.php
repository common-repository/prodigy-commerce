<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorShortDescription extends \Elementor\Widget_Base {

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
		return 'pae-short-description-product';
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
		return __( 'Product Description', 'prodigy' );
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
		return 'prgicon prgicon-product-description';
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
		return array( 'prodigy-elements-single' );
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
		 * Content
		 */
		$this->start_controls_section(
			'prg_content_description_gen',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_content_description_show',
			array(
				'label'        => __( 'Truncate', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'prodigy' ),
				'label_off'    => __( 'Disable', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'prg_content_description_truncate_chars',
			array(
				'label'      => __( 'Characters', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'condition'  => array(
					'prg_content_description_show' => array( 'yes' ),
				),
			)
		);

		$this->end_controls_section();

		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_style_description_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_alignment_text',
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
					'{{WRAPPER}} .prodigy-product__description' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_anchor_margin_description',
			array(
				'label'          => __( 'Anchor Margin', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__description-container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_container_margin_description',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Text
		 */
		$this->start_controls_section(
			'prg_style_title_description',
			array(
				'label' => __( 'Text', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_description_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__description-container',
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
			'prg_style_description_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-container' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_description_text_padding',
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
					'{{WRAPPER}} .prodigy-product__description-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Anchor
		 */
		$this->start_controls_section(
			'prg_style_description_anchor',
			array(
				'label'     => __( 'Anchor', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_description_show' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_type',
			array(
				'label'   => __( 'Type', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'link',
				'options' => array(
					'link'   => __( 'Link', 'prodigy' ),
					'button' => __( 'Button', 'prodigy' ),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_anchor_link_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__description-control',
				'condition'      => array(
					'prg_style_anchor_type' => array( 'link' ),
				),
				'fields_options' => array(
					'typography'      => array( 'default' => 'yes' ),
					'font_size'       => array(
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
					'font_weight'     => array(
						'default' => 400,
					),
					'text_decoration' => array(
						'default' => 'underline',
					),
					'line_height'     => array(
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

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_anchor_btn_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__description-control',
				'condition'      => array(
					'prg_style_anchor_type' => array( 'button' ),
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
			'prg_style_anchor_border_type',
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
				'condition' => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_border_width',
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
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_anchor_border_type' => array(
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
					'prg_style_anchor_type'        => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'condition'  => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_description_padding',
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
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => true,
				),
				'condition'      => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab(
			'classic_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_anchor_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'link' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_btn_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_background_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_style_anchor_border_type' => array(
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
					'prg_style_anchor_type'        => array( 'button' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'classic_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_anchor_text_color_hover',
			array(
				'label'      => __( 'Text Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'link' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_btn_text_color_hover',
			array(
				'label'      => __( 'Text Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_background_color_hover',
			array(
				'label'      => __( 'Background Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'condition'  => array(
					'prg_style_anchor_type' => array( 'button' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_anchor_border_color_hover',
			array(
				'label'     => __( 'Border Color Hover', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_style_anchor_border_type' => array(
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
					'prg_style_anchor_type'        => array( 'button' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product__description-control--btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
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

		update_option( $this->get_id(), $settings );

		$sett_prg['idwidget'] = $this->get_id();

		do_action( 'prodigy_product_short_description', array( 'settings' => $sett_prg ) );
	}
}
