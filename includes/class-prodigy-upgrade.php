<?php
/**
 * Upgrade Class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy_Upgrade class.
 */
class Prodigy_Upgrade {


	protected $version;

	/** @var Prodigy_Options */
	private $options;

	public function __construct() {
		$this->options = new Prodigy_Options();
		add_action( 'init', array( $this, 'upgrade' ) );
		add_action( 'admin_init', array( $this, 'upgrade' ) );

		$this->version = get_option( 'PRODIGY_VERSION' );
	}

	/**
	 * check upgrade
	 */
	public function upgrade() {

		$this->options->set_default_options();

		/*
		 * Activate for old clients
		 */
		if ( ! get_option( 'pae_save_data' ) ) {
			$this->updateOptionElementor();
		}
	}

	public function updateOptionElementor() {
		$option      = 'pae_save_data';
		$optionValue = array(
			'categories' => 'on',
			'products'   => 'on',
			'category'   => 'on',
		);

		if ( ! get_option( $option ) ) {
			update_option( $option, $optionValue );
		}
	}

}
