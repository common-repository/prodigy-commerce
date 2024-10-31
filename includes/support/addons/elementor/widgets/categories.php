<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Categories_Data_Mapper;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Prodigy;

class ElementorCategories extends Widget_Base {

	public $categories_mapper;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		$this->categories_mapper = new Prodigy_Categories_Data_Mapper();
	}

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
		return 'pae-categories';
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
		return __( 'Categories', 'prodigy' );
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
		return 'prgicon prgicon-categories';
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
		* Categories Selection
		*/
		$this->start_controls_section(
			'prg_filter_section',
			array(
				'label' => __( 'Categories Selection', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_category_ids',
			array(
				'label'       => __( 'By Category Names', 'prodigy' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'slug' ),
				'default'     => array(),
				'multiple'    => true,
				'description' => 'Write all Category Name slugs separated with comma e.g gallery, innovation, brand',
			)
		);

		$this->add_control(
			'prg_parent_ids',
			array(
				'label'       => __( 'By Parent Names', 'prodigy' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => '',
				'options'     => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'name' ),
				'description' => 'Write all Parent IDs separated with comma',
			)
		);

		$this->end_controls_section();

		/*
		* Content
		*/
		$this->start_controls_section(
			'prg_general_section',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_orderby',
			array(
				'label'   => __( 'Order By', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'id',
				'options' => array(
					'title' => __( 'Title' ),
					'id'    => __( 'Category ID' ),
				),
			)
		);

		$this->add_control(
			'prg_order',
			array(
				'label'   => __( 'Order', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => array(
					'asc'  => __( 'ASC', 'prodigy' ),
					'desc' => __( 'DESC', 'prodigy' ),
				),
			)
		);

		$this->add_control(
			'prg_limit',
			array(
				'label'     => __( 'Limit', 'prodigy' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -1,
				'default'   => 4,
				'condition' => array(
					'prg_display' => array( 'slider' ),
				),
			)
		);

		$this->add_control(
			'prg_display',
			array(
				'label'   => __( 'Display', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slider',
				'options' => array(
					'slider' => __( 'Slider', 'prodigy' ),
					'grid'   => __( 'Grid', 'prodigy' ),
				),
			)
		);

		$this->add_control(
			'prg_columns',
			array(
				'label'        => __( 'Columns', 'prodigy' ),
				'type'         => Controls_Manager::NUMBER,
				'prefix_class' => 'elementor-grid%s-',
				'min'          => 1,
				'max'          => 6,
				'default'      => 4,
				'selectors'    => array(
					'{{WRAPPER}} .prodigy-product-list__grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
				),
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'prg_items_per_page_number',
			array(
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Number of items' ),
				'placeholder' => 1,
				'min'         => 1,
				'max'         => 50,
				'step'        => 1,
				'default'     => 9,
				'required'    => true,
				'oninput'     => 'validity.valid;',
				'onblur'      => 'validity.valid;',
				'condition' => array(
					'prg_display' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'prg_show_product_count',
			array(
				'label'        => __( 'Product Count', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'prodigy' ),
				'label_off'    => __( 'Hide', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/*
		 * General
		 */
		$this->start_controls_section(
			'prg_style_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_column_margin',
			array(
				'label'          => __( 'Column Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
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
					'{{WRAPPER}} .prodigy-categories-slider .slick-list' => 'margin: 0 calc({{SIZE}}{{UNIT}} / -2)',
					'{{WRAPPER}} .prodigy-categories-slider .slick-slide' => 'margin: 0 calc({{SIZE}}{{UNIT}} / 2)',
					'{{WRAPPER}} .prodigy-product-list__grid' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_rows_margin',
			array(
				'label'          => __( 'Row Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 24,
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
				'condition'      => array(
					'prg_display' => array( 'grid' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__grid' => 'row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

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
					'{{WRAPPER}} .prodigy-categories-slider' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-categories' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_vertical_padding',
			array(
				'label'          => __( 'Vertical Padding', 'prodigy' ),
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
				'condition'      => array(
					'prg_display' => array( 'slider' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-homepage__slider-container .slick-list' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Box
		 */
		$this->start_controls_section(
			'prg_style_box',
			array(
				'label' => __( 'Box', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_border_type',
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_width',
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
					'prg_style_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		$this->start_controls_tab(
			'classic_style_normal',
			array(
				'label' => __( 'Normal' , 'prodigy'),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap',
			)
		);

		$this->add_control(
			'box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap, div.prodigy-categories-slider .prodigy-categories__card-wrap' => 'border-color: {{VALUE}}',
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap:hover, div.prodigy-categories-slider .prodigy-categories__card-wrap:hover',
			)
		);

		$this->add_control(
			'box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap:hover, div.prodigy-categories-slider .prodigy-categories__card-wrap:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap:hover, div.prodigy-categories-slider .prodigy-categories__card-wrap:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Slider
		 */
		$this->start_controls_section(
			'prg_style_slider',
			array(
				'label'     => __( 'Slider', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_display' => array( 'slider' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_slider_arrow_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-categories-slider .slick-slider' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_slider_hide_arrows',
			array(
				'label'        => __( 'Hide arrows', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'prodigy' ),
				'label_off'    => __( 'No', 'prodigy' ),
				'default'      => '',
				'return_value' => 'yes',
				'description'  => 'Hide the arrow controls until the slider is hovered',
			)
		);

		$this->add_control(
			'prg_style_slider_separator',
			array(
				'label'     => __( 'Arrows', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_size',
			array(
				'label'      => __( 'Font Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 36,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_border_type',
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
					'{{WRAPPER}} .prodigy-related__products-nav' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_border_width',
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
					'prg_style_slider_arrows_border_type' => array(
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
					'{{WRAPPER}} .prodigy-related__products-nav' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'slider_style_tabs' );

		$this->start_controls_tab(
			'slider_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '',
				'condition'  => array(
					'prg_style_slider_arrows_border_type' => array(
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
					'{{WRAPPER}} .prodigy-related__products-nav' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-nav:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_slider_arrows_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '',
				'condition'  => array(
					'prg_style_slider_arrows_border_type' => array(
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
					'{{WRAPPER}} .prodigy-related__products-nav:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Overlay
		 */
		$this->start_controls_section(
			'prg_style_overlay',
			array(
				'label' => __( 'Overlay', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_title_overlay',
			array(
				'label'   => __( 'Position', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'overlay',
				'options' => array(
					'overlay' => __( 'Overlay', 'prodigy' ),
					'below'   => __( 'Below', 'prodigy' ),
				),
			)
		);

		$this->start_controls_tabs(
			'prg_categories_style_overlay_tabs',
			array(
				'condition' => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
			)
		);

		$this->start_controls_tab(
			'prg_categories_style_overlay_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_categories_style_overlay_color',
			array(
				'label'     => __( 'Background', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffffe6',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-categories__card-title' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_categories_style_overlay_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_categories_style_overlay_color_hover',
			array(
				'label'     => __( 'Background', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-categories__card-wrap:hover .prodigy-categories__card-title' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_overlay_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 80,
					'unit' => '%',
				),
				'tablet_default' => array(
					'size' => 80,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 80,
					'unit' => '%',
				),
				'range'          => array(
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'condition'      => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-categories__card-title' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_overlay_block_text_padding_top',
			array(
				'label'          => __( 'Text Padding Top', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'        => array(
					'size' => 26,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 26,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 26,
					'unit' => 'px',
				),
				'condition'      => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-categories__card-title' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_overlay_block_text_padding_bottom',
			array(
				'label'          => __( 'Text Padding Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'        => array(
					'size' => 26,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 26,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 26,
					'unit' => 'px',
				),
				'condition'      => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-categories__card-title' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_overlay_block_position_horizontal',
			array(
				'label'       => __( 'Position Horizontal', 'prodigy' ),
				'type'        => Controls_Manager::SELECT,
				'description' => 'Determines the position of the overlay with the category link',
				'options'     => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'default'     => 'center',
				'condition'   => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
			)
		);

		$this->add_control(
			'prg_style_overlay_block_position_vertical',
			array(
				'label'       => __( 'Position Vertical', 'prodigy' ),
				'type'        => Controls_Manager::SELECT,
				'description' => 'Determines the position of the overlay with the category link',
				'options'     => array(
					'top'    => __( 'Top', 'prodigy' ),
					'middle' => __( 'Middle', 'prodigy' ),
					'bottom' => __( 'Bottom', 'prodigy' ),
				),
				'default'     => 'bottom',
				'condition'   => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Image
		 */
		$this->start_controls_section(
			'prg_style_image',
			array(
				'label' => __( 'Image', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_image_border_type',
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_image_border_width',
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
					'prg_style_image_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_image_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'condition'  => array(
					'prg_style_image_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_spacing',
			array(
				'label'       => __( 'Spacing', 'prodigy' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'default'     => array(
					'size' => 16,
				),
				'description' => 'Between bottom of image and text below',
				'selectors'   => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title--below' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'prg_style_image_title_overlay' => array( 'below' ),
				),
			)
		);

		$this->add_control(
			'image_ratio_image_prod',
			array(
				'label'       => __( 'Aspect Ratio', 'prodigy' ),
				'description' => 'Aspect Ratio',
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'default'     => array(
					'width'  => 3,
					'height' => 4,
				),
				'selectors'   => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card' => 'aspect-ratio: {{WIDTH}}/{{HEIGHT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Title
		 */
		$this->start_controls_section(
			'prg_style_title',
			array(
				'label' => __( 'Title', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_alignment',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => Controls_Manager::SELECT,
				'desktop_default' => 'center',
				'tablet_default'  => 'center',
				'mobile_default'  => 'center',
				'options'         => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title-name',
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

		$this->start_controls_tabs( 'title_style_tabs' );

		$this->start_controls_tab(
			'title_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_title_color',
			array(
				'label'      => __( 'Title Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_title_color_hover',
			array(
				'label'      => __( 'Title Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap:hover .prodigy-categories__card-title-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_title_spacing_top',
			array(
				'label'          => __( 'Spacing Top', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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
				'condition'      => array(
					'prg_style_title_overlay' => array( 'below' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-categories__card-title--below' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_title_spacing_bottom',
			array(
				'label'          => __( 'Spacing Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
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
				'condition'      => array(
					'prg_style_title_overlay' => array( 'below' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-categories__card-title--below' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_title_spacing_between',
			array(
				'label'          => __( 'Spacing Between', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Determines the spacing between title and count products',
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
					'{{WRAPPER}} .prodigy-categories__card-title-name' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Product Count
		 */
		$this->start_controls_section(
			'prg_style_count_prod',
			array(
				'label'     => __( 'Product Count', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_show_product_count' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_count_prod_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title-name-amount',
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
					'text_transform' => array(
						'default' => 'uppercase',
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

		$this->start_controls_tabs( 'count_style_tabs' );

		$this->start_controls_tab(
			'count_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_count_prod_color',
			array(
				'label'      => __( 'Count Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4c4c4c',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-title-name-amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'count_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_count_prod_color_hover',
			array(
				'label'      => __( 'Count Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-categories .prodigy-categories__card-wrap:hover .prodigy-categories__card-title-name-amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Pagination
		 */
		$this->start_controls_section(
			'prg_style_pagination',
			array(
				'label'     => __( 'Pagination', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_display' => array( 'grid' ),
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_top_margin',
			array(
				'label'      => __( 'Top Margin', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_pagination_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-pagination' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_pagination_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-pagination .prodigy-pagination__item',
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
						'default' => 'none',
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

		$this->add_control(
			'prg_style_pagination_border_type',
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
					'{{WRAPPER}} .prodigy-pagination__item' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_pagination_border_type' => array(
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
					'{{WRAPPER}} .prodigy-pagination__item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_responsive_control(
			'prg_style_pagination_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'tablet_default' => array(
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-pagination__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_spacing',
			array(
				'label'      => __( 'Space Between', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item',
			array(
				'label'     => __( 'Item', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_style_pagination_item_transition',
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
					'{{WRAPPER}} .prodigy-pagination__item' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'pagination_item_style_tabs' );

		$this->start_controls_tab(
			'pagination_item_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_pagination_border_type' => array(
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
					'{{WRAPPER}} .prodigy-pagination__item' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_item_style_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_pagination_border_type' => array(
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
					'{{WRAPPER}} .prodigy-pagination__item:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_style_pagination_item_active',
			array(
				'label'     => __( 'Active Item', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_transition',
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
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'pagination_item_active_style_tabs' );

		$this->start_controls_tab(
			'pagination_item_active_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_pagination_border_type' => array(
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
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_item_active_style_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_pagination_item_active_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_pagination_border_type' => array(
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
					'{{WRAPPER}} .prodigy-pagination__item.prodigy-pagination__item--active:hover' => 'border-color: {{VALUE}}',
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
	 * @return void
	 */
	public function set_widget_options( array $settings) :array {
		$attr = array();
		foreach ( $settings as $key => $setting ) {

			if ( is_array( $setting ) && (
					'prg_category_ids' === $key ||
					'prg_category_slugs' === $key ||
					'prg_parent_ids' === $key )
			) {
				$setting = implode( ',', $setting );
			}

			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				if ( 'prg_show_product_count' == $key && empty( $setting ) ) {
					$setting = 'no';
				}
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$attr['title_classname'] = 'prodigy-categories__card-title';
		if ( $settings['prg_style_title_overlay'] === 'below' ) {
			$attr['title_classname'] .= ' prodigy-categories__card-title--below';
		} else {
			if ( $settings['prg_style_overlay_block_position_horizontal'] === 'left' ) {
				$attr['title_classname'] .= ' prodigy-categories__card-title--left';
			}
			if ( $settings['prg_style_overlay_block_position_horizontal'] === 'right' ) {
				$attr['title_classname'] .= ' prodigy-categories__card-title--right';
			}
			if ( $settings['prg_style_overlay_block_position_vertical'] === 'top' ) {
				$attr['title_classname'] .= ' prodigy-categories__card-title--top';
			}
			if ( $settings['prg_style_overlay_block_position_vertical'] === 'middle' ) {
				$attr['title_classname'] .= ' prodigy-categories__card-title--middle';
			}
		}
		$attr['show_product_count'] = $this->categories_mapper->show_product_count_mapper[$attr['show_product_count']];
		$attr['idWidget'] = $this->get_id();

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
		do_action( 'prodigy_get_template_categories', $attr );
	}
}
