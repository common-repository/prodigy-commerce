(function ($, window) {

    let prodigy_remote_cart = {

        init: function () {
               // this.get_remote_cart();
        },

        get_remote_cart: function () {
            let self = this;

            let post_data = {
                action: "prodigy-remote-get-template-cart",
            };

            $.ajax({
                type: "post",
                data: post_data,
                dataType: "json",
                url: ajax_url,
                success: function (response) {
                    if (response.success === false) {
                        self.check_empty_cart_load_remote();
                    } else {
                        $('.prodigy-cart-container-js .row').removeClass('cart-skeleton').html(response.data.cart);
                        if (response.data.is_show_cross_products) {
                            $('.related-products-block-js').show();
                            $('.related-products-container-js').show().html(response.data.cross_products);
                            self.cross_slider_init();
                        }
                    }
                }
            });
        },

        cross_slider_init: function () {
            $('.related-products-js').not('.slick-initialized').slick({
                prevArrow: '<button type="button" class="prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left"></button>',
                nextArrow: '<button type="button" class="prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right"></button>',
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                mobileFirst: true,
                variableWidth: false,
                responsive: [
                    {
                        breakpoint: 767,
                        settings: {
                            variableWidth: false,
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 1168,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            variableWidth: false,
                            arrows: true,
                        }
                    },
                ]
            });
        },

        check_empty_cart_load_remote: function () {
            $('.prodigy-cart-container-js .row').hide();
            $('.empty-cart-js').show();
            if (settings.is_deleted_product) {
                $('.widget-cart-message-error-js').show();
            }
        },
    };

    window.prodigyRemoteCart = prodigy_remote_cart;
})(jQuery, window);

jQuery(function ($) {
    window.prodigyRemoteCart.init();
});
