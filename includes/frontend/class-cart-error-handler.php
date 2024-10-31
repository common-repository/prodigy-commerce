<?php

namespace Prodigy\Includes\Frontend;

/**
 * Class error handler
 *
 * @version    2.9.2
 */
class Cart_Error_Handler {
	const ERROR_ORDER_NOT_UPDATED = 'E_0003';

	const ERROR_SEND_PRODUCT_TO_API = 'E_0005';

	const ERROR_CART_RESPONSE_EMPTY = 'E_0006';

	const ERROR_SET_ORDER = 'E_0007';

	const ERROR_ADD_ITEM_TO_ORDER = 'E_0008';

	const ERROR_DELETE_ITEM_FROM_DB = 'E_0010';
	const ERROR_CART_NOT_RESET = 'E_0012';

	const ERROR_INIT_ORDER_ERROR = 'E_0014';

	const ERROR_API_ORDER_NOT_DELETED = 'E_0015';
	const ERROR_TYPE_DEFAULT = 'error';
	const ERROR_TYPE_HOSTED_SYSTEM = 'hosted_system_error';
	const ERROR_TYPE_DB = 'db_error';

	/**
	 * @param string $error_message
	 * @param string $error_type
	 *
	 */
	public function log_error( string $error_message, string $error_type = self::ERROR_TYPE_DEFAULT ) {
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $error_message, $error_type );
		}
	}

	/**
	 * @param string $error_code
	 *
	 * @return string
	 */
	public  function get_error_message_for_response( string $error_code ): string {
		return 'Something went wrong, please try again later.<br/> Error code: ' . $error_code;
	}
}