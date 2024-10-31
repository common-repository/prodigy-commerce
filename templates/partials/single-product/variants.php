<?php foreach ( $product->get_variant_options() as $attribute => $variant ) : ?>
	<?php $product_taxonomy = \Prodigy\Includes\Content\Prodigy_Product_Attributes::get_attribute_taxonomies_by_slug( $attribute ); ?>

	<div class="prodigy-product__attr-text d-flex justify-content-between align-items-center">
		<div class="prodigy-product__attr-text-label">
				<span class="prodigy-product__attr-text-label--inner">
					<span>
				<?php echo esc_attr( $product_taxonomy->name ); ?>
						<?php if ( isset( $is_tiered_prices ) && $is_tiered_prices ) : ?>
							(<?php echo esc_html__( 'min. qty', 'prodigy' ); ?> -
							<strong><?php echo esc_html( $tiered_min_quantity_text ); ?></strong>)
						<?php endif; ?>
				</span>
					</span>
		</div>
		<?php if ( isset( $show_bulk ) && $show_bulk ) : ?>
			<button
					type="button"
					data-attribute="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>"
					class="prodigy-unstyled__btn enable-bulk-js"
					data-value="<?php echo esc_attr( $product_taxonomy->name ?? '' ); ?>"
			>
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

	<div style="display: none"
		class="bulk-container-js prodigy-bulk__wrap prodigy-custom-template bulk-container-<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>-js"
		data-attribute="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>">
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
					</div>
					<div class="prodigy-bulk__table-cell-body">
						<input value=""
								maxlength="6"
								class="prodigy-bulk-input prodigy-bulk-input-js"
								data-option="<?php echo esc_attr( $key ); ?>"
								data-option-id="<?php echo esc_attr( $option['option_id'] ); ?>"
								placeholder="0"
						>
						<small class="prodigy-bulk__stock-indicator">
							<span class="prodigy-bulk__stock-indicator-label stock-indicator-label-js<?php echo esc_attr( $key ); ?>"></span>
							<span class="prodigy-bulk__stock-indicator-qty stock-indicator-qty-js<?php echo esc_attr( $key ); ?>"></span>
						</small>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="prodigy-product__attr">
		<div class="prodigy-product__attr-item variant-container-<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>-js">
			<select
					data-attribute="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>"
					name="attribute_values"
					class="prodigy-main-select attribute_values form-control attribute_values_js"
					data-slug="<?php echo esc_attr( $product_taxonomy->slug ?? '' ); ?>"
			>
			</select>
			<div class="prodigy-selectbox__arrow"></div>
		</div>
	</div>
<?php endforeach; ?>
