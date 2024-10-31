<?php
namespace Prodigy\Includes\Demo;

use Prodigy\Includes\Demo\Exception\Prodigy_Not_Found_Type_Exception;

defined( 'ABSPATH' ) || exit;


class Prodigy_Factory_Demo_Content {

	/**
	 * @param string $type
	 *
	 * @return Prodigy_Interface_Strategy_Demo_Content
	 * @throws Prodigy_Not_Found_Type_Exception
	 */
	public static function create( string $type ) {
		if ( $type == Prodigy_Default_Content::ITEM_NAME_DEMO_CONTENT_PRODUCT ) {
			return new Prodigy_Install_Demo_Content_Product();
		} else {
			throw new Prodigy_Not_Found_Type_Exception();
		}
	}

}
