<?php
namespace Prodigy\Includes\Frontend\Shortcodes;

/**
 * Prodigy common shortcode class
 *
 * @version    2.8.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Active_Filters
 */
class Prodigy_Short_Code_Active_Filter {

	public function __construct() {
		add_shortcode( 'prodigy_active_filter', array( $this, 'output' ) );
	}

    /**
     * @param array $params
     *
     * @return void
     */
    public function render_view( array $params ): void {
        do_action('prodigy_shortcode_template_active_filters', $params);
    }


	/**
	 * @param $atts
	 * @param $data
	 * @param $content
	 *
	 * @return false|string
	 */

	public function output( $atts, $data = [], $content = null ) {
        $attr['data'] = $data;
		ob_start();
		$this->render_view($attr);
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
