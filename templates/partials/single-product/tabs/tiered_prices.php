<?php

use Prodigy\Includes\frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Helpers\Prodigy_Formatting;

$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
$product          = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Template_Builder::get_random_product() );

if (
	( isset( $_GET['action'] ) && $_GET['action'] !== 'elementor' )
	|| ( isset( $_POST['action'] ) && $_POST['action'] !== 'elementor_ajax' )
) {
    $product = $GLOBALS['prodigy_product'] ?? $product;
}

?>
<!-- qty -->
<?php if ( !empty($product->get_tiered_prices())) : ?>
    <div class="prodigy-tabs__desc" id="prodigy-tabs__desc-qty">
        <p class="prodigy-tab__tiered-info">
            <?php esc_html_e( "Below is information about wholesale prices for the product, as well as your savings.", "prodigy" ); ?>
        </p>
        <div class="prodigy-table__bulk-qty-description">
            <div class="prodigy-table__bulk-qty-description-head d-none d-md-flex w-100">
                <div class="prodigy-table__bulk-head-cell flex-shrink-1"><?php esc_html_e( "Quantity", "prodigy" ); ?></div>
                <div class="prodigy-table__bulk-head-cell flex-grow-1 text-center"><?php esc_html_e( "Price per unit", "prodigy" ); ?></div>
                <div class="prodigy-table__bulk-head-cell flex-shrink-1 text-right"><?php esc_html_e( "You save", "prodigy" ); ?></div>
            </div>
            <?php foreach($product->get_tiered_prices() as $key=>$price): ?>
                <div class="prodigy-table__bulk-qty-description-cell w-100">
                    <div class="flex-1 prodigy-table__bulk-body-cell">
                        <span class="prodigy-table__bulk-qty-description-head prodigy-table__bulk-qty-description-head-sm d-md-none"><?php esc_html_e( "Quantity", "prodigy" ); ?></span>
                        <?php if ($price['attributes']['min-quantity'] === $price['attributes']['max-quantity']): ?>
                            <span><?php echo $price['attributes']['min-quantity'] ?></span>
                        <?php elseif( $price['attributes']['max-quantity'] === \Prodigy\includes\content\Prodigy_Product_Parser::MAX_RANGE_LIMIT ): ?>
                            <span><?php echo $price['attributes']['min-quantity'] ?>+</span>
                        <?php else: ?>
                            <span><?php echo $price['attributes']['min-quantity'] ?>-<?php echo $price['attributes']['max-quantity']?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 prodigy-table__bulk-body-cell">
                        <span class="prodigy-table__bulk-qty-description-head prodigy-table__bulk-qty-description-head-sm d-md-none"><?php esc_html_e( "Price per unit", "prodigy" ); ?></span>
                        <span>
                            <span>$</span><?php echo Prodigy_Formatting::prodigy_price_format($price['attributes']['flat-price']) ?>
                        </span>
                    </div>
                    <div class="flex-1 prodigy-table__bulk-body-cell">
                        <span class="prodigy-table__bulk-qty-description-head prodigy-table__bulk-qty-description-head-sm d-md-none"><?php esc_html_e( "You save", "prodigy" ); ?></span>
                        <span><?php echo $price['attributes']['discount'] ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<!-- end qty -->
