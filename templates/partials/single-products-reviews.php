<?php
global $post_id;

use Prodigy\Includes\Frontend\Pages\Prodigy_Product_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>

<div class="prodigy-reviews-ratings">
	<div class="d-flex align-items-center">
		<div class="prodigy-reviews-ratings__rating">
			<h3 class="review-rating-title"><?php echo $rating_title; ?></h3>
			<div class="d-flex align-items-center flex-wrap">
				<?php if ( get_option( 'pg_product_rating' ) ) : ?>
					<?php echo pg_get_rating_html( $average ); ?>
				<?php endif; ?>

				<?php if ( comments_open() ) : ?>
					<?php if ( get_option( 'pg_product_review' ) ) : ?>
						<div class="d-flex align-items-center">
							<span class="prodigy-reviews-ratings__average">
								<?php echo esc_attr( $average ); ?>
							</span>
							<span class="prodigy-reviews-ratings__count">
									<?php printf( esc_attr( _n( '%s review', '%s reviews', $review_count, 'prodigy' ) ), '' . esc_html( $review_count ) ); ?>
							</span>
						</div>
					<?php endif ?>
				<?php endif ?>
			</div>
		</div>
	</div>

	<button class="prodigy-main-button prodigy-reviews-ratings__btn" type="button" data-toggle="modal" data-target="#reviewModal"><?php esc_html_e( 'Write a review', 'prodigy' ); ?></button>
</div>

