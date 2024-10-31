<?php
namespace Prodigy\Includes\Support\Customizer;

use Prodigy\Includes\Prodigy;
use WP_Customize_Control;

/**
 * @version 2.1.0
 * @package prodigy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Prodigy_Customizer_Control_Slider extends WP_Customize_Control {

	public $type = 'prodigy-range-value';


	public function enqueue() {
		wp_enqueue_script( 'customizer-range-value-control', Prodigy::plugin_url() . '/web/templates/js/customizer-range-slider.js', array( 'jquery' ), wp_rand(), true );
		wp_enqueue_style( 'customizer-range-value-style', Prodigy::plugin_url() . '/web/templates/css/customizer-range-slider.css', array(), wp_rand(), 'all' );
	}

	/**
	 * Render the control's content.
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="range-slider"  style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
				<span  style="width:100%; flex: 1 0 0; vertical-align: middle;"><input class="range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>"
			  <?php
				$this->input_attrs();
				$this->link();
				?>
				>
				<input type="number" class="range-slider__value"><span>PX</span></span>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>
		</label>
		<?php
	}
}
