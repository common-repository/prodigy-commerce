<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php if ( ! empty( $comment->comment_approved ) ) : ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="prodigy-review__item">
		<div class="prodigy-review__info">
			<div class="prodigy-review__info-inner">
				<?php
					do_action( 'prodigy_review_meta', $comment );
					do_action( 'prodigy_review_before_comment_meta', $comment );
				?>
			</div>
			<?php
				do_action( 'prodigy_review_before_comment_text', $comment );
				do_action( 'prodigy_review_comment_text', $comment );
				do_action( 'prodigy_review_after_comment_text', $comment );
			?>
		</div>
	</div>
	<style>.comment.depth-1{ margin-left: 0;}</style>
	<?php
endif;
