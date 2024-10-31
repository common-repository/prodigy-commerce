<?php /* Template Name: Thank-you shortcode */
use Prodigy\Includes\Helpers\Prodigy_Page;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="prodigy-custom-template">
    <div class="container prodigy-thank-you-page">
        <div class="row mb-80">
            <div class="col-12 pl-0 pr-0">
                <div class="d-flex flex-column align-items-center">

					<?php if ( $divi_editor || !empty( $order_info ) ) : ?>
                        <h2 class="prodigy-thank-you-page__title">
							<?php echo esc_html( $args['message'] ?? '' ); ?>
                        </h2>
                        <div class="prodigy-thank-you-page__txt prodigy-thanks-txt__content">
                            <p class="mb-0 text-center">
								<?php
								echo sprintf(
									__( 'Order %s is successfully placed.', 'prodigy' ),
									'<span class="font-bold">#' . esc_attr( $order_remote ) . '</span>'
								);
								?>
                            </p>
                        </div>
						<?php if ( $is_approval ): ?>
                            <h5 class="prodigy-thank-you-page__approval-message">
								<?php esc_html_e( "Your order has been sent for approval.", "prodigy" ); ?>
                                <br class="d-md-none"/>
								<?php esc_html_e( " You will receive an email with a reply.", "prodigy" ); ?>
                            </h5>
						<?php endif; ?>
					<?php else : ?>
                        <h2 class="prodigy-thank-you-page__title">
							<?php esc_html_e( "This order", "prodigy" ); ?>
                            <br class="d-md-none">
                            <?php esc_html_e( " does not exist.", "prodigy" ); ?>
                        </h2>
						<?php if ( $is_approval ): ?>
                            <h5 class="prodigy-thank-you-page__approval-message">
								<?php esc_html_e( "Your order has been sent for approval.", "prodigy" ); ?>
                                <br class="d-md-none"/>
								<?php esc_html_e( " You will receive an email with a reply.", "prodigy" ); ?>
                            </h5>
						<?php endif; ?>
					<?php endif; ?>
                    <a class="prodigy-main-button prodigy-main-button--link prodigy-main-button--wide prodigy-thanks-txt__content"
                       href="<?php echo Prodigy_Page::prodigy_get_shop_url(); ?>">
						<?php esc_html_e( "Back to shop list", "prodigy" ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script
        src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/feature-products.js' ) ) . 'feature-products.js'; ?>">
</script>
