<?php
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Helpers\Prodigy_Template;

defined( 'ABSPATH' ) || exit;

?>
<div class="prodigy-custom-template">
	<div class="prodigy-cart container-fluid p-0">
		<div style="display: none"
			class="prodigy-deficiency-message-js prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert--info mb-20">
			<i class="icon icon-error mr-16"></i>
			<span class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'The selected quantity is not available. There are currently', 'prodigy' ); ?>
				<span class="prodigy-inventory-count-js"></span> <?php esc_html_e( 'in stock', 'prodigy' ); ?></span>
		</div>

		<div class="prodigy-cart-container-js container-fluid prodigy-cart-container__fluid p-0 mb-40 ">
			<div class="row sss"><?php Prodigy_Template::prodigy_get_template( 'shortcode/pages/cart/item.php', $args ); ?></div>
		</div>
		<?php if ( empty( $cart_items['items'] ) ) : ?>
		<div class="prodigy-empty-cart__wrap d-flex flex-column justify-content-center align-items-center ">
			<div class="prodigy-empty-cart empty-cart-js text-center w-100">
				<div class="prodigy-empty-cart__icon icon icon-cart font-36"></div>
				<p class="prodigy-empty-cart__txt mb-40 mt-16">
					<?php esc_html_e( 'Your cart is empty', 'prodigy' ); ?>
				</p>
				<div class="d-flex justify-content-center">
					<a class="prodigy-main-button d-flex prodigy-empty-cart__link" href="<?php echo esc_url( Prodigy_Page::prodigy_get_shop_url() ) ?>">
						<i class="icon icon-arrow-left prodigy-empty-cart__link-icon"></i>
						<span><?php esc_html_e( 'Continue Shopping', 'prodigy' ); ?></span>
					</a>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
