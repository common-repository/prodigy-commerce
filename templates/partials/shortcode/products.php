<?php
use Prodigy\Includes\Helpers\Prodigy_Formatting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="prodigy-feature-products-slider prodigy-product-list-js prodigy-custom-template">
	<input type="hidden" class="is-featured-products-js<?php echo esc_attr( $attr['idWidget'] ?? '' ); ?>">
	<div class="prodigy-homepage__slider prodigy-homepage-slider-related">
		<div class="related-products-js<?php echo esc_attr( $attr['idWidget'] ?? '' ); ?> prodigy-homepage__slider-container
			<?php
			if ( $attr['slider_hide_arrows'] === 'yes' || $attr['slider_hide_arrows'] === 'on' ) {
				echo ' prodigy-homepage__slider-container--hidden-arrows';
			}
			?>
		">
			<?php foreach ( $products as $product ) : ?>
				<div class="prodigy-product-list__item">
					<?php if ( ! empty( $product['sale_price'] ) && $attr['sale'] === 'yes' ) : ?>
						<div class="<?php echo esc_attr( $attr['products_sale_classname'] ?? '' ); ?>">
							<span><?php esc_html_e( 'Sale', 'prodigy' ); ?></span>
						</div>
					<?php endif; ?>
					<div class="prodigy-product-list__item-container">
						<div <?php echo ( isset( $attr['image_ratio'] ) && $attr['image_ratio'] !== '' ) ? 'style="padding-top: ' . esc_attr( $attr['image_ratio'] ) . '%"' : ''; ?>
								class="prodigy-product-list__link-wrp">
							<a class="prodigy-product-list__item-preview icon icon-image"
								href="<?php echo esc_url( $product['local_url'] ?? '' ); ?>">
								<?php echo get_shop_product_logo_image_template( $product ); ?>
							</a>
						</div>
						<?php if ( $attr['category'] === 'yes' ) : ?>
							<p class="prodigy-product-list__item-category">
								<?php echo esc_html( $product['category'] ); ?>
							</p>
						<?php endif; ?>
						<h3 class="prodigy-product-list__item-title">
							<a href="<?php echo esc_url( $product['local_url'] ?? '' ); ?>">
								<?php echo esc_html( $product['name'] ?? '' ); ?>
							</a>
						</h3>
						<?php if ( $attr['rating'] === 'yes' ) : ?>
							<div class="prodigy-product-list__item-rating">
								<div class="prodigy-star-rating">
									<?php echo pg_get_star_rating_html( $product['rating'] ?? 0 ); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
							<div class="d-flex flex-wrap">
								<?php if ( ! empty( $product['sale_price'] ) ) : ?>
									<div class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
										<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['regular_price'] ) ); ?>
									</div>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['sale_price'] ) ); ?>
									</div>
								<?php else : ?>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['regular_price'] ) ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ( $attr['buynow'] === 'yes' ) : ?>
							<a href="<?php echo esc_url( '/buy-now?product-id=' . $product['id'] ); ?>">
								<button class="prodigy-buynow-button prodigy-main-button">
									<?php esc_html_e( 'Buy now', 'prodigy' ); ?>
								</button>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function ($) {
		var idwidget = "<?php echo esc_attr( $attr['idWidget'] ?? '' ); ?>";
		let is_feature_products = $('.is-featured-products-js' + idwidget).length;

		if (!is_feature_products) {
			var left = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left prodigy-related__products-nav--sm';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right prodigy-related__products-nav--sm';
		} else {
			var left = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right';
		}

		$('.related-products-js' + idwidget).not('.slick-initialized').slick({
			prevArrow: "<button type='button' class='" + left + "'></button>",
			nextArrow: "<button type='button' class='" + right + "'></button>",
			dots: false,
			arrows: true,
			mobileFirst: true,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						variableWidth: false,
						slidesToShow: 3,
						slidesToScroll: 3,
					}
				},
				{
					breakpoint: 1168,
					settings: {
						slidesToShow: <?php echo $columns; ?>,
						slidesToScroll: <?php echo $columns; ?>,
						variableWidth: false,
						arrows: true,
					}
				},
			],
		});
	});
</script>
