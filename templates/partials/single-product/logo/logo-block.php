
	<div class="prodigy-logo-tool__form-container form-container prodigy-custom-template">
	<?php if ( ! $args['is_enable_logo_swatches'] ) : ?>
		<div class="prodigy-product__attr prodigy-product__logo prodigy-product-logo-block-js">
			<div class="prodigy-product__attr-item prodigy-product__logo-item">
				<div class="prodigy-product__attr-text prodigy-product__logo-text d-flex justify-content-between align-items-center">
					<div class="prodigy-product__attr-text-label prodigy-product__logo-text-label">
						<span class="prodigy-product__attr-text-label--inner prodigy-product__logo-text-label--inner">
							<?php esc_html_e( 'Logo', 'prodigy' ); ?>
						</span>
					</div>
				</div>
				<select name="logo_values" class="prodigy-main-select prodigy-main-logoselect logo_values form-control prodigy-logo-values-js">
					<?php foreach ( $args['product']->get_logos() as $logo ) : ?>
						<?php $logo_charge_amount = (float) ( $logo['attributes']['charge-amount'] ?? 0 ); ?>
						<?php $logo_name = empty( $logo_charge_amount ) ? $logo['attributes']['name'] : $logo['attributes']['name']; ?>
						<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
							<?php $logo_name .= ' (+$' . \Prodigy\Includes\Helpers\Prodigy_Formatting::prodigy_price_format( $logo_charge_amount ) . ')'; ?>
						<?php endif; ?>
						<option data-price="<?php echo esc_attr( $logo_charge_amount ); ?>"
								value="<?php echo esc_attr( $logo['id'] ); ?>"
								data-attributes='<?php echo wp_json_encode( $logo['attributes'] ); ?>'
								data-image="<?php echo esc_url( $logo['attributes']['original-url'] ); ?>"
						>
							<?php echo esc_html( $logo_name ); ?>
						</option>
					<?php endforeach ?>
				</select>
				<div class="prodigy-selectbox__arrow"></div>
			</div>
		</div>
	<?php else : ?>
		<div class="prodigy-product__attr-item--no-select prodigy-product__attr-item--logo-select">
			<div class="prodigy-product__attr-text prodigy-product__logo-text d-flex justify-content-between align-items-center">
				<div class="prodigy-product__attr-text-label">
				<span class="prodigy-product__attr-text-label--inner">
					<?php esc_html_e( 'Logo', 'prodigy' ); ?>
				</span>
				</div>
			</div>
			<div class="prodigy-product__attr-item--no-select-value prodigy-product__logo-item d-flex flex-column">
			<span class="prodigy-product__attr-text prodigy-product__logo-text prodigy-no-select">
				<?php esc_html_e( 'Selected', 'prodigy' ); ?>:
				<span class="prodigy-product__attr-text--name swatch-logo-name-js"></span>
			</span>
				<form class="d-flex flex-wrap align-items-center prodigy-radio__logo-btn-wrap position-relative">

				<?php foreach ( $args['product']->get_logos() as $key => $logo ) : ?>
					<?php $logo_charge_amount = (float) ( $logo['attributes']['charge-amount'] ?? 0 ); ?>
					<?php $logo_name = empty( $logo_charge_amount ) ? $logo['attributes']['name'] : $logo['attributes']['name']; ?>
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<?php $logo_name .= ' (+$' . \Prodigy\Includes\Helpers\Prodigy_Formatting::prodigy_price_format( $logo_charge_amount ) . ')'; ?>
					<?php endif; ?>
				
					<div
						class="d-flex flex-wrap align-items-center prodigy-radio__btn-wrap position-md-relative prodigy-tooltip prodigy-tooltip-js"
						id="prodigy-tooltip-<?php echo esc_attr( $logo['id'] ); ?>"
					>
						<span class="prodigy-tooltip__message prodigy-tooltip__not-allowed-logo-message"
								id="prodigy-tooltip-message-<?php echo esc_attr( $logo['id'] ); ?>">
							<?php esc_html_e( 'Not available with the selected product color', 'prodigy' ); ?>
						</span>
						<span class="prodigy-after__backdrop" id="prodigy-backdrop-<?php echo esc_attr( $logo['id'] ); ?>"></span>
						<div class="prodigy-product__attr-item--no-select-value d-flex flex-wrap align-items-center">
							<div class="prodigy-radio__swatch-btn prodigy-radio__swatch-logo-btn">
								<input
										type="radio"
										name="radio.swatch.logo"
										class="prodigy-product__btn-no-select prodigy-product__swatch  prodigy-product__logo-swatch prodigy-product__logo-swatch-js"
										value="<?php echo esc_attr( $logo['id'] ); ?>"
										data-attributes='<?php echo wp_json_encode( $logo['attributes'] ); ?>'
										data-price="<?php echo esc_attr( $logo_charge_amount ); ?>"
										data-name="<?php echo esc_attr( $logo_name ); ?>"
								<?php echo empty( $key ) ? 'checked' : ''; ?> />
								<label for="radio.swatch.logo"></label>
								<input type="image"
										alt="logo"
										class="prodigy-product__btn-no-select prodigy-product__swatch prodigy-product__swatch-init-js prodigy-product__logo-swatch position-relative"
										src="<?php echo esc_url( $logo['attributes']['original-url'] ); ?>"/>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				</form>
			</div>
		</div>
	<?php endif; ?>

	<div class="prodigy-product__attr prodigy-product__logo prodigy-product__logo-location prodigy-product-location-block-js">
		<div class="prodigy-product__attr-item prodigy-product__logo-item">
			<div class="prodigy-product__attr-text prodigy-product__logo-text d-flex justify-content-between align-items-center">
				<div class="prodigy-product__attr-text-label prodigy-product__logo-text-label">
					<span class="prodigy-product__attr-text-label--inner prodigy-product__logo-text-label--inner">
						<?php esc_html_e( 'Location', 'prodigy' ); ?>
					</span>
				</div>
			</div>
			<select
					name="logo_location_values"
					class="prodigy-main-select logo_location_values form-control prodigy-logo-location-js"
			>
				<?php foreach ( $args['product']->get_logo_locations() as $location ) : ?>
					<option value="<?php echo esc_html( $location['id'] ); ?>" data-attributes='<?php echo wp_json_encode( $location['attributes'] ); ?>'>
						<?php echo esc_html( $location['attributes']['name'] ); ?>
					</option>
				<?php endforeach ?>
			</select>
			<div class="prodigy-selectbox__arrow"></div>
		</div>
	</div>
</div>


