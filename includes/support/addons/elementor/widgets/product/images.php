<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorImages extends \Elementor\Widget_Base {

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
		return 'pae-images-product';
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
		return __( 'Product Images', 'prodigy' );
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
		return 'prgicon prgicon-product-images';
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
			'prg_style_images_gen',
			array(
				'label' => __( 'Content', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'prg_content_thumbnails',
			array(
				'label'     => __( 'Thumbnails', 'prodigy' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'prodigy' ),
				'label_off' => __( 'Hide', 'prodigy' ),
				'default'   => 'yes',
			)
		);

		$this->end_controls_section();

		/*
		 * Gallery
		 */
		$this->start_controls_section(
			'prg_style_active_images',
			array(
				'label' => __( 'Gallery', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_gallery_gap',
			array(
				'label'          => __( 'Spacing', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'description'    => 'Between Gallery and Thumbnails',
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
				'condition'      => array(
					'prg_content_thumbnails' => array( 'yes' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__gallery-container' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_images_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_images_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_images_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_images_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_images_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'condition'  => array(
					'prg_style_images_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'image_ratio_active_image_box',
			array(
				'label'       => __( 'Aspect Ratio Box', 'prodigy' ),
				'description' => 'Aspect Ratio Box',
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'default'     => array(
					'width'  => 4,
					'height' => 5,
				),
				'selectors'   => array(
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide' => 'aspect-ratio: {{WIDTH}} / {{HEIGHT}} !important',
				),
			)
		);

		$this->add_control(
			'image_ratio_active_image',
			array(
				'label'       => __( 'Aspect Ratio Image', 'prodigy' ),
				'description' => 'Aspect Ratio Image',
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'default'     => array(
					'width'  => 3,
					'height' => 4,
				),
				'selectors'   => array(
					'{{WRAPPER}} .prodigy-product__gallery-main-image-container .prodigy-product__gallery > .swiper-wrapper .swiper-slide .prodigy-product__gallery-img' => 'aspect-ratio: {{WIDTH}} / {{HEIGHT}} !important',
				),
			)
		);

		$this->add_control(
			'image_ratio_active_image_prod_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-container .swiper-wrapper .swiper-slide' => 'background-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'image_ratio_active_image_prod_scale',
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-img svg' => 'transform: scale({{SIZE}})',
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
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_sale_badge_typography',
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
				'type'       => \Elementor\Controls_Manager::COLOR,
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
				'type'       => \Elementor\Controls_Manager::COLOR,
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
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
				'type'       => \Elementor\Controls_Manager::SLIDER,
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

		$this->end_controls_section();

		/*
		 * Gallery Navigation Buttons
		 */
		$this->start_controls_section(
			'prg_style_navigation',
			array(
				'label' => __( 'Gallery Navigation Buttons', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_navigation_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav-next' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_navigation_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_navigation_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_size',
			array(
				'label'      => __( 'Font Size', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'navigation_style_tabs' );

		$this->start_controls_tab(
			'navigation_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_navigation_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'navigation_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_navigation_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_navigation_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-nav:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		 * Gallery Control Buttons
		 */
		$this->start_controls_section(
			'prg_style_gallery_controls',
			array(
				'label' => __( 'Gallery Control Buttons', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_style_gallery_controls_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'prg_style_gallery_navigation_bottom_separator',
			array(
				'label'     => __( 'Full Screen Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_style_full_screen_btn_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_full_screen_btn_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_size',
			array(
				'label'      => __( 'Font Size', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_full_screen_btn_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'full_screen_btn_style_tabs' );

		$this->start_controls_tab(
			'full_screen_btn_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_full_screen_btn_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'full_screen_btn_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_full_screen_btn_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_full_screen_btn_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-icon--fullscreen:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_style_count',
			array(
				'label'     => __( 'Gallery Count', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'prg_style_count_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_count_padding_left',
			array(
				'label'          => __( 'Padding Left', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'padding-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_count_padding_right',
			array(
				'label'          => __( 'Padding Right', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_count_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__gallery-count',
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
							'unit' => 'px',
							'size' => 24,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 24,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 24,
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
			'prg_style_count_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_count_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_count_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_count_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_count_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_count_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_count_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_count_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery .prodigy-product__gallery-count' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Thumbnails
		 */
		$this->start_controls_section(
			'prg_style_style_thumbnails',
			array(
				'label'     => __( 'Thumbnails', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_thumbnails' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_position',
			array(
				'label'   => __( 'Position', 'prodigy' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => array(
					'top'    => __( 'Top', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
					'bottom' => __( 'Bottom', 'prodigy' ),
					'left'   => __( 'Left', 'prodigy' ),
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_slides',
			array(
				'label'     => __( 'Slides to show', 'prodigy' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 6,
				'default'   => 3,
				'condition' => array(
					'prg_style_thumbnails_position' => array(
						'top',
						'bottom',
					),
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'condition'  => array(
					'prg_style_thumbnails_position' => array(
						'left',
						'right',
					),
				),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => 120,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-container--left .prodigy-product__gallery-thumbs' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__gallery-container--right .prodigy-product__gallery-thumbs' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_spacing',
			array(
				'label'       => __( 'Spacing, px', 'prodigy' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'description' => 'Spacing between slides',
				'size_units'  => array( 'px' ),
				'default'     => array(
					'size' => 10,
					'unit' => 'px',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-img'         => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-img svg'     => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-img svg img' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);


		$this->add_control(
			'prg_image_ratio_thumbnails',
			array(
				'label'       => __( 'Aspect Ratio', 'prodigy' ),
				'description' => 'Aspect Ratio',
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'default'     => array(
					'width'  => 3,
					'height' => 4,
				),
				'selectors'   => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-img svg' => 'aspect-ratio: {{WIDTH}} / {{HEIGHT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide .prodigy-product__gallery-img svg' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_style_thumbnails_style_tabs' );

		$this->start_controls_tab(
			'prg_style_thumbnails_style_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide:not(.swiper-slide-thumb-active) .prodigy-product__gallery-img' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_thumbnails_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide:not(.swiper-slide-thumb-active) .prodigy-product__gallery-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => 'transparent',
				'condition'  => array(
					'prg_style_thumbnails_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide:not(.swiper-slide-thumb-active) .prodigy-product__gallery-img' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_style_thumbnails_style_tab_active',
			array(
				'label' => __( 'Active', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_type_active',
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide.swiper-slide-thumb-active .prodigy-product__gallery-img' => 'border-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_width_active',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_thumbnails_border_type_active' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide.swiper-slide-thumb-active .prodigy-product__gallery-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbnails_border_color_active',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'condition'  => array(
					'prg_style_thumbnails_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .swiper-slide.swiper-slide-thumb-active .prodigy-product__gallery-img' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'prg_style_thumbs_navigation',
			array(
				'label'     => __( 'Thumbnails Navigation Buttons', 'prodigy' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'prg_content_thumbnails' => array( 'yes' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_thumbs_navigation_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery-container--left .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery-container--right .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery-container--left .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-next' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .prodigy-product__gallery-container--right .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav-next' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_thumbs_navigation_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_thumbs_navigation_height',
			array(
				'label'          => __( 'Height', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_size',
			array(
				'label'      => __( 'Font Size', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_border_type',
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_border_width',
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
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'condition'  => array(
					'prg_style_thumbs_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'thumbs_navigation_style_tabs' );

		$this->start_controls_tab(
			'thumbs_navigation_style_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_thumbs_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'thumbs_navigation_style_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_bg_color_hover',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_thumbs_navigation_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#808285',
				'condition'  => array(
					'prg_style_thumbs_navigation_border_type' => array(
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
					'{{WRAPPER}} .prodigy-product__gallery-thumbs .prodigy-product__gallery-nav:hover' => 'border-color: {{VALUE}}',
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

			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$sett_prg[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$sett_prg['style_thumbnails_spacing']['size'] = $settings['prg_style_thumbnails_spacing']['size'] ?? false;

		$sett_prg['idWidget'] = $this->get_id();

		do_action( 'prodigy_before_single_product_summary', array( 'settings' => $sett_prg ) );
	}
}
