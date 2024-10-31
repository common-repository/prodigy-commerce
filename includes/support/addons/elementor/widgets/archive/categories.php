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
 * @version 2.0.7
 */
class ElementorBrowseCategories extends Widget_Base {

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
		return 'pae-browse-categories';
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
		return __( 'Product Categories', 'prodigy' );
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
		return 'prgicon prgicon-product-categories';
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
		return array( 'prodigy-elements-archive' );
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
			'prg_browse_content_type_gen',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_set_show_product_count',
			array(
				'label'        => __( 'Products Count', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show' ),
				'label_off'    => __( 'Hide' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_browse_style_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_browse_style_bottom_margin',
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
					'{{WRAPPER}} .prodigy-filter__main' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Heading
		 */
		$this->start_controls_section(
			'prg_browse_style_heading',
			array(
				'label' => __( 'Heading', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_browse_style_heading_text',
			array(
				'label'   => __( 'Text value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Browse',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_browse_style_heading_typography',
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
			'prg_browse_style_heading_text_color',
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
			'prg_browse_style_heading_alignment',
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
			'prg_browse_style_heading_bottom_spacing',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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

		/*
		 * Category Name
		 */
		$this->start_controls_section(
			'prg_browse_style_cat_name',
			array(
				'label' => __( 'Category Name', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_browse_style_cat_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .filter__card-link-category-id',
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

		$this->start_controls_tabs( 'prg_browse_style_cat_name_tabs' );

		$this->start_controls_tab(
			'prg_browse_style_cat_name_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_browse_style_cat_name_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'selectors'  => array(
					'{{WRAPPER}} .filter__card-link-category-id' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_browse_style_cat_name_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_browse_style_cat_name_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .filter__card-link-category-id:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_browse_style_cat_name_tab_active',
			array(
				'label' => __( 'Active', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_browse_style_cat_name_color_active',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .filter__card-link-category-id.filter__card-link--active' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Products Count
		 */
		$this->start_controls_section(
			'prg_browse_style_prod_count',
			array(
				'label'     => __( 'Products Count', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_set_show_product_count' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_browse_style_prod_count_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .filter__card-count',
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
			'prg_browse_style_prod_count_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .filter__card-count' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Filter Card Box
		 */
		$this->start_controls_section(
			'prg_browse_style_card_box',
			array(
				'label' => __( 'Filter Card Box', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_border_type',
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
					'{{WRAPPER}} .prodigy-filter__card' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_border_width',
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
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_browse_style_card_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_browse_style_card_box_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-filter__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'card_box_tabs' );

		$this->start_controls_tab(
			'card_box_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_browse_style_card_box_shadow',
				'selector' => '{{WRAPPER}} .prodigy-filter__card',
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_browse_style_card_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_box_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_browse_style_card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-filter__card:hover',
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_box_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_browse_style_card_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Filter Card List
		 */
		$this->start_controls_section(
			'prg_browse_style_card_list',
			array(
				'label' => __( 'Filter Card List', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_border_type',
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
					'{{WRAPPER}} .prodigy-filter__card-list' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_border_width',
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
					'left'     => '1',
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_browse_style_card_list_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-list' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-list' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '12',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'card_list_tabs' );

		$this->start_controls_tab(
			'card_list_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_browse_style_card_list_shadow',
				'selector' => '{{WRAPPER}} .prodigy-filter__card-list',
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-list' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_browse_style_card_list_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-list' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_list_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_browse_style_card_list_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-filter__card-list:hover',
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-list:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_card_list_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_browse_style_card_list_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-list:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Arrow Button
		 */
		$this->start_controls_section(
			'prg_browse_style_arrow_button',
			array(
				'label' => __( 'Arrow Button', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_browse_style_arrows_button_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-btn' => 'min-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrows_button_size',
			array(
				'label'      => __( 'Arrow Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-arrow-down:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_color',
			array(
				'label'     => __( 'Arrow Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .icon-arrow-down:before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_font_weight',
			array(
				'label'      => __( 'Arrow Font Weight', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-header .prodigy-filter__card-btn .icon-arrow-down:before, .prodigy-filter__card-list .prodigy-filter__card-btn .icon-arrow-down:before' => 'border-top-width: {{SIZE}}{{UNIT}} !important; border-left-width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_border_type',
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
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_border_width',
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
					'prg_browse_style_arrow_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_transition',
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
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'arrow_button_tabs' );

		$this->start_controls_tab(
			'arrow_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_color',
			array(
				'label'     => __( 'Arrow Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}}  .prodigy-filter__card-header .prodigy-filter__card-btn .icon-arrow-down:before' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrow_button_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_color_hover',
			array(
				'label'     => __( 'Arrow Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'selectors' => array(
					'{{WRAPPER}}  .prodigy-filter__card-header .prodigy-filter__card-btn:hover .icon-arrow-down:before' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_browse_style_arrow_button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn:hover' => 'border-color: {{VALUE}}',
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

        $sett_prg = array();
        foreach ( $settings as $key => $setting ) {

            if ( substr( $key, 0, 8 ) == 'prg_set_' && ! empty( $setting ) ) {

                $sett_prg[] = str_replace( 'prg_set_', '', $key ) . '="' . $setting . '"';
            }
        }

        $sett_prg[] = 'idWidget="' . $this->get_id() . '"';

        echo do_shortcode( '[prodigy_categories_filter ' . implode( ' ', $sett_prg ) . ']' );
	}
}
