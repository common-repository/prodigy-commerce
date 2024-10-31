/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./web/admin/js/pages/attributes-filter.js":
/*!*************************************************!*\
  !*** ./web/admin/js/pages/attributes-filter.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  let list_filters = $('.js-list-attributes-widget-filter');
  $(document).on('click', '.button-link-delete.widget-control-remove', function (e) {
    let id_widget = $(this).closest('div.widget').attr('id');
    let myRe = /filters_prodigy_widget/g;
    let info = myRe.test(id_widget);
    if (info === true) {
      list_filters.val(null).trigger('change');
      list_filters.select2('destroy');
      list_filters.off('select2:select');
    }
  });
  $(document).on('click', '.widgets-chooser-add', function (e) {
    let id_widget = $(this).parent().parent().parent().attr('id');
    let myRe = /filters_prodigy_widget/g;
    let info = myRe.test(id_widget);
    if (info === true) {
      list_filters.select2({
        width: '100%'
      });
    }
  });
})(jQuery);

/***/ }),

/***/ "./web/admin/js/pages/attributes-list.js":
/*!***********************************************!*\
  !*** ./web/admin/js/pages/attributes-list.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  var prodigy_admin_attributes = {
    init: function () {
      this.get_page_content();
      this.set_sortable();
      this.set_attributes_search_parameters();
      this.mobile_cell_btn();
    },
    set_attributes_search_parameters: function () {
      var self = this;
      var search = self.prodigyGetUrlParam('search');
      if (typeof search !== 'undefined' && search !== 0) {
        $('.admin-attributes-search-js').val(self.prodigyGetUrlParam('search'));
      }
      $(document).on('click', '.admin-submit-attributes-search-js', function () {
        self.set_attributes_search_params();
      });
    },
    prodigyGetUrlParam: function (name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results == null) {
        return null;
      }
      return decodeURI(results[1]) || 0;
    },
    set_attributes_search_params: function () {
      var search_value = $('.admin-attributes-search-js').val();
      var newParams = [['search', search_value]];
      var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
      history.pushState('', '', newUrl);
      document.location.reload();
      $('.admin-attributes-search-js').val(search_value);
    },
    set_sortable: function () {
      $(document).on('click', '.sortable', function () {
        var sort_value = $(this).attr('data-sort');
        if ($('.sortable').hasClass('desc')) {
          $(this).removeClass('desc');
          var newParams = [['sort', sort_value + '_asc']];
        } else {
          $(this).removeClass('asc');
          var newParams = [['sort', '-' + sort_value + '_desc']];
        }
        var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
        history.pushState('', '', newUrl);
        document.location.reload();
      });
    },
    get_page_content: function () {
      let query = window.location.search.slice(1) + '&nonce=' + admin_data.nonce;
      $.ajax({
        type: "GET",
        url: ajaxurl + '?action=prodigy-get-attributes-content&' + query,
        cache: false,
        success: function (response) {
          if (response.data.attributes != null && typeof response.data.attributes.data != "undefined") {
            if (response.data.attributes.data.length === 0) {
              $('.no-result-attributes-list-js').append('<p>No attributes found</p>');
            }
          }
          if (typeof response.data.search !== "undefined") $('.admin-attributes-search-js').val(response.data.search);
          $('.main-attributes-container-js').html(response.data.template);
          $('.attributes-pagination-js').html(response.data.pagination);
        }
      });
    },
    mobile_cell_btn: function () {
      $(document).on('click', '.prodigy-primary-cell__btn', evt => {
        $(evt.currentTarget).toggleClass('prodigy-primary-cell__btn--show').parent().find('.prodigy-primary-cell__mobile-content').toggleClass('prodigy-primary-cell__mobile-content--show');
      });
    }
  };
  window.prodigyAdminAttributes = prodigy_admin_attributes;
})(jQuery, window);

/***/ }),

/***/ "./web/admin/js/pages/categories-list.js":
/*!***********************************************!*\
  !*** ./web/admin/js/pages/categories-list.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  var prodigy_admin_categories = {
    init: function () {
      this.get_categories_page_content();
      this.set_categories_search_parameters();
      this.mobile_cell_btn();
    },
    set_categories_search_parameters: function () {
      var self = this;
      var search = this.prodigyGetUrlParam('search');
      if (typeof search !== 'undefined' && search !== 0) {
        $('.admin-categories-search-js').val(this.prodigyGetUrlParam('search'));
      }
      $(document).on('click', '.admin-submit-categories-search-js', function () {
        self.set_categories_search_params();
      });
    },
    prodigyGetUrlParam: function (name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results == null) {
        return null;
      }
      return decodeURI(results[1]) || 0;
    },
    set_categories_search_params: function () {
      var search_value = $('.admin-categories-search-js').val();
      var newParams = [['search', search_value]];
      var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
      history.pushState('', '', newUrl);
      document.location.reload();
      $('.admin-categories-search-js').val(search_value);
    },
    get_categories_page_content: function () {
      var query = window.location.search.slice(1);
      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
          action: 'prodigy-get-categories-content',
          query: query,
          nonce: admin_data.nonce
        },
        cache: false,
        success: function (response) {
          if (response.data.data != null && typeof response.data.data != "undefined") {
            if (response.data.data.length === 0) {
              $('.no-result-categories-list-js').append('<p>No categories found</p>');
            }
          }
          if (typeof response.data.search !== "undefined") {
            $('.admin-categories-search-js').val(response.data.search);
          }
          $('.main-categories-container-js').html(response.data.categories);
        }
      });
    },
    mobile_cell_btn: function () {
      $(document).on('click', '.prodigy-primary-cell__btn', evt => {
        $(evt.currentTarget).toggleClass('prodigy-primary-cell__btn--show').parent().find('.prodigy-primary-cell__mobile-content').toggleClass('prodigy-primary-cell__mobile-content--show');
      });
    }
  };
  window.prodigyAdminCategories = prodigy_admin_categories;
})(jQuery, window);

/***/ }),

