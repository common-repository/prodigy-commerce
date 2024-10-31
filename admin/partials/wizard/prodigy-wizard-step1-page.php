<?php
	use Prodigy\Includes\Prodigy;

	global $wp_session;
?>
<?php

defined( 'ABSPATH' ) || exit;
$nonce = wp_create_nonce( 'wizard-form' );
$url = admin_url( 'index.php?page=prodigy-setup&step=2&_wpnonce=' . $nonce );
?>

<form method="post" action="<?php echo esc_url( $url ) ?>" id="form_setting">
<div class="form__body">
	<div class="form__txt-wrp">
		<span class="form__txt"><?php esc_html_e( 'Connect your WP Plugin with the Prodigy Cloud Platform', 'prodigy' ); ?>:</span>
		<?php if ( $this->is_connected ) : ?>
			<span class="wp-connect-state pill"><?php esc_html_e( 'Connected', 'prodigy' ); ?></span>
		<?php endif; ?>
	</div>
	<?php if ( $this->is_connected ) : ?>
	<div class="font__card-outline">
		<div class="store-info">
			<div class="store-info__inner">
				<span class="store-info__label"><?php esc_html_e( 'Store name', 'prodigy' ); ?></span>
				<span class="store-info__name fw-700"><?php echo esc_html( $this->domain_hosted_system ); ?></span>
			</div>
			<div class="store-info__inner">
				<span class="store-info__label"><?php esc_html_e( 'Subdomain', 'prodigy' ); ?></span>
				<span class="store-info__name fw-700">
					<a target="_blank" class="link-wizard" href="<?php esc_html( PRODIGY_PROTOCOL_DOMAIN . $this->url_domain_hosted_system . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>" >
						<?php echo esc_html( PRODIGY_PROTOCOL_DOMAIN . $this->url_domain_hosted_system . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>
					</a>
				</span>
			</div>
		</div>
		<?php if ( empty( get_option( Prodigy::PRODIGY_FIRST_CONNECTED_PRODUCT ) ) ) : ?>
			<p class="mb-16">
				<?php esc_html_e( 'This store will be disconnected if you connect a different store. Please note that proceeding with this action will clear the previous store\'s products, categories, and attributes from the WordPress database and automatically sync the new store.', 'prodigy' ); ?>
			</p>
				<a class="btn" href="<?php echo esc_url( $this->get_url_login_hosted_system() ); ?>">
					<svg class="mr-12" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0h20v20H0z" />
							<path
								d="M15.48 7.02l-2.126 2.126a.5.5 0 00.353.854H15c0 2.758-2.242 5-5 5a4.892 4.892 0 01-2.333-.583L6.45 15.633A6.609 6.609 0 0010 16.667 6.665 6.665 0 0016.667 10h1.293a.5.5 0 00.353-.854L16.187 7.02a.5.5 0 00-.707 0zM5 10c0-2.758 2.242-5 5-5 .842 0 1.642.208 2.333.583l1.217-1.216A6.609 6.609 0 0010 3.333 6.665 6.665 0 003.333 10H2.04a.5.5 0 00-.353.854l2.126 2.126a.5.5 0 00.707 0l2.126-2.126A.5.5 0 006.293 10H5z"
								fill="#008EFF"
							/>
						</g>
					</svg>
					<?php esc_html_e( 'Connect Different Store', 'prodigy' ); ?>
				</a>
		<?php endif; ?>
	<?php else : ?>
		<div>
			<button class="btn btn--blue btn--large connect-button-js" href="<?php echo esc_url( $this->get_url_login_hosted_system() ); ?>">
				<svg class="mr-12" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
					<g fill="none" fill-rule="evenodd">
						<path d="M0 0h20v20H0z" />
						<path
							d="M15.48 7.02l-2.126 2.126a.5.5 0 00.353.854H15c0 2.758-2.242 5-5 5a4.892 4.892 0 01-2.333-.583L6.45 15.633A6.609 6.609 0 0010 16.667 6.665 6.665 0 0016.667 10h1.293a.5.5 0 00.353-.854L16.187 7.02a.5.5 0 00-.707 0zM5 10c0-2.758 2.242-5 5-5 .842 0 1.642.208 2.333.583l1.217-1.216A6.609 6.609 0 0010 3.333 6.665 6.665 0 003.333 10H2.04a.5.5 0 00-.353.854l2.126 2.126a.5.5 0 00.707 0l2.126-2.126A.5.5 0 006.293 10H5z"
							fill="#FFFFFF"
						/>
					</g>
				</svg>
				<span>
					<?php esc_html_e( 'Connect', 'prodigy' ); ?>
				</span>
			</button>
		</div>
	<?php endif; ?>
	<?php if ( isset( $wp_session['message_error_connection'] ) ) : ?>
		<p class="prodigy-error"><?php esc_html_e( 'Connection error:', 'prodigy' ); ?> <?php esc_html( $wp_session['message_error_connection'] ); ?></p>
	<?php endif; ?>
	</div>
	<?php if ( $this->is_connected ) : ?>
		<div class="form__footer">
			<button id="c" class="btn btn--blue btn--large">
				<?php esc_html_e( 'Continue', 'prodigy' ); ?>
			</button>
		</div>
	<?php endif; ?>
	<p class="text-center d-md-none">
		<a href="#" class="link-wizard">
			<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
		</a>
	</p>
</div>

</form>

