<?php
namespace Prodigy\Includes\Demo;

use Prodigy\Includes\Synchronization\Content\Prodigy_Process_Factory;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;

defined( 'ABSPATH' ) || exit;
/**
 * Class InstallDemoContentProduct
 */
class Prodigy_Install_Demo_Content_Product extends Prodigy_Abstract_Demo_Content {


	/** @var object $sync Prodigy_Api_Client */
	public $sync;

	/** @var object Prodigy_Process_Factory  */
	public $process_factory;

	public function __construct() {
		$this->sync            = new Prodigy_Synchronization();
		$this->process_factory = new Prodigy_Process_Factory();
	}

	/**
	 * @return true
	 */
	public function installItem() {
		update_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE, Prodigy_Synchronization::PRODIGY_DEMO_PROCESS );
		return true;
	}

	/**
	 *
	 */
	public function parseItem() {
		return true;
	}
}
