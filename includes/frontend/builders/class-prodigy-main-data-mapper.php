<?php
namespace Prodigy\Includes\Frontend\Builders;

defined( 'ABSPATH' ) || exit;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Cart;

abstract class Prodigy_Main_Data_Mapper {

	/** @var Prodigy_Api_Client  */
	public $api_client;

	/** @var Prodigy_Cache  */
	public $cache;

	public $user_cookie;

	public function __construct() {
		$this->api_client = new Prodigy_Api_Client();
		$this->cache = new Prodigy_Cache();
		$this->user_cookie = sanitize_text_field( wp_unslash( $_COOKIE[Prodigy_Cart::CART_COOKIE_NAME] ?? null ) );
	}

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	abstract function get_default_parameters( array $options ) :array;

	/**
	 * @param string $sort
	 *
	 * @return string
	 */
	public static function mapping_sort_params( $sort ) {

		switch ( $sort ) {
			case 'id':
				return 'id';
			case 'title':
				return 'name';
			case 'price':
				return 'price';
			case 'date':
				return 'created_at';
			case 'rating':
				return 'rating';
			case 'in_stock':
				return 'In stock';
			case 'out_of_stock':
				return 'Out of stock';
		}
	}

	public function construct() {
	}
}