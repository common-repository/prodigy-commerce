<?php
namespace Prodigy\Includes\Demo\Exception;

defined( 'ABSPATH' ) || exit;

class Prodigy_Not_Found_Demo_Content_Exception extends Prodigy_Demo_Content_Exception {
	protected $message = 'The demo content is not found for installation';
}
