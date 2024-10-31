( function ( $, window ) {
        const qnonce = settings.nonce;
        $(document).on('click', '.quick-view-js', function () {
            window.code_happened = false;
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'prodigy-quick-edit',
                    post_id: $(this).data('id'),
                    nonce: qnonce
                },
                cache: false,
                success: function(html) {
                    $.magnificPopup.open({
                        items: {
                            src: '#quick-view-js',
                        },
                        type: 'inline',
                        callbacks: {
                            beforeOpen : function() {
                                $('#quick-view-content-js').html(html);
                                window.prodigyProduct.init();
                                window.prodigyProduct.set_global_remote_product();
                                window.prodigyProduct.set_product_gallery();
                                window.prodigyProduct.change_variant_selection();
                                window.prodigyProduct.update_variants();
                                window.prodigyProduct.update_images_gallery();
                                window.prodigyProduct.set_elementor_options();
                                window.prodigyProduct.set_product_counter();
                            }
                        }
                    });
                }
            });


        $(document).on('click', '.quick-view-close', '.filter-close', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    });
})(jQuery, window);