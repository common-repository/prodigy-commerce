<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="col-md-6 col-lg-5 prodigy-homepage__image-card-item prodigy-homepage__image-card-item--double">

	<div class="prodigy-homepage__image-card-inner" style="background-image: url(<?php echo esc_url( $image ); ?>)">
		<?php if ( isset( $category, $category->count, $category->term_id, $category->name ) ) : ?>
			<a class="prodigy-homepage__image-card-link" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
				<p class="mb-4"><?php echo esc_html( $category->name ); ?></p>
				<?php if ( ! empty( $category->count ) && $show_product_count ) : ?>
					<span class="prodigy-homepage__image-card-link-caption">
						<span>
							<?php
								echo esc_html( $category->count ) . ' ';
								echo esc_html_e( 'products', 'prodigy' ); ?>
						</span>
						<i class="icon icon-straight-arrow font-16 ml-4"></i>
					</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</div>
</div>
