<?php

namespace Prodigy\Includes\Helpers;

use DateInterval;
use DateTime;
use DateTimeZone;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy Helper Hosted System class
 *
 * @version    2.8.3
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Cookies {

	/**
	 * Get cookie hook
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'get_cookie' ) );
	}

	/**
	 * @param string $cookie_name
	 *
	 * @return void
	 */
	public function remove_cookie( string $cookie_name ) {
		$expirationTime = time() - 3600;
		@setcookie( $cookie_name, '', $expirationTime, '/' );
	}


	/**
	 * @param string      $name
	 * @param string      $value
	 * @param string|null $expiration
	 * @param string|null $cookiepath
	 * @param string|null $cookiedomain
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function set_cookie( string $name, string $value, string $expiration = null, string $cookiepath = null, string $cookiedomain = null ): bool {
		$_COOKIE[ $name ] = $value;

		return @setcookie(
			$name,
			$value,
			$expiration ?? $this->get_default_expiration_time(),
			$cookiepath ?? COOKIEPATH,
			$cookiedomain ?? COOKIE_DOMAIN
		);
	}

	/**
	 * @param string $cookie_name
	 *
	 * @return bool
	 */
	public function has_cookie( string $cookie_name ): bool {
		return isset( $_COOKIE[ $cookie_name ] );
	}

	/**
	 * @param string $cookie_name
	 *
	 * @return string
	 */
	public function get_cookie( string $cookie_name ): string {
		return filter_var( $_COOKIE[ $cookie_name ] ?? '', FILTER_SANITIZE_SPECIAL_CHARS ); //phpcs:ignore
	}


	/**
	 * @param string $timeString
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	public function calculate_expiration_time( string $timeString ): string {
		$dateTime      = \DateTime::createFromFormat( 'Y-m-d\TH:i:s.uP', $timeString );
		$formattedTime = $dateTime->format( 'Y-m-d H:i:s' );

		$specificDate = new \DateTime( $formattedTime );
		$currentTime  = new \DateTime( 'now' );

		$diff          = $specificDate->getTimestamp() - $currentTime->getTimestamp();
		$diffInSeconds = abs( $diff );

		return time() + $diffInSeconds;
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	private function get_default_expiration_time(): string {
		$currentTime = new DateTime( 'now', new DateTimeZone( 'UTC' ) );
		$currentTime->add( new DateInterval( 'PT5M' ) );

		return $currentTime->format( 'Y-m-d\TH:i:s.uP' );
	}
}
