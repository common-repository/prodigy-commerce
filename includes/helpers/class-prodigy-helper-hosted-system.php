<?php
namespace Prodigy\Includes\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy Helper Hosted System class
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Helper_Hosted_System {

	const HOSTED_PATH_LOGIN = '/customer/login';
	const HOSTED_PATH_ACCOUNT = '/customer/account';
	const HOSTED_PATH_ORDERS = '/customer/orders';
	const HOSTED_PATH_ADDRESSES = '/customer/addresses';
	const HOSTED_PATH_PAYMENT_METHODS = '/customer/payment_methods';
	const HOSTED_PATH_PROFILE_SETTINGS = '/customer/profile_settings';
	const HOSTED_PATH_SUBSCRIPTION = '/customer/subscriptions';

	/**
	 * @param string $target_url
	 *
	 * @return void
	 */
	public function redirect_to_hosted_system( string $target_url ) {
		wp_redirect( $target_url );
		exit;
	}

	/**
	 * @return string
	 */
	public static function get_url_subdomain(): string {
		return get_option( 'pg_url_domain_hosted_system', '' );
	}

	/**
	 * @return string
	 */
	public static function get_url_customer_login(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_LOGIN;
	}


	/**
	 * @return string
	 */
	public static function get_url_customer_account(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_ACCOUNT;
	}

	/**
	 * @return string
	 */
	public static function get_url_customer_orders(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_ORDERS;
	}


	/**
	 * @return string
	 */
	public static function get_url_customer_addresses(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_ADDRESSES;
	}


	/**
	 * @return string
	 */
	public static function get_url_customer_payments(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_PAYMENT_METHODS;
	}

	/**
	 * @return string
	 */
	public static function get_url_customer_subscription_settings(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_SUBSCRIPTION;
	}

	/**
	 * @return string
	 */
	public static function get_url_customer_balance(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_ACCOUNT;
	}

	/**
	 * @return string
	 */
	public static function get_url_customer_profile_settings(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN . self::HOSTED_PATH_PROFILE_SETTINGS;
	}

	/**
	 * @return string
	 */
	public static function get_url_home(): string {
		return PRODIGY_PROTOCOL_DOMAIN . self::get_url_subdomain() . '.' . PRODIGY_CHECKOUT_DOMAIN;
	}
}
