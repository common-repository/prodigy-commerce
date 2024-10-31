<?php

namespace Prodigy\Includes\Support\Customizer;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class Prodigy_Customizer {

	/**
	 * Number of columns for products.
	 *
	 * @var int
	 */
	const PRODIGY_PRODUCTS_NUMBER_COLUMNS = 3;

	/**
	 * Show sidebar on shop page
	 *
	 * @var int
	 */
	const PRODIGY_SHOW_SIDEBAR = '1';

	/**
	 * Set button filter instead sidebar
	 *
	 * @var int
	 */
	const PRODIGY_SHOW_FILTER_BUTTON = '2';

	/**
	 * Array of menu locations.
	 *
	 * @var int[]
	 */
	public $menu_locations = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register' ) );
		add_action( 'customize_controls_print_styles', array( $this, 'add_styles' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );

		$this->menu_locations = $this->set_cart_widget_locations();
	}

	/**
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register( $wp_customize ) {
		$wp_customize->add_panel(
			'prodigy_panel',
			array(
				'title'    => 'Prodigy',
				'priority' => 160,
			)
		);

		/**
		 * General section
		 */
		$wp_customize->add_section(
			'prodigy_general_options',
			array(
				'title'    => __( 'General' ),
				'priority' => 160,
				'panel'    => 'prodigy_panel',
			)
		);

