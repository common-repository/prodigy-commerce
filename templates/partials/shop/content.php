<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="prodigy-custom-template">
	<div class="prodigy-catalog container-fluid pl-0 pr-0">
		<div class="row ml-0 mr-0 flex-md-nowrap">

			<?php
			/**
			 * @hooked prodigy_shop_sidebar_template - 10
			 */
			do_action( 'prodigy_shop_sidebar' );

			do_action( 'prodigy_shop_before_loop' );

			/**
			 * @hooked prodigy_get_template_products_loop - 10
			 */
			do_action( 'prodigy_shop_products_loop', array( 'content' => $content ) );

			/**
			 * @hooked prodigy_get_pagination_template - 10
			 */
			do_action( 'prodigy_shop_after_loop' );

			?>
		</div>
	</div>

</div>
