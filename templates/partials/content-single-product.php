<?php
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
do_action( 'prodigy_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

$is_quick_view = $GLOBALS['quick_view'] ?? false;

$is_admin = Prodigy\Includes\Helpers\Prodigy_Template::prodigy_is_admin() ? 1 : 0;
?>
<div class="prodigy-custom-template">
	<div class="prodigy-container container-fluid">
		<input type="hidden" data-attr="<?php echo esc_attr( $is_admin ); ?>" id="user-role-js">
		<input type="hidden" data-attr="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>" class="pg-cart-url-js">

		<div class="prodigy-product row product-container-js">
			<?php
			/**
			 * Hook: prodigy_before_single_product_summary.
			 *
			 * @hooked prodigy_show_product_images - 20
			 */
			do_action( 'prodigy_before_single_product_summary' );
			?>

			<div class="prodigy-product__info col-md-6 prodigy-order-1">
				<?php
				/**
				 * Hook: prodigy_single_product_summary.
				 *
				 * @hooked prodigy_single_product_breadcrumbs_template - 1
				 * @hooked prodigy_product_template_title - 5
				 * @hooked prodigy_product_range_price- 7
				 * @hooked prodigy_product_template_meta - 10
				 * @hooked prodigy_product_template_rating - 15
				 * @hooked prodigy_product_template_short_description - 20
				 */
				do_action( 'prodigy_product_summary_first' );

				/**
				 * @hooked prodigy_product_template_variants - 25
				 * @hooked prodigy_product_template_add_to_cart - 30
				 */
				do_action( 'prodigy_product_summary_second' );
				?>

				<ul class="prodigy-product__tags">

					<?php

					/**
					 * Hook: prodigy_product_additional_info.
					 *
					 * @hooked prodigy_product_template_categories - 5
					 * @hooked prodigy_product_template_sku - 10
					 * @hooked prodigy_product_template_tags - 15
					 */
					do_action( 'prodigy_product_additional_info' );

					?>
				</ul>

			</div>
		</div>

		<?php
		/**
		 * Hook: prodigy_after_single_product_summary.
		 *
		 * @hooked prodigy_output_product_data_tabs - 10
		 * @hooked prodigy_upsell_products_display - 15
		 */
		if ( ! $is_quick_view ) {
			do_action( 'prodigy_after_single_product_tabs' );
			do_action( 'prodigy_shortcode_template_products' );
		}
		do_action( 'prodigy_after_single_product' );
		?>

		<script
			src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . 'includes/frontend/shortcodes/js/feature-products.js' ) ) . 'feature-products.js'; ?>">
		</script>
	</div>
</div>
