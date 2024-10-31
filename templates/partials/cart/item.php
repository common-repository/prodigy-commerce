<?php defined( 'ABSPATH' ) || exit; ?>
<?php
if ( sanitize_text_field( wp_unslash( $_COOKIE['wp-prodigy_user'] ) ) ) {
	$subtotal_price = 0;
	?>
<div class="col-xl-3 offset-xl-1 cart-subtotal-js">
	<h4 class="prodigy-cart__subtitle"><?php esc_html_e( 'CART TOTAL', 'prodigy' ); ?></h4>
	<div class="prodigy-cart__total mb-20">
		<p class="prodigy-cart__total-info"><span><?php esc_html_e( 'Subtotal', 'prodigy' ); ?></span>
			<span class="subtotal-price-js">$<?php echo esc_attr( prodigy_price_format( $subtotal_price ) ); ?></span>
		</p>
		<a href="<?php echo esc_url( $GLOBALS['proceed_url'] ); ?>">
			<button class="">
				<?php esc_html_e( 'PROCEED TO CHECKOUT', 'prodigy' ); ?>
			</button>
		</a>
	</div>
</div>


	<?php do_action( 'prodigy_empty_cart' );
}
?>
