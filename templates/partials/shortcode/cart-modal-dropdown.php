<?php
/* Template Name: Cart shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$elementor_conditions        = get_option( 'elementor_pro_theme_builder_conditions' );
$is_life_preview             = isset( $elementor_options );
$has_elementor_template      = ! empty( $elementor_conditions['archive'] );

// for prodigy theme
if ( isset( wp_get_sidebars_widgets()['prodigy_left_sidebar'] ) && is_array( wp_get_sidebars_widgets()['prodigy_left_sidebar'] ) ) {
	$widget = ! is_numeric(
		array_search( 'cart_prodigy_widget-2', wp_get_sidebars_widgets()['prodigy_left_sidebar'], false )
	);
}

$total_price = 0;

$customizer_general_options = get_option( 'prodigy_general_options' );

$cart_icon_type = 'icon';
if ( ! empty( $attr_shortcode['cart_content_icon_url'] ) ) {
	$cart_icon_type = 'svg';
}
$cart_icon_class = $attr_shortcode['cart_content_icon_value'] ?? 'icon icon-cart';
$cart_svg_class  = 'icon-img';
if ( $attr_shortcode['cart_content_icon_position'] === 'left' ) {
	$cart_icon_class .= ' order-first';
	$cart_svg_class  .= ' order-first';
}

$count_classname = 'prodigy-navbar-cart__count';
if ( $attr_shortcode['cart_style_indicator_position_vertical'] === 'bottom' ) {
	$count_classname .= ' prodigy-navbar-cart__count--bottom';
}
if ( $attr_shortcode['cart_style_indicator_position_horizontal'] === 'left' ) {
	$count_classname .= ' prodigy-navbar-cart__count--left';
}

$heading_text    = $attr_shortcode['cart_style_heading_text'] ?? 'Shopping Cart';
$empty_cart_text = $attr_shortcode['cart_style_empty_text'] ?? 'No products added yet';

$container_class = 'prodigy-cart-dropdown__container';
if ( $attr_shortcode['cart_content_gen_alignment'] === 'start' ) {
	$container_class .= ' prodigy-cart-dropdown__container--left';
}
if ( $attr_shortcode['cart_content_gen_alignment'] === 'center' ) {
	$container_class .= ' prodigy-cart-dropdown__container--center';
}

$cart_widget_option = $customizer_general_options['prodigy_enable_cart_widget'] ?? false;

if ( $cart_widget_option || ! empty( $attr_shortcode['idwidget'] ) ) :
	?>
<div class="prodigy-cart-dropdown__wrap prodigy-custom-template">
	<div class="prodigy-cart-dropdown prodigy-cart-dropdown-js" data-auto-open="<?php echo esc_attr( $attr_shortcode['cart_content_gen_auto_open'] ); ?>">
		<button class="prodigy-cart__toggle prodigy-cart-dropdown__toggle">
			<span class="prodigy-navbar-cart__txt"><?php esc_attr_e( 'Cart', 'prodigy' ); ?></span>
			<?php if ( $cart_icon_type === 'icon' ) : ?>
				<?php if ( ! empty( $cart_icon_class ) ) : ?>
					<i class="<?php echo esc_attr( $cart_icon_class ); ?> prodigy-navbar-cart__icon"></i>
				<?php endif; ?>
			<?php elseif ( $cart_icon_type === 'svg' ) : ?>
				<img class="<?php echo esc_attr( $cart_svg_class ); ?>" src="<?php echo esc_attr( $attr_shortcode['cart_content_icon_url'] ); ?>" alt="">
			<?php endif; ?>
			<?php if ( $attr_shortcode['cart_content_icon_items_indicator'] === 'yes' ) : ?>
				<span class="<?php echo esc_attr( $count_classname ); ?> cart-count-js" style="display: none" data-hide-empty="<?php echo esc_attr( $attr_shortcode['cart_content_icon_hide_empty'] ); ?>">0</span>
			<?php endif; ?>
		</button>

		<div class="<?php echo $container_class; ?>">
			<div class="prodigy-cart-dropdown__main">
				<div class="prodigy-cart__head">
					<div class="d-flex align-items-center pl-16 pr-16">
						<div class="flex-1 pr-16">
							<div class="prodigy-cart-dropdown__title"><?php echo esc_attr( $heading_text ); ?></div>
						</div>
						<button class="prodigy-cart__close prodigy-cart-dropdown__close" type="button">
							<i class="icon icon-close"></i>
						</button>
					</div>
				</div>
				<div class="prodigy-cart__body">
					<div class="prodigy-cart-dropdown__alert widget-cart-add-item-message-js" style="display: none">
						<div class="d-flex align-items-center">
							<i class="icon icon-check font-20 in-green-100 mr-8"></i>
							<span class="prodigy-cart-dropdown__alert-txt"><?php esc_attr_e( 'has been added to your cart.', 'prodigy' ); ?></span>
						</div>
					</div>
					<div class="prodigy-cart-dropdown__alert widget-cart-remove-item-message-js" style="display: none">
						<div class="d-flex align-items-center">
							<i class="icon icon-check font-20 in-green-100 mr-8"></i>
							<span class="prodigy-cart-dropdown__alert-txt"><?php esc_attr_e( 'has been removed from your cart.', 'prodigy' ); ?></span>
						</div>
					</div>
					<div class="prodigy-cart-dropdown__alert widget-cart-message-error-js mb-20 prodigy-cart-dropdown__alert--default mt-16" style="display: <?php echo esc_attr( $is_deleted_product ) ? 'flex' : 'none'; ?>"
					>
						<i class="icon icon-error mr-8"></i>
						<span class="prodigy-cart-dropdown__alert-txt">One or more items are no longer available and were removed from your cart</span>
					</div>
					<div class="prodigy-cart-dropdown__alert widget-cart-empty-cart-message-js" style="display: <?php echo empty( $cart_products ) ? 'flex' : 'none'; ?>"
					>
						<i class="icon icon-info font-20 mr-8"></i>
						<span class="prodigy-cart-dropdown__alert-txt"><?php echo esc_attr( $empty_cart_text ); ?></span>
					</div>

					<?php
					prodigy_get_template(
						'cart_items.php',
						array(
							'cart_products' => $cart_products,
							'is_dropdown'   => $is_dropdown,
							'total_price'   => $total_price,
						)
					);
					?>

					<div class="prodigy-cart-total widget-cart-subtotal-js" style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>;">
						<span class="prodigy-cart-total__text">
							<?php esc_attr_e( 'Subtotal:', 'prodigy' ); ?>
						</span>
						<span class="prodigy-cart-total__value widget-subtotal-price-js">
							$<?php echo esc_attr( prodigy_price_format( $total_price ) ); ?>
						</span>
					</div>
				</div>
				<div class="prodigy-cart__footer widget-cart-checkout-block-js" style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>;">
					<a class="prodigy-main-button prodigy-main-button--outline prodigy-cart__cart-btn" href="<?php echo esc_url( prodigy_get_cart_url() ); ?>">
						<?php esc_attr_e( 'View cart', 'prodigy' ); ?>
					</a>
					<a class="prodigy-main-button prodigy-cart__checkout-btn checkout-url-js" href="<?php echo esc_url( $proceed_url ); ?>">
						<?php esc_attr_e( 'Checkout', 'prodigy' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if (!$is_life_preview || !$has_elementor_template):  ?>
<script
		src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/cart-widget.js' ) ) . 'cart-widget.js'; ?>">
</script>
<?php endif; ?>