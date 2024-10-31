<?php
/**
 * @var string $current_tab
 * @var array $tabs
 */

use Prodigy\Admin\Prodigy_Admin_Settings;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Helpers\Prodigy_Page;

defined( 'ABSPATH' ) || exit;

$list_pages            = Prodigy_Admin_Settings::get_post_pages();
$current_shop_page_id  = Prodigy_Page::prodigy_get_page_id( 'shop' );
$current_cart_page_id  = Prodigy_Page::prodigy_get_page_id( 'cart' );
$current_thank_page_id = Prodigy_Page::prodigy_get_page_id( 'thank' );

?>
<div class="prodigy-admin-wrap prodigy-admin-custom-template">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Settings', 'prodigy' ); ?></h1>
	<div class="prodigy-main-container">
		<div class="prodigy-main-alert prodigy-main-alert--red" style="display: none">
			<p class="font-12 mb-0">
				<?php
				esc_html_e(
					'The store is disconnected. You need to paste API key for synchronize.',
					'prodigy'
				)
				?>
			</p>
			<i class="prodigy-main-alert__close icon icon-close"></i>
		</div>
		<div class="prodigy-main-alert prodigy-main-alert--red" style="display: none">
			<p class="font-12 mb-0"><?php esc_html_e( 'The store is deleted on Prodigy hosted system.', 'prodigy' ); ?>
				<a href="#" class="prodigy-main-link">
					<?php esc_html_e( 'See more details on Prodigy hosted system.', 'prodigy' ); ?>
				</a></p>
			<i class="prodigy-main-alert__close icon icon-close"></i>
		</div>


		<div class="settings-container">
			<nav class="nav-tab-wrapper">
				<?php
				foreach ( $tabs as $tab_name => $tab_settings ) {
					$url = prodigy_get_admin_url(
						'edit.php',
						array(
							'post_type' => Prodigy::get_prodigy_product_type(),
							'page'      => Prodigy_Admin_Settings::SETTINGS_PAGE,
							'tab'       => $tab_name,
						)
					);
					?>
					<a id="general-tab" href="<?php echo esc_url( wp_nonce_url( $url, 'admin-tab' ) ); ?>"
						class="nav-tab <?php echo $tab_name === esc_html( $current_tab ) ? ' nav-tab-active' : ''; ?>">
						<?php echo esc_attr( $tab_settings['title'] ); ?>
					</a>
					<?php
				}
				?>
			</nav>
			<?php
			$tab_settings = $tabs[ $current_tab ];
			if ( isset( $tab_settings['template'] ) ) {
				extract( $tab_settings['template'] );
				require_once PRODIGY_PLUGIN_PATH . 'admin/partials/settings/' . $current_tab . '-settings.php';
			} else {
				extract( $tab_settings );
				require_once PRODIGY_PLUGIN_PATH . 'admin/partials/settings/tab-settings.php';
			}
			?>

		</div>


		<div id="saveModal" class="hidden">
			<div class="modal-body">
				<div class="modal-content">
					<div class="prodigy-plugin-settings__modal-body modal-body">
						<h4 class="prodigy-plugin-settings__subtitle font-20">
							<?php esc_html_e( 'You have an Unsaved Settings', 'prodigy' ); ?>
						</h4>
						<p class="mb-0">
							<?php
							esc_html_e(
								'Are you sure you want to leave this page without saving it?',
								'prodigy'
							)
							?>
						</p>
						<p>
							<?php
							esc_html_e(
								'If you leave this page, all unsaved changes will be lost.',
								'prodigy'
							)
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="prodigy-plugin-settings__modal-footer modal-footer">
					<input
							class="prodigy-button-link mr-20 close-setting-popup"
							type="button"
							value="<?php esc_attr_e( 'Leave without saving', 'prodigy' ); ?>"
					/>
					<input class="prodigy-main-button prodigy-main-button--grey-dark settings-button-save" type="submit" value="<?php esc_attr_e( 'Save and Leave', 'prodigy' ); ?>"/>
				</div>
			</div>
		</div>

	</div>
</div>
