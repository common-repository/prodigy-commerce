<?php use Prodigy\Includes\Prodigy;

defined( 'ABSPATH' ) || exit; ?>
<?php
$post_slug = Prodigy::get_prodigy_product_type();
?>

<form method="post" action="<?php echo esc_url( admin_url() . 'index.php' ); ?>" id="form_setting">
	<input type="hidden" class="wizard-nonce-js" value="<?php echo esc_attr( wp_create_nonce( 'wizard-form' ) ); ?>">
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

	<div class="alert alert--error d-none wizard-error-js" role="alert">
		<svg class="alert__icon" viewBox="0 0 20 20" width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<defs>
				<path
					d="M10 .833c5.054 0 9.167 4.113 9.167 9.167 0 5.054-4.113 9.167-9.167 9.167C4.946 19.167.833 15.054.833 10 .833 4.946 4.946.833 10 .833zM10 2.5c-4.135 0-7.5 3.365-7.5 7.5 0 4.136 3.365 7.5 7.5 7.5 4.136 0 7.5-3.364 7.5-7.5 0-4.135-3.364-7.5-7.5-7.5zm-.317 10.067a.826.826 0 01.634 0 .86.86 0 01.275.175.962.962 0 01.175.275.83.83 0 01-.175.908.828.828 0 01-.909.175.962.962 0 01-.275-.175.828.828 0 01-.175-.908c.042-.1.1-.192.175-.275a.86.86 0 01.275-.175zM10 5.833c.46 0 .833.374.833.834V10a.834.834 0 01-1.666 0V6.667c0-.46.373-.834.833-.834z"
					id="a" />
			</defs>
			<use fill="#FF4E84" xlink:href="#a" fill-rule="evenodd" />
		</svg>
		<p class="alert__txt wizard-error-message-js">
			<?php esc_html_e( 'Error installing Home Page, please click \'Continue\' again or skip the step and finish later.', 'prodigy' ); ?>
		</p>
	</div>
	<label class="checkbox" for="products">
		<input class="checkbox__input" type="checkbox" hidden="hidden" id="products" name="products">
		<div class="checkbox__label">
			<svg class="checkbox__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
				<path fill="#fff" fill-rule="nonzero" d="M17.2 6l-7.97 8.76-2.69-2.68L5 13.62l4.3 4.3 9.5-10.45z"></path>
			</svg>
		</div>
		<span class="checkbox__txt">
			<span class="bold">
				<?php esc_html_e( 'Products', 'prodigy' ); ?>
			</span>
			<?php esc_html_e( 'This will create demo Products, Categories, and Tags.', 'prodigy' ); ?>
		</span>
	</label>
	<div class="form__footer form__footer--between">
		<div class="d-flex align-items-center">
			<?php
			$nonce = wp_create_nonce( 'wizard-form' );
			$url = admin_url( 'index.php?page=prodigy-setup&step=1&_wpnonce=' . $nonce );
			?>
			<a class="link-wizard d-flex align-items-center" href="<?php echo esc_url( $url ); ?>">
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
				<a href="<?php echo esc_url( admin_url() . 'edit.php?post_type=' . Prodigy::get_prodigy_product_type() . '&page=prodigy_settings' ); ?>" class="btn btn--large" role="button">
					<?php esc_html_e( 'Skip this step', 'prodigy' ); ?>
				</a>
			<button class="btn btn--blue btn--large install-demo-content-js d-flex">
				<svg class="d-none" width="19" height="19" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<defs>
						<path
						d="M14.152 4.652c0 2.203-3.305 2.203-3.305 0s3.305-2.203 3.305 0m-.826 16.521c0 1.102-1.653 1.102-1.653 0 0-1.1 1.653-1.1 1.653 0M9.677 4.996c1.01 1.75-1.613 3.264-2.623 1.515-1.009-1.749 1.614-3.263 2.623-1.515m7.551 14.73c.46.797-.732 1.485-1.19.69-.46-.795.731-1.484 1.19-.69M6.031 7.596c1.59.917.213 3.302-1.376 2.384-1.59-.918-.214-3.303 1.376-2.385m13.9 8.967c.636.367.085 1.321-.55.954-.637-.367-.086-1.32.55-.954M5.478 12.913c0 1.652-2.478 1.652-2.478 0 0-1.653 2.478-1.653 2.478 0m15.695 0c0 .551-.826.551-.826 0 0-.55.826-.55.826 0M6.294 16.496c.734 1.27-1.173 2.372-1.908 1.1-.734-1.27 1.174-2.373 1.908-1.1m13.602-7.854c.184.318-.293.593-.476.275-.184-.318.293-.594.476-.275M8.856 19.235c1.112.643.15 2.312-.964 1.67-1.113-.644-.15-2.313.963-1.67"
						id="load" />
					</defs>
					<use fill="#FFF" xlink:href="#load" transform="translate(-3 -3)" fill-rule="evenodd" />
				</svg>
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
</form>


<script>

	jQuery(function ($) {
		const input_synchronization = $(".install-demo-content-js");
		let list_demo_checked = [];

		input_synchronization.click(false);

		/*
		 * Synchronize content to hosted system
		 */
		input_synchronization.on('click', input_synchronization, function () {
			$(this).find('svg').removeClass('d-none').addClass('loading');
			$(this).prop('disabled', true);
			$('#form_setting *').filter(':input').each(function(){

				if ($(this).prop('checked') === true) {
					let name_con = $(this).prop('name');
					list_demo_checked.push(name_con);
				}

				$(this).prop('disabled', true);
			});
			set_send(this);
		});

		function set_send(_this) {
			let elem_demo = list_demo_checked.shift();
            let wizard_nonce = $('.wizard-nonce-js').val();

			if (elem_demo === undefined) {
				$('#form_setting *').filter(':input').each(function(){
					input_synchronization.prop('disabled', false);
				});
				$('.install-demo-content-js').prop('disabled', false);
				$('.install-demo-content-js svg').removeClass('loading').addClass('d-none');
				window.location.href = 'edit.php?post_type=' + '<?php echo esc_html( $post_slug ); ?>' + '&page=prodigy_settings';
				return;
			}

			$.ajax({
				dataType: 'json',
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'install_demo_content',
					item_demo: elem_demo,
					nonce: wizard_nonce
				},
				success: function (data) {
					if (elem_demo !== undefined) {
						$('.status-install-'+elem_demo+'-js').html('Installed');
						set_send();
					}

					return true;
				},
				error: function (data) {
					$('.wizard-error-js').removeClass('d-none');
					$('.wizard-error-message-js').text(data.responseJSON.data);
					return true;
				}
			});

			return true;
		}
	});

</script>
