<ul class="prodigy-product__tags">

	<?php

	/**
	 * Hook: prodigy_product_additional_info.
	 *
	 * @hooked prodigy_product_template_sku - 10
	 * @hooked prodigy_product_template_tags - 15
	 *
	 * @var array $settings
	 */
	do_action( 'prodigy_product_additional_info', $args );

	?>
</ul>
