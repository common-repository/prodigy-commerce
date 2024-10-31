<?php

defined( 'ABSPATH' ) || exit;

global $comment;

$pg_comment_time = prodigy_get_comment_time( $comment->comment_ID );
$thumburl        = wp_get_attachment_thumb_url( get_option( 'pg_image_logo' ) );

$get_author_id       = get_the_author_meta( 'ID' );
$get_author_gravatar = get_avatar_url( $get_author_id, array( 'size' => 450 ) );

if ( ! empty( $comment->comment_parent ) ) : ?>
		<?php if ( ! empty( $thumburl ) ) : ?>
			<div class="prodigy-review__avatar-wrapper">
				<img alt=""
						src="<?php echo esc_url( $thumburl ); ?>"
						srcset="<?php echo esc_url( $thumburl ); ?> 2x"
						class="prodigy-review__avatar"
						height="40"
						width="40"
				>
			</div>
		<?php else : ?>
			<img alt="" src="http://1.gravatar.com/avatar/dd0a1379e1b86d32c0f21e10d1a2a7dd?s=60&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/dd0a1379e1b86d32c0f21e10d1a2a7dd?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60">
		<?php endif; ?>
<?php endif; ?>
	<div class="prodigy-review__avatar-wrapper">
		<span class="prodigy-review__date"><?php echo esc_html( $pg_comment_time ); ?></span>
	</div>

<p class="prodigy-review__title meta">
	<span class="prodigy-review__author">
		<?php if ( ! empty( $comment->comment_parent ) ) : ?>
			<span class="prodigy-review__author-response"><?php echo esc_html( "Response from", "prodigy" ); ?></span>
		<?php endif; ?>
		<?php comment_author(); ?>
	</span>
</p>

<?php
