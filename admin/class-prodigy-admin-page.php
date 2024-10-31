<?php

namespace Prodigy\Admin;

use Prodigy\Includes\Content\Prodigy_Api_Client;

/**
 * Prodigy admin products class
 *
 * @version 2.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Page {

	const COUNT_ITEMS_ON_PAGE = 20;

	/**
	 * @var object|Prodigy_Api_Client
	 */
	public $api_client;

	/** @var object Prodigy_Product_Parser */
	public $product;

	/**
	 * Prodigy admin construct
	 */
	public function __construct() {
		$this->api_client = new Prodigy_Api_Client();
	}
}
