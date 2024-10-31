<?php

/**
 * Prodigy cart class
 *
 * @version    2.0.7
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes;

use Prodigy\Includes\Helpers\Prodigy_Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Cart
 */
class Prodigy_Cart {

	const PRODIGY_ORDER_COMPLETED   = 1;
	const PRODIGY_ORDER_IN_PROGRESS = 0;
	const ORDER_DATA_TABLE          = 'prodigy_orders';
	const CART_COOKIE_NAME          = 'wordpress_prodigy_cart';

	public $order_data_table;

	/** @var Prodigy_Cookies */
	public $cookie_helper;

	public $db;

	/**
	 * Prodigy_Base constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->db               = $wpdb;
		$this->cookie_helper    = new Prodigy_Cookies();
		$this->order_data_table = $this->db->prefix . self::ORDER_DATA_TABLE;
	}

	/**
	 * @param int    $order_number
	 * @param string $order_token
	 *
	 * @return string
	 */
	public static function get_checkout_url( int $order_number, string $order_token ): string {
		$base_url     = sprintf(
			'%1$s%2$s.%3$s/orders/%4$s/checkout/login',
			PRODIGY_PROTOCOL_DOMAIN,
			get_option( 'pg_url_domain_hosted_system' ),
			PRODIGY_CHECKOUT_DOMAIN,
			$order_number
		);
		$redirect_url = add_query_arg( 'token', $order_token, home_url() . '/api-listener' );

		return add_query_arg(
			array(
				'token'               => $order_token,
				'plugin_redirect_url' => rawurlencode( $redirect_url ),
			),
			$base_url
		);
	}

