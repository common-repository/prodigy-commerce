<?php
namespace Prodigy\Includes\Frontend\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy search shortcode class
 *
 * @version    2.8.6
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Short_Code_Search {

	/**
	 * Shortcode name
	 *
	 * @var string
	 */
	const NAME = 'prodigy_search';

	public function __construct() {
		add_shortcode( 'prodigy_search', array( $this, 'output' ) );
	}

	/**
	 * Get allowed html for wp_kses()
	 *
	 * @return array[]
	 */
	public static function get_allowed_html(): array {
		return array(
			'form'   => array(
				'class' => true,
			),
			'input'  => array(
				'class'       => true,
				'type'        => true,
				'placeholder' => true,
			),
			'button' => array(
				'class'      => true,
				'aria-label' => true,
				'type'       => true,
			),
			'i'      => array(
				'class' => true,
			),
		);
	}

	/**
	 * @param string $atts
	 *
	 * @return false|string
	 */
	public function output( $atts ) {
		$defaultAts = array(
			'type' => 'normal',
		);

		$attrs = array_merge( $defaultAts, (array) $atts );

		ob_start();
		do_action( 'prodigy_shortcode_template_search', $attrs );

		return ob_get_clean();
	}
}
