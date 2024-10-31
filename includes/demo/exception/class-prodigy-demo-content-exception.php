<?php
namespace Prodigy\Includes\Demo\Exception;

use Exception;

defined( 'ABSPATH' ) || exit;

class Prodigy_Demo_Content_Exception extends Exception {
	protected $message = 'Error installing Products and Home Page, please click ‘Continue’ again or skip this step and finish later.';
}
