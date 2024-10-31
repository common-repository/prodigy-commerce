<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customizer_general_options = get_option( 'prodigy_general_options' );
$width_container            = $customizer_general_options['prodigy_width_container'] ?? 1200;
?>
<div id="prodigy-primary" class="prodigy-content-area prodigy-custom-template"><div id="prodigy-main" style="max-width:<?php echo esc_attr( $width_container ); ?>px" class="prodigy-customized-wrapper" role="main">
