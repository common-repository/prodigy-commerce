<?php
namespace Prodigy\Includes\Demo\Exception;

defined( 'ABSPATH' ) || exit;

class Prodigy_Not_Found_Type_Exception extends Prodigy_Demo_Content_Exception {
	protected $message = 'Wrong demo item type passed.';
}
