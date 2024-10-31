<?php
/**
 * Prodigy shortcode class
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
 * Class Prodigy_Short_Code_Attributes_Filter
 */
class Prodigy_Short_Code_Attributes_Filter {

	public function __construct() {
		add_shortcode( 'prodigy_attributes_filter', array( $this, 'output' ) );
	}

    /**
     * @param $attr
     * @param null $content
     *
     * @return string
     */
    public function output( $attr, $content = null ) {
        ob_start();
        $this->render_view( $attr );
        wp_reset_postdata();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function render_view( array $params ): void {
        do_action( 'prodigy_shortcode_template_attributes_filter_layout', $params );
    }

}
