<?php
/**
 * @var string $title
 * @var string $current_tab
 * @var array $fields
 */

use Prodigy\Admin\Prodigy_Admin_Form_Field;

?>

<div id="<?php echo esc_html( $current_tab ); ?>" class="prodigy_settings__wrapper" >

	<form action="#" method="post" class="form" id="<?php echo esc_html( $current_tab ); ?>-form">
		<?php
		$form_field = new Prodigy_Admin_Form_Field( array( 'wrap' => true ) );
		foreach ( $fields as $field ) {
			echo $form_field->display_field( $field );
		}
		?>
		<?php wp_nonce_field( 'admin-settings' ); ?>
		<button type="submit" class="button button-primary">
			<?php esc_html_e( 'Save Changes', 'prodigy' ); ?>
		</button>
	</form>
</div>



