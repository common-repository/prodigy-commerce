<?php

use Prodigy\Includes\Prodigy;

/* Template Name: Shop */

// for check page in theme
$GLOBALS['quick_view'] = false;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * @hooked prodigy_output_content_wrapper -10
 * @hooked prodigy_container_shop_block -20
 */
do_action( 'prodigy_before_main_content' );

?>
<?php if ( ! is_singular( Prodigy::get_prodigy_product_type() ) ) : ?>
	<div class="prodigy-sort-container prodigy-custom-template">
		<div class="prodigy-sort-container__inner container-fluid">
			<div class="row justify-content-center ml-0 mr-0">
				<div class="col-12 prodigy-sort-container__col pl-0 pr-0">
					<div class="prodigy-top-bar">
						<?php
						/**
						 * @hooked prodigy_shop_get_breadcrumbs_template
						 */
						do_action( 'prodigy_shop_breadcrumbs_block' );
						?>
					</div>
				</div>
				<div class="col-12 pl-0 pr-0">
					<div class="prodigy-divider-block prodigy-divider-block--light w-100"></div>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php

/**
 * @hooked prodigy_shop_get_content_template - 10
 */
do_action( 'prodigy_shop_get_content', array( 'content' => $content ?? '' ) );

/**
 * @hooked prodigy_output_content_wrapper_end - 10
 */
do_action( 'prodigy_after_main_content' );
?>

<?php get_footer(); ?>
