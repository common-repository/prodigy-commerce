<?php if ( isset( $show_description ) ) : ?>
	<div class="prodigy-product__description prodigy-custom-template">
		<div class="prodigy-product__description-container">
			<?php if ( isset( $is_huge_description ) ) : ?>
				<?php echo Prodigy\Includes\Helpers\Prodigy_Formatting::prodigy_truncate( $content, $content_truncate_chars ); ?>
			<?php else : ?>
				<?php echo $content; ?>
			<?php endif; ?>
		</div>
		<?php if ( isset( $is_quick_view ) ) : ?>
			<?php if ( isset( $is_huge_description ) ) : ?>
				<span role="button" class="show-description-js" style="text-decoration: underline">
					<a href="<?php echo esc_attr( $product->get_field( 'guid' ) ); ?>#tab-description"><?php esc_html_e( 'View on Product Page', 'prodigy' ); ?></a>
				</span>
			<?php endif; ?>
		<?php else : ?>
			<?php if ( isset( $is_huge_description ) ) : ?>
				<span role="button" class="show-description-js" style="text-decoration: underline">
						<a href="<?php echo esc_attr( $product->get_field( 'guid' ) ); ?>#tab-description"><?php esc_html_e( 'Show more', 'prodigy' ); ?></a>
					</span>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
