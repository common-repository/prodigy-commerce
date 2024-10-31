<?php defined( 'ABSPATH' ) || exit; ?>
<?php if ( isset( $product['rating'] ) ) : ?>
	<div class="prodigy-product-list__item-rating prodigy-custom-template">
		<?php echo pg_get_rating_html( $product['rating'] ); ?>
	</div>
<?php endif; ?>
