<?php
use Prodigy\Includes\Prodigy_Pagination;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Prodigy_Pagination::prodigy_pagination( isset( $data ) ? (array) $data : array(), $data['pages'] ?? 1 );
