<?php
/* Template Name: Related shortcode */

use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<?php
$placeholder_url = plugin_dir_url( PRODIGY_PLUGIN_PATH . 'web/admin/images/placeholder.png' ) . 'placeholder.png';
$columns         = $args['columns'] ?? 4;

$image_ratio = Prodigy_Customizer::get_images_ratio();
?>
<div class="prodigy-custom-template">
	<div class="row">
		<div class="col-lg-12">
			<div class="prodigy-related">
				<input type="hidden" class="feature-product-columns-number-js" value="<?php echo esc_attr( $columns ); ?>">
				<div class="prodigy-related__products-container related-products-js">
					<?php
					foreach ( $products as $product ) :
						$img           = $product->attributes->{'versions-image-url'};
						$title         = $product->attributes->{'name'};
						$price         = $product->attributes->{'price'};
						$sale_price    = $product->attributes->{'sale-price'};
						$local_product = \Prodigy\includes\content\Prodigy_Product_Parser::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $product->id );
						?>
					<div class="prodigy-related__products-item">
						<?php if ( isset( $local_product->post_id ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( $local_product->post_id ) ); ?>"
							class="prodigy-related__products-img">
							<?php if ( isset( $img ) ) : ?>
							<img loading="lazy" width="60"
								srcset="<?php echo esc_attr( $img->thumbnails ); ?> 1x, <?php echo esc_attr( $img->thumbnails_retina ); ?> 2x"
								src="<?php echo esc_url( $img->thumbnails ); ?>">
							<?php else : ?>
							<img loading="lazy" width="60" src="<?php echo esc_url( $placeholder_url ); ?>">
							<?php endif; ?>
						</a>
						<?php endif; ?>
						<div>
							<?php if ( isset( $local_product->post_id ) ) : ?>
							<a href="<?php echo esc_url( get_permalink( $local_product->post_id ) ); ?>"
								class="prodigy-related__products-item-title">
								<?php echo esc_html( $title ); ?>
							</a>
							<?php endif; ?>
							<div class="prodigy-related__products-item-price">

								<?php
								if (
									isset( $product->attributes->{'price-range'}->min_price, $product->attributes->{'display-price-range'}, $product->attributes->{'price-range'}->max_price ) &&
									$product->attributes->{'display-price-range'} &&
									$product->attributes->{'price-range'}->min_price == $product->attributes->{'price-range'}->max_price
								) :
									?>
								<span class="prodigy-related__products-item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $product->attributes->{'price-range'}->min_price ) ); ?>
								</span>
									<?php
								elseif (
									isset( $product->attributes->{'price-range'}->min_price, $product->attributes->{'display-price-range'} ) &&
									! $product->attributes->{'display-price-range'}
								) :
									?>
									<?php if ( ! empty( $sale_price ) ) : ?>
								<span class="prodigy-related__products-item-price-sale">
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $price ) ); ?>
								</span>
								<span>
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $sale_price ) ); ?>
								</span>
								<?php else : ?>
								<span
									class="prodigy-related__products-item-price">$<?php echo esc_attr( Prodigy_Formatting::prodigy_price_format( $price ) ); ?></span>
								<?php endif; ?>
								<?php elseif ( ( $product->attributes->{'price-range'}->min_price === $product->attributes->{'price-range'}->max_price ) ) : ?>
									<?php if ( ! empty( $sale_price ) ) : ?>
								<span class="prodigy-related__products-item-price-sale">
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $price ) ); ?>
								</span>
								<span>
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $sale_price ) ); ?>
								</span>
								<?php else : ?>
								<span
									class="prodigy-related__products-item-price">$<?php echo esc_html( Prodigy_Formatting::prodigy_price_format( $price ) ); ?></span>
								<?php endif; ?>
								<?php else : ?>
									<?php if ( isset( $product->attributes->{'display-price-range'} ) && $product->attributes->{'display-price-range'} ) : ?>
								<span class="prodigy-related__products-item-price">
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $product->attributes->{'price-range'}->min_price ) ); ?>
								</span>
								&nbsp;-&nbsp;
								<span class="prodigy-related__products-item-price">
										<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $product->attributes->{'price-range'}->max_price ) ); ?>
								</span>
								<?php else : ?>
								<span class="prodigy-related__products-item-price">
									<?php echo esc_html( get_option( 'pg_currency_type' ) ) . esc_html( Prodigy_Formatting::prodigy_price_format( $product->attributes->{'price-range'}->min_price ) ); ?>
								</span>
								<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

</div>
