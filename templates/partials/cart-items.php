<?php

use Prodigy\Includes\Helpers\Prodigy_Formatting;

?>

<div class="prodigy-cart-dropdown__body cart-dropdown-widget-item-list-js">
	<div class="prodigy-cart-item prodigy-cart-loading__element prodigy-cart-loading__element-js" style="display:none">
		<div class="d-flex flex-column prodigy-cart__placeholder-wrap">
			<div class="prodigy-cart__placeholder"></div>
		</div>
		<div class="prodigy-cart-item__info">
			<span class="prodigy-cart-item__info-title prodigy-cart-item__loading-info-title">
				<?php esc_html_e( 'Some Loading Product Name', 'prodigy' ); ?>
			</span>
			<div class="prodigy-cart-item__info-price">
				<div class="prodigy-cart-item__info-price-qty">
					<span class="prodigy-cart-item__qty-text"><?php esc_html_e( 'qty', 'prodigy' ); ?>:</span>
					<span class="prodigy-cart-item__info-price__count">00</span>
				</div>
				<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
					<div class="prodigy-cart-item__info-price-prc">
						<span class="prodigy-cart-item__prc-text"><?php esc_html_e( 'Price', 'prodigy' ); ?>:</span>
						<span class="prodigy-cart-item__info-price__count">$000.00</span>
					</div>
				<?php endif; ?>
			</div>
			<ul class="prodigy-cart-item__info-variants"></ul>
			<button class="prodigy-cart-item__remove-btn" type="button">
				<?php esc_html_e( 'Remove', 'prodigy' ); ?>
			</button>
		</div>
	</div>

	<?php foreach ( $cart_products as $remote_product_id => $product ) : ?>
		<?php
		$image     = $product['attributes']['versions-image-url'];
		$image_src = ! empty( $image ) ? '<img loading="lazy" alt="' . esc_html__( 'Product', 'prodigy' ) . '" width="150" src="' . $image['thumbnails'] . '" srcset="' . $image['thumbnails'] . ' 1x, ' . $image['thumbnails_retina'] . ' 2x" />' : '';
		?>
		<div class="prodigy-cart-item prodigy-cart-item__widget-item widget-cart-item-js">
			<div class="d-flex flex-column prodigy-cart__placeholder-wrap">
				<div class="prodigy-cart__placeholder">
					<a class="prodigy-cart-item__link"
						href="<?php echo esc_url( get_permalink( $product['local_parent_product_id'] ) ); ?>">
						<div class="prodigy-cart-item__img <?php echo empty( $image_src ) ? 'icon icon-image' : ''; ?>">
							<?php echo wp_kses_post( $image_src ); ?>
						</div>
					</a>
				</div>
				<div class="d-flex flex-wrap prodigy-cart__placeholder-logo">
					<?php if ( ! empty( $product['logo_options'] ) ) : ?>
						<?php foreach ( $product['logo_options'] as $key => $item ) : ?>
							<span class="d-block">
								<img src="<?php echo esc_url( $item['logo']['original-url'] ); ?>"
									alt="logo"
									loading="lazy"
								/>
							</span>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="prodigy-cart-item__info">
				<a class="prodigy-cart-item__info-title"
					href="<?php echo esc_url( get_permalink( $product['local_parent_product_id'] ) ); ?>"><?php echo esc_attr( $product['name'] ); ?></a>
				<div class="prodigy-cart-item__info-price widget-cart-product-price-js">
					<div class="prodigy-cart-item__info-price-qty">
						<span class="prodigy-cart-item__qty-text"><?php esc_html_e( 'qty', 'prodigy' ); ?>:</span>
						<span class="prodigy-cart-item__info-price__count widget-cart-count-item-js">
							<?php echo esc_attr( $product['count_items'] ) ?? 0; ?>
						</span>
					</div>
					<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
						<div class="prodigy-cart-item__info-price-prc">
							<span class="prodigy-cart-item__prc-text"><?php esc_html_e( 'Product Price', 'prodigy' ); ?>:</span>
							<span class="prodigy-cart-item__info-price__value widget-total-price-js">
								<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['actual_price'] ) ); ?>
							</span>
						</div>
							<?php if ( isset( $product['attributes']['setup-charge-amount'] ) && (float) $product['attributes']['setup-charge-amount'] > 0 ) : ?>
							<div class="prodigy-cart-item__info-price-prc">
								<span class="prodigy-cart-item__prc-text"><?php esc_html_e( 'Setup Charge', 'prodigy' ); ?>:</span>
								<span class="prodigy-cart-item__info-price__value widget-total-price-js">
								<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $product['attributes']['setup-charge-amount'] ) ); ?>
							</span>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if ( isset( $product['subscriptions'] ) ) : ?>
					<div>
						<div class="d-flex">
							<div class="prodigy-cart-item__tag">
								<?php esc_html_e( 'Subscription', 'prodigy' ); ?>
							</div>
						</div>

						<div>
							<div class="prodigy-cart-item-subscr__item">
								<span class="prodigy-cart-item-subscr__condition">
									<?php esc_html_e( 'Period', 'prodigy' ) . ':'; ?>
								</span>

								<?php if ( $product['subscriptions']['attributes']['interval'] > 1 ) : ?>
									<span class="prodigy-cart-item-subscr__value">
									<?php
									echo esc_html_e( 'Every', 'prodigy' ) . ' ';
									esc_attr( $product['subscriptions']['attributes']['interval'] );
									?>
										<?php echo esc_attr( $product['subscriptions']['attributes']['period'] ); ?>s</span>
								<?php else : ?>
									<span class="prodigy-cart-item-subscr__value">
									<?php
									echo esc_html_e( 'Every', 'prodigy' ) . ' ';
									esc_attr( $product['subscriptions']['attributes']['period'] );
									?>
										</span>
								<?php endif; ?>
							</div>
							<?php if ( ! isset( $product['subscriptions']['attributes']['number-of-charges'] ) ) : ?>
								<div class="prodigy-cart-item-subscr__item">
									<span class="prodigy-cart-item-subscr__condition">
										<?php esc_html_e( 'Duration', 'prodigy' ) . ':'; ?>
									</span>
									<div class="prodigy-tooltip">
										<i class="icon icon-info"></i>
										<span class="prodigy-tooltip__message">
											<?php esc_html_e( 'The subscription will continue to run until canceled. You can cancel your subscription at any time.', 'prodigy' ); ?>
										</span>
									</div>
									<span class="prodigy-cart-item-subscr__value ml-4"><?php esc_html_e( 'Valid until canceled', 'prodigy' ); ?></span>
								</div>
							<?php else : ?>
								<div class="prodigy-cart-item-subscr__item">
									<span class="prodigy-cart-item-subscr__condition">
										<?php esc_html_e( 'Duration', 'prodigy' ) . ':'; ?>
									</span>
									<div class="prodigy-tooltip">
										<i class="icon icon-info"></i>
										<span class="prodigy-tooltip__message">
											<?php esc_html_e( ' The subscription will continue to run until canceled. You can cancel your subscription at any time.', 'prodigy' ); ?>
										</span>
									</div>
									<?php if ( $product['subscriptions']['attributes']['number-of-charges'] > 1 ) : ?>
										<span class="prodigy-cart-item-subscr__value ml-4"><?php echo esc_attr( $product['subscriptions']['attributes']['number-of-charges'] ); ?> charges</span>
									<?php elseif ( $product['subscriptions']['attributes']['number-of-charges'] === 1 ) : ?>
										<span class="prodigy-cart-item-subscr__value ml-4"><?php echo esc_attr( $product['subscriptions']['attributes']['number-of-charges'] ); ?> charge</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div class="prodigy-cart-item-subscr__item">
								<span class="prodigy-cart-item-subscr__condition">
									<?php esc_html_e( 'Next billing date', 'prodigy' ) . ':'; ?>
								</span>
								<span class="prodigy-cart-item-subscr__value"><?php echo esc_attr( $product['subscriptions']['attributes']['next-run-date'] ); ?></span>
							</div>
						</div>
					</div>
				<?php endif; ?>


				<ul class="prodigy-cart-item__info-variants">
					<?php if ( ! empty( $product['option_variants'] ) ) : ?>
						<?php foreach ( $product['option_variants'] as $item_variant ) : ?>
							<li>
								<span class="prodigy-cart-item__info-variants__name"><?php echo esc_attr( $item_variant['name'] ); ?>:</span>
								<span class="prodigy-cart-item__info-variants__value"><?php echo esc_attr( $item_variant['value'] ); ?></span>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>


				<ul class="prodigy-cart-item__info-variants">
					<?php
					if ( ! empty( $product['attributes']['personalization'] ) ) :
						?>
						<?php $i = 0; ?>
						<?php foreach ( $product['attributes']['personalization'] as $item ) : ?>
							<?php if ( ! empty( $item[ key( $item ) ]['value'] ) ) : ?>
								<li>
									<span class="prodigy-cart-item__info-variants__name"><?php echo esc_attr( $item[ key( $item ) ]['label'] ); ?>:</span>
									<span class="prodigy-cart-item__info-variants__value"><?php echo esc_attr( $item[ key( $item ) ]['value'] ); ?></span>
									<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
										<?php if ( empty( $i ) && (float) $item[ key( $item ) ]['amount'] > 0 ) : ?>
											<span class="prodigy-cart-item__info-variants__value">(<?php echo esc_html( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( esc_attr( $item[ key( $item ) ]['amount'] ) ); ?>)</span>
										<?php endif; ?>
									<?php endif; ?>
								</li>
								<?php ++$i; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>


				<ul class="prodigy-cart-item__info-variants prodigy-cart-item__info-logo-variants"
				>
					<?php if ( ! empty( $product['logo_options'] ) ) : ?>
						<?php $i = 1; ?>
						<?php foreach ( $product['logo_options'] as $key => $item ) : ?>
							<?php $i = count( $product['logo_options'] ) === 1 ? '' : $i; ?>
							<?php $logo_charge_amount = (float) ( $item['logo']['charge-amount'] ?? 0 ); ?>
							<?php $logo_name = empty( $logo_charge_amount ) ? $item['logo']['name'] : $item['logo']['name']; ?>
							<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
								<?php $logo_name .= '(+$' . Prodigy_Formatting::prodigy_price_format( $logo_charge_amount ) . ')'; ?>
							<?php endif; ?>
							<li>
								<?php $logo_title = empty( $i ) ? 'Logo:' : sprintf( __( 'Logo %d:', 'prodigy' ), $i ); ?>
								<span class="prodigy-cart-item__info-variants__name prodigy-cart-item__info-logo__name . <?php echo esc_attr( $key ); ?>"><?php echo esc_html( $logo_title ); ?></span>
								<span class="prodigy-cart-item__info-variants__value prodigy-cart-item__info-variants__logo-value . <?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $logo_name ); ?></span>
							</li>
							<li>
								<?php $location_title = empty( $i ) ? 'Location:' : esc_html( sprintf( __( 'Location %d', 'prodigy' ), $i ) ) . ':'; ?>
								<span class="prodigy-cart-item__info-variants__name prodigy-cart-item__info-location__name . <?php echo esc_attr( $key ); ?>"><?php echo esc_html( $location_title ); ?></span>
								<span class="prodigy-cart-item__info-variants__value prodigy-cart-item__info-variants__location-value . <?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $item['location']['name'] ); ?></span>
							</li>
							<?php ++$i; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
				<button
						class="prodigy-cart-item__remove-btn text-center widget-remove-item-js"
						type="button"
						data-line-item-id="<?php echo esc_attr( $product['id'] ); ?>"
						data-remote-id="<?php echo esc_attr( $remote_product_id ); ?>"
				>
					<?php esc_html_e( 'Remove', 'prodigy' ); ?>
				</button>
			</div>
		</div>
	<?php endforeach; ?>
</div>
