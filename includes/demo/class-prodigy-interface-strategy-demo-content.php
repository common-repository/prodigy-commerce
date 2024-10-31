<?php
namespace Prodigy\Includes\Demo;

defined( 'ABSPATH' ) || exit;

interface Prodigy_Interface_Strategy_Demo_Content {
	public function parseItem();
	public function installItem();
}
