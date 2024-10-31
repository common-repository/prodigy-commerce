<?php
/* Template Name: Top Menu Categories shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<ul class="prodigy-navbar__menu prodigy-custom-template">
	<li><a class="prodigy-navbar__menu-item" href="#"><?php esc_html_e( "ABOUT", "prodigy" ); ?></a></li>
	<li class="prodigy-navbar__menu-item-wrp">
		<div class="prodigy-navbar__menu-item prodigy-navbar__menu-item--collapse d-lg-none">
			<a href="<?php echo esc_url( $link_to_shop ); ?>"><?php esc_html_e( "SHOP", "prodigy" ); ?></a>
			<button class="prodigy-navbar__menu-item-btn" type="button" data-toggle="collapse" data-target="#prodigy-navbar-collapse" aria-expanded="false" aria-controls="prodigy-navbar-collapse">
				<i class="icon icon-arrow-down prodigy-navbar__menu-item-icon"></i>
			</button>
		</div>
		<a class="prodigy-navbar__menu-item prodigy-navbar__menu-item--collapse d-none d-lg-flex" href="<?php echo esc_url( $link_to_shop ); ?>">
			<span><?php esc_html_e( "SHOP", "prodigy" ); ?></span>
			<i class="icon icon-arrow-down prodigy-navbar__menu-item-icon"></i>
		</a>
		<div class="collapse prodigy-collapse prodigy-collapse-js" id="prodigy-navbar-collapse">
			<?php

			foreach ( $categories as $category ) :

				$sub_categories = get_categories(
					array(
						'taxonomy'   => Prodigy::get_prodigy_category_type(),
						'orderby'    => 'name',
						'order'      => 'ASC',
						'hide_empty' => false,
						'parent'     => $category->term_id,
					)
				);

				?>
				
				<div>
					<ul class="prodigy-collapse__list">
						<li><a class="prodigy-collapse__list-item" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
								<?php echo esc_attr( mb_strtoupper( $category->name ) ); ?>
							</a>
						</li>
						
						<?php foreach ( $sub_categories as $sub_category ) : ?>
							<li><a class="prodigy-collapse__list-item" href="<?php echo esc_url( get_category_link( $sub_category->term_id ) ); ?>"><?php echo esc_attr( $sub_category->name ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			
			<?php endforeach; ?>
		
		</div>
	</li>
	<li><a class="prodigy-navbar__menu-item" href="#"><?php esc_html_e( "OUR STORES", "prodigy" ); ?></a></li>
	<li><a class="prodigy-navbar__menu-item" href="#"><?php esc_html_e( "BLOG", "prodigy" ); ?></a></li>
	<li><a class="prodigy-navbar__menu-item" href="#"><?php esc_html_e( "CONTACT", "prodigy" ); ?></a></li>
	<li><a class="prodigy-navbar__menu-item" href="#"><?php esc_html_e( "FAQ", "prodigy" ); ?></a></li>
	<li class="d-lg-none"><a class="prodigy-navbar__menu-item d-flex" href="#">
			<i class="icon icon-message mr-8 font-20"></i><?php esc_html_e( "NEWSLETTER", "prodigy" ); ?></a></li>
	<li class="prodigy-navbar-account d-lg-none">
		<a class="prodigy-navbar__menu-item" href="#">
			<?php esc_html_e( "MY ACCOUNT", "prodigy" ); ?>
		</a>
	</li>
	<li class="d-lg-none"><a class="prodigy-navbar-cart prodigy-navbar__menu-item" href="#">
			<span class="prodigy-navbar-cart__txt"><?php esc_html_e( "CART", "prodigy" ); ?></span>
			<div class="position-relative pr-14 d-inline-block"><i
					class="icon icon-cart prodigy-navbar-cart__icon"></i>
				<div class="prodigy-navbar-cart__count">0</div>
			</div>
		</a></li>
</ul>
