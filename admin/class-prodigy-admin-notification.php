<?php
namespace Prodigy\Admin;

/**
 * Prodigy admin notifications class
 *
 * @version 1.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Notification {

	const NOTICE_FIELD = 'my_admin_notice_message';

	/**
	 *  Display errors
	 */
	public function display_admin_notice(): void {
		$option       = get_option( self::NOTICE_FIELD );
		$message      = $option['message'] ?? false;
		$notice_level = ! empty( $option['notice-level'] ) ? esc_attr( $option['notice-level'] ) : 'notice-error';

		if ( $message ) {
			echo '
				<div class="prodigy-admin-custom-template-notice">
					<div class="notice ' . esc_attr( $notice_level ) . ' is-dismissible">
						<p>' . esc_attr( $message ) . '</p>
					</div>
				</div>
			';
			delete_option( self::NOTICE_FIELD );
		}
	}

	/**
	 * @param string $message
	 */
	public static function display_error( string $message ): void {
		self::update_option( $message, 'notice-error' );
	}

	/**
	 * @param string $message
	 */
	public static function display_warning( string $message ): void {
		self::update_option( $message, 'notice-warning' );
	}

	/**
	 * @param string $message
	 *
	 * @return void
	 */
	public static function display_info( string $message ): void {
		self::update_option( $message, 'notice-info' );
	}

	/**
	 * @param string $message
	 */
	public static function display_success( string $message ): void {
		self::update_option( $message, 'notice-success' );
	}

	/**
	 * @param string $message
	 * @param string $notice_level
	 */
	protected static function update_option( string $message, string $notice_level ): void {
		update_option(
			self::NOTICE_FIELD,
			array(
				'message'      => $message,
				'notice-level' => $notice_level,
			)
		);
	}
}
