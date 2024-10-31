<?php if ( $rating_count > 0 ) : ?>
	<div class="prodigy-product__rating prodigy-custom-template">
		<?php if ( get_option( 'pg_product_rating' ) ) : ?>
			<?php echo pg_get_rating_html( $average ); ?>
		<?php endif; ?>
		<?php if ( isset( $settings['style_rating_separator'] ) ) : ?>
			<?php if ( $settings['style_rating_separator'] === 'yes' ) : ?>
				<div class="prodigy-product__rating-divider"></div>
			<?php endif; ?>
		<?php else : ?>
			<div class="prodigy-product__rating-divider"></div>
		<?php endif; ?>
		<?php if ( comments_open( $product->get_field( 'ID' ) ) ) : ?>
			<?php if ( get_option( 'pg_product_review' ) && isset( $product_variant_info['attributes']['url'] ) ) : ?>
			<input type="hidden" value="<?php echo esc_attr( $product_variant_info['attributes']['url'] ); ?>" class="product-url-js">
				<?php if ( isset( $settings['prg_style_rating_icon_align'] ) ) : ?>
					<a
							class="prodigy-product__rating-link prodigy-review-link-js"
							rel="nofollow"
							style="cursor: pointer"
							href="<?php echo get_permalink( $product->get_field( 'ID' ) ); ?>#tab-reviews"
					>
						<?php if ( $icon_type === 'icon' ) : ?>
							<?php if ( $icon_class !== '' ) : ?>
								<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
							<?php endif; ?>
						<?php elseif ( $icon_type === 'svg' ) : ?>
							<img class="<?php echo esc_attr( $icon_svg_class ); ?>" src="<?php echo esc_attr( $settings['prg_style_rating_selected_icon']['value']['url'] ); ?>" alt="">
						<?php endif; ?>
						<span class="count prodigy-product__rating-info">(<?php printf( esc_html( _n( '%s customer review', '%s customer reviews', $review_count, 'prodigy' ) ), '' . esc_html( $review_count ) ); ?>)</span>
					</a>
				<?php else : ?>
					<a
							class="prodigy-product__rating-link prodigy-review-link-js"
							rel="nofollow"
							style="cursor: pointer"
							href="<?php echo get_permalink( $product->get_field( 'ID' ) ); ?>#tab-reviews"
					>
						<?php if ( $icon_class !== '' ) : ?>
							<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
						<?php endif; ?>
						<span class="count prodigy-product__rating-info">(<?php printf( esc_html( '%s customer review', '%s customer reviews', $review_count, 'prodigy' ), '' . esc_html( $review_count ) ); ?>)</span>
					</a>
				<?php endif; ?>
			<?php endif ?>
		<?php endif ?>
	</div>
	<?php if ( $is_quick_view && ! empty( $product->get_field( 'post_excerpt' ) ) ) : ?>
		<p class="prodigy-product__description"><?php echo $product->get_field( 'post_excerpt' ); ?></p>
	<?php endif; ?>
<?php endif; ?>
