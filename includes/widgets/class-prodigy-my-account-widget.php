<?php
/**
 * Prodigy my account widget class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Widgets;

use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_My_Account;
use WP_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class My_Account_Prodigy_Widget
 */
class Prodigy_My_Account_Widget extends WP_Widget {

	/**
	 * @var string|void
	 */
	protected $default_title;

	/**
	 * My_Account_Prodigy_Widget constructor.
	 */
	public function __construct() {

		$this->default_title = esc_html__( 'My Account', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'prodigy_my_account_widget',
			'description' => 'Prodigy My Account',
		);
		parent::__construct( 'prodigy_my_account_widget', 'Prodigy My Account', $widget_ops );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( wp_is_json_request() ) {
			return '';
		}

		echo esc_html( $args['before_widget'] . do_shortcode( '[' . Prodigy_Short_Code_My_Account::NAME . ']' ) . $args['after_widget'] );
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		?>
		<p></p>
		<?php
	}
}
