<?php
/* Template Name: Cart shortcode */
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="prodigy-cart-slide prodigy-cart-slide-js prodigy-custom-template" data-auto-open="<?php echo esc_attr( $attr_shortcode['cart_content_gen_auto_open'] ); ?>">
	<button class="prodigy-cart__toggle prodigy-cart-slide__toggle">
		<span class="prodigy-navbar-cart__txt"><?php esc_html_e( 'Cart', 'prodigy' ); ?></span>

		<?php if ( ! empty( $attr_shortcode['icon_utf'] ) ) : ?>
			<span class="divi-icon-output prodigy-navbar-cart__icon" data-icon-type="<?php echo esc_attr( $attr_shortcode['icon_type'] ); ?>" data-icon-utf="<?php echo htmlspecialchars( $attr_shortcode['icon_utf'] ); ?>" data-icon-font-weight="<?php echo esc_attr( $attr_shortcode['icon_weight'] ); ?>" data-icon="<?php echo esc_attr( $attr_shortcode['icon_utf'] ); ?>"></span>
		<?php elseif ( empty( $attr_shortcode['icon_utf'] ) && empty( $attr_shortcode['cart_icon_type'] ) ) : ?>
			<i class="<?php echo esc_attr( $attr_shortcode['cart_icon_class'] ); ?> prodigy-navbar-cart__icon"></i>
		<?php endif; ?>

		<?php if ( isset( $attr_shortcode['cart_icon_type'] ) && $attr_shortcode['cart_icon_type'] === 'icon' ) : ?>
			<?php if ( ! empty( $attr_shortcode['cart_icon_class'] ) ) : ?>
				<i class="<?php echo esc_attr( $attr_shortcode['cart_icon_class'] ); ?> prodigy-navbar-cart__icon"></i>
			<?php endif; ?>
		<?php elseif ( isset( $attr_shortcode['cart_icon_type'] ) && $attr_shortcode['cart_icon_type'] === 'svg' ) : ?>
			<img class="<?php echo esc_attr( $attr_shortcode['cart_svg_class'] ); ?>" src="<?php echo esc_attr( $attr_shortcode['cart_content_icon_url'] ); ?>" alt="">
		<?php endif; ?>
		<?php if ( isset( $attr_shortcode['cart_content_icon_items_indicator'] ) && $attr_shortcode['cart_content_icon_items_indicator'] === 'yes' ) : ?>
			<span class="<?php echo esc_attr( $attr_shortcode['count_classname'] ); ?> prodigy-cart__count-items-indicator cart-count-js" style="display: none;" data-hide-empty="<?php echo esc_attr( $attr_shortcode['cart_content_icon_hide_empty'] ); ?>">0</span>
		<?php endif; ?>
	</button>

	<div class="prodigy-cart-slide__container">
		<div class="prodigy-cart-slide__main">
			<div class="prodigy-cart__head">
				<div class="d-flex align-items-center pl-16 pr-16 prodigy-cart-dropdown__title-wrap">
					<div class="flex-1 pr-16">
						<div class="prodigy-cart-dropdown__title"><?php echo esc_html( $attr_shortcode['heading_text'] ); ?></div>
					</div>
					<button class="prodigy-cart__close prodigy-cart-slide__close" type="button">
						<i class="icon icon-close"></i>
					</button>
				</div>
			</div>
			<div class="prodigy-cart__body">
				<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-added widget-cart-add-item-message-js" style="display: none">
					<div class="d-flex align-items-center">
						<i class="icon icon-check font-20 in-green-100 mr-8"></i>
						<span class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'has been added to your cart.', 'prodigy' ); ?></span>
					</div>
				</div>
				<div class="prodigy-cart-dropdown__alert widget-cart-remove-item-message-js" style="display: none">
					<div class="d-flex align-items-center">
						<i class="icon icon-check font-20 in-green-100 mr-8"></i>
						<span class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'has been removed from your cart.', 'prodigy' ); ?></span>
					</div>
				</div>
				<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-empty widget-cart-empty-cart-message-js" style="display: <?php echo empty( $cart_products ) ? 'flex' : 'none'; ?>"
				>
					<i class="icon icon-info font-20 mr-8"></i>
					<span class="prodigy-cart-dropdown__alert-txt"><?php echo esc_html( $attr_shortcode['empty_cart_text'] ); ?></span>
				</div>

				<?php
				Prodigy\Includes\Helpers\Prodigy_Template::prodigy_get_template(
					'cart-items.php',
					array(
						'cart_products' => $cart_products,
						'is_dropdown'   => $is_dropdown,
						'total_price'   => 0,
					)
				);
				?>
				
				<!-- Here the needed class to add 'prodigy-cart-loading__element' for loading element -->
				<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
					<div class="prodigy-cart-total prodigy-cart-total__widget-subtotal widget-cart-subtotal-js" style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>;">
						<span class="prodigy-cart-total__text">
							<?php esc_html_e( 'Subtotal:', 'prodigy' ); ?>
						</span>
						<span class="prodigy-cart-total__value prodigy-cart-total__value-subtotal-price widget-subtotal-price-js">
							$<?php echo esc_html( Prodigy_Formatting::prodigy_price_format( 0 ) ); ?>
						</span>
					</div>
				<?php endif; ?>
			</div>
			<div class="prodigy-cart__footer widget-cart-checkout-block-js" style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>;">
				<a class="prodigy-main-button prodigy-main-button--outline prodigy-cart__cart-btn" href="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>">
					<?php esc_html_e( 'View cart', 'prodigy' ); ?>
				</a>
				<button class="prodigy-main-button prodigy-cart__checkout-btn checkout-url-js">
					<?php esc_html_e( 'Checkout', 'prodigy' ); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<?php if ( ! Prodigy_Layouts_Manager::is_elementor_live_preview() || ! Prodigy_Layouts_Manager::is_elementor_template() ) : ?>
	<script
			src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/cart-widget.js' ) ) . 'cart-widget.js'; ?>">
	</script>
<?php endif; ?>
