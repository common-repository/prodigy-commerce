<?php defined( 'ABSPATH' ) || exit; ?>
<div class="prodigy-promo prodigy-custom-template">
  <div class="prodigy-promo__inner">
	<section class="prodigy-promo__content">
	  <h2 class="prodigy-promo-content__title"><?php echo esc_attr( $args['title'] ); ?></h2>
	  <p class="prodigy-promo-content__txt"><?php echo esc_attr( $args['main_text'] ); ?></p>
	  <div class="prodigy-promo-content__nav">
		  <?php foreach ( $args['buttons'] as $key => $button ) : ?>
			  <a href="<?php echo get_home_url() . trim( $buttons_links[ $key ] ); ?>" class="prodigy-promo-content__nav-link"><?php echo esc_html( $button ); ?></a>
		  <?php endforeach; ?>
	  </div>
	</section>
  </div>
  <div
	class="prodigy-promo__img"
	style="background-image: url(<?php echo esc_url( $args['image'] ); ?>)"
  ></div>
</div>
