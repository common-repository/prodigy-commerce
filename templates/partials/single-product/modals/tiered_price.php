<div class="modal fade prodigy-bulk-modal tiered-price-modal-js" id="minorderQTY">
	<div class="modal-dialog modal-dialog-centered prodigy-order-modal__dialog">
		<div class="modal-content prodigy-order-modal__content">
			<div class="prodigy-order-modal__body modal-body">
				<div class="prodigy-order-modal__body-title d-flex justify-content-between align-items-center">
					<h4 class="mt-0 mb-0">
						<?php esc_html_e( "Minimum Order Quantity", "prodigy" ); ?>
					</h4>
					<a role="button"
					   rel="noopener"
					   class="icon icon-small-close cursor-pointer prodigy-order-modal__icon-close"
					   data-dismiss="modal" aria-label="Close"></a>
				</div>
				<p class="tiered-price-message-js"></p>
				<p><?php esc_html_e( "Need a different quantity?", "prodigy" ); ?>
                    <a href="mailto:<?php echo get_option( 'admin_email' ) ?>"><?php esc_html_e( "Contact us", "prodigy" ); ?></a>
				</p>
			</div>
			<div class="prodigy-order-modal__footer modal-footer border-top-0">
				<div class="prodigy-order-modal__footer-btn-wrap d-flex w-100 align-items-center justify-content-end flex-wrap">
					<button type="button" class="prodigy-main-button close-tiered-prices-js">
						<?php esc_html_e( "Back to item", "prodigy" ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
