<?php
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Catalog_Filters_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy;

defined( 'ABSPATH' ) || exit;

/**
 * Prodigy price filter data mapper
 *
 * @version    2.9.1
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Price_Filter_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $attr
	 *
	 * @return array
	 */
	public function get_default_parameters( array $attr = array() ): array {
		$query        = http_build_query( $_GET ?? array() );
		$content      = Prodigy_Request_Maker::get_instance()->do_catalog_filters_request( $query );
		$catalog_info = Prodigy_Catalog_Filters_Parser::get_catalog_info( $content );
		$catalog_info = json_decode( wp_json_encode( $catalog_info['attributes'] ?? array() ), true );
		$max_price = (int) ( $catalog_info['price-range']['max_price'] ?? 0 );
		$min_price = (int) ( $catalog_info['price-range']['min_price'] ?? 0 );

		return array(
			'min'                   => $min_price,
			'max'                   => $max_price,
			'query_min_price'       => $min_price,
			'query_max_price'       => $max_price,
			'taxonomy'              => Prodigy::get_prodigy_category_type(),
			'current_type_category' => Prodigy::get_prodigy_category_type(),
			'attr_shortcode'        => $attr,
			'shop_page'             => prodigy_get_shop_url(),
			'is_shop_page'          => ( is_prodigy_product_taxonomy() || is_page( 'shop' ) ) ? 'true' : 'false',
			'heading_price_filter'  => $attr['attr_shortcode']['price_style_heading_text'] ?? 'Price Filter',
		);
	}
}
