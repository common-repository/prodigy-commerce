<?php

namespace Prodigy\Includes\Content;

use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Prodigy_Cache;

defined( 'ABSPATH' ) || exit;

/**
 * Prodigy request maker class
 *
 * @version    2.8.9
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Request_Maker {

	/**
	 * Single object of class
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Result of filter query
	 *
	 * @var object
	 */
	private $filter_result;

	/**
	 * Result of catalog query
	 *
	 * @var object
	 */
	private $catalog_result;

	/**
	 * Result of product query
	 *
	 * @var object
	 */
	private $product_result;

	/**
	 * Result of products query
	 *
	 * @var object
	 */
	private $products_result;

	/**
	 * Result of order query
	 *
	 * @var object
	 */
	private $order_result;

	/**
	 * Result of init order query
	 *
	 * @var object
	 */
	private $init_order_result;

	/**
	 * Result of related products query
	 *
	 * @var array
	 */
	private $related_products_result;

	/**
	 * Result of plugin settings
	 *
	 * @var array
	 */
	private $settings_result;

	/**
	 * @var Prodigy_Api_Client
	 */
	protected $api_client;

	/**
	 * @var object Prodigy_Cache
	 */
	public $cache;

	/**
	 * Deny allow clone
	 */
	protected function __clone() {}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize a Prodigy_Request_Maker object.' );
	}

	/**
	 * Create single object
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @return void
	 */
	public function __construct() {
		$this->cache      = new Prodigy_Cache();
		$this->api_client = new Prodigy_Api_Client();
	}

	/**
	 * @param string $query
	 *
	 * @return array
	 */
	public function do_catalog_filters_request( string $query = '' ): array {
		if ( $this->filter_result === null ) {
			$relations_query = 'categories.children,categories.parent,tags,properties.options';
			$catalog         = $this->cache->get_catalog_filters( $query );
			$catalog_url     = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::CATALOG_URL : Prodigy_Api_Client::CATALOG_ADMIN_URL;

			if ( ! empty( $catalog ) ) {
				$this->filter_result = $catalog;
			} else {
				$catalog_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $catalog_url . '?include=' . $relations_query . '&' . $query;
				$response    = $this->api_client->get_remote_content( $catalog_url );
				if ( ! is_wp_error( $response ) ) {
					$body          = wp_remote_retrieve_body( $response );
					$filter_result = json_decode( $body, true );

					if ( $filter_result ) {
						$this->cache->set_catalog_filters( $filter_result, $query );
						$this->filter_result = $filter_result;
					}
				}
			}
		}

		return $this->filter_result ?? array();
	}

	/**
	 * @param string $query
	 *
	 * @return mixed
	 */
	public function do_catalog_products_request( string $query ): array {
		if ( $this->catalog_result === null ) {
			$products = $this->cache->get_catalog_products( $query );

			if ( ! empty( $products ) && ! empty( $products['data'] ) ) {
				$this->catalog_result = $products;
			} else {
				$product_url      = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::PRODUCTS_URL : Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
				$api_url          = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . '?' . $query;
				$product_response = $this->api_client->get_remote_content( $api_url );

				if ( ! is_wp_error( $product_response ) ) {
					$body           = wp_remote_retrieve_body( $product_response );
					$catalog_result = json_decode( $body, true );

					if ( $catalog_result ) {
						$this->cache->set_catalog_products( $catalog_result, $query );
						$this->catalog_result = $catalog_result;
					}
				}
			}
		}

		return $this->catalog_result ?? array();
	}


	/**
	 * @param null   $id_remote_product
	 * @param string $includes
	 *
	 * @return mixed
	 */
	public function do_product_request( $id_remote_product = null, string $includes = null ): array {
		if ( $this->product_result === null ) {
			if ( $includes === null ) {
				$includes = implode(
					',',
					array(
						'tags',
						'categories',
						'tax-information',
						'master-variant.dimension',
						'master-variant.inventory',
						'variants.dimension',
						'variants.inventory',
						'cross-sell-products',
						'up-sell-products',
						'descriptive-attributes.options.images',
						'variant-attributes.options.images',
						'images',
						'master-variant.subscription-plan.subscription-conditions',
						'variants.subscription-plan.subscription-conditions',
						'quantity-price-breaks',
						'logos',
						'logo-locations',
						'logo-options',
						'personalization.personalization-fields',
					)
				);
			}

			$product     = $this->cache->get_product( (int) $id_remote_product );
			$product_url = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::PRODUCTS_URL : Prodigy_Api_Client::PRODUCTS_ADMIN_URL;
			if ( ! empty( $product ) ) {
				$this->product_result = $product;
			} else {
				$api_url           = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $product_url . '/' . $id_remote_product;
				$params['include'] = $includes;
				if ( ! Prodigy_Page::prodigy_is_frontend() ) {
					$params['admin'] = true;
				}

				$request_url        = add_query_arg( $params, $api_url );
				$product_obj_remote = $this->api_client->get_remote_content( $request_url );
				$response_code      = $product_obj_remote['code'] ?? '';

				if ( $response_code === \WP_Http::NOT_FOUND ) {
					if ( PRODIGY_DEBUG_MODE ) {
						do_action( 'logger', $product_obj_remote['response']['message'], 'error' );
					}
					wp_safe_redirect( home_url( '404' ) );
					exit();
				}

				$body = wp_remote_retrieve_body( $product_obj_remote );
				if ( ! is_wp_error( $product_obj_remote ) ) {
					$product_result = json_decode( $body, true );

					if ( $product_result ) {
						$this->cache->set_product( (int) $id_remote_product, $product_result );
						$this->product_result = $product_result;
					}
				}
			}
		}

		return $this->product_result ?? array();
	}

	/**
	 * @param string $query
	 *
	 * @return array
	 */
	public function do_products_request( string $query ): array {
		$hash = md5( $query );
		if ( ! isset( $this->products_result[ $hash ] ) ) {
			$products = $this->cache->get_products_shortcode( $query );
			if ( ! empty( $products ) && ! empty( $products['data'] ) ) {
				$this->products_result[ $hash ] = $products;
			} else {
				$api_url          = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::PRODUCTS_URL . '?' . $query;
				$product_response = $this->api_client->get_remote_content( $api_url );
				$body             = wp_remote_retrieve_body( $product_response );
				if ( ! is_wp_error( $product_response ) ) {
					$products_result = json_decode( $body, true );

					if ( $products_result ) {
						$this->cache->set_products_shortcode( $products_result, $query );
						$this->products_result[ $hash ] = $products_result;
					}
				}
			}
		}

		return $this->products_result[ $hash ] ?? array();
	}

	/**
	 * @param string $query
	 * @param string $key
	 *
	 * @return array
	 */
	public function do_related_products_request( string $query, string $key ): array {
		if ( $this->related_products_result === null ) {
			$object = $this->cache->get_related_product( $key );
			if ( empty( $object ) ) {
				$url                = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::RELATED_PRODUCTS_URL : Prodigy_Api_Client::RELATED_PRODUCTS_ADMIN_URL;
				$api_url            = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $url . '?' . $query;
				$product_obj_remote = $this->api_client->get_remote_content( $api_url );
				if ( ! is_wp_error( $product_obj_remote ) ) {
					$body   = wp_remote_retrieve_body( $product_obj_remote );
					$object = json_decode( $body, true );

					if ( $object ) {
						$this->cache->set_related_product( $key, $object );
						$this->related_products_result = $object;
					}
				}
			} else {
				$this->related_products_result = $object;
			}
		}

		return $this->related_products_result ?? array();
	}

	/**
	 * @param string $order_token
	 *
	 * @return mixed
	 */
	public function do_order_request( string $order_token ): array {
		if ( $this->order_result === null ) {
			$order = $this->cache->get_order( $order_token );
			if ( ! empty( $order ) ) {
				$this->order_result = $order;
			} else {
				$order_url   = Prodigy_Page::prodigy_is_frontend() ? Prodigy_Api_Client::ORDER_URL : Prodigy_Api_Client::ORDER_ADMIN_URL;
				$api_url     = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $order_url . '/' . $order_token;
				$request_url = add_query_arg(
					array(
						'include' =>
							'line-items.subscription-condition,cross-sell-products,up-sell-products,line-items.logo-options.logo,line-items.logo-options.logo-location,line-items.personalization-fields',
					),
					$api_url
				);
				$obj_remote  = $this->api_client->get_remote_content( $request_url );
				if ( ! is_wp_error( $obj_remote ) ) {
					$body            = wp_remote_retrieve_body( $obj_remote );
					$obj_data_remote = json_decode( $body, true );

					if ( $obj_data_remote ) {
						$this->cache->set_order( $order_token, $obj_data_remote );
						$this->order_result = $obj_data_remote;
					}
				}
			}
		}

		return $this->order_result ?? array();
	}

	/**
	 * @param array $request
	 *
	 * @return array
	 */
	public function do_init_order_request( array $request ): array {
		if ( $this->init_order_result === null ) {
			/* init order and push item in current order */
			$api_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::CART_URL;

			$this->init_order_result = $this->api_client->patch_remote_content( $api_url, $request );
		}

		return $this->init_order_result ?? array();
	}

	/**
	 * @return array|mixed
	 */
	public function do_settings_request() {
		if ( $this->settings_result === null ) {
			$option = $this->cache->get_settings();
			if ( empty( $option ) ) {
				$url      = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::HS_SETTINGS_URL;
				$response = $this->api_client->get_remote_content( $url );
				$body     = wp_remote_retrieve_body( $response );
				$data     = json_decode( $body, true );
				if ( isset( $response['code'], $data['data']['attributes'] ) && $response['code'] === \WP_Http::OK ) {
					$this->cache->set_settings( $option );
					$this->settings_result = $data;
					update_option( 'prodigy_plugin_settings', $data );
				}
			}
		}

		return $this->settings_result ?? array();
	}
}
