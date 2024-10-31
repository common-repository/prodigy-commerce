<?php
namespace Prodigy\Includes\Frontend;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Product_Comments;

/**
 * Prodigy product template builder
 *
 * @version    3.0.2
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Template_Builder {

	/**
	 * @var Prodigy_Product_Template_Item
	 */
	private $product;

	public function __construct( Prodigy_Product_Template_Item $product ) {
		$this->product = $product;
	}

	/**
	 * @param int $post_id
	 *
	 * @return Prodigy_Product_Template_Item
	 */
	public function get_product( int $post_id = 0 ): Prodigy_Product_Template_Item {

		if (
			isset( $_POST['action'] ) && ! empty( $post_id ) && ( $_POST['action'] === 'elementor_ajax' || wp_doing_ajax() )
		) {
			$product_id = $post_id;
		} else {
			/*
			* for elementor
			*/
			$product_id = $this->get_product_id();
		}

		if ( $product_id !== null ) {
			$id_remote_product = get_post_meta( $product_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );

			if ( isset( $id_remote_product ) ) {
				$product_response   = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $id_remote_product );
				$remote_product_obj = new Prodigy_Product_Parser( $product_response );
				$this->product->set_remote_product_id( $id_remote_product );
			}

			if ( Prodigy::get_prodigy_product_type() === get_post_type( $product_id ) && (int) $product_id ) {
				$this->product->set_row_id( $product_id );
				$this->product->set_fields( (array) get_post( $product_id, false ) );
				$this->product->set_meta( get_post_meta( $product_id ) );
				$this->product->set_count_reviews( Prodigy_Product_Comments::get_count_review_product( $product_id ) );
				$this->product->set_count_rating( Prodigy_Product_Comments::get_counts_rating_product( $product_id ) );
				$this->product->set_average_rating( Prodigy_Product_Comments::get_rating_average_product( $product_id ) );

				if ( isset( $remote_product_obj ) ) {
					$this->product->set_remote_main_stock_status( $remote_product_obj->get_categories() );
					$this->product->set_up_sell_products( $remote_product_obj->get_up_sell_products() );
					$this->product->set_cross_sell_products( $remote_product_obj->get_cross_sell_products() );
					$this->product->set_local_product_id( $product_id );
					$this->product->set_remote_categories( $remote_product_obj->get_categories() );
					$this->product->set_remote_tags( $remote_product_obj->get_tags() );
					$this->product->set_remote_description( $remote_product_obj->get_description() );
					$this->product->set_remote_title( $remote_product_obj->get_title() );
					$this->product->set_remote_variants( $remote_product_obj->get_variants() );
					$this->product->set_remote_main_price( $remote_product_obj->get_main_price() );
					$this->product->set_remote_range_current_price( $remote_product_obj->get_range_current_price() );
					$this->product->set_remote_main_sku( $remote_product_obj->get_main_sku() );
					$this->product->set_charge_amount( $remote_product_obj->get_charge_amount() );
					$this->product->set_remote_images( $remote_product_obj->get_images() );
					$this->product->set_master_id_variant( $remote_product_obj->get_id_master_variant() );
					$this->product->set_remote_master_variant_info(
						$remote_product_obj->get_variant_info( array(), $remote_product_obj->get_id_master_variant() )
					);
					$this->product->set_master_variant_logos( $remote_product_obj->get_master_variant_logos() );
					$this->product->set_descriptive_attributes( $remote_product_obj->get_descriptive_properties() );
					$this->product->set_descriptive_option( $remote_product_obj->get_descriptive_option() );
					$this->product->set_variant_options( $remote_product_obj->get_attributes_options() );
					$this->product->set_logos( $remote_product_obj->get_logos() );
					$this->product->set_logo_locations( $remote_product_obj->get_logo_locations() );
					$this->product->set_images( $remote_product_obj->get_all_images_relation() );
					$this->product->set_range_setting( $remote_product_obj->get_status_range() );
					$this->product->set_prepared_variants( $remote_product_obj->get_prepared_variants() );
					$this->product->set_option_variants_intersect( $remote_product_obj->get_option_variants_intersect() );
					$this->product->set_subscriptions( $remote_product_obj->get_subscriptions() );
					$this->product->set_display_options_type( $remote_product_obj->get_display_options_type() );
					$this->product->set_tiered_prices( $remote_product_obj->get_tired_prices() );
					$this->product->set_tiered_price_range( $remote_product_obj->get_tiered_price_range() );
					$this->product->set_personalizations_fields( $remote_product_obj->get_personalizations_fields() );
				}
			}

			if ( isset( $GLOBALS['prodigy_product'] ) ) {
				unset( $GLOBALS['prodigy_product'] );
			}

			$GLOBALS['prodigy_product'] = $this->product;
		}

		return $this->product;
	}

	/**
	 *
	 * @return false|int|mixed|string
	 */
	public function get_product_id() {
		global $post;

		if ( ! isset( $_GET['action'] ) && isset( $post, $post->ID ) && Prodigy::get_prodigy_product_type() === get_post_type( $post->ID ) ) {
			return absint( $post->ID );
			// for elementor
		}

		if (
			isset( $_POST['_nonce'], $_POST['action'], $_POST['post_id'] ) &&
			wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_nonce'] ) ), 'elementor_ajax' )
		) {
			return esc_attr( sanitize_key( wp_unslash( $_POST['post_id'] ) ) );
		}

		// For the Elementor builder.
		return self::get_random_product();
	}


	/**
	 * For Elementor builder.
	 *
	 * @return int|null
	 */
	public static function get_random_product() {
		$api_client        = new Prodigy_Api_Client();
		$product_url       = Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
		$url               = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url;
		$products_response = $api_client->get_remote_content( $url );
		$body              = wp_remote_retrieve_body( $products_response );
		$object            = json_decode( $body, true );

		$local_parent_product_id = null;
		if ( isset( $object['data'][0]['id'] ) ) {
			$local_parent_product_info = self::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, (int) $object['data'][0]['id'] );
			$local_parent_product_id   = $local_parent_product_info->post_id ?? 0;
		}

		return $local_parent_product_id;
	}

	/**
	 * @param int $limit
	 *
	 * @return array|null
	 */
	public static function get_random_products( int $limit = 5 ): ?array {
		$params = array(
			'post_type'      => Prodigy::get_prodigy_product_type(),
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
		);

		$query = new \WP_Query( $params );
		if ( $query->have_posts() ) {
			return $query->posts;
		}

		return null;
	}

	/**
	 * @param string $key
	 * @param int    $value
	 *
	 * @return object
	 */
	public static function get_product_meta_by_remote_id( string $key, int $value ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->postmeta} WHERE meta_key = %s and meta_value= %d ",
				array( $key, $value )
			)
		);
	}
}
