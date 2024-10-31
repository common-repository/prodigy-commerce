<?php
/* Template Name: Active Filters ajax template */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$heading_text = $data['attr_shortcode']['active_filters_style_heading_text'] ?? 'Active Filters';
$is_show_active_filter_name = empty($data['attr_shortcode']['active_filters_show_attribute_name']) ? null : true;
?>

<?php if ( ! empty( $data['args_request'] ) ) : ?>
    <div class="prodigy-filter__main prodigy-custom-template">
    <div class="prodigy-filter__main-title-wrap">
        <h3 class="prodigy-filter__title"><?php echo esc_attr(  $heading_text ); ?></h3>

        <?php if ( ! empty( $data['args_request'] ) ) : ?>
            <span class="prodigy-main-badge__md">
                <a class="prodigy-main-badge prodigy-main-badge--btn clear-params-js">
                    <?php esc_attr_e( 'Clear All', 'prodigy' ); ?>
                </a>
            </span>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ( $data['args_request'] ): ?>
    <div class="prodigy-filter__badges">
<?php endif; ?>
        <?php foreach ( $data['args_request'] ?? array() as $attribute => $value ) : ?>
            <?php foreach ( $value as $key=>$values ) : ?>
                <?php foreach ( $values as $value_one ) : ?>
                    <span
                            class="prodigy-main-badge"
                            data-attribute-name="<?php echo esc_attr( $key ); ?>"
                            data-attribute-value="<?php echo esc_attr( $value_one ); ?>"
                    >
                        <span class="prodigy-main-badge__text">
                        <?php if ( isset($is_show_active_filter_name) ): ?>
                            <span class="prodigy-main-badge__inner-wrap">
                                <span class="prodigy-main-badge__attr"><?php echo esc_attr( $key === 'Price' ? $key . ':' : $attribute . ':'); ?></span>
                                <span class="prodigy-main-badge__val"><?php echo esc_attr( $value_one ); ?></span>
                            </span>
                        <?php else: ?>
                            <span class="prodigy-main-badge__val"><?php echo esc_attr( $value_one ); ?></span>
                        <?php endif; ?>
                            <i class="prodigy-main-badge__close icon icon-close filter-close-js"></i>
                        </span>

                        <span class="prodigy-main-badge__divider"></span>
                    </span>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
<?php if ( $data['args_request'] ): ?>
    </div>
<?php endif; ?>

<?php if (! empty( $args_request ) ) : ?>
    </div>
<?php endif; ?>
