<?php use Prodigy\Includes\Prodigy_Options;

if ( ! empty( $main_sku ) && $enable_product_sku ) : ?>
	<li class="prodigy-product__tags-item product_sku">
		<span class="prodigy-product__tags-label">
			<?php esc_html_e( 'Sku:', 'prodigy' ); ?>
		</span>
		<span class="prodigy-product__tags-text product_sku_value">
			<?php esc_html_e( $main_sku ); ?>
		</span>
	</li>
<?php endif; ?>
<?php if ( Prodigy_Options::get_redemption_store_status() ) : ?>
	<?php if ( isset( $charge_amount ) && $charge_amount > 0 ) : ?>
	<li class="prodigy-product__tags-item">
		<span class="prodigy-product__tags-label"><?php echo esc_html( 'Setup Charge:' ); ?></span>
		<span class="prodigy-product__tags-text"><?php esc_html_e( get_option( 'pg_currency_type' ) . \Prodigy\Includes\Helpers\Prodigy_Formatting::prodigy_price_format( $charge_amount ) ); ?></span>
	</li>
	<?php endif; ?>
<?php endif; ?>

<?php if ( ! empty( $categories ) && $enable_product_categories ) : ?>
	<li class="prodigy-product__tags-item">
		<span class="prodigy-product__tags-label">
			<?php esc_html_e( _n( 'Category:', 'Categories:', $count_categories, 'prodigy' ) ); ?>
		</span>
		<span class="prodigy-product__tags-text">
			<?php
			foreach ( $categories as $key => $category ) {
				$category_info = get_term_by( 'id', $category->term_id, \Prodigy\Includes\Prodigy::get_prodigy_category_type() );
				$category_link = get_category_link( $category_info->term_id );
				echo '<a href="' . esc_attr( $category_link ) . '">' . esc_attr( $category_info->name ) . '</a>';
				if ( ++$key != $count_categories ) {
					echo ', ';
				}
			}
			?>
		</span>
	</li>
<?php endif; ?>
