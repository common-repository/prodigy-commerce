<?php

namespace Prodigy\Includes\Content;

/**
 * Prodigy content catalog products
 *
 * @version    2.8.9
 */
class Prodigy_Catalog_Products_Parser extends Prodigy_Main_Content {

	/**
	 * @param array $content
	 *
	 * @return array
	 */
	public static function get_products( array $content ): array {
		$products = array();
		if ( isset( $content['data'] ) ) {
			foreach ( $content['data'] as $key => $item ) {
				$products[ $key ] = $item;
			}
		}

		return $products;
	}
}
