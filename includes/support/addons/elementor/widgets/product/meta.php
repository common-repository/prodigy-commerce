<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Product;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorMeta extends \Elementor\Widget_Base {

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
		return 'pae-meta-product';
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
		return __( 'Product Meta', 'prodigy' );
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
		return 'prgicon prgicon-product-meta';
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
			'prg_style_gen_meta',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_meta_show_sku',
			array(
				'label'        => __( 'Show SKU', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'prodigy' ),
				'label_off'    => __( 'Disable', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'prg_meta_show_categories',
			array(
				'label'        => __( 'Show Categories', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'prodigy' ),
				'label_off'    => __( 'Disable', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'prg_meta_show_tags',
			array(
				'label'        => __( 'Show Tags', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'prodigy' ),
				'label_off'    => __( 'Disable', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_responsive_control(
			'prg_style_alignment_rating',
			array(
				'label'           => __( 'Alignment', 'prodigy' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'desktop_default' => 'left',
				'tablet_default'  => 'left',
				'mobile_default'  => 'left',
				'options'         => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'       => array(
					'{{WRAPPER}} .prodigy-product__tags' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_container_margin_meta_top',
			array(
				'label'          => __( 'Top Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-product__tags' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_container_margin_meta_bottom',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 9,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 9,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 9,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-product__tags' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Label
		 */
		$this->start_controls_section(
			'prg_style_label_meta',
			array(
				'label' => __( 'Label', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_label_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__tags-label',
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
			'prg_style_label_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Value
		 */
		$this->start_controls_section(
			'prg_style_value_meta',
			array(
				'label' => __( 'Value', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_sku_value',
			array(
				'label'     => __( 'SKU', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_sku_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__tags-text.product_sku_value',
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
			'prg_style_value_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_categories_tags_value',
			array(
				'label'     => __( 'Tags/Categories', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-product__tags-text:not(.product_sku_value)',
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
			'prg_style_value_link_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-text a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_value_link_color_hover',
			array(
				'label'      => __( 'Color Hover', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-text a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_style_value_margin_meta',
			array(
				'label'          => __( 'Left Margin', 'prodigy' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-product__tags-text' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Divider
		 */
		$this->start_controls_section(
			'prg_style_divider_meta',
			array(
				'label' => __( 'Divider', 'prodigy' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_divider_color',
			array(
				'label'      => __( 'Color', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-item' => 'border-top-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_style_divider_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-product__tags-item' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-product__tags-item:last-child' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
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

		$sett_prg['idWidget'] = $this->get_id();

		do_action( 'prodigy_product_additional_info_widget', $sett_prg );
	}
}
