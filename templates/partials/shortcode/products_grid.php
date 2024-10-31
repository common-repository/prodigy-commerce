<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
?>
<div class="feature-products__container prodigy-custom-template">
	<input type="hidden" class="is-featured-products-js">
	<div class="prodigy-product-list__grid prodigy-product-list__grid-<?php echo $columns; ?>">
		<?php foreach ( $products as $key => $product ) : ?>
			<div class="prodigy-product-list__item">
				<?php if ( ! empty( $product['sale_price'] ) && $attr['sale'] === 'yes' ) : ?>
					<div class="<?php echo esc_attr( $attr['products_sale_classname'] ?? '' ); ?>">
						<?php esc_html_e( 'SALE', 'prodigy' ); ?>
					</div>
				<?php endif; ?>
				<div class="prodigy-product-list__item-container">
					<div <?php echo ( $attr['image_ratio'] !== '' ) ? 'style="padding-top: ' . esc_attr( $attr['image_ratio'] ) . '%"' : ''; ?> class="prodigy-product-list__link-wrp">
						<a class="prodigy-product-list__item-preview icon icon-image"
							href="<?php echo esc_url( $product['local_url'] ?? '' ); ?>"
						>
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
							<?php echo esc_html( $product['name'] ); ?>
						</a>
					</h3>
					<?php if ( $attr['rating'] === 'yes' ) : ?>
						<div class="prodigy-product-list__item-rating">
							<div class="prodigy-star-rating">
								<?php echo pg_get_star_rating_html( $product['rating'] ); ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<div class="d-flex flex-wrap">
							<?php if ( isset( $product['tiered-price'], $product['price'] ) && $product['tiered-price'] && $product['price'] == 0.0 ) : ?>
								<?php if ( isset( $product['price-range']['min_price'], $product['price-range']['max_price'] ) ) : ?>
									<?php if ( $product['price-range']['min_price'] === $product['price-range']['max_price'] ) : ?>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_html( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $product['price-range']['min_price'] ); ?>
										</div>
									<?php else : ?>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_html( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $product['price-range']['min_price'] ); ?>
										</div>
										<span class="prodigy-product-list__item-price">&nbsp;-&nbsp;</span>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_html( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $product['price-range']['max_price'] ); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>

							<?php elseif ( ! empty( $product['sale_price'] ) ) : ?>
								<span class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['regular_price'] ) ); ?>
								</span>
								<span class="prodigy-product-list__item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['sale_price'] ) ); ?>
								</span>
							<?php else : ?>
								<span class="prodigy-product-list__item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['regular_price'] ) ); ?>
								</span>
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
	<div class="prodigy-pagination">
		<?php Prodigy_Pagination::prodigy_pagination( $pagination['pagination'] ?? array(), $pagination['pagination']['pages'] ?? 1 ); ?>
	</div>
</div>

