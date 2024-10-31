<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Content\Prodigy_Main_Content;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Main_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Products_Data_Mapper;

defined( 'ABSPATH' ) || exit;
/**
 * Class RemoteProduct
 *
 * @version 2.0.0
 */
class Prodigy_Content_Related_Product extends Prodigy_Main_Content {

	/**
	 * @var $obj
	 */
	private $obj;

	/** @var object Prodigy_Cache $cache */
	public $cache;

	/**
	 * Product constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->cache = new Prodigy_Cache();
	}

    /**
     * @param array $products
     *
     * @return string
     */
	public function get_related_products_id_url_params( array $products = array() ): string {
		if ( count( $products ) === 1 ) {
			return 'product_ids[]=' . $products[0];
		}

		if ( empty( $products ) ) {
			return '';
		}

		return 'product_ids[]=' . implode( '&product_ids[]=', $products );
	}

    /**
     * @param array $params
     * @return string
     */
	public function get_url_params( array $params = array() ): string {
		$strUrl = '';

		if ( ! empty( $params['type'] ) ) {
            if ($params['type'] === 'both') {
                $strUrl .= '&filters[][name]=bond_type&filters[][value]=cross_sell,up_sell';
            } else {
                $strUrl .= '&filters[][name]=bond_type&filters[][value]=' . $params['type'];
            }
		}

        if ( isset( $params['orderby'] ) ) {
            $sort = Prodigy_Main_Data_Mapper::mapping_sort_params( $params['orderby'] );

            if ( isset( $params['order'] ) ) {
                if ( strtolower( $params['order'] ) === strtolower( Prodigy_Products_Data_Mapper::DESCENDING_SORT ) ) {
                    $sort = '-' . $sort;
                }
            }

            $strUrl .= '&sort=' . $sort;
        }

		if ( ! empty( $params['size'] ) ) {
			$strUrl .= '&page[size]=' . $params['size'];
		}

		if ( ! empty( $params['pg'] ) ) {
			$strUrl .= '&page[number]=' . (int) $params['pg'];
		} else {
			$strUrl .= '&page[number]=1';
		}

		return $strUrl;
	}

	/**
	 * @param array $products
	 * @param array $params
	 *
	 * @return array
	 */
	public function get_related_product( array $products = array(), array $params = array() ) {
		$cache_key = md5( wp_json_encode( array_merge( $products, array( $params['type'] ) ) ) );
		$relatedParams = $this->get_related_products_id_url_params( $products );
		$paramsUrl     = $this->get_url_params( $params );

		return Prodigy_Request_Maker::get_instance()->do_related_products_request( $relatedParams . $paramsUrl, $cache_key );
	}

	/**
	 * @param array $products
	 *
	 * @return string
	 */
	public function get_key( array $products = array() ): string {
		if ( empty( $products ) ) {
			return hash( 'sha256', 'all' );
		}

		return hash( 'sha256', implode( '', $products ) );
	}

}
