<?php
/**
 *
 * @see prodigy_output_content_wrapper()
 * @see prodigy_container_shop_block()
 */
add_action( 'prodigy_before_main_content', 'prodigy_output_content_wrapper' );
add_action( 'prodigy_before_main_content', 'prodigy_container_shop_block', 20 );

/**
 * @see prodigy_output_content_wrapper_end()
 * @see prodigy_product_get_captcha()
 */
add_action( 'prodigy_after_main_content', 'prodigy_output_content_wrapper_end' );
add_action( 'prodigy_after_main_content', 'prodigy_product_get_captcha', 20 );
add_action( 'prodigy_get_product_subscriptions', 'prodigy_get_template_product_subscriptions', 20 );

/**
 * Thank you page
 *
 * @see prodigy_get_thank_you_page()
 */
add_action( 'prodigy_thank_you_page', 'prodigy_get_thank_you_page', 15 );

/**
 * Shop page
 *
 * @see prodigy_get_template_products_loop()
 * @see prodigy_get_pagination_template()
 * @see prodigy_get_template_without_result_template()
 * @see prodigy_shop_get_breadcrumbs_template()
 * @see prodigy_shop_get_template_sortable()
 * @see prodigy_shop_get_content_template()
 * @see prodigy_shop_get_quick_template()
 * @see prodigy_shop_sidebar_template()
 */

add_action( 'prodigy_shop_sidebar', 'prodigy_shop_sidebar_template' );
add_action( 'prodigy_shop_products_loop', 'prodigy_get_template_products_loop' );

add_action( 'prodigy_product_loop_rating_stars', 'prodigy_get_template_products_loop_rating' );

add_action( 'prodigy_shop_after_loop', 'prodigy_get_pagination_template' );
add_action( 'prodigy_shop_without_result', 'prodigy_get_template_without_result_template' );

add_action( 'prodigy_shop_breadcrumbs_block', 'prodigy_shop_get_breadcrumbs_template' );
add_action( 'prodigy_shop_sortable_block', 'prodigy_shop_get_template_sortable', 20 );

add_action( 'prodigy_shop_get_content', 'prodigy_shop_get_content_template' );
add_action( 'prodigy_shop_get_quick_view', 'prodigy_shop_get_quick_template' );

/**
 * Product page
 *
 * @see prodigy_product_template_title()
 * @see prodigy_product_template_range_price()
 * @see prodigy_product_template_meta()
 * @see prodigy_product_template_rating()
 * @see prodigy_product_template_short_description()
 * @see prodigy_product_template_variants()
 * @see prodigy_product_template_add_to_cart()
 * @see prodigy_show_product_thumbnails()
 * @see prodigy_show_product_images()
 * @see prodigy_display_product_attributes()
 * @see prodigy_output_product_data_tabs()
 * @see prodigy_upsell_products_display()
 * @see prodigy_single_product_breadcrumbs_template()
 * @see prodigy_product_template_quick_view_title()
 */



add_action( 'prodigy_product_summary_first', 'prodigy_single_product_breadcrumbs_template', 1 );
add_action( 'prodigy_single_product_breadcrumbs', 'prodigy_single_product_breadcrumbs_template', 1 );


add_action( 'prodigy_product_summary_first', 'prodigy_product_template_title', 5 );
add_action( 'prodigy_single_product_title', 'prodigy_product_template_title', 5 );
add_action( 'prodigy_product_summary_first', 'prodigy_product_template_range_price', 7 );
add_action( 'prodigy_product_summary_first', 'prodigy_product_template_meta' );
add_action( 'prodigy_product_summary_first', 'prodigy_product_template_rating', 15 );
add_action( 'prodigy_single_product_rating', 'prodigy_product_template_rating', 15 );

add_action( 'prodigy_single_product_price_range', 'prodigy_product_template_range_price', 15 );

add_action( 'prodigy_product_summary_first', 'prodigy_product_template_short_description', 20 );

add_action( 'prodigy_product_short_description', 'prodigy_product_template_short_description', 20 );

add_action( 'prodigy_product_summary_second', 'prodigy_product_template_variants', 25 );
add_action( 'prodigy_product_summary_second', 'prodigy_product_template_add_to_cart', 35 );
add_action( 'prodigy_product_additional_info', 'prodigy_product_template_sku' );

add_action( 'prodigy_product_additional_info', 'prodigy_product_template_tags', 15 );

add_action( 'prodigy_product_additional_info_widget', 'prodigy_product_template_additional_info', 15 );

add_action( 'prodigy_product_thumbnails', 'prodigy_show_product_thumbnails', 20 );
add_action( 'prodigy_before_single_product_summary', 'prodigy_show_product_images' );

add_action( 'prodigy_product_additional_information', 'prodigy_display_product_attributes' );

add_action( 'prodigy_after_single_product_tabs', 'prodigy_output_product_data_tabs' );
add_action( 'prodigy_shortcode_template_products', 'prodigy_get_template_shortcode_products' );

