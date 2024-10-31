<?php

/**
 * Prodigy product page class
 *
 * @version    2.8.1
 * @package    prodigy/includes/public/pages
 */
namespace Prodigy\Includes\Frontend\Pages;

use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Models\Prodigy_Products;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy product page class
 *
 * @version    2.8.1
 * @package    prodigy/includes/public/pages
 */
class Prodigy_Product_Page extends Prodigy_Page {

	const COUNT_COMMENTS_ON_PAGE_PRODUCT = 5;

	/**
	 * Prodigy_Product_Page constructor.
	 */
	public function __construct() {
		add_filter( 'pre_get_document_title', array( $this, 'prodigy_set_meta_tags' ) );
		add_action( 'wp_ajax_prodigy-public-get-variant-data', array( $this, 'prodigy_public_get_variant_data' ) );
		add_action(
			'wp_ajax_nopriv_prodigy-public-get-variant-data',
			array(
				$this,
				'prodigy_public_get_variant_data',
			)
		);
		add_action(
			'wp_ajax_prodigy-public-get-variant-multiple-data',
			array(
				$this,
				'prodigy_public_get_variant_multiple_data',
			)
		);
		add_action(
			'wp_ajax_nopriv_prodigy-public-get-variant-multiple-data',
			array(
				$this,
				'prodigy_public_get_variant_multiple_data',
			)
		);
		add_action( 'wp_ajax_prodigy-quick-edit', array( $this, 'prodigy_quick_view_get_product' ) );
		add_action( 'wp_ajax_nopriv_prodigy-quick-edit', array( $this, 'prodigy_quick_view_get_product' ) );
		add_action(
			'wp_ajax_prodigy-get-master-variant-data',
			array(
				$this,
				'prodigy_remote_get_master_variant_data',
			)
		);
		add_action(
			'wp_ajax_nopriv_prodigy-get-master-variant-data',
			array(
				$this,
				'prodigy_remote_get_master_variant_data',
			)
		);
		add_action( 'wp_ajax_prodigy-remote-get-inventory-product', array( $this, 'prodigy_get_inventory_product' ) );
		add_action(
			'wp_ajax_nopriv_prodigy-remote-get-inventory-product',
			array(
				$this,
				'prodigy_get_inventory_product',
			)
		);
		add_action( 'wp_ajax_prodigy-public-get-comments', array( $this, 'prodigy_get_comments' ) );
		add_action( 'wp_ajax_nopriv_prodigy-public-get-comments', array( $this, 'prodigy_get_comments' ) );
		add_action( 'wp_ajax_prodigy-public-get-comments-count', array( $this, 'prodigy_get_comments_count' ) );
		add_action( 'wp_ajax_nopriv_prodigy-public-get-comments-count', array( $this, 'prodigy_get_comments_count' ) );
		add_action( 'wp_ajax_prodigy-get-tiered-prices-range', array( $this, 'get_tiered_prices_range' ) );
		add_action( 'wp_ajax_nopriv_prodigy-get-tiered-prices-range', array( $this, 'get_tiered_prices_range' ) );
	}

	/**
	 * @return void
	 */
	public function get_tiered_prices_range() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';

