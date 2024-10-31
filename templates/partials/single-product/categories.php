<?php

defined( 'ABSPATH' ) || exit;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Prodigy;

$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
$product = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );

$main_sku         = $product->get_remote_main_sku();
$categories       = $product->get_remote_categories();
$categories_count = count( $categories );

?>

<ul class="prodigy-product__tags">
	<?php if ( ! empty( $main_sku ) ) : ?>
		<li class="prodigy-product__tags-item product_sku">
			<?php echo 'Sku'; ?>
			<span class="prodigy-product__tags-text product_sku_value">
				<?php echo esc_attr( $main_sku ); ?>
			</span>
		</li>
	<?php endif; ?>
	
	<?php if ( is_array( $product->get_remote_categories() ) ) : ?>
		<li class="prodigy-product__tags-item">
			<?php echo esc_attr( _n( 'Category:', 'Categories:', $categories_count, 'prodigy' ) ); ?>
			<span class="prodigy-product__tags-text">
				<?php
				foreach ( $categories as $key_cat => $remote_category ) {
					$category_info = get_term_by( 'name', $remote_category, Prodigy::get_prodigy_category_type() );
					$category_link = get_category_link( $category_info->term_id );
					echo '<a href="' . esc_attr( $category_link ) . '">' . esc_attr( $remote_category ) . '</a>';
					if ( ++ $key_cat != $categories_count ) {
						echo ', ';
					}
				}
				?>
			</span>
		</li>
	<?php endif; ?>
</ul>
