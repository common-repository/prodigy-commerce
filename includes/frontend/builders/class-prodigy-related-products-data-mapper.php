<?php
/**
 * Prodigy related products data mapper
 *
 * @version    2.7.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Frontend\Builders;

use Prodigy\Includes\Content\Prodigy_Order_Parser;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\Includes\Prodigy_Content_Related_Product;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

defined( 'ABSPATH' ) || exit;

class Prodigy_Related_Products_Data_Mapper extends Prodigy_Main_Data_Mapper {

    const GRID   = 'grid';
    const SLIDER = 'slider';
    const ORDER_ASC  = 'asc';
    const ORDER_DESC = 'desc';

    const UP_SELL = 'up_sell';
    const CROSS_SELL = 'cross_sell';

    const UNLIMIT_PRODUCTS_NUMBER = -1;

    /**
     * @param array $params
     *
     * @return array
     */
    public function get_default_parameters( array $params ) :array {
        $params = $this->set_type_params( $params );
        $params = $this->set_order_params( $params );
        $params = $this->set_pagination_params( $params );
        $product_ids = $this->get_type_of_products( $params );
        $heading = apply_filters( 'prodigy_product_related_products_heading', 'Related products' );

        if ( isset( $params ) && ! empty( $params['style_image_ratio']['width'] ) && ! empty( $params['style_image_ratio']['height'] ) ) {
            $params['image_ratio'] = ( $params['style_image_ratio']['height'] / $params['style_image_ratio']['width'] ) * 100;
        }

        $params['products'] = $product_ids['data'] ?? [];
        $params['display'] = $params['display'] ?? self::SLIDER;
        $params['settings'] = $params ?? array();
        $params['image_ratio'] = Prodigy_Customizer::get_images_ratio();
        $params['sale_classname'] = 'prodigy-product-list__item-label';
        $params['heading'] = $params['style_content_heading_text'] ?? $heading ?? 'Related Products';
        $params['idWidget'] = $params['idWidget'] ?? '';
        $params['sale'] = $params['sale'] ?? '';
        $params['category'] = $params['category'] ?? true;
        $params['rating'] = $params['rating'] ?? true;
        $params['hide_arrows'] = $params['slider_hide_arrows'] ?? 'no';
        $params['placeholder_url'] = plugin_dir_url( PRODIGY_PLUGIN_PATH . 'web/admin/images/placeholder.png' ) . 'placeholder.png';

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    public function get_type_of_products( array $params ) {
        if (
            ( isset( $_GET['action'] ) && $_GET['action'] === 'elementor' )
            || ( isset( $_POST['action'] ) && $_POST['action'] === 'elementor_ajax' )
        ) {
            $up_sell_product_ids = $this->set_products_for_elementor_page( $params );
        } elseif ( is_cart() || ( isset( $_GET['order_token'] ) && ! empty( $_GET['order_token'] ) ) ) {
            $up_sell_product_ids = $this->set_products_for_cart_page( $params );
        } else {
            if ( isset( $_GET['pg'] ) && ! empty( $_GET['pg'] ) ) {
                $params['pg'] = sanitize_key( wp_unslash( $_GET['pg'] ) );
            }
            $up_sell_product_ids = $this->get_related_products( $params );
        }

        return $up_sell_product_ids;
    }

    /**
     * @param array $params
     * @return array
     */
    public function set_type_params( array $params ) {
        $params['type'] = $params['type'] ?? 'up-sell';

        if ( isset( $params['type'] ) ) {
            $params['type'] = $this->mappingTypeParams( $params['type'] );
        }

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    public function get_related_products( array $params ) {
        if (isset($GLOBALS['prodigy_product'])) {
            $products = [$GLOBALS['prodigy_product']->get_remote_product_id()];
        } else {
	        $products = $this->get_products_ids( Prodigy_Product_Parser::get_random_products( self::UNLIMIT_PRODUCTS_NUMBER ) );
        }

        $related_products_obj = new Prodigy_Content_Related_Product();
        $up_sell_product_obj  = $related_products_obj->get_related_product( $products , $params );

        return get_format_related_products( $up_sell_product_obj['data'] ?? [] );
    }

    /**
     * @param array $products
     * @return array
     */
    public function get_products_ids( array $products ) {
        $ids = [];
        if (is_array( $products )) {
            foreach ( $products as $key => $product ) {
                $ids[$key] = get_post_meta( $product->ID, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );
            }
        }

        return $ids;
    }

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public function set_products_for_elementor_page( array $params ): array {
		$products             = Prodigy_Product_Parser::get_random_products();
		$remote_ids           = array_map(
			function ( $e ) {
				return get_post_meta( $e->ID, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );
			},
			$products ?? []
		);
		$related_products_obj = new Prodigy_Content_Related_Product();
		$relatedParams        = $related_products_obj->get_related_products_id_url_params( $remote_ids );
		$paramsUrl            = $related_products_obj->get_url_params( $params );
		$up_sell_product_obj  = Prodigy_Request_Maker::get_instance()->do_products_request( $relatedParams . $paramsUrl );

		return get_format_related_products( $up_sell_product_obj['data'] );
	}

    /**
     * @param array $params
     * @return array
     */
    public function set_products_for_cart_page( array $params ): array {
        if ( is_cart() ) {
            $cart        = new Prodigy_Cart();
            $order_token = $cart->get_token_for_current_order( sanitize_text_field( wp_unslash( $_COOKIE[ Prodigy_Cart::CART_COOKIE_NAME ] ?? '' ) ) );
        } else {
            $order_token = sanitize_key( $_GET['order_token'] );
        }

	    $product_ids = array();
        if ( $order_token ) {
			$order_data        = Prodigy_Request_Maker::get_instance()->do_order_request( $order_token );
			$remote_order_info = new Prodigy_Order_Parser( $order_data );

			switch ( $params['type'] ) {
				case self::UP_SELL:
					$product_ids = $remote_order_info->get_up_sell_products();
					break;
				case self::CROSS_SELL:
					$product_ids = $remote_order_info->get_cross_sell_products();
					break;
				default:
					$up_sell_product_ids    = $remote_order_info->get_up_sell_products();
					$cross_sell_product_ids = $remote_order_info->get_cross_sell_products();
					$product_ids            = array_merge( $up_sell_product_ids, $cross_sell_product_ids );
					break;
			}
		}

        if ( $params['size'] && count( $product_ids ) > $params['size'] ) {
            $product_ids = array_slice( $product_ids, 0, $params['size'] );
        }

        return get_format_related_products( $product_ids );
    }

    /**
     * @param array $params
     * @return array
     */
    public function set_order_params( array $params ) {
        if ( isset( $params['orderby'] ) ) {
            $order = '';
            if ( isset( $params['order'] ) && $params['order'] == self::ORDER_DESC ) {
                $order = '-';
            }
            $params['sort'] = $order . $this->mappingOrderParams( $params['orderby'] );
        }

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    public function set_pagination_params( array $params ) {
        $display = $params['display'] ?? self::SLIDER;

        $params['size'] = '';
        if ( isset( $params['limit'] ) && $params['limit'] > 0 && $display == self::SLIDER ) {
            $params['size'] = $params['limit'];
        } elseif ( $display == self::GRID ) {
            $params['size'] = $params['content_archive_products_content_items_number'];
        } else {
            $params['size'] = '';
        }

        $params['pg'] = sanitize_key( wp_unslash( $_GET['pg'] ?? 1 ) );

        if ( isset( $params['display'] ) && $params['display'] === self::GRID ) {
            $query = build_query( $_GET ?? '' );
            if ( isset( $up_sell_product_ids['products-count'] ) ) {
                $total_count = $up_sell_product_ids['products-count'];
            } else {
                $total_count = 0;
            }

            $base_url             = remove_query_arg( 'pg', wp_unslash( $_SERVER['HTTP_REFERER'] ?? '' ) );
            $params['pagination'] = array(
                'pages' => ! empty( $catalog_info ) ? Prodigy_Pagination::calculate_count_pages( (int) $catalog_info['products-count'], $params['content_archive_products_content_items_number'] ) : 1,
                'url'   => $base_url,
                'page'  => Prodigy_Pagination::get_current_page( (array) $query ),
                'page_number' => $_GET['pg'] ?? 1,
            );
        }

        return $params;
    }

    /**
     * @param string $order
     * @return string
     */
    public function mappingOrderParams( string $order ) {
        $hsParams = array(
            'id'         => 'id',
            'created_at' => 'created_at',
            'date'       => 'created_at',
            'title'      => 'name',
            'rating'     => 'rating',
            'price'      => 'price',
        );

        return $hsParams[$order];
    }

    /**
     * @param string $type
     * @return string
     */
    public function mappingTypeParams( string $type ) {
        $hsParams = array(
            "cross-sell" => self::CROSS_SELL,
            "up-sell"    => self::UP_SELL,
            "both"       => "",
        );

        return $hsParams[$type];
    }


}