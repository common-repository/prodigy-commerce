<?php
namespace Prodigy\Includes;

defined( 'ABSPATH' ) || exit;

class Prodigy_Mapper_Product {
	/**
	 * @var $remote_product
	 */
	private $remote_product;

	/**
	 * constructor MapperRemoteProduct
	 */
	public function __constructor() {
		$this->remote_product = Prodigy_Content_Product::getInstance();
	}
}
