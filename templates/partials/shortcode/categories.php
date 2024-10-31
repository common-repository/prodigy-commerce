<?php defined( 'ABSPATH' ) || exit; ?>

<div class="prodigy-categories-slider category-list-js prodigy-custom-template">
	<div class="prodigy-homepage__slider prodigy-categories">
		<div class="categories-slider-js<?php echo esc_attr( $attr['idWidget'] ?? ''); ?> prodigy-homepage__slider-container
	   <?php
		if ( $attr['slider_hide_arrows'] === 'yes' || $attr['slider_hide_arrows'] === 'on' ) {
			echo ' prodigy-homepage__slider-container--hidden-arrows';}
		?>
		">
			<?php foreach ( $categories as $key => $category ) : ?>
				<div class="prodigy-categories__card-wrap">
					<a class="prodigy-categories__card" href="<?php echo esc_url( $category['local_url'] ); ?>"
					style="background-image: url(<?php echo esc_url( $category['img_url'] ); ?>)">
						<?php if ( empty( $category['img_url'] ) ) :?>
							<span class="prodigy-product-list__item-preview icon icon-image"></span>
						<?php endif ?>
					</a>
					<div class="<?php echo esc_attr( $attr['title_classname'] ?? '' ); ?>">
						<div class="prodigy-categories__card-title-name">
							<?php echo esc_html( $category['name'] ); ?>
						</div>
						<?php if ( $show_count ) : ?>
							<div class="prodigy-categories__card-title-name-amount">
								<?php
								if ( ! empty( $category['count'] ) ) {
									echo esc_attr( $category['count'] ) . '&nbsp' . esc_html__(' products', 'prodigy' );
								} else {
									echo '&nbsp';
								}
								?>
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
		var idwidget = "<?php echo esc_attr( $attr['idWidget'] ?? ''); ?>";

		$('.categories-slider-js'+idwidget).not('.slick-initialized').slick({
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 1168,
                    settings: {
                        slidesToShow: <?php echo $columns ?>,
                        slidesToScroll: <?php echo $columns ?>,
                    }
                },
            ],
			prevArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--prev icon icon-arrow-left" type="button"></button>',
			nextArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--next icon icon-arrow-right" type="button"></button>'
		});
	});
</script>