	/**
	 * @param string|null $current_session
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function set_user_session( string $current_session = null ) {
		$setting_time = ! empty( get_option( 'pg_custom_expiration_time' ) ) ? get_option( 'pg_custom_expiration_time' ) : get_option( 'pg_cart_expiration_time' );
		$expiry       = strtotime( '+' . $setting_time . ' hours' );

		if ( empty( $current_session ) ) {
			$this->cookie_helper->set_cookie( self::CART_COOKIE_NAME, $this->generate_uuid(), $expiry );
		} else {
			$this->cookie_helper->set_cookie( self::CART_COOKIE_NAME, $current_session, $expiry );
		}
	}

	/**
	 * Generate unique hash
	 *
	 * @return string
	 */
	public function generate_uuid() {
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0x0C2f ) | 0x4000,
			wp_rand( 0, 0x3fff ) | 0x8000,
			wp_rand( 0, 0x2Aff ),
			wp_rand( 0, 0xffD3 ),
			wp_rand( 0, 0xff4B )
		);
	}

	/**
	 * @param string $token
	 *
	 * @return array
	 */
	public static function get_order_includes( string $token ): int {
		global $wpdb;
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"select order_number from {$wpdb->prefix}prodigy_orders where token = %s and status <> 1",
				$token
			),
			ARRAY_A
		);

		if ( isset( $result[0] ) ) {
			return json_decode( $result[0]['order_number'], true );
		}
	}

	/**
	 * @param string $order_token
	 * @param int    $status
	 *
	 * @return bool
	 */
	public function update_status_orders( string $order_token, $status = self::PRODIGY_ORDER_IN_PROGRESS ) {

		$is_update = $this->db->update(
			$this->order_data_table,
			array(
				'status'     => $status,
				'updated_at' => gmdate( 'Y-m-d H:i:s', time() ),
			),
			array(
				'token' => $order_token,
			),
			array( '%d', '%s' ),
			array( '%s' )
		);

		return (bool) $is_update;
	}

	/**
	 * @param string $order_token
	 * @param string $user_session
	 * @param array  $data
	 *
	 * @return bool
	 */
	public function update_order_data_in_storage( $order_token, $user_session, $data ) {
		$is_update = $this->db->update(
			$this->order_data_table,
			array(
				'includes'   => $data,
				'updated_at' => gmdate( 'Y-m-d H:i:s', time() ),
			),
			array(
				'local_user_hash' => $user_session,
				'token'           => $order_token,
			),
			array( '%s', '%s' ),
			array( '%s', '%s' )
		);

		return (bool) $is_update;
	}

	/**
	 * @param array  $response
	 * @param string $user_session
	 *
	 * @return bool
	 */
	public function create_order( array $response, string $user_session ): bool {
		$order_number = $response['data']['id'] ?? null;
		$token        = $response['data']['attributes']['token'] ?? false;

		$result = false;
		if ( isset( $order_number ) && $token ) {
			$result = $this->db->insert(
				$this->order_data_table,
				array(
					'local_user_hash' => $user_session,
					'order_number'    => $order_number,
					'token'           => $token,
					'status'          => $this->get_order_status( $token ),
					'created_at'      => gmdate( 'Y-m-d H:i:s', time() ),
					'includes'        => wp_json_encode( $response ),
				),
				array( '%s', '%d', '%s', '%d', '%s', '%s' )
			);
		}

		return (bool) $result;
	}

	/**
	 * @param string $token
	 *
	 * @return int
	 */
	public function get_order_status( string $token ) {
		global $wpdb;
		$completed_status = self::PRODIGY_ORDER_COMPLETED;

		$status = $wpdb->get_results(
			$wpdb->prepare(
				"select * from {$wpdb->prefix}prodigy_orders where token = %s and status <> %d",
				$token,
				$completed_status
			),
			ARRAY_A
		);

		return (int) $status;
	}

	/**
	 * @param string $token
	 *
	 * @return array
	 */
	public function get_in_process_order_for_token( string $token ) {
		global $wpdb;
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"select * from {$wpdb->prefix}prodigy_orders where token = %s and status = %d",
				$token,
				self::PRODIGY_ORDER_IN_PROGRESS
			),
			ARRAY_A
		);

		return ! empty( $result ) ? $result[0] : false;
	}


	/**
	 * @param array  $remote_product
	 * @param string $count
	 *
	 * @return array
	 */
	public function prepare_line_item_request( array $remote_product, string $count ) {
		if ( isset( $remote_product['remote_product_id'] ) ) {
			$product_id = filter_var( $remote_product['remote_product_id'], FILTER_VALIDATE_INT );
		}

		if ( isset( $remote_product['subscription_id'] ) ) {
			$subscription_id = filter_var( $remote_product['subscription_id'], FILTER_VALIDATE_INT );
		}

		$request = array(
			'line_item'   =>
				array(
					'quantity'                  => $count ?? 0,
					'variant_id'                => $product_id ?? '',
					'subscription_condition_id' => $subscription_id ?? '',
					'logo_option_ids'           => $item['logos_ids'] ?? array(),
				),
			'order_token' => $remote_product['token'],
		);

		if ( isset( $request['line_items'] ) && ! $request['line_items'][0]['subscription_condition_id'] ) {
			unset( $request['line_items'][0]['subscription_condition_id'] );
		}

		return $request;
	}

	/**
	 * @param array $item
	 * @param null  $token
	 *
	 * @return array
	 */
	public function set_cart_prepare_request( array $item, $token = null ): array {
		if ( isset( $item['count'] ) ) {
			$count = filter_var( $item['count'], FILTER_VALIDATE_INT );
		}

		if ( isset( $item['remote_product_id'] ) ) {
			$remote_product_id = filter_var( $item['remote_product_id'], FILTER_VALIDATE_INT );
		}

		if ( isset( $item['subscription_id'] ) ) {
			$subscription_id = filter_var( $item['subscription_id'], FILTER_VALIDATE_INT );
		}

		if ( isset( $item['is_bulk'] ) && $item['is_bulk'] !== 'false' ) {
			$request = array();
			if ( is_array( $item['remote_product_id'] ) ) {
				foreach ( $item['remote_product_id'] as $key => $one ) {
					if ( is_numeric( $key ) ) {
						$request['line_items'][ $key ] = array(
							'quantity'        => $item['attributes'][ $key ]['quantity'] ?? 0,
							'variant_id'      => $one['remote_variant_id'] ?? '',
							'logo_option_ids' => $item['logos_ids'] ?? array(),
						);
					}

					if ( isset( $item['personalization'][0] ) && $this->is_personalization_filled( $item['personalization'] ) ) {
						$label = wp_unslash( $item['personalization'][0]['label'] ?? '' );
						$request['line_items'][ $key ]['personalization_id']                 = $item['personalization'][0]['personalization_id'] ?? 0;
						$request['line_items'][ $key ]['personalization_fields']             = $item['personalization'] ?? '';
						$request['line_items'][ $key ]['personalization_fields'][0]['label'] = $label;
					}
				}
			}
		} else {
			$request = array(
				'include'    => 'line-items',
				'line_items' => array(
					array(
						'quantity'                  => $count ?? 0,
						'variant_id'                => $remote_product_id ?? '',
						'subscription_condition_id' => $subscription_id ?? '',
						'logo_option_ids'           => $item['logos_ids'] ?? array(),
					),
				),
			);

			if ( isset( $item['personalization'][0] ) && $this->is_personalization_filled( $item['personalization'] ) ) {
				$label = wp_unslash( $item['personalization'][0]['label'] ?? '' );
				$request['line_items'][0]['personalization_id']                 = $item['personalization'][0]['personalization_id'] ?? 0;
				$request['line_items'][0]['personalization_fields']             = $item['personalization'] ?? '';
				$request['line_items'][0]['personalization_fields'][0]['label'] = $label;
			}
		}

		if ( isset( $request['line_items'][0]['subscription_condition_id'] ) && ! $request['line_items'][0]['subscription_condition_id'] ) {
			unset( $request['line_items'][0]['subscription_condition_id'] );
		}

		$request['redirect_to'] = '/api-listener';

		if ( ! empty( $token ) ) {
			$request['order_token'] = $token;
		}

		if ( isset( $request['line_items']['bulk_total_price'] ) ) {
			unset( $request['line_items']['bulk_total_price'] );
		}

		return $request;
	}

	/**
	 * @param array $personalization
	 *
	 * @return bool
	 */
	public function is_personalization_filled( array $personalization ): bool {
		$is_filled = false;
		foreach ( $personalization as $field ) {
			if ( ! empty( $field['value'] ) ) {
				$is_filled = true;
			}
		}
		return $is_filled;
	}

	/**
	 * @param string $user_session
	 *
	 * @return bool
	 */
	public function get_token_for_current_order( string $user_session ) {
		global $wpdb;
		$table_name = $this->order_data_table;

		$like = '%' . $wpdb->prefix . 'prodigy_orders%';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like ) ) == $table_name ) {
			$result = $wpdb->get_results(
				$wpdb->prepare(
					"select token from {$wpdb->prefix}prodigy_orders where local_user_hash = %s and status <> 1 and deleted_at is null ",
					$user_session
				),
				ARRAY_A
			);

			return $result[0]['token'] ?? null;
		}

		return null;
	}

	/**
	 * @param string $order_token
	 *
	 * @return bool
	 */
	public function delete_local_order( string $order_token ) {
		$is_update = $this->db->update(
			$this->order_data_table,
			array(
				'deleted_at' => gmdate( 'Y-m-d H:i:s', time() ),
			),
			array(
				'token' => $order_token,
			),
			array( '%s' ),
			array( '%s' )
		);

		return (bool) $is_update;
	}


	/**
	 * @param string $order_token
	 *
	 * @return bool
	 */
	public function is_deleted_order( string $order_token ) {

		$result = $this->db->get_row(
			$this->db->prepare(
				"select deleted_at from {$this->db->prefix}prodigy_orders where token = %s",
				$order_token
			),
			ARRAY_A
		);

		return ! empty( $result['deleted_at'] );
	}
}
