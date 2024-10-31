<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Prodigy\Includes\Frontend\Prodigy_Public;

class ElementorCart extends Widget_Base {

	public function get_script_depends() {
		return array( 'cart-widget' );
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
		return 'pg-cart';
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
		return __( 'Product Cart', 'prodigy' );
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
		return 'prgicon prgicon-cart-menu';
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
		* General - Content
		*/
		$this->start_controls_section(
			'prg_cart_content_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_content_gen_message_info',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => 'You should turn off the Customizer Menu Cart if you are using this widget. 
                To do this, proceed to the <a href=" ' . get_admin_url( null, 'customize.php?autofocus[section]=prodigy_general_options' ) . '" target="_blank">Appearance -> Customize -> Prodigy -> General</a>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			)
		);

		$this->add_control(
			'prg_cart_content_gen_type',
			array(
				'label'   => __( 'Cart Type', 'prodigy' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'slide-cart'    => __( 'Slide', 'prodigy' ),
					'dropdown-cart' => __( 'Dropdown', 'prodigy' ),
				),
				'default' => 'dropdown-cart',
			)
		);

		$this->add_control(
			'prg_cart_content_gen_alignment',
			array(
				'label'     => __( 'Cart Position', 'prodigy' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'  => array(
						'title' => __( 'Left', 'prodigy' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'prodigy' ),
						'icon'  => 'eicon-h-align-center',
					),
					'end'    => array(
						'title' => __( 'Right', 'prodigy' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'end',
				'toggle'    => true,
				'condition' => array(
					'prg_cart_content_gen_type' => array( 'dropdown-cart' ),
				),
			)
		);

		$this->add_control(
			'prg_cart_content_gen_auto_open',
			array(
				'label'       => __( 'Automatically Open Cart', 'prodigy' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'yes' => __( 'Yes', 'prodigy' ),
					'no'  => __( 'No', 'prodigy' ),
				),
				'default'     => 'yes',
				'description' => 'Open the cart every time an item is added.',
				'render_type' => 'template',
			)
		);

		$this->end_controls_section();

		/*
		* Menu Icon
		*/
		$this->start_controls_section(
			'prg_cart_content_icon',
			array(
				'label' => __( 'Menu Icon', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_content_icon_value',
			array(
				'label'       => __( 'Icon', 'prodigy' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'icon icon-cart',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'prg_cart_content_icon_position',
			array(
				'label'     => __( 'Icon Position', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'left'  => __( 'Before', 'prodigy' ),
					'right' => __( 'After', 'prodigy' ),
				),
				'default'   => 'right',
				'condition' => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
			)
		);

		$this->add_control(
			'prg_cart_content_icon_items_indicator',
			array(
				'label'        => __( 'Items Indicator', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'prodigy' ),
				'label_off'    => __( 'Hide', 'prodigy' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'prg_cart_content_icon_hide_empty',
			array(
				'label'     => __( 'Hide Empty', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'yes' => __( 'Yes', 'prodigy' ),
					'no'  => __( 'No', 'prodigy' ),
				),
				'default'   => 'yes',
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/*
		* General - Style
		*/
		$this->start_controls_section(
			'prg_cart_style_gen',
			array(
				'label' => __( 'General', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_gen_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 50,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 50,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-slide' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Menu Cart Button
		*/
		$this->start_controls_section(
			'prg_cart_style_button',
			array(
				'label' => __( 'Menu Cart Button', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_button_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'flex-end',
				'tablet_default' => 'flex-end',
				'mobile_default' => 'flex-end',
				'options'        => array(
					'flex-start' => __( 'Left', 'prodigy' ),
					'center'     => __( 'Center', 'prodigy' ),
					'flex-end'   => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-slide' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__wrap' => 'justify-content: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_visibility',
			array(
				'label'     => __( 'Text Visibility', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'block',
				'options'   => array(
					'block' => __( 'visible', 'prodigy' ),
					'none'  => __( 'hidden', 'prodigy' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle > span.prodigy-navbar-cart__txt' => 'display: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart__toggle > span.prodigy-navbar-cart__txt',
				'condition'      => array(
					'prg_cart_style_button_visibility' => 'block',
				),
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
			'prg_cart_style_button_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'border-style: {{SIZE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_border_width',
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
					'prg_cart_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '20',
					'bottom'   => '0',
					'left'     => '20',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; min-height: 40px !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_transition',
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
					'{{WRAPPER}} .prodigy-cart__toggle' => 'transition-duration: {{SIZE}}s !important;',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_button_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_button_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_icon_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'condition' => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle i' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'condition' => array(
					'prg_cart_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__toggle' => 'border-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_button_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_button_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle:hover' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'condition' => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle:hover i' => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__toggle:hover' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'condition' => array(
					'prg_cart_style_button_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__toggle:hover' => 'border-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_icon_separator',
			array(
				'label'     => __( 'Menu Icon', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_icon_spacing',
			array(
				'label'      => __( 'Icon Spacing', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 8,
					'unit' => 'px',
				),
				'condition'  => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__toggle' => 'column-gap: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_icon_size',
			array(
				'label'      => __( 'Icon Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'condition'  => array(
					'prg_cart_content_icon_value[value]!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .icon-img' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_separator',
			array(
				'label'     => __( 'Items Indicator', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f55454',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_indicator_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-navbar-cart__count',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 10,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 10,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 10,
						),
					),
					'font_weight'    => array(
						'default' => 800,
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
				'condition'      => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count' => 'min-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_position_vertical',
			array(
				'label'     => __( 'Position Vertical', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'top'    => __( 'Top', 'prodigy' ),
					'bottom' => __( 'Bottom', 'prodigy' ),
				),
				'default'   => 'top',
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_position_vertical_dist',
			array(
				'label'      => __( 'Position Vertical Distance', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => -12,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count:not(.prodigy-navbar-cart__count--bottom)' => 'top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-navbar-cart__count--bottom' => 'bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_position_horizontal',
			array(
				'label'     => __( 'Position Horizontal', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'left'  => __( 'Left', 'prodigy' ),
					'right' => __( 'Right', 'prodigy' ),
				),
				'default'   => 'right',
				'condition' => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_indicator_position_horizontal_dist',
			array(
				'label'      => __( 'Position Horizontal Distance', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-navbar-cart__count:not(.prodigy-navbar-cart__count--left)' => 'right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-navbar-cart__count--left' => 'left: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'prg_cart_content_icon_items_indicator' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Cart
		*/
		$this->start_controls_section(
			'prg_cart_style_cart',
			array(
				'label' => __( 'Cart', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_cart_style_heading_separator',
			array(
				'label' => __( 'Heading', 'prodigy' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_heading_alignment',
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
					'{{WRAPPER}} .prodigy-cart-dropdown__title' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_heading_text',
			array(
				'label'   => __( 'Text Value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Shopping Cart',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_heading_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__title',
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
			'prg_cart_style_heading_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_heading_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart__head' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_heading_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__head' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_heading_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__head' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_heading_border_width',
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
					'isLinked' => false,
				),
				'condition'  => array(
					'prg_cart_style_heading_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__head' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_heading_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__head' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_close_separator',
			array(
				'label'     => __( 'Close Cart', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_cart_style_close_size',
			array(
				'label'      => __( 'Icon Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__head .icon.icon-close ' => 'font-size: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_close_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_close_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_close_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__head .icon.icon-close, .prodigy-cart-dropdown__header-close' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_close_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_close_color_hover',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__head .icon.icon-close:hover, .prodigy-cart-dropdown__header-close:hover' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_remove_separator',
			array(
				'label'     => __( 'Remove Item', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_remove_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__remove-btn',
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
						'default' => 'capitalize',
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

		$this->add_responsive_control(
			'prg_cart_style_remove_top_margin',
			array(
				'label'          => __( 'Top Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 6,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 6,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 6,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-item:not(.prodigy-cart-loading__element) .prodigy-cart-item__remove-btn' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_remove_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_remove_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_remove_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__remove-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_remove_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_remove_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__remove-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_subtotal_separator',
			array(
				'label'     => __( 'Subtotal', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subtotal_text_typography',
				'label'          => __( 'Text Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-widget__subtotal-txt, .prodigy-cart-total__text',
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
			'prg_cart_style_subtotal_text_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-widget__subtotal-txt' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subtotal_value_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-total__value',
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
			'prg_cart_style_subtotal_value_color',
			array(
				'label'     => __( 'Value Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-total__value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subtotal_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart-total' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-total' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_border_width',
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
					'prg_cart_style_subtotal_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-total' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-total' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '8',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-total' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_subtotal_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_subtotal_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-total' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d9dbe1',
				'condition' => array(
					'prg_cart_style_subtotal_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-total' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_subtotal_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-total:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subtotal_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d9dbe1',
				'condition' => array(
					'prg_cart_style_subtotal_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-total:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		* Products
		*/
		$this->start_controls_section(
			'prg_cart_style_products',
			array(
				'label' => __( 'Products', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_separator',
			array(
				'label' => __( 'Box', 'prodigy' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_width',
			array(
				'label'      => __( 'Box Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 150,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '100',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-wrap' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_height',
			array(
				'label'      => __( 'Box Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 150,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '100',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_border_width',
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
					'prg_cart_style_products_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '0',
					'bottom'   => '16',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_products_box_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_products_box_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_cart_style_products_box_shadow_box',
				'selector' => '{{WRAPPER}} .prodigy-cart-item',
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d9dbe1',
				'condition' => array(
					'prg_cart_style_products_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_products_box_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'prg_cart_style_products_box_shadow_box_hover',
				'selector' => '{{WRAPPER}} .prodigy-cart-item:hover',
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_box_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d9dbe1',
				'condition' => array(
					'prg_cart_style_products_box_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_product_logo_image_control',
			array(
				'label'     => __( 'Logo Image', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_control_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => esc_attr( 'none' ),
					'dotted' => esc_attr( 'dotted' ),
					'dashed' => esc_attr( 'dashed' ),
					'double' => esc_attr( 'double' ),
					'groove' => esc_attr( 'groove' ),
					'ridge'  => esc_attr( 'ridge' ),
					'inset'  => esc_attr( 'inset' ),
					'outset' => esc_attr( 'outset' ),
					'hidden' => esc_attr( 'hidden' ),
					'solid'  => esc_attr( 'solid' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo span' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_control_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '0',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo span' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_control_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo span' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_control_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo span' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_product_logo_image_control_spacing',
			array(
				'label'          => __( 'Image Spacing', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_product_logo_image_control_size',
			array(
				'label'          => __( 'Image Size', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 48,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 48,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 48,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-item .prodigy-cart__placeholder-logo span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_title_separator',
			array(
				'label'     => __( 'Product Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_products_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-title',
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
			'prg_cart_style_products_title_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_products_title_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'size' => 12,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 12,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-item__info-title:not(.prodigy-cart-item__loading-info-title)' => 'margin-bottom: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart-item__info-title.prodigy-cart-item__loading-info-title' => 'margin-bottom: 8px !important',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_quantity_separator',
			array(
				'label'     => __( 'Product Quantity', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_products_quantity_text_typography',
				'label'          => __( 'Text Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__qty-text',
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
					'text_transform' => array(
						'default' => 'uppercase',
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
			'prg_cart_style_products_quantity_text_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__qty-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_products_quantity_value_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-price__count',
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
			'prg_cart_style_products_quantity_value_color',
			array(
				'label'     => __( 'Value Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-price__count' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_products_quantity_left_margin',
			array(
				'label'          => __( 'Left Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-price__count' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_products_quantity_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart-item:not(.prodigy-cart-loading__element) .prodigy-cart-item__info-price .prodigy-cart-item__info-price-qty' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_products_price_separator',
			array(
				'label'     => __( 'Product Price', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_products_price_text_typography',
				'label'          => __( 'Text Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__prc-text',
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
			'prg_cart_style_products_price_text_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__prc-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_products_price_value_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-price__value',
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
			'prg_cart_style_products_price_value_color',
			array(
				'label'     => __( 'Value Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-price__value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_products_price_left_margin',
			array(
				'label'          => __( 'Left Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-price__value' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_products_price_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-price' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_separator',
			array(
				'label'     => __( 'Subscription Label', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subscr_label_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__tag',
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 10,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 10,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 10,
						),
					),
					'font_weight'    => array(
						'default' => 400,
					),
					'line_height'    => array(
						'default'        => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.2,
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
			'prg_cart_style_subscr_label_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_border_width',
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
					'prg_cart_style_subscr_label_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 4,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subscr_label_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_subscr_label_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_subscr_label_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e8eef1',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_subscr_label_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_subscr_label_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e8eef1',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__tag:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_label_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_subscr_label_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-item__tag:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_subscr_condition_separator',
			array(
				'label'     => __( 'Subscription Conditions', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subscr_condition_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item-subscr__condition',
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
							'size' => 1.2,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.2,
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
			'prg_cart_style_subscr_condition_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item-subscr__condition' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subscr_condition_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item-subscr__item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subscr_condition_right_margin',
			array(
				'label'          => __( 'Right Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item-subscr__condition' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_value_separator',
			array(
				'label'     => __( 'Subscription Conditions Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subscr_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item-subscr__value',
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
							'size' => 1.2,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.2,
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
			'prg_cart_style_subscr_value_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item-subscr__value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_separator',
			array(
				'label'     => __( 'Subscription Tooltip', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_icon_size',
			array(
				'label'      => __( 'Icon Font Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip .icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_subscr_tooltip_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_subscr_tooltip_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_icon_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip .icon' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_subscr_tooltip_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0693e3',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip:hover .icon' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_subscr_tooltip_icon_transition',
			array(
				'label'      => __( 'Icon Transition Duration', 'prodigy' ),
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
					'size' => 0.3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip .icon' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_subscr_tooltip_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-tooltip__message',
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
							'size' => 1.2,
						),
						'tablet_default' => array(
							'unit' => 'em',
							'size' => 1.2,
						),
						'mobile_default' => array(
							'unit' => 'em',
							'size' => 1.2,
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
			'prg_cart_style_subscr_tooltip_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_border_width',
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
					'prg_cart_style_subscr_tooltip_border_type' => array(
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
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_subscr_tooltip_border_type' => array(
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
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#445668',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_subscr_tooltip_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '4',
					'right'    => '8',
					'bottom'   => '4',
					'left'     => '8',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_attr_name_separator',
			array(
				'label'     => __( 'Attribute Name', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_attr_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__name:not(.prodigy-cart-item__info-logo__name):not(.prodigy-cart-item__info-location__name)',
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
			'prg_cart_style_attr_name_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name:not(.prodigy-cart-item__info-logo__name):not(.prodigy-cart-item__info-location__name)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_attr_name_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants li' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_attr_name_right_margin',
			array(
				'label'          => __( 'Right Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name:not(.prodigy-cart-item__info-logo__name):not(.prodigy-cart-item__info-location__name)' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_attr_value_separator',
			array(
				'label'     => __( 'Attribute Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_attr_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__value:not(.prodigy-cart-item__info-variants__logo-value):not(.prodigy-cart-item__info-variants__location-value)',
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
			'prg_cart_style_attr_value_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__value:not(.prodigy-cart-item__info-variants__logo-value):not(.prodigy-cart-item__info-variants__location-value)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_logo_name_separator',
			array(
				'label'     => __( 'Logo Name', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_logo_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-logo__name',
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
			'prg_cart_style_logo_name_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-logo__name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_logo_name_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants.prodigy-cart-item__info-logo-variants li' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_logo_name_right_margin',
			array(
				'label'          => __( 'Right Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-logo__name' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_logo_value_separator',
			array(
				'label'     => __( 'Logo Name Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_logo_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__value.prodigy-cart-item__info-variants__logo-value',
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
			'prg_cart_style_logo_value_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__value.prodigy-cart-item__info-variants__logo-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_logo_location_name_separator',
			array(
				'label'     => __( 'Location Name', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_logo_location_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-location__name',
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
			'prg_cart_style_location_name_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-location__name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_location_right_margin',
			array(
				'label'          => __( 'Right Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants__name.prodigy-cart-item__info-location__name' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_location_value_separator',
			array(
				'label'     => __( 'Location Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_location_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__value.prodigy-cart-item__info-variants__location-value',
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
			'prg_cart_style_location_value_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#57617f',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__value.prodigy-cart-item__info-variants__location-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Buttons
		*/
		$this->start_controls_section(
			'prg_cart_style_buttons',
			array(
				'label' => __( 'Buttons', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_separator',
			array(
				'label' => __( 'View Cart Button', 'prodigy' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_buttons_cart_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart__cart-btn',
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

		$this->add_control(
			'prg_cart_style_buttons_cart_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_border_width',
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
					'prg_cart_style_buttons_cart_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_bottom_margin',
			array(
				'label'      => __( 'Bottom Margin', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_transition',
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
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_buttons_cart_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_buttons_cart_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'condition' => array(
					'prg_cart_style_buttons_cart_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__cart-btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_buttons_cart_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__cart-btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_cart_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'condition' => array(
					'prg_cart_style_buttons_cart_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__cart-btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prg_cart_style_buttons_checkout_separator',
			array(
				'label'     => __( 'Checkout Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_buttons_checkout_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart__checkout-btn',
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

		$this->add_control(
			'prg_cart_style_buttons_checkout_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_border_width',
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
					'prg_cart_style_buttons_checkout_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_transition',
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
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->start_controls_tabs( 'prg_cart_style_buttons_checkout_tabs' );

		$this->start_controls_tab(
			'prg_cart_style_buttons_checkout_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_buttons_checkout_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__checkout-btn' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'prg_cart_style_buttons_checkout_tab_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_color_hover',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__checkout-btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_buttons_checkout_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_buttons_checkout_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__checkout-btn:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		* Empty Cart Message
		*/
		$this->start_controls_section(
			'prg_cart_style_empty',
			array(
				'label' => __( 'Empty Cart Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_cart_style_empty_text',
			array(
				'label'   => __( 'Text Value', 'prodigy' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'No products added yet',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_empty_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__alert-txt, .prodigy-cart-dropdown__alert--default span, ',
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
			'prg_cart_style_empty_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
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
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'border-style: {{SIZE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_border_width',
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
					'prg_cart_style_empty_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '16',
					'bottom'   => '8',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_color_icon',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert .icon.icon-info' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert .icon.icon-check' => 'color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default .icon.icon-error' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#93c3344d',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert:not(.prodigy-cart-dropdown__alert-error)' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_empty_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'prg_cart_style_empty_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}


	public function set_widget_parameters( $settings ) {
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) == 'prg_' && ! is_array( $setting ) ) {
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		if ( isset( $attr['cart_content_gen_type'] ) && $attr['cart_content_gen_type'] == 'dropdown-cart' ) {
			$attr['dropdown'] = 1;
		}

		$attr['cart_content_icon_value'] = $settings['prg_cart_content_icon_value']['value'];
		$attr['cart_content_icon_url']   = $settings['prg_cart_content_icon_value']['value']['url'] ?? '';

		$attr['cart_icon_type'] = 'icon';
		if ( ! empty( $attr['cart_content_icon_url'] ) ) {
			$attr['cart_icon_type'] = 'svg';
		}

		$attr['cart_icon_class'] = $attr['cart_content_icon_value'] ?? 'icon icon-cart';
		$attr['cart_svg_class']  = 'icon-img';
		if ( $attr['cart_content_icon_position'] === 'left' ) {
			$attr['cart_icon_class'] .= ' order-first';
			$attr['cart_svg_class']  .= ' order-first';
		}

		$attr['count_classname'] = 'prodigy-navbar-cart__count';
		if ( $attr['cart_style_indicator_position_vertical'] === 'bottom' ) {
			$attr['count_classname'] .= ' prodigy-navbar-cart__count--bottom';
		}
		if ( $attr['cart_style_indicator_position_horizontal'] === 'left' ) {
			$attr['count_classname'] .= ' prodigy-navbar-cart__count--left';
		}

		$attr['container_class'] = 'prodigy-cart-dropdown__container';
		if ( $attr['cart_content_gen_alignment'] === 'start' ) {
			$attr['container_class'] .= ' prodigy-cart-dropdown__container--left';
		}
		if ( $attr['cart_content_gen_alignment'] === 'center' ) {
			$attr['container_class'] .= ' prodigy-cart-dropdown__container--center';
		}

		$attr['heading_text']    = $attr['cart_style_heading_text'] ?? 'Shopping Cart';
		$attr['empty_cart_text'] = $attr['cart_style_empty_text'] ?? 'No products added yet';

		return $attr;
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.7.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$attr     = $this->set_widget_parameters( $settings );

		do_action( 'prodigy_shortcode_template_cart', $attr );
	}
}
