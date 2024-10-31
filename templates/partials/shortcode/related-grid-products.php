<?php
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Helpers\Prodigy_Formatting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $products ) ) : ?>
	<div class="prodigy-custom-template">
		<h3 class="prodigy-related__products-title">
			<?php if ( $heading ) : ?>
				<?php echo esc_html( $heading ); ?>
			<?php endif; ?>
		</h3>
	</div>
<?php endif; ?>

<div class="related-products__container prodigy-custom-template container-fluid">
	<input type="hidden" class="feature-product-columns-number-js" value="<?php echo esc_attr( $settings['columns'] ) ?? 4; ?>">
	<input type="hidden" class="is-featured-products-js">

	<div class="prodigy-product-list__grid prodigy-product-list__grid-<?php echo $columns; ?>">
		<?php
		foreach ( $products as $key => $product ) :
			$product = (array) $product;
			?>
			<div class="prodigy-product-list__item">
				<?php if ( ! empty( $product['sale_price'] ) && $settings['sale'] === 'yes' ) : ?>
					<div class="<?php echo esc_attr( $sale_classname ); ?>"><span><?php esc_html_e( 'Sale', 'prodigy' ); ?></span></div>
				<?php endif; ?>
				<div class="prodigy-product-list__item-container">
					<div <?php echo ( $image_ratio !== '' ) ? 'style="padding-top: ' . esc_attr( $image_ratio ) . '%"' : ''; ?> class="prodigy-product-list__link-wrp">
						<a class="prodigy-product-list__item-preview icon icon-image" href="<?php echo esc_url( $product['local_url'] ?? '' ); ?>">
							<?php echo get_shop_product_logo_image_template( $product ); ?>
						</a>
					</div>
					<?php if ( $settings['category'] === 'yes' ) : ?>
						<p class="prodigy-product-list__item-category">
							<?php echo esc_html( $product['category'] ); ?>
						</p>
					<?php endif; ?>
					<h3 class="prodigy-product-list__item-title">
						<a href="<?php echo esc_attr( $product['local_url'] ?? '' ); ?>">
							<?php echo esc_html( $product['name'] ); ?>
						</a>
					</h3>
					<?php if ( $settings['rating'] === 'yes' ) : ?>
						<div class="prodigy-product-list__item-rating">
							<div class="prodigy-star-rating">
								<?php echo pg_get_star_rating_html( $product['rating'] ); ?>
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
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="prodigy-pagination">
		<?php Prodigy_Pagination::prodigy_pagination( $pagination ?? array(), $pagination['pages'] ?? 1 ); ?>
	</div>
</div>
