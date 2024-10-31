<?php
/* Template Name: Search shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( $search_type === 'normal' ) : ?>
    <form class="prodigy-search prodigy-custom-template">
        <input class="prodigy-main-input prodigy-search__input prodigy-search__input-js"
               placeholder="<?php echo esc_attr( $placeholder ); ?>" type="text">
        <button aria-label="Search" class="prodigy-search__icon prodigy-search__icon-widget-js" type="button">
            <?php if ( $icon_type === 'icon' ) : ?>
                <?php if ( $icon_class !== '' ) : ?>
                    <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                <?php endif; ?>
            <?php elseif ( $icon_type === 'svg' ) : ?>
                <img class="icon-img" src="<?php echo esc_url( $settings['prg_style_search_icon']['value']['url'] ); ?>"
                    alt="<?php esc_attr_e( 'Search', 'prodigy' ); ?>">
            <?php endif; ?>
        </button>
        <button aria-label="Clear Search" class="prodigy-search__close-icon d-none" type="button"></button>
    </form>
<?php elseif ( $search_type === 'button' ) : ?>
    <!-- Search widget shortcode for search widget as icon -->
    <li class="prodigy-navbar__custom-search">
        <form class="prodigy-custom-template prodigy-search__custom-dropdown prodigy-search">
            <div class="prodigy-search__custom-dropdown-wrap prodigy-search__custom-search">
                <?php if ( $icon_type === 'icon' ) : ?>
                    <?php if ( $icon_class !== '' ) : ?>
                        <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                    <?php endif; ?>
                <?php elseif ( $icon_type === 'svg' ) : ?>
                    <img class="icon-img" src="<?php echo esc_url( $settings['prg_style_search_icon']['value']['url'] ); ?>" 
                        alt="<?php esc_attr_e( 'Search', 'prodigy' ); ?>">
                <?php endif; ?>
                <span class="prodigy-search__custom-title"><?php echo esc_html( $placeholder ); ?></span>
            </div>
            <div class="prodigy-search__custom-dropdown-block-search">
                <div class="position-relative prodigy-search__custom-dropdown-block-search-wrap">
                    <input class="prodigy-main-input prodigy-search__input prodigy-search__input-js"
                       placeholder="<?php echo esc_attr( $placeholder ); ?>" type="text">
                    <button aria-label="Search" class="prodigy-search__icon" type="button">
                        <?php if ( $icon_type === 'icon' ) : ?>
                            <?php if ( $icon_class !== '' ) : ?>
                                <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                            <?php endif; ?>
                        <?php elseif ( $icon_type === 'svg' ) : ?>
                            <img class="icon-img" src="<?php echo esc_url( $settings['prg_style_search_icon']['value']['url'] ); ?>"
                                alt="<?php esc_attr_e( 'Search', 'prodigy' ); ?>">
                        <?php endif; ?>
                    </button>
                    <button aria-label="Clear Search" class="prodigy-search__close-icon d-none" type="button"></button>
                </div>
            </div>
        </form>
    </li>
<?php endif; ?>

