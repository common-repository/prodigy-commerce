<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( isset( $settings ) ) {
	$settings['settings']['product'] = $GLOBALS['prodigy_product'];

	do_action( 'prodigy_product_additional_information', $settings );
} else {
	do_action( 'prodigy_product_additional_information' );
}
