(function( $ , window) {

    if (settings.pg_google_track_id) {
        $(document).on("click", ".category-filter-js", function () {
            var value = $(this).text().trim();

            gtag('event', 'set_attribute_filter', {
                "event_category": 'prodigy_product_catalog',
                "event_label": 'set_attribute_filter',
                "value": value
            });
        });

        $(document).on("click", ".attribute-filter-js", function () {
            var value = $(this).text().trim();

            gtag('event', 'set_category_filter', {
                "event_category": 'prodigy_product_catalog',
                "event_label": 'set_category_filter',
                "value": value
            });
        });

        $(document).on("click", ".remove-item-js, .widget-remove-item-js", function () {
            var item = [];
            item.push($(this).data('cart-item'));
            item.push({
                quantity: $('counter-count-js').val(),
            });

            gtag('event', 'remove_from_cart', {
                "event_category": 'prodigy_ecommerce',
                "items": item[0]
            });
        });


        $(document).on("click", "button.checkout-button-js", function () {
            var items = [];
            $('.cart-item-js').each(function (key, item) {
                var item = $(this).data('cart-item');
                item.quantity = $(this).find('.counter-count-js').val();
                items.push(item);
            });

            var cart_items = [];
            gtag('event', 'begin_checkout', {
                "event_category": 'prodigy_ecommerce',
                "items": items
            });
        });
    }

}) (jQuery, window);
