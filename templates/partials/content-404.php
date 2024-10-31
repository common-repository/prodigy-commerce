<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="prodigy-primary" class="prodigy-content-area prodigy-custom-template">
	<main id="prodigy-main">
		<div class="prodigy-page-not-found">
			<div class="prodigy-page-not-found__error">404</div>
			<h2 class="prodigy-page-not-found__title"><?php esc_html_e( 'OPPS! PAGE IS NOT FOUND', 'prodigy' ); ?></h2>
			<p class="prodigy-page-not-found__txt">
				<?php esc_html_e( 'Sorry but the page you are looking for does not exist, have been removed, name changed or is temporary unavailable.', 'prodigy' ); ?>
			</p>
			<a class="prodigy-main-button prodigy-main-button--link min-w-217" href="<?php echo esc_url( get_home_url() ); ?>"><?php esc_html_e( 'BACK TO HOMEPAGE', 'prodigy' ); ?></a>
		</div>
	</main>
</div>
