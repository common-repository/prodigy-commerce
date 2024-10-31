<?php
namespace Prodigy\Includes\Demo\Exception;

defined( 'ABSPATH' ) || exit;

class Prodigy_File_Parsing_Error_Demo_Content_Exception extends Prodigy_Demo_Content_Exception {
	protected $message = 'The demo content is not parsed for installation';
}
