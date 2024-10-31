(function ($, window) {
    var my_account = {
        open_class: 'prodigy-navbar-account__wrap--open',
        my_account_element: '#my-account',

        init: function () {
            this.toggle_widget();
            this.logout();
            this.closeOnOutsideClick();
            this.user_login();
        },

        user_login: function () {
            $(document).on('click', '.user-login-js', function () {
                let post_data = {
                    action: "prodigy-user-login",
                    current_url: window.location.href,
                    nonce: options.nonce
                };

                $.ajax(
                    {
                        type: "post",
                        data: post_data,
                        dataType: "json",
                        url: ajax_url,
                        success: function (data) {
                            window.location.href = data.data.login_url;
                        }
                    }
                );
            });
        },

        toggle_widget: function () {
            let self = this;
            $(document).off('click', this.my_account_element).on('click', this.my_account_element, function (e) {
                e.stopPropagation();
                $(this).toggleClass(self.open_class);
            });
        },

        closeOnOutsideClick: function () {
            let self = this;
            $(document).on('click', function (e) {
                if (!$(e.target).closest(self.my_account_element).length) {
                    $(self.my_account_element).removeClass(self.open_class);
                }
            });
        },

        logout: function () {
            $('.user-logout-js').click(function () {
                let post_data = {
                    action: "prodigy-user-logout",
                };

                $.ajax({
                    type: "post",
                    data: post_data,
                    dataType: "json",
                    url: ajax_url,
                    success: function (data) {
                        location.reload();
                    }
                });
            });
        }

    };
    window.my_account = my_account;
})( jQuery, window );
jQuery(
    function ($) {
        window.my_account.init();
    }
);
