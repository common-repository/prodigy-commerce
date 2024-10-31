<?php

/**
 * Prodigy shortcode class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes\Frontend\Shortcodes\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Thank_You
 */
class Prodigy_Short_Code_Thank_You {

	public function __construct() {
		add_shortcode( 'prodigy_thank_you_page', array( $this, 'output' ) );
	}

	/**
	 * @param array $atts
	 * @param null $content
	 * @param string $name
	 *
	 * @return string
	 */
	public function output( $atts, $name, $content = null ) {
		global $wp_session;

		ob_start();
		do_action( 'prodigy_shortcode_template_thank_you', [] );
		$content = ob_get_contents();
		ob_end_clean();

		/**
		 * clear token while show empty thank page
		 */
		unset( $wp_session['order_token'] );

		return $content;
	}
}