add_action( 'prodigy_product_review_tab', 'prodigy_product_comments_tab' );

add_action( 'prodigy_product_tiered_tab', 'prodigy_product_tiered_prices_tab' );

add_action( 'prodigy_product_logo', 'prodigy_product_get_logo_template' );

/**
 * Reviews
 *
 * @see prodigy_product_template_review_rating()
 * @see prodigy_review_display_gravatar()
 * @see prodigy_review_display_meta()
 * @see prodigy_review_display_comment_text()
 */
add_action( 'prodigy_review_before', 'prodigy_review_display_gravatar' );
add_action( 'prodigy_review_before_comment_meta', 'prodigy_product_template_review_rating' );
add_action( 'prodigy_review_meta', 'prodigy_review_display_meta' );
add_action( 'prodigy_review_comment_text', 'prodigy_review_display_comment_text' );

/**
 * Footer
 *
 * @see prodigy_photoswipe()
 */
add_action( 'wp_footer', 'prodigy_photoswipe' );


/**
 * Builders
 *
 * @see prodigy_get_template_shortcode_search()
 * @see prodigy_get_template_shortcode_thank_you()
 * @see prodigy_get_template_shortcode_products()
 * @see prodigy_get_template_shortcode_feature_products()
 * @see prodigy_get_template_shortcode_price_filter()
 * @see prodigy_get_template_shortcode_my_account()
 * @see prodigy_get_template_shortcode_categories_filter()
 * @see prodigy_get_template_shortcode_cart()
 * @see prodigy_get_template_shortcode_breadcrumbs()
 * @see prodigy_get_template_shortcode_attributes_filter()
 * @see prodigy_get_template_shortcode_attributes_filter_layout()
 * @see prodigy_get_template_shortcode_active_filters()
 * @see prodigy_get_template_shortcode_cart_page()
 * @see prodigy_get_template_shortcode_subscription()
 * @see prodigy_shortcode_get_template_feed_categories()
 * @see prodigy_shortcode_get_template_categories()
 */
add_action( 'prodigy_shortcode_template_search', 'prodigy_get_template_shortcode_search' );
add_action( 'prodigy_shortcode_template_thank_you', 'prodigy_get_template_shortcode_thank_you' );
add_action( 'prodigy_shortcode_related_products', 'prodigy_get_template_shortcode_products' );
add_action( 'prodigy_shortcode_template_price_filter', 'prodigy_get_template_shortcode_price_filter' );
add_action( 'prodigy_shortcode_template_my_account', 'prodigy_get_template_shortcode_my_account' );
add_action( 'prodigy_shortcode_template_categories_filter', 'prodigy_get_template_shortcode_categories_filter' );
add_action( 'prodigy_shortcode_template_cart', 'prodigy_get_template_shortcode_cart' );
add_action( 'prodigy_shortcode_template_breadcrumbs', 'prodigy_get_template_shortcode_breadcrumbs' );

/**
 * @deprecated deprecated since version 2.8.2
 * The prodigy_shortcode_template_attributes_filter filter is deprecated. Use prodigy_shortcode_template_attributes_filter_layout instead.
 */
add_action( 'prodigy_shortcode_template_attributes_filter_layout', 'prodigy_get_template_shortcode_attributes_filter_layout' );
add_action( 'prodigy_shortcode_template_active_filters', 'prodigy_get_template_shortcode_active_filters' );
add_action( 'prodigy_shortcode_template_subscription', 'prodigy_get_template_shortcode_subscription' );
add_action( 'prodigy_shortcode_template_feed_categories', 'prodigy_shortcode_get_template_feed_categories' );
add_action( 'prodigy_shortcode_template_banner', 'prodigy_shortcode_get_template_banner' );
add_action( 'prodigy_get_template_products', 'prodigy_get_template_products' );
add_action( 'prodigy_get_template_categories', 'prodigy_get_template_categories' );
add_action( 'prodigy_get_template_category_link', 'prodigy_get_template_category_link' );
add_action( 'prodigy_get_template_category_link', 'prodigy_get_template_category_link' );
add_action( 'prodigy_get_template_cart_page', 'prodigy_get_template_cart_page' );


/**
 * Filters
 *
 * @see wptexturize()
 * @see convert_smilies()
 * @see convert_chars()
 * @see shortcode_unautop()
 * @see prepend_attachment()
 * @see do_shortcode()
 */
add_filter( 'prodigy_short_description', 'wptexturize' );
add_filter( 'prodigy_short_description', 'convert_smilies' );
add_filter( 'prodigy_short_description', 'convert_chars' );
add_filter( 'prodigy_short_description', 'wpautop' );
add_filter( 'prodigy_short_description', 'shortcode_unautop' );
add_filter( 'prodigy_short_description', 'prepend_attachment' );
add_filter( 'prodigy_short_description', 'do_shortcode', 11 );
