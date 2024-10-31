(function ($, window) {
    var prodigy_cart = {
        main_container: '',
        inventory_quantity: {},
        init: function () {
            this.remove_item();
            this.recalculate_subtotal_amount_cart_widget($(".prodigy-dropdown-cart-widget-js"));
            if ($('.cart_prodigy_widget').length !== 0) {
                this.recalculate_subtotal_amount_cart_widget($(".prodigy-cart-widget-js"));
            }
            this.check_empty_cart();
            this.set_count_to_enter_press();
        },

        set_count_to_enter_press: function () {
            var self = this;
            $(document).on(
                'keypress blur focusout',
                '.counter-count-js',
                function (e) {
                    if (e.type === 'keypress' && e.which === 13) {
                        $(this).blur();
                        self.recalculate_total_price_after_event(self, $(this));
                    } else if (e.type === 'blur' || e.type === 'focusout') {
                        self.recalculate_total_price_after_event(self, $(this));
                    }

                }
            );

        },

        recalculate_total_price_after_event: function (self, container) {
            self.main_container = container;
            let count = self.main_container.val();
            let item_container = self.main_container.closest('tr.item-container-js');
            let line_item_id = item_container.find('.remove-item-js').data('line-item-id');
            let remote_product_id = item_container.find('.remove-item-js').data('remote-id');
            self.update_line_item(line_item_id, remote_product_id, count);
        },

        remove_item: function () {
            var self = this;
            $(document).on(
                'click',
                '.remove-item-js',
                function () {
                    var cartItems = $('.cart-item-js').length;
                    $(this).closest('.item-container-js').remove();
                    self.recalculate_subtotal_amount();
                    self.delete_cart_item($(this).data('line-item-id'));
                    if (cartItems === 0) {
                        $('.continue-cart-js').parent().hide();
                    }
                }
            );
            $(document).on(
                'click',
                '.widget-remove-item-js',
                function () {
                    self.recalculate_subtotal_amount();
                    self.recalculate_subtotal_amount_cart_widget($(".prodigy-dropdown-cart-widget-js"));

                    if ($('.cart_prodigy_widget').length !== 0) {
                        self.recalculate_subtotal_amount_cart_widget($(".prodigy-cart-widget-js"));
                    }

                    if ($('.widget-cart-item-js').length > 0) {
                        window.location.reload();
                    }
                }
            );

        },
        check_empty_cart: function () {
            if (parseInt($('.cart-item-js').length) === 0) {
                $('.cart-items-list-js').hide();
                $('.cart-subtotal-js').hide();
                $('.empty-cart-js').show();
            }
        },
        // reload cart widget content
        reload_widget_content: function () {
            if (window.prodigy_cart_widget !== undefined) {
                window.prodigy_cart_widget.load_cart_data();
            }
        },

        recalculate_subtotal_amount_cart_widget: function (container) {
            var self = this;
            var subtotal_amount = 0;
            container.find(".widget-cart-product-price-js").each(
                function () {
                    let amount = parse_price(
                        $(this)
                            .find(".widget-total-price-js")
                            .text()
                    );
                    let count = parseInt(
                        $(this)
                            .find(".widget-cart-count-item-js")
                            .text()
                    );
                    subtotal_amount += amount * count;
                }
            );

            container.find(".widget-subtotal-price-js").text(
                "$" + prodigy_price_format(subtotal_amount)
            );
            localStorage.setItem("subtotal_amount", "$" + prodigy_price_format(subtotal_amount));
        },

        delete_cart_item: function (line_item_id) {
            var self = this;
            var post_data = {
                action: 'prodigy-remove-item-cart',
                line_item_id: line_item_id,
                nonce: settings.nonce
            };
            $.ajax({
                    type: 'post',
                    data: post_data,
                    url: ajax_url,
                    dataType: 'json',
                    success: function (data) {
                        if (!data.success && data.length !== 0) {
                            if (data.data && data.data.message) {
                                self.show_error(data.data.message);
                            }
                            self.reload_page_content();
                            self.reload_widget_content();
                        } else {
                            self.reload_page_content();
                            self.reload_widget_content();
                            if ($('.cart-item-js').length < 1) {
                                window.location.reload();
                            }
                        }
                    },
                }
            );
        },

        show_error: function (message) {
            var add_to_cart_message = $('.widget-cart-message-error-js');
            add_to_cart_message.find('span').html(message);
            add_to_cart_message.show();
            add_to_cart_message.delay(5000).fadeOut('slow');
        },

        update_line_item: function (line_item_id, remote_id, count, message = 'add') {
            var self = this;
            var post_data = {
                action: 'prodigy-update-item-cart',
                line_item_id: line_item_id,
                remote_id: remote_id,
                count: count,
                nonce: settings.nonce
            };
            $.ajax(
                {
                    type: 'post',
                    data: post_data,
                    url: ajax_url,
                    success: function (data) {
                        if (!data.success) {
                            if (data.data && data.data.message) {
                                self.show_error(data.data.message);

                                setTimeout(() => {
                                    self.reload_page_content();
                                    self.reload_widget_content();
                                }, 5000);
                            }
                        } else {
                            if (message === 'add') {
                                self.show_add_to_cart_message();
                            } else if (message === 'remove') {
                                self.show_remove_from_cart_message();
                            }
                            self.reload_page_content();
                            self.reload_widget_content();
                        }

                    },
                }
            );
        },

        reload_page_content() {
            $(".prodigy-cart-container-js").load(location.href + " .prodigy-cart-container-js");
        },

        show_add_to_cart_message() {
            var add_to_cart_message = $('.widget-cart-add-item-message-js');
            add_to_cart_message.show();
            add_to_cart_message.delay(5000).fadeOut('slow');
        },

        show_remove_from_cart_message() {
            let remove_from_cart_message = $('.widget-cart-remove-item-message-js');
            remove_from_cart_message.show();
            remove_from_cart_message.delay(5000).fadeOut('slow');
        },

        recalculate_total_amount: function (count, container) {
            let item_container = container.closest('tr.item-container-js');
            var field_price = item_container.find('.price-js');
            var total_price_field = item_container.find('.total-price-js');
            var text_price = field_price.text();
            var price = parse_price(text_price);
            var total_price = parseFloat(price) * count;
            total_price_field.text('$' + Number(total_price).toFixed(2));
            localStorage.setItem("subtotal_amount", '$' + Number(total_price).toFixed(2));
        },

        recalculate_subtotal_amount: function () {
            var self = this;
            var subtotal_amount = 0;
            $('.total-price-js').each(
                function () {
                    subtotal_amount += parse_price($(this).text());
                }
            );
            subtotal_amount = Number(subtotal_amount).toFixed(2);
            $('.subtotal-price-js').text('$' + subtotal_amount);
        },

        set_cart_counter_analytics: function (object) {
            if (typeof settings.pg_google_track_id !== "undefined") {
                var item = [];
                item.push(object.data('cart-item'));
                item.push(
                    {
                        quantity: $('counter-count-js').val(),
                    }
                );
            }
        },

        get_data_inventory: function (remote_id) {
            let self = this;

            let post_data = {
                action: "prodigy-remote-get-inventory-product",
                remote_id: remote_id
            };

            $.ajax(
                {
                    type: "post",
                    data: post_data,
                    dataType: "json",
                    url: ajax_url,
                    success: function (data) {
                        if (typeof data.attributes !== 'undefined') {
                            self.inventory_quantity = data.attributes;
                        }
                    }
                }
            );
        },

    };
    window.prodigyCart = prodigy_cart;
})(jQuery, window);
jQuery(
    function ($) {
        window.prodigyCart.init();
    }
);
