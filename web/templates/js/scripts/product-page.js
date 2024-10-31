(function($, window) {

    var prodigy_product = {
        _weight_type_mapper: ["lbs", "g", "kg", "oz"],
        _dimension_type_mapper: ["in", "cm"],
        _stock_status_mapper: ["In stock", "Out of stock"],
        _add_to_cart_key: "add_item_to_cart",
        product: {},
        is_show_subscription_popup: false,
        subscription_price: 0,
        is_subscription_replaced: false,
        is_one_time_order: true,
        subscription_id: '',
        remote_product: {},
        variant: {},
        maxItems: 99,
        is_admin: $(document).find('#user-role-js').data('attr'),
        checkout_url: "",

        init: function() {
            let is_product_page = $("body").hasClass("single-prodigy-product");
            let is_shop_page = $("body").hasClass("tax-prodigy-product-shop");

            if (!is_shop_page && is_product_page) {
                this.set_global_remote_product();
                this.set_product_tabs();
                this.scroll_for_hash(window.location.hash);
                this.set_product_counter();
                this.set_product_gallery();
                this.change_variant_selection();
                this.show_tab_review();
                this.show_tab_description();
                this.send_captcha();
                this.send_review_for_user();
                this.disable_submit_comment();
                this.reset_focus_to_press_enter();
                this.set_default_link_review();
                this.change_product_quantity_analytic_event();
                this.update_variants();
                this.update_images_gallery();
                this.set_elementor_options();
                this.set_subscription_id();
                this.set_tabs_for_resolution();
            }
        },

        set_tabs_for_resolution: function() {
            let windowWidth = window.innerWidth;
            if (windowWidth < 768) {
                $('.desktop-resolution-js').remove();
            } else {
                $('.mobile-resolution-js').remove();
            }
        },

        validate_options: function () {
            let text = $(".prodigy-product__attr-text");
            let msg = "Please select Department";
            let result = true;
            $('.attribute_values_js').each(function (e) {
                if ($(this).val() === "") {
                    $(this).prev().css('color', 'red');
                    $(this).css('border-color', 'red');
                    result = false;
                } else {
                    $(this).prev().removeAttr('style');
                    $(this).removeAttr('style');
                    result = result && true;
                }
            });

            return result;
        },

        set_subscription_id: function () {
            var self = this;
            self.subscription_id = $('.subscription_id').val();
        },

        set_elementor_options: function () {
            var is_show_regular_price = $('#regular_price_state_option').val();

            if (is_show_regular_price !== 'yes') {
                $('.regular-price-container').remove();
            } else {
                $('.regular-price-container').show();
            }
            this.set_subscriptions();
        },

        format_subscription_price: function (price) {
            var self = this;
            var is_subscriptions = $(document).find('.prodigy-subscriptions-tab').length > 0;

            if (is_subscriptions) {
                if (typeof parse_price(price) === 'undefined') {
                     price = $('.sale-subscription-price-js').text();
                }

                var sale_price = $('.subscription-sale_price-js').val();
                if (parse_price(sale_price) !== parse_price(price) && typeof parse_price(sale_price) !== 'undefined' && sale_price !== 0 ) {
                    $('.subscriptions-price-currency-js').show();
                    $('.subscriptions-regular-price-js').text(prodigy_price_format(parse_price(price)));
                    $('.product-default-info-price-js').text('$' + prodigy_price_format(parse_price(sale_price)));
                    $('.prodigy-subscriptions-tab-js').trigger('click');
                }
            }
        },

        is_need_replace_subscription_item: function (subscription_id) {
            var self = this;
            var remote_product_id;
            var attribute_values_js = $(".attribute_values_js");

            // if isset variants
            if (attribute_values_js.length > 0) {
                remote_product_id = $('.add-to-cart-js').attr("data-remote-id");
            } else {
                if (typeof self.remote_product !== 'undefined') {
                    remote_product_id = self.remote_product.remote_master_id_variant;
                }
            }

            if (typeof remote_product_id !== "undefined") {
                var post_data = {
                    action: "prodigy-is-replace-subscription-item",
                    remote_product_id: remote_product_id,
                    one_time_order: self.is_one_time_order,
                };

                if (!self.is_one_time_order && subscription_id && typeof subscription_id !== 'undefined') {
                    self.subscription_id = subscription_id;
                    post_data.subscription_id = subscription_id;
                }

                $.ajax({
                    type: "post",
                    data: post_data,
                    dataType: "json",
                    url: ajax_url,
                    success: function (data) {
                        if (data !== null) {
                            self.is_show_subscription_popup = data.show_subscription_popup;
                        }
                    }
                });
            }
        },

        add_item_to_cart: function() {
            var self = this;

            $(document)
                .off("click", "button.add-to-cart-js, button.replace-subscription-condition-js")
                .on("click", "button.add-to-cart-js, button.replace-subscription-condition-js", function(e) {
                    if ( !self.validate_options() ) {
                        return;
                    }

                    var remote_product_id;
                    var attribute_values_js = $(".attribute_values_js");
                    var current_button = $(this).attr('data-name');

                    if (current_button === 'replace-subscription-condition-js') {
                        $('#add_item_Modal').modal('hide');
                        self.is_show_subscription_popup = false;
                        self.is_subscription_replaced = true;
                    } else {
                        self.is_subscription_replaced = false;
                    }

                    if (self.is_show_subscription_popup) {
                        $('#add_item_Modal').modal('show');
                        self.is_show_subscription_popup = false;
                    } else {
                        // if isset variants
                        if (attribute_values_js.length > 0) {
                            remote_product_id = $(this).attr("data-remote-id");
                        } else {
                            if (typeof self.remote_product !== 'undefined') {
                                remote_product_id = self.remote_product.remote_master_id_variant;
                            }
                        }

                        if ( typeof remote_product_id === 'undefined') {
                            remote_product_id = $('.add-to-cart-js').attr("data-remote-id");
                        }

                        self.set_analytic_add_item_to_cart();
                        var form_count_products = $(".counter-count-js").val();

                        if (form_count_products > self.maxItems) {
                            form_count_products = self.maxItems;
                            $(".counter-count-js").val(self.maxItems);
                        }

                        var attributes = {attribute: {}, item: {}};

                        attribute_values_js.each(function (key) {
                            var $option = $(this).find("option:selected");
                            attributes["attribute"][key] = $option.val();
                            attributes["item"][key] = $option.text();
                        });

                        // set items in remote cart
                        self.add_to_cart(
                            form_count_products,
                            remote_product_id,
                            attributes,
                            self.get_current_product_price(),
                            self.subscription_id,
                            self.is_subscription_replaced
                        );
                    }

                });
        },


        show_add_to_cart_message() {
            var add_to_cart_message = $( '.widget-cart-add-item-message-js' );
            add_to_cart_message.show();
            add_to_cart_message.delay( 5000 ).fadeOut( 'slow' );
        },


        set_subscriptions: function () {
            var self = this;
            var sale_price = 0;

            $(document).on('change', '.subscription-radio-js', function () {
                if ($(this).is(':checked')) {
                    sale_price = $(this).prev().prev().prev().prev().val();
                    var sale_price_rounded = parseFloat(sale_price) < 0 ? 0 : parseFloat(sale_price);
                    self.subscription_price = sale_price;
                    $('.sale-subscription-price-js').text(prodigy_price_format(sale_price_rounded));
                    self.subscription_id = $(this).prev().prev().prev().val();
                    self.is_need_replace_subscription_item(self.subscription_id);
                    self.set_subscription_additional_price(sale_price, $(this));

                    let price = $('.regular-price').text();
                    if (price === '') {
                        price = prodigy_price_format(parse_price($('.sale-price').text()));
                    }
                    let price_container = $(this).closest('.prodigy-subscriptions-tab').find('.prodigy-subscriptions-tab__item-sale');
                    if (parse_price(self.subscription_price) !== parse_price(price)) {
                        price_container.show();
                        $('.subscriptions-regular-price-js').text(prodigy_price_format(parse_price(price))).show();
                    } else {
                        price_container.hide();
                    }
                }
            });

            $(document).on('click', 'button.prodigy-close-button, button.close-subscription-popup-js', function () {
                $('#add_item_Modal').modal('hide');
                self.is_show_subscription_popup = true;
            });


            $(document).on('click', '.prodigy-subscriptions-tab-js', function () {
                self.set_subscription_options($(this));
                self.activate_subscription_block($(this));
                let is_conditions = $(this).next().find('.prodigy-subscription-period-js');

                if (is_conditions.length > 0) {
                    $('.subscription-radio-js').each(function () {
                        if ($(this).is(':checked')) {
                            $('.subscription-radio-js').removeAttr('disabled');
                            sale_price = parseFloat($('.sale-subscription-price-js').text().trim());
                            self.subscription_price = parseFloat(sale_price) < 0 ? 0 : parseFloat(sale_price);
                            self.subscription_id = $(this).prev().prev().prev().val();
                            self.is_need_replace_subscription_item(self.subscription_id);
                            self.set_subscription_additional_price(sale_price, $(this));
                        }
                    });
                } else {
                    self.is_need_replace_subscription_item();
                    let price = $(this).next().find('.prodigy-subscriptions-tab__item-price').text();
                    $('.product-default-info-price-js').text(price);
                }
            });
        },

        set_subscription_additional_price: function (price,container) {
            let format_price_string = '$' + prodigy_price_format(price);
            let condition_string = container.parent().find('.subscription-condition-js').val();
            $('.product-default-info-price-js').text(format_price_string + ' (' + condition_string + ')');
        },

        activate_subscription_block: function (container) {
            $('.prodigy-subscriptions-radio-js').prop('checked', false);
            $('.prodigy-subscriptions-tab-js').removeClass('active');
            $(container).find('.prodigy-subscriptions-radio-js').prop('checked', true);
            container.addClass('active');
            $('.subscription-radio-js').prop('disabled', function(i, v) { return !v; });
        },

        set_subscription_options: function (container) {
            let self = this;
            self.set_subscription_price(container);
            if (container.hasClass("active")) {
                if (container.attr('aria-controls') === 'nav-home') {
                    self.subscription_price = container.find('.sale-price').text().trim();
                    self.is_one_time_order = true;
                } else {
                    self.subscription_price = $('.sale-subscription-price-js').text().trim();
                    self.is_one_time_order = false;
                }
            }
        },

        set_subscription_price: function (container) {
            let subscription_price = $('.prodigy-subscriptions-wrap-price-js').text();
            $('.prodigy-additional-info-price-js').text(subscription_price).show();
        },

        load_subscription_price: function () {
            let self = this;
            $('.prodigy-subscriptions-tab-js').each(function () {
                self.set_subscription_options($(this));
            });
        },

        get_current_product_price: function () {
            var self = this;
            var price = 0;
            var price_str = $(document).find(".sale-price").text().trim();
            var is_subscriptions = $(document).find('.prodigy-subscriptions-tab').length > 0;

            if (is_subscriptions && !self.is_one_time_order) {
                price = parseFloat(self.subscription_price);
            }

            if (self.is_one_time_order && price_str !=='' ) {
                price = prodigy_price_format(price_str).replace(/\,/g,'');
            }

            return price;
        },


        add_to_cart: function(
            form_count_products,
            remote_product_id,
            attributes_item,
            price,
            subscription_id,
            is_subscription_replaced = false
        ) {
            var self = this;

            var post_data = {
                action: "prodigy-add-remote-cart",
                remote_product_id: remote_product_id,
                count: form_count_products,
                price: price,
                attributes: attributes_item,
                is_subscription_replaced: is_subscription_replaced,
                nonce: settings.nonce
            };
            if (!self.is_one_time_order) {
                post_data.subscription_id = subscription_id;
            }


            $.ajax({
                type: "post",
                data: post_data,
                dataType: "json",
                url: ajax_url,
                success: function(data) {
                    if (data !== null && typeof data.error !== 'undefined') {
                        if (window.prodigy_cart_widget !== undefined) {
                            window.prodigy_cart_widget.cart_modal_trigger(true);
                        }
                        self.show_error(data.error);
                    } else if (data !== null) {
                        if (window.prodigy_cart_widget !== undefined) {
                            window.prodigy_cart_widget.cart_modal_trigger(false);
                        }

                        self.cart_slide_open();
                        $('.counter-count-js').val(1);
                        self.show_add_to_cart_message();
                        self.show_cart_message();

                        // redirect to cart page
                        if ($(".cart-redirect-js").data("cart-redirect") === "redirect_to_cart") {
                            var dinamic_cart_url = $('.pg-cart-url-js').data('attr');
                            window.location.replace(dinamic_cart_url);
                        }
                    }
                }
            });
        },

        cart_slide_open: function () {
            let cart_slider = $('.prodigy-cart-slide-js');
            if (cart_slider.data( 'auto-open' ) === 'yes') {
                cart_slider.toggleClass('prodigy-cart-slide--open');
                setTimeout(function () {
                    cart_slider.removeClass('prodigy-cart-slide--open');
                }, 5000);
            }
        },

        set_checkout_url: function() {
            var post_data = {
                action: "prodigy-get-checkout-url"
            };
            var result;
            $.ajax({
                type: "post",
                data: post_data,
                async: false,
                dataType: "json",
                url: ajax_url,
                success: function(data) {
                    if (data.url !== "") {
                        result = data.url;
                    }
                },
                error: function() {
                    result = "";
                }
            });

            return result;
        },

        change_variant_selection: function () {
            let attribute_values_js = $('.attribute_values_js');
            let self = this;

            attribute_values_js.change(function() {
                let selector = $(this);
                let variantSelected = true;
                let variants = [];
                let $option = false;


                attribute_values_js.each(function() {
                    $option = $(this).find("option:selected");
                    let value = $option.val();
                    let text = $option.text();
                    if (!value) {
                        variantSelected = false;
                    } else {
                        variants.push(text);
                    }
                });

                if (variantSelected && self.validate_options()) {
                    $('.add-to-cart-js').prop("disabled", true);

                    let post_data = {
                        action: "prodigy-public-get-remote-variants-data",
                        post_id: $("#product_id").val(),
                        variants: variants,
                        nonce: settings.nonce
                    };

                    $.ajax({
                        type: "post",
                        data: post_data,
                        dataType: "json",
                        url: ajax_url,
                        error: function (xhr, status, error) {
                        },
                        success: function(response) {
                            $('.add-to-cart-js').prop("disabled", false);
                            var data = response.data.result;
                            if (typeof data !== undefined && data.subscriptions) {
                                $('#subscriptions_block').html(data.subscriptions);
                            }

                            self.variant = data;
                            self.set_variants_data(selector, data);

                            var is_subscriptions = $(document).find('.prodigy-subscriptions-tab').length > 0;

                            if (!is_subscriptions) {
                                self.is_one_time_order = true;
                            }

                            let dimension_attrs = data.dimension.attributes;
                            self.set_shipping_data_variants(
                                data.attributes.sku,
                                dimension_attrs['weight-value'] + dimension_attrs['weight-unit'],
                                dimension_attrs['depth-value']
                                +' x '+ dimension_attrs['width-value']
                                +' x '+ dimension_attrs['height-value']
                                + dimension_attrs['size-unit']
                            );
                        }
                    });
                } else {
                    self.is_one_time_order = true;
                    self.show_main_product_info();
                    self.pg_variations_image_reset(selector);

                    if ( typeof self.remote_product.remote_master_variant_info !== "undefined") {
                        let dimension_attrs = self.remote_product.remote_master_variant_info.dimension.attributes;
                        self.set_shipping_data_variants(
                            self.remote_product.remote_main_sku,
                            dimension_attrs['weight-value'] + dimension_attrs['weight-unit'],
                            dimension_attrs['depth-value']
                            + ' x ' + dimension_attrs['width-value']
                            + ' x ' + dimension_attrs['height-value']
                            + dimension_attrs['size-unit']
                        );
                    }
                }
            });
        },

        update_images_gallery: function () {
            var self = this;
            $(document).on('change', '.attribute_values_js', function () {
                var post_data = {
                    action: "prodigy-get-image-option",
                    post_id: $("#product_id").val(),
                    option: $(this).val(),
                    attribute: $(this).data('attribute'),
                    nonce: settings.nonce
                };

                $.ajax({
                    type: "post",
                    data: post_data,
                    dataType: "json",
                    url: ajax_url,
                    error: function (xhr, status, error) {
                    },
                    success: function(response) {
                        if (typeof response.data !== undefined && response.data) {
                            $('.images-gallery-js').html($(response.data.product_gallery).html());
                            self.set_product_gallery();
                        }
                    }
                });

            });
        },

        slide_to_current_image_option() {
            var galleryHasImage =
                $gallery_nav.find('li img[data-o_src="' + data.img_url + '"]')
                    .length > 0;

            // If the gallery has the image, reset the images. We'll scroll to the correct one.
            if (galleryHasImage) {
                self.pg_variations_image_reset();
            }

            // See if gallery has a matching image we can slide to.
            var slideToImage = $gallery_nav.find(
                'li img[src="' + data.img_url + '"]'
            );

            self.pg_set_variation_attr($product_img, "src", data.img_url);

            self.pg_set_variation_attr(
                $product_img_wrap,
                "data-thumb",
                data.img_url
            );
            self.pg_set_variation_attr($gallery_img, "src", data.img_url);
            self.pg_set_variation_attr($product_link, "href", data.img_url);
        },

        update_variants: function () {
            var self = this;
            var variantsObj = $('.elementor-widget-container div.variants-container-js');
            var variants = variantsObj.data('variants');

            if (variants !== 'undefined') {
                $('select[data-attribute]').each(function () {
                    self.update_select($(this), variants, {});
                });
            }

            $(document).on('focus', 'select[data-attribute]', function () {
                var $selects = $('select[data-attribute]');
                $selects.each(function() {
                    var selected_attributes = [],
                        filtered_attributes = [];
                    var current_attr = $(this).data('attribute');
                    $selects.each(function () {
                        if ($(this).val() !== '') {
                            if (current_attr !== $(this).data('attribute')) {
                                filtered_attributes[$(this).data('attribute')] = $(this).val();
                            }
                            selected_attributes[$(this).data('attribute')] = $(this).val();
                        }
                    });

                    var available_variants = self.filter_variants(filtered_attributes);
                    self.update_select($(this), available_variants, selected_attributes);
                });
            });
        },


        update_select: function($select, variants, selected_attributes) {
            var attributes = $('.variants-container-js').data('attributes');
            var available_attributes = {};

            for (i in variants) {
                var variant = variants[i];
                for (j in attributes) {
                    var attr = attributes[j];
                    if (variant[attr] !== undefined) {
                        if (available_attributes[attr] === undefined) {
                            available_attributes[attr] = [];
                        }
                        if (available_attributes[attr].indexOf(variant[attr]) === -1) {
                            available_attributes[attr].push(variant[attr]);
                        }
                    }
                }
            }

            if ($select.length > 0) {
                var attr_name = $select.data('attribute');
                var default_select_option = $('#default_select_option').val();
                $select.html('<option class="attributes_default_value-js" value="">'+default_select_option+'</option>');
                for (i in available_attributes[attr_name]) {
                    var is_selected = selected_attributes[attr_name] === available_attributes[attr_name][i];
                    $select.append('<option class="attached enabled" value="' + available_attributes[attr_name][i] + '"' + (is_selected ? ' selected' : '') + '>' + available_attributes[attr_name][i] + '</option>');
                }
            }
        },


        filter_variants: function (selected_attributes) {
            var variants = $('.variants-container-js').data('variants'),
                availableVariants = [];
            for (i in variants) {
                var is_available = true;
                for (var attr_name in selected_attributes) {
                    if (variants[i][attr_name] !== selected_attributes[attr_name]) {
                        is_available = false;
                        break;
                    }
                }
                if (is_available) {
                    availableVariants.push(variants[i]);
                }
            }

            return availableVariants;
        },

        scroll_for_hash: function (hash) {
            if (hash) {
                var hash = hash;

                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1500, 'swing');
            }
        },

        /**
         *
         * @version 2.0.0
         */
        set_analytic_add_item_to_cart: function() {
            if (settings.pg_google_track_id) {
                let current_url = window.location.pathname.replace(/\/+$/, "");
                if (current_url.includes(settings.product_type)) {
                    let self = this;
                    let product = self.variant;
                    let price = product.attributes.price;
                    let sku = product.attributes.sku;
                    /**
                     * TODO check title in api
                     */
                    let title = product.attributes.sku;
                    let sale_price = product.attributes['sale-price'];
                    let remote_variant_id = product.remote_variant_id;

                    gtag('event', 'add_to_cart', {
                        "event_category": 'prodigy_ecommerce',
                        "items": [
                            {
                                "id": remote_variant_id,
                                "name": title,
                                // "category": product.categories,
                                "variant": sku,
                                "price": self.get_actual_price(price, sale_price),
                                "quantity": parseInt($('.counter-count-js').val()),
                            }
                        ]
                    });
                }
            }
        },

        /**
         * @version 2.0.0
         */
        change_product_quantity_analytic_event: function() {

            if (settings.pg_google_track_id) {
                let current_url = window.location.pathname.replace(/\/+$/, "");

                if (current_url.includes(settings.product_type)) {
                    let self = this;

                    let old_quantity = parseInt($('.counter-count-js').val());

                    $('.counter-btn-plus-js, .counter-btn-minus-js').on('click', function () {

                        let product = self.variant;

                        let price = product.attributes.price;
                        let sku = product.attributes.sku;
                        /**
                         * TODO check title in api
                         */
                        let title = product.attributes.sku;
                        let sale_price = product.attributes['sale-price'];
                        let remote_variant_id = product.remote_variant_id;

                        gtag('event', 'change_product_quantity', {
                            "event_category": 'prodigy_product',
                            "items": [
                                {
                                    "id": remote_variant_id,
                                    "name": title,
                                    // "category": product.categories, // check
                                    "sku": sku,
                                    "price": self.get_actual_price(price, sale_price),
                                    "new_quantity": parseInt($('.counter-count-js').val()),
                                    "old_quantity": old_quantity,
                                }
                            ]
                        });

                    });
                }
            }
        },

        /**
         * @version 2.0.0
         * @param data
         */
        set_view_product_analytic_event: function(data) {
            let current_url = window.location.pathname.replace(/\/+$/, "");

            let price = data.attributes.price;
            let sku = data.attributes.sku;
            /**
             * TODO check title in api
             */
            let title = data.attributes.sku;
            let sale_price = data.attributes['sale-price'];
            let remote_variant_id = data.remote_variant_id;

            if (typeof  current_url.includes(settings.product_type)) {
                let self = this;

                gtag('event', 'view_variant', {
                    "event_category": 'prodigy_product',
                    "items": [
                        {
                            "id": remote_variant_id,
                            "name": title,
                            // "category": data.categories,
                            "variant": sku,
                            "price": self.get_actual_price(price, sale_price)
                        }
                    ]
                });
            }
        },

        captcha_callback: function(val) {
            $(".recaptcha-checkbox").attr("aria-checked", true);
            this.check_enable_comment_fields();
        },

        reset_focus_to_press_enter: function() {
            $(document).on("keypress", ".counter-count-js", function(e) {
                if (e.which === 13) {
                    if ($(this).is(":focus")) {
                        if (parseInt($(this).val()) > 1) {
                            $(".counter-btn-minus-js").prop("disabled", false);
                            $(".counter-btn-minus-js").removeAttr("style");
                        }
                        $(this).blur();
                    }
                }
            });
        },

        send_captcha: function() {
            $(".submit-product-button").click(function(e) {
                var response;
                $.ajax({
                    type: "post",
                    data: $("#commentform").serialize() + "&action=google-captcha-url",
                    dataType: "json",
                    url: ajax_url,
                    async: false,
                    success: function(data) {
                        if (data.nocaptcha === "true") {
                            response = 1;
                        } else if (data.spam === "true") {
                            response = 1;
                        } else {
                            response = 0;
                        }
                    }
                });
            });
        },

        send_review_for_user: function() {
            var is_admin = this.is_admin;
            $(document).on('submit', 'form#commentform', function (e) {
                e.preventDefault();
                $('#submit').addClass('prodigy-main-button--loading');
                var form = $('form#commentform');

                $.ajax({
                    type: 'POST',
                    url : form.attr('action'),
                    data: form.serialize(),
                    error: function(error) {
                        $('#reviewModal').modal('toggle');
                        $('#reviewModalSuccess').modal('toggle');
                        $('.prodigy-reviews-ratings__btn').hide();
                        $('.review-message-popup-js').text('Couldn\'t submit a review. Please try again later.');
                    },
                    success: function(respond_data) {
                        $('#reviewModal').modal('toggle');
                        $('.prodigy-reviews-ratings__btn').hide();
                        if (!is_admin) {
                            $('#submit').removeClass('prodigy-main-button--loading');
                            if (typeof respond_data !== "undefined") {
                                $('#reviewModalSuccess').modal('toggle');
                                $('.review-message-popup-js').text('We will post your review soon after moderation approve');
                            }
                        }
                    }
                });
            });
        },

        show_cart_message() {
            var add_to_cart_message = $('.widget-cart-add-item-message-js');
            add_to_cart_message.show();
            add_to_cart_message.delay(5000).fadeOut('slow');
        },

        show_view_cart_btn() {
            var view_cart = $(".view-cart-js");
            view_cart.show();
            $(".prodigy-product__values").removeClass("flex-nowrap");
        },

        show_add_to_cart_message() {
            var self = this;
            var add_to_cart_button = $(".add-to-cart-js");
            add_to_cart_button.text("ADDED TO CART");
            add_to_cart_button.prop("disabled", true);
            add_to_cart_button.css("background", "grey");
            self.show_cart_message();
            self.show_view_cart_btn();

            setTimeout(function() {
                add_to_cart_button.prop("disabled", false);
                add_to_cart_button.text("ADD TO CART");
                add_to_cart_button.removeAttr("style");
            }, 5000);
        },

        show_error: function(message, type = "success") {
            var add_to_cart_message = $(".widget-cart-message-error-js");
            add_to_cart_message.find("span").html(message);
            add_to_cart_message.show();
            add_to_cart_message.delay(5000).fadeOut("slow");
            if (type === "error") {
                add_to_cart_message.addClass("prodigy-cart-dropdown__error-alert");
            }
        },


        disable_submit_comment: function() {
            var self = this;

            self.check_enable_comment_fields();

            $("#comment").on("input", function(e) {
                self.check_enable_comment_fields();
            });

            $(".comment-author-js").on("input", function(e) {
                self.check_enable_comment_fields();
            });

            $(".comment-email-js").on("input", function(e) {
                self.check_enable_comment_fields();
            });

            $("body").on("change", "#prodigy-rating", function(e) {
                self.check_enable_comment_fields();
            });
        },

        check_enable_comment_fields: function() {
            var comment_submit = $(".prodigy-main-button.submit-product-button");

            var rating_form = $(".comment-form-rating").length;

            if (!this.is_admin) {
                var rating_val = $("#prodigy-rating").val();
            }

            var comment_val = $("#comment").val();
            var name_val = $(".comment-author-js").val();
            var email_val = $(".comment-email-js").val();
            var captcha_val = $("#g-recaptcha-response").val();
            var captcha = $("#g-recaptcha-response");
            var is_rating_enable = $(".prodigy-comment__rating").length > 0;
            var is_email_enable = $(".comment-email-js").length > 0;
            var enable_submit = true;

            if (document.body.classList.contains("logged-in")) {
                if (this.is_admin) {
                    var enable_submit = comment_val;
                } else if (typeof rating_val !== 'undefined')  {
                    var enable_submit = rating_val && comment_val;
                } else {
                    var enable_submit = comment_val;
                }
                if (captcha.length > 0 && !this.is_admin) {
                    var enable_submit = rating_val && comment_val && captcha_val;
                } else if (captcha.length > 0 && this.is_admin) {
                    var enable_submit = comment_val && captcha_val;
                }
            } else {
                if (typeof rating_val !== "undefined") {
                    var enable_submit = rating_val && comment_val && name_val && email_val;
                    if (captcha.length > 0 && !this.is_admin) {
                        var enable_submit = rating_val && comment_val && name_val && captcha_val && email_val;
                    } else if (captcha.length > 0 && this.is_admin) {
                        var enable_submit = comment_val && name_val && captcha_val && email_val;
                    } else if (captcha.length > 0 && this.is_admin && is_rating_enable) {
                        var enable_submit = comment_val && name_val && rating_val && email_val;
                    } else if (captcha.length == 0 && this.is_admin && !is_rating_enable) {
                        var enable_submit = comment_val && name_val && email_val;
                    }  else if (captcha.length == 0 && !this.is_admin && !is_rating_enable && !is_email_enable) {
                        var enable_submit = comment_val && name_val;
                    } else if (captcha.length == 0 && !this.is_admin && is_rating_enable && !is_email_enable) {
                        var enable_submit = comment_val && name_val;
                    }
                } else {
                    var enable_submit = comment_val && name_val && email_val;

                    if (captcha.length > 0 && !this.is_admin) {
                        var enable_submit = comment_val && name_val && captcha_val && email_val;
                    } else if (captcha.length > 0 && this.is_admin) {
                        var enable_submit = comment_val && name_val && captcha_val && email_val;
                    } else if (captcha.length > 0 && this.is_admin && is_rating_enable) {
                        var enable_submit = comment_val && name_val && email_val;
                    } else if (captcha.length == 0 && this.is_admin && !is_rating_enable) {
                        var enable_submit = comment_val && name_val && email_val;
                    } else if (captcha.length == 0 && !this.is_admin && !is_rating_enable && !is_email_enable) {
                        var enable_submit = comment_val && name_val;
                    }
                }
            }

            if (enable_submit) {
                comment_submit.prop("disabled", false);
                comment_submit.removeAttr("style");
            } else {
                comment_submit.prop("disabled", true);
                comment_submit.css("background", "grey");
                comment_submit.css("cursor", "not-allowed");
            }
        },

        set_product_gallery: function() {
            let thumbsDirection = 'horizontal';
            let thumbsSlidesPerView = $("#gallery-thumbs").data('slides') || 3;
            let thumbsSpaceBetween = $("#gallery-thumbs").data('spacing') || 10;

            if ($("#gallery").hasClass("prodigy-product__gallery-container--left") || $("#gallery").hasClass("prodigy-product__gallery-container--right")) {
                const ratio = $("#gallery-main").data("ratio");
                const width = $("#gallery-main").width();
                const height = width / ratio;
                $("#gallery").height(height);
                thumbsDirection = 'vertical';
                thumbsSlidesPerView = 'auto';
            }

            const initNav = (swiper, el) => {
                el.on("click", ".prodigy-product__gallery-nav-prev", function() {
                    if (swiper.isBeginning) {
                        swiper.slideTo(swiper.slides.length - 1);
                    } else {
                        swiper.slidePrev();
                    }
                })
                el.on("click", ".prodigy-product__gallery-nav-next", function() {
                    if (swiper.isEnd) {
                        swiper.slideTo(0);
                    } else {
                        swiper.slideNext();
                    }
                })
            }

            const swiperThumbs = new Swiper("#gallery-thumbs", {
                direction: thumbsDirection,
                slidesPerView: thumbsSlidesPerView,
                spaceBetween: thumbsSpaceBetween,
                speed: 500,
                on: {
                    init: function(swiper) {
                        if (thumbsDirection === 'horizontal') {
                            const slides = $("#gallery-thumbs .swiper-slide");
                            if (slides.length > thumbsSlidesPerView) {
                                $("#gallery-thumbs .prodigy-product__gallery-nav").show();
                                initNav(swiper, $("#gallery-thumbs"));
                            }
                        } else if (thumbsDirection === 'vertical') {
                            let slidesHeight = 0;
                            let mainHeight = $("#gallery-main").outerHeight();
                            swiper.slides.forEach(slide => {
                                slidesHeight += $(slide).outerHeight();
                            });
                            if (slidesHeight > mainHeight) {
                                $("#gallery-thumbs .prodigy-product__gallery-nav").show();
                                initNav(swiper, $("#gallery-thumbs"));
                            }
                        }
                    }
                }
            });

            const swiperMain = new Swiper("#gallery-main", {
                speed: 500,
                pagination: {
                    el: ".prodigy-product__gallery-count",
                    type: "fraction",
                },
                thumbs: {
                    swiper: $("#gallery-thumbs").length ? swiperThumbs : null,
                },
                on: {
                    init: function(swiper) {
                        const slides = $("#gallery-main .swiper-slide");
                        if (slides.length > 1) {
                            $("#gallery-main .prodigy-product__gallery-nav").show();
                            initNav(swiper, $("#gallery-main"));
                        }
                    }
                }
            });

            var $target = $("#gallery-main");
            if (typeof code_happened === 'undefined' || window.code_happened == false) {
                window.code_happened = true;
                $target.on(
                    "click",
                    ".icon-fullscreen-js",
                    this.open_photo_swipe.bind(this)
                );
            }
        },

        get_gallery_images: function() {
            const slides = $("#gallery-main .prodigy-product__gallery-img");
            let items = [];

            if (slides.length) {
                slides.each(function(i, el) {
                    var img = $(el).find("img");

                    if (img.length) {
                        var large_image_src = img.attr("data-large_image"),
                            large_image_w = img.attr("data-large_image_width"),
                            large_image_h = img.attr("data-large_image_height"),
                            item = {
                                src: large_image_src,
                                w: large_image_w,
                                h: large_image_h,
                                title: img.attr("data-caption")
                                    ? img.attr("data-caption")
                                    : img.attr("title")
                            };
                        items.push(item);
                    }

                });
            }

            return items;
        },

        open_photo_swipe: function(e) {
            e.preventDefault();

            var pswpElement = $(".pswp")[0],
                items = this.get_gallery_images(),
                index = $("#gallery-main .swiper-slide-active").index();

            var options1 = $.extend(
                {
                    index: index,
                },
                {}
            );

            // Initializes and opens PhotoSwipe.
            var photoswipe = new PhotoSwipe(
                pswpElement,
                PhotoSwipeUI_Default,
                items,
                options1
            );
            photoswipe.init();
        },

        set_shipping_data_variants: function (
            sku,
            weight,
            dimension) {
            let prodigy_additional_weight_js = $('.prodigy-additional-weight-js');
            let prodigy_additional_dimensions_js = $('.prodigy-additional-dimensions-js');
            let product_sku_value = $('.product_sku_value');

            prodigy_additional_weight_js.text(weight)
            prodigy_additional_dimensions_js.text(dimension)
            product_sku_value.text(sku);
        },

        counter_reset: function() {
            $(".counter-count-js").val(1);
        },

        set_product_counter: function () {
            const self = this;
            const counterCount = $(".counter-count-js");
            let cart_button = $('.add-to-cart-js');
            counterCount.inputmask({ regex: "[0-9]*", rightAlign: false });

            $(document).on("click", '.counter-btn-minus-js', function() {
                cart_button.prop("disabled", false);
                cart_button.removeAttr("style");

                const counterCount = $(".counter-count-js");
                const minusBtn = $(".counter-btn-minus-js");
                var counter = parseInt(counterCount.val());
                if (counter !== 1) {
                    counterCount.val(--counter);
                    if (counter <= 1) {
                        minusBtn.prop("disabled", true);
                        minusBtn.css("background", "grey");
                        minusBtn.css("cursor", "not-allowed");
                    }
                }
            });

            $(document)
                .off("click", ".counter-btn-plus-js")
                .on("click", ".counter-btn-plus-js", function() {

                self.get_inventory_data();

                const counterCount = $(".counter-count-js");
                var counter = parseInt(counterCount.val());
                const minusBtn = $(".counter-btn-minus-js");
                if (counter < self.maxItems) {
                    counterCount.val(++counter);
                    if (counter > 1) {
                        minusBtn.prop("disabled", false);
                        minusBtn.removeAttr("style");
                    }
                } else {
                    $('.prodigy-inventory-count-js').text(self.maxItems);
                    $('.prodigy-deficiency-message-js').show();

                    setTimeout(function() {
                        $('.prodigy-deficiency-message-js').css('display','none');
                    }, 5000);
                }
            });
        },

        get_inventory_data: function () {
            let self = this;

            let post_data = {
                action: "prodigy-remote-get-inventory-product",
                post_id: $("#product_id").val(),
                nonce: settings.nonce
            };

            $.ajax({
                type: "post",
                data: post_data,
                dataType: "json",
                url: ajax_url,
                success: function(data) {
                    if (typeof data.attributes !== 'undefined') {
                        self.set_stock_status(data.attributes);
                    }
                }
            });
        },

        reset_product_counter: function(inventory = null) {
            var self = this;
            self.counter_reset();

            if (typeof inventory !== 'undefined') {
                self.set_stock_status(inventory);
            }
        },

        set_stock_status: function (inventory) {
            var inventory_quantity = parseInt(localStorage.getItem("items_quantity"));
            if (inventory['backorderable']) {
                this.maxItems = 99;
            } else if (inventory['manage-stock'] && !inventory['backorderable'] && inventory_quantity > 0 ) {
                this.maxItems = inventory_quantity;
            }
        },

        show_price: function(price, sale_price, subscriptions, select_variant = 0) {
            var attribute_select = $(".attribute_values_js");
            var stock_info = $(".prodigy-product-stock-js");
            var regular_price_info = $(".regular-price-container");
            var sale_price_info = $(".sale-price-container");
            var sale_price_value_block = $(".sale-price");
            var regular_price_value_block = $(".regular-price");
            var currency_sign = $(".price-currency-js");
            var subscription_currency_sign = $('.subscriptions-price-currency-js');
            var subscription_block = $('.subscriptions');
            var default_info = $('.product-default-info-js');
            var sale_price_bracket = $('.sale-price-bracket-js');

            if (attribute_select.length !== 0 && !select_variant) {
                stock_info.hide();
                regular_price_info.hide();
                sale_price_info.hide();
                subscription_block.hide();
            } else {
                if (
                    (typeof sale_price !== "undefined") ||
                    (typeof sale_price !== "undefined" && parseInt(sale_price) !== 0)
                ) {
                    if (price === "" || parseInt(sale_price) === 0) {
                        stock_info.hide();
                        regular_price_info.hide();
                        sale_price_info.hide();
                        if (subscriptions) {
                            currency_sign.hide();
                            sale_price_bracket.hide();
                        }
                    } else {
                        regular_price_info.show();
                        sale_price_info.show();
                        stock_info.show();
                        currency_sign.show();
                    }

                    if (sale_price === "") {
                        sale_price_info.show();
                        currency_sign.hide();
                        sale_price_bracket.hide();
                        if (typeof price !== 'undefined' && price) {
                            sale_price_value_block.text(prodigy_price_format(price));
                            regular_price_info.hide();
                            currency_sign.show();
                            if (subscriptions) {
                                subscription_currency_sign.hide();
                                currency_sign.hide();
                                sale_price_bracket.hide();
                            }
                        }
                    } else {
                        if (price && typeof price !== "undefined" && (sale_price !== null && sale_price.length > 0 )) {
                            regular_price_value_block.text(prodigy_price_format(price));
                            sale_price_value_block.text(prodigy_price_format(sale_price));
                            regular_price_info.show();
                            sale_price_info.show();
                        }else {
                            sale_price_value_block.text(prodigy_price_format(price));
                            regular_price_info.hide();
                            if (subscriptions) {
                                currency_sign.hide();
                                sale_price_bracket.hide();
                            }
                        }
                    }
                } else {
                    sale_price_info.hide();
                    regular_price_info.hide();
                    currency_sign.hide();
                    sale_price_bracket.hide();
                }
            }

            default_info.show();
            let is_subscriptions = $(document).find('.prodigy-subscriptions-tab').length > 0;

            if (select_variant) {
                default_info.hide();

                if (subscriptions) {
                    $('.prodigy-subscriptions-tab-js:first').trigger('click');
                    $('.prodigy-product__price-wrapper').hide();
                } else {
                    $('.prodigy-product__price-wrapper').show();
                }

                let sale_price = $('.subscription-sale_price-js').val();
                if (sale_price !== price && typeof sale_price !== 'undefined') {
                    let price = this.get_current_product_price();
                    let price_string = '$' + prodigy_price_format(price);
                    $('.prodigy-product__prop-txt-price').text(price_string).show();
                }
            } else if (is_subscriptions) {
                $('.product-default-info-price-js').text('$' + price);
            } else {
                let add_info_string = $('.product-default-info-price-js').data('string');
                $('.product-default-info-price-js').text(add_info_string);
            }

            this.format_subscription_price(price);
        },

        show_main_product_info: function() {
            var self = this;
            if (
                typeof this.remote_product !== "undefined" &&
                this.remote_product.remote_main_price !== null
            ) {

                if (typeof this.remote_product.remote_master_variant_info !== 'undefined') {
                    var subscriptions = typeof this.remote_product.remote_master_variant_info['subscription-plan'] !== 'undefined';
                } else {
                    var subscriptions = false;
                }


                if (typeof this.remote_product.remote_main_price !== 'undefined') {
                    var price = this.remote_product.remote_main_price.price;
                    var sale_price = this.remote_product.remote_main_price['sale-price'];
                } else {
                    var price = 0;
                    var sale_price = 0;
                }

                this.show_price(
                    price,
                    sale_price,
                    subscriptions
                );

                if (
                    typeof this.remote_product !== 'undefined' &&
                    typeof this.remote_product.remote_master_variant_info !== "undefined"
                ) {
                    localStorage.setItem("items_quantity", this.remote_product.remote_master_variant_info.inventory.attributes.count);
                }

                var has_variants = !$.isEmptyObject(this.remote_product.variant_option);

                if (!has_variants) {
                    $('.add-to-cart-js').prop("disabled", false);
                    $('.add-to-cart-js').removeAttr('style');
                }

                if (
                    typeof this.remote_product.remote_master_variant_info !== 'undefined'
                    && typeof this.remote_product.remote_master_variant_info.inventory !== 'undefined'
                ) {
                    this.show_status(this.remote_product.remote_master_variant_info.inventory.attributes, has_variants, false);
                }
            }

            if (
                this.product.meta &&
                typeof this.product.meta.product_sku !== "undefined" &&
                this.product.meta.product_sku[0]
            ) {
                var main_product_sku = this.product.meta.product_sku[0];
                $(".product_sku_value").text(main_product_sku);
            }

            var is_subscriptions = $(document).find('.prodigy-subscriptions-tab').length > 0;

            if (!is_subscriptions) {
                self.is_one_time_order = true;
            }

            self.load_subscription_price();
        },


        show_status: function(inventory, has_variant, select_variant ) {
            var self = this;

            var inventory_quantity = parseInt(localStorage.getItem("items_quantity"));
            if (typeof inventory_quantity !== "undefined" && inventory['manage-stock']) {
                self.maxItems = inventory_quantity;
            } else {
                self.maxItems = 99;
            }
            var is_variant = (has_variant && select_variant) || !has_variant;

            if (typeof inventory.stock !== "undefined") {
                var stock_block = $(".prodigy-product-stock-js");

                if (typeof inventory !== 'undefined') {
                    self.set_stock_status(inventory);
                }

                if (inventory['manage-stock'] && inventory_quantity > 0) {
                    if ($(".attribute_values_js").length !== 0 && !is_variant) {
                        self.set_out_of_stock_status();
                        stock_block.hide();
                    } else {
                        self.disable_minus_button();
                        self.set_in_stock_status();
                    }
                } else if (is_variant && inventory['manage-stock'] && inventory['backorderable'] && inventory['stock'] === 'in_stock' && inventory_quantity === 0) {
                    self.set_in_stock_status();
                } else if (is_variant && !inventory['manage-stock'] && inventory['stock'] === 'in_stock') {
                    self.set_in_stock_status();
                }
                else if (is_variant && !inventory['manage-stock'] && inventory['stock'] === 'out_of_stock') {
                    self.set_out_of_stock_status();
                    stock_block.text(this._stock_status_mapper[1]);
                }
            }
        },

        disable_minus_button: function () {
            var minus = $(".counter-btn-minus-js");

            if (parseInt($(".counter-count-js").val()) === 1) {
                minus.prop("disabled", true);
                minus.css("background", "grey");
                minus.css("cursor", "not-allowed");
            } else {
                minus.prop("disabled", false);
                minus.removeAttr("style");
            }
        },

        set_out_of_stock_status: function () {
            var plus = $(".counter-btn-plus-js");
            var minus = $(".counter-btn-minus-js");

            minus.css("cursor", "not-allowed");
            minus.prop("disabled", true);
            minus.css("background", "grey");

            plus.prop("disabled", true);
            plus.css("background", "grey");
            plus.css("cursor", "not-allowed");

            this.disable_add_to_cart_button();
        },

        disable_add_to_cart_button: function () {
            var cart_button = $("button.add-to-cart-js");
            var count_input = $(".counter-count-js");

            cart_button.prop("disabled", true);
            cart_button.css("background", "grey");
            cart_button.css("cursor", "not-allowed");
            count_input.prop("disabled", true);
        },


        set_in_stock_status: function () {
            var stock_block = $(".prodigy-product-stock-js");
            var cart_button = $("button.add-to-cart-js");
            var plus = $(".counter-btn-plus-js");
            var count_input = $(".counter-count-js");
            count_input.prop("disabled", false);
            plus.prop("disabled", false);
            plus.removeAttr("style");

            cart_button.prop("disabled", false);
            cart_button.removeAttr("style");
            stock_block.text(this._stock_status_mapper[0]);
        },

        get_actual_price: function(price, sale_price) {
            if (sale_price === '') {
                return price;
            } else {
                return sale_price;
            }
        },

        set_variants_data: function(selector, data) {
            let self = this;
            if (typeof data !== 'undefined') {

                if (settings.pg_google_track_id) {
                    self.set_view_product_analytic_event(data);
                }

                let cart_button = $("button.add-to-cart-js");
                let sku;
                if (
                    data &&
                    typeof data.attributes !== "undefined" &&
                    data.attributes.sku
                ) {
                    sku = data.attributes.sku;
                }

                if (typeof data.inventory.attributes.count !== "undefined") {
                    localStorage.setItem("items_quantity", data.inventory.attributes.count);
                }

                this.show_status(data.inventory.attributes,true, true);

                if (data.inventory.attributes['manage-stock']) {
                    this.reset_product_counter(data.inventory.attributes);
                }

                this.show_price(
                    data.attributes.price,
                    data.attributes['sale-price'],
                    data['subscription-plan'],
                    true
                );

                if (sku !== "" && typeof sku !== "undefined") {
                    $(".product_sku_value").text(sku);
                } else {
                    $(".prodigy-product__tags-item product_sku").hide();
                }

                // set product data for cart

                if (typeof data !== "undefined") {
                    if (typeof data.remote_variant_id !== "undefined") {
                        cart_button.attr("data-remote-id", data.remote_variant_id);
                    }

                    if (typeof data.local_variant_id !== "undefined") {
                        cart_button.attr("data-local-id", data.local_variant_id);
                    }
                }

                var $product = selector.closest(".product-container-js"),
                    $product_gallery = $product.find(".images-gallery-js"),
                    $gallery_nav = $product.find("#gallery-main"),
                    $gallery_img = $gallery_nav.find("li:eq(0) img"),
                    $product_img_wrap = $product_gallery
                        .find(
                            ".prodigy-product__gallery-image, .prodigy-product__gallery-image--placeholder"
                        )
                        .eq(0),
                    $product_img = $product_img_wrap.find(".wp-post-image"),
                    $product_link = $product_img_wrap.find("a").eq(0);

                if (data.img_url) {
                    var galleryHasImage =
                        $gallery_nav.find('li img[data-o_src="' + data.img_url + '"]')
                            .length > 0;

                    // If the gallery has the image, reset the images. We'll scroll to the correct one.
                    if (galleryHasImage) {
                        self.pg_variations_image_reset();
                    }

                    // See if gallery has a matching image we can slide to.
                    var slideToImage = $gallery_nav.find(
                        'li img[src="' + data.img_url + '"]'
                    );

                    self.pg_set_variation_attr($product_img, "src", data.img_url);

                    self.pg_set_variation_attr(
                        $product_img_wrap,
                        "data-thumb",
                        data.img_url
                    );
                    self.pg_set_variation_attr($gallery_img, "src", data.img_url);
                    self.pg_set_variation_attr($product_link, "href", data.img_url);
                } else {
                    self.pg_variations_image_reset(selector);
                }

                self.load_subscription_price();
            }
        },

        pg_variations_image_reset: function(selector) {
            if (typeof selector !== "undefined") {
                var $product = selector.closest(".product-container-js"),
                    $product_gallery = $product.find(".images-gallery-js"),
                    $gallery_nav = $product.find("#gallery-main"),
                    $gallery_img = $gallery_nav.find("li:eq(0) img"),
                    $product_img_wrap = $product_gallery
                        .find(
                            ".prodigy-product__gallery-image, .prodigy-product__gallery-image--placeholder"
                        )
                        .eq(0),
                    $product_img = $product_img_wrap.find("img"),


                    $product_link = $product_img_wrap.find("a").eq(0);

                this.pg_reset_variation_attr($product_img, "src");
                this.pg_reset_variation_attr($product_img, "width");
                this.pg_reset_variation_attr($product_img, "height");
                this.pg_reset_variation_attr($product_img, "srcset");
                this.pg_reset_variation_attr($product_img, "sizes");
                this.pg_reset_variation_attr($product_img, "title");
                this.pg_reset_variation_attr($product_img, "data-caption");
                this.pg_reset_variation_attr($product_img, "alt");
                this.pg_reset_variation_attr($product_img, "data-src");
                this.pg_reset_variation_attr($product_img, "data-large_image");
                this.pg_reset_variation_attr($product_img, "data-large_image_width");
                this.pg_reset_variation_attr($product_img, "data-large_image_height");
                this.pg_reset_variation_attr($product_img_wrap, "data-thumb");
                this.pg_reset_variation_attr($gallery_img, "src");
                this.pg_reset_variation_attr($product_link, "href");
            }
        },

        pg_reset_variation_attr: function(element, attr) {
            if (undefined !== element.attr("data-o_" + attr)) {
                element.attr(attr, element.attr("data-o_" + attr));
            }
        },

        pg_set_variation_attr: function(element, attr, value) {

            if (undefined === element.attr("data-o_" + attr)) {
                element.attr(
                    "data-o_" + attr,
                    !element.attr(attr) ? "" : element.attr(attr)
                );
            }
            if (false === value) {
                element.removeAttr(attr);
            } else {
                element.attr(attr, value);
            }
        },

        /**
         * Get obj remote product info
         * @version 2.0.0
         */
        set_global_remote_product: function() {
            let post_data = {
                action: "prodigy-remote-get-product",
                post_id: $("#product_id").val()
            };

            let self = this;

            $.ajax({
                type: "post",
                data: post_data,
                dataType: "json",
                url: ajax_url,
                success: function(data) {
                    self.remote_product = data.data;

                    if (typeof settings.is_captcha !== 'undefined' &&
                        settings.is_captcha !== '' &&
                        typeof settings.captcha_site_key !== 'undefined' &&
                        settings.captcha_site_key !== ''
                    ) {
                        let is_admin = $(document).find('#user-role-js').data('attr');
                        if (!is_admin) {
                            grecaptcha.render('captcha', {
                                'sitekey': settings.captcha_site_key
                            });
                        }
                    }

                    if ( typeof data.data !== 'undefined') {
                        self.variant = data.data.remote_master_variant_info;
                    }
                    self.show_main_product_info();

                    // init cart
                    self.add_item_to_cart();
                }
            });
        },

        show_tab_description: function () {
            $("body").on("click", ".show-description-js", function() {
                $(".description_tab").addClass("active").show();
                $("#tab-li-reviews").removeClass("active");
                $("#tab-additional_information").hide();
                $("#tab-description").show();
                $("#tab-reviews").hide();
                $(".additional_information_tab").removeClass("active");
                $(".reviews_tab").removeClass("active");
                $(".description_tab").addClass("active");
            });
        },

        show_tab_review: function() {
            $("body").on("click", ".prodigy-review-link-js", function() {
                $("#tab-reviews").addClass("active").show();
                $("#tab-li-reviews").addClass("active");
                $("#tab-description").hide();
                $("#tab-additional_information").hide();
                $(".description_tab").removeClass("active");
                $(".additional_information_tab").removeClass("active");
                $(".reviews_tab").addClass("active");
                if ( document.getElementById("tab-reviews")) {
                    document.getElementById("tab-reviews").scrollIntoView();
                }
            });
        },

        set_product_tabs: function() {
            $(".description_tab").addClass("active");
            $("#tab-additional_information").hide();
            $("#tab-reviews").hide();

            var product_url = $('.product-url-js').val();
            $('.show-description-js, .description_tab, .additional_information_tab, .reviews_tab').on('click', function() {
                $('html,body').animate({scrollTop: $(this).offset().top}, 500);
            });

            $("body")
                // Tabs
                .on("init", ".prodigy-tabs-js, .prodigy-tabs", function() {
                    $(".pg-tab, .prodigy-tabs .panel:not(.panel .panel)").hide();
                    var hash = window.location.hash;
                    var url = window.location.href;
                    var $tabs = $(this)
                        .find(".pg-tabs, ul.tabs")
                        .first();
                    if (
                        hash.toLowerCase().indexOf("comment-") >= 0 ||
                        hash === "#reviews" ||
                        hash === "#tab-reviews"
                    ) {
                        $tabs.find("li.reviews_tab a").click();
                    } else if (
                        url.indexOf("comment-page-") > 0 ||
                        url.indexOf("cpage=") > 0
                    ) {
                        $tabs.find("li.reviews_tab a").click();
                    } else if (hash === "#tab-additional_information") {
                        $tabs.find("li.additional_information_tab a").click();
                    } else {
                        var $tab = $tabs.find("li:first a");
                        var $tabs_wrapper = $tab.closest(".prodigy-tabs-js, .prodigy-tabs");
                        $tabs.find("li").removeClass("active");
                        $tabs_wrapper.find(".pg-tab, .panel:not(.panel .panel)").hide();

                        $tab.addClass("active");
                        $tabs_wrapper.find($tab.data("href")).show();
                    }
                })
                .on("click", ".pg-tabs li a, ul.tabs li a", function(e) {
                    var $tab = $(this);
                    var $tabs_wrapper = $tab.closest(".prodigy-tabs-js, .prodigy-tabs");
                    var $tabs = $tabs_wrapper.find(".pg-tabs, ul.tabs");

                    $tabs.find("li").removeClass("active");
                    $tabs_wrapper.find(".pg-tab, .panel:not(.panel .panel)").hide();

                    $tab.closest("li").addClass("active");
                    $tabs_wrapper.find($tab.data("href")).show();
                })

                // Star ratings for comments
                .on("init", "#prodigy-rating", function() {
                    $(this)
                        .hide()
                        .before(
                            "" +
                            '<div class="stars prodigy-comment__rating">' +
                            '<a class="star-1 prodigy-comment__star icon icon-star" href="#">1</a>' +
                            '<a class="star-2 prodigy-comment__star icon icon-star" href="#">2</a>' +
                            '<a class="star-3 prodigy-comment__star icon icon-star" href="#">3</a>' +
                            '<a class="star-4 prodigy-comment__star icon icon-star" href="#">4</a>' +
                            '<a class="star-5 prodigy-comment__star icon icon-star" href="#">5</a>' +
                            "</div>"
                        );
                })
                .on("click", "#respond div.stars a", function() {
                    var $star = $(this),
                        $rating = $(this)
                            .closest("#respond")
                            .find("#prodigy-rating"),
                        $container = $(this).closest(".stars");
                    $rating.val($star.text()).trigger("change");
                    $star.siblings("a").removeClass("active");
                    $star.addClass("active");
                    $container.addClass("selected");

                    return false;
                })

                .on("click", "#reviews #comments .justify-content-center", function() {
                    window.prodigyProduct
                        .get_count_review()
                        .done(function(result) {
                            let count_review = result.data;
                            if (count_review > 0) {
                                window.prodigyProduct.get_content_review();
                            }
                        })
                        .fail(function() {});
                });

            $(".prodigy-tabs-js, .prodigy-tabs, #prodigy-rating").trigger("init");
        },

        get_content_review: function() {
            let self = $("#reviews #comments .justify-content-center");
            let page = $(".per-page-js").data("page");
            let post_data = {
                action: "prodigy-public-get-comments",
                post_id: $("#product_id").val(),
                page: page,
                nonce: settings.nonce
            };

            $.ajax({
                type: "post",
                data: post_data,
                dataType: "text",
                url: ajax_url,
                success: function(data) {
                    self.before(data);
                    $(".per-page-js").data("page", page + 1);

                    window.prodigyProduct.get_count_review().done(function(res) {
                        if (res.data === 0) {
                            window.prodigyProduct.hide_link_show_more_reviews();
                        }
                    });
                }
            });
        },

        get_count_review: function() {
            let post_data = {
                action: "prodigy-public-get-comments-count",
                post_id: $("#product_id").val(),
                page: $(".per-page-js").data("page"),
                nonce: settings.nonce
            };

            return $.ajax({
                type: "post",
                data: post_data,
                dataType: "json",
                url: ajax_url
            });
        },

        hide_link_show_more_reviews: function() {
            $(".link-show-more-reviews-js")
                .removeClass("d-flex")
                .addClass("d-none");
        },

        set_default_link_review: function() {
            window.prodigyProduct.get_count_review().done(function(res) {
                if (res.data === 0) {
                    window.prodigyProduct.hide_link_show_more_reviews();
                }
            });
        },

        init_show_more: function() {
            $("body").on(
                "click",
                ".prodigy-product__description-show-more",
                function() {
                    var $container = $(this).parent();
                    $container
                        .find(".prodigy-product__description-container")
                        .removeClass("prodigy-product__description-container--truncated");
                    $container.find(".prodigy-product__description-fade").remove();
                    $(this).remove();
                }
            );
        }
    };

    window.prodigyProduct = prodigy_product;
})(jQuery, window);

// jQuery(function($) {
jQuery(document).ready(function ($) {
    window.prodigyProduct.init();
    window.prodigyRecaptchaCallback = window.prodigyProduct.captcha_callback.bind(
        window.prodigyProduct
    );
});

