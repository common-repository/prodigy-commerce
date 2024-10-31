<?php
/* Template Name: All products */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
\Prodigy\Includes\Helpers\Prodigy_Template::prodigy_get_template_part( 'content', '404' );
get_footer();

