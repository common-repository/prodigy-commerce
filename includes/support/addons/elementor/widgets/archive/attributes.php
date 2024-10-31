<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Prodigy_Content_Catalog;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorAttributes extends Widget_Base {

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
		return 'pae-attributes';
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
		return __( 'Product Filters' );
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
		return 'prgicon prgicon-product-filters';
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
			'prg_attrs_content_gen',
			array(
				'label' => 'Content',
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_attrs_content_type',
			array(
				'label'   => __( 'Type' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'accordion' => 'Accordion',
					'list'      => 'List',
				),
				'default' => 'accordion',
			)
		);

		$this->add_control(
			'prg_attrs_content_prod_count',
			array(
				'label'     => __( 'Products Count' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show' ),
				'label_off' => __( 'Hide' ),
				'default'   => 'yes',
			)
		);

		$catalog = Prodigy_Content_Catalog::getInstance();
		$query   = $_GET ?? array();
		if ( ! $catalog->getMain ) {
			$catalog->init( $query, true );
		}
		$attributes = array();
		$filter     = $catalog->get_attributes();
		foreach ( $filter as $attribute ) {
			$attributes[ $attribute['id'] ] = $attribute['name'];
		}

		$this->add_control(
			'prg_attrs_content_view_attributes',
			array(
				'label'    => __( 'Filter by', 'prodigy' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => $attributes,
				'default'  => array_keys( $attributes ),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_name_limit_list',
			array(
				'label'       => __( 'Number of visible items' ),
				'description' => 'Max number of attribute values to show before "Show more" button. <br/>
								Select 0 to show all items.',
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 50,
				'default'     => 4,
			)
		);

		$this->add_control(
			'prg_attrs_content_expanded_sections_list',
			array(
				'label'       => __( 'Number of expanded sections' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 50,
				'default'     => 1,
				'condition'      => array(
					'prg_attrs_content_type' => array( 'accordion' ),
				),
			)
		);

		$this->end_controls_section();

		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_attrs_style_gen',
			array(
				'label' => 'General',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_bottom_margin',
			array(
				'label'          => __( 'Filter Item Bottom Margin' ),
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
					'{{WRAPPER}} .prodigy-filter__item + .prodigy-filter__item' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Heading
		 */
		$this->start_controls_section(
			'prg_attrs_style_heading',
			array(
				'label' => __( 'Heading' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_attrs_style_heading_text',
			array(
				'label'   => __( 'Text value' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Filter by',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attrs_style_heading_typography',
				'label'          => esc_html( 'Typography' ),
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
			'prg_attrs_style_heading_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} h3.prodigy-filter__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_heading_alignment',
			array(
				'label'          => __( 'Alignment' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'left',
				'options'        => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'selectors'      => array(
					'{{WRAPPER}} h3.prodigy-filter__title' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_heading_bottom_margin',
			array(
				'label'          => esc_html( 'Bottom Margin' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of heading and first attribute name',
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
		 * Attribute Name
		 */
		$this->start_controls_section(
			'prg_attrs_style_attr_name',
			array(
				'label' => __( 'Attribute Name' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attrs_style_attr_name_typography',
				'label'          => esc_html( 'Typography' ),
				'selector'       => '{{WRAPPER}} h5.prodigy-filter__subtitle',
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
						'default' => 600,
					),
					'text_transform' => array(
						'default' => 'uppercase',
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
			'prg_attrs_style_attr_name_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} h5.prodigy-filter__subtitle' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_attr_name_alignment',
			array(
				'label'          => __( 'Alignment' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'left',
				'options'        => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'condition'      => array(
					'prg_attrs_content_type' => array( 'list' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} h5.prodigy-filter__subtitle' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_attr_name_spacing',
			array(
				'label'          => esc_html( 'Spacing' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Between bottom of attribute name and first value',
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
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} h5.prodigy-filter__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-filter__card-list-item h5.prodigy-filter__subtitle' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Attribute Value
		 */
		$this->start_controls_section(
			'prg_attrs_style_attr_value',
			array(
				'label' => __( 'Attribute Value' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attrs_style_attr_value_typography',
				'label'          => esc_html( 'Typography' ),
				'selector'       => '{{WRAPPER}} .prodigy-filter__item-list-txt',
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
			'prg_attrs_style_attr_checkbox_color',
			array(
				'label'      => __( 'Checkbox Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-custom-template .prodigy-filter__item-list-txt input[type=checkbox]:checked' => 'accent-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-txt a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Products Count
		 */
		$this->start_controls_section(
			'prg_attrs_style_attr_prod_count',
			array(
				'label'     => __( 'Products Count' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_attrs_content_prod_count' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attrs_style_attr_prod_count_typography',
				'label'          => esc_html( 'Typography' ),
				'selector'       => '{{WRAPPER}} .filter__item-list-info',
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
			'prg_attrs_style_attr_prod_count_color',
			array(
				'label'      => __( 'Count Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .filter__item-list-info' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Attribute Value Box
		 */
		$this->start_controls_section(
			'prg_attrs_style_attr_value_box',
			array(
				'label' => __( 'Attribute Value Box' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-filter__item-list-li' => 'border-style: {{SIZE}}',
					'{{WRAPPER}} .prodigy-filter__card'         => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'prg_attrs_style_attr_value_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-filter__card'         => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-li' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-filter__card'         => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_attr_value_box_padding',
			array(
				'label'      => __( 'Padding' ),
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
					'{{WRAPPER}} .prodigy-filter__card-list-item .prodigy-filter__item-list-txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .category-filter-js.prodigy-filter__item-list-txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_attrs_style_attr_value_box_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_attr_value_box_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'prg_attrs_style_attr_value_shadow',
				'condition' => array(
					'prg_attrs_content_type' => array( 'list' ),
				),
				'selector'  => '{{WRAPPER}} .prodigy-filter__item-list-li',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'prg_attrs_style_attr_value_box_shadow',
				'condition' => array(
					'prg_attrs_content_type' => array( 'accordion' ),
				),
				'selector'  => '{{WRAPPER}} .prodigy-filter__card',
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_bg_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-li' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-filter__card'         => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_color_list',
			array(
				'label'     => __( 'Border Color List' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'condition' => array(
					'prg_attrs_style_attr_value_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-li' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_color_accordion',
			array(
				'label'     => __( 'Border Color Accordion' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_attrs_style_attr_value_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card'         => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_attrs_style_attr_value_box_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'prg_attrs_style_attr_value_shadow_hover',
				'condition' => array(
					'prg_attrs_content_type' => array( 'list' ),
				),
				'selector'  => '{{WRAPPER}} .prodigy-filter__item-list-li:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'prg_attrs_style_attr_value_box_shadow_hover',
				'condition' => array(
					'prg_attrs_content_type' => array( 'accordion' ),
				),
				'selector'  => '{{WRAPPER}} .prodigy-filter__card:hover',
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_bg_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-li:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-filter__card:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_color_list_hover',
			array(
				'label'     => __( 'Border Color List' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'condition' => array(
					'prg_attrs_style_attr_value_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-li:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_attr_value_box_border_color_accordion_hover',
			array(
				'label'     => __( 'Border Color Accordion' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_attrs_style_attr_value_box_border_type' => array(
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
		 * Button
		 */
		$this->start_controls_section(
			'prg_attrs_style_button',
			array(
				'label'     => __( 'Button' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_attrs_style_button_typography',
				'label'          => esc_html( 'Typography' ),
				'selector'       => '{{WRAPPER}} .prodigy-filter__btn',
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
			'prg_attrs_style_button_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-filter__btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'prg_attrs_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_attrs_style_button_padding',
			array(
				'label'          => __( 'Text Padding' ),
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
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-filter__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_transition',
			array(
				'label'      => __( 'Transition Duration' ),
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
					'{{WRAPPER}} .prodigy-filter__btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_attrs_style_button_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_button_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_color',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_bg_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attrs_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_attrs_style_button_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_color_hover',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#768492',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_bg_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_button_border_color_hover',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'solid',
				'condition' => array(
					'prg_attrs_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__btn:hover' => 'border-color: {{VALUE}}',
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
			'prg_attrs_style_card_list',
			array(
				'label'     => __( 'Filter Card List' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_attrs_content_type' => array( 'accordion' ),
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_card_list_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
			'prg_attrs_style_card_list_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_attrs_style_card_list_border_type' => array(
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
			'prg_attrs_style_card_list_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
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
			'prg_attrs_style_card_list_list_padding',
			array(
				'label'      => __( 'Padding' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_attrs_style_card_list_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_card_list_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_attrs_style_card_list_shadow',
				'selector' => '{{WRAPPER}} .prodigy-filter__card-list',
			)
		);

		$this->add_control(
			'prg_attrs_style_card_list_bg_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-list' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_card_list_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_attrs_style_card_list_border_type' => array(
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
			'prg_attrs_style_card_list_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_attrs_style_card_list_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-filter__card-list:hover',
			)
		);

		$this->add_control(
			'prg_attrs_style_card_list_bg_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-list:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_card_list_border_color_hover',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'condition' => array(
					'prg_attrs_style_card_list_border_type' => array(
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
			'prg_attrs_style_arrow_button',
			array(
				'label'     => __( 'Arrow Button' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_attrs_content_type' => array( 'accordion' ),
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_width',
			array(
				'label'      => __( 'Width' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__accordion .prodigy-filter__card-btn' => 'min-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_size',
			array(
				'label'      => __( 'Arrow Size' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__accordion .prodigy-filter__card-btn > .icon-arrow-down:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_color',
			array(
				'label'     => __( 'Arrow Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__accordion .prodigy-filter__card-btn > .icon-arrow-down:before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_color_weigth',
			array(
				'label'      => __( 'Font Weight' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__accordion .prodigy-filter__card-btn > .icon-arrow-down:before' => 'border-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
			'prg_attrs_style_arrow_button_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'prg_attrs_style_arrow_button_border_type' => array(
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
			'prg_attrs_style_arrow_button_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_transition',
			array(
				'label'      => __( 'Transition Duration' ),
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

		$this->start_controls_tabs( 'prg_attrs_style_arrow_button_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_arrow_button_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_color',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d9dbe1',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn .icon:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_bg_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attrs_style_arrow_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_attrs_style_arrow_button_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_color_hover',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#3a3a3a',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn:hover .icon:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_bg_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00000000',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_arrow_button_border_color_hover',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attrs_style_arrow_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__card-btn.prodigy-icon-btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Filter Item Close Icon
		 */
		$this->start_controls_section(
			'prg_attrs_style_close_icon',
			array(
				'label' => __( 'Filter Item Close Icon' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_width',
			array(
				'label'      => __( 'Width' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_height',
			array(
				'label'      => __( 'Height' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_font_size',
			array(
				'label'      => __( 'Font Size' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'prg_attrs_style_close_icon_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_transition',
			array(
				'label'      => __( 'Transition Duration' ),
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
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_attrs_style_close_icon_tabs' );

		$this->start_controls_tab(
			'prg_attrs_style_close_icon_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_color',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_bg_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attrs_style_close_icon_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-close' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_attrs_style_close_icon_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_color_hover',
			array(
				'label'     => __( 'Text Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0170b9',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_bg_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-filter__item-list-close:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_attrs_style_close_icon_border_color_hover',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_attrs_style_close_icon_border_type' => array(
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
					'{{WRAPPER}} .prodigy-filter__item-list-close:hover' => 'border-color: {{VALUE}}',
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
		if ( isset( $settings['prg_attrs_content_view_attributes'] ) ) {
			$sett_prg[] = 'attribute_ids="' . implode( ',', $settings['prg_attrs_content_view_attributes'] ) . '"';
		}
		foreach ( $settings as $key => $setting ) {

			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$sett_prg[] = str_replace( 'prg_', '', $key ) . '="' . $setting . '"';
			}
		}
		$sett_prg[] = 'idWidget="' . $this->get_id() . '"';

		echo do_shortcode( '[prodigy_attributes_filter ' . implode( ' ', $sett_prg ) . ']' );
	}
}
