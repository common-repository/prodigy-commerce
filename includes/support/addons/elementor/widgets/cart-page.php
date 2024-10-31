<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets\Cart;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @version 2.0.7
 */
class ElementorCartPage extends Widget_Base {

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
		return 'pg-cart-widget';
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
		return __( 'Cart Page', 'prodigy' );
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
		return 'prgicon prgicon-cart';
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
		$this->start_controls_section(
			'pg_style_cart_product_table_counter',
			array(
				'label' => __( 'Title Counter', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title',
			array(
				'label'     => __( 'Title', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title_show',
			array(
				'label'        => __( 'Show Title', 'prodigy' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'prodigy' ),
				'label_off'    => __( 'Hide', 'prodigy' ),
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_cart_table_counter_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
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
							'size' => 18,
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__counter-title',
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#49463d',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__counter-title' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title_padding',
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
					'{{WRAPPER}} .prodigy-cart__counter-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title_margin',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'prg_style_cart_table_counter_title_counter',
			array(
				'label'     => __( 'Counter', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_cart_table_title_counter_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
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
							'size' => 18,
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__counter-title > span',
			)
		);

		$this->add_control(
			'prg_style_cart_table_title_counter_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#49463d',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__counter-title > span' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_table',
			array(
				'label' => __( 'Products Table', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_cart_table_column_title',
			array(
				'label'     => __( 'Table Column Titles', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_cart_table_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
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
						'default' => 700,
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__table th.prodigy-cart__table-product-cell, .prodigy-cart__table th.prodigy-cart__table-price-cell, .prodigy-cart__table th.prodigy-cart__table-quantity-cell',
			)
		);

		$this->add_control(
			'prg_style_cart_table_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell, .prodigy-cart__table-quantity-cell' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '-1',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell, .prodigy-cart__table-quantity-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_border_type',
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
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell,.prodigy-cart__table-desc-cell, .prodigy-cart__table-quantity-cell' => 'border-style: {{SIZE}} !important',
					'{{WRAPPER}} .prodigy-cart__table' => 'border-top-style: {{SIZE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_table_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'tablet_default' => array(
					'bottom' => '1',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'mobile_default' => array(
					'bottom' => '1',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__table-product-cell'  => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table-price-cell'    => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table-desc-cell'     => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table-quantity-cell' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table'               => 'border-top-width: {{TOP}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table-product-cell'  => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table-price-cell'    => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table-desc-cell'     => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table-quantity-cell' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table'               => 'border-top-color: {{VALUE}} !important',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_rows',
			array(
				'label' => __( 'Products Rows', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '18',
					'right'    => '0',
					'bottom'   => '18',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} tr.prodigy-cart__tr > td' => 'padding-top: {{TOP}}{{UNIT}}',
					'{{WRAPPER}} tr.prodigy-cart__tr td' => 'padding-bottom: {{BOTTOM}}{{UNIT}}',
					'{{WRAPPER}} tr.prodigy-cart__tr td:first-of-type' => 'padding-left: {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} tr.prodigy-cart__tr td:last-of-type' => 'padding-right: {{RIGHT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_border_type',
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
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr:first-of-type td'                                => 'border-top-style: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:first-of-type'                                => 'border-left-style: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:last-of-type'                                 => 'border-right-style: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td.prodigy-cart__table-data-info:nth-of-type(2)' => 'border-right-style: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_product_rows_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '1',
					'right'  => '0',
					'bottom' => '1',
					'left'   => '0',
					'unit'   => 'px',
				),
				'tablet_default' => array(
					'top'    => '1',
					'right'  => '0',
					'bottom' => '1',
					'left'   => '0',
					'unit'   => 'px',
				),
				'mobile_default' => array(
					'top'    => '1',
					'right'  => '0',
					'bottom' => '1',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr:not(:first-of-type) td:not(.prodigy-table-cell__count-wrap)' => 'border-top-width: {{TOP}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td'                                                         => 'border-bottom-width: {{TOP}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:first-of-type'                                           => 'border-left-width: {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:last-of-type'                                            => 'border-right-width: {{RIGHT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td.prodigy-cart__table-data-info:nth-of-type(2)'            => 'border-right-width: {{RIGHT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr:first-of-type td'                                => 'border-top-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr:not(:first-of-type) td'                          => 'border-top-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td'                                              => 'border-bottom-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:first-of-type'                                => 'border-left-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td:last-of-type'                                 => 'border-right-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .prodigy-cart__tbody tr.prodigy-cart__tr td.prodigy-cart__table-data-info:nth-of-type(2)' => 'border-right-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_product_mobile_space',
			array(
				'label'          => __( 'Mobile Gap', 'prodigy' ),
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
					'size' => 22,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__table-body' => 'gap: {{SIZE}}{{UNIT}} !important',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_product_image',
			array(
				'label' => __( 'Product Image', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_product_image_border_type',
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
					'{{WRAPPER}} div.prodigy-cart__placeholder a' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_product_image_border_width',
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
					'{{WRAPPER}} div.prodigy-cart__placeholder a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_image_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__placeholder a' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_image_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__placeholder a' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_product_image_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-cart__placeholder-wrap' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_product_logo_image',
			array(
				'label' => __( 'Logo Image', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_border_type',
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
					'{{WRAPPER}} div.prodigy-cart__placeholder-logo span' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_border_width',
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
					'{{WRAPPER}} div.prodigy-cart__placeholder-logo span' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__placeholder-logo span' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_product_logo_image_bg_color',
			array(
				'label'      => __( 'Background Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__placeholder-logo span' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_product_logo_image_spacing',
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
					'{{WRAPPER}} .prodigy-cart__placeholder-logo' => 'gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_product_image_size',
			array(
				'label'          => __( 'Image Size', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'default'        => array(
					'size' => 64,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 64,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 48,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__placeholder-logo a' => 'max-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'pg_style_cart_table_product_title',
			array(
				'label' => __( 'Product Title', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__table-info-title',
			)
		);

		$this->add_control(
			'pg_style_cart_table_product_title_link_color',
			array(
				'label'      => __( 'Link Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__table-info-title a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_product_title_link_color_hover',
			array(
				'label'      => __( 'Link Color Hover', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#0170b9',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__table-info-title a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_table_product_title_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart__table-info-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_table_product_sku',
			array(
				'label' => __( 'SKU', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_sku_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .sku',
			)
		);

		$this->add_control(
			'pg_style_cart_table_product_sku_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .sku' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_table_product_sku_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
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
					'{{WRAPPER}} .sku' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_attribute_name',
			array(
				'label' => __( 'Attribute Name', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_attribute_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants-attr-name',
			)
		);

		$this->add_control(
			'pg_style_cart_product_attribute_name_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants-attr-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_attribute_name_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants-attr-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_attribute_value',
			array(
				'label' => __( 'Attribute Value', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_attribute_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants-attr-value',
			)
		);

		$this->add_control(
			'pg_style_cart_product_attribute_value_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000000',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants-attr-value' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_attribute_value_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants-attr-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_logo_info',
			array(
				'label' => __( 'Logo Info', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_product_logo_info_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-cart-item__info-logo-variants' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_name',
			array(
				'label'     => __( 'Logo Name', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_logo_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-logo__name',
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_name_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-logo__name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_name_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-logo__name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_value',
			array(
				'label'     => __( 'Logo Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_logo_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__logo-value',
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_value_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000000',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__logo-value' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logo_value_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants__logo-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_name',
			array(
				'label'     => __( 'Logo Location Name', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_logolocation_name_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-location__name',
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_name_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-location__name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_name_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-location__name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_value',
			array(
				'label'     => __( 'Logo Location Value', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_logolocation_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__info-variants__location-value',
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_value_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000000',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__info-variants__location-value' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_logolocation_value_padding',
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
					'{{WRAPPER}} .prodigy-cart-item__info-variants__location-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',

				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subscription_label',
			array(
				'label' => __( 'Subscription Label', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_label_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart-item__tag',
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_typography_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_typography_border_type',
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
					'{{WRAPPER}} div.prodigy-cart-item__tag' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_typography_border_width',
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
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_subscription_label_state' );
		$this->start_controls_tab(
			'pg_style_cart_subscription_label_state_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_state_background_color_normal',
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
			'pg_style_cart_subscription_label_state_border_color_normal',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'border-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_subscription_label_state_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_state_background_color_hover',
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
			'pg_style_cart_subscription_label_state_border_color_hover',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag:hover' => 'border-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_subscription_label_border_radius',
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
			'pg_style_cart_subscription_label_border_padding',
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
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_subscription_label_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-cart-item__tag' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subscription_conditions',
			array(
				'label' => __( 'Subscription Conditions', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_conditions_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'capitalize',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-subscription-condition',
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#a6abbc',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscription-condition' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_subscription_conditions_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
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
					'{{WRAPPER}} .prodigy-subscription-condition, .prodigy-subscription-condition-value, .prodigy-tooltip' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_subscription_conditions_right_margin',
			array(
				'label'          => __( 'Right Margin', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-subscription-condition' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subscription_conditions_value',
			array(
				'label' => __( 'Subscription Conditions Value', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_conditions_value_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'capitalize',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-subscription-condition-value',
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subscription-condition-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subscription_tooltip',
			array(
				'label' => __( 'Subscription Tooltip', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_tooltip_icon_size',
			array(
				'label'      => __( 'Icon Font Size', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-info' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_tooltip_icon_color',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#a6abbc',
				'selectors' => array(
					'{{WRAPPER}} .icon-info' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_tooltip_icon_color_hover',
			array(
				'label'     => __( 'Icon Color Hover', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0693e3',
				'selectors' => array(
					'{{WRAPPER}} .icon-info:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_tooltip_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.3,
				),
				'selectors' => array(
					'{{WRAPPER}} .icon-info:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_conditions_value_tooltip_typography',
				'label'          => __( 'Tooltip Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-tooltip__message',
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_text_color',
			array(
				'label'      => __( 'Tooltip Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_border_type',
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
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_border_width',
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
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_background_color',
			array(
				'label'     => __( 'Tooltip Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#445668',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_conditions_value_tooltip_border_radius',
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
			'pg_style_cart_subscription_conditions_value_tooltip_padding',
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
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-tooltip__message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_table_remove_link',
			array(
				'label' => __( 'Remove Link', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_remove_link_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
				'selector'       => '{{WRAPPER}} a.prodigy-cart__remove.prodigy-cart__remove-item',
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_table_remove_link_tabs' );
		$this->start_controls_tab(
			'pg_style_cart_table_remove_link_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_table_remove_link_text_color_normal',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000',
				'selectors'  => array(
					'{{WRAPPER}} a.prodigy-cart__remove.prodigy-cart__remove-item' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_table_remove_link_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_table_remove_link_text_color_hover',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3558BC',
				'selectors'  => array(
					'{{WRAPPER}} a.prodigy-cart__remove.prodigy-cart__remove-item:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pg_style_cart_table_product_remove_link_bottom_margin',
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
					'{{WRAPPER}} a.prodigy-cart__remove.prodigy-cart__remove-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_price',
			array(
				'label' => __( 'Price', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_price_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-cart__total-price:not(.prodigy-cart__total-cell)',
			)
		);

		$this->add_control(
			'pg_style_cart_price_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__total-price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_price_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__total-price:not(.prodigy-cart__total-price-sm)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_quantity',
			array(
				'label' => __( 'Quantity', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_title',
			array(
				'label'     => __( 'QTY', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_quantity_count_title_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-qty',
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_title_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#49463d',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-qty' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count',
			array(
				'label'     => __( 'Count', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_quantity_count_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} input.prodigy-counter__total',
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_height',
			array(
				'label'      => __( 'Height', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_width',
			array(
				'label'      => __( 'Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 60,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#666666',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fafafa',
				'selectors' => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_border_type',
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
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '1',
					'right'  => '1',
					'left'   => '1',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_border_color',
			array(
				'label'      => __( 'Border Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#e9eaee',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_total',
			array(
				'label' => __( 'Total', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_total_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-cart__total-cell',
			)
		);

		$this->add_control(
			'pg_style_cart_total_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__total-cell' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_total_padding',
			array(
				'label'          => __( 'Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '8',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__total-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subtotal',
			array(
				'label' => __( 'Subtotal', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subtotal_text_typography',
				'label'          => __( 'Text Typography', 'prodigy' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
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
						'default' => 700,
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
				'selector'       => '{{WRAPPER}} span.prodigy-cart__total-text',
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} span.prodigy-cart__total-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subtotal_value_typography',
				'label'          => __( 'Value Typography', 'prodigy' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
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
						'default' => 700,
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
				'selector'       => '{{WRAPPER}} span.prodigy-cart__total-value',
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subtotal_padding_block',
			array(
				'label'          => __( 'Padding Block', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart__total-info' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subtotal_block_alignment',
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
					'{{WRAPPER}} .prodigy-cart__total-info .justify-content-sm-end' => 'justify-content: {{VALUE}} !important',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_style_subtotal_block_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'size' => 42,
					'unit' => '%',
				),
				'tablet_default' => array(
					'size' => 40,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 100,
					'unit' => '%',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart-subtotal__block' => 'min-width: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart-subtotal__block .prodigy-subtotal__btn-block > a' => 'flex: 1 !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_value_color',
			array(
				'label'      => __( 'Value Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} span.prodigy-cart__total-value' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_divider_type',
			array(
				'label'     => __( 'Divider Type', 'prodigy' ),
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
					'{{WRAPPER}} div.prodigy-divider-block' => 'border-bottom: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_mobile_divider_type',
			array(
				'label'     => __( 'Mobile Divider Top Type', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-cart__total-info' => 'border-top-style: {{TYPE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_divider_width',
			array(
				'label'      => __( 'Divider Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '0',
					'right'  => '0',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-divider-block' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_mobile_divider_width',
			array(
				'label'      => __( 'Divider Mobile Top Width', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => '1',
					'unit' => 'px',
					'step' => '1',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__total-info' => 'border-top-width: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_divider_color',
			array(
				'label'      => __( 'Divider Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-divider-block' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_mobile_divider_color',
			array(
				'label'      => __( 'Divider Mobile Top Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__total-info' => 'border-top-color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_border_padding',
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
					'{{WRAPPER}} div.prodigy-divider-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_empty_cart_message',
			array(
				'label' => __( 'Empty Cart Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_empty_cart_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'normal',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-empty-cart__txt',
			)
		);

		$this->add_control(
			'pg_style_cart_empty_cart_message_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#333333',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-empty-cart__txt' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_widget_buttons',
			array(
				'label' => __( 'Buttons', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout',
			array(
				'label'     => __( 'Proceed To Checkout Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_widget_buttons_proceed_to_checkout_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-main-button__checkout',
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
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
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_width',
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
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_padding',
			array(
				'label'      => __( 'Text Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_widget_buttons_proceed_to_checkout_tab' );
		$this->start_controls_tab(
			'pg_style_cart_widget_buttons_proceed_to_checkout_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_text_color_normal',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_normal_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_normal_border_type',
			array(
				'label'     => __( 'Border Type', 'prodigy' ),
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
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_normal_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-main-button__checkout:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_tooltip_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button__checkout:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button',
			array(
				'label'     => __( 'Continue Shopping Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_widget_continue_shopping_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-subtotal__btn-continue',
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_type',
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
					'{{WRAPPER}} .prodigy-subtotal__btn-continue' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '1',
					'right'  => '1',
					'left'   => '1',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_padding',
			array(
				'label'      => __( 'Text Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_widget_continue_shopping_button_tab' );
		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_text_color_normal',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue,.icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_normal_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_normal_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-subtotal__btn-continue' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_button_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue:hover,.prodigy-subtotal__btn-continue:hover .icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-subtotal__btn-continue:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-subtotal__btn-continue:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button',
			array(
				'label'     => __( 'Continue Shopping(Empty) Button', 'prodigy' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_widget_continue_shopping_empty_button_typography',
				'label'          => __( 'Typography', 'prodigy' ),
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
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .prodigy-subtotal__btn-continue.prodigy-empty-cart__link, .prodigy-main-button.prodigy-empty-cart__link > span',
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_border_type',
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
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_border_width',
			array(
				'label'      => __( 'Border Width', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '1',
					'right'  => '1',
					'left'   => '1',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_responsive_control(
			'pg_style_cart_widget_continue_shopping_empty_button_padding',
			array(
				'label'          => __( 'Text Padding', 'prodigy' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => array( 'px', 'em' ),
				'default'        => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'tablet_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'mobile_default' => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link span' => 'white-space: nowrap',
				),
			)
		);

		$this->add_responsive_control(
			'pg_style_cart_widget_continue_shopping_empty_button_width',
			array(
				'label'          => __( 'Width', 'prodigy' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'default'        => array(
					'unit' => 'px',
					'size' => 'auto',
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => 'auto',
				),
				'mobile_default' => array(
					'unit' => 'px',
					'size' => 'auto',
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_widget_continue_shopping_empty_button_tab' );
		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_empty_button_tab_normal',
			array(
				'label' => __( 'Normal', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link, .prodigy-main-button.prodigy-empty-cart__link .icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_normal_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_normal_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_empty_button_hover',
			array(
				'label' => __( 'Hover', 'prodigy' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_hover_text_color',
			array(
				'label'      => __( 'Text Color', 'prodigy' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link:hover,.prodigy-main-button.prodigy-empty-cart__link:hover .icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_empty_button_transition',
			array(
				'label'     => __( 'Transition Duration', 'prodigy' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.2,
				),
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button.prodigy-empty-cart__link:hover,.prodigy-main-button.prodigy-empty-cart__link:hover .icon-arrow-left:before' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Removed Product Message
		*/
		$this->start_controls_section(
			'prg_cart_style_removed',
			array(
				'label' => __( 'Removed Product Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_style_removed_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} .prodigy-cart-dropdown__alert--default span, ',
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
			'prg_cart_style_removed_border_type',
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_border_width',
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
					'prg_cart_style_removed_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_padding',
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_color_icon',
			array(
				'label'     => __( 'Icon Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default .icon.icon-error' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#93c3344d',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_style_removed_border_color',
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
					'{{WRAPPER}} .prodigy-cart-dropdown__alert--default' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/*
		* Warning  Message
		*/
		$this->start_controls_section(
			'prg_cart_warning_message',
			array(
				'label' => __( 'Warning Quantity Message', 'prodigy' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'prg_cart_warning_message_alignment',
			array(
				'label'          => __( 'Alignment', 'prodigy' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'options'        => array(
					'left'   => __( 'Left', 'prodigy' ),
					'center' => __( 'Center', 'prodigy' ),
					'right'  => __( 'Right', 'prodigy' ),
				),
				'selectors'      => array(
					'{{WRAPPER}} .prodigy-cart__notification' => 'text-align: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_cart_warning_message_typography',
				'label'          => __( 'Typography', 'prodigy' ),
				'selector'       => '{{WRAPPER}} p.prodigy-cart__notification-message',
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
			'prg_cart_warning_message_color',
			array(
				'label'     => __( 'Text Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__notification-message' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_warning_message_bg_color',
			array(
				'label'     => __( 'Background Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e9eaee',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-cart__notification' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_warning_message_border_type',
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
					'{{WRAPPER}} .prodigy-cart__notification' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_warning_message_border_width',
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
					'prg_cart_warning_message_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__notification' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_warning_message_border_radius',
			array(
				'label'      => __( 'Border Radius', 'prodigy' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__notification' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'prg_cart_warning_message_border_color',
			array(
				'label'     => __( 'Border Color', 'prodigy' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'condition' => array(
					'prg_cart_warning_message_border_type' => array(
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
					'{{WRAPPER}} .prodigy-cart__notification' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_warning_message_padding',
			array(
				'label'      => __( 'Padding', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => false,
				),
				'tablet_default'    => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => false,
				),
				'mobile_default'    => array(
					'unit'     => 'px',
					'top'      => '12',
					'right'    => '16',
					'bottom'   => '12',
					'left'     => '16',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__notification' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'prg_cart_warning_message_margin',
			array(
				'label'      => __( 'Margin', 'prodigy' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'tablet_default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'mobile_default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__notification' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}


	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function set_widget_options( array $settings ): array {
		$attr       = array();
		$parameters = array();
		foreach ( $settings as $key => $setting ) {
			if ( substr( $key, 0, 4 ) === 'prg_' && ! is_array( $setting ) ) {
				$attr[ str_replace( 'prg_', '', $key ) ] = $setting;
			}
		}

		if ( isset( $attr['style_cart_table_counter_title_show'] ) ) {
			$parameters['is_quantity_title'] = $attr['style_cart_table_counter_title_show'] === 'yes';
		}

		return $parameters;
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$attr = $this->set_widget_options( $settings );
		do_action( 'prodigy_get_template_cart_page', $attr );
	}
}
