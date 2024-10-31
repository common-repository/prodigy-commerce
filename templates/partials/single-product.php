<?php

defined( 'ABSPATH' ) || exit;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Helpers\Prodigy_Template;

$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
$product          = $product_template->get_product( (int) get_the_ID() );
// set current product to $GLOBAL
$customizer_general_options = get_option( 'prodigy_general_options' );


get_header();
?>

<?php
/**
 * prodigy_before_main_content hook.
 *
 * @hooked prodigy_output_content_wrapper - 10
 */
do_action( 'prodigy_before_main_content' );
?>
<?php
while ( have_posts() ) :
	the_post();
	?>
	<?php Prodigy_Template::prodigy_get_template_part( 'content', 'single-product' ); ?>
<?php endwhile; // end of the loop. ?>

<?php
/**
 * prodigy_after_main_content hook.
 *
 * @hooked prodigy_output_content_wrapper_end - 10
 * @hooked prodigy_product_get_captcha - 20
 */
do_action( 'prodigy_after_main_content' );
?>

<?php
get_footer();

