<?php

use Prodigy\Includes\Prodigy_Product_Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $comment;
$rating = (int) get_comment_meta( $comment->comment_ID, Prodigy_Product_Comments::PRODIGY_RATING, true );

if ( $rating ) {
	echo pg_get_rating_html( $rating );
}
