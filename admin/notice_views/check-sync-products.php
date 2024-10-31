<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="prodigy-admin-custom-template-notice">
	<div class="notice notice-info is-dismissible">
		<p>
			<?php
			esc_html_e( 'Demo content successfully installed, but synchronization with the Prodigy Cloud platform still in progress. It may take several minutes for the synchronization to complete.', 'prodigy-commerce' );
			?>
		</p>
	</div>
</div>