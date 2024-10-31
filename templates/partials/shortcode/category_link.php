<?php
defined( 'ABSPATH' ) || exit;

if ( isset( $category ) ) :?>
	<?php if ( ! empty( $category_image ) ) : ?>
		<div
			class="prodigy-category-link-wrapper prodigy-custom-template"
		>
			<div
				class="prodigy-category-link__img"
				style="
				background-image: url('<?php echo esc_url( $category_image ); ?>');
				height: <?php echo $height ?? ''; ?>;
                background-position-y: <?php echo $image_position ?? ''; ?>;
				"
			></div>
			<a style="opacity: <?php echo $opacity ?? ''; ?>"
			  href="<?php echo $category['local_url'] ?? ''; ?>"
			  class="<?php echo esc_attr( $attr['link_classname'] ); ?>"
			>
				<div class="prodigy-category-link__title"><?php echo ! empty( $category['name'] ) ? esc_attr( $category['name'] ) : esc_attr( $attr['category_slug'] ); ?></div>
				<?php if ( $args['show_product_count'] ) : ?>
					<div class="prodigy-category-link__products">
						<?php
							echo esc_html( $category['count'] ?? 0 ) . ' ';
							echo esc_html__( 'products', 'prodigy' );
						?>
						<span class="prodigy-category-link__icon icon icon-straight-arrow"></span>
					</div>
				<?php endif; ?>
			</a>
		</div>
	<?php else : ?>
			<a
				href="<?php echo $category['local_url']; ?>"
				class="<?php echo esc_attr( $attr['link_classname'] ); ?>"
			>
				<div class="prodigy-category-link__title"><?php echo ! empty( $category['name'] ) ? esc_attr( $category['name'] ) : esc_attr( $attr['category_slug'] ); ?></div>

				<?php if ( $show_product_count ) : ?>
					<div class="prodigy-category-link__products">
						<?php echo esc_attr( $category['count'] ?? 0); ?> products
						<span class="prodigy-category-link__icon icon icon-straight-arrow"></span>
					</div>
				<?php endif; ?>
			</a>
	<?php endif; ?>
<?php endif; ?>
