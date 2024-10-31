<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Prodigy;

class ElementorCategory extends Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
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
		return 'pae-category';
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
		return __( 'Category', 'prodigy' );
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
		* Category Selection
		*/
		$this->start_controls_section(
			'prg_filter_section',
			array(
				'label' => __( 'Category Selection', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_category_id',
			array(
				'label'       => __( 'By Category Name', 'prodigy' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => false,
				'default'     => '',
				'description' => 'Accepts a single Category Name slug to display',
				'options'     => Prodigy_Product_Parser::get_taxonomies( Prodigy::get_prodigy_category_type(), Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION, 'name' ),
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
			'category_image_media',
			array(
				'label'   => __( 'Background Image', 'prodigy' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'prg_show_count_products',
			array(
				'label'       => __( 'Show product count', 'prodigy' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => 'Determines if the count of products will be shown in the image overlay',
				'options'     => array(
					'false' => __( 'Hide', 'prodigy' ),
					'true'  => __( 'Show', 'prodigy' ),
				),
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
					'{{WRAPPER}} .prodigy-category-link-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Box
		 */
		$this->start_controls_section(
			'prg_category_style_box',
			array(
				'label' => __( 'Box', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_box_border_type',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'border-style: {{VALUE}}',
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
					'prg_style_box_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
				'selector' => '{{WRAPPER}} div.prodigy-category-link-wrapper',
			)
		);

		$this->add_control(
			'box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_style_box_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper' => 'border-color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} div.prodigy-category-link-wrapper:hover',
			)
		);

		$this->add_control(
			'box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'box_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_style_box_border_type' => array(
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper:hover' => 'border-color: {{VALUE}}',
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
			'prg_category_style_image',
			array(
				'label' => __( 'Image', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'description'    => 'Specifies the height in pixels of the background image',
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'default'        => array(
					'size' => 325,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 325,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 325,
					'unit' => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'prg_image_position',
			array(
				'label'           => __( 'Image position', 'prodigy' ),
				'type'            => Controls_Manager::SELECT,
				'desktop_default' => 'center',
				'tablet_default'  => 'center',
				'mobile_default'  => 'center',
				'description'     => 'If the full height of the background image is not being displayed, the image_position specified the positioning of the background image',
				'options'         => array(
					'top'    => __( 'Top', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'bottom' => __( 'Bottom', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__img' => 'background-position-y: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Overlay
		 */
		$this->start_controls_section(
			'prg_category_style_overlay',
			array(
				'label' => __( 'Overlay', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_title_overlay',
			array(
				'label'   => __( 'Text Position', 'prodigy' ),
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
			'prg_style_overlay_color',
			array(
				'label'     => __( 'Background', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffffe6',
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link' => 'background-color: {{VALUE}}',
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
			'prg_style_overlay_color_hover',
			array(
				'label'     => __( 'Background', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link:hover' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link' => 'max-width:none; width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_overlay_padding_top',
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
					'{{WRAPPER}} .prodigy-category-link' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_overlay_padding_bottom',
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
					'{{WRAPPER}} .prodigy-category-link' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_title_block_position',
			array(
				'label'       => __( 'Overlay Position Horizontal', 'prodigy' ),
				'type'        => Controls_Manager::SELECT,
				'description' => 'Determines the position of the overlay with the category link',
				'default'     => 'center',
				'options'     => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				),
				'condition'   => array(
					'prg_style_title_overlay' => array( 'overlay' ),
				),
			)
		);

		$this->add_control(
			'prg_style_title_block_position_vertical',
			array(
				'label'       => __( 'Overlay Position Vertical', 'prodigy' ),
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
		 * Title
		 */
		$this->start_controls_section(
			'prg_category_style_title',
			array(
				'label' => __( 'Title', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_title_alignment',
			array(
				'label'     => __( 'Text Alignment', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors' => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__title, div.prodigy-category-link-wrapper .prodigy-category-link__products' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_title_top_spacing',
			array(
				'label'       => __( 'Spacing Top', 'prodigy' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'description' => 'Spacing (between bottom of image and title)',
				'default'     => array(
					'size' => '16',
					'unit' => 'px',
				),
				'condition'   => array(
					'prg_style_title_overlay' => array( 'below' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link--below' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__title',
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
						'default' => 600,
					),
					'text_transform' => array(
						'default' => 'uppercase',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__title' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link:hover .prodigy-category-link__title' => 'color: {{VALUE}}',
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
				'default'        => array(
					'size' => 8,
				),
				'tablet_default' => array(
					'size' => 8,
				),
				'mobile_default' => array(
					'size' => 8,
				),
				'selectors'      => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'description'    => 'Spacing (between bottom of title and product count)',
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
					'prg_show_count_products' => array( 'yes' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_count_prod_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => 'div.prodigy-category-link-wrapper .prodigy-category-link__products',
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
				'default'    => '#57617f',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link__products' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} div.prodigy-category-link-wrapper .prodigy-category-link:hover .prodigy-category-link__products' => 'color: {{VALUE}}',
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
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		if ( isset( $settings['category_image_media']['url'] ) && ! empty( $settings['category_image_media']['url'] ) ) {
			$attr['category_image']  = $settings['category_image_media']['url'];
		}

		$attr['height'] = $settings['prg_height']['size'] . 'px"';

		if ( $settings['prg_style_title_overlay'] === 'below' ) {
			$attr['link_classname'] = 'prodigy-category-link prodigy-category-link--below';
		} else {
			$attr['link_classname'] = 'prodigy-category-link';
			if ( $settings['prg_style_title_block_position'] === 'left' ) {
				$attr['link_classname'] .= ' prodigy-category-link--left';
			} if ( $settings['prg_style_title_block_position'] === 'right' ) {
				$attr['link_classname'] .= ' prodigy-category-link--right';
			} if ( $settings['prg_style_title_block_position_vertical'] === 'top' ) {
				$attr['link_classname'] .= ' prodigy-category-link--top';
			} if ( $settings['prg_style_title_block_position_vertical'] === 'middle' ) {
				$attr['link_classname'] .= ' prodigy-category-link--middle';
			}
		}

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
		$this->render_view( $attr );
	}

	/**
	 * @param array $attr
	 *
	 * @return string
	 */
	public function render_view( array $attr ) {
		do_action( 'prodigy_get_template_category_link', $attr );
	}

}
