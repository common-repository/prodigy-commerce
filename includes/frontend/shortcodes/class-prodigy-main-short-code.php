<?php
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Prodigy_Cache;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Main_Short_Code
 */
class Prodigy_Main_Short_Code {

	public $api_client;
	public $cache;

	public $bool_mapper = array(
		'true'  => true,
		'false' => false,
		'1'     => true,
		'0'     => false,
		''      => false,
		'yes'   => true,
		true    => true,
	);

	/**
	 * Prodigy_Main_Short_Code constructor.
	 */
	public function __construct() {
		$this->api_client = new Prodigy_Api_Client();
		$this->cache      = new Prodigy_Cache();
	}
}
