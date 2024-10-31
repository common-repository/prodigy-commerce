<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorBreadcrumbs extends \Elementor\Widget_Base {

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
		return 'pae-breadcrumbs-product';
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
		return __( 'Breadcrumbs', 'prodigy' );
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
		return 'prgicon prgicon-breadcrumbs';
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
		 * General
		 */
		$this->start_controls_section(
			'prg_style_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_bread_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-breadcrumbs .prodigy-breadcrumbs__item, .prodigy-breadcrumbs .prodigy-breadcrumbs__item-divider',
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

		$this->add_control(
			'prg_style_bread_color',
			array(
				'label'      => __( 'Link Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0274be',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-breadcrumbs .prodigy-breadcrumbs__item-link' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_bread_color_hover',
			array(
				'label'      => __( 'Link Color Hover', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-breadcrumbs .prodigy-breadcrumbs__item-link:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_alignment',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'desktop_default' => 'flex-start',
				'tablet_default'  => 'flex-start',
				'mobile_default'  => 'flex-start',
				'options'         => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} .prodigy-breadcrumbs' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_curr_page',
			array(
				'label'       => __( 'Current page', 'prodigy' ),
				'description' => 'last item in the Breadcrumbs',
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => __( 'Show', 'prodigy' ),
				'label_off'   => __( 'Hide', 'prodigy' ),
				'default'     => 'yes',
			)
		);

		$this->add_control(
			'prg_style_bread_color_text',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3a3a3a',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-breadcrumbs span.prodigy-breadcrumbs__item' => 'color: {{VALUE}}',
				),
				'condition'  => array(
					'prg_style_curr_page' => array( 'yes' ),
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_gen_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-breadcrumbs' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

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

		$sett_prg['idwidget'] = $this->get_id();

		do_action( 'prodigy_single_product_breadcrumbs', array( 'settings' => $sett_prg ) );
	}
}