		$product = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $product_id );
		$range   = ( new Prodigy_Product_Parser( $product ) )->get_tiered_price_range( $product );

		wp_send_json_success( $range );
	}

	/**
	 * set meta tags
	 */
	public function prodigy_set_meta_tags() {
		$slug    = get_queried_object()->post_name ?? '';
		$product = get_page_by_path( $slug, OBJECT, Prodigy::get_prodigy_product_type() );

		if ( isset( $product->ID ) ) {
			$title = get_post_meta( $product->ID, Prodigy_Products::PRODUCT_META_TITLE, true );
		}

		return $title ?? '';
	}

	/**
	 * Get inventory for product
	 */
	public function prodigy_get_inventory_product() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}
		$post_id        = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : '';
		$post_remote_id = isset( $_POST['remote_id'] ) ? sanitize_text_field( wp_unslash( $_POST['remote_id'] ) ) : '';

		if ( $post_id || $post_remote_id ) {
			$remote_id    = $post_remote_id ?? get_post_meta( (int) $post_id, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );
			$product_info = '';
			if ( ! empty( $remote_id ) ) {
				$product_info = Prodigy_Request_Maker::get_instance()->do_product_request( $remote_id, 'master-variant.inventory,variants.inventory' );
			}

			$attributes = array();

			if ( isset( $product_info->included ) ) {
				foreach ( $product_info->included as $item ) {
					if ( $item->type === 'inventories' ) {
						$attributes = $item->attributes;
					}
				}
			}

			wp_send_json_success( compact( 'attributes' ) );
		}
	}

	/**
	 * Get remote product by ajax and generate html
	 *
	 * @version 2.8.1
	 */
	public function prodigy_remote_get_master_variant_data() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}

		$post_id      = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : '';
		$items_number = isset( $_POST['items_number'] ) ? sanitize_text_field( wp_unslash( $_POST['items_number'] ) ) : '';

		$product_data                                 = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $post_id );
		$product                                      = new Prodigy_Product_Parser( $product_data );
		$master_variant                               = $product->get_master_variant();
		$master_variant['subscriptions']              = $product->get_subscriptions( (int) $post_id );
		$master_variant['remote_main_price']          = $product->get_main_price();
		$master_variant['remote_master_variant_info'] = $product->get_variant_info( array(), $product->get_id_master_variant() );

		if ( $product->is_tiered_price() ) {
			$master_variant['tiered_price'] = $product->calculate_tiered_price( $master_variant, (int) ( $items_number ?? 1 ) );
		}

		wp_send_json_success( $master_variant );
	}

	/**
	 * @return void
	 */
	public function prodigy_get_comments_count() {
		$comm    = 0;
		$post_id = isset( $_POST['post_id'] ) ? sanitize_key( wp_unslash( $_POST['post_id'] ) ) : '';
		$page    = isset( $_POST['page'] ) ? sanitize_key( wp_unslash( $_POST['page'] ) ) : 1;

		if ( ! empty( $post_id ) ) {
			$comm = get_comments(
				array(
					'post_id' => $post_id,
					'count'   => true,
				)
			);
		}

		if ( ! empty( $comm ) ) {
			$count_p = ceil( $comm / self::COUNT_COMMENTS_ON_PAGE_PRODUCT );

			if ( $page > $count_p ) {
				$comm = 0;
			}
		}

		wp_send_json_success( $comm );
	}

	/**
	 * get pagination comments
	 */
	public function prodigy_get_comments() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}

		$post_id = isset( $_POST['post_id'] ) ? sanitize_key( wp_unslash( $_POST['post_id'] ) ) : '';
		$page    = isset( $_POST['page'] ) ? sanitize_key( wp_unslash( $_POST['page'] ) ) : 1;

		$comments = get_comments(
			array(
				'post_id' => (int) $post_id,
			)
		);

		$data_i = array(
			'callback' => 'prodigy_comments',
			'per_page' => self::COUNT_COMMENTS_ON_PAGE_PRODUCT,
			'page'     => $page,
		);

		$data = wp_list_comments(
			$data_i,
			$comments
		);

		if ( ! empty( $data ) ) {
			echo $data;
		}

		wp_die();
	}

	/**
	 * Ajax handler for retrieving product variant data.
	 *
	 * @return void
	 */
	public function prodigy_public_get_variant_multiple_data() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			wp_send_json_error( 'Unauthorised', 401 );
		}

		$post_data = filter_input_array(
			INPUT_POST,
			array(
				'attribute'       => FILTER_SANITIZE_SPECIAL_CHARS,
				'post_id'         => FILTER_VALIDATE_INT,
				'logo_id'         => FILTER_VALIDATE_INT,
				'location_id'     => FILTER_VALIDATE_INT,
				'bulk_attributes' => array(
					'filter' => FILTER_SANITIZE_STRING,
					'flags'  => FILTER_REQUIRE_ARRAY,
				),
				'variants'        => array(
					'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
					'flags'  => FILTER_REQUIRE_ARRAY,
				),
			)
		);

		$variant_array     = array();
		$id_remote_product = $post_data['post_id'] ?? '';
		$bulk_attribute    = $post_data['bulk_attributes'] ?? array();
		$valid_variant     = $post_data['variants'] ?? array();

		if ( empty( $bulk_attribute ) || empty( $id_remote_product ) ) {
			wp_send_json_error( 'Invalid data', \WP_Http::BAD_REQUEST );
		}

		$product_data       = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $id_remote_product );
		$remote_product_obj = new Prodigy_Product_Parser( $product_data );

		foreach ( $bulk_attribute as $item ) {
			$valid_variant[]                = $item['name'];
			$variant_array[ $item['name'] ] = $remote_product_obj->get_variant_info( $valid_variant );
			$key                            = array_search( $item['name'], $valid_variant, true );
			unset( $valid_variant[ $key ] );
		}

		wp_send_json_success( $variant_array );
	}

	/**
	 * get remote variants
	 *
	 * @version 2.0.7
	 */
	public function prodigy_public_get_variant_data() {
		$nonce = sanitize_text_field( $_POST['nonce'] ?? '' );
		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'store-nonce' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
			return;
		}

		$is_bulk           = filter_var( $_POST['is_bulk'], FILTER_VALIDATE_BOOLEAN );
		$quantity          = filter_var( $_POST['number_of_items'], FILTER_VALIDATE_INT );
		$variants          = wp_unslash( $_POST['variants'] ?? array() );
		$id_remote_product = filter_var( wp_unslash( $_POST['post_id'] ?? '' ), FILTER_VALIDATE_INT );

		if ( $is_bulk ) {
			$variants = (array) $variants;
		} else {
			$variants = array( $variants );
		}

		$variant_data       = array();
		$product_data       = Prodigy_Request_Maker::get_instance()->do_product_request( (int) $id_remote_product );
		$remote_product_obj = new Prodigy_Product_Parser( $product_data );

		if ( empty( $id_remote_product ) ) {
			wp_send_json_error( 'Not found product!', 404 );
		}

		foreach ( $variants as $key => $variant ) {
			if ( $is_bulk ) {
				if ( $remote_product_obj->is_tiered_price() ) {
					$quantity          = $this->get_bulk_quantity( $variants );
					$quantity_response = $variants[ $key ]['quantity'];
				} else {
					$quantity_response = $variant['quantity'];
				}
				$variant = explode( '&', $variant['variant'] );
			}
			$variant_data[ $key ] = $remote_product_obj->get_variant_info( $variant );

			if ( isset( $variant_data[ $key ]['remote_variant_id'] ) ) {
				$subscriptions      = $remote_product_obj->get_subscriptions( (int) $variant_data[ $key ]['remote_variant_id'] );
				$subscriptionPrices = $this->sort_subscription_prices( $variant_data[ $key ]['attributes']['subscription-prices'] ?? array() );

				$variant_data[ $key ]['subscriptions'] = Prodigy_Template::prodigy_get_template_html(
					'single-product/subscriptions.php',
					compact( 'subscriptions', 'subscriptionPrices' )
				);
			}

			if ( $remote_product_obj->is_tiered_price() ) {
				$variant_data[ $key ]['attributes']['tiered_price'] = $remote_product_obj->calculate_tiered_price( $variant_data[ $key ], (int) ( $quantity ?? 1 ) );
			}
			if ( $is_bulk ) {
				$variant_data[ $key ]['number_of_items'] = $quantity_response;
			}
			$variant_data[ $key ]['tiered_prices_range'] = $remote_product_obj->get_tiered_price_range();
		}

		wp_send_json_success( array( 'result' => $variant_data ) );
	}

	/**
	 * @param array $items
	 *
	 * @return int
	 */
	private function get_bulk_quantity( array $items ): int {
		$total_quantity = 0;
		foreach ( $items as $item ) {
			if ( isset( $item['quantity'] ) && is_numeric( $item['quantity'] ) ) {
				$total_quantity += $item['quantity'];
			}
		}

		return (int) $total_quantity;
	}


	/**
	 * @param array $prices
	 * @return array
	 */
	protected function sort_subscription_prices( array $prices ): array {
		if ( empty( $prices ) ) {
			return array();
		}

		usort(
			$prices,
			static function ( $a, $b ) {
				return $a['condition_price'] > $b['condition_price'];
			}
		);

		foreach ( $prices as $price ) {
			$sortPrices[ $price['subscription_condition_id'] ] = (array) $price;
		}

		return $sortPrices ?? array();
	}

	/**
	 *  Get product for quick view modal window
	 */
	public function prodigy_quick_view_get_product() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'store-nonce' ) ) {
			return;
		}
		$id_remote_product = 0;
		if ( isset( $_POST['post_id'] ) ) {
			$id_remote_product = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
		}
		$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product_template->get_product( (int) $id_remote_product );
		// for check page in theme
		$GLOBALS['quick_view'] = true;
		Prodigy_Template::prodigy_get_template( 'content-single-product.php' );
		wp_die();
	}
}
