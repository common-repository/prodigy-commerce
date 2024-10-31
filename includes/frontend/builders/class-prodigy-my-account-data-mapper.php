<?php
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_My_Account;
use Prodigy\Includes\Helpers\Prodigy_Helper_Hosted_System;
use Prodigy\Includes\Prodigy_User;

/**
 * Prodigy my account data mapper
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_My_Account_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $options
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function get_default_parameters( array $options ): array {
		if ( ! empty( $options['my_account_icon_url'] ) ) {
			$options['icon_type'] = 'svg';
		}
		$options['icon_class'] = $options['icon_class'] ?? '';
		$options['get_customer_login_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_login() );
		$options['get_customer_account_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_account() );
		$options['get_customer_orders_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_orders() );
		$options['get_customer_addresses_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_addresses() );
		$options['get_customer_payment_methods_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_payments() );
		$options['get_customer_profile_settings_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_profile_settings() );
		$options['get_customer_subscriptions_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_subscription_settings() );
		$options['get_customer_giftcards_url'] = esc_url( Prodigy_Helper_Hosted_System::get_url_customer_balance() );
		$options['is_dropdown'] = $options['is_dropdown'] ?? false;
		$options['container_class'] = $options['container_class'] ?? '';
		$options['subscriptions'] = get_option( Prodigy_User::SUBSCRIPTION_OPTION );
		$options['customer_balance'] = get_option( Prodigy_User::CUSTOMER_BALANCE_OPTION );
		$options['heading_text'] = $options['heading_text'] ?? Prodigy_Short_Code_My_Account::DEFAULT_TITLE;

		return $options;
	}
}
