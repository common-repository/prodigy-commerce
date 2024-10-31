<?php foreach ( $product->get_variant_options() as $attribute => $variant ) : ?>

	<?php $product_taxonomy = Prodigy\Includes\Content\Prodigy_Product_Attributes::get_attribute_taxonomies_by_slug( $attribute ); ?>

<div class="variants-container-js prodigy-custom-template">
	<div class="prodigy-product__attr-text d-flex justify-content-between align-items-center">
		<div class="prodigy-product__attr-text-label">
				<span class="prodigy-product__attr-text-label--inner">
					<span>
				<?php echo esc_attr( $product_taxonomy->name ); ?>
						<?php if ( $is_tiered_prices ) : ?>
							(<?php esc_html_e( 'min. qty', 'prodigy' ); ?> -
							<strong><?php echo esc_html( $tiered_min_quantity_text ); ?></strong>)
						<?php endif; ?>
				</span>
					</span>
		</div>
		<?php if ( $show_bulk ) : ?>
			<button
					type="button"
					data-attribute="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>"
					class="prodigy-unstyled__btn enable-bulk-js"
					data-value="<?php echo esc_attr( $product_taxonomy->name ?? '' ); ?>">
				<span class="d-md-inline">
					<?php echo esc_html( $add_to_cart_widget['prg_enable_multiple_quantity_text'] ); ?>
				</span>
			</button>

			<button
					style="display:none"
					type="button"
					data-attribute="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>"
					class="prodigy-unstyled__btn disable-bulk-link-js"
					data-value="<?php echo esc_attr( $product_taxonomy->name ?? '' ); ?>">
				<span class="d-md-inline">
					<?php echo esc_html( $add_to_cart_widget['prg_disable_multiple_quantity_text'] ); ?>
				</span>
			</button>
		<?php endif; ?>
	</div>

	<div class="prodigy-product__attr prodigy-product__attr-tags flex-column w-100">
		<div style="display: none"
			class="bulk-container-js prodigy-bulk__wrap prodigy-custom-template bulk-container-<?php echo esc_attr( $product_taxonomy->slug ); ?>-js"
			data-attribute="<?php echo esc_attr( $product_taxonomy->slug ); ?>">

			<div class="prodigy-bulk__table">
				<?php foreach ( $variant as $key => $option ) : ?>
					<div class="prodigy-bulk__table-cell d-flex flex-column justify-content-between align-items-center">
						<div class="prodigy-bulk__table-cell-head prodigy-tooltip <?php echo isset( $option['image'] ) || isset( $option['color'] ) ? 'prodigy-bulk__table-cell-head--swatch' : ''; ?>">
							<?php if ( isset( $option['image'] ) ) : ?>
								<span class="prodigy-bulk__attr-name prodigy-bulk__attr-color"
										style="background: no-repeat center/cover transparent url(<?php echo esc_url( $option['image'] ); ?>);"
								></span>
							<?php endif; ?>
							<?php if ( isset( $option['color'] ) ) : ?>
								<span class="prodigy-bulk__attr-name prodigy-bulk__attr-color"
										style="--data-color: <?php echo esc_attr( $option['color'] ); ?>"
								></span>
							<?php endif; ?>

							<span class="prodigy-bulk__attr-name prodigy-bulk__attr-color-name">
								<span><?php echo esc_html( $option['name'] ); ?></span>
								<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
									<small class="prodigy-small-block bulk-price-modify-js<?php echo esc_attr( $key ); ?>"></small>
								<?php endif; ?>
							</span>
						</div>
						<div class="prodigy-bulk__table-cell-body">
							<input value=""
									maxlength="6"
									class="prodigy-bulk-input prodigy-bulk-input-js"
									placeholder="0"
									data-attribute="<?php echo esc_attr( $key ); ?>"
									data-option="<?php echo esc_attr( $key ); ?>"
									data-option-id="<?php echo esc_attr( $option['option_id'] ); ?>"
							>
							<?php $key = str_replace( ' ', '_', $key ); ?>
							<small class="prodigy-bulk__stock-indicator">
								<span class="prodigy-bulk__stock-indicator-label stock-indicator-label-js<?php echo esc_attr( $key ); ?>"></span>
								<span class="prodigy-bulk__stock-indicator-qty stock-indicator-qty-js<?php echo esc_attr( $key ); ?>"></span>
							</small>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>


		<div class="prodigy-product__attr-item--no-select variant-container-<?php echo esc_attr( $product_taxonomy->slug ); ?>-js">
			<div class="prodigy-product__attr-item--no-select-value d-flex flex-column swatch-container-js">
					<span class="prodigy-product__attr-text prodigy-no-select text-nowrap">
						<?php esc_html_e( 'Selected', 'prodigy' ); ?>: <span
								class="prodigy-product__attr-text--name swatch-attribute-name-js"
								data-attribute="<?php echo esc_attr( $product_taxonomy->slug ); ?>"></span>
					</span>
				<div data-attribute="<?php echo esc_attr( $product_taxonomy->slug ); ?>"
					class="d-flex flex-wrap align-items-center prodigy-radio__btn-wrap prodigy-product__swatch-block-js">
					<?php $is_checked_set = false; ?>
					<?php foreach ( $variant as $key => $option ) : ?>
						<?php $checked = ''; ?>
						<?php if ( ! $is_checked_set ) : ?>
							<?php $checked = $option['default'] || ! empty( $option['logos'] ) ? 'checked' : ''; ?>
							<?php $is_checked_set = true; ?>
						<?php endif; ?>
						<div class="d-flex flex-wrap align-items-center prodigy-radio__btn-wrap">
							<?php if ( isset( $option['image'] ) ) : ?>
								<div class="prodigy-product__attr-item--no-select-value d-flex flex-wrap align-items-center">
									<div class="prodigy-radio__swatch-btn">
										<input
												type="radio"
												name="radio.swatch<?php echo esc_attr( $product_taxonomy->slug ); ?>"
												class="prodigy-product__btn-no-select prodigy-product__swatch prodigy-product__swatch-js <?php echo ! empty( $option['logos'] ) ? 'has-logo-settings-js' : ''; ?>"
												value="<?php echo esc_attr( $option['name'] ); ?>"
												data-slug="<?php echo esc_attr( $key ); ?>"
												data-attribute="<?php echo esc_attr( $product_taxonomy->name ); ?>"
												data-logos='<?php echo wp_json_encode( $option['logos'] ?? array() ); ?>'
											<?php echo esc_html( $checked ); ?>
										/>
										<label for="radio.swatch<?php echo esc_attr( $product_taxonomy->slug ); ?>"></label>

										<input type="image"
												class="prodigy-product__btn-no-select prodigy-product__swatch position-relative prodigy-product__swatch-js"
												src="<?php echo esc_url( $option['image'] ); ?>"/>
									</div>
								</div>
							<?php elseif ( isset( $option['color'] ) ) : ?>
								<div class="prodigy-product__attr-item--no-select-value d-flex flex-wrap align-items-center">
									<div class="prodigy-radio__swatch-btn">
										<input
												type="radio"
												name="radio.swatch<?php echo esc_attr( $product_taxonomy->slug ); ?>"
												class="prodigy-product__btn-no-select prodigy-product__swatch prodigy-product__swatch-js <?php echo ! empty( $option['logos'] ) ? 'has-logo-settings-js' : ''; ?>"
												data-color="<?php echo esc_attr( $option['color'] ); ?>"
												value="<?php echo esc_attr( $option['name'] ); ?>"
												data-slug="<?php echo esc_attr( $key ); ?>"
												data-attribute="<?php echo esc_attr( $product_taxonomy->slug ); ?>"
												data-logos='<?php echo wp_json_encode( $option['logos'] ?? array() ); ?>'
											<?php echo esc_html( $checked ); ?>
										/>
										<label for="radio.swatch<?php echo esc_attr( $product_taxonomy->slug ); ?>"
												style="--data-color: <?php echo esc_attr( $option['color'] ); ?>;"></label>
									</div>
								</div>
							<?php else : ?>
								<div class="prodigy-radio__no-swatch-btn">
									<input
											type="radio"
											name="radio.noswatch.img<?php echo esc_attr( $product_taxonomy->slug ); ?>"
											class="prodigy-product__btn-no-select prodigy-product__no-swatch prodigy-product__swatch-js <?php echo ! empty( $option['logos'] ) ? 'has-logo-settings-js' : ''; ?>"
											value="<?php echo esc_attr( $option['name'] ); ?>"
											data-slug="<?php echo esc_attr( $key ); ?>"
											data-attribute="<?php echo esc_attr( $product_taxonomy->slug ); ?>"
											data-logos='<?php echo wp_json_encode( $option['logos'] ?? array() ); ?>'
										<?php echo esc_html( $checked ); ?>
									/>
									<label for="radio.noswatch.img<?php echo esc_attr( $product_taxonomy->slug ); ?>"></label>
									<input type="button" class="prodigy-product__btn-no-select position-relative"
											value="<?php echo esc_attr( $option['name'] ); ?>"
											data-slug="<?php echo esc_attr( $key ); ?>"
									/>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endforeach; ?>
