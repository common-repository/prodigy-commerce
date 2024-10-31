<?php if ( ! isset( $idWidget ) ) : ?>
	<div
			class="panel entry-content prodigy-product__additional-wrap prodigy-custom-template"
			id="tab-additional_information"
			role="tabpanel"
			aria-labelledby="tab-title-additional_information"
	>
<?php endif; ?>

	<table class="prodigy-product__additional">
		<tbody>
		<?php if ( $show_additional ) : ?>
			<?php if ( $show_additional_weight ) : ?>
				<tr>
					<td class="prodigy-product__additional-col-title"><?php esc_html_e( 'WEIGHT', 'prodigy' ); ?></td>
					<td class="prodigy-product__additional-col-value prodigy-additional-weight-js">
						<?php esc_html_e( $prodigy_additional_weight ); ?>
						<?php esc_html_e( $prodigy_additional_weight_unit ); ?>
					</td>
				</tr>
			<?php endif; ?>
			<tr>
				<td class="prodigy-product__additional-col-title">
					<?php esc_html_e( 'DIMENSIONS', 'prodigy' ); ?>
				</td>
				<td class="prodigy-product__additional-col-value prodigy-additional-dimensions-js">
					<?php esc_html_e( $prodigy_additional_depth ); ?>
					x
					<?php esc_html_e( $prodigy_additional_width ); ?> x
					<?php esc_html_e( $prodigy_additional_height ); ?>
					<?php esc_html_e( $prodigy_additional_size_unit ); ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php if ( ! empty( $descriptive_option ) && is_array( $descriptive_option ) ) : ?>
			<?php foreach ( $descriptive_option as $key => $item ) : ?>
				<tr>
					<td class="prodigy-product__additional-col-title">
						<?php esc_html_e( $key ); ?>
					</td>
					<td class="prodigy-product__additional-col-value"><?php esc_html_e( implode( ', ', $item ) ); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
<?php if ( ! isset( $idWidget ) ) : ?>
	</div>
<?php endif; ?>
