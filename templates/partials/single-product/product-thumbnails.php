<template id="gallery-thumbs-slide">
	<?php
	$attachments_default = array(
		'versions' => array(
			'thumbnails'        => '',
			'thumbnails_retina' => '',
		),
	);
	?>
	<?php
	echo apply_filters(
		'prodigy_single_product_image_thumbnail_html',
		prodigy_get_remote_gallery_image_html( $attachments_default, 0 ),
		$attachments_default
	);
	?>
</template>

<div
		id="gallery-thumbs"
		class="prodigy-product__gallery-thumbs swiper prodigy-custom-template"
		data-slides="<?php echo isset( $settings ) ? esc_attr( $settings['style_thumbnails_slides'] ) : 3; ?>"
		data-spacing="<?php echo isset( $settings ) ? esc_attr( $settings['style_thumbnails_spacing']['size'] ) : 10; ?>"
>
	<div class="swiper-wrapper">
		<?php
		if ( ! empty( $attachments ) ) {
			foreach ( $attachments as $image_id => $attachment ) {
				echo apply_filters( 'prodigy_single_product_image_thumbnail_html', prodigy_get_remote_gallery_image_html( $attachment, $image_id ), $attachment );
			}
		}
		?>
	</div>
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
</div>
<?php