<div id="reviews">
	<ul id="comments" class="prodigy-review">

		<?php if ( $review_count ) : ?>
			<?php

			$comments = get_comments(
				array( 'post_id' => $post_id )
			);

			wp_list_comments(
				apply_filters(
					'prodigy_product_review_list_args',
					array(
						'callback' => 'prodigy_comments',
						'per_page' => Prodigy_Product_Page::COUNT_COMMENTS_ON_PAGE_PRODUCT,
						'page'     => 1,
					)
				),
				$comments
			);
			?>

			<?php
			if ( get_comment_pages_count() > 1 ) :
				echo '<nav class="prodigy-pagination">';
				paginate_comments_links(
					apply_filters(
						'prodigy_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php endif; ?>
		<div class="d-flex align-items-center justify-content-center">
			<div class="d-flex align-items-center cursor-pointer link-show-more-reviews-js">
				<span data-page="2" class="per-page-js"><?php esc_html_e( 'Show more reviews', 'prodigy' ); ?></span>
				<i class="icon icon-arrow-down"></i>
			</div>
		</div>
	</ul>
</div>

<div class="modal fade prodigy-review-modal" id="reviewModal">
	<div class="modal-dialog modal-dialog-centered prodigy-review-modal__dialog">
		<div class="container">
			<div class="row">
				<div class="modal-content prodigy-review-modal__content col-md-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
					<div class="prodigy-review-modal__img-wrp d-none d-md-block">
						<?php if ( isset( $product->get_images()[0]['versions']['medium'] ) ) : ?>
							<img src="<?php echo esc_url( $product->get_images()[0]['versions']['medium'] ); ?>" class="mb-20" alt="<?php echo esc_attr( $post_title ); ?>">
						<?php else : ?>
							<i class="icon icon-image mb-20 prodigy-review-modal__img-wrp-icon" style="font-size: 100px;"></i>
						<?php endif; ?>
						<p class="prodigy-review-modal__img-caption"><?php echo esc_attr( $post_title ); ?></p>
					</div>
					<div class="prodigy-review-modal__body">
						<a role="button" rel="noopener" class="icon icon-small-close cursor-pointer prodigy-review-modal__icon-close" data-dismiss="modal" aria-label="Close"></a>
						<div id="review_form_wrapper" class="prodigy-review-modal__form">
							<div id="review_form" class="prodigy-comment">
								<?php
								$commenter = wp_get_current_commenter();

								/*
								* Format standard comments output
								*/
								$comment_form = array(
									'fields'               => array(),
									'submit_field'         => '<div class="form-submit"  style="clear: both">%1$s %2$s</div>',
									'class_submit'         => 'prodigy-main-button submit-product-button cursor-pointer',
									'label_submit'         => esc_html__( 'Post a review', 'prodigy' ),
									'comment_notes_before' => '',
									'submit_button'        => '<button class="prodigy-main-button submit-product-button cursor-pointer" id="submit" type="submit">Post a review</button>',
								);

								/*
								* Google captcha
								*/
								if ( ! empty( get_option( 'pg_captcha_launch' ) ) && ! empty( get_option( 'pg_captcha_site_key' ) ) ) {
									$comment_form['comment_notes_after'] =
										'<div class="g-recaptcha mb-20" id="captcha" data-callback="prodigyRecaptchaCallback" data-sitekey="' . get_option( 'pg_captcha_site_key' ) . '"></div>';
								}

								$is_enable_rating = get_option( 'pg_product_rating' );
								$user             = wp_get_current_user();

								$role = $user->roles[0] ?? '';

								/*
								* Format standard comments output
								*/
								$comment_form['comment_field'] = '';
								if ( ! empty( $is_enable_rating ) && $role !== 'administrator' ) {
									$comment_form['comment_field'] =
										'<div class="prodigy-review-modal__body-section comment-form-rating">
											<label class="prodigy-review-modal__body-label" for="rating">
												' . esc_html__( 'Product rating *', 'prodigy' ) . '
											</label>
											<div class="d-flex align-items-center">
												<select class="prodigy-main-select" name="rating" id="prodigy-rating" required>
													<option value="">' . esc_html__( 'Rate&hellip;', 'prodigy' ) . '</option>
													<option value="5">' . esc_html__( 'Perfect', 'prodigy' ) . '</option>
													<option value="4">' . esc_html__( 'Good', 'prodigy' ) . '</option>
													<option value="3">' . esc_html__( 'Average', 'prodigy' ) . '</option>
													<option value="2">' . esc_html__( 'Not that bad', 'prodigy' ) . '</option>
													<option value="1">' . esc_html__( 'Very poor', 'prodigy' ) . '</option>
												</select>
												<small class="font-14 ml-16 d-none d-md-inline-block">Click to rate</small>
											</div>
                                        </div>';
								}

								$comment_form['comment_field'] .=
									'<div class="prodigy-review-modal__body-section prodigy-review-modal__body-section--column">' . '
                                        <label class="prodigy-review-modal__body-label" for="author">' . esc_html__( 'Your name *', 'prodigy' ) . '
                                        </label>
                                        <input id="author" class="prodigy-review-modal__body-section-text  comment-author-js prodigy-main-input" name="author" type="text" value="' . $author_name_value . '" size="30" required />
                                    </div>';


								if ( get_option( 'require_name_email' ) ) {
									$comment_form['comment_field'] .=
										'<div class="prodigy-review-modal__body-section prodigy-review-modal__body-section--column">' . '
                                        <label class="prodigy-review-modal__body-label" for="author">' . esc_html__( 'Your email *', 'prodigy' ) . '
                                        </label>
                                        <input id="author" class="prodigy-review-modal__body-section-text  comment-email-js prodigy-main-input" name="email" type="email" value="' . $author_email_value . '" size="100" required />
                                    </div>';
								}

								$comment_form['comment_field'] .=
									'<div class="prodigy-review-modal__body-section prodigy-review-modal__body-section--column mb-20">
                                        <label class="prodigy-review-modal__body-label" for="comment">
                                            ' . esc_html__( 'Review *', 'prodigy' ) . '&nbsp;
                                        </label>
                                        <textarea
                                            placeholder="' . esc_html__( 'Write your review here...', 'prodigy' ) . '"
                                            id="comment"
                                            class="prodigy-review-modal__body-section-text prodigy-comment__text prodigy-main-input"
                                            name="comment"
                                            cols="45"
                                            rows="8"
                                            required></textarea>
                                    </div>';

								comment_form( apply_filters( 'prodigy_product_review_comment_form_args', $comment_form ) );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade prodigy-review-modal" id="reviewModalSuccess">
	<div class="modal-dialog modal-dialog-centered prodigy-review-modal__dialog">
		<div class="container">
			<div class="row">
				<div class="modal-content prodigy-review-modal__content col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					<div class="prodigy-review-modal__body">
						<a role="button" rel="noopener" class="icon icon-small-close cursor-pointer prodigy-review-modal__icon-close" data-dismiss="modal" aria-label="Close"></a>
						<div id="review_form_wrapper" class="prodigy-review-modal__form">
							<p class="mb-24 mt-48 text-center"><?php esc_html_e( 'Thank you!', 'prodigy' ); ?></p>
							<p class="mb-48 text-center review-message-popup-js"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
