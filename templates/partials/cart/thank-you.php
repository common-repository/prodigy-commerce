<?php /* Template Name: Thank-you shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = apply_filters( 'prodigy_product_related_products_heading', 'Customers also buy' );
?>

<div class="prodigy-custom-template">
	<div class="container prodigy-thank-you-page">
		<div class="row mb-80">
			<div class="col-12">
				<div class="d-flex flex-column align-items-center">
					<?php if ( ! empty( $order_info ) && isset( $order_remote ) ) : ?>
					<h2 class="prodigy-thank-you-page__title">
						<?php echo esc_attr( $message ); ?>
					</h2>
					<div class="prodigy-thank-you-page__txt">
						<p class="mb-0">
							<?php
							echo sprintf(
								__( 'Order %s is successfully placed.', 'prodigy' ),
								'<span class="font-bold">#' . esc_attr( $order_remote ) . '</span>'
							);
							?>
						</p>
					</div>
					<?php else : ?>
					<h2 class="prodigy-thank-you-page__title">
						<?php esc_attr_e( 'This order does not exist.', 'prodigy' ); ?>
					</h2>
					<?php endif; ?>
					<a class="prodigy-main-button prodigy-main-button--link prodigy-main-button--wide"
						href="<?php echo esc_url( home_url( prodigy_get_shop_url() ) ); ?>">
						<?php esc_attr_e( 'BACK TO SHOP LIST', 'prodigy' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script
	src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/feature-products.js' ) ) . 'feature-products.js'; ?>">
</script>
