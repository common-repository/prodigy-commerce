<?php
/**
 * Prodigy category data mapper
 *
 * @version    2.6.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;

defined( 'ABSPATH' ) || exit;

class Prodigy_Category_Data_Mapper extends Prodigy_Main_Data_Mapper {

	const IMG_DEFAULT_CATEGORY = 'https://prodigycommerce-public-files.s3.us-east-2.amazonaws.com/wordpress/default-category.jpg';

	/**
	 * @var array $show_product_count_mapper
	 */
	public $show_product_count_mapper = array(
		'true'  => true,
		'yes'   => true,
		'false' => false,
		''      => false,
		'on'    => true,
		'off'   => false,
	);

	/**
	 * @param int $category_id
	 *
	 * @return mixed
	 */
	private function get_category( $category_id ) {
		$categories = $this->cache->get_categories_shortcode( $category_id );
		if ( ! empty( $categories ) ) {
			$object = $categories;
		} else {
			$category_url = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::CATEGORY_URL : Prodigy_Api_Client::CATEGORY_ADMIN_URL;
			$params       = '?ids[]=' . $category_id;
			if ( ! Prodigy_Page::prodigy_is_frontend() ) {
				$params .= '&admin=true';
			}

			$api_url           = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $category_url . $params;
			$category_response = $this->api_client->get_remote_content( $api_url );
			$body              = wp_remote_retrieve_body( $category_response );
			$object            = json_decode( $body, true );
			$this->cache->set_categories_shortcode( $object ?? array(), $category_id );
		}

		return $object;
	}

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		global $wpdb;

		if ( ! empty( $options['category_id'] ) ) {
			$remote_id = $options['category_id'];
		}

		if ( ! empty( $options['category_slug'] ) ) {
			$category = Prodigy_Taxonomies::get_taxonomy_by_different_slugs( Prodigy::get_prodigy_category_type(), $options['category_slug'] );

			if ( isset( $category->term_id ) ) {
				$remote_id = get_term_meta( (int) $category->term_id, 'prodigy_hosted_category_relation', true );
			}
		} else {
			$options['category_slug'] = 'Category Title';
		}

		if ( isset( $remote_id ) ) {
			$category_response = $this->get_category( (int) $remote_id );
		}

		$category_image = '';
		if (
			isset( $options['category_image'] )
			&& $options['category_image'] !== self::IMG_DEFAULT_CATEGORY
		) {
			$category_image = $options['category_image'];
		}

		if ( isset( $category_response ) ) {
			$category = $this->format_data( $category_response['data'] );
		}

		if ( isset( $category_response['data'] ) && empty( $options['category_image'] ) ) {
			$category_image = $category['img_url'];
		}

		if ( ! empty( $options['category_image'] ) ) {
			$category_image = $options['category_image'];
		}

		$is_product_count = $this->show_product_count_mapper[ $options['show_count_products'] ];
		if ( isset( $category['id'] ) ) {
			$category['term_id']   = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $category['id'] );
			$category['local_url'] = get_category_link( $category['term_id']->term_id ?? '' );
		}

		return array(
			'category'           => $category ?? array(),
			'category_image'     => ! empty( $category_image ) ? $category_image : self::IMG_DEFAULT_CATEGORY,
			'opacity'            => $options['opacity'] ?? '',
			'image_position'     => $options['image_position'] ?? '',
			'height'             => $options['height'],
			'show_product_count' => $is_product_count,
			'attr'               => $options,
		);
	}


	/**
	 * @param array $category
	 *
	 * @return array
	 */
	private function format_data( array $category ): array {
		$categories_data['id']      = $category[0]['id'] ?? 0;
		$categories_data['name']    = $category[0]['attributes']['name'] ?? '';
		$categories_data['count']   = $category[0]['attributes']['products-count'] ?? 0;
		$categories_data['img_url'] = $category[0]['attributes']['image-url'] ?? '';

		return $categories_data;
	}
}