/***/ "./web/admin/js/pages/prodigy-settings.js":
/*!************************************************!*\
  !*** ./web/admin/js/pages/prodigy-settings.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  var exeption_slugs = ['attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category', 'category__and', 'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup', 'customize_messenger_channel', 'customized', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'fields', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nonce', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'theme', 'type', 'w', 'withcomments', 'withoutcomments', 'year'];
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
  function setToggles() {
    let $toggler = $('[prodigy-toggle]', document);
    $toggler.on('change', function (e) {
      let selector = $(this).attr('prodigy-toggle');
      let $target = $(selector);
      if ($target.length) {
        if ($(this).prop('checked') === true) {
          $target.show();
        } else {
          $target.hide();
        }
      }
    });
    $toggler.trigger('change');
  }
  function setPagesAutocomplete() {
    let url = ajaxurl + '?action=prodigy-get-pages&nonce=' + admin_data.nonce;
    $('.prodigy-init-page-select').select2({
      ajax: {
        url: url,
        dataType: 'json',
        processResults: function (data) {
          return {
            results: data.data.items
          };
        }
      },
      allowClear: true,
      height: '34px',
      placeholder: 'select page..',
      minimumInputLength: 3,
      multiple: false,
      width: 400
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
          required: true
        },
        pg_captcha_secret_key: {
          required: true
        }
      },
      submitHandler: function (form) {
        if ($(form).valid()) {
          form.submit();
          showMessage($('button[type=submit]'));
        } else {
          $('html, body').animate({
            scrollTop: $('form .form-error-input').offset().top - 300
          }, 200);
          return false;
        }
      }
    });
    $.validator.addMethod("regex", function (value, element, regexp) {
      return this.optional(element) || regexp.test(value) && $.inArray(value, exeption_slugs);
    }, "Please check your input.");
  }
  function clear_cache_ajax() {
    var post_data = {
      action: 'prodigy-cache-clear',
      is_clear: true,
      nonce: admin_data.nonce
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
      nonce: admin_data.nonce
    };
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: post_data,
      cache: false,
      success: function (response) {}
    });
  }
  function check_sync_status() {
    var myVar = setInterval(function () {
      var post_data = {
        action: 'prodigy-check-sync-status'
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
    }, 2000);
  }
  function sync_error_notification() {
    return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-error is-dismissible"><p>' + plugin_path_dir.sync_notification_message + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
  }
  function sync_success_notification() {
    return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-success is-dismissible"><p>Synchronization of products completed successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
  }
  function setExpirationTimeSetting() {
    var expiration_time_input = $('.expiration-custom-js');
    expiration_time_input.inputmask('integer', {
      max: 9999,
      rightAlign: false,
      placeholderText: 'from 1h to 9999h'
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
      max: 9999,
      rightAlign: false,
      placeholderText: 'from 1s to 9999s'
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
        });
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
        }
      }
    });
  }
  function showMessage(button) {
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
    let current_form = prodigyGetUrlParam('tab');
    let isShowConfirm = false;
    window.isDirty = false;
    $('#' + current_form + '-form :input:not([type=submit])').each(function () {
      if ($(this).is(':radio') || $(this).is(':checkbox')) {
        var checked = $(this).is(':checked') ? 'checked' : 'unchecked';
        $(this).data('initialValue', checked);
      } else {
        $(this).data('initialValue', $(this).val());
      }
    });
    $('a').click(function (event) {
      window.isDirty = false;
      let currentValue = null;
      $('#' + current_form + '-form :input:not([type=submit])').each(function () {
        if ($(this).is(':radio') || $(this).is(':checkbox')) {
          currentValue = $(this).is(':checked') ? 'checked' : 'unchecked';
        } else {
          currentValue = $(this).val();
        }
        if ($(this).data('initialValue') !== currentValue) {
          window.isDirty = true;
        }
      });
      if (window.isDirty === true) {
        let currentUrl = document.URL;
        if (currentUrl.indexOf('prodigy_settings') != -1) {
          event.preventDefault();
          $('#saveModal').dialog('open');
        }
      } else {
        window.isDirty = false;
      }
      let url = $(this).attr('href');
      if (!url.startsWith('http') && !url.startsWith('/wp-admin')) {
        url = '/wp-admin/' + url;
      }
      $(document).on("click", '.settings-button-save', function () {
        let $form = $('#' + current_form + '-form');
        let data = $form.serialize();
        $.post(window.location.href, data, function () {
          window.location.href = url;
        });
      });
      $('.close-setting-popup').click(url, function (e) {
        e.preventDefault();
        window.location.href = url;
      });
    });
  }
});

/***/ }),

