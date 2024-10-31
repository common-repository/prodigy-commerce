<?php
/**
 * @var bool $is_connected
 * @var string $domain_hosted_system
 */

use Prodigy\Includes\Helpers\Prodigy_Helper_Hosted_System;

?>

<div id="general" class="prodigy-admin-custom-template">
	<h4 class="prodigy-plugin-settings__subtitle"><?php esc_html_e( 'Setup wizard', 'prodigy' ); ?></h4>
	<p>
	<?php
	esc_html_e(
		'If you need to access the setup wizard again, please click on the button below.',
		'prodigy'
	);
		$nonce = wp_create_nonce( 'wizard-form' );
		$url = admin_url( 'index.php?page=prodigy-setup&step=1&_wpnonce=' . $nonce );
	?>
	</p>

	<div class="d-flex mb-8">
		<a class="button button-primary button-large setup-to-wizard-js" href="<?php echo esc_url( $url ); ?>">
			<?php esc_html_e( 'Setup Wizard', 'prodigy' ); ?>
		</a>
	</div>
	<div class="d-flex align-items-center">
		<h4 class="prodigy-plugin-settings__subtitle">
			<?php esc_html_e( 'API synchronization status', 'prodigy' ); ?>
		</h4>
		<?php if ( $is_connected ) : ?>
			<span class="prodigy-pill ml-16 prodigy-pill--green"><?php esc_html_e( 'Connected', 'prodigy' ); ?></span>
		<?php else : ?>
			<span class="prodigy-pill ml-16"><?php esc_html_e( 'Not connected', 'prodigy' ); ?></span>
		<?php endif; ?>
	</div>
	<?php if ( $is_connected ) : ?>
		<div>
			<div class="d-flex mb-8">
				<span class="button button-primary button-large update-store-js">
					<?php esc_html_e( 'Update Store', 'prodigy' ); ?>
				</span>
				<span class="font-300" hidden="hidden">
                    <?php esc_html_e( 'Data successfully updated', 'prodigy' ); ?>
                </span>
			</div>
			<div class="d-flex mb-8">
				<span class="width-100 mr-20" style="flex-shrink: 0">
                    <?php esc_html_e( 'Store name', 'prodigy' ); ?>
                </span>
				<span class="font-700 name-store-js"><?php echo esc_attr( $domain_hosted_system ); ?></span>
			</div>
			<div class="d-flex mb-8">
				<span class="width-100 mr-20" style="flex-shrink: 0">
                    <?php esc_html_e( 'Subdomain', 'prodigy' ); ?>
                </span>
				<span class="font-700 subdomen-store-js" style="overflow-wrap: anywhere;word-break: break-word;">
                    <?php echo esc_url( Prodigy_Helper_Hosted_System::get_url_home() ); ?>
                </span>
			</div>
			<div class="d-flex mb-8">
				<span class="width-100 mr-20" style="flex-shrink: 0"><?php esc_html_e( 'Country', 'prodigy' ); ?></span>
				<span class="font-700"><?php esc_html_e( 'United States', 'prodigy' ); ?></span>
			</div>
			<div class="d-flex mb-8">
				<span class="width-100 mr-20" style="flex-shrink: 0"><?php esc_html_e( 'Currency', 'prodigy' ); ?></span>
				<span class="font-700"><?php esc_html_e( 'United States dollar ($)', 'prodigy' ); ?></span>
			</div>
		</div>
	<?php endif; ?>
	<div>
		<h4 class="prodigy-plugin-settings__subtitle">
			<?php esc_html_e( 'Synchronization', 'prodigy' ); ?>
		</h4>
		<p>
			<?php esc_html_e( 'Synchronize all the data related to the Products, Categories and Attributes.', 'prodigy' ); ?>
		</p>


		<button
				class="button button-primary prodigy-products-list-item__link prodigy-products-list-item__link--sync d-flex align-items-center sync-process-button-js"
		>
			<span class="icon icon-sync font-18 mr-4"></span>
			<span class="icon icon-rotate font-18 mr-4"></span>
			<?php esc_html_e( 'Sync with Prodigy', 'prodigy' ); ?>
			<span
				id="products-list-item-link-popup"
				tabIndex="0"
				role="button"
				aria-label="<?php esc_html_e( 'More information', 'prodigy' ); ?>"
				class="icon icon-info font-18 ml-4 prodigy-tooltip"
			>

            <span class="prodigy-tooltip__message">
                <?php esc_html_e( 'Synchronize all the data related to the Products, Categories and Attributes', 'prodigy' ) ?>
            </span>
		</button>

	</div>
	<div>
		<h4 class="prodigy-plugin-settings__subtitle">
			<?php esc_html_e( 'Plugin cache', 'prodigy' ); ?>
		</h4>
		<button class="button button-primary d-flex align-items-center pg-clear-cache-js">
			<?php esc_html_e( 'Clear Cache', 'prodigy' ); ?>
		</button>
	</div>
</div>
