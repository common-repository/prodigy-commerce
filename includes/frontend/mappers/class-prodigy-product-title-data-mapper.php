<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

/**
 * Prodigy product title data mapper
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Product_Title_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 * @throws \DOMException
	 */
	public function get_default_parameters( array $options ): array {
		$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
		$product          = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );
		$content          = '';
		if ( isset( $options['title'] ) ) {
			$content = ! empty( $product ) ? $product->get_remote_title() : $options['title'];
		} elseif ( ! empty( $product ) ) {
			$content = $product->get_remote_title();
		}
		$html_tag = $options['content_title_html_tag'] ?? 'h3';

		$dom        = new \DOMDocument( '1.0' );
		$tagElement = $dom->createElement( $html_tag, htmlentities( $content ) );
		$tagElement->setAttribute( 'class', 'prodigy-product__name' );
		$dom->appendChild( $tagElement );

		return array( 'dom' => $dom );
	}
}
