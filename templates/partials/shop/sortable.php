
<div class="prodigy-sort catalog-sort-js prodigy-catalog-sort d-flex flex-nowrap justify-content-between justify-content-md-end prodigy-custom-template" data-width="200">
	<button id="filter-toggle-btn-2" class="prodigy-filter__sm-btn prodigy-filter__sm-btn-default <?php echo esc_attr( $has_sidebar ) ? '' : '-lg-none'; ?>">
		<span class="icon icon-filter"></span>
		<?php esc_html_e( 'Filter', 'prodigy' ); ?>
	</button>
	<?php if ( $show_sorting ) : ?>
		<?php if ( isset( $sort_param ) ) : ?>
			<select class="prodigy-custom-select prodigy-custom-select__catalog-sort catalog-page-sort-js">
				<?php
				foreach ( $sort_array as $key => $label ) {
					?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $sort_param, $key, true ); ?> >
						<?php echo esc_attr( $label ); ?>
					</option>
					<?php
				}
				?>
			</select>
		<?php endif; ?>
	<?php endif; ?>
	<div class="prodigy-select-md d-lg-none catalog-page-device-sort-js">
		<div class="d-flex flex-column prodigy-select-md__wrap">
			<div class="prodigy-select-md__header d-flex flex-row justify-content-between align-items-center">
				<h5 class="prodigy-select-md__header-title">Sort by</h5>
				<button class="prodigy-select-md__btn" id="select-toggle-btn" aria-label="Close Select">
					<span class="icon icon-close catalog-page-device-sort-close-js"></span>
				</button>
			</div>
			<ul class="d-flex flex-column prodigy-select-md__list">
				<?php
				if ( isset( $sort_param ) ) {
					foreach ( $sort_array as $key => $label ) {
						?>
					<li class="d-flex flex-row justify-content-start align-items-center prodigy-select-md__list-item">
						<label class="prodigy-main-radio w-100">
							<input value="<?php echo esc_attr( $key ); ?>" class="prodigy-main-radio__field sr-only sort-radio-js" name="selection"
								type="radio" <?php checked( $sort_param, $key, true ); ?>>
							<span class="prodigy-main-radio__icon prodigy-main-radio__icon--off icon icon-radio-off"></span>
							<span class="prodigy-main-radio__icon prodigy-main-radio__icon--on icon icon-radio-on"></span>
							<span class="prodigy-main-radio__label"><?php echo esc_attr( $label ); ?></span>
						</label>
					</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
