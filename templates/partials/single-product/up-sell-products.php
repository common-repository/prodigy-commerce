<?php

use Prodigy\Includes\Helpers\Enums\Prodigy_Enums;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cart;
use Prodigy\Includes\Prodigy_Content_Order;
use Prodigy\Includes\Prodigy_Content_Related_Product;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Prodigy_Product;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $settings['type'] ) ) {
	$type = $settings['type'];
}

$type    = $settings['type'] ?? 'up-sell';
$display = $settings['display'] ?? 'slider';

$params = array();
if ( isset( $type ) ) {
	$params['type'] = mappingTypeParams( $type );
}
if ( isset( $settings['orderby'] ) ) {
	$order = '';
	if ( isset( $settings['order'] ) && $settings['order'] == 'desc' ) {
		$order = '-';
	}
	$params['sort'] = $order . mappingOrderParams( $settings['orderby'] );
}

if ( isset( $settings['columns'], $settings['rows'] ) ) {
	$c_lg = $settings['columns'] ?? Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS;
	$c_md = $settings['columns_tablet'] ?? Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_TABLET;
	$c_sm = $settings['columns_mobile'] ?? Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_MOBILE;
	$r_lg = $settings['rows'] ?? 1;
	$r_md = $settings['rows_tablet'] ?? 1;
	$r_sm = $settings['rows_mobile'] ?? 1;

	$c                    = max( array( $c_lg, $c_md, $c_sm ) );
	$r                    = max( array( $r_lg, $r_md, $r_sm ) );
	$count_items_per_page = $c * $r;
} else {
	$count_items_per_page = 4;
}

$params['size'] = '';
if ( isset( $settings['limit'] ) && $settings['limit'] > 0 && $display == 'slider' ) {
	$params['size'] = $settings['limit'];
} elseif ( $display == 'grid' ) {
	$params['size'] = $count_items_per_page;
} else {
	$params['size'] = '';
}

$params['pg'] = sanitize_key( wp_unslash( $_GET['pg'] ?? 1 ) );

if (
	( isset( $_GET['action'] ) && $_GET['action'] === 'elementor' )
	|| ( isset( $_POST['action'] ) && $_POST['action'] === 'elementor_ajax' )
) {
	$products             = Prodigy_Product::get_random_products();
	$remote_ids           = array_map(
		function ( $e ) {
			return get_post_meta( $e->ID, Prodigy::PRODIGY_REMOTE_PRODUCT_ID, true );
		},
		$products ?? []
	);
	$related_products_obj = new Prodigy_Content_Related_Product();
	$up_sell_product_obj  = $related_products_obj->getRemoteProducts( $remote_ids ?? [], $params );
	$up_sell_product_ids  = get_format_related_products( $up_sell_product_obj->data );

} elseif ( is_cart() || ( isset( $_GET['order_token'] ) && ! empty( $_GET['order_token'] ) ) ) {
	if ( is_cart() ) {
		$cart        = new Prodigy_Cart();
		$order_token = $cart->get_token_for_current_order( sanitize_text_field( wp_unslash( $_COOKIE['wp-prodigy_user'] ?? '' ) ) );
	} else {
		$order_token = sanitize_key( $_GET['order_token'] );
	}

	$remote_order_info = new Prodigy_Content_Order();
	if ( $order_token ) {
		$remote_order_info->initOrder( $order_token );
	}
	$product_ids = array();
	switch ( $params['type'] ) {
		case 'up_sell':
			$product_ids = $remote_order_info->getUpSellProducts();

			break;
		case 'cross_sell':
			$product_ids = $remote_order_info->getCrossSellProducts();
			break;
		default:
			$up_sell_product_ids    = $remote_order_info->getUpSellProducts();
			$cross_sell_product_ids = $remote_order_info->getCrossSellProducts();
			$product_ids            = array_merge( $up_sell_product_ids, $cross_sell_product_ids );
			$ids                    = array();
			foreach ( $product_ids as $k => $product ) {
				if ( ! in_array( $product->id, $ids ) ) {
					$ids[] = $product->id;
				} else {
					unset( $product_ids[ $k ] );
				}
			}
			break;
	}

	if ( $params['size'] && count( $product_ids ) > $params['size'] ) {
		$product_ids = array_slice( $product_ids, 0, $params['size'] );
	}

	$up_sell_product_ids = get_format_related_products( $product_ids );
} else {
	if ( isset( $_GET['pg'] ) && ! empty( $_GET['pg'] ) ) {
		$params['pg'] = sanitize_key( wp_unslash( $_GET['pg'] ) );
	}

	$product              = $GLOBALS['prodigy_product'] ?? get_prodigy_product( Prodigy_Product::get_random_product() );
	$related_products_obj = new Prodigy_Content_Related_Product();
	$up_sell_product_obj  = $related_products_obj->getRelatedProduct( array( $product->get_remote_product_id() ), $params );
	$up_sell_product_ids  = get_format_related_products( $up_sell_product_obj->data );
}

$heading = apply_filters( 'prodigy_product_related_products_heading', 'Related products' );
$heading = $settings['style_content_heading_text'] ?? $heading ?? 'Related Products';

if ( isset( $settings['display'] ) && $settings['display'] === 'grid' ) {
	$query = build_query( $_GET ?? '' );
	if ( isset( $up_sell_product_obj->meta->products_total_count ) ) {
		$total_count = $up_sell_product_obj->meta->products_total_count;
	} else {
		$total_count = 0;
	}

	$base_url             = remove_query_arg( 'pg', wp_unslash( $_SERVER['HTTP_REFERER'] ?? '' ) );
	$params['pagination'] = array(
		'pages' => ! empty( $up_sell_product_ids['data'] ) ? Prodigy_Pagination::calculate_count_pages( (int) $total_count, (int) $count_items_per_page ) : 1,
		'url'   => $base_url,
		'page'  => Prodigy_Pagination::get_current_page( $query ),
	);
}

?>

<?php
if ( isset( $up_sell_product_ids['data'] ) && ! empty( $up_sell_product_ids['data'] ) ) :
	?>
	<h3 class="prodigy-related__products-title">
		<?php if ( $heading ) : ?>
			<?php echo esc_html( $heading ); ?>
		<?php endif; ?>
	</h3>
	<?php
		$params['display']  = $display;
		$params['products'] = $up_sell_product_ids['data'];
		$params['settings'] = $settings ?? array();
		do_action( 'prodigy_shortcode_template_products', $params );
	?>
<?php endif; ?>
