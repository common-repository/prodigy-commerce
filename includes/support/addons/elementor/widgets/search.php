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
class ElementorSearch extends Widget_Base {

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
		return 'pae-search';
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
		return __( 'Product Search', 'prodigy' );
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
		return 'prgicon prgicon-product-search';
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
			'prg_style_search_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_search_type',
			array(
				'label'   => __( 'Type', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
                    'button'  => __( 'Button', 'prodigy' ),
                    'normal'  => __( 'Normal', 'prodigy' ),
				),
				'default' => 'normal',
			)
		);

		$this->add_responsive_control(
			'prg_style_search_dropdown_alignment',
			array(
				'label'          => __( 'Dropdown Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'options'        => array(
					'start'         => __( 'Left', 'prodigy' ),
					'center'        => __( 'Center', 'prodigy' ),
					'end'           => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'align-items: {{VALUE}} !important',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_dropdown_left_offset',
			array(
				'label'          => __( 'Left Offset', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em', '%' ),
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'left: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_dropdown_right_offset',
			array(
				'label'          => __( 'Right Offset', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em', '%' ),
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'right: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_dropdown_icon_size',
			array(
				'label'          => __( 'Main Icon Size', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown .prodigy-search__custom-search > *:not(.prodigy-search__custom-title)' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->start_controls_tabs( 'dropdown_search_style_tabs' );

		$this->start_controls_tab(
			'dropdown_search_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'dropdown_search_style_icon_color',
			array(
				'label'      => __( 'Main Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown .prodigy-search__custom-search > *:not(.prodigy-search__custom-title)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dropdown_search_style_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'dropdown_search_style_icon_color_hover',
			array(
				'label'      => __( 'Main Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown:hover .prodigy-search__custom-search > *:not(.prodigy-search__custom-title)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dropdown_search_style_icon_transition',
			array(
				'label'      => __( 'Main Icon Transition Duration' ),
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown .prodigy-search__custom-search > *' => 'transition-duration: {{SIZE}}s !important',
				),
			)
		);

		$this->add_control(
			'prg_search_dropdown_text_visibility',
			array(
				'label'          => __( 'Text Visibility', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'block',
				'options'        => array(
					'block'    => __( 'Visible', 'prodigy' ),
					'none'     => __( 'Hidden', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown .prodigy-search__custom-title' => 'display: {{VALUE}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_search_dropdown_icon_position',
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown-wrap' => 'flex-direction: {{VALUE}} !important',
				),
				'condition'      => array(
					'prg_search_dropdown_text_visibility' => 'block',
				),
			)
		);

		$this->add_responsive_control(
			'prg_search_dropdown_icon_spacing',
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown-wrap' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_search_dropdown_text_visibility' => 'block',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_search_dropdown_text_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-search__custom-title',
				'condition'      => array(
					'prg_search_dropdown_text_visibility' => 'block',
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
				),
			)
		);

		$this->start_controls_tabs( 'prg_style_search_dropdown_text_tabs',
			array(
				'condition'      => array(
					'prg_search_dropdown_text_visibility' => 'block',
				),
			),
		);

		$this->start_controls_tab(
			'prg_style_search_dropdown_text_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown .prodigy-search__custom-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_style_search_dropdown_text_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown:hover .prodigy-search__custom-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_search_dropdown_input_width',
			array(
				'label'          => __( 'Dropdown Input Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 33,
					'unit' => '%',
				),
				'tablet_default' => array(
					'size' => 50,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 100,
					'unit' => '%',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search-wrap' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_bg_color',
			array(
				'label'      => __( 'Dropdown Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'background-color: {{VALUE}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_bg_overlay_color',
			array(
				'label'      => __( 'Dropdown Backdrop Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'rgba(0, 0, 0, 0.25)',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown--open:after' => 'background-color: {{VALUE}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_dropdown_main_padding',
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
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
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
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_border_width',
			array(
				'label'      => __( 'Dropdown Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'prg_style_search_dropdown_border_color',
			array(
				'label'      => __( 'Dropdown Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__custom-dropdown-block-search' => 'border-color: {{VALUE}}',
				),
				'condition'      => array(
					'prg_style_search_type' => array( 'button' ),
				),
			)
		);

		$this->add_control(
			'prg_style_search_icon',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-search',
					'library' => 'solid',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_icon_size',
			array(
				'label'          => __( 'Icon Size', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-search__icon > *' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-search__custom-search > *:not(.prodigy-search__custom-title)' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_close_icon_size',
			array(
				'label'          => __( 'Close Icon Size', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-search__close-icon' => 'width: {{SIZE}}{{UNIT}}',
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
					'size' => 30,
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
					'{{WRAPPER}} .prodigy-search__input' => 'padding-left: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_icon_left_margin',
			array(
				'label'          => __( 'Left Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-search__icon' => 'left: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_search_icon_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-search__input' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'prg_style_search_icon_placeholder',
			array(
				'label'   => __( 'Placeholder text', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Search',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_search_icon_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-search__input',
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
				),
			)
		);

		$this->add_control(
			'prg_style_search_icon_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_search_icon_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'search_style_tabs' );

		$this->start_controls_tab(
			'search_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_search_icon_color',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-search__custom-search i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_close_icon_color',
			array(
				'label'      => __( 'Close Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__close-icon:after' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-search__close-icon:before' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_width',
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
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_style_tab_focus',
			array(
				'label' => __( 'Focus', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_search_icon_color_focus',
			array(
				'label'      => __( 'Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus ~ .prodigy-search__icon i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_close_icon_color_focus',
			array(
				'label'      => __( 'Close Icon Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus ~ .prodigy-search__close-icon:after' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-search__input:focus ~ .prodigy-search__close-icon:before' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_width_focus',
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
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_color_focus',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_search_border_radius_focus',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus' => 'border-radius: {{SIZE}}{{UNIT}}',
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
	public function set_widget_options( array $settings ) :array {
		if ( isset( $settings['prg_style_sorting_text'] ) && empty( trim( $settings['prg_style_sorting_text'] ) ) ) {
			$settings['prg_style_sorting_text'] = 'Showing';
		}

		$settings['type'] = $settings['prg_style_search_type'];
		$settings['idWidget'] = $this->get_id();

		update_option( $this->get_id(), $settings );

		return $settings;
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
		$widget_options = $this->get_settings_for_display();
		$attr = $this->set_widget_options( $widget_options );

		do_action( 'prodigy_shortcode_template_search', $attr );
	}
}
