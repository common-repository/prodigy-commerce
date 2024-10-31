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
		return __( 'Product Search' );
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
				'label' => 'General',
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .prodigy-search__icon i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'prg_style_search_icon[value]!' => '',
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
				'label'          => esc_html( 'Typography' ),
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
				'label' => __( 'Normal' ),
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

				),
			)
		);

		$this->add_control(
			'prg_style_close_icon_color',
			array(
				'label'      => __( 'Close Icon Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__close-icon i' => 'color: {{VALUE}}',

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
				'label'      => esc_html( 'Border Radius' ),
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
				'label' => __( 'Focus' ),
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
				'label'      => __( 'Close Icon Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-search__input:focus ~ .prodigy-search__close-icon i' => 'color: {{VALUE}}',
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
				'label'      => esc_html( 'Border Radius' ),
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

		if ( isset( $settings['prg_style_sorting_text'] ) && empty( trim( $settings['prg_style_sorting_text'] ) ) ) {
			$settings['prg_style_sorting_text'] = 'Showing';
		}

		$sett_prg = array();
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$sett_prg[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		$sett_prg['idWidget'] = $this->get_id();

		do_action( 'prodigy_shortcode_template_search', array( 'settings' => $sett_prg ) );
	}
}
