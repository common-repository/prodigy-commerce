<?php

/**
 * Prodigy price filter shortcode class
 *
 * @version    2.8.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Price_Filter
 */
class Prodigy_Short_Code_Price_Filter {

	/**
	 * Prodigy_Short_Code_Price_Filter constructor.
	 */
	public function __construct() {
		add_shortcode( 'prodigy_price_filter', array( $this, 'output' ) );
	}

    /**
     * @param array $params
     *
     * @return void
     */
    public function render_view( array $params ): void {
        do_action( 'prodigy_shortcode_template_price_filter', $params );
    }

	/**
	 * @param $atts
	 * @param $data
	 * @param $content
	 *
	 * @return false|string
	 */
	public function output( $atts, $data, $content = null ) {
        ob_start();
        $this->render_view( $atts );
        wp_reset_postdata();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
	}
}
