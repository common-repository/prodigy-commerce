<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Archive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Content\Prodigy_Catalog_Products_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Pages\Prodigy_Shop_Page;
use Prodigy\Includes\Prodigy_Pagination;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorProducts extends Widget_Base {

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
		return 'pae-archive-products';
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
		return __( 'Products Archive', 'prodigy' );
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
		return 'prgicon prgicon-products';
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
		$this->start_controls_section(
			'prg_content_archive_products',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_order_by',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Order By', 'prodigy' ),
				'default' => 'created_at',
				'options' => array(
					'created_at' => __( 'Date', 'prodigy' ),
					'price'      => __( 'Price', 'prodigy' ),
					'rating'     => __( 'Rating', 'prodigy' ),
				),
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_order',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Order', 'prodigy' ),
				'default' => 'desc',
				'options' => array(
					'asc'  => __( 'ASC', 'prodigy' ),
					'desc' => __( 'DESC', 'prodigy' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_content_archive_products_content_columns',
			array(
				'label'          => __( 'Columns', 'prodigy' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 3,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'min'            => 1,
				'max'            => 6,
				'device_args'    => array(
					'desktop' => array(
						'max' => 5,
					),
					'tablet'  => array(
						'max' => 3,
					),
					'mobile'  => array(
						'max' => 2,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
				),
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
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_category',
			array(
				'label'        => __( 'Category', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => 'Hide',
				'label_on'     => 'Show',
				'default'      => '',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_rating',
			array(
				'label'        => __( 'Rating', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => 'Hide',
				'label_on'     => 'Show',
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_sale',
			array(
				'label'        => __( 'Sale Badge', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => 'Hide',
				'label_on'     => 'Show',
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'prg_content_archive_products_content_quick_view',
			array(
				'label'        => __( 'Quick View', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => 'Hide',
				'label_on'     => 'Show',
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_general',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_general_margin',
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
					'{{WRAPPER}} .prodigy-product-list__grid' => 'column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_general_row_margin',
			array(
				'label'          => __( 'Row Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-product-list__grid' => 'row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_general_alignment',
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
			'prg_style_archive_products_general_bottom_margin',
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
					'{{WRAPPER}} .prodigy-product-list' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_general_top_margin',
			array(
				'label'          => __( 'Top Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-custom-template .prodigy-product-list__grid.mt-20' => 'margin-top: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_box',
			array(
				'label' => __( 'Box', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_archive_products_box_border_type',
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
			'prg_style_archive_products_box_border_width',
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
					'prg_style_archive_products_box_border_type' => array(
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
			'prg_style_archive_products_box_border_radius',
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
			'prg_style_archive_products_box_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_style_archive_products_box_tabs' );

		$this->start_controls_tab(
			'prg_style_archive_products_box_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'prodigy' ),
				'name'     => 'prg_style_archive_products_box_shadow',
				'selector' => '{{WRAPPER}} .prodigy-product-list__item-container',
			)
		);

		$this->add_control(
			'prg_style_archive_products_box_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_box_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_archive_products_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product-list__item-container' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_style_archive_products_box_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'prodigy' ),
				'name'     => 'prg_style_archive_products_box_shadow_hover',
				'selector' => '{{WRAPPER}} .prodigy-product-list__item-container:hover',
			)
		);

		$this->add_control(
			'prg_style_archive_products_box_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-container:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_box_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition'  => array(
					'prg_style_archive_products_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product-list__item-container:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_image',
			array(
				'label' => __( 'Image', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_archive_products_image_border_type',
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
			'prg_style_archive_products_image_border_width',
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
					'prg_style_archive_products_image_border_type' => array(
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
			'prg_style_archive_products_image_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'condition'  => array(
					'prg_style_archive_products_image_border_type' => array(
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

		$this->add_control(
			'prg_style_archive_products_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_image_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Between bottom of image and text below',
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
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_image_aspect_ratio',
			array(
				'label'     => __( 'Aspect Ratio', 'prodigy' ),
				'type'      => Controls_Manager::IMAGE_DIMENSIONS,
				'default'   => array(
					'width'  => 3,
					'height' => 4,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'padding-top: calc(100% * {{HEIGHT}} / {{WIDTH}})',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_image_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__link-wrp' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_image_scale',
			array(
				'label'          => __( 'Scale', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.05,
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
					'{{WRAPPER}} .prodigy-product-list__item-preview svg' => 'transform: scale({{SIZE}})',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_category',
			array(
				'label'     => __( 'Category', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_archive_products_content_category' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_archive_products_category_typography',
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
			'prg_style_archive_products_category_color',
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
			'prg_style_archive_products_category_spacing',
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

		$this->start_controls_section(
			'prg_style_archive_products_title',
			array(
				'label' => __( 'Title', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_archive_products_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-list__item-title a',
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
			'title_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_archive_products_title_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-title a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_style_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_archive_products_title_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-title a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'prg_style_archive_products_title_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Between bottom of title and star rating',
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
					'{{WRAPPER}} .prodigy-product-list__item-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_rating',
			array(
				'label'     => __( 'Rating', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_archive_products_content_rating' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_rating_star_color',
			array(
				'label'      => __( 'Star Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffcb27',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating__item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_rating_empty_star_color',
			array(
				'label'      => __( 'Empty Star Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e5e5e5',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-rating .prodigy-star-rating:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_rating_star_size',
			array(
				'label'          => __( 'Star size', 'prodigy' ),
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
			'prg_style_archive_products_rating_spacing',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Between bottom of rating and price',
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
					'{{WRAPPER}} .prodigy-product-list__item-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_price',
			array(
				'label' => __( 'Price', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_archive_products_price_typography',
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
			'prg_style_archive_products_price_color',
			array(
				'label'      => __( 'Price Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_archive_products_sale',
			array(
				'label'     => __( 'Sale Badge', 'prodigy' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_archive_products_content_sale' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_archive_products_sale_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product-list__item-label',
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
			'prg_style_archive_products_sale_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_archive_products_sale_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#f55454',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product-list__item-label' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_archive_products_sale_width',
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
			'prg_style_archive_products_sale_height',
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
			'prg_style_archive_products_sale_border_radius',
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
			'prg_style_archive_products_sale_position_vertical',
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
			'prg_style_archive_products_sale_position_vertical_dist',
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
			'prg_style_archive_products_sale_position_horizontal',
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
			'prg_style_archive_products_sale_position_horizontal_dist',
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
				'label' => __( 'Pagination', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
	 * @param array $params
	 *
	 * @return array
	 */
	public function prepare_params( array $params ): array {
		unset( $params['action'], $params['_'] );

		return $params;
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = array_filter(
			$this->get_settings_for_display(),
			static function ( $val, $key ) {
				return strpos( $key, 'prg_' ) === 0;
			},
			ARRAY_FILTER_USE_BOTH
		);

		$settings_keys = array_map(
			static function ( $value ) {
				return str_replace( 'prg_', '', $value );
			},
			array_keys( $settings )
		);

		$settings             = array_combine( $settings_keys, $settings );
		$settings['idWidget'] = $this->get_id();

		$params          = $this->prepare_params( $_GET ?? array() );
		$products_parser = new Prodigy_Catalog_Products_Parser();
		$query_params    = $products_parser->set_query_catalog_params( $params );
		$category        = $products_parser->get_catalog_category_param( $params['tax_slug'] ?? '', $params['tax_name'] ?? '' );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$query = $products_parser->catalog_query_builder( $query_params, (int) $products_parser->get_number_per_page() );

		$content                  = Prodigy_Request_Maker::get_instance()->do_catalog_products_request( $query );
		$settings['products']     = Prodigy_Catalog_Products_Parser::get_products( $content );
		$total_number             = $settings['products'][0]['attributes']['products-count'] ?? 0;
		$shop_page                = new Prodigy_Shop_Page();
		$settings['pagination']   = array(
			'pages'       => ! empty( $settings['products'] ) ? Prodigy_Pagination::calculate_count_pages( (int) $total_number, $settings['content_archive_products_content_items_number'] ) : 1,
			'url'         => $shop_page->get_catalog_url( $query ),
			'page'        => Prodigy_Pagination::get_current_page( $params ?? array() ),
			'page_number' => $params['pg'] ?? 1,
		);
		$settings['is_elementor'] = true;
		update_option( 'pg_elementor_archive_widget', $settings );

		do_action( 'prodigy_shop_products_loop', array( 'elementor_options' => $settings ) );
	}
}
