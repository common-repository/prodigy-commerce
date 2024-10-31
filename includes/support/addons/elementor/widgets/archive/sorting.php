<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorSorting extends Widget_Base {

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return 'pae-sorting';
	}

	/**
	 * @inheritDoc
	 */
	public function get_title():string {
		return __( 'Product Sorting', 'prodigy' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_icon():string {
		return 'prgicon prgicon-product-sorting';
	}

	/**
	 * @inheritDoc
	 */
	public function get_categories(): array {
		return array( 'prodigy-elements-archive' );
	}

	/**
	 * @inheritDoc
	 */
	protected function register_controls() {
		/*
		 * TAB style
		 */
		$this->start_controls_section(
			'prg_style_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'flex-end',
				'tablet_default' => 'flex-end',
				'mobile_default' => 'flex-end',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-sort' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_sorting_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-sort',
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
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_sorting_mobile_title_typography',
				'label'          => __( 'Mobile Title Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-custom-template .prodigy-select-md .prodigy-select-md__header .prodigy-select-md__header-title',
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
			)
		);

		$this->add_control(
			'prg_style_sorting_dropdown_width',
			array(
				'label'          => __( 'Dropdown Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default' => array(
					'size' => 100,
					'unit' => '%',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-custom-select.jq-selectbox .jq-selectbox__dropdown' => 'width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);


		$this->add_control(
			'prg_style_sorting_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#666666',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-sort' => 'color: {{VALUE}}',
				),
			)
		);
		

		$this->add_control(
			'prg_style_sorting_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__select' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_color_border',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__select' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_border_width_focus',
			array(
				'label'      => __( 'Focus Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select.focused .jq-selectbox__select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_color_border_focus',
			array(
				'label'      => __( 'Focus Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select.focused .jq-selectbox__select' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_border_radius_focus',
			array(
				'label'      => __( 'Focus Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select.focused .jq-selectbox__select' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_style_sorting_tabs' );

		$this->start_controls_tab(
			'prg_style_sorting_tab_selected',
			array(
				'label' => __( 'Selected', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_sorting_option_color_selected',
			array(
				'label'      => __( 'Option Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__dropdown li.selected' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_option_bg_color_selected',
			array(
				'label'      => __( 'Option Background', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#A3ABB1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__dropdown li.selected' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_style_sorting_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_sorting_option_color_hover',
			array(
				'label'      => __( 'Option Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__dropdown li:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sorting_option_bgcolor_hover',
			array(
				'label'      => __( 'Option Background', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0088cc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__dropdown li:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_gen_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-sort' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_width',
			array(
				'label'      => __( 'Arrow Button Right', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .jq-selectbox__trigger-arrow:before' => 'right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_height',
			array(
				'label'      => __( 'Arrow Button Top', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__trigger-arrow' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_font_size',
			array(
				'label'      => __( 'Arrow Font Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__trigger-arrow:before' => 'height: {{SIZE}}{{UNIT}} !important; width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_font_weight',
			array(
				'label'      => __( 'Arrow Font Weight', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__trigger-arrow:before' => 'border-top-width: {{SIZE}}{{UNIT}} !important; border-left-width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);


		$this->start_controls_tabs( 'prg_attrs_style_arrow_button_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_arrow_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_color',
			array(
				'label'     => __( 'Arrow Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-custom-select .jq-selectbox__trigger-arrow:before' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_sorting_style_arrow_button_tab_focus',
			array(
				'label' => __( 'Focus', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_sorting_style_arrow_button_color_focus',
			array(
				'label'     => __( 'Arrow Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'selectors' => array(
					'{{WRAPPER}} .opened .jq-selectbox__trigger-arrow:before' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * @inheritDoc
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( trim( $settings['style_sorting_text'] ?? '' ) ) ) {
			$settings['style_sorting_text'] = 'Showing';
		}
		$settings['widget_products'] = get_option( 'pg_elementor_archive_widget' );

		do_action( 'prodigy_shop_sortable_block', array( 'elementor_settings' => $settings ) );
	}
}
