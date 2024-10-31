(function ($, window) {
    var prodigy_cart_widget = {
        header_cart_block: $('.header-cart-block-js'),
        timeoutId: '',

        init: function () {
            this.load_cart_data();
            this.open_widget();
            this.open_slide_widget();
            this.close_widget();
            this.remove_item();
            this.add_item();
            this.redirect_to_checkout()
        },

        redirect_to_checkout: function () {
            $(document).on('click', '.checkout-url-js, .checkout-button-js', function () {
                let post_data = {
                    action: "prodigy-get-checkout-url",
                    nonce: data.nonce
                };

                $.ajax(
                    {
                        type: "post",
                        data: post_data,
                        dataType: "json",
                        url: ajax_url,
                        success: function (data) {
                            window.location.href = data.data.checkout_url;
                        }
                    }
                );
            });
        },

        open_slide_widget: function () {
            var self = this;
            $('.prodigy-cart-slide__toggle').on(
                'click',
                function () {
                    $('.prodigy-cart-slide-js').addClass('prodigy-cart-slide--open');
                    $('body').addClass('overflow-hidden');
                }
            );
            $('.prodigy-cart-slide__close').on(
                'click',
                function () {
                    $('.prodigy-cart-slide-js').removeClass('prodigy-cart-slide--open');
                    $('body').removeClass('overflow-hidden');
                }
            );
            $('.prodigy-cart-slide__container').on(
                'click',
                function () {
                    $('.prodigy-cart-slide-js').removeClass('prodigy-cart-slide--open');
                    $('body').removeClass('overflow-hidden');
                }
            );
            $('.cart-close-js').click(function () {
                $('.prodigy-cart-widget-js').hide();
                $('.header-cart-block-js').removeClass('prodigy-navbar-cart--open');
                $('body').removeClass('overflow-hidden');
            });
            $('.counter-plus-js').click(function () {
                self.load_cart_data();
            });
            $('.counter-minus-js').click(function () {
                self.load_cart_data();
            });
        },

        close_widget: function () {
            $(document).on('click', '.close-cart-widget-js', function (e) {
                $('.prodigy-dropdown-cart-widget-js').hide();
            });
        },

        open_widget: function () {
            var self = this;
            $(document).off('click', '.header-cart-block-js').on('click', '.header-cart-block-js', function (e) {
                if (self.check_menu()) {
                    e.preventDefault();
                    $(this).addClass('prodigy-navbar-cart--open');
                    $(this).parent().find('.prodigy-dropdown-cart-widget-js').toggle();
                    $('.prodigy-cart-widget-js').toggle();
                    self.show_widget_block(0, false);
                    self.load_cart_data();
                }
            });
        },

        remove_item: function () {
            let self = this;

            $(document).on('click', ".widget-remove-item-js", function () {
                let remote_product_id = $(this).data('remote-id');
                let line_item_id = $(this).data('line-item-id');

                self.remove_from_cart(line_item_id, remote_product_id, function () {
                    self.load_cart_data(function () {
                        self.change_widget_blocks(line_item_id);
                    });
                });

                self.check_hide_counter();
                if ($('.widget-cart-item-js').length === 0) {
                    $('.continue-cart-js').hide();
                }
            });
        },

        recalculate_subtotal_amount: function (container) {
            var subtotal_amount = 0;

            container.find('.widget-cart-product-price-js').each(function () {
                let amount = parse_price($(this).find('.widget-total-price-js').text());
                let count = parseInt($(this).find('.widget-cart-count-item-js').text());
                subtotal_amount += amount * count;
            });

            container.find($('.widget-subtotal-price-js')).text('$' + prodigy_price_format(subtotal_amount));
            localStorage.setItem("subtotal_amount", "$" + prodigy_price_format(subtotal_amount));
        },

        change_widget_blocks: function (data_id) {
            let delete_button = $('.widget-remove-item-js[data-line-item-id=' + data_id + ']');
            delete_button.parent().parent().remove();
            if (parseInt($('.widget-cart-item-js').length) === 0) {
                $('.widget-cart-checkout-block-js').hide();
                $('.widget-cart-subtotal-js').hide();
                $('.widget-cart-empty-cart-message-js').show();
            }
        },

        remove_from_cart: function (line_item_id, remote_id, callback) {
            let self = this;
            let post_data = {
                action: 'prodigy-remove-item-cart',
                line_item_id: line_item_id,
                remote_id: remote_id,
                nonce: settings.nonce
            };

            $.ajax(
                {
                    type: 'post',
                    data: post_data,
                    url: ajax_url,
                    dataType: 'json',
                    success: function (data) {
                        if (data.length > 0 && data !== null) {
                            self.show_error(data.error);
                        }

                        window.prodigyRemoteCart.get_remote_cart();
                        if (callback !== undefined) {
                            callback();
                        }
                    },
                }
            );
        },

        cart_modal_trigger: function (is_error) {
            let self = this;
            if (!is_error) {
                if (self.check_menu()) {
                    $('.prodigy-dropdown-cart-widget-js').show();
                    self.show_widget_block(5000, true);
                }
                self.load_cart_data();
            }
        },

        show_widget_block: function (time, show_alert) {
            if (time) {
                $('.prodigy-dropdown-cart-widget-js').delay(time).fadeOut('slow');
            }
            if (show_alert) {
                $('.add-to-cart-alert-js').show();
            } else {
                $('.add-to-cart-alert-js').hide();
            }
        },

        load_cart_data: function (callback) {
            let self = this;
            clearTimeout(self.timeoutId);
            $('.prodigy-cart-loading__element-js').show();
            $('.prodigy-cart-total').addClass('prodigy-cart-loading__element');
            $('.widget-cart-item-js').hide();
            self.timeoutId = setTimeout(function () {
                $.ajax({
                    type: "post",
                    data: {action: "prodigy-load-cart-data"},
                    dataType: "json",
                    url: ajax_url,
                    cache: false,
                    success: function (data) {
                        $('.prodigy-cart-loading__element-js').hide();
                        $('.prodigy-cart-total').removeClass('prodigy-cart-loading__element');
                        $('.cart-count-js').html(data.cart_items_count);
                        $('.cart-dropdown-widget-item-list-js').html(data.cart_items);
                        $('.widget-subtotal-price-js').html("$" + prodigy_price_format(data.total_price));
                        localStorage.setItem('cart_count_items', data.cart_items_count);
                        localStorage.setItem("subtotal_amount", "$" + prodigy_price_format(data.total_price));
                        self.check_hide_counter();
                        if ($('.widget-cart-item-js').length === 0) {
                            $('.continue-cart-js').hide();
                        }

                        if (data.cart_items_count) {
                            $('.widget-cart-subtotal-js').show();
                            $('.widget-cart-checkout-block-js').show();
                            $('.widget-cart-empty-cart-message-js').hide();
                        } else {
                            $('.widget-cart-subtotal-js').hide();
                            $('.widget-cart-checkout-block-js').hide();
                            $('.widget-cart-empty-cart-message-js').show();
                        }

                        if (callback !== undefined) {
                            callback();
                        }
                    }
                });
            }, 1000);
        },

        add_item: function () {
            let self = this;
            $(document).on('click', '.add-to-cart-js', function () {
                $('.widget-cart-subtotal-js').show();
                $('.widget-cart-checkout-block-js').show();
                $('.widget-cart-empty-cart-message-js').hide();
                self.recalculate_subtotal_amount($('.prodigy-cart-widget-js'));
                self.recalculate_subtotal_amount($('.prodigy-dropdown-cart-widget-js'));
                self.check_hide_counter();
            });
        },

        show_add_to_cart_message() {
            var add_to_cart_message = $('.widget-cart-add-item-message-js');
            add_to_cart_message.show();
            add_to_cart_message.delay(5000).fadeOut('slow');
        },

        check_hide_counter: function () {
            $('.cart-count-js').each(function () {
                if (parseInt($(this).text()) === 0) {
                    const hide_empty = $(this).data('hide-empty')
                    if (hide_empty !== 'no') {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                } else {
                    $(this).show();
                }
            });
        },

        check_menu: function () {
            const self = this;
            if (typeof (document.querySelector('.prodigy-navbar-cart')) !== "undefined" &&
                document.querySelector('.prodigy-navbar-cart') !== null
            ) {
                const theme_name = window.getComputedStyle(document
                    .querySelector('.prodigy-navbar-cart'), ':before')
                    .getPropertyValue('content').replace(/^"|"$/g, '');
                const width = window.innerWidth;
                const handlers = {
                    'astra': () => {
                        return self.header_cart_block.parents('.ast-header-break-point').length === 0;
                    },
                    'twenty-twenty-one': () => width > 481,
                    'twenty-twenty': () => width > 999,
                    'twenty-nineteen': () => {
                        return self.header_cart_block.parents('.hidden-links').length === 0;
                    },
                    'oceanwp': () => width > 959,
                    'hello-elementor': () => width > 767,
                    'flatsome': () => width > 849,
                    'divi': () => {
                        return self.header_cart_block.parents('.et_mobile_menu').length === 0;
                    },
                    DEFAULT: () => true
                }
                const handler = handlers[theme_name] || handlers.DEFAULT;

                return handler();
            }

            return true;
        }

    };
    window.prodigy_cart_widget = prodigy_cart_widget;
})(jQuery, window);
jQuery(function ($) {
    window.prodigy_cart_widget.init();
});
