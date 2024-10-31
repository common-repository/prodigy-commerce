<?php
namespace Prodigy\Includes\Demo;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Default_Content
 *
 * @package Prodigy\Includes\Demo
 */
class Prodigy_Default_Content {

	const ITEM_NAME_DEMO_CONTENT_PRODUCT = 'products';

	private static $defaultItems = array(
		self::ITEM_NAME_DEMO_CONTENT_PRODUCT => array(
			'description' => 'This will create default Products as seen in the demo',
			'item'        => 'Products',
			'installed'   => false,
		),

	);

	public function __construct() {
	}

	/**
	 * Get default items
	 *
	 * @return array
	 */
	public static function getDefaultItems(): array {
		return self::$defaultItems;
	}
}
