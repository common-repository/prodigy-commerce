<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// get description
$product = $GLOBALS['prodigy_product'];
echo $product->get_remote_description();
