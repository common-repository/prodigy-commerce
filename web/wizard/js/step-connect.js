jQuery(function ($) {

    const body_element = $('body');
    const modal_info_synchronization = $(".modal-info-synchronization-js");
    const cancel_sync_content = $('.cancel-sync-content-js');
    const sync_content = $('.sync-content-js');
    const input_synchronization = $("#synchronization");

    $('body').on('click', '.connect-button-js', function() {
        let url_hs = $(this).attr('href');
        location = url_hs;

        return false;
    });

    /*
     * Synchronize content to hosted system
     */
    input_synchronization.on('change', input_synchronization, function () {
         change_synchronize_content();
    });

    cancel_sync_content.on('click', function () {
        hide_modal_sync();
        remove_indicator_sync_content();
    });

    sync_content.on('click', function () {
        hide_modal_sync();
        set_checked_synchronization();
        set_indicator_sync_content();
    });

    function set_indicator_sync_content() {

        $.ajax({
            dataType: 'json',
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'set-indicator-sync-content',
                nonce_code : prodigyajax.nonce
            },
            success: function (data) {
                console.log(data.success);
            },
            fail: function (data) {
            },
        });
    }

    function remove_indicator_sync_content() {

        $.ajax({
            dataType: 'json',
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'remove-indicator-sync-content',
                nonce_code : prodigyajax.nonce
            },
            success: function (data) {
                console.log(data.success);
            },
            fail: function (data) {
            },
        });
    }

    function change_synchronize_content() {
        let synchronization = input_synchronization.prop("checked");

        if (synchronization === false) {
            show_modal_sync();
        } else {
            set_indicator_sync_content();
        }
    }

    function set_checked_synchronization() {
        input_synchronization.prop("checked", true);
        set_indicator_sync_content();
    }

    function show_modal_sync() {
        modal_info_synchronization.show();
        body_element.addClass('modal-open');
    }

    function hide_modal_sync() {
        modal_info_synchronization.hide();
        body_element.removeClass('modal-open');
    }

});