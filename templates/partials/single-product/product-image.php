<template id="gallery-slide">
	<?php echo prodigy_get_remote_gallery_thumb_html( array(), 0 ); ?>
</template>


<div id="gallery" class="<?php echo esc_attr( $gallery_classname ); ?> prodigy-custom-template prodigy-product__gallery-main-image-container">
	<?php if ( ! empty( $price['sale-price'] ) ) : ?>
		<div class="prodigy-product-list__item-label"><?php esc_html_e( 'SALE', 'prodigy' ); ?></div>
	<?php endif; ?>

	<div
			id="gallery-main"
			class="prodigy-product__gallery swiper"
			data-images='<?php echo wp_json_encode( $attachments ); ?>'
			data-ratio="<?php echo esc_attr( $ratio ); ?>"
	>
		<?php if ( isset( $post_thumbnail_id ) && $post_thumbnail_id ) : ?>
			<div class="swiper-wrapper">
				<?php
				if ( $attachments ) {
					foreach ( $attachments as $image_id => $attachment ) {
						echo prodigy_get_remote_gallery_thumb_html( $attachment, $image_id );
					}
				}
				?>
			</div>
			<?php if ( ! empty( $attachments ) ) : ?>
			<button
				class="prodigy-product__gallery-nav prodigy-product__gallery-nav-prev icon icon-arrow-left"
				aria-label="Previous slide"
				style="display: none;"
			></button>
			<button
				class="prodigy-product__gallery-nav prodigy-product__gallery-nav-next icon icon-arrow-right"
				aria-label="Next slide"
				style="display: none;"
			></button>
<!--            TODO - Hide fullscreen mode-->
<!--			<button-->
<!--				class="prodigy-product__gallery-icon prodigy-product__gallery-icon--fullscreen icon icon-fullscreen icon-fullscreen-js"-->
<!--				aria-label="Toggle Fullscreen mode"-->
<!--			></button>-->
			<div class="prodigy-product__gallery-count"></div>
		<?php endif; ?>
		<?php else : ?>
			<i class="icon icon-image"></i>
		<?php endif; ?>
	</div>

	<?php if ( isset( $post_thumbnail_id ) && $post_thumbnail_id && $show_thumbnails ) : ?>
		<?php if ( isset( $settings ) ) : ?>
			<?php
			do_action(
				'prodigy_product_thumbnails',
				array(
					'images'   => $attachments,
					'settings' => $settings,
				)
			);
			?>
		<?php else : ?>
			<?php do_action( 'prodigy_product_thumbnails', array( 'images' => $attachments ) ); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>
