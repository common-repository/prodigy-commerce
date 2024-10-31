<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Helpers\Prodigy_Formatting;

/**
 * Prodigy product subscriptions data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Subscriptions_Data_Mapper extends Prodigy_Main_Data_Mapper {

	const SUBSCRIPTIONS_DISCOUNT_TYPE = 'percentage';
	const SUBSCRIPTIONS_DISCOUNT_SIGN = '%';

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$options['subscr_icon_type'] = 'icon';
		$options['discount_sign']    = self::SUBSCRIPTIONS_DISCOUNT_SIGN;

		if ( ! empty( $options['product_subscription_alert_icon']['value']['url'] ) ) {
			$options['subscr_icon_type'] = 'svg';
		}
		$options['subscr_icon_class'] = $options['product_subscription_alert_icon']['value'] ?? 'icon icon-info';
		$options['subscr_svg_class']  = 'icon-img';
		if ( isset( $options ) && $options['product_subscription_alert_icon_position'] === 'right' ) {
			$options['subscr_icon_class'] .= ' order-last';
			$options['subscr_svg_class']  .= ' order-last';
		}

		if ( ! empty( $options['subscriptions'] ) ) {
			$options['price_array'] = array();
			$options['temp']        = 0;
			$options['minimal_key'] = 0;

			$minimal_key = 0;
			foreach ( $options['subscriptions'] as $key => $plan ) {
				if ( is_int( $key ) ) {
					if ( empty( $temp ) ) {
						$temp = (int) $plan['attributes']['subscription-price'];
					}
					if ( (int) $plan['attributes']['subscription-price'] < $temp ) {
						$temp        = (int) $plan['attributes']['subscription-price'];
						$minimal_key = $key;
					}
				}
			}

			if ( $options['subscriptions'][ $minimal_key ]['attributes']['discount-type'] === self::SUBSCRIPTIONS_DISCOUNT_TYPE ) {
				$options['discount_sign'] = (int) $options['subscriptions'][ $minimal_key ]['attributes']['discount-value'] . '%';
			} else {
				$options['discount_sign'] = get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $options['subscriptions'][ $minimal_key ]['attributes']['discount-value'] ) . '</span><span class="subscription-sale-currency-js">';
			}
		}

		return $options;
	}
}
