<?php

defined( 'ABSPATH' ) || exit;

use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;

$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
$product          = $GLOBALS['prodigy_product'] ?? $product_template->get_product( (int) Prodigy_Product_Parser::get_random_product() );
$subscriptions    = $product->get_subscriptions();
