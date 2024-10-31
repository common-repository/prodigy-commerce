<?php
namespace Prodigy\Includes\Demo;

use Prodigy\Includes\Demo\Exception\Prodigy_Not_Found_Demo_Content_Exception;

defined( 'ABSPATH' ) || exit;


abstract class Prodigy_Abstract_Demo_Content implements Prodigy_Interface_Strategy_Demo_Content {

	/**
	 * @var array
	 */
	private $parse_demo_content = array();

	/**
	 * @throws Prodigy_Not_Found_Demo_Content_Exception
	 */
	public function isEmptyStack() {
		if ( empty( $this->parse_demo_content ) && is_array( $this->parse_demo_content ) ) {
			throw new Prodigy_Not_Found_Demo_Content_Exception();
		}
	}

	/**
	 * @return array
	 */
	public function getParsedDemoContent() {
		return $this->parse_demo_content;
	}

	/**
	 * @param $content
	 */
	public function setParsedDemoContent( $content ) {
		$this->parse_demo_content = $content;
	}


}
