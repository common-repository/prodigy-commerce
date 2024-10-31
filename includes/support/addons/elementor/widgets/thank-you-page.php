<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class ElementorThankYouPage extends Widget_Base {

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return 'pg-thank-you-page';
	}

	/**
	 * @inheritDoc
	 */
	public function get_title() {
		return __( 'Thank You Page', 'prodigy' );
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
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'prgicon prgicon-category';
	}


	/**
	 * @inheritDoc
	 */
	protected function register_controls() {
		/***** START HEADING */
		$this->start_controls_section(
			'section_thank_you_heading',
			array(
				'label' => __( 'Heading', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_heading_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => array(
					'left'  => array(
						'title' => __( 'Left', 'prodigy' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'prodigy' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'    => array(
						'title' => __( 'Right', 'prodigy' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page__title' => 'text-align: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'prg_main_container_padding',
			array(
				'label'          => __( 'Container Padding' ),
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
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page.container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);
		$this->add_responsive_control(
			'prg_heading_top_margin',
			array(
				'label'          => __( 'Top Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 80,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__title' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_responsive_control(
			'prg_heading_bottom_margin',
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
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_responsive_control(
			'prg_heading_inline_padding',
			array(
				'label'          => __( 'Inline Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__title' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_control(
			'prg_heading_text',
			array(
				'label'   => __( 'Text value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Thank you for your order.', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_heading_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__title',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 30,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 30,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 30,
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
			'prg_heading_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__title' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
		/***** END HEADING */

		/***** START CONTENT */
		$this->start_controls_section(
			'section_thank_you_content',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'prg_content_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => array(
					'start'  => array(
						'title' => __( 'Left', 'prodigy' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'prodigy' ),
						'icon'  => 'eicon-h-align-center',
					),
					'end'    => array(
						'title' => __( 'Right', 'prodigy' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt' => 'align-self: {{VALUE}}',
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'align-self: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'prg_content_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_text_typography',
				'label'          => __( 'Text Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt',
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
							'size' => 1.6,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.6,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.6,
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
			'prg_content_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_variable_typography',
				'label'          => __( 'Variable Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt .font-bold',
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
							'size' => 1.6,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.6,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.6,
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
			'prg_content_variable_color',
			array(
				'label'      => __( 'Variable Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-thank-you-page__txt .font-bold' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message',
			array(
				'label'     => __( 'Approval Message', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_content_approval_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} h5.prodigy-thank-you-page__approval-message',
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
							'size' => 1.6,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.6,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.6,
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
			'prg_content_approval_message_margin',
			array(
				'label'          => __( 'Margin', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => -20,
						'max' => 100,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '-20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '-20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '-20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_approval_message_padding',
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
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);


		$this->add_control(
			'prg_content_approval_message_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message_border_width',
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
					'prg_content_approval_message_border_type' => array(
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
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_content_approval_message_border_type' => array(
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
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message_border_type',
			array(
				'label'      => __( 'Border Type', 'prodigy' ),
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
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_content_approval_message_border_radius',
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
					'{{WRAPPER}} h5.prodigy-thank-you-page__approval-message' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
		/***** END CONTENT */

		/***** START BUTTON */
		$this->start_controls_section(
			'section_thank_you_button',
			array(
				'label' => __( 'Button', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'prg_button_responsive_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
						'step'=> 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step'=> 1,
					),
				),
				'default'        => array(
					'unit'     => 'px',
					'size'     => 'auto',
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'size'     => 'auto',
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'size'     => 'auto',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-custom-template a.prodigy-main-button.prodigy-main-button--link.prodigy-main-button--wide.prodigy-thanks-txt__content, .et-l div a.prodigy-main-button.prodigy-main-button--link.prodigy-main-button--wide.prodigy-thanks-txt__content',
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
			'prg_button_border_type',
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
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'border-style: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'prg_button_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);
		$this->add_control(
			'prg_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);
		$this->add_responsive_control(
			'prg_button_text_padding',
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
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);
		$this->add_responsive_control(
			'prg_button_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 80,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_button_tabs' );

		$this->start_controls_tab(
			'prg_button_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_button_text_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_button_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_bg_color_hover',
			array(
				'label'     =>__( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_button_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.2,
				),
				'range'     => array(
					'px' => array(
						'max'  => 2,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-thank-you-page .prodigy-main-button--link' => 'transition: all {{SIZE}}s',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		/***** END BUTTON */
	}

	/**
	 * @param $attr
	 *
	 * @return array
	 */
	public function set_widget_options( $settings ) :array {
        foreach ( $settings as $key => $setting ) {
            if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
                $attr[ str_replace( 'prg_', '', $key ) ] = $setting;
            }
        }

		$attr['heading_text'] = $attr['heading_text'] ?? 'Thank you for your order.';

		return $attr;
	}

	/**
	 * @inheritDoc
	 */
	protected function render() {
		$sett_prg = $this->get_settings_for_display();
		$attr = $this->set_widget_options( $sett_prg );

		do_action('prodigy_shortcode_template_thank_you', $attr );
	}
}