/***/ "./web/admin/js/pages/product-list.js":
/*!********************************************!*\
  !*** ./web/admin/js/pages/product-list.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  var prodigy_admin_products = {
    init: function () {
      if (admin_data.is_have_sync_notification == 1) {
        this.check_sync_status();
      }
      this.get_products_content();
      this.set_product_search_parameters();
      this.set_sortable();
      this.mobile_cell_btn();
      this.launch_sync_process();
      this.close_notification();
    },
    close_notification: function () {
      $(document).on('click', '.notice-dismiss', function () {
        $(this).closest(".prodigy-admin-custom-template-notice").remove();
      });
    },
    set_sortable: function () {
      $(document).on('click', '.sortable', function () {
        var sort_value = $(this).attr('data-sort');
        if ($('.sortable').hasClass('desc')) {
          $(this).removeClass('desc');
          var newParams = [['sort', sort_value + '_asc']];
        } else {
          $(this).removeClass('asc');
          var newParams = [['sort', '-' + sort_value + '_desc']];
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
        url: ajaxurl + '?action=prodigy-get-products-content&' + query,
        cache: false,
        success: function (response) {
          if (response.data.products != null && typeof response.data.products != "undefined") {
            if (response.data.products.length === 0) {
              $('.not-result-products-list-js').append('<p>No products found</p>');
            }
          }
          if (typeof response.data.search !== "undefined") $('.admin-product-search-js').val(response.data.search);
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
    prodigyGetUrlParam: function (name) {
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results == null) {
        return null;
      }
      return decodeURI(results[1]) || 0;
    },
    set_product_search_params: function () {
      var search_value = $('.admin-product-search-js').val();
      var newParams = [['search', search_value]];
      var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
      history.pushState('', '', newUrl);
      document.location.reload();
      $('.admin-product-search-js').text(search_value);
    },
    mobile_cell_btn: function () {
      $(document).on('click', '.prodigy-primary-cell__btn', evt => {
        $(evt.currentTarget).toggleClass('prodigy-primary-cell__btn--show').parent().find('.prodigy-primary-cell__mobile-content').toggleClass('prodigy-primary-cell__mobile-content--show');
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
          action: 'prodigy-check-sync-status'
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
            if (response.data != null && typeof response.data.status !== undefined) {
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
      }, 2000);
    },
    sync_error_notification: function () {
      return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-error is-dismissible"><p>' + plugin_path_dir.sync_notification_message + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
    },
    sync_success_notification: function () {
      return '<div class="prodigy-admin-custom-template-notice"><div class="notice notice-success is-dismissible"><p>Synchronization of products completed successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div></div>';
    },
    start_process: function () {
      var post_data = {
        action: 'prodigy-start-sync-process',
        sync: true,
        nonce: admin_data.nonce
      };
      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: post_data,
        cache: false,
        success: function (response) {}
      });
    }
  };
  window.prodigyAdminProducts = prodigy_admin_products;
})(jQuery, window);

/***/ }),

/***/ "./web/admin/scss/application.scss":
/*!*****************************************!*\
  !*** ./web/admin/scss/application.scss ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./web/admin/js/pages/prodigy-settings.js ./web/admin/js/pages/product-list.js ./web/admin/js/pages/attributes-list.js ./web/admin/js/pages/categories-list.js ./web/admin/js/pages/attributes-filter.js ./web/admin/scss/application.scss ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./web/admin/js/pages/prodigy-settings.js */"./web/admin/js/pages/prodigy-settings.js");
__webpack_require__(/*! ./web/admin/js/pages/product-list.js */"./web/admin/js/pages/product-list.js");
__webpack_require__(/*! ./web/admin/js/pages/attributes-list.js */"./web/admin/js/pages/attributes-list.js");
__webpack_require__(/*! ./web/admin/js/pages/categories-list.js */"./web/admin/js/pages/categories-list.js");
__webpack_require__(/*! ./web/admin/js/pages/attributes-filter.js */"./web/admin/js/pages/attributes-filter.js");
module.exports = __webpack_require__(/*! ./web/admin/scss/application.scss */"./web/admin/scss/application.scss");


/***/ })

/******/ });
//# sourceMappingURL=admin.js.map