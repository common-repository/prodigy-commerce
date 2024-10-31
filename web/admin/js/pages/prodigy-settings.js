jQuery(document).ready(function ($) {

    var exeption_slugs = [
        'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category', 'category__and'
        , 'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup'
        , 'customize_messenger_channel', 'customized', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'fields'
        , 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nonce', 'nopaging', 'offset'
        , 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post', 'post__in'
        , 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 'posts'
        , 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence'
        , 'showposts', 'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id'
        , 'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'theme', 'type', 'w', 'withcomments'
        , 'withoutcomments', 'year'
    ];

    init();

    function init() {
        productFormValidation();
        setExpirationTimeSetting();
        setCaptchaSetting();
        checkDataFormToUpdate();
        makeTabsLogic();
        setEvents();
        setPagesAutocomplete();
        setToggles();
    }

    function setToggles(){
        let $toggler = $('[prodigy-toggle]', document);
        $toggler.on('change', function (e){
            let selector = $(this).attr('prodigy-toggle');
            let $target = $(selector);
            if ( $target.length ) {
                if( $(this).prop('checked') === true ){
                    $target.show();
                }else{
                    $target.hide();
                }
            }
        });
        $toggler.trigger('change');
    }

    function setPagesAutocomplete() {
        let url = ajaxurl + '?action=prodigy-get-pages&nonce=' + admin_data.nonce ;
        $('.prodigy-init-page-select').select2({
            ajax: {
                url: url,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.items,
                    };
                },
            },
            allowClear: true,
            height: '34px',
            placeholder: 'select page..',
            minimumInputLength: 3,
            multiple: false,
            width: 400,
        });
    }

    function productFormValidation() {
        $('#product-form').validate({
            rules: {
                pg_custom_expiration_time: {
                    required: true
                },
                prodigy_product_type_slug: {
                    required: true,
                    regex: /^[0-9a-zA-Z_-]{2,}$/
                },
                prodigy_category_type_slug: {
                    required: true,
                    regex: /^[0-9a-zA-Z_-]{2,}$/
                },
                prodigy_tag_type_slug: {
                    required: true,
                    regex: /^[0-9a-zA-Z_-]{2,}$/
                },
                pg_captcha_site_key: {
                    required: true,
                },
                pg_captcha_secret_key: {
                    required: true,
                }
            },
            submitHandler: function (form) {
                if ($(form).valid()) {
                    form.submit();
                    showMessage($('button[type=submit]'));
                } else {
                    $('html, body').animate({
                        scrollTop: ($('form .form-error-input').offset().top - 300)
                    }, 200);

                    return false;
                }
            },
        });

        $.validator.addMethod(
            "regex",
            function (value, element, regexp) {
                return this.optional(element) || (regexp.test(value) && $.inArray(value, exeption_slugs))
            },
            "Please check your input."
        );
    }

    function clear_cache_ajax() {
        var post_data = {
            action: 'prodigy-cache-clear',
            is_clear: true,
            nonce: admin_data.nonce,
        };

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: post_data,
            cache: false,
            success: function (response) {
                location.reload();
            }
        });
    }

    function start_process() {
        var post_data = {
            action: 'prodigy-settings-start-manual-sync-process',
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

    function check_sync_status () {
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
                    if (typeof response.data !== 'undefined') {
                        if (response.data.status === 'error') {
                            clearInterval(myVar);
                            $('.sync-process-button-js').removeAttr('disabled');
                            var error_message = sync_error_notification();
                            $('#screen-meta').after(error_message);
                        }
                    }
                },
                success: function (response) {
                    if (typeof response.data !== 'undefined') {
                        if (response.data.status === 'success') {
                            clearInterval(myVar);
                            $('.sync-process-button-js').removeAttr('disabled');
                            var success_message = sync_success_notification();
                            $('#screen-meta').after(success_message);
                        }
                    }
                }
            });
        }, 1000);
    }

    function sync_error_notification() {
        return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-error is-dismissible"><p>'+plugin_path_dir.sync_notification_message+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
    }

     function sync_success_notification() {
        return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-success is-dismissible"><p>Synchronization of products completed successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
    }



    function setExpirationTimeSetting() {
        var expiration_time_input = $('.expiration-custom-js');

        expiration_time_input.inputmask('integer', {
            max: 9999, rightAlign: false, placeholderText: 'from 1h to 9999h'
        });

        var expiration_time_select = $('.expiration-time-js');

        expiration_time_select.change(function () {
            if ($(this).val() === 'custom') {
                expiration_time_input.show();
            } else {
                expiration_time_input.hide();
            }
        });

        if (expiration_time_select.val() === 'custom') {
            expiration_time_input.show();
        } else {
            expiration_time_input.hide();
            expiration_time_input.val('');
        }

        var expiration_cache_time_input = $('.pg-cache-expiration-custom-js');

        expiration_cache_time_input.inputmask('integer', {
            max: 9999, rightAlign: false, placeholderText: 'from 1s to 9999s'
        });

        var expiration_cache_time_select = $('.pg-cache-expiration-time-js');

        expiration_cache_time_select.change(function () {
            if ($(this).val() === 'custom') {
                expiration_cache_time_input.show();
            } else {
                expiration_cache_time_input.hide();
            }
        });

        if (expiration_cache_time_select.val() === 'custom') {
            expiration_cache_time_input.show();
        } else {
            expiration_cache_time_input.hide();
            expiration_cache_time_input.val('');
        }
    }


    function setCaptchaSetting() {
        var captcha_block = $('.captcha-block-js');

        if ($('.captcha-launch-js').prop('checked') == true) {
            captcha_block.show();
        } else {
            captcha_block.hide();
        }

        $('.captcha-launch-js').change(function () {
            if ($(this).prop('checked') == true) {
                captcha_block.show();
            } else {
                captcha_block.hide();
            }
        });
    }

    function makeTabsLogic() {
        // check for prodigy settings page
        if (document.URL.indexOf('prodigy_settings') != -1) {
            var url = new URL(document.URL);
            var tabParam = url.searchParams.get("tab");
            if (tabParam == null) {
                $('#general-tab').addClass('nav-tab-active');
                $('#general').removeAttr("style");
            }

            if (tabParam == 'product') {
                $('#manage_stock').change(function () {
                    if ($(this).prop('checked') == true) {
                        $('.manage-visible').hide();
                    } else {
                        $('.manage-visible').show();
                    }
                })
            }
        }
    }


    function setEvents() {
        $(document).on('click', '.sync-process-button-js', function () {
            $('.sync-process-button-js').attr('disabled', 'disabled');
            start_process();
            check_sync_status();
        });

        $(document).on('click', '.pg-clear-cache-js', function () {
            clear_cache_ajax();
        });

        $(document).on('click', '.notice-dismiss', function () {
            $(this).closest(".prodigy-admin-custom-template-notice").remove();
        });

        $('.update-store-js').on('click', function (event) {
            update_store_info();
        });

        $('.setup-to-wizard-js').on('click', function (event) {
            setup_to_wizard();
        });

        $(document).on("submit", "form", function (e) {
            window.onbeforeunload = null;
        });

        $('#saveModal').dialog({
            title: 'Save Settings',
            autoOpen: false,
            draggable: false,
            width: 'auto',
            modal: true,
            resizable: false,
            closeOnEscape: true,
            position: {
                my: "center",
                at: "center",
                of: window
            }
        });
    }

    function setup_to_wizard() {
        window.location.href = url_redirect;
    }

    /**
     * Update store info from hosted system
     */
    function update_store_info() {
        $.ajax({
            dataType: 'json',
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'update-store-info'
            },
            success: function (data) {
                alert(data.data.message);
                $('.name-store-js').text(data.data.pg_domain_hosted_system);
                $('.subdomen-store-js').text(data.data.pg_url_domain_hosted_system);
            },
            fail: function () {
                $('.error-message').show();
            },
            statusCode: {
                404: function (data) {
                    alert(data.responseJSON.data);
                },
                422: function (data) {
                    alert(data.responseJSON.data);
                },
            }
        });
    }

    function showMessage ( button ) {
        button.click(function () {
            localStorage.reloadAfterPageLoad = true;
            window.location.reload();
        });

        if (localStorage.reloadAfterPageLoad) {
            $('#show-message').show();
            localStorage.reloadAfterPageLoad = false;
            localStorage.clear();
        }
    }

    function checkDataFormToUpdate() {

        let current_form = prodigyGetUrlParam( 'tab' );
        let isShowConfirm = false;
        window.isDirty = false;

        $( '#' + current_form + '-form :input:not([type=submit])' ).each( function() {

            if ( $( this ).is( ':radio' ) || $( this ).is( ':checkbox' ) ) {
                var checked = $( this ).is( ':checked' ) ? 'checked' : 'unchecked';
                $( this ).data(  'initialValue', checked );
            } else {
                $( this ).data( 'initialValue', $( this ).val() );
            }
        });


        $( 'a' ).click( function ( event ) {
            window.isDirty = false;
            let currentValue = null;

            $( '#' + current_form + '-form :input:not([type=submit])' ).each( function () {
                if ( $( this ).is( ':radio' ) || $( this ).is( ':checkbox' ) ) {
                    currentValue =  $( this ).is( ':checked' ) ? 'checked' : 'unchecked';
                } else {
                    currentValue = $( this ).val();
                }

                if ( $( this ).data( 'initialValue' ) !== currentValue ) {
                    window.isDirty = true;
                }
            });

            if ( window.isDirty === true ) {

                let currentUrl = document.URL;
                if ( currentUrl.indexOf('prodigy_settings') != -1 ) {
                    event.preventDefault();

                    $( '#saveModal' ).dialog( 'open' );
                }
            } else {
                window.isDirty = false;
            }

            let url = $( this ).attr( 'href' );
            if( !url.startsWith('http') && !url.startsWith('/wp-admin')){
                url = '/wp-admin/' + url;
            }
            $(document).on("click", '.settings-button-save', function() {
                let $form = $( '#' + current_form + '-form' );
                let data = $form.serialize();
                $.post( window.location.href, data, function () {
                    window.location.href = url;
                } );
            });

            $( '.close-setting-popup' ).click( url, function ( e ) {
                e.preventDefault();
                window.location.href = url;
            });

        });
    }
});
