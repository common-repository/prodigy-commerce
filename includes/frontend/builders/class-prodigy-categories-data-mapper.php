<?php
/**
 * Prodigy categories data mapper
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Prodigy_Product_Attributes;

defined( 'ABSPATH' ) || exit;

class Prodigy_Categories_Data_Mapper extends Prodigy_Main_Data_Mapper {
	const ASCENDING_SORT      = 'ASC';
	const DESCENDING_SORT     = 'DESC';
	const COUNT_DEFAULT_CATEGORIES = 4;

	const COUNT_COLUMNS_CATEGORY   = 5;

	public $arrows_mapper = array(
		'on'  => 'yes',
		'off' => 'no',
		''    => 'no',
		'yes' => 'yes',
	);

	public $show_product_count_mapper = array(
		'no'   => false,
		'yes'  => true,
		'on'  => true,
		'off' => false,
	);


	/**
	 * @param $shortcode_params
	 *
	 * @return mixed
	 */
	public function get_categories( $shortcode_params ) {
		$shortcode_params['pg'] = sanitize_key( wp_unslash( $_GET['pg'] ?? '' ) );
		$query                  = $this->get_categories_query_builder( $shortcode_params );
		$categories             = $this->cache->get_categories_shortcode( $query );
		if ( ! empty( $categories ) ) {
			$object = $categories;
		} else {
			$category_url        = prodigy_is_frontend() ? Prodigy_Api_Client::CATEGORY_URL : Prodigy_Api_Client::CATEGORY_ADMIN_URL;
			$api_url           = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $category_url . '?' . $query;
			$category_response = $this->api_client->get_remote_content( $api_url );
			$body   = wp_remote_retrieve_body( $category_response );
			$object = json_decode( $body, true );
			$this->cache->set_categories_shortcode( $object ?? array(), $query );
		}

		return $object;
	}

	/**
	 * @param array $categories
	 * @param array $settings
	 *
	 * @return array
	 */
	public function format_data( array $categories, array $settings ) :array {

		if ( ! empty( $categories ) ) {
			$categories_data = array();

			if ( ! empty( $categories ) ) {
				foreach ( $categories as $key => $category ) {
					$categories_data[ $key ]['id']      = $category['id'];
					$categories_data[ $key ]['name']    = $category['attributes']['name'];
					$categories_data[ $key ]['count']   = $category['attributes']['products-count'];
					$categories_data[ $key ]['img_url'] = $category['attributes']['image-url'];
				}
			}
		}

		return $categories_data ?? array();
	}

	/**
	 * @param int $columns
	 * @param int $rows
	 *
	 * @return float|int
	 */
	public function get_items_per_page( int $columns, int $rows ) :int {
		return $columns * $rows;
	}

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ) :array {
		$categories        = $this->get_categories( $options );
		if ( isset( $categories['data'] ) ) {
			$categories = $this->format_data( $categories['data'], $options );
		} else {
			$categories = $this->getFakeData( self::COUNT_COLUMNS_CATEGORY );
		}

		return array(
			'columns'       => $options['columns'],
			'categories'    => $this->categories_preparation( $categories ),
			'show_count'    => $options['show_product_count'],
			'attr'          => $options,
			'display'       => $options['display']
		);
	}

	/**
	 * @param array $categories
	 *
	 * @return array
	 */
	private function categories_preparation( array $categories ) :array {
		foreach ($categories as $key=>$category) {
			$category_term = Prodigy_Product_Attributes::get_term_id_by_meta_key(
				Prodigy::PRODIGY_HOSTED_CATEGORY_RELATION,
				(int) $category['id']
			);
			$categories[$key]['local_url'] = get_category_link( $category_term->term_id ?? '' );
		}

		return $categories;
	}

	/**
	 * @param int $countCategory
	 * @return array
	 */
	public function getFakeData( int $countCategory = 4 ): array {
		$categoriesData = array(
			'id'      => 0,
			'name'    => 'Title category',
			'count'   => rand( 1, 10 ),
			'img_url' => 'https://prodigycommerce-public-files.s3.us-east-2.amazonaws.com/wordpress/default-category.jpg',
		);

		return array_fill( 0, $countCategory, $categoriesData );
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public function get_categories_query_builder( array $params ) :string {
		global $wpdb;
		$attributes = array();
		if ( ! empty( $params['parent_ids'] ) ) {
			$local_category_ids = array_filter( array_map( 'trim', explode( ',', $params['parent_ids'] ) ) );
			foreach ( $local_category_ids as $key => $category_id ) {
				$attributes['parent_ids'][ $key ] = $category_id;
			}
		}

		if ( ! empty( $params['category_ids'] ) ) {
			$local_category_ids = array_filter( array_map( 'trim', explode( ',', $params['category_ids'] ) ) );
			foreach ( $local_category_ids as $key => $category_id ) {
				$attributes['ids'][ $key ] = $category_id;
			}
			$this->total_count = count( $attributes['ids'] );
		}

		if ( ! empty( $params['category_slugs'] ) ) {
			$slugs = array_filter( array_map( 'trim', explode( ',', $params['category_slugs'] ) ) );
			if ( is_array( $slugs ) && ! empty( $slugs ) ) {
				foreach ( $slugs as $key => $category_slug ) {
					$category = Prodigy_Taxonomies::get_taxonomy_by_different_slugs( Prodigy::get_prodigy_category_type(), $category_slug );
					if ( isset( $category->term_id ) ) {
						$remote_id                 = get_term_meta( (int) $category->term_id, 'prodigy_hosted_category_relation', true );
						$attributes['ids'][ $key ] = $remote_id;
					}
				}
			}
			$this->total_count = isset( $attributes['ids'] ) ? count( $attributes['ids'] ) : 0;
		}

		if ( isset( $params['orderby'] ) ) {
			$sort = self::mapping_sort_params( $params['orderby'] );

			if ( isset( $params['order'] ) ) {
				if ( strtolower( $params['order'] ) === strtolower( self::DESCENDING_SORT ) ) {
					$sort = '-' . $sort;
				}
			}

			$attributes['sort'] = $sort;
		}

		if ( isset( $params['show_product_count'] ) ) {
			$attributes['show_product_count'] = $params['show_product_count'];
		}

		if ( ! empty( $params ) ) {
			$attributes['page']['size']   = (int) $params['limit'] > 0 ? (int) $params['limit'] : '';
			$attributes['page']['number'] = $params['pg'] ?? 1;
		}

		if ( $params['display'] === 'grid' ) {
			$attributes['limit'] = $params['items_per_page_number'];
		}

		if ( ! prodigy_is_frontend() ) {
			$attributes['admin'] = true;
		}

		$query_string = http_build_query( $attributes );

		return urldecode( preg_replace( '/%5B(?:[0-9]|[1-9][0-9]+)%5D/', '[]', $query_string ) );
	}
}