		$wp_customize->add_setting(
			'prodigy_general_options[prodigy_width_container]',
			array(
				'type'    => 'option',
				'default' => 1200,
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customizer_Control_Slider(
				$wp_customize,
				'prodigy_width_container',
				array(
					'type'        => 'prodigy-range-value',
					'section'     => 'prodigy_general_options',
					'settings'    => 'prodigy_general_options[prodigy_width_container]',
					'label'       => __( 'Container Width' ),
					'input_attrs' => array(
						'min'  => 300,
						'max'  => 2000,
						'step' => 1,
					),
					'priority'    => 1,
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_thumbnail_cropping',
			array(
				'default' => 'default',
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_thumbnail_cropping_custom_height',
			array(
				'default' => '4',
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_thumbnail_cropping_custom_width',
			array(
				'default' => '3',
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customizer_Control_Ratio(
				$wp_customize,
				'prodigy_thumbnail_cropping',
				array(
					'section'  => 'prodigy_general_options',
					'settings' => array(
						'ratio'         => 'prodigy_thumbnail_cropping',
						'custom_height' => 'prodigy_thumbnail_cropping_custom_height',
						'custom_width'  => 'prodigy_thumbnail_cropping_custom_width',
					),
					'label'    => __( 'Product image aspect ratio' ),
					'choices'  => array(
						'default' => array(
							'label'       => __( '3:4' ),
							'description' => __( 'Images will be displayed at a 3:4 aspect ratio' ),
						),
						'custom'  => array(
							'label'       => __( 'Custom' ),
							'description' => __( 'Images will be displayed at a custom aspect ratio' ),
						),
					),
				)
			)
		);

		if ( ! empty( $this->menu_locations ) ) {

			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_cart_widget_locations]',
				array(
					'default' => '',
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customizer_Control_Multiple_Select(
					$wp_customize,
					'prodigy_general_options[prodigy_cart_widget_locations]',
					array(
						'settings' => 'prodigy_general_options[prodigy_cart_widget_locations]',
						'label'    => 'Select multiple locations Cart widget',
						'section'  => 'prodigy_general_options',
						'type'     => 'multiple-select',
						'choices'  => $this->menu_locations,
					)
				)
			);


			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_enable_cart_widget]',
				array(
					'default' => false,
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customize_Control(
					$wp_customize,
					'prodigy_enable_cart_widget',
					array(
						'type'        => 'checkbox',
						'label'       => __( 'Show Cart widget as last menu item' ),
						'encodeLabel' => false,
						'section'     => 'prodigy_general_options',
						'settings'    => 'prodigy_general_options[prodigy_enable_cart_widget]',
					)
				)
			);


			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_my_account_locations]',
				array(
					'default' => '',
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customizer_Control_Multiple_Select(
					$wp_customize,
					'prodigy_general_options[prodigy_my_account_locations]',
					array(
						'settings' => 'prodigy_general_options[prodigy_my_account_locations]',
						'label'    => 'Select multiple locations My account widget',
						'section'  => 'prodigy_general_options',
						'type'     => 'multiple-select',
						'choices'  => $this->menu_locations,
					)
				)
			);


			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_enable_my_account]',
				array(
					'default' => false,
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customize_Control(
					$wp_customize,
					'prodigy_enable_my_account',
					array(
						'type'        => 'checkbox',
						'label'       => __( 'Show My Account widget menu item' ),
						'encodeLabel' => false,
						'section'     => 'prodigy_general_options',
						'settings'    => 'prodigy_general_options[prodigy_enable_my_account]',
					)
				)
			);





			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_search_locations]',
				array(
					'default' => '',
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customizer_Control_Multiple_Select(
					$wp_customize,
					'prodigy_general_options[prodigy_search_locations]',
					array(
						'settings' => 'prodigy_general_options[prodigy_search_locations]',
						'label'    => 'Select multiple locations Search widget',
						'section'  => 'prodigy_general_options',
						'type'     => 'multiple-select',
						'choices'  => $this->menu_locations,
					)
				)
			);


			$wp_customize->add_setting(
				'prodigy_general_options[prodigy_enable_search]',
				array(
					'default' => false,
					'type'    => 'option',
				)
			);

			$wp_customize->add_control(
				new Prodigy_Customize_Control(
					$wp_customize,
					'prodigy_enable_search',
					array(
						'type'        => 'checkbox',
						'label'       => __( 'Show Search widget as last menu item' ),
						'encodeLabel' => false,
						'section'     => 'prodigy_general_options',
						'settings'    => 'prodigy_general_options[prodigy_enable_search]',
					)
				)
			);


		}

		/**
		 * Product section
		 */
		$wp_customize->add_section(
			'prodigy_product_options',
			array(
				'title' => 'Product',
				'panel' => 'prodigy_panel',
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_breadcrumbs]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_control_bulk]',
			array(
				'default' => false,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_description]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_sku]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_control_bulk',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Allow Multiple Quantity' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_control_bulk]',
				)
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_control_breadcrumbs',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show breadcrumbs' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_breadcrumbs]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_description]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_control_description',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show description' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_description]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_sku]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_control_sku',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show sku' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_sku]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_tags]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_control_tags',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show tags' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_tags]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_categories]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_product_categories',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show categories' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_categories]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_product_settings[prodigy_product_view_cart]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_active_filter_name',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show view cart button' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_product_options',
					'settings'    => 'prodigy_product_settings[prodigy_product_view_cart]',
				)
			)
		);

		/**
		 * Shop section
		 */
		$wp_customize->add_section(
			'prodigy_shop_options',
			array(
				'title' => 'Shop',
				'panel' => 'prodigy_panel',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_sidebar]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_rating]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sale]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_breadcrumbs]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sortable]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_quick_view]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_per_row]',
			array(
				'default' => '3',
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_default_sortable]',
			array(
				'default' => '-created_at',
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_products_per_row',
				array(
					'label'    => __( 'Columns' ),
					'priority' => 10,
					'section'  => 'prodigy_shop_options',
					'settings' => 'prodigy_shop_settings[prodigy_shop_products_per_row]',
					'type'     => 'select',
					'choices'  => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
					),
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_number_items_per_page]',
			array(
				'default' => 9,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'prodigy_shop_products_number_items_per_page',
			array(
				'label'       => __( 'Number of items per page' ),
				'section'     => 'prodigy_shop_options',
				'settings'    => 'prodigy_shop_settings[prodigy_shop_products_number_items_per_page]',
				'type'        => 'number',
				'priority'    => 10,
				'input_attrs' => array(
					'min'      => 1,
					'max'      => 50,
					'required' => true,
					'oninput'  => 'validity.valid;',
					'onblur'   => 'validity.valid;',
				),
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_default_sortable',
				array(
					'label'    => __( 'Default sorting' ),
					'priority' => 10,
					'section'  => 'prodigy_shop_options',
					'settings' => 'prodigy_shop_settings[prodigy_shop_default_sortable]',
					'type'     => 'select',
					'choices'  => array(
						'-created_at' => __( 'Sort by newness' ),
						'-rating'     => __( 'Sort by average rating' ),
						'price'       => __( 'Sort by price: low to high' ),
						'-price'      => __( 'Sort by price: high to low' ),
					),
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_sidebar_display]',
			array(
				'default' => self::PRODIGY_SHOW_SIDEBAR,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_sidebar',
				array(
					'label'    => __( 'Sidebar Display' ),
					'priority' => 10,
					'section'  => 'prodigy_shop_options',
					'settings' => 'prodigy_shop_settings[prodigy_shop_sidebar_display]',
					'type'     => 'select',
					'choices'  => array(
						__( 'None', 'prodigy' ),
						__( 'Left Column', 'prodigy' ),
						__( 'Button/Modal', 'prodigy' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_products_quick_view',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show page quick view' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_quick_view]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_quick_view]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_rating]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_rating',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show product rating' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_rating]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sale]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_sale',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show product sale icon' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_sale]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_breadcrumbs]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_breadcrumbs',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show breadcrumbs' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_breadcrumbs]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sortable]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_sortable',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show products sortable' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_sortable]',
				)
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_products_quick_view',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show page quick view' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_quick_view]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_quick_view]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_rating]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_rating',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show product rating' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_rating]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sale]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_sale',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show product sale icon' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_sale]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_breadcrumbs]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_breadcrumbs',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show breadcrumbs' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_breadcrumbs]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_products_sortable]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_products_sortable',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show products sortable' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_products_sortable]',
				)
			)
		);

		$wp_customize->add_setting(
			'prodigy_shop_settings[prodigy_shop_search_bar]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			new Prodigy_Customize_Control(
				$wp_customize,
				'prodigy_shop_control_search_bar',
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show search bar' ),
					'encodeLabel' => false,
					'section'     => 'prodigy_shop_options',
					'settings'    => 'prodigy_shop_settings[prodigy_shop_search_bar]',
				)
			)
		);

		/**
		 * Footer sections
		 */
		$wp_customize->add_setting(
			'prodigy_footer_widget_settings[prodigy_footer_checkbox_visa]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_footer_widget_settings[prodigy_footer_checkbox_paypal]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_footer_widget_settings[prodigy_footer_checkbox_mastercard]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
		$wp_customize->add_setting(
			'prodigy_footer_widget_settings[prodigy_footer_checkbox_stripe]',
			array(
				'default' => true,
				'type'    => 'option',
			)
		);
	}

	/**
	 * @return float|string
	 */
	public static function get_images_ratio() {
		$image_ratio_type = get_option( 'prodigy_thumbnail_cropping' ) ?? null;
		$width            = get_option( 'prodigy_thumbnail_cropping_custom_width' );
		$height           = get_option( 'prodigy_thumbnail_cropping_custom_height' );
		$image_ratio      = '';
		if (
			! empty( $image_ratio_type ) && 'custom' === $image_ratio_type &&
			(
				isset( $width, $height ) &&
				is_numeric( $width ) && is_numeric( $height ) &&
				(int) $width > 0 && (int) $height > 0
			)
		) {
			$image_ratio = round( ( $height / $width ) * 100, 3 );
		}

		return $image_ratio;
	}

	/**
	 * Scripts to improve our form.
	 */
	public function add_scripts() {
		?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(document.body).on('change', '.prodigy-ratio-control input[type="radio"]', function () {
                    var $wrapper = $(this).closest('.prodigy-ratio-control'),
                        value = $wrapper.find('input:checked').val();

                    if ('custom' === value) {
                        $wrapper.find('.prodigy-ratio-control-aspect-ratio').slideDown(200);
                    } else {
                        $wrapper.find('.prodigy-ratio-control-aspect-ratio').hide();
                    }

                    return false;
                });

                wp.customize.bind('ready', function () {
                    $('.prodigy-ratio-control').find('input:checked').change();
                    $('.range-slider').find('input').change();
                });

                wp.customize.bind('ready', function () {
                    let show_cart_checkbox = '#customize-control-prodigy_enable_cart_widget input[type="checkbox"]';
                    hide_multiselect($(show_cart_checkbox));
                    $(document.body).on('change', show_cart_checkbox, function () {
                        hide_multiselect($(this));
                        return false;
                    });

                    function hide_multiselect(checkbox) {
                        let multiselect = '#customize-control-prodigy_general_options-prodigy_cart_widget_locations';
                        if (checkbox.is(':checked')) {
                            $(document).find(multiselect).slideDown(200);
                            $first_option = $(document).find(multiselect).find('option').first();
                            $first_option.attr('selected', 'selected');
                            $first_option.trigger('change');
                        } else {
                            $(document).find(multiselect).hide();
                        }
                    }

                    $(document.body).on(
                        'blur',
                        '#_customize-input-prodigy_shop_products_number_items_per_page',
                        function () {
                            if ($(this).val() <= 0) {
                                $(this).val(1);
                            }
                            if ($(this).val() > 50) {
                                $(this).val(50);
                            }
                        }
                    )
                });
            });
        </script>
		<?php
	}

	/**
	 * @return int[]|string[]
	 */
	public function set_cart_widget_locations() {
		$locations     = get_nav_menu_locations();
		$new_locations = array();
		foreach ( $locations as $key => $location ) {
			$new_locations[ $key ] = $key;
		}

		return $new_locations;
	}

	/**
	 * CSS styles to improve our form.
	 */
	public function add_styles() {
		?>
        <style type="text/css">
            .prodigy-ratio-control {
                margin: 0 40px 1em 0;
                padding: 0;
                display: inline-block;
                vertical-align: top;
            }

            .prodigy-ratio-control input[type=radio] {
                margin-top: 1px;
            }

            .prodigy-ratio-control span.prodigy-ratio-control-aspect-ratio {
                margin-top: .5em;
                display: block;
            }

            .prodigy-ratio-control span.prodigy-ratio-control-aspect-ratio input {
                width: auto;
                display: inline-block;
            }
        </style>
		<?php
	}
}
