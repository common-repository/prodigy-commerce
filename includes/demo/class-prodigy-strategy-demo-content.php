<?php
namespace Prodigy\Includes\Demo;

defined( 'ABSPATH' ) || exit;

class Prodigy_Strategy_Demo_Content {
	/**
	 * @var Prodigy_Interface_Strategy_Demo_Content
	 */
	private $strategy;

	/**
	 * StrategyDemoContent constructor.
	 *
	 * @param Prodigy_Interface_Strategy_Demo_Content $strategy
	 */
	public function __construct( Prodigy_Interface_Strategy_Demo_Content $strategy ) {
		$this->strategy = $strategy;
	}

	/**
	 * @param Prodigy_Interface_Strategy_Demo_Content $strategy
	 */
	public function setStrategy( Prodigy_Interface_Strategy_Demo_Content $strategy ) {
		$this->strategy = $strategy;
	}

	/**
	 *
	 */
	public function parseDemoContent() {
		$this->strategy->parseItem();
	}

	/**
	 * @param $item
	 *
	 * @return bool
	 */
	public function installDemoContent( $item ) {

		$result = $this->strategy->installItem();
		$this->updateOptionDemoContent( $item, $result );

		return $result;
	}


	/**
	 * @param $item
	 * @param $action
	 */
	private function updateOptionDemoContent( $item, $action ) {
		$demoContentOption = get_option( 'prodigy_demo_content_' . get_option( 'pg_url_domain_hosted_system' ) );

		if ( is_array( $demoContentOption ) && key_exists( $item, $demoContentOption ) ) {
			$demoContentOption[ $item ] = $action;
		} else {
			update_option( 'prodigy_demo_content_' . $item . get_option( 'pg_url_domain_hosted_system' ), array( $action ) );
		}
	}

}
