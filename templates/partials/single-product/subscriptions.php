<?php if ( ! empty( $subscriptions ) ) : ?>
	<div class="subscriptions prodigy-custom-template">
	<?php if ( ! empty( (int) $subscriptions[ $minimal_key ]['attributes']['discount-value'] ) ) : ?>
		<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert--info prodigy-subscription-alert">
			<?php if ( $subscr_icon_type === 'icon' ) : ?>
				<?php if ( ! empty( $subscr_icon_class ) ) : ?>
					<i class="<?php echo esc_attr( $subscr_icon_class ); ?> font-24"></i>
				<?php endif; ?>
			<?php elseif ( $subscr_icon_type === 'svg' ) : ?>
				<img class="<?php echo esc_attr( $subscr_svg_class ); ?>"
					src="<?php echo esc_attr( $settings['product_subscription_alert_icon']['value']['url'] ); ?>"
					alt="">
			<?php endif; ?>
			<span class="prodigy-cart-dropdown__alert-txt">
			<?php esc_html_e( 'Subscribe and save up to ', 'prodigy' ); ?><span
						class="subscription-sale-amount-js"><?php echo $discount_sign; ?></span>
		</span>
		</div>
	<?php endif; ?>

	<div class="d-flex flex-row flex-wrap flex-lg-nowrap prodigy-subscriptions-tab__container">
		<!-- first -->
		<?php if ( ! $subscriptions['subscription-only'] ) : ?>
			<div role="tablist" class="prodigy-subscriptions-tab nav flex-column w-100 prodigy-subscriptions-one-time-order-js">
				<?php $type = empty( $subscriptions ); ?>
				<?php if ( empty( $subscriptions['subscription-only'] ) ) : ?>
					<a class="prodigy-subscriptions-tab__item w-100 nav-link prodigy-subscriptions-tab-js <?php echo empty( $subscriptions['subscription-only'] ) ? 'active' : ''; ?>"
						data-toggle="tab" data-target="#nav-home-1"
						href="javascript:void(0)" role="tab" aria-controls="nav-home"
						aria-selected="<?php echo empty( $subscriptions['subscription-only'] ) ? 'true' : 'false'; ?>">
						<label class="prodigy-main-radio w-100 d-flex align-items-center">
							<input class="prodigy-main-radio__field sr-only prodigy-subscriptions-radio-js"
									name="subscription-selection"
									type="radio" <?php echo empty( $subscriptions['subscription-only'] ) ? 'checked' : ''; ?>>
							<span class="prodigy-main-radio__icon prodigy-main-radio__icon--off icon icon-radio-off"></span>
							<span class="prodigy-main-radio__icon prodigy-main-radio__icon--on icon icon-radio-on"></span>
							<span class="prodigy-main-radio__label"><?php esc_html_e( 'ONE-TIME ORDER ', 'prodigy' ); ?></span>
						</label>
					</a>
				<?php endif; ?>
				<div class="prodigy-subscriptions-content tab-content flex-1">
					<div class="tab-pane tab-pane--onetime fade w-100 show" id="nav-home-1" role="tabpanel"
						aria-labelledby="nav-home-tab">
						<div class="prodigy-subscriptions-tab__item-wrap">
							<span class="prodigy-subscriptions-tab__item-title"><?php esc_html_e( 'Price', 'prodigy' ); ?>:</span>
							<span class=" prodigy-subscriptions-price-js">
								<span class="subscriptions-price-currency-js"></span><span class="subscriptions-one-time-price-js"></span>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- second -->
		<div role="tablist" class="prodigy-subscriptions-tab flex-column nav w-100">
			<a class="prodigy-subscriptions-tab__item w-100 nav-link prodigy-subscriptions-tab-js <?php echo ! empty( $subscriptions['subscription-only'] ) ? 'active' : ''; ?>"
				data-toggle="tab" data-target="#nav-profile-1" href="javascript:void(0)" role="tab"
				aria-controls="nav-profile"
				aria-selected="<?php echo esc_attr( $subscriptions['subscription-only'] ) ?? false; ?>">
				<label class="prodigy-main-radio w-100 d-flex align-items-center">
					<input class="prodigy-main-radio__field sr-only prodigy-subscriptions-radio-js"
							name="subscription-selection"
							type="radio" <?php echo ! empty( $subscriptions['subscription-only'] ) ? 'checked' : ''; ?>>
					<span class="prodigy-main-radio__icon prodigy-main-radio__icon--off icon icon-radio-off"></span>
					<span class="prodigy-main-radio__icon prodigy-main-radio__icon--on icon icon-radio-on"></span>
					<span class="prodigy-main-radio__label"><?php esc_html_e( 'SUBCSRIPTION', 'prodigy' ); ?></span>
				</label>
			</a>
			<div class="prodigy-subscriptions-content tab-content flex-1">
				<div class="tab-pane fade w-100 <?php echo ! empty( $subscriptions['subscription-only'] ) ? 'show active' : ''; ?>"
					id="nav-profile-1" role="tabpanel" aria-labelledby="nav-profile-tab">
					<div class="prodigy-subscriptions-tab__item-wrap prodigy-subscriptions-tab--price">
						<span class="prodigy-subscriptions-tab__item-title"><?php esc_html_e( 'Price', 'prodigy' ); ?>:</span>
						<span class="prodigy-subscriptions-tab__item-holder">
					<?php
					if ( ! empty( $subscriptionPrices ) ) {
						$minPrice        = $subscriptionPrices;
						$minPrice        = array_shift( $minPrice );
						$condition_price = $minPrice['condition_price'] ?? 0;
						$discountValue   = $condition_price;
					} else {

						foreach ( $subscriptions as $key => $plan ) :

							if ( empty( $key ) ) {
								$condition_price = $plan['attributes']['subscription-price'] < 0 ? 0 : $plan['attributes']['subscription-price'];
								$discountValue   = $plan['attributes']['discount-value'];
							}

						endforeach;
					}
					?>

							<span class="prodigy-subscriptions-tab__item-price">
								<span><?php echo get_option( 'pg_currency_type' ); ?></span><span class="sale-subscription-price-js"><?php echo number_format( (float) $condition_price, 2, '.', '' ); ?></span>
							</span>
							<?php if ( ! empty( $discountValue ) ) : ?>
							<span class="prodigy-subscriptions-tab__item-sale">
								<span class="subscriptions-price-currency-js">(<?php echo get_option( 'pg_currency_type' ); ?></span><span class="subscriptions-regular-price-js"></span>)
							</span>
						</span>
						<?php endif ?>
					</div>
					<table class="prodigy-subscriptions-content__table">
						<tbody>
						<tr>
							<td class="prodigy-subscriptions-content__table-cell"><span
										class="prodigy-subscriptions-content__table-cell-title prodigy-subscription-period-js"><?php esc_html_e( 'Period', 'prodigy' ); ?>:</span></td>
							<td>
								<div class="d-flex flex-column align-items-start">
									<?php $is_checked_plan = ''; ?>
									<?php foreach ( $subscriptions as $key => $plan ) : ?>
										<?php if ( is_int( $key ) ) : ?>
											<?php

											if ( empty( $is_checked_plan ) && $key <= 1 ) {
												$is_checked_plan = $plan['id'];
											}

											if ( empty( $subscriptionPrices ) ) {
												$condition_price_sel = $plan['attributes']['subscription-price'] < 0 ? 0 : $plan['attributes']['subscription-price'];
											} else {
												$condition_price_sel = $subscriptionPrices[ $plan['id'] ]['condition_price'];
											}

											?>

											<label class="prodigy-main-radio">
												<input type="hidden" class="subscription-sale_price-js"
														value="<?php echo esc_attr( $condition_price_sel ); ?>">
												<?php if ( isset( $plan['id'] ) ) : ?>
													<input type="hidden" class="subscription_id"
															value="<?php echo esc_attr( $plan['id'] ); ?>">
												<?php endif; ?>
												<input type="hidden" class="subscription-discount-currency-js"
														value="<?php echo esc_attr( $plan['attributes']['discount-type'] ) === 'fixed' ? '$' : '%'; ?>">
												<input type="hidden" class="subscription-discount-value-js"
														value="<?php echo esc_attr( $plan['attributes']['discount-value'] ); ?>">
												<input class="prodigy-main-radio__field sr-only subscription-radio-js"
														name="subscription" type="radio"
													<?php echo $is_checked_plan == $plan['id'] ? 'checked' : ''; ?>
														disabled>
												<span
														class="prodigy-main-radio__icon prodigy-main-radio__icon--off icon <?php echo count( $subscriptions ) > 2 ? 'icon-radio-off' : ''; ?>"></span>
												<span
														class="prodigy-main-radio__icon prodigy-main-radio__icon--on icon <?php echo count( $subscriptions ) > 2 ? 'icon-radio-on' : ''; ?>"></span>
												<?php if ( $plan['attributes']['interval'] > 1 ) : ?>
													<span class="prodigy-main-radio__label"><?php esc_html_e( 'Every', 'prodigy' ); ?>
													<?php echo esc_htnl( $plan['attributes']['interval'] ); ?>
														<?php echo esc_attr( $plan['attributes']['period'] ); ?>s</span>
													<input type="hidden" class="subscription-condition-js"
															value="<?php esc_attr_e( 'Every', 'prodigy' ); ?> <?php echo esc_attr( $plan['attributes']['interval'] ); ?> <?php echo esc_attr( $plan['attributes']['period'] ); ?>s">
												<?php else : ?>
													<span class="prodigy-main-radio__label"><?php esc_html_e( 'Every', 'prodigy' ); ?>
													<?php echo esc_html( $plan['attributes']['period'] ); ?></span>
													<input type="hidden" class="subscription-condition-js"
															value="<?php esc_attr_e( 'Every', 'prodigy' ); ?> <?php echo esc_attr( $plan['attributes']['period'] ); ?>">
												<?php endif; ?>
											</label>

										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>

	<div class="prodigy-custom-template">
		<div class="modal fade prodigy-replace-product__modal" id="add_item_Modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="prodigy-replace-product__modal-head">
						<?php esc_html_e( 'Replace product', 'prodigy' ); ?>
						<button class="prodigy-close-button">
							<i class="icon icon-close"></i>
						</button>
					</div>
					<div class="prodigy-replace-product__modal-body">
						<?php esc_html_e( 'This product is already added to your cart with a different subscription condition. Would you like to replace it?', 'prodigy' ); ?>
					</div>
					<div class="prodigy-replace-product__modal-footer">
						<button class="prodigy-secondary-button prodigy-button__close-subscription close-subscription-popup-js" type="button">
							<?php esc_html_e( 'CANCEL', 'prodigy' ); ?>
						</button>
						<button class="prodigy-main-button ml-16 replace-subscription-condition-js prodigy-main-button__replace-subscription-condition"
								data-name="replace-subscription-condition-js" type="button">
								<?php esc_html_e( 'REPLACE', 'prodigy' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
