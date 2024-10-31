<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Helpers\Enums\Prodigy_Enums;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

/**
 * @version 2.0.7
 */
class ElementorRelatedProducts extends Widget_Base {

	public $product;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * @inheritDoc
	 */
	public function get_name():string {
		return 'pae-related-products';
	}

	/**
	 * @inheritDoc
	 */
	public function get_title():string {
		return __( 'Related Products', 'prodigy' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_icon():string {
		return 'prgicon prgicon-related-products';
	}

	/**
	 * @inheritDoc
	 */
	public function get_categories(): array {
		return array( 'prodigy-elements-single', 'prodigy-addons' );
	}

	/**
	 * @inheritDoc
	 */
	protected function register_controls() {
		/*
		* Products Selection
		*/
		$this->start_controls_section(
			'prg_filter_section',
			array(
				'label' => __( 'Products Selection', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_type',
			array(
				'label'       => __( 'Type', 'prodigy' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'up-sell',
				'options'     => array(
					'up-sell'    => __( 'Up-sell', 'prodigy' ),
					'cross-sell' => __( 'Cross-sell', 'prodigy' ),
					'both'       => __( 'Both', 'prodigy' ),
				),
				'render_type' => 'template',
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
					'id'     => 'Product ID',
					'date'   =>  'Date',
					'title'  => 'Title',
					'price'  =>  'Price',
					'rating' =>  'Avg Rating',
				),
			)
		);

		$this->add_control(
			'prg_order',
			array(
				'label'   => __( 'Order', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
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
				'default'   => -1,
				'min'       => -1,
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

		$this->add_responsive_control(
			'prg_columns',
			array(
				'label'          => __( 'Columns', 'prodigy' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 6,
				'default'        => Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS,
				'tablet_default' => Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_TABLET,
				'mobile_default' => Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_MOBILE,
				'render_type'    => 'template',
			)
		);

        $this->add_control(
            'prg_content_archive_products_content_items_number',
            array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => __( 'Number of items per page', 'prodigy' ),
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
			'prg_category',
			array(
				'label'        => __( 'Category', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'prodigy' ),
				'label_off'    => __( 'Hide', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_rating',
			array(
				'label'        => __( 'Rating', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'prodigy' ),
				'label_off'    => __( 'Hide', 'prodigy' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_sale',
			array(
				'label'        => __( 'Sale', 'prodigy' ),
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
			'prg_style_gen_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'flex-start',
				'tablet_default' => 'flex-start',
				'mobile_default' => 'flex-start',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'align-items: {{VALUE}}',
				),
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
					'{{WRAPPER}} .prodigy-homepage__slider .slick-list' => 'margin: 0 calc({{SIZE}}{{UNIT}} / -2)',
					'{{WRAPPER}} .prodigy-homepage__slider .slick-slide' => 'margin: 0 calc({{SIZE}}{{UNIT}} / 2)',
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
					'{{WRAPPER}} .prodigy-feature-products-slider' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .related-products__container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_vertical_padding',
			array(
				'label'          => __( 'Top/Bottom Padding', 'prodigy' ),
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
					'{{WRAPPER}} .slick-list' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Heading
		 */
		$this->start_controls_section(
			'prg_style_content_heading',
			array(
				'label' => __( 'Heading', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_content_heading_text',
			array(
				'label'   => __( 'Text Value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Related Products',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_content_heading_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-related__products-title',
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
						'default' => 400,
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
			'prg_style_content_heading_title_color',
			array(
				'label'      => __( 'Title Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_content_heading_alignment',
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
					'{{WRAPPER}} .prodigy-related__products-title' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_content_heading_type',
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
					'{{WRAPPER}} .prodigy-related__products-title' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_content_heading_width',
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
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_style_content_heading_type' => array(
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
			)
		);

		$this->add_control(
			'prg_style_content_heading_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_style_content_heading_type' => array(
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
			)
		);

		$this->add_responsive_control(
			'prg_style_content_heading_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_style_content_heading_style_tabs' );

		$this->start_controls_tab(
			'prg_style_content_heading_classic_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_style_content_heading_shadow',
				'selector' => '{{WRAPPER}} .prodigy-related__products-title',
			)
		);

		$this->add_control(
			'prg_style_content_heading_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_content_heading_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-related__products-title' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_style_content_heading_classic_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_style_content_heading_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-related__products-title:hover',
			)
		);

		$this->add_control(
			'prg_style_content_heading_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-related__products-title:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_content_heading_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-related__products-title:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_content_heading_bottom_margin',
			array(
				'label'          => __( 'Margin Bottom', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-related__products-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Box
		 */
		$this->start_controls_section(
			'section_design_box',
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
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'border-style: {{SIZE}}',
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
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .prodigy-product-list__item-container',
			)
		);

		$this->add_control(
			'box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'border-color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .prodigy-product-list__item-container:hover',
			)
		);

		$this->add_control(
			'box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product-list__item-container:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product-list__item-container:hover' => 'border-color: {{VALUE}}',
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
					'{{WRAPPER}} .prodigy-homepage__slider .slick-slider' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .prodigy-related__products-nav:before' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .prodigy-related__products-nav:hover:before' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'border-style: {{SIZE}}',
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
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_image_bottom_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of image and text below',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
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
			)
		);

		$this->add_control(
			'prg_style_image_ratio',
			array(
				'label'       => __( 'Aspect Ratio', 'prodigy' ),
				'description' => 'Aspect Ratio',
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'default'     => array(
					'width'  => 3,
					'height' => 4,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'padding-top: calc(100% * ({{HEIGHT}} / {{WIDTH}}))',
				),
			)
		);

		$this->add_responsive_control(
			'image_image_ratio_object_fit',
			array(
				'label'          => __( 'Image Object Fit', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'cover',
				'tablet_default' => 'cover',
				'mobile_default' => 'cover',
				'options'        => array(
					'cover'      => __( 'Cover', 'prodigy' ),
					'contain'    => __( 'Contain', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp .prodigy-product-list__item-preview-img' => 'object-fit: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'image_image_ratio_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-container .prodigy-product-list__link-wrp' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'image_image_ratio_scale',
			array(
				'label'          => __( 'Scale', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'default'        => array(
					'size' => 1,
					'unit' => '',
				),
				'tablet_default' => array(
					'size' => 1,
					'unit' => '',
				),
				'mobile_default' => array(
					'size' => 1,
					'unit' => '',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-preview-img' => 'transform: scale({{SIZE}})',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Category
		 */
		$this->start_controls_section(
			'prg_style_category',
			array(
				'label'     => __( 'Category', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_category' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_category_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-list__item-category',
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
			'prg_style_category_color',
			array(
				'label'      => __( 'Category Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-category' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_category_bottom_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Between bottom of category and title',
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
					'{{WRAPPER}} .prodigy-product-list__item-category' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} h3.prodigy-product-list__item-title',
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
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} h3.prodigy-product-list__item-title a' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} h3.prodigy-product-list__item-title a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_title_bottom_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of title and star rating',
				'selectors'      => array(
					'{{WRAPPER}} h3.prodigy-product-list__item-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
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
			)
		);

		$this->end_controls_section();

		/*
		 * Rating
		 */
		$this->start_controls_section(
			'prg_style_rating',
			array(
				'label'     => __( 'Rating', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_rating' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'prg_style_rating_star_color',
			array(
				'label'      => __( 'Rating Star Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating__item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_rating_empty_star_color',
			array(
				'label'      => __( 'Empty Start Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e5e5e5',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_rating_size_star',
			array(
				'label'          => __( 'Star Size', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 14,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating' => 'width: calc({{SIZE}}{{UNIT}} * 5); height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating:before' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating__item' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating__item:before' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_rating_bottom_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'description'    => 'Between bottom of star rating and price',
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
					'{{WRAPPER}} .prodigy-product-list__item-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Price
		 */
		$this->start_controls_section(
			'prg_style_price',
			array(
				'label' => __( 'Price', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_price_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-list__item-price',
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
			'prg_style_price_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Sale Badge
		 */
		$this->start_controls_section(
			'prg_style_sale_badge',
			array(
				'label'     => __( 'Sale Badge', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_sale' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_sale_badge_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-list__item-label > span',
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
						'default' => 800,
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
			'prg_style_sale_badge_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sale_badge_back_color',
			array(
				'label'      => __( 'Background Сolor', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#f55454',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_sale_badge_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 48,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 48,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_sale_badge_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 48,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 48,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sale_badge_border_radius',
			array(
				'label'      => __( 'Border radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sale_badge_position_vertical',
			array(
				'label'   => __( 'Position Vertical', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'top'    => __( 'Top', 'prodigy' ),
					'bottom' => __( 'Bottom', 'prodigy' ),
				),
				'default' => 'top',
			)
		);

		$this->add_responsive_control(
			'prg_style_sale_badge_position_vertical_dist',
			array(
				'label'          => __( 'Position Vertical Distance', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
				'range'          => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'render_type'    => 'template',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-label:not(.prodigy-product-list__item-label--bottom)' => 'top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product-list__item-label--bottom' => 'bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_sale_badge_position_horizontal',
			array(
				'label'   => __( 'Position Horizontal', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'left'  => __( 'Left', 'prodigy' ),
					'right' => __( 'Right', 'prodigy' ),
				),
				'default' => 'left',
			)
		);

		$this->add_responsive_control(
			'prg_style_sale_badge_position_horizontal_dist',
			array(
				'label'          => __( 'Position Horizontal Distance', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => -6,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => -6,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => -6,
					'unit' => 'px',
				),
				'range'          => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'render_type'    => 'template',
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-label:not(.prodigy-product-list__item-label--right)' => 'left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product-list__item-label--right' => 'right: {{SIZE}}{{UNIT}}',
				),
			)
		);

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

    public function set_widget_settings() {
        $settings = array_filter(
            $this->get_settings_for_display(),
            function ( $val, $key ) {
                return strpos( $key, 'prg_' ) === 0;
            },
            ARRAY_FILTER_USE_BOTH
        );

        $settings_keys = array_map(
            function ( $value ) {
                return str_replace( 'prg_', '', $value );
            },
            array_keys( $settings )
        );

        $settings = array_combine( $settings_keys, $settings );

        $settings['image_ratio'] = Prodigy_Customizer::get_images_ratio();
        $settings['sale_classname'] = 'prodigy-product-list__item-label';

        if ( isset( $settings ) && ! empty( $settings['style_image_ratio']['width'] ) && ! empty( $settings['style_image_ratio']['height'] ) ) {
            $settings['image_ratio'] = ( $settings['style_image_ratio']['height'] / $settings['style_image_ratio']['width'] ) * 100;
            if ( $settings['style_sale_badge_position_vertical'] === 'bottom' ) {
                $settings['sale_classname'] .= ' prodigy-product-list__item-label--bottom';
            }
            if ( $settings['style_sale_badge_position_horizontal'] === 'right' ) {
                $settings['sale_classname'] .= ' prodigy-product-list__item-label--right';
            }
        }

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
        $settings = $this->set_widget_settings();

        do_action( 'prodigy_shortcode_related_products', $settings );
	}
}
