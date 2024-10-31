<?php use Prodigy\Includes\Prodigy;

defined( 'ABSPATH' ) || exit; ?>

	<p class="text-center d-md-none">
		<a href="<?php echo esc_url( admin_url() ); ?>" class="link-wizard">
			<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
		</a>
	</p>
	<!-- 1 -->
	<div class="d-none">
		<img
			src="<?php echo esc_url( Prodigy::plugin_url() . '/' . PRODIGY_WIZARD_PATH . '/images/logo.svg' ); ?>"
			alt="<?php esc_attr_e( 'Prodigy', 'prodigy' ); ?>" class="logo"
		/>
		<ul class="steps">
			<li class="step step--active step--next-disabled">
				<?php esc_html_e( 'Connection', 'prodigy' ); ?>
			</li>
			<li class="step">
				<?php esc_html_e( 'Demo Content', 'prodigy' ); ?>
			</li>
		</ul>
		<div class="form">
			<div class="form__header">
				<h1 class="form__title">
					<?php esc_html_e( 'Data Synchronization', 'prodigy' ); ?>
				</h1>
				<a href="http://prodigy:8888/wp-admin/" class="link-wizard d-none d-md-block">
					<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
				</a>
			</div>
			<div class="form__txt-wrp">
				<span class="form__txt">
					<?php esc_html_e( 'Connect your WP Plugin with the Prodigy Cloud Platform:', 'prodigy' ); ?>
				</span>
			</div>
			<div>
				<button class="btn btn--blue btn--large">
					<svg class="mr-12" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0h20v20H0z" />
							<path
								d="M15.48 7.02l-2.126 2.126a.5.5 0 00.353.854H15c0 2.758-2.242 5-5 5a4.892 4.892 0 01-2.333-.583L6.45 15.633A6.609 6.609 0 0010 16.667 6.665 6.665 0 0016.667 10h1.293a.5.5 0 00.353-.854L16.187 7.02a.5.5 0 00-.707 0zM5 10c0-2.758 2.242-5 5-5 .842 0 1.642.208 2.333.583l1.217-1.216A6.609 6.609 0 0010 3.333 6.665 6.665 0 003.333 10H2.04a.5.5 0 00-.353.854l2.126 2.126a.5.5 0 00.707 0l2.126-2.126A.5.5 0 006.293 10H5z"
								fill="#FFFFFF" />
						</g>
					</svg>
					<span><?php esc_html_e( 'Connect', 'prodigy' ); ?></span>
				</button>
			</div>
		</div>
		<p class="text-center d-md-none">
			<a href="#" class="link-wizard">
				<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
			</a>
		</p>
	</div>
	<!-- 2 -->
	<div class="d-none">
		<img
			src="<?php echo esc_url( Prodigy::plugin_url() . '/' . PRODIGY_WIZARD_PATH . '/images/logo.svg' ); ?>"
			alt="<?php esc_attr_e( 'Prodigy', 'prodigy' ); ?>" class="logo"
		/>
		<ul class="steps">
			<li class="step step--active step--next-disabled">
				<?php esc_html_e( 'Connection', 'prodigy' ); ?>
			</li>
			<li class="step">
				<?php esc_html_e( 'Demo Content', 'prodigy' ); ?>
			</li>
		</ul>
		<div class="form">
			<div class="form__header">
				<h1 class="form__title">
					<?php esc_html_e( 'Data Synchronization', 'prodigy' ); ?>
				</h1>
				<a href="http://prodigy:8888/wp-admin/" class="link-wizard d-none d-md-block">
					<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
				</a>
			</div>
			<div class="form__txt-wrp">
				<span class="form__txt">
					<?php esc_html_e( 'Connect your WP Plugin with the Prodigy Cloud Platform:', 'prodigy' ); ?>
				</span>
				<span class="wp-connect-state pill">
					<?php esc_html_e( 'Connected', 'prodigy' ); ?>
				</span>
			</div>
			<div class="font__card-outline">
				<div class="store-info">
					<div class="store-info__inner">
						<span class="store-info__label">
							<?php esc_html_e( 'Store name', 'prodigy' ); ?>
						</span>
						<span class="store-info__name">
							<?php esc_html_e( 'example', 'prodigy' ); ?>
						</span>
					</div>
					<div class="store-info__inner">
						<span class="store-info__label">
							<?php esc_html_e( 'Subdomain', 'prodigy' ); ?>
						</span>
						<a href="#" class="link-wizard">http://example.develop.prodigycommerce.com</a>
					</div>
				</div>
				<p class="mb-16">
					<?php esc_html_e( 'You can change the store that your WP Plugin is connected to if you have not yet created any products or categories.', 'prodigy' ); ?>
				</p>
				<button class="btn">
					<svg class="mr-12" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0h20v20H0z" />
							<path
								d="M15.48 7.02l-2.126 2.126a.5.5 0 00.353.854H15c0 2.758-2.242 5-5 5a4.892 4.892 0 01-2.333-.583L6.45 15.633A6.609 6.609 0 0010 16.667 6.665 6.665 0 0016.667 10h1.293a.5.5 0 00.353-.854L16.187 7.02a.5.5 0 00-.707 0zM5 10c0-2.758 2.242-5 5-5 .842 0 1.642.208 2.333.583l1.217-1.216A6.609 6.609 0 0010 3.333 6.665 6.665 0 003.333 10H2.04a.5.5 0 00-.353.854l2.126 2.126a.5.5 0 00.707 0l2.126-2.126A.5.5 0 006.293 10H5z"
								fill="#008EFF"
							/>
						</g>
					</svg>
					<span>
						<?php esc_html_e( 'Connect another store', 'prodigy' ); ?>
					</span>
				</button>
			</div>
			<div class="form__footer">
				<button class="btn btn--blue btn--large">
					<?php esc_html_e( 'Continue', 'prodigy' ); ?>
				</button>
			</div>
		</div>
		<p class="text-center d-md-none">
			<a href="#" class="link-wizard">
				<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
			</a>
		</p>
	</div>
	<!-- 4 -->
	<div class="d-none">
		<img
			src="<?php echo esc_url( Prodigy::plugin_url() . '/' . PRODIGY_WIZARD_PATH . '/images/logo.svg' ); ?>"
			alt="<?php esc_attr_e( 'Prodigy', 'prodigy' ); ?>" class="logo"
		>
		<ul class="steps">
			<li class="step step--complete">
				<?php esc_html_e( 'Connection', 'prodigy' ); ?>
			</li>
			<li class="step step--active">
				<?php esc_html_e( 'Demo Content', 'prodigy' ); ?>
			</li>
		</ul>
		<div class="form">
			<div class="form__header">
				<h1 class="form__title">
					<?php esc_html_e( 'Demo Content', 'prodigy' ); ?>
				</h1>
				<a href="http://prodigy:8888/wp-admin/" class="link-wizard d-none d-md-block">
					<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
				</a>
			</div>
			<div class="form__txt-wrp">
				<span class="form__txt">
					<?php esc_html_e( 'We recommend installing the demo content to get a quick understanding of how the platform works. This is optional and you can always delete the demo content.', 'prodigy' ); ?>
				</span>
			</div>
			<div class="prodigy-divider-block"></div>
			<h2>
				<?php esc_html_e( 'Install Demo Content', 'prodigy' ); ?>
			</h2>
			<p>
				<?php esc_html_e( 'Choose the demo data that you would like to install below and click continue.', 'prodigy' ); ?>
			</p>
			<div class="alert alert--error" role="alert">
				<svg class="alert__icon" viewBox="0 0 20 20" width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<defs>
						<path
							d="M10 .833c5.054 0 9.167 4.113 9.167 9.167 0 5.054-4.113 9.167-9.167 9.167C4.946 19.167.833 15.054.833 10 .833 4.946 4.946.833 10 .833zM10 2.5c-4.135 0-7.5 3.365-7.5 7.5 0 4.136 3.365 7.5 7.5 7.5 4.136 0 7.5-3.364 7.5-7.5 0-4.135-3.364-7.5-7.5-7.5zm-.317 10.067a.826.826 0 01.634 0 .86.86 0 01.275.175.962.962 0 01.175.275.83.83 0 01-.175.908.828.828 0 01-.909.175.962.962 0 01-.275-.175.828.828 0 01-.175-.908c.042-.1.1-.192.175-.275a.86.86 0 01.275-.175zM10 5.833c.46 0 .833.374.833.834V10a.834.834 0 01-1.666 0V6.667c0-.46.373-.834.833-.834z"
							id="a" />
					</defs>
					<use fill="#FF4E84" xlink:href="#a" fill-rule="evenodd" />
				</svg>
				<p class="alert__txt">
					<?php esc_html_e( 'Error installing Home Page, please click \'Continue\' again or skip the step and finish later', 'prodigy' ); ?>
				</p>
			</div>
			<label class="checkbox" for="is-install-homepage-2">
				<input class="checkbox__input" type="checkbox" hidden="hidden" id="is-install-homepage-2" name="pg_astra_demo">
				<div class="checkbox__label">
					<svg class="checkbox__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
						<path fill="#fff" fill-rule="nonzero" d="M17.2 6l-7.97 8.76-2.69-2.68L5 13.62l4.3 4.3 9.5-10.45z"></path>
					</svg>
				</div>
				<span class="checkbox__txt">
					<span class="bold">
						<?php esc_html_e( 'Home Page', 'prodigy' ); ?>
					</span>
					<?php esc_html_e( 'This will create default Pages as seen in the demo.', 'prodigy' ); ?>
				</span>
			</label>
			<label class="checkbox" for="is-install-products-2">
				<input class="checkbox__input" type="checkbox" hidden="hidden" id="is-install-products-2" name="pg_astra_demo">
				<div class="checkbox__label">
					<svg class="checkbox__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
						<path fill="#fff" fill-rule="nonzero" d="M17.2 6l-7.97 8.76-2.69-2.68L5 13.62l4.3 4.3 9.5-10.45z"></path>
					</svg>
				</div>
				<label class="checkbox__txt">
					<span class="bold">
						<?php esc_html_e( 'Products', 'prodigy' ); ?>
					</span>
					<?php esc_html_e( 'This will create default Products as seen in the demo.', 'prodigy' ); ?>
				</label>
			</label>
			<div class="form__footer form__footer--between">
				<div class="d-flex align-items-center">
					<a class="link-wizard d-flex align-items-center" href="#">
						<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<defs>
								<path
									d="M8.866 10.244a.778.778 0 00-1.132 0 .858.858 0 000 1.179l3.2 3.333a.778.778 0 001.132 0l3.2-3.333a.858.858 0 000-1.179.778.778 0 00-1.132 0L11.5 12.988l-2.634-2.744z"
									id="a2" />
							</defs>
							<g fill="none" fill-rule="evenodd">
								<path d="M0 0h24v24H0z" />
								<mask id="b2" fill="#fff">
									<use xlink:href="#a2" />
								</mask>
								<use fill="#000" fill-rule="nonzero" opacity=".01" transform="rotate(90 11.5 12.5)" xlink:href="#a2" />
								<g mask="url(#b2)" fill="#008EFF">
									<path d="M0 0h24v24H0z" />
								</g>
							</g>
						</svg>
						<?php esc_html_e( 'Back to Connection', 'prodigy' ); ?>
					</a>
				</div>
				<div class="d-flex align-items-center">
					<button class="btn btn--large">
						<?php esc_html_e( 'Skip this step', 'prodigy' ); ?>
					</button>
					<button class="btn btn--blue btn--large">
						<?php esc_html_e( 'Continue', 'prodigy' ); ?>
					</button>
				</div>
			</div>
		</div>
		<p class="text-center d-md-none">
			<a href="#" class="link-wizard">
				<?php esc_html_e( 'Back to Dashboard', 'prodigy' ); ?>
			</a>
		</p>
	</div>
</div>
	<?php
	do_action( 'admin_footer' );
	do_action( 'admin_print_footer_scripts' );
	?>
</body>
</html>
