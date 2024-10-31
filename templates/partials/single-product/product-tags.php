<?php if ( is_array( $tags ) && ! empty( $tags ) && $enable_product_tags ) : ?>
	<li class="prodigy-product__tags-item">
		<span class="prodigy-product__tags-label">
			<?php echo esc_html( _n( 'Tag:', 'Tags:', $tags_count, 'prodigy' ) ); ?>
		</span>
		<span class="prodigy-product__tags-text">
			<?php
			foreach ( $tags as $key_cat => $remote_tag ) {

				$tag_info = get_term_by( 'name', $remote_tag, Prodigy\Includes\Prodigy::get_prodigy_tag_type() );
				$tag_link = get_category_link( $tag_info->term_id );
				echo '<a href="' . esc_attr( $tag_link ) . '">' . esc_attr( $remote_tag ) . '</a>';
				if ( ++$key_cat != $tags_count ) {
					echo ', ';
				}
			}
			?>
		</span>
	</li>
<?php endif; ?>
