<?php
use Prodigy\Includes\Helpers\Prodigy_Page;

/* Template Name: Cross Sells shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$customizer_shop_options           = get_option( 'prodigy_shop_settings' );
$style_curr_page                   = isset( $attr_shortrcode['idwidget'] ) ? $attr_shortrcode['style_curr_page'] : 'yes';
$prodigy_shop_products_breadcrumbs = $customizer_shop_options['prodigy_shop_products_breadcrumbs'] ?? true;
$show_breadcrumbs                  = isset( $attr_shortrcode['idwidget'] ) ? true : ( $customizer_shop_options['prodigy_shop_products_breadcrumbs'] ?? true );
if ( $show_breadcrumbs ) :
	?>

<ul class="prodigy-breadcrumbs prodigy-custom-template">
    <input type="hidden" class="category-name-js" value="<?php echo get_query_var( 'term' ); ?>">
    <input type="hidden" class="slug-name-js" value="<?php echo get_query_var('taxonomy'); ?>">

	<li class="prodigy-breadcrumbs__item">
		<a class="prodigy-breadcrumbs__item-link" href="<?php echo get_home_url() ?>"><?php esc_html_e( 'home', 'prodigy' ); ?></a>
	</li>
	<span class="prodigy-breadcrumbs__item-divider">/</span>
	<li class="prodigy-breadcrumbs__item">
		<a class="prodigy-breadcrumbs__item-link" href="<?php echo esc_url( Prodigy_Page::prodigy_get_shop_url() ); ?>"><?php esc_html_e( 'shop', 'prodigy' ); ?></a>
	</li>
	<?php if ( ! empty( $category_name ) && isset( $url_to ) && $style_curr_page == 'yes' ) : ?>
		<span class="prodigy-breadcrumbs__item-divider">/</span>
		<span class="prodigy-breadcrumbs__item">
			<?php echo html_entity_decode( esc_html( mb_strtolower( $category_name ) ) ); ?>
		</span>
	<?php endif; ?>
</ul>

	<?php
endif;
?>
