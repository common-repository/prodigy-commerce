<?php
/**
 * @var string $current_version
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="prodigy-admin-custom-template-notice">
	<div class="notice notice-warning is-dismissible">
		<p>
			<?php
			esc_html(
				sprintf(
					// Translators: %s is the current MySQL version.
					__( 'The Prodigy Commerce plugin requires MySQL version 5.6 or greater to work correctly. You are currently using version %1$s, please upgrade your MySQL and re-install Prodigy Commerce.', 'prodigy-commerce' ),
					$current_version
				)
			);
			?>
		</p>
	</div>
</div>
