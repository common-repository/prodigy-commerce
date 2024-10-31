<?php
use Prodigy\Includes\Prodigy_Pagination;

defined( 'ABSPATH' ) || exit;
?>

<div class="prodigy-categories prodigy-custom-template">
	<div class="prodigy-product-list__grid prodigy-product-list__grid-<?php echo $columns ?>">
		<?php
		if ( ! empty( $categories ) ) :
			foreach ( $categories as $key => $category ) :?>
				<div class="prodigy-product-list__item">
					<div class="prodigy-categories__card-wrap">
						<a class="prodigy-categories__card" href="<?php echo esc_url( $category['local_url'] ); ?>"
						style="background-image: url(<?php echo esc_url( $category['img_url'] ); ?>)">
							<?php if ( empty( $category['img_url'] ) ) : ?>
								<span class="prodigy-product-list__item-preview icon icon-image"></span>
							<?php endif ?>
						</a>
						<div class="<?php echo esc_attr( $attr['title_classname'] ?? '' ); ?>">
							<div class="prodigy-categories__card-title-name">
								<?php echo esc_attr( $category['name'] ); ?>
							</div>
							<?php if ( $show_count ) : ?>
								<div class="prodigy-categories__card-title-name-amount">
									<?php
									if ( ! empty( $category['count'] ) ) {
										echo esc_attr( $category['count'] ) . ' products';
									} else {
										echo '&nbsp';
									}
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="prodigy-pagination">
		<?php Prodigy_Pagination::prodigy_pagination( $pagination ?? array(), $pagination['pages'] ?? 1 ); ?>
	</div>
</div>

<script>
	jQuery(document).ready(function ($) {
		var idwidget = "<?php echo esc_attr($attr['idWidget'] ?? ''); ?>";

		$('.categories-slider-js'+idwidget).slick({
			mobileFirst: true,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: <?php echo $columns ?>,
						slidesToScroll: <?php echo $columns ?>,
					}
				},
			],
			appendArrows: $('.categories-slider-arrows-js'+idwidget),
			prevArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--prev icon icon-arrow-left" type="button"></button>',
			nextArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--next icon icon-arrow-right" type="button"></button>'
		});
	});
</script>
