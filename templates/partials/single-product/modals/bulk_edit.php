<div class="modal fade prodigy-bulk-modal" id="disableBulkModal">
	<div class="modal-dialog modal-dialog-centered prodigy-bulk-modal__dialog">
		<div class="modal-content prodigy-bulk-modal__content">
			<div class="prodigy-bulk-modal__body modal-body">
				<div class="prodigy-bulk-modal__body-title d-flex justify-content-between align-items-center">
					<h4 class="mt-0 mb-0 disable-bulk-modal-text-js">
						<?php esc_html_e( 'Disable Multiple Quantity', 'prodigy' ); ?>
					</h4>
					<a role="button"
						rel="noopener"
						class="icon icon-small-close cursor-pointer prodigy-bulk-modal__icon-close"
						data-dismiss="modal" aria-label="Close"></a>
				</div>
				<p><?php esc_html_e( 'Any items that you have selected but not added to your cart will be removed.', 'prodigy' ); ?></p>
				<p><?php esc_html_e( 'Are you sure you want to disable multiple quantity?', 'prodigy' ); ?></p>
			</div>
			<div class="prodigy-bulk-modal__footer modal-footer border-top-0">
				<div class="prodigy-bulk-modal__footer-btn-wrap d-flex w-100 justify-content-center align-items-center justify-content-md-end flex-wrap">
					<button type="button" class="prodigy-main-button prodigy-main-button--outline close-bulk-modal-js">
						<?php esc_html_e( 'Cancel', 'prodigy' ); ?>
					</button>
					<button type="button" class="prodigy-main-button disable-bulk-button-js" data-attribute="">
						<?php esc_html_e( 'Disable Multiple Quantity', 'prodigy' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
