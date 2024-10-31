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
class ElementorCartPageWidget extends Widget_Base {

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
		return __( 'Cart Page' );
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
			'pg_style_cart_product_table',
			array(
				'label' => 'Products Table',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'prg_style_cart_table_column_title',
			array(
				'label'     => __( 'Table Column Titles' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'prg_style_cart_table_typography',
				'label'          => esc_html( 'Value Typography' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell, .prodigy-cart__table-quantity-cell',
			)
		);

		$this->add_control(
			'prg_style_cart_table_text_color',
			array(
				'label'      => __( 'Text Color' ),
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
				'label'      => __( 'Padding' ),
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
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell,.prodigy-cart__table-desc-cell, .prodigy-cart__table-quantity-cell' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell,.prodigy-cart__table-desc-cell, .prodigy-cart__table-quantity-cell' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_table_border_color',
			array(
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table-product-cell, .prodigy-cart__table-price-cell,.prodigy-cart__table-desc-cell, .prodigy-cart__table-quantity-cell' => 'border-top-color: {{VALUE}} !important',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_product_rows',
			array(
				'label' => 'Products Rows',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_padding',
			array(
				'label'      => __( 'Padding' ),
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
					'{{WRAPPER}} tr.item-container-js > td' => 'padding-top: {{TOP}}{{UNIT}}',
					'{{WRAPPER}} tr.item-container-js td' => 'padding-bottom: {{BOTTOM}}{{UNIT}}',
					'{{WRAPPER}} tr.item-container-js td:first-of-type' => 'padding-left: {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} tr.item-container-js td:last-of-type' => 'padding-right: {{RIGHT}}{{UNIT}}',

				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js:first-of-type td' => 'border-top-style: {{SIZE}}',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td' => 'border-bottom-style: {{SIZE}}',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:first-of-type' => 'border-left-style: {{SIZE}}',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:last-of-type' => 'border-right-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_border_width',
			array(
				'label'      => __( 'Border Width' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '1',
					'left'   => '0',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js:first-of-type td' => 'border-top-width: {{TOP}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td' => 'border-bottom-width: {{BOTTOM}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:first-of-type' => 'border-left-width: {{LEFT}}{{UNIT}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:last-of-type' => 'border-right-width: {{RIGHT}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_product_rows_border_color',
			array(
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js:first-of-type td' => 'border-top-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td' => 'border-bottom-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:first-of-type' => 'border-left-color: {{VALUE}} !important',
					'{{WRAPPER}} .prodigy-cart__table .cart-body-js tr.item-container-js td:last-of-type' => 'border-right-color: {{VALUE}} !important',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_product_image',
			array(
				'label' => __( 'Product Image' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_product_image_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
				'label'      => __( 'Border Width' ),
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
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-cart__placeholder a' => 'border-color: {{VALUE}} !important',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_table_product_title',
			array(
				'label' => __( 'Product Title' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_title_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Link Color' ),
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
				'label'      => __( 'Link Color Hover' ),
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
				'label'          => __( 'Bottom Margin' ),
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
				'label' => __( 'SKU' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_sku_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'          => __( 'Bottom Margin' ),
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
				'label' => __( 'Attribute Name' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_attribute_name_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'      => __( 'Padding' ),
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
				'label' => __( 'Attribute Value' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_product_attribute_value_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'      => __( 'Padding' ),
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
			'pg_style_cart_subscription_label',
			array(
				'label' => __( 'Subscription Label' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_label_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'     => __( 'Border Type' ),
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
				'label'      => __( 'Border Width' ),
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
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_state_background_color_normal',
			array(
				'label'     => __( 'Background Color' ),
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
				'label'      => __( 'Border Color' ),
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
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_label_state_background_color_hover',
			array(
				'label'     => __( 'Background Color' ),
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
				'label'      => __( 'Border Color' ),
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
				'label'      => __( 'Border Radius' ),
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
				'label'      => __( 'Padding' ),
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
				'label'          => __( 'Bottom Margin' ),
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
				'label' => __( 'Subscription Conditions' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_conditions_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'          => __( 'Bottom Margin' ),
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
				'label'          => __( 'Right Margin' ),
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
				'label' => __( 'Subscription Conditions Value' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subscription_conditions_value_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label' => __( 'Subscription Tooltip' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_subscription_tooltip_icon_size',
			array(
				'label'      => __( 'Icon Font Size' ),
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
				'label'     => __( 'Icon Color' ),
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
				'label'     => __( 'Icon Color Hover' ),
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
				'label'     => __( 'Transition Duration' ),
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
				'label'          => esc_html( 'Tooltip Typography' ),
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
				'label'      => __( 'Tooltip Text Color' ),
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
				'label'     => __( 'Border Type' ),
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
				'label'      => __( 'Border Width' ),
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
				'label'      => __( 'Border Color' ),
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
				'label'     => __( 'Tooltip Background Color' ),
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
				'label'      => __( 'Border Radius' ),
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
				'label'      => __( 'Padding' ),
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
				'label' => __( 'Remove Link' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_table_product_remove_link_typography',
				'label'          => esc_html( 'Typography' ),
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
				'selector'       => '{{WRAPPER}} a.prodigy-cart__remove.remove-item-js',
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_table_remove_link_tabs' );
		$this->start_controls_tab(
			'pg_style_cart_table_remove_link_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'pg_style_cart_table_remove_link_text_color_normal',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#000',
				'selectors'  => array(
					'{{WRAPPER}} a.prodigy-cart__remove.remove-item-js' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_table_remove_link_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'pg_style_cart_table_remove_link_text_color_hover',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#3558BC',
				'selectors'  => array(
					'{{WRAPPER}} a.prodigy-cart__remove.remove-item-js:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pg_style_cart_table_product_remove_link_bottom_margin',
			array(
				'label'          => __( 'Bottom Margin' ),
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
					'{{WRAPPER}} a.prodigy-cart__remove.remove-item-js' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_price',
			array(
				'label' => __( 'Price' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_price_typography',
				'label'          => esc_html( 'Typography' ),
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
				'selector'       => '{{WRAPPER}} .prodigy-cart__total-price:not(.total-price-js)',
			)
		);

		$this->add_control(
			'pg_style_cart_price_text_color',
			array(
				'label'      => __( 'Text Color' ),
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
				'label'      => __( 'Padding' ),
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
					'{{WRAPPER}} .prodigy-cart__total-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_quantity',
			array(
				'label' => __( 'Quantity' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count',
			array(
				'label'     => __( 'Count' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_quantity_count_typography',
				'label'          => esc_html( 'Typography' ),
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
				'label'      => __( 'Height' ),
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
				'label'      => __( 'Width' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
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
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#666',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_background_color',
			array(
				'label'     => __( 'Background Color' ),
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
				'label'     => __( 'Border Type' ),
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
				'label'      => __( 'Border Width' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'bottom' => '1',
					'top'    => '1',
					'right'  => '0',
					'left'   => '0',
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
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#eaeaea',
				'selectors'  => array(
					'{{WRAPPER}} input.prodigy-counter__total' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_quantity_count_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
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

		$this->add_control(
			'pg_style_cart_counter_button',
			array(
				'label'     => __( 'Counter Button' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_counter_button_typography',
				'label'          => esc_html( 'Typography' ),
				'fields_options' => array(
					'typography'     => array( 'default' => 'yes' ),
					'font_size'      => array(
						'default'        => array(
							'unit' => 'px',
							'size' => 18,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
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
				'selector'       => '{{WRAPPER}} .prodigy-main-button--counter:before',
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .prodigy-main-button--counter' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'{{WRAPPER}} .prodigy-main-button--counter' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_height',
			array(
				'label'      => __( 'Height' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_width',
			array(
				'label'      => __( 'Width' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'size' => 34,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_counter_button_box_tab' );
		$this->start_controls_tab(
			'pg_style_cart_counter_button_box_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_text_color_normal',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_background_color_normal',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#bfc2cc',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button--counter' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_border_color_normal',
			array(
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_quantity_box_tab_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_text_color_hover',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter:hover:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_background_color_hover',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .prodigy-main-button--counter:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_counter_button_border_color_hover',
			array(
				'label'      => __( 'Border Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors'  => array(
					'{{WRAPPER}} .prodigy-main-button--counter:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_counter_button_border_color_button_transition',
			array(
				'label'     => esc_html__( 'Transition Duration', 'elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.2,
				),
				'range'     => array(
					'px' => array(
						'max'  => 2,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}  .prodigy-main-button--counter:hover' => 'transition: all {{SIZE}}s',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_total',
			array(
				'label' => __( 'Total' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_total_typography',
				'label'          => esc_html( 'Typography' ),
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
				'selector'       => '{{WRAPPER}} .total-price-js',
			)
		);

		$this->add_control(
			'pg_style_cart_total_text_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#4b4f58',
				'selectors'  => array(
					'{{WRAPPER}} .total-price-js' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_total_padding',
			array(
				'label'      => __( 'Padding' ),
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
					'{{WRAPPER}} .total-price-js' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pg_style_cart_subtotal',
			array(
				'label' => 'Subtotal',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_subtotal_text_typography',
				'label'          => esc_html( 'Text Typography' ),
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
				'label'      => __( 'Text Color' ),
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
				'label'          => esc_html( 'Value Typography' ),
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

		$this->add_control(
			'pg_style_cart_subtotal_value_color',
			array(
				'label'      => __( 'Value Color' ),
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
				'label'     => __( 'Divider Type' ),
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
			'pg_style_cart_subtotal_divider_width',
			array(
				'label'      => __( 'Divider Width' ),
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
			'pg_style_cart_subtotal_divider_color',
			array(
				'label'      => __( 'Divider Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#d9dbe1',
				'selectors'  => array(
					'{{WRAPPER}} div.prodigy-divider-block' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_subtotal_border_padding',
			array(
				'label'      => __( 'Padding' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '8',
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
			'pg_style_cart_widget_buttons',
			array(
				'label' => __( 'Buttons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout',
			array(
				'label'     => __( 'Proceed To Checkout Button' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_widget_buttons_proceed_to_checkout_typography',
				'label'          => esc_html( 'Typography' ),
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
				'selector'       => '{{WRAPPER}} .checkout-button-js',
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .checkout-button-js' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'{{WRAPPER}} .checkout-button-js' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .checkout-button-js' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_padding',
			array(
				'label'      => __( 'Text Padding' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .checkout-button-js' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_widget_buttons_proceed_to_checkout_tab' );
		$this->start_controls_tab(
			'pg_style_cart_widget_buttons_proceed_to_checkout_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_text_color_normal',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .checkout-button-js' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_normal_background_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .checkout-button-js' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_normal_border_color',
			array(
				'label'     => __( 'Border Color' ),
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
					'{{WRAPPER}} .checkout-button-js' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_text_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .checkout-button-js:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_background_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffcb27',
				'selectors' => array(
					'{{WRAPPER}} .checkout-button-js:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_hover_border_color',
			array(
				'label'     => __( 'Border Color' ),
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
					'{{WRAPPER}} .checkout-button-js:hover' => 'border-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_widget_buttons_proceed_to_checkout_tooltip_transition',
			array(
				'label'     => __( 'Transition Duration' ),
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
					'{{WRAPPER}} .checkout-button-js:hover' => 'transition-duration: {{SIZE}}s',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button',
			array(
				'label'     => __( 'Continue Shopping Button' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'pg_style_cart_widget_continue_shopping_button_typography',
				'label'          => esc_html( 'Typography' ),
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
				'selector'       => '{{WRAPPER}} .continue-cart-js',
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_type',
			array(
				'label'     => __( 'Border Type' ),
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
					'{{WRAPPER}} .continue-cart-js' => 'border-style: {{SIZE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_width',
			array(
				'label'      => __( 'Border Width' ),
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
					'{{WRAPPER}} .continue-cart-js' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_border_radius',
			array(
				'label'      => __( 'Border Radius' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .continue-cart-js' => 'border-radius: {{SIZE}}{{UNIT}}',
				),

			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_padding',
			array(
				'label'      => __( 'Text Padding' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '16',
					'bottom'   => '0',
					'left'     => '16',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .continue-cart-js' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'pg_style_cart_widget_continue_shopping_button_tab' );
		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_button_tab_normal',
			array(
				'label' => __( 'Normal' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_text_color_normal',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#2a3658',
				'selectors'  => array(
					'{{WRAPPER}} .continue-cart-js,.icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_normal_background_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .continue-cart-js' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_normal_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
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
					'{{WRAPPER}} .continue-cart-js' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pg_style_cart_widget_continue_shopping_button_hover',
			array(
				'label' => __( 'Hover' ),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_text_color',
			array(
				'label'      => __( 'Text Color' ),
				'type'       => Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'    => '#ffffff',
				'selectors'  => array(
					'{{WRAPPER}} .continue-cart-js:hover,.continue-cart-js:hover .icon-arrow-left:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_background_color',
			array(
				'label'     => __( 'Background Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
				'selectors' => array(
					'{{WRAPPER}} .continue-cart-js:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_hover_border_color',
			array(
				'label'     => __( 'Border Color' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2a3658',
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
					'{{WRAPPER}} .continue-cart-js:hover' => 'border-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'pg_style_cart_widget_continue_shopping_button_transition',
			array(
				'label'     => __( 'Transition Duration' ),
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
					'{{WRAPPER}} .continue-cart-js:hover' => 'transition-duration: {{SIZE}}s',
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
		update_option( 'elementor_prodigy_cart_page', $settings );

		echo do_shortcode( '[prodigy_cart]' );
	}
}
