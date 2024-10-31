<?php
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( $show_breadcrumbs ) :
    ?>

<ul class="prodigy-breadcrumbs prodigy-custom-template">
	<li class="prodigy-breadcrumbs__item">
		<a href="<?php echo get_home_url() ?>" class="prodigy-breadcrumbs__item-link"><?php esc_html_e( 'home', 'prodigy' ); ?></a>
	</li>
	<span class="prodigy-breadcrumbs__item-divider">/</span>
	<li class="prodigy-breadcrumbs__item">
		<a href="<?php echo esc_url( Prodigy_Page::prodigy_get_shop_url() ); ?>"
		   class="prodigy-breadcrumbs__item-link"><?php esc_html_e( 'shop', 'prodigy' ); ?></a>
	</li>
	<?php if ( ! empty( $category ) ) : ?>
		<span class="prodigy-breadcrumbs__item-divider">/</span>
	<?php endif; ?>
	<?php if ( ! empty( $category ) ) : ?>
		<li class="prodigy-breadcrumbs__item">
			<a href="<?php echo esc_url( $link_to_category ); ?>" class="prodigy-breadcrumbs__item-link">
				<?php echo html_entity_decode( esc_html( mb_strtolower( $category ) ) ); ?>
			</a>
		</li>
	<?php endif; ?>
	<?php if ( ! empty( $style_curr_page ) && ! empty( $title ) ) : ?>
		<span class="prodigy-breadcrumbs__item-divider">/</span>
		<span class="prodigy-breadcrumbs__item">
			<?php echo esc_html( $title ); ?>
		</span>
	<?php endif; ?>
</ul>
	<?php
endif;
?>
