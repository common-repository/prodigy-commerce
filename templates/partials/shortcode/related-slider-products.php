<?php
use Prodigy\Includes\Helpers\Enums\Prodigy_Enums;
use Prodigy\Includes\Helpers\Prodigy_Formatting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $products ) ) : ?>
	<div class="prodigy-custom-template container-fluid">
		<h3 class="prodigy-related__products-title">
			<?php echo esc_html( $heading ?? '' ); ?>
		</h3>
	</div>
<?php endif; ?>

<div class="prodigy-feature-products-slider prodigy-product-list-js prodigy-custom-template container-fluid">
	<input type="hidden" class="feature-product-columns-number-js<?php echo esc_attr( $idWidget ?? '' ); ?>" value="<?php echo esc_attr( $settings['columns'] ?? Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS ); ?>">
	<input type="hidden" class="is-featured-products-js<?php echo esc_attr( $idWidget ?? '' ); ?>">
	<div class="prodigy-homepage__slider prodigy-homepage-slider-related">
		<div class="related-products-js<?php echo esc_attr( $idWidget ?? '' ); ?> prodigy-homepage__slider-container
			<?php
			if ( isset( $hide_arrows ) && $hide_arrows === 'yes' ) {
				echo ' prodigy-homepage__slider-container--hidden-arrows';}
			?>
		">
			<?php
			foreach ( $products as $product ) :
				$product    = (array) $product;
				$title      = $product['name'] ?? '';
				$price      = $product['regular_price'] ?? '';
				$sale_price = $product['sale_price'] ?? '';
				?>
				<div class="prodigy-product-list__item" >
					<?php if ( ! empty( $sale_price ) && isset( $sale ) && $sale == 'yes' ) : ?>
						<div class="<?php echo esc_attr( $sale_classname ); ?>"><span><?php esc_html_e( 'Sale', 'prodigy' ); ?></span></div>
					<?php endif; ?>
					<div class="prodigy-product-list__item-container">
					<?php if ( isset( $image_ratio ) ) : ?>
						<div <?php echo ( $image_ratio !== '' ) ? 'style="padding-top: ' . esc_attr( $image_ratio ) . '%"' : ''; ?> class="prodigy-product-list__link-wrp">
							<a class="prodigy-product-list__item-preview icon icon-image" href="<?php echo esc_url( $product['local_url'] ); ?>">
								<?php echo get_shop_product_logo_image_template( $product ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="prodigy-product-list__link-wrp">
							<a class="prodigy-product-list__item-preview icon icon-image" href="<?php echo esc_url( $product['local_url'] ); ?>">
								<?php echo get_shop_product_logo_image_template( $product ); ?>
							</a>
						</div>
					<?php endif; ?>

					<?php if ( isset( $category ) && ( $category == 'yes' || $category ) ) : ?>
						<p class="prodigy-product-list__item-category">
							<?php echo esc_html( $product['category'] ); ?>
						</p>
					<?php endif; ?>

					<h3 class="prodigy-product-list__item-title">
						<a href="<?php echo esc_attr( $product['local_url'] ); ?>"><?php echo esc_html( $title ); ?></a>
					</h3>
					<?php if ( isset( $rating ) && $rating === 'yes' ) : ?>
						<div class="prodigy-product-list__item-rating">
							<div class="prodigy-star-rating">
								<?php echo pg_get_star_rating_html( $product['rating'] ); ?>
							</div>
						</div>
					<?php endif; ?>
						
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<div class="d-flex flex-wrap">
								<?php if ( ! empty( $sale_price ) ) : ?>
								<div class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $price ) ); ?>
								</div>
								<div class="prodigy-product-list__item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $sale_price ) ); ?>
								</div>
							<?php else : ?>
								<div class="prodigy-product-list__item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $price ) ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
						
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function ($) {

		var idWidget = "<?php echo esc_attr( $settings['idWidget'] ?? '' ); ?>";

		let columns_number = parseInt($('.feature-product-columns-number-js'+idWidget).val());
		let columns_tablet = parseInt(<?php echo esc_attr( $settings['columns_tablet'] ?? esc_attr( Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_TABLET ) ); ?>);
		let columns_mobile = parseInt(<?php echo esc_attr( $settings['columns_mobile'] ?? esc_attr( Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_MOBILE ) ); ?>);
		if (isNaN(columns_number)) {
			columns_number = <?php echo esc_attr( Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS ); ?>;
		}
		if (isNaN(columns_tablet)) {
			columns_tablet = <?php echo esc_attr( Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_TABLET ); ?>;
		}
		if (isNaN(columns_mobile)) {
			columns_mobile = <?php echo esc_attr( Prodigy_Enums::RELATED_PRODUCTS_DEFAULT_COLUMNS_MOBILE ); ?>;
		}
		let is_feature_products = $('.is-featured-products-js'+idWidget).length;

		if (!is_feature_products) {
			var left = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left prodigy-related__products-nav--sm';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right prodigy-related__products-nav--sm';
		} else {
			var left = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right';
		}

		$('.related-products-js'+idWidget).not('.slick-initialized').slick({
			prevArrow: "<button type='button' class='"+ left +"'></button>",
			nextArrow: "<button type='button' class='"+ right +"'></button>",
			dots: false,
			arrows: true,
			mobileFirst: true,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						variableWidth: false,
						slidesToShow: columns_tablet,
						slidesToScroll: columns_tablet,
					}
				},
				{
					breakpoint: 359,
					settings: {
						variableWidth: false,
						slidesToShow: columns_mobile,
						slidesToScroll: columns_mobile,
					}
				},
				{
					breakpoint: 1168,
					settings: {
						slidesToShow: columns_number,
						slidesToScroll: columns_number,
						variableWidth: false,
						arrows: true,
					}
				},
			],
		});

		$('.related-products-js'+idWidget+'.prodigy-homepage__slider-container--hidden-arrows')
			.on('mouseenter', function() {
				$(this).addClass('show');
			})
			.on('mouseleave', function() {
				const _this = $(this);
				setTimeout(function() {
					if (!_this.is(':hover')) {
						_this.removeClass('show');
					}
				}, 400)
			});
	});
</script>
