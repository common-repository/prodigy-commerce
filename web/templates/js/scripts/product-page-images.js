(function($, window) {

    var prodigy_product_images = {
        _weight_type_mapper: ["lbs", "g", "kg", "oz"],
        _dimension_type_mapper: ["in", "cm"],
        _stock_status_mapper: ["In stock", "Out of stock"],
        product: {},
        is_show_subscription_popup: false,
        subscription_price: 0,
        is_subscription_replaced: false,
        is_one_time_order: true,
        subscription_id: '',
        remote_product: {},
        variant: {},
        maxItems: 99,
        checkout_url: "",

        init: function () {
            this.set_product_gallery();
            this.update_images_gallery();
        },

        update_images_gallery: function () {
            var self = this;
            $(document).on('change', '.attribute_values_js', function () {
                var post_data = {
                    action: "prodigy-get-image-option",
                    post_id: $("#product_id").val(),
                    option: $(this).val(),
                    attribute: $(this).data('attribute')
                };

                $.ajax({
                    type: "post",
                    data: post_data,
                    dataType: "json",
                    url: ajax_url,
                    error: function (xhr, status, error) {
                    },
                    success: function (response) {
                        if (typeof response.data !== undefined && response.data) {
                            $('.images-gallery-js').html($(response.data.product_gallery).html());
                            self.set_product_gallery();
                        }
                    }
                });

            });
        },

        set_product_gallery: function () {
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
                el.on("click", ".prodigy-product__gallery-nav-prev", function () {
                    if (swiper.isBeginning) {
                        swiper.slideTo(swiper.slides.length - 1);
                    } else {
                        swiper.slidePrev();
                    }
                })
                el.on("click", ".prodigy-product__gallery-nav-next", function () {
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
                    init: function (swiper) {
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
                    init: function (swiper) {
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

        get_gallery_images: function () {
            const slides = $("#gallery-main .prodigy-product__gallery-img");
            let items = [];

            if (slides.length) {
                slides.each(function (i, el) {
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

        open_photo_swipe: function (e) {
            e.preventDefault();

            var pswpElement = $(".pswp")[0],
                items = this.get_gallery_images(),
                index = $("#gallery-main .swiper-slide-active").index();

            var options = $.extend(
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
                options
            );
            photoswipe.init();
        },

        pg_variations_image_reset: function (selector) {
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

        pg_reset_variation_attr: function (element, attr) {
            if (undefined !== element.attr("data-o_" + attr)) {
                element.attr(attr, element.attr("data-o_" + attr));
            }
        },

        pg_set_variation_attr: function (element, attr, value) {

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

    }

    window.prodigyProductImg = prodigy_product_images;
})(jQuery, window);

// jQuery(function($) {
jQuery(document).ready(function ($) {
    window.prodigyProductImg.init();
});

