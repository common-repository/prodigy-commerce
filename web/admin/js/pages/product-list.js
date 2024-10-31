(function( $, window ) {
        var prodigy_admin_products = {

            init: function () {
                if ( admin_data.is_have_sync_notification==1 ) {
                    this.check_sync_status();
                }

                this.get_products_content();
                this.set_product_search_parameters();
                this.set_sortable();
                this.mobile_cell_btn();
                this.launch_sync_process();
                this.close_notification()
            },

            close_notification: function() {
              $(document).on('click', '.notice-dismiss', function () {
                $(this).closest(".prodigy-admin-custom-template-notice").remove();
              });
            },

            set_sortable: function () {
                $(document).on('click', '.sortable', function () {
                    var sort_value = $(this).attr('data-sort');

                    if ($('.sortable').hasClass('desc')) {
                        $(this).removeClass('desc');
                        var newParams = [
                            ['sort', sort_value + '_asc'],
                        ];
                    } else {
                        $(this).removeClass('asc');
                        var newParams = [
                            ['sort', '-' + sort_value + '_desc'],
                        ];
                    }

                    var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
                    history.pushState('', '', newUrl);
                    document.location.reload();
                });
            },

            get_products_content: function () {
                let query = window.location.search.slice(1) + '&nonce=' + admin_data.nonce;
                $.ajax({
                    type: "GET",
                    url: ajaxurl + '?action=prodigy-get-products-content&' + query ,
                    cache: false,
                    success: function (response) {
                        if (response.data.products != null && typeof response.data.products != "undefined") {
                            if (response.data.products.length === 0) {
                                $('.not-result-products-list-js').append('<p>No products found</p>');
                            }
                        }

                        if (typeof response.data.search !== "undefined")
                            $('.admin-product-search-js').val(response.data.search);

                        $('.main-products-container-js').html(response.data.template);
                        $('.products-pagination-js').html(response.data.pagination);
                    }
                });
            },

            set_product_search_parameters: function () {
                var self = this;
                var search = this.prodigyGetUrlParam('search');
                if (typeof search !== 'undefined' && search !== 0) {
                    $('.admin-product-search-js').val(this.prodigyGetUrlParam('search'));
                }

                $(document).on('click', '.admin-submit-product-search-js', function () {
                    self.set_product_search_params();
                });
            },

            prodigyGetUrlParam: function(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null) {
                    return null;
                }

                return decodeURI(results[1]) || 0;
            },


            set_product_search_params: function () {
                var search_value = $('.admin-product-search-js').val();

                var newParams = [
                    ['search', search_value]
                ];

                var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
                history.pushState('', '', newUrl);
                document.location.reload();
                $('.admin-product-search-js').text(search_value);
            },

            mobile_cell_btn: function () {
                $(document).on('click', '.prodigy-primary-cell__btn', (evt) => {
                    $(evt.currentTarget)
                        .toggleClass('prodigy-primary-cell__btn--show')
                        .parent()
                        .find('.prodigy-primary-cell__mobile-content')
                        .toggleClass('prodigy-primary-cell__mobile-content--show');
                });
            },

            launch_sync_process: function () {
                var self = this;

                $(document).on('click', '.sync-process-js', function () {
                    $('.sync-process-js').attr('disabled', 'disabled');
                    self.start_process();
                    self.check_sync_status();
                });
            },

            check_sync_status: function () {
                var self = this;
                var myVar = setInterval(function () {
                    var post_data = {
                        action: 'prodigy-check-sync-status',
                    };

                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: post_data,
                        cache: false,
                        error: function (response) {
                            if (response.data.status === 'error') {
                                clearInterval(myVar);
                                $('.sync-process-js').removeAttr('disabled');
                                var error_message = self.sync_error_notification();
                                $('#screen-meta').after(error_message);
                            }
                        },
                        success: function (response) {
                            if (response.data != null && typeof response.data.status !== undefined ) {
                                if (response.data.status === 'success') {
                                    clearInterval(myVar);
                                    $('.sync-process-js').removeAttr('disabled');
                                    $('.notice').remove();
                                    var success_message = self.sync_success_notification();
                                    $('#screen-meta').after(success_message);
                                }
                            }
                        }
                    });
                }, 1000);
            },

            sync_error_notification: function() {
                return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-error is-dismissible"><p>'+plugin_path_dir.sync_notification_message+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
            },

            sync_success_notification: function() {
                return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-success is-dismissible"><p>Synchronization of products completed successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
            },


            start_process: function () {
                var post_data = {
                    action: 'prodigy-start-sync-process',
                    sync: true,
                    nonce: admin_data.nonce,
                };

                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: post_data,
                    cache: false,
                    success: function (response) {

                    }
                });
            }

        }
    window.prodigyAdminProducts = prodigy_admin_products;
})(jQuery, window);
