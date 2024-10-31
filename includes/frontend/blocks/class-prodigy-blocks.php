<?php

namespace Prodigy\Includes\Frontend\Blocks;

use Prodigy\Includes\Frontend\Prodigy_Public;
use Prodigy\Includes\Prodigy;

/**
 * This class registers the Gutenberg blocks used by Prodigy.
 */
class Prodigy_Blocks {

	/**
	 * Prodigy_Blocks constructor.
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		add_action( 'init', array( $this, 'register_blocks' ), 20 );
		add_action( 'rest_api_init', array( $this, 'add_prodigy_meta_to_api' ) );
		add_filter( 'block_categories_all', array( $this, 'register_block_categories' ) );
	}

	/**
	 * Enqueue block editor JS.
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script(
			'prodigy-blocks-js',
			Prodigy::plugin_url() . '/assets/admin/blocks/js/blocks.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-server-side-render' ),
			PRODIGY_VERSION,
			true
		);
		wp_enqueue_style(
			'prodigy-blocks-editor-styles',
			Prodigy::plugin_url() . '/assets/admin/blocks/css/editor-styles.css',
			array(),
			PRODIGY_VERSION
		);
		wp_enqueue_style(
			'styles',
			Prodigy::plugin_url() . '/assets/templates/css/styles.css',
			array(),
			PRODIGY_VERSION,
		);
	}

	/**
	 * Register the Prodigy blocks.
	 */
	public function register_blocks() {
		register_block_type(
			'prodigy/products',
			array(
				'render_callback' => array( $this, 'render_products_block' ),
				'attributes'      => array(
					'idWidget'    => array(
						'type'    => 'string',
						'default' => uniqid(),
					),
					'categoryIds' => array(
						'type'    => 'string',
						'default' => '',
					),
					'columns'     => array(
						'type'    => 'integer',
						'default' => 4,
					),
					'limit'       => array(
						'type'    => 'integer',
						'default' => 9,
					),
					'orderby'     => array(
						'type'    => 'string',
						'default' => 'date',
					),
					'on_sale'     => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'sale'        => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'category'    => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'rating'      => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'order'       => array(
						'type'    => 'string',
						'default' => 'asc',
					),
					'display'     => array(
						'type'    => 'string',
						'default' => 'slider',
					),
				),
			)
		);

		register_block_type(
			'prodigy/categories',
			array(
				'render_callback' => array( $this, 'render_categories_block' ),
				'attributes'      => array(
					'idWidget'           => array(
						'type'    => 'string',
						'default' => uniqid(),
					),
					'parentIds'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'columns'            => array(
						'type'    => 'integer',
						'default' => 4,
					),
					'orderby'            => array(
						'type'    => 'string',
						'default' => 'date',
					),
					'show_product_count' => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'order'              => array(
						'type'    => 'string',
						'default' => 'asc',
					),
					'display'            => array(
						'type'    => 'string',
						'default' => 'slider',
					),
				),
			)
		);

		register_block_type(
			'prodigy/category',
			array(
				'render_callback' => array( $this, 'render_category_block' ),
				'attributes'      => array(
					'idWidget'           => array(
						'type'    => 'string',
						'default' => uniqid(),
					),
					'category_id'        => array(
						'type'    => 'string',
						'default' => '',
					),
					'show_product_count' => array(
						'type'    => 'boolean',
						'default' => true,
					),
				),
			)
		);
	}

	/**
	 * Register the metadata for the REST API.
	 */
	public function add_prodigy_meta_to_api() {
		register_rest_field(
            'prodigy-product-category',
            'prodigyHostedCategoryRelation',
            array(
				'get_callback'    => function ( $term ) {
					return get_term_meta( $term['id'], 'prodigy_hosted_category_relation', true );
				},
				'update_callback' => null,
				'schema'          => null,
            )
        );
	}

	/**
	 * Register the Prodigy block category
	 *
	 * @param array $categories The existing block categories.
	 *
	 * @return array The updated block categories.
	 */
	public function register_block_categories( array $categories ): array {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'prodigy',
					'title' => 'Prodigy',
					'icon'  => 'wordpress',
				),
			)
		);
	}

	/**
	 * Render the products block.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string The rendered block markup.
	 */
	public function render_products_block( array $attributes ): string {
		$params = array(
			'idWidget'                => $attributes['idWidget'],
			'category_ids'            => $attributes['categoryIds'],
			'columns'                 => $attributes['columns'],
			'limit'                   => $attributes['limit'],
			'orderby'                 => $attributes['orderby'],
			'on_sale'                 => $attributes['on_sale'],
			'sale'                    => $attributes['sale'] ? 'yes' : 'no',
			'category'                => $attributes['category'] ? 'yes' : 'no',
			'rating'                  => $attributes['rating'] ? 'yes' : 'no',
			'order'                   => $attributes['order'],
			'display'                 => $attributes['display'],
			'slider_hide_arrows'      => false,
			'products_sale_classname' => 'prodigy-product-list__item-label',
		);

		ob_start();

		do_action( 'prodigy_get_template_products', $params );

		return ob_get_clean();
	}

	/**
	 * Render the categories block.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string The rendered block markup.
	 */
	public function render_categories_block( array $attributes ): string {
		$params = array(
			'idWidget'           => $attributes['idWidget'],
			'parent_ids'         => $attributes['parentIds'],
			'columns'            => $attributes['columns'],
			'limit'              => '-1',
			'rows'               => '-1',
			'orderby'            => $attributes['orderby'],
			'show_product_count' => $attributes['show_product_count'],
			'order'              => $attributes['order'],
			'display'            => $attributes['display'],
			'slider_hide_arrows' => false,
			'title_classname'    => 'prodigy-categories__card-title',
		);

		ob_start();

		do_action( 'prodigy_get_template_categories', $params );

		return ob_get_clean();
	}

	/**
	 * Render the category block.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string The rendered block markup.
	 */
	public function render_category_block( array $attributes ): string {
		$params = array(
			'idWidget'           => $attributes['idWidget'],
			'category_id'        => $attributes['category_id'],
			'show_product_count' => $attributes['show_product_count'],
			'opacity'            => '1',
			'image_position'     => 'center',
			'height'             => '325px',
			'link_classname'     => 'prodigy-category-link',
		);

		ob_start();

		do_action( 'prodigy_get_template_category_link', $params );

		return ob_get_clean();
	}
}
