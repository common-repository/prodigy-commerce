<?php

/**
 * Prodigy related products shortcode class
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Shortcodes;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Content_Related_Product;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Short_Code_Related_Products
 */
class Prodigy_Short_Code_Related_Products {

	const GRID   = 'grid';
	const SLIDER = 'slider';

	/**
	 * Prodigy_Short_Code_Related_Products constructor.
	 */
	public function __construct() {
		add_shortcode( 'prodigy_related_products', array( $this, 'output' ) );
	}

	/**
	 * @param string $atts
	 * @param null   $content
	 *
	 * @return string
	 */
	function output( $atts, $content = null ) {
        $params = array();
        if ( ! Prodigy_Template::is_cart() ) {
            $atts = shortcode_atts(
                array(
                    'product_ids'   => '',
                    'product_names' => '',
                    /** cross-sell, up-sell */
                    'type'          => 'up-sell',
                    'limit'         => '-1',
                    /** id, title, price, date, rating */
                    'orderby'       => 'date',
                    'order'         => 'DESC',
                    'columns'       => '4',
                    /** slider, grid */
                    'display'       => 'slider',
                ),
                $atts,
                'products'
            );

            if ( ! empty( $atts['product_names'] ) ) {
                $product_ids_by_names = prodigy_get_images_id_by_title(
                    $atts['product_names'],
                    Prodigy::get_prodigy_product_type()
                );
            }

            if ( ! empty( $product_ids_by_names ) && is_array( $product_ids_by_names ) ) {
                $product_ids = implode( ',', $product_ids_by_names );
                $atts['product_ids'] = $product_ids;
            }

            if ( ! empty( $atts['product_ids'] ) ) {
                $list_ids = explode( ',', $atts['product_ids'] );
            } else {
                return '';
            }

            $products = $this->get_products_by_type( $list_ids, $atts );
            $placeholder_url = plugin_dir_url( PRODIGY_PLUGIN_PATH . 'web/admin/images/placeholder.png' ) . 'placeholder.png';

            $params = array(
                'display'         => $atts['display'],
                'columns'         => $atts['columns'] ?? false,
                'products'        => $products,
                'placeholder_url' => $placeholder_url,
            );
        }

		ob_start();
		do_action( 'prodigy_shortcode_related_products', $params );
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * @param $list_ids
	 * @param $type
	 *
	 * @return array
	 */
	public function get_products_by_type( $list_ids, $params ) {
        if ( ! empty( $list_ids ) ) {
            $product_ids = $this->get_related_products( $list_ids, $params );
        } else {
            $product_ids = $this->get_related_products( array( Prodigy_Product_Template_Builder::get_random_product() ), $params );
        }

		return $product_ids;
	}


    /**
     * @param array $product_ids
     * @param array $params
     * @return array
     */
    public function get_related_products( array $product_ids, array $params ): array {
	    return ( new Prodigy_Content_Related_Product() )->get_related_product( $product_ids, $params );
    }
}
