<?php
namespace Prodigy\Includes\Support\Customizer;

use WP_Customize_Control;

/**
 * Multiple select customize control class.
 */
class Prodigy_Customizer_Control_Multiple_Select extends WP_Customize_Control {
	public $type = 'multiple-select';

	/**
	 * Displays the multiple select on the customize screen.
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
				foreach ( $this->choices as $value => $label ) {
					$selected = ( in_array( $value, (array) $this->value() ) ) ? selected( 1, 1, false ) : '';
					echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $label ) . '</option>';
				}
				?>
			</select>
		</label>
		<?php
	}
}
