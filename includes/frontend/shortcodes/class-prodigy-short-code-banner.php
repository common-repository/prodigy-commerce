<?php

/**
 * Prodigy banner shortcode class
 *
 * @version    2.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Prodigy_Short_Code_Banner
 *
 * @package Prodigy\Includes\Frontend\Shortcodes
 */
class Prodigy_Short_Code_Banner {

	/**
	 * Prodigy_Short_Code_Banner constructor.
	 */
	public function __construct() {
		add_shortcode( 'prodigy_banner', array( $this, 'output' ) );
	}


	/**
	 * @param string $atts
	 * @param null   $content
	 *
	 * @return string
	 */
	function output( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'image_id'      => '',
					'default_image' => 'https://prodigycommerce-wp-demo-content.s3.us-east-2.amazonaws.com/Banner/image.webp',
					'buttons'       => 'SHOP MEN, SHOP WOMEN, SHOP ALL',
					'buttons_links' => array(
						'/' . Prodigy::get_prodigy_category_type() . '/men',
						'/' . Prodigy::get_prodigy_category_type() . '/women',
						'/' . Prodigy_Page::prodigy_get_shop_url(),
					),
					'title'         => '',
					'main_text'     => '',
				),
				$atts
			)
		);

		$image = wp_get_attachment_image_url( $image_id );

		if ( ! empty( $buttons ) ) {
			$buttons = explode( ',', $buttons );
		}

		ob_start();

		$params = array(
			'image'         => ! empty( $image ) ? $image : $default_image,
			'buttons'       => $buttons,
			'buttons_links' => $buttons_links,
			'title'         => ! empty( $title ) ? $title : '',
			'main_text'     => ! empty( $main_text ) ? $main_text : '',
		);

		do_action( 'prodigy_shortcode_template_banner', $params );

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}
