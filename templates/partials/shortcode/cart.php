<?php
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Helpers\Prodigy_Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<li class="prodigy-cart-dropdown__wrap prodigy-custom-template">
	<div class="prodigy-cart-dropdown">
		<?php if ( ! empty( $is_dropdown ) ) : ?>
			<a href="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>"
				class="prodigy-navbar-cart header-cart-block-js prodigy-cart__toggle prodigy-cart-dropdown__toggle">
				<span class="prodigy-navbar-cart__txt prodigy-navbar-cart__text"><?php esc_html_e( 'Cart', 'prodigy' ); ?></span>

				<?php if ( ! empty( $attr_shortcode['icon_utf'] ) ) : ?>
					<span class="divi-icon-output prodigy-navbar-cart__icon"
							data-icon-type="<?php echo esc_attr( $attr_shortcode['icon_type'] ); ?>"
							data-icon-utf="<?php echo esc_url( $attr_shortcode['icon_utf'] ); ?>"
							data-icon-font-weight="<?php echo esc_attr( $attr_shortcode['icon_weight'] ); ?>"
							data-icon="<?php echo esc_attr( $attr_shortcode['icon_utf'] ); ?>"></span>
				<?php elseif ( empty( $attr_shortcode['cart_icon_type'] ) ) : ?>
					<i class="<?php echo esc_attr( $attr_shortcode['cart_icon_class'] ?? 'icon icon-cart' ); ?> prodigy-navbar-cart__icon"></i>
				<?php endif; ?>

				<?php if ( isset( $attr_shortcode['cart_icon_type'] ) && $attr_shortcode['cart_icon_type'] === 'icon' ) : ?>
					<i class="<?php echo esc_attr( $attr_shortcode['cart_icon_class'] ?? '' ); ?> prodigy-navbar-cart__icon"></i>
				<?php elseif ( isset( $attr_shortcode['cart_icon_type'] ) && $attr_shortcode['cart_icon_type'] === 'svg' ) : ?>
					<img class="<?php echo esc_attr( $attr_shortcode['cart_svg_class'] ); ?>"
						src="<?php echo esc_attr( $attr_shortcode['cart_content_icon_url'] ); ?>" alt="">
				<?php endif; ?>

				<?php if ( isset( $attr_shortcode['cart_content_icon_items_indicator'] ) && $attr_shortcode['cart_content_icon_items_indicator'] === 'yes' ) : ?>
					<span class="<?php echo esc_attr( $attr_shortcode['count_classname'] ); ?> prodigy-cart__count-items-indicator cart-count-js"
							data-hide-empty="<?php echo esc_attr( $attr_shortcode['cart_content_icon_hide_empty'] ); ?>">0</span>
				<?php else : ?>
					<span class="prodigy-navbar-cart__count prodigy-cart__count-items-indicator cart-count-js" style="display: none">0</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>

		<div class="<?php echo esc_attr( $attr_shortcode['container_class'] ?? '' ); ?>" aria-labelledby="cartDropdown">
			<div class="prodigy-cart-dropdown__main prodigy-cart-dropdown__menu dropdown-menu dropdown-menu-right prodigy-cart-widget prodigy-<?php echo $is_dropdown ? 'dropdown-' : ''; ?>cart-widget-js"
				aria-labelledby="cartDropdown"
				style="display: <?php echo ! empty( $is_dropdown ) ? 'none' : 'block'; ?>">
				<div class="prodigy-cart__body">
					<?php if ( $is_dropdown ) : ?>
						<div class="prodigy-cart__head">
							<div
									class="d-flex align-items-center justify-content-between prodigy-cart__heading-title prodigy-cart-dropdown__title-wrap pl-16 pr-16">
								<div class="flex-1 pr-16">
									<div class="prodigy-cart-dropdown__title">
										<?php esc_html_e( 'Shopping Cart', 'prodigy' ); ?></div>
								</div>
								<button class="prodigy-cart-dropdown__header-close icon icon-close close-cart-widget-js"
										type="button"></button>
							</div>
						</div>
					<?php endif; ?>

					<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-added widget-cart-add-item-message-js" style="display: none">
						<i class="icon icon-check mr-8 font-20 in-green-100"></i>
						<span
								class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'has been added to your cart.', 'prodigy' ); ?></span>
					</div>

					<div class="prodigy-cart-dropdown__alert widget-cart-remove-item-message-js" style="display: none">
						<i class="icon icon-check mr-8 font-20 in-green-100"></i>
						<span
								class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'has been removed from your cart.', 'prodigy' ); ?></span>
					</div>

					<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-error widget-cart-message-error-js mb-20 prodigy-cart-dropdown__alert--default mt-16"
						style="display: <?php echo $is_deleted_product ? 'flex' : 'none'; ?>">
						<i class="icon icon-error mr-8"></i>
						<span class="prodigy-cart-dropdown__alert-txt"></span>
					</div>
					<?php delete_option( 'prodigy_widget_cart_removed_products' ); ?>

					<?php
					Prodigy_Template::prodigy_get_template(
						'cart-items.php',
						array(
							'cart_products' => $cart_products,
							'is_dropdown'   => $is_dropdown,
							'total_price'   => 0,
						)
					);
					?>
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<p class="prodigy-cart-total prodigy-cart-total__widget-subtotal widget-cart-subtotal-js"
							style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>  ">
							<span
									class="prodigy-widget__subtotal-txt prodigy-widget__subtotal-text"><?php esc_html_e( 'Subtotal:', 'prodigy' ); ?></span>
							<span
									class="widget-subtotal-price-js prodigy-widget__subtotal-txt-price prodigy-cart-total__value">$<?php echo esc_html( Prodigy_Formatting::prodigy_price_format( 0 ) ); ?></span>
						</p>
					<?php endif; ?>
				</div>

				<div class="prodigy-cart-dropdown__footer widget-cart-checkout-block-js"
					style="display: <?php echo empty( $cart_products ) ? 'none' : 'flex'; ?>  ">
					<a class="prodigy-main-button prodigy-main-button--outline justify-content-center mb-16 prodigy-cart__cart-btn"
						href="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>">
						<?php esc_html_e( 'View cart', 'prodigy' ); ?>
					</a>
					<button class="prodigy-main-button justify-content-center checkout-url-js prodigy-cart__checkout-btn">
						<?php esc_html_e( 'Checkout', 'prodigy' ); ?>
					</button>
				</div>
				<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-empty widget-cart-empty-cart-message-js"
					style="display: <?php echo empty( $cart_products ) ? 'block' : 'none'; ?>">
					<div class="d-flex align-items-center">
						<i class="icon icon-info mr-8"></i>
						<span
								class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'No products added yet', 'prodigy' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
