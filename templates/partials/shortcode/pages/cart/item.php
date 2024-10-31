<?php

use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Page;

?>

<?php if ( ! empty( $cart_items['items'] ) ) : ?>
	<?php if ( $is_quantity_number ) : ?>
		<h1 class="prodigy-cart__counter-title"><?php esc_html_e( 'Cart', 'prodigy' ); ?>
			(<?php echo (int) $cart_items['common_number_of_items'] ?? 0; ?>)</h1>
	<?php endif; ?>
	<section class="prodigy-cart__wrapper prodigy-cart__wrapper__cart-items-list cart-items-list-js col-md-12">
		<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-error widget-cart-message-error-js" style="display:none;">
			<i class="icon icon-error"></i>
			<span class="prodigy-cart-dropdown__alert-txt"></span>
		</div>

		<table class="prodigy-cart__table">
			<thead>
			<tr class="text-left">
				<th class="prodigy-cart__table-product-cell">
					<?php
					esc_html_e( 'Product', 'prodigy' );
					?>
				</th>
				<th class="prodigy-cart__table-desc-cell"></th>
				<th class="prodigy-cart__table-quantity-cell pl-0"><?php esc_html_e( 'Quantity', 'prodigy' ); ?></th>
				<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
					<th class="prodigy-cart__table-price-cell pl-0"><?php esc_html_e( 'Price', 'prodigy' ); ?></th>
					<th class="prodigy-cart__table-price-cell"><?php esc_html_e( 'Total', 'prodigy' ); ?></th>
				<?php endif; ?>
			</tr>
			</thead>
			<tbody class="cart-body-js prodigy-cart__table-body prodigy-cart__tbody ">

			<?php foreach ( $cart_items['items'] as $key => $item_line ) : ?>
				<tr class="item-container-js prodigy-cart__table-row prodigy-cart__tr">
					<td class="cart-item-js prodigy-cart__table-product-td prodigy-cart__table-data-img"
						data-cart-item='<?php echo wp_json_encode( $item_line['data_analytics'] ?? '' ); ?>'>
						<div class="d-flex flex-column prodigy-cart__placeholder-wrap">
							<div class="prodigy-cart__placeholder">
								<a href="<?php echo esc_url( $item_line['local_url'] ); ?>"
									class="prodigy-cart__placeholder-link">
									<!--if logo tool => logo tool layout -->
									<?php echo get_cart_item_logo_image_template( $item_line ); ?>
									<!-- end logo tool -->
								</a>
							</div>
							<!--if logo tool => logo tool layout -->
							<?php
							if ( ! empty( $item_line['attributes']['logos'] ) ) :
								?>
								<div class="d-flex flex-wrap prodigy-cart__placeholder-logo">
									<?php foreach ( $item_line['attributes']['logos'] as $item ) : ?>
										<span class="d-block">
											<img src="<?php echo esc_url( $item['logo']['original-url'] ); ?>"
												alt="logo"
												loading="lazy"
											/>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</td>
					<td class="prodigy-cart__table-info-cell prodigy-cart__table-data-info">
						<div class="prodigy-cart__table-info">
							<div class="prodigy-cart__table-info-title d-flex justify-content-between">
								<a href="<?php echo esc_url( $item_line['local_url'] ?? '' ); ?>"
									class="prodigy-cart__table-info-title-link">
									<?php echo esc_attr( $item_line['product_name'] ?? '' ); ?>
								</a>
								<span></span>
							</div>
							<p class="sku"><?php esc_attr_e( 'Sku:', 'prodigy' ); ?>
								<?php echo esc_attr( $item_line['product_sku'] ?? '' ); ?>
							</p>
							<ul class="prodigy-cart-item__info-variants">
								<?php
								if ( ! empty( isset( $item_line['option_variants'] ) && $item_line['option_variants'] ) ) {
									foreach ( $item_line['option_variants'] as $item_variant ) {
										echo "<li class='prodigy-cart-item__info-variants-attr'><span class='prodigy-cart-item__info-variants-attr-name'>" . esc_attr( $item_variant['name'] ) . ":&nbsp;</span><span class='prodigy-cart-item__info-variants-attr-value'> " . esc_attr( $item_variant['value'] ) . '</span></li>';
									}
								}
								?>
							</ul>

							<ul class="prodigy-cart-item__info-variants">
								<?php
								if ( isset( $item_line['attributes']['personalization'] ) ) {
									$i = 0;
									foreach ( $item_line['attributes']['personalization'] as $item ) {
										if ( ! empty( $item[ key( $item ) ]['value'] ) ) {
											$string = "<li class='prodigy-cart-item__info-variants-attr'><span class='prodigy-cart-item__info-variants-attr-name'>" . esc_attr( $item[ key( $item ) ]['label'] ) . ":&nbsp;</span><span class='prodigy-cart-item__info-variants-attr-value'> " . esc_attr( $item[ key( $item ) ]['value'] ) . '</span>' .
														'<span class="prodigy-cart-item__info-variants-attr-value">';
											if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) {
												if ( empty( $i ) && ( (float) $item[ key( $item ) ]['amount'] > 0 ) ) {
													$string .= ' (' . esc_html( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( esc_attr( $item[ key( $item ) ]['amount'] ) ) . ')' . '</span></li>';
												}
											}
											++$i;
											echo $string;
										}
									}
								}
								?>
							</ul>

							<ul class="prodigy-cart-item__info-variants prodigy-cart-item__info-logo-variants">
								<?php if ( ! empty( $item_line['attributes']['logos'] ) ) : ?>
									<?php $i = 1; ?>
									<?php foreach ( $item_line['attributes']['logos'] as $item ) : ?>
										<?php $i = count( $item_line['attributes']['logos'] ) === 1 ? '' : $i; ?>
										<?php $logo_charge_amount = (float) ( $item['logo']['charge-amount'] ?? 0 ); ?>
										<?php $logo_name = empty( $logo_charge_amount ) ? $item['logo']['name'] : $item['logo']['name']; ?>
										<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
											<?php $logo_name .= ' (+$' . Prodigy_Formatting::prodigy_price_format( $logo_charge_amount ) . ')'; ?>
										<?php endif; ?>
										<li>
											<span class="prodigy-cart-item__info-variants__name prodigy-cart-item__info-logo__name . <?php echo esc_attr( $key ); ?>">
												<?php echo empty( $i ) ? 'Logo:' : esc_html( sprintf( __( 'Logo %d', 'prodigy' ), $i ) ) . ':'; ?>
											</span>
											<span class="prodigy-cart-item__info-variants__value prodigy-cart-item__info-variants__logo-value . <?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $logo_name ); ?></span>
										</li>
										<li>
											<span class="prodigy-cart-item__info-variants__name prodigy-cart-item__info-location__name . <?php echo esc_attr( $key ); ?>">
												<?php echo empty( $i ) ? 'Location:' : esc_html( sprintf( __( 'Location %d', 'prodigy' ), $i ) ) . ':'; ?>
											</span>
											<span class="prodigy-cart-item__info-variants__value prodigy-cart-item__info-variants__location-value . <?php echo esc_attr( $key ); ?>">
												<?php echo esc_attr( $item['location']['name'] ); ?>
											</span>
										</li>
										<?php ++$i; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>


							<?php if ( isset( $item_line['subscriptions'] ) ) : ?>
								<div class="text-nowrap">
									<div class="d-flex mb-0">
										<div class="prodigy-cart-item__tag">
											<?php esc_html_e( 'Subscription', 'prodigy' ); ?>
										</div>
									</div>

									<div class="d-flex align-items-center flex-wrap flex-md-nowrap mb-4">
										<span class="prodigy-subscription-condition"><?php esc_html_e( 'Period:', 'prodigy' ); ?></span>

										<?php if ( $item_line['subscriptions']['attributes']['interval'] > 1 ) : ?>
											<span class="prodigy-subscription-condition-value"><?php esc_html_e( 'Every', 'prodigy' ); ?>
												<?php echo (int) $item_line['subscriptions']['attributes']['interval']; ?>
												<?php echo (int) $item_line['subscriptions']['attributes']['period']; ?>s</span>
										<?php else : ?>
											<span class="prodigy-subscription-condition-value"><?php esc_html_e( 'Every', 'prodigy' ); ?>
												<?php echo esc_attr( $item_line['subscriptions']['attributes']['period'] ); ?></span>
										<?php endif; ?>
									</div>
									<?php if ( ! isset( $item_line['subscriptions']['attributes']['number-of-charges'] ) ) : ?>
										<div class="d-flex align-items-center flex-wrap flex-md-nowrap mb-4">
											<span class="prodigy-subscription-condition"><?php esc_html_e( 'Duration:', 'prodigy' ); ?></span>
											<div class="prodigy-tooltip">
												<i class="icon icon-info"></i>
												<span class="prodigy-tooltip__message">
													<?php
													esc_html_e(
														'The subscription will continue to run until canceled. You can cancel your
                                                        subscription at any time.',
														'prodigy'
													);
													?>
									</span>
											</div>
											<span class="prodigy-subscription-condition-value"><?php esc_html_e( 'Valid until canceled', 'prodigy' ); ?></span>
										</div>
									<?php else : ?>
										<div class="d-flex align-items-center flex-wrap flex-md-nowrap mb-4">
											<span class="prodigy-subscription-condition"><?php esc_html_e( 'Duration:', 'prodigy' ); ?></span>
											<div class="prodigy-tooltip">
												<i class="icon icon-info"></i>
												<span class="prodigy-tooltip__message">
													<?php
													esc_html_e(
														'The subscription will run for the specified number of charges or until
                                                        canceled. You can cancel your subscription at any time.',
														'prodigy'
													);
													?>
									</span>
											</div>
											<?php if ( $item_line['subscriptions']['attributes']['number-of-charges'] > 1 ) : ?>
												<span
														class="prodigy-subscription-condition-value"><?php echo esc_attr( $item_line['subscriptions']['attributes']['number-of-charges'] ); ?>
													<?php esc_html_e( 'charges', 'prodigy' ); ?></span>
											<?php elseif ( $item_line['subscriptions']['attributes']['number-of-charges'] === 1 ) : ?>
												<span
														class="prodigy-subscription-condition-value"><?php echo esc_attr( $item_line['subscriptions']['attributes']['number-of-charges'] ); ?>
													<?php esc_html_e( 'charge', 'prodigy' ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<div class="d-flex align-items-center flex-wrap flex-md-nowrap">
										<span class="prodigy-subscription-condition"><?php esc_html_e( 'Next billing date:', 'prodigy' ); ?></span>
										<span
												class="prodigy-subscription-condition-value"><?php echo esc_attr( $item_line['subscriptions']['attributes']['next-run-date'] ); ?></span>
									</div>
								</div>
							<?php endif; ?>
							<div
									class="d-none d-md-flex flex-wrap flex-sm-nowrap justify-content-between align-items-baseline prodigy-cart__remove-wrapper w-100">
								<a href="#" id="remove-item-js"
									class="prodigy-cart__remove prodigy-cart__remove-item remove-item-js"
									data-cart-item='<?php echo wp_json_encode( $item_line['data_analytics'] ); ?>'
									aria-label="<?php esc_attr_e( 'Remove Item', 'prodigy' ); ?>"
									data-local-id="<?php echo esc_attr( $item_line['product_id'] ?? '' ); ?>"
									data-remote-id="<?php echo esc_attr( $item_line['product_id'] ?? '' ); ?>"
									data-line-item-id="<?php echo esc_attr( $item_line['id'] ?? '' ); ?>">
									<?php esc_html_e( 'Remove', 'prodigy' ); ?>
								</a>
							</div>
						</div>
					</td>
					<td class="d-flex d-md-table-cell prodigy-table-cell__count-wrap">
						<div
								class="d-flex d-md-none flex-wrap flex-sm-nowrap justify-content-between align-items-baseline prodigy-cart__remove-wrapper w-100">
							<a href="#" id="remove-item-js"
								class="prodigy-cart__remove prodigy-cart__remove-item remove-item-js"
								data-cart-item='<?php echo wp_json_encode( $item_line['data_analytics'] ); ?>'
								aria-label="<?php esc_attr_e( 'Remove Item', 'prodigy' ); ?>"
								data-local-id="<?php echo esc_attr( $item_line['product_id'] ?? '' ); ?>"
								data-remote-id="<?php echo esc_attr( $item_line['product_id'] ?? '' ); ?>"
								data-line-item-id="<?php echo esc_attr( $item_line['id'] ?? '' ); ?>"><?php esc_html_e( 'Remove', 'prodigy' ); ?>
							</a>
						</div>
						<div class="prodigy-counter pl-12 pr-12">
							<div class="prodigy-qty__wrap">
								<span class="prodigy-qty"><?php esc_html_e( 'qty:', 'prodigy' ); ?> </span>

								<input class="prodigy-counter__total prodigy-main-input prodigy-main-input__total-count counter-count-js"
										type="text"
										value="<?php echo (int) $item_line['item_quantity'] ?? 1; ?>"
										maxlength="5"/>

								<input type="hidden" class="inventory-product-data-js"
										value='<?php echo wp_json_encode( $item_line['inventory'] ); ?>'>
							</div>
						</div>
					</td>
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<?php if ( isset( $item_line['item_price'] ) ) : ?>
							<td class="d-none d-md-table-cell px-md-2">
								<p class="text-nowrap price-js mb-0 pt-0 prodigy-cart__total-price prodigy-cart__total-cell-price">
									<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $item_line['item_price'] ) ); ?>
									<?php if ( isset( $item_line['attributes']['setup-charge-amount'] ) && (float) $item_line['attributes']['setup-charge-amount'] > 0 ) : ?>
										<?php esc_html_e( '(Product Price)', 'prodigy' ); ?>
									<?php endif; ?>
								</p>
								<?php if ( isset( $item_line['attributes']['setup-charge-amount'] ) && (float) $item_line['attributes']['setup-charge-amount'] > 0 ) : ?>
									<p class="text-nowrap price-js mb-0 pt-0 prodigy-cart__total-price prodigy-cart__total-cell-price">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $item_line['attributes']['setup-charge-amount'] ) ); ?>
										<?php esc_html_e( '(Setup Charge)', 'prodigy' ); ?>
									</p>
								<?php endif; ?>
							</td>
						<?php endif; ?>
						<td class="text-right d-md-table-cell">
							<p class="text-nowrap mb-0 prodigy-cart__total-price prodigy-cart__total-price-sm prodigy-cart__total-cell total-price-js">
								<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $item_line['item_total'] ?? '' ) ); ?>
							</p>
							<input type="hidden" class="copy-total-price-js" value="">
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</section>

	<section class="prodigy-cart-subtotal__section cart-subtotal-js d-flex flex-row w-100 justify-content-sm-end">
		<div class="prodigy-cart-subtotal__block">
			<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
				<div class="prodigy-cart__total-info d-flex flex-row align-items-center">
					<div class="d-flex flex-row">
						<span
								class="prodigy-cart__total-text d-inline-block"><?php esc_html_e( 'Subtotal', 'prodigy' ); ?>:</span>
					</div>
					<div class="d-flex flex-row justify-content-end">
						<span
								class="prodigy-cart__total-value subtotal-price-js"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $order_attributes['total'] ?? '' ) ); ?></span>
					</div>
				</div>
			<?php endif; ?>
			<div class="prodigy-divider-block prodigy-divider-block--light w-100"></div>
			<div class="prodigy-subtotal__btn-block d-flex flex-row mr-0 ml-0 justify-content-between justify-content-sm-end flex-column-reverse flex-sm-row">
				<a class="prodigy-subtotal__btn-continue prodigy-main-button prodigy-main-button--outline mt-12 continue-cart-js"
					href="<?php echo esc_url( Prodigy_Page::prodigy_get_shop_url() ); ?>">
					<?php esc_html_e( 'Continue Shopping', 'prodigy' ); ?>
				</a>
				<button class="prodigy-main-button prodigy-main-button__checkout mt-12 checkout-button-js">
					<?php esc_html_e( 'Proceed to Checkout', 'prodigy' ); ?>
				</button>
			</div>
		</div>
	</section>

	<script src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/cart-page.js' ) . 'cart-page.js' ); ?>"></script>

<?php endif; ?>
