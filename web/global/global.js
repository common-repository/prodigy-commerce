(function ($) {
    'use strict';

    $(document).ready(function () {
        //TODO -  need to modify
        set_admin_url_menu();

        function set_admin_url_menu() {
            var menu = $('.wp-submenu').find('.wp-first-item');
            var link = data.site_url + '/wp-admin/edit.php?post_type=' + data.post_type + '&page=prodigy_products';

            $('.wp-menu-name').each(function () {
                var name = $(this).text();
                if (name === "Prodigy") {
                    $(this).parent().attr("href", link);
                }
            });

            menu.each(function () {
                var name = $(this).text();
                if (name === "Products") {
                    $(this).attr("href", link);
                }
            });
        }

        window.removeArr = function (arr, what) {
            debugger
            a = arguments, L = a.length, ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax = arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }


        window.setUrlParameter = function (url, key, value) {
            var baseUrl = url.split('?')[0],
                urlQueryString = '?' + url.split('?')[1],
                newParam = key + '=' + value,
                params = '?' + newParam;

            // If the "search" string exists, then build params from it
            if (urlQueryString) {
                var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
                var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

                if (typeof value === 'undefined' || value === null || value === '') { // Remove param if value is empty
                    params = urlQueryString.replace(removeRegex, "$1");
                    params = params.replace(/[&;]$/, "");

                } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
                    params = urlQueryString.replace(updateRegex, "$1" + newParam);

                } else { // Otherwise, add it to end of query string
                    params = urlQueryString + '&' + newParam;
                }
            }

            // no parameter was set so we don't need the question mark
            params = params === '?' ? '' : params;

            return baseUrl + params;
        }

        window.imagePathDirectory = function () {
            return window.location.protocol + '//' + window.location.hostname + '/wp-content/plugins/' + data.plugin_directory + '/web/';
        };

        window.prodigyGetUrlParam = function (name, url = window.location.href) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            if (results == null) {
                return null;
            }

            return decodeURI(results[1]) || 0;
        };

        window.removeParams = function (sParam) {
            var url = window.location.href.split('?')[0] + '?';
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] != sParam) {
                    url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
                }
            }
            return url.substring(0, url.length - 1);
        }

        window.prodigyInsertUrlParams = function (params) {
            var result;
            var ii = params.length;
            var queryString = document.location.search.substr(1);
            var kvps = queryString ? queryString.split('&') : [];
            var kvp;
            var skipParams = [];
            var i = kvps.length;
            while (i--) {
                kvp = kvps[i].split('=');
                if (kvp[0].slice(-2) != '[]') {
                    var ii = params.length;
                    while (ii--) {
                        if (params[ii][0] == kvp[0]) {
                            kvp[1] = params[ii][1];
                            kvps[i] = kvp.join('=');
                            skipParams.push(ii);
                        }
                    }
                }
            }
            var ii = params.length;
            while (ii--) {
                if (skipParams.indexOf(ii) === -1) {
                    kvps.push(params[ii].join('='));
                }
            }
            result = kvps.length ? '?' + kvps.join('&') : '';
            return result;
        },

            window.getCurrentUrl = function () {
                var path = window.location.pathname;
                var pathName = path.substring(0, path.lastIndexOf('/') + 1);

                return pathName;
            },

            window.updateURLParam = function (key, val) {
                var url = window.location.href;
                var reExp = new RegExp("[\?|\&]" + key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

                if (reExp.test(url)) {
                    // update
                    var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                    var delimiter = reExp.exec(url)[0].charAt(0);
                    url = url.replace(reExp, delimiter + key + "=" + val);
                } else {
                    // add
                    var newParam = key + "=" + val;
                    var devider = (url.indexOf('?') === -1) ? '?' : '&';

                    if (url.indexOf('#') > -1) {
                        var urlparts = url.split('#');
                        url = urlparts[0] + devider + newParam + (urlparts[1] ? "#" + urlparts[1] : '');
                    } else {
                        // if (typeof newParam !== 'undefined')
                        url += devider + newParam;
                    }
                }
                window.history.pushState(null, document.title, url);
                return url;
            },

            window.prodigy_price_format = function (number, decimals = 2, dec_point = '.', thousands_sep = ',') {
                // Strip all characters but numerical ones.
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            },

            window.parse_price = function (str) {
                if (str === 0) {
                    return 0;
                }
                var regex = /[+-]?\d+(?:\.\d+)?/g;
                var number = regex.exec(str.trim().replace(/\,/g, ''));
                if (number !== null)
                    return parseFloat(number[0]);
            }

        window.findGetParameter = function (parameterName) {
            var result = null,
                tmp = [];
            var items = location.search.substr(1).split("&");
            for (var index = 0; index < items.length; index++) {
                tmp = items[index].split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            }
            return result;
        }

    });

})(jQuery);