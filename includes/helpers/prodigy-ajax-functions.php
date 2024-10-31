<?php
// add google captcha
add_action( 'wp_ajax_google-captcha-url', 'google_captcha_url' );
add_action( 'wp_ajax_nopriv_google-captcha-url', 'google_captcha_url' );

/**
 * Get google captcha
 */
function google_captcha_url() {
	$data = array();
	header( 'Content-Type: application/json' );
	error_reporting( E_ALL ^ E_NOTICE );
	$captcha = '';
	if ( isset( $_POST['g-recaptcha-response'] ) ) {
		$captcha = esc_url_raw( wp_unslash( ( $_POST['g-recaptcha-response'] ) ) );
	}
	if ( ! $captcha ) {
		$data = array( 'nocaptcha' => 'true' );
		echo wp_json_encode( $data );
		exit;
	}

	if ( ! empty( get_option( 'pg_captcha_secret_key' ) ) ) {
		$address = isset( $_SERVER['REMOTE_ADDR'] ) ? esc_url_raw( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		// calling google recaptcha api.
		$response = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . get_option( 'pg_captcha_secret_key' ) . '&response=' . $captcha . '&remoteip=' . $address );
		// validating result.
		$responseKeys = wp_remote_retrieve_body( $response );
		if ( $responseKeys['success'] == false ) {
			$data = array( 'spam' => 'true' );
			echo wp_json_encode( $data );
		} else {
			$data = array( 'spam' => 'false' );
			echo wp_json_encode( $data );
		}
		wp_die();
	} else {
		exit;
	}
}


add_action( 'wp_ajax_prodigy-is-admin', 'check_user_is_admin_ajax' );
add_action( 'wp_ajax_nopriv_prodigy-is-admin', 'check_user_is_admin_ajax' );


/**
 * check user is admin
 */
function check_user_is_admin_ajax() {
	$user = wp_get_current_user();
	if ( ! empty( $user->roles ) && $user->roles[0] === 'administrator' ) {
		echo true;
	} else {
		echo false;
	}
	wp_die();
}
