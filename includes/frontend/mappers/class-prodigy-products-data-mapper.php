<?php

namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Models\Prodigy_Products;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

defined( 'ABSPATH' ) || exit;

/**
 * Prodigy products data mapper
 *
 * @version    2.9.1
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Products_Data_Mapper extends Prodigy_Main_Data_Mapper {
	const DESCENDING_SORT = 'DESC';
	const SLIDER          = 'slider';

	public $placeholder;

	public function __construct() {
		parent::__construct();
		$this->placeholder = plugin_dir_url( PRODIGY_PLUGIN_PATH . 'web/admin/images/placeholder.png' ) . 'placeholder.png';
	}


	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$page                   = isset( $_GET['pg'] ) ? sanitize_key( wp_unslash( $_GET['pg'] ) ) : 1;
		$options['pg']          = $page;
		$query                  = $this->get_products_query_builder( $options );
		$products               = Prodigy_Request_Maker::get_instance()->do_products_request( $query );
		$data                   = $this->format_data( $products['data'] ?? array() );
		$options['image_ratio'] = Prodigy_Customizer::get_images_ratio();

		return array(
			'display'         => $options['display'],
			'products'        => $data,
			'placeholder_url' => $this->placeholder,
			'columns'         => $options['columns'],
			'attr'            => $options,
		);
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function get_products_query_builder( array $params ): string {
		$attributes = array();

		if ( isset( $params['idWidget'] ) ) {
			$attributes['widget_id'] = $params['idWidget'];
		}

		if ( ! empty( $params['product_ids'] ) ) {
			$local_product_ids = array_filter( array_map( 'trim', explode( ',', $params['product_ids'] ) ) );
			foreach ( $local_product_ids as $key => $product_id ) {
				$attributes['product_ids'][ $key ] = $product_id;
			}
		}

		if ( ! empty( $params['category_ids'] ) ) {
			$local_category_ids = array_filter( array_map( 'trim', explode( ',', $params['category_ids'] ) ) );
			foreach ( $local_category_ids as $key => $category_id ) {
				$attributes['category_ids'][ $key ] = $category_id;
			}
		}

		if ( ! empty( $params['category_names'] ) ) {
			$local_category_ids = array_filter( array_map( 'trim', explode( ',', $params['category_names'] ) ) );

			$local_category_ids = Prodigy_Products::prodigy_get_products_id_by_title( $params['product_names'] );
			foreach ( $local_category_ids as $key => $category_id ) {
				$attributes['category_names'][ $key ] = $category_id;
			}
		}

		if ( ! empty( $params['product_names'] ) ) {
			$product_ids_by_names = Prodigy_Products::prodigy_get_products_id_by_title( $params['product_names'] );

			if ( ! empty( $product_ids_by_names ) ) {
				foreach ( $product_ids_by_names as $key => $product_id ) {
					$remote_id                         = get_post_meta( (int) $product_id, 'prodigy_remote_product_id', true );
					$attributes['product_ids'][ $key ] = $remote_id;
				}
			}
		}

		if ( ! empty( $params['tags'] ) ) {
			$tags = array_filter( array_map( 'trim', explode( ',', $params['tags'] ) ) );
			foreach ( $tags as $key => $tag_id ) {
				$attributes['tags'][ $key ] = $tag_id;
			}
		}

		if ( isset( $params['orderby'] ) ) {
			$sort = self::mapping_sort_params( $params['orderby'] );

			if ( isset( $params['order'] ) && strtolower( $params['order'] ) === strtolower( self::DESCENDING_SORT ) ) {
				$sort = '-' . $sort;
			}

			$attributes['sort'] = $sort;
		}

		if ( isset( $params['on_sale'] ) ) {
			$attributes['on_sale'] = $params['on_sale'];
		}

		if ( isset( $params['limit'] ) ) {
			$attributes['page']['size']   = (int) $params['limit'] > 0 ? (int) $params['limit'] : '';
			$attributes['page']['number'] = $params['pg'] ?? 1;
		}

		if ( isset( $params['display'] ) && $params['display'] === 'grid' ) {
			$attributes['page']['size'] = $params['number_items_per_page'];
		}

		$attributes['sync'] = true;

		$query_string = http_build_query( $attributes );

		return urldecode( preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D/', '[]', $query_string ) );
	}

	/**
	 * @param array $products
	 *
	 * @return array
	 */
	public function format_data( array $products ): array {
		$products_data = array();

		if ( ! empty( $products ) ) {
			foreach ( $products as $key => $product ) {
				$local_product                                  = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $product['id'] );
				$products_data[ $key ]['id']                    = (int) $product['id'];
				$products_data[ $key ]['name']                  = $product['attributes']['name'];
				$products_data[ $key ]['regular_price']         = $product['attributes']['price'];
				$products_data[ $key ]['sale_price']            = $product['attributes']['sale-price'];
				$products_data[ $key ]['versions-image-url']    = $product['attributes']['versions-image-url'] ?? array();
				$products_data[ $key ]['rating']                = $product['attributes']['rating'];
				$products_data[ $key ]['tiered-price']          = $product['attributes']['tiered-price'];
				$products_data[ $key ]['price-range']           = $product['attributes']['price-range'] ?? array();
				$products_data[ $key ]['logo-location']         = $product['attributes']['logo-location'] ?? array();
				$products_data[ $key ]['logo']                  = $product['attributes']['logo'] ?? array();
				$products_data[ $key ]['image-cropping-params'] = $product['attributes']['image-cropping-params'] ?? array();
				if ( isset( $local_product->post_id ) ) {
					$products_data[ $key ]['local_url'] = esc_url( get_permalink( $local_product->post_id ) );
				}
				$products_data[ $key ]['category'] = $product['attributes']['categories-list'];
			}
		} else {
			$image         = 'https://prodigycommerce-public-files.s3.us-east-2.amazonaws.com/wordpress/default-category.jpg';
			$products_data = array(
				'id'            => 0,
				'name'          => 'Title product',
				'regular_price' => wp_rand( 1, 10 ),
				'sale_price'    => wp_rand( 1, 10 ),
				'rating'        => wp_rand( 1, 5 ),
				'img_url'       => array(
					'catalog'           => $image,
					'catalog_retina'    => $image,
					'thumbnails'        => $image,
					'thumbnails_retina' => $image,
					'medium'            => $image,
					'medium_retina'     => $image,
					'large'             => $image,
					'large_retina'      => $image,
					'cropped'           => $image,
				),
				'category'      => 'Category',
			);

			$products_data = array_fill( 0, 5, $products_data );
		}

		return $products_data;
	}

	/**
	 * @param int   $current_page
	 * @param int   $item_per_page
	 * @param array $products
	 *
	 * @return array
	 */
	public function get_pagination( int $current_page, int $item_per_page, array $products ): array {
		$page                 = isset( $_GET['pg'] ) ? sanitize_key( wp_unslash( $_GET['pg'] ) ) : 1;
		$total_count          = $products['data'][0]['attributes']['products-count'] ?? 0;
		$base_url             = remove_query_arg( 'pg', get_permalink() );
		$params['pagination'] = array(
			'pages'       => ! empty( $products['data'] ) ? Prodigy_Pagination::calculate_count_pages( (int) $total_count, $item_per_page ) : 1,
			'url'         => $base_url,
			'page'        => $current_page,
			'page_number' => $page,
		);

		return $params;
	}
}
