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

/***/ "./web/templates/js/navigation.js":
/*!****************************************!*\
  !*** ./web/templates/js/navigation.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  var container, button, menu, links, i, len;
  container = document.getElementById('site-navigation');
  if (!container) {
    return;
  }
  button = container.getElementsByTagName('button')[0];
  if ('undefined' === typeof button) {
    return;
  }
  menu = container.getElementsByTagName('ul')[0];

  // Hide menu toggle button if menu is empty and return early.
  if ('undefined' === typeof menu) {
    button.style.display = 'none';
    return;
  }
  menu.setAttribute('aria-expanded', 'false');
  if (-1 === menu.className.indexOf('nav-menu')) {
    menu.className += ' nav-menu';
  }
  button.onclick = function () {
    if (-1 !== container.className.indexOf('toggled')) {
      container.className = container.className.replace(' toggled', '');
      button.setAttribute('aria-expanded', 'false');
      menu.setAttribute('aria-expanded', 'false');
    } else {
      container.className += ' toggled';
      button.setAttribute('aria-expanded', 'true');
      menu.setAttribute('aria-expanded', 'true');
    }
  };

  // Get all the link elements within the menu.
  links = menu.getElementsByTagName('a');

  // Each time a menu link is focused or blurred, toggle focus.
  for (i = 0, len = links.length; i < len; i++) {
    links[i].addEventListener('focus', toggleFocus, true);
    links[i].addEventListener('blur', toggleFocus, true);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    var self = this;

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while (-1 === self.className.indexOf('nav-menu')) {
      // On li elements toggle the class .focus.
      if ('li' === self.tagName.toLowerCase()) {
        if (-1 !== self.className.indexOf('focus')) {
          self.className = self.className.replace(' focus', '');
        } else {
          self.className += ' focus';
        }
      }
      self = self.parentElement;
    }
  }

  /**
   * Toggles `focus` class to allow submenu access on tablets.
   */
  (function (container) {
    var touchStartFn,
      i,
      parentLink = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');
    if ('ontouchstart' in window) {
      touchStartFn = function (e) {
        var menuItem = this.parentNode,
          i;
        if (!menuItem.classList.contains('focus')) {
          e.preventDefault();
          for (i = 0; i < menuItem.parentNode.children.length; ++i) {
            if (menuItem === menuItem.parentNode.children[i]) {
              continue;
            }
            menuItem.parentNode.children[i].classList.remove('focus');
          }
          menuItem.classList.add('focus');
        } else {
          menuItem.classList.remove('focus');
        }
      };
      for (i = 0; i < parentLink.length; ++i) {
        parentLink[i].addEventListener('touchstart', touchStartFn, false);
      }
    }
  })(container);
})();

/***/ }),

/***/ "./web/templates/js/scripts/analytics.js":
/*!***********************************************!*\
  !*** ./web/templates/js/scripts/analytics.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  if (settings.pg_google_track_id !== '') {
    $(document).on("click", ".category-filter-js", function () {
      var value = $(this).text().trim();
      gtag('event', 'set_attribute_filter', {
        "event_category": 'prodigy_product_catalog',
        "event_label": 'set_attribute_filter',
        "value": value
      });
    });
    $(document).on("click", ".attribute-filter-js", function () {
      var value = $(this).text().trim();
      gtag('event', 'set_category_filter', {
        "event_category": 'prodigy_product_catalog',
        "event_label": 'set_category_filter',
        "value": value
      });
    });
    $(document).on("click", ".remove-item-js, .widget-remove-item-js", function () {
      var item = [];
      item.push($(this).data('cart-item'));
      item.push({
        quantity: $('counter-count-js').val()
      });
      gtag('event', 'remove_from_cart', {
        "event_category": 'prodigy_ecommerce',
        "items": item[0]
      });
    });
    $(document).on("click", "button.checkout-button-js", function () {
      var items = [];
      $('.cart-item-js').each(function (key, item) {
        var item = $(this).data('cart-item');
        item.quantity = $(this).find('.counter-count-js').val();
        items.push(item);
      });
      var cart_items = [];
      gtag('event', 'begin_checkout', {
        "event_category": 'prodigy_ecommerce',
        "items": items
      });
    });
  }
})(jQuery, window);

/***/ }),

/***/ "./web/templates/js/scripts/cart-load.js":
/*!***********************************************!*\
  !*** ./web/templates/js/scripts/cart-load.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  let prodigy_remote_cart = {
    init: function () {
      // this.get_remote_cart();
    },
    get_remote_cart: function () {
      let self = this;
      let post_data = {
        action: "prodigy-remote-get-template-cart"
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
        responsive: [{
          breakpoint: 767,
          settings: {
            variableWidth: false,
            slidesToShow: 3,
            slidesToScroll: 3
          }
        }, {
          breakpoint: 1168,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            variableWidth: false,
            arrows: true
          }
        }]
      });
    },
    check_empty_cart_load_remote: function () {
      $('.prodigy-cart-container-js .row').hide();
      $('.empty-cart-js').show();
      if (settings.is_deleted_product) {
        $('.widget-cart-message-error-js').show();
      }
    }
  };
  window.prodigyRemoteCart = prodigy_remote_cart;
})(jQuery, window);
jQuery(function ($) {
  window.prodigyRemoteCart.init();
});

/***/ }),

/***/ "./web/templates/js/scripts/filter.js":
/*!********************************************!*\
  !*** ./web/templates/js/scripts/filter.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  'use strict';

  $(document).ready(function () {
    init();
    function init() {
      filter_handler();
      set_sortable();
      reset_filters();
      clear_params();
      apply_filters();
      set_price_filter();
      set_sidebar();
      close_active_filter();
      remove_filter_storage();
      set_filters();
      if (is_elementor_template()) {
        set_elementor_filter_mode();
      }
      set_custom_select();
    }
    function get_shop_page_id() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('page_id');
    }
    function set_number_of_columns_by_screen_resolution() {
      $('.prodigy-product-list__grid').removeClass('d-none');
      let windowWidth = screen.width;
      let default_number_of_columns = settings.customizer_product_columns;
      let number_of_columns = 1;
      if (windowWidth >= 1440) {
        number_of_columns = default_number_of_columns;
      } else if (windowWidth >= 1024) {
        number_of_columns = default_number_of_columns >= 4 ? 4 : default_number_of_columns;
      } else if (windowWidth >= 768) {
        number_of_columns = default_number_of_columns >= 3 ? 3 : default_number_of_columns;
      } else if (windowWidth >= 375) {
        number_of_columns = default_number_of_columns >= 2 ? 2 : default_number_of_columns;
      }
      $('.shop-resolution-js').addClass('prodigy-product-list__grid-' + number_of_columns);
    }
    function is_elementor_template() {
      return $('.elementor-widget-pae-archive-products').length > 0;
    }
    function is_show_active_filter() {
      return $('.elementor-show-active-filter-js').val();
    }
    function set_elementor_filter_mode() {
      $('.prodigy-filter__sm-btn-js').click(function () {
        $('.prodigy-filter-js').show();
        $('.prodigy-filter__accordion-header-js').show();
        $('.prodigy-shop-sidebar').toggleClass('prodigy-shop-sidebar--open');
      });
    }
    function set_filters() {
      $('.attribute-filter-js').each(function () {
        if ($(this).is(':checked')) {
          let attribute_name = $(this).data('attribute-id');
          let attribute_value = $(this).data('attribute-value');
          load_filters(attribute_name, attribute_value);
        }
      });
    }
    function remove_filter_storage() {
      sessionStorage.removeItem('filter');
    }
    function close_active_filter() {
      $(document).on('click', '.filter-close-js', function () {
        let element = $(this).closest('.prodigy-main-badge');
        let attribute_id = element.data("attribute-id");
        let attribute_value = element.data('attribute-slug');
        unset_filter(attribute_id, attribute_value);
        get_catalog_filters(build_query(), $(this).closest('.elementor-widget-pae-attributes'));
        get_catalog_products(build_query());
      });
    }
    function set_sidebar() {
      const filterToggleBtnHandler = () => {
        $('#filter-toggle-btn').toggleClass('prodigy-shop-sidebar-btn--show');
        $('#filter').toggleClass('prodigy-shop-sidebar--open');
      };
      $('body').on('click', '#filter-toggle-btn, #filter-toggle-btn-2, #shop-sidebar-backdrop-js', filterToggleBtnHandler);
    }
    function set_loader() {
      $('.prodigy-loader-wrapper').show();
      $('.prodigy-loader-wrapper').attr("style", "display:flex");
      $('.prodigy-loader-wrapper').find('*').addClass('pointer-events-none');
    }
    function remove_loader() {
      $('.prodigy-loader-wrapper').hide();
      $('.prodigy-loader-wrapper').find('*').removeClass('pointer-events-none');
    }
    function set_price_filter() {
      $(document).on('click', '.price-filter-submit-js', function (e) {
        let price_max = prodigyGetUrlParam('price_max');
        let price_min = prodigyGetUrlParam('price_min');
        let price_query = '';
        if (price_min && price_min) {
          price_query = 'price_max=' + price_max + '&' + 'price_min=' + price_min;
        }
        sessionStorage.setItem('price-range', price_query);
        get_catalog_filters(build_query(), $(this).closest('.elementor-widget-pae-attributes'));
        get_catalog_products(build_query());
      });
    }
    function apply_filters() {
      $(document).on('click', '.attribute-filter-js', function (e) {
        let attribute_id = $(this).data('attribute-id');
        let attribute_value = $(this).data('attribute-value');
        if ($(this).is(':checked')) {
          set_filters();
        } else {
          unset_filter(attribute_id, attribute_value);
        }
        get_catalog_filters(build_query(), $(this).closest('.elementor-widget-pae-attributes'));
        get_catalog_products(build_query());
      });
    }
    function clear_params() {
      $(document).on('click', '.clear-params-js', function (e) {
        sessionStorage.removeItem('price-range');
        sessionStorage.removeItem('catalog-sortable');
        clear_url_params();
        set_loader();
      });
      if (window.location.search === '') {
        sessionStorage.removeItem('price-range');
        sessionStorage.removeItem('catalog-sortable');
      }
      remove_loader();
    }
    function reset_filters() {
      $(document).on('click', '.filter-reset-js', function () {
        clear_url_params();
      });
    }
    function clear_url_params() {
      remove_filter_storage();
      if (get_shop_page_id() !== null) {
        window.location.href = window.location.origin + '?page_id=' + get_shop_page_id();
      } else {
        window.location.href = window.location.href.split("?")[0];
      }
    }
    function build_query() {
      let filter = sessionStorage.getItem('filter');
      let params = JSON.parse(filter);
      let filter_query = jQuery.param(params);
      let price_query = sessionStorage.getItem('price-range');
      let total_query = '';
      if (price_query !== null) {
        total_query = filter_query + '&' + price_query;
      } else {
        total_query = filter_query;
      }
      if (get_shop_page_id() !== null) {
        total_query = 'page_id=' + get_shop_page_id() + '&' + total_query;
      }
      if (total_query !== '') {
        history.pushState('', '', '?' + total_query);
      } else {
        history.pushState(null, null, window.location.pathname);
      }
      let category_name = $('.category-name-js').val();
      let category_slug = $('.slug-name-js').val();
      let current_url = window.location.href;
      if (category_name && category_slug) {
        total_query = total_query + '&tax_name=' + category_name + '&tax_slug=' + category_slug;
      }
      total_query = total_query + '&current_url=' + current_url;
      return total_query;
    }
    function get_catalog_products(query) {
      let widget_id = $('.filter-widget-id').val();
      let category = $('.prodigy-category-slug-js').val();
      let category_type = $('.prodigy-category-type-js').val();
      $('.prodigy-product-list__grid').addClass('prodigy__is-loading');
      set_loader();
      let ajax_url = ajaxurl + '?action=prodigy-load-shop-products&' + query + '&tax_slug=' + category + '&tax_name=' + category_type;
      if (typeof widget_id !== 'undefined') {
        ajax_url = ajaxurl + '?action=prodigy-load-shop-products&' + query + '&filter_widget_id=' + widget_id + '&tax_slug=' + category + '&tax_name=' + category_type;
      }
      $.ajax({
        type: "GET",
        url: ajax_url,
        cache: false,
        dataType: "json",
        success: function (response) {
          $('.prodigy-product-list__grid').removeClass('prodigy__is-loading');
          remove_loader();
          $('.prodigy-pagination-shop-js').html(response.data.pagination_list);
          let empty_products = $(response.data.products).find('.shop-page-container-empty-js');
          if (empty_products.length > 0 || !is_elementor_template()) {
            let products = $(response.data.products).find('.shop-page-container-js');
            $('.shop-page-container-js').replaceWith(products);
          } else {
            let products = $(response.data.products).find('.prodigy-product-list__grid');
            let no_results = $(document).find('.shop-page-container-empty-js');
            let container = '.prodigy-product-list__grid';
            if (no_results.length > 0) {
              container = '.shop-page-container-empty-js';
            }
            $(container).replaceWith(products);
          }
          set_number_of_columns_by_screen_resolution();
        }
      });
    }
    function get_catalog_filters(query, container) {
      let widget_id = $(container).data('id');
      let category = $('.prodigy-category-slug-js').val();
      let category_type = $('.prodigy-category-type-js').val();
      let ajax_url = ajaxurl + '?action=prodigy-load-shop-filters&' + query + '&tax_slug=' + category + '&tax_name=' + category_type + '&filter_widget_id=' + widget_id;
      if (typeof widget_id !== 'undefined') {
        ajax_url = ajaxurl + '?action=prodigy-load-shop-filters&' + query + '&filter_widget_id=' + widget_id + '&tax_slug=' + category + '&tax_name=' + category_type;
      }
      $.ajax({
        type: "GET",
        url: ajax_url,
        cache: false,
        dataType: "json",
        success: function (response) {
          $('.catalog-sort-js').html($(response.data.sort).html());
          let empty_products = $(response.data.products).find('.shop-page-container-empty-js');
          if (empty_products.length > 0 || !is_elementor_template()) {
            if ($('.prodigy-filter__badges').length > 0) {
              $('.prodigy-filter__badges').closest('.prodigy-filter__main').remove();
              $('.prodigy-filter__badges').remove();
            }
            $('.prodigy-filter__main').first().before(response.data.active);
            $('.prodigy-filter-title-js').html(response.data.filters);
          } else {
            let filters = $(response.data.filters).closest('.prodigy-filter-js');
            $('.prodigy-filter-js').replaceWith(filters);
            if (is_show_active_filter()) {
              if ($('.active-filter-js').length > 0) {
                $('.active-filter-js').html(response.data.active);
              } else {
                if ($('.prodigy-filter__sm-btn-js').is(':visible')) {
                  $('.prodigy-filter-by-title-js').before(response.data.active);
                } else {
                  $('.prodigy-filter-title-js').eq(0).before(response.data.active);
                }
              }
              $('.price-filter-container-js').html(response.data.price_filter);
              let price_filter = $(response.data.price_filter).find('.js-range-slider');
              $(document).find('.min-js').val($(price_filter).attr('data-min'));
              $(document).find('.max-js').val($(price_filter).attr('data-max'));
            }
            if ($('.prodigy-main-badge__val').length === 0) {
              $('.active-filter-js').remove();
            }
          }
          let price_filter_container = $('.price-filter-container-js');
          if (price_filter_container.length !== 0) {
            price_filter_container.html(response.data.price);
            window.slider_widget.init(response.data.min_price, response.data.max_price, response.data.query_min_price, response.data.query_max_price);
          }
          set_custom_select();
        }
      });
    }
    function set_custom_select() {
      $(document).find('.prodigy-custom-select').styler({
        onFormStyled: function () {
          $(document).find('.jq-selectbox__select-text').each(function () {
            const width = $(this).closest('.jq-selectbox').find('select').width();
            // $(this).width(width);
          });
        }
      });
    }
    function set_sortable() {
      $(document).on('click', '.catalog-page-sort-js', function () {
        if (navigator.platform.indexOf("iPhone") != -1 || navigator.platform.indexOf("iPod") != -1) {
          $("select.catalog-page-sort-js").remove();
        }
        $('.catalog-page-device-sort-js').addClass('prodigy-select-md--open');
      });
      $(document).on('change', '.catalog-page-sort-js', function () {
        var sort = $(this).children("option:selected").val();
        if (typeof sort !== 'undefined') {
          sessionStorage.setItem('catalog-sortable', sort.replace(/\?/g, '&'));
          var newParams = [['sort', sort]];
          var newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);
          history.pushState('', '', newUrl);
          document.location.reload();
        }
      });
      $(document).on('change', '.sort-radio-js', function () {
        $('.sort-radio-js').each(function () {
          if ($(this).is(':checked')) {
            var sort = $(this).val();
            if (typeof sort !== undefined) {
              sessionStorage.setItem('catalog-sortable', sort.replace(/\?/g, '&'));
              var newParams = [['sort', sort]];
              var newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);
              history.pushState('', '', newUrl);
              document.location.reload();
            }
          }
        });
      });
      $('body, .catalog-page-device-sort-close-js').click(function () {
        $('.catalog-page-device-sort-js').removeClass('prodigy-select-md--open');
      });
      $('.prodigy-select-md__wrap').click(function (event) {
        event.stopPropagation();
      });
    }
    function unset_filter(id, attribute) {
      let filter = sessionStorage.getItem('filter');
      let params = JSON.parse(filter);
      if (params === null) {
        sessionStorage.removeItem('filter');
      } else {
        let values = '';
        if (typeof params['attr'] !== 'undefined' && typeof params['attr'][id] !== 'undefined') {
          values = params['attr'][id].split(';');
          values.forEach(function (value, key) {
            if (attribute == value) {
              values.splice(key, 1);
            }
          });
        }
        if (values.length > 0) {
          let values_str = values.join(';');
          params['attr'][id] = values_str;
        } else {
          delete params['attr'][id];
        }
        sessionStorage.setItem('filter', JSON.stringify(params));
      }
      if (id === 'Price') {
        sessionStorage.removeItem('price-range');
      }
      uncheck_filter_checkbox(id, attribute);
    }
    function uncheck_filter_checkbox(id, attribute) {
      $('.attribute-filter-js').each(function () {
        if ($(this).data('attribute-id') == id && $(this).data('attribute-name') == attribute) {
          $(this).removeAttr('checked');
        }
      });
    }
    function load_filters(id, value) {
      let sort = findGetParameter('sort');
      let filter = sessionStorage.getItem('filter');
      let params = JSON.parse(filter);
      if (params !== null && Object.keys(params['attr']).length !== 0) {
        $.each(params['attr'], function (i, item) {
          let parts = item.split(";");
          if (i == id && parts.indexOf(value.toString()) === -1) {
            params['attr'][id] = item + ';' + value.toString();
          }
        });
      }
      if (params === null || Object.keys(params['attr']).length === 0) {
        params = {};
        params['attr'] = {};
        params['attr'][id] = value.toString();
      } else if (typeof params['attr'][id] === 'undefined') {
        params['attr'][id] = value.toString();
      }
      if (sort !== undefined && sort !== null) {
        params['sort'] = sort;
      }
      sessionStorage.setItem('filter', JSON.stringify(params));
    }
    function filter_handler() {
      // show more/less filter values
      $(document).on('click', '.filter__btn-js', function () {
        const id_attr = $(this).data('id');
        const list = $('.filter__item-list-js#filter_attr_' + id_attr);
        const listItems = list.find('.prodigy-filter__item-list-li, .prodigy-filter__card-list-item');
        const btnText = $(this).find('.filter__btn-txt-js');
        const listOpenClass = 'active';
        const moreText = 'Show more';
        const lessText = 'Show less';
        const countShow = list.data('count-show');
        $(this).toggleClass(listOpenClass);
        if ($(this).hasClass(listOpenClass)) {
          btnText.text(lessText);
          listItems.show();
        } else {
          btnText.text(moreText);
          listItems.each(function (i) {
            if (i + 1 > countShow) {
              $(this).hide();
            }
          });
        }
      });
    }
  });
})(jQuery, window);

/***/ }),

/***/ "./web/templates/js/scripts/product-bulk.js":
/*!**************************************************!*\
  !*** ./web/templates/js/scripts/product-bulk.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  let prodigy_product_bulk = {
    enable_bulk_element: '.enable-bulk-js',
    add_to_cart_button: "button.add-to-cart-js",
    bulk_container_general: '.bulk-container-js',
    bulk_container: '.bulk-container-',
    variant_container: '.variant-container-',
    swatch_variant_container: '.swatch-variant-container-',
    button_disable_bulk: '.disable-bulk-button-js',
    link_disable_bulk: '.disable-bulk-js',
    bulk_modal: '#disableBulkModal',
    counter_element: '.prodigy-counter-wrap-js',
    bulk_total_block: '.bulk-total-block-js',
    close_bulk_modal: '.close-bulk-modal-js',
    replaced_hidden_option: '',
    disable_bulk_modal_text: '.disable-bulk-modal-text-js',
    disable_bulk_link_element: '.disable-bulk-link-js',
    is_active_logo_bulk: false,
    is_active_bulk: false,
    bulk_container_element: '.bulk-container-js',
    input_bulk_quantity_element: '.prodigy-bulk-input-js',
    bulk_price_modifier_element: '.bulk-price-modify-js',
    bulk_stock_status: '.stock-indicator-label-js',
    bulk_stock_qty: '.stock-indicator-qty-js',
    bulkVariants: [],
    bulkTotalQuantity: 0,
    bulk_total_price: '.bulk-total-price-js',
    _stock_status_mapper: {
      "in_stock": "In stock",
      "out_of_stock": "Out of stock"
    },
    total_quantity_element: '.prodigy-bulk-total-qty-js',
    init: function () {
      if (this.is_bulk()) {
        this.set_quantity_validation();
      }
      this.bulk_showing_manager();
    },
    reset_bulk_inputs: function () {
      $(prodigyProductBulk.input_bulk_quantity_element).each(function () {
        $(this).val('');
      });
      $(this.total_quantity_element).text(0);
      $(this.bulk_total_price).text('$0.00');
    },
    update_bulk_price: function (data) {
      let total_price = 0;
      for (let key in data.result) {
        let product_quantity = data.result[key].number_of_items;
        if (typeof data.result[key].attributes !== "undefined") {
          let price = data.result[key].attributes.price;
          let sale_price = data.result[key].attributes['sale-price'];
          let tiered_price = data.result[key].attributes.tiered_price;
          if (product_quantity === 0) {
            this.reset_bulk_inputs();
            return;
          }
          total_price += prodigyProduct.calculate_product_price(price, sale_price, tiered_price, product_quantity);
        }
      }
      if (typeof data !== "undefined") {
        $(this.bulk_total_price).text('$' + prodigy_price_format(total_price));
        $('.product-default-info-price-js').text('$' + total_price);
      }
    },
    is_bulk: function () {
      return $(this.enable_bulk_element).is(":visible");
    },
    is_bulk_enabled: function () {
      return $(this.bulk_container_general).is(":visible");
    },
    get_attr_name_with_bulk_enabled() {
      return $(this.bulk_container_general + ':visible').data('attribute');
    },
    open_bulk_options_mode: function (container) {
      let self = this;
      self.is_active_bulk = true;
      let attribute_name = container.data('attribute');
      if (typeof attribute_name === "undefined") {
        attribute_name = $('.bulk-container-js:visible').data('attribute');
      }
      prodigyProduct.set_variant_modifier(attribute_name);
      if (self.is_active_bulk) {
        prodigyProduct.show_available_variants_bulk(attribute_name);
        $(self.button_disable_bulk).data('attribute', self.get_attr_name_with_bulk_enabled());
        $(self.button_disable_bulk).data('show-attribute', attribute_name);
        $(self.disable_bulk_modal_text).text('Disable Multiple Quantity for ' + self.get_attr_name_with_bulk_enabled());
        if (attribute_name === product_logo_management_object.logo_attribute) {
          self.is_active_logo_bulk = true;
          $('.prodigy-product__main-price').hide();
          $(document).trigger('enable-multiple-quantity', container);
        }
      }
      if (self.is_bulk_enabled()) {
        $(self.bulk_modal).modal('show');
        return;
      }
      $('.attribute_values_js[data-attribute="' + attribute_name + '"]').addClass('ignored');
      $('.prodigy-product__swatch-block-js[data-attribute="' + attribute_name + '"]').addClass('ignored');
      self.hide_default_product_info();
      self.show_bulk_for_attr(attribute_name);
    },
    return_product_state: function () {
      $('.prodigy-product__main-price').show();
      $('.prodigy-product__prop-text').show();
      $('.main-price-currency-js').hide();
      $('.prodigy-product-stock-js').show();
      $('.prodigy-product__prop-wrap').show();
    },
    bulk_showing_manager: function () {
      let self = this;
      $(this.enable_bulk_element).on('click', function () {
        self.open_bulk_options_mode($(this));
      });
      $(this.close_bulk_modal).on('click', function () {
        $(self.bulk_modal).modal('hide');
      });
      $(this.disable_bulk_link_element).on('click', function () {
        debugger;
        let attribute_name = $(this).data('attribute');
        self.is_active_bulk = false;
        if (attribute_name === product_logo_management_object.logo_attribute) {
          self.is_active_logo_bulk = false;
          self.return_product_state();
        }
        if (self.is_active_bulk) {
          prodigyProduct.show_available_variants_bulk(attribute_name);
        }
        product_logo_management_object.update_locations_availability();
        $('.bulk-container-' + attribute_name + '-js').hide();
        $(self.variant_container + attribute_name + '-js').show();
        $('.disable-bulk-link-js[data-attribute="' + attribute_name + '"]').hide();
        $('.enable-bulk-js[data-attribute="' + attribute_name + '"]').show();
        self.show_price_bulk_block();
        $('.attribute_values_js[data-attribute="' + attribute_name + '"]').removeClass('ignored');
        $('.prodigy-product__swatch-block-js[data-attribute="' + attribute_name + '"]').removeClass('ignored');
        debugger;
        let slug = $('.attribute_values_js').find("option:selected").data('slug');
        prodigyProduct.set_gallery([{
          name: slug
        }], attribute_name);
      });
      $(this.link_disable_bulk).on('click', function () {
        let attribute_name = $(this).data('attribute');
        if (self.is_active_bulk) {
          prodigyProduct.show_available_variants_bulk(attribute_name);
        }
        $(self.button_disable_bulk).data('attribute', attribute_name);
        $(self.disable_bulk_modal_text).text('Enable Multiple Quantity for ' + attribute_name);
        $(self.bulk_modal).modal('show');
      });
      $(this.button_disable_bulk).on('click', function () {
        let attribute_name = $(this).data('attribute');
        $(self.bulk_modal).modal('hide');
        self.hide_bulk_for_attr(attribute_name);
        self.show_bulk_for_attr($(this).data('show-attribute'));
        $(this).removeData('attribute');
        $(this).removeData('show-attribute');
        self.show_price_bulk_block();
        self.reset_bulk_inputs();
        $('.attribute_values_js[data-attribute="' + attribute_name + '"]').removeClass('ignored');
        $('.prodigy-product__swatch-block-js[data-attribute="' + attribute_name + '"]').removeClass('ignored');
        self.show_default_product_info();
        $(document).trigger('enable-multiple-quantity', [this]);
        if (prodigyProduct.is_bulk()) {
          let bulk_attribute = $('.bulk-container-js:visible').data('attribute');
          prodigyProduct.set_variant_modifier(bulk_attribute);
        }
      });
    },
    show_default_product_info: function () {
      $('.prodigy-product__prop-wrap').show();
    },
    hide_default_product_info: function () {
      $('.prodigy-product__prop-wrap').hide();
    },
    hide_bulk_for_attr: function (attribute_name) {
      $(this.bulk_container + attribute_name + '-js').hide();
      $(this.variant_container + attribute_name + '-js').show();
      $(this.counter_element).show();
      $(this.bulk_total_block).hide();
    },
    show_bulk_for_attr: function (attribute_name) {
      $(this.variant_container + attribute_name + '-js').hide();
      $('.bulk-container-' + attribute_name + '-js').show();
      $('.enable-bulk-js[data-attribute="' + attribute_name + '"]').hide();
      $('.enable-bulk-js[data-attribute="' + attribute_name + '"]').closest('.prodigy-product__attr-text-label');
      $('.attribute_values_js[data-attribute="' + attribute_name + '"]').hide();
      $('.disable-bulk-link-js[data-attribute="' + attribute_name + '"]').show();
      $('.enable-bulk-' + attribute_name + '-js').hide();
      $(this.counter_element).hide();
      $(this.bulk_total_block).show();
      $(this.enable_bulk_element).each(function () {
        if ($(this).data('attribute') !== attribute_name) {
          $(this).show();
        }
      });
      $(this.disable_bulk_link_element).each(function () {
        if ($(this).data('attribute') !== attribute_name) {
          $(this).hide();
        }
      });
    },
    show_price_bulk_block: function () {
      let is_show_bulk_price_block = $('.bulk-container-js').is(":visible");
      if (is_show_bulk_price_block) {
        $('.prodigy-counter-wrap-js').hide();
        $('.bulk-total-block-js').show();
      } else {
        $('.bulk-total-block-js').hide();
        $('.prodigy-counter-wrap-js').show();
      }
    },
    set_quantity_validation: function () {
      $(this.input_bulk_quantity_element).inputmask({
        mask: '9{1,4}',
        regex: "^[1-9][0-9]*|$"
      });
    },
    activate_bulk_processes: function () {
      let active_bulk_attribute = $('.bulk-container-js:visible').data('attribute');
      this.set_bulk_data();
      prodigyProduct.set_active_bulk_attribute_name();
      prodigyProduct.show_available_variants_bulk(active_bulk_attribute);
      prodigyProduct.set_variant_modifier(active_bulk_attribute);
      if (this.is_active_logo_bulk) {
        $(document).trigger('enable-multiple-quantity');
      }
    },
    get_bulk_variant_data: function (variant, current_options) {
      let self = this;
      let post_data = {
        action: "prodigy-public-get-variant-multiple-data",
        post_id: $("#product_id").val(),
        variants: variant,
        bulk_attributes: current_options,
        nonce: settings.nonce
      };
      clearTimeout(self.timeoutMultipleDataId);
      self.timeoutMultipleDataId = setTimeout(function () {
        $.ajax({
          type: "post",
          data: post_data,
          dataType: "json",
          url: ajax_url,
          error: function (xhr, status, error) {},
          success: function (response) {
            self.set_variant_bulk_info(response);
            if (product_logo_management_object.is_logo() && !self.is_active_logo_bulk) {
              self.set_bulk_data();
            }
          }
        });
      }, 500);
    },
    set_bulk_data: function () {
      let self = this;
      let total_quantity = 0;
      let attribute_name = '';
      let bulkOptions = [];
      if (!prodigyProductBulk.is_active_logo_bulk) {
        if (prodigyProduct.is_swatches()) {
          prodigyProduct.set_checked_swatch();
        } else {
          prodigyProduct.set_attribute_value_options();
        }
      }
      let selected_variant = prodigyProduct.get_selected_variant();
      $(self.bulk_container_element).each(function (e) {
        let is_visible = $(this).is(':visible');
        let variant = '';
        if (is_visible) {
          $(this).find(self.input_bulk_quantity_element).each(function (e) {
            let bulk_input_value = parseInt($(this).val());
            if (!isNaN(bulk_input_value)) {
              total_quantity += bulk_input_value;
              attribute_name = $(this).data('option');
              variant = attribute_name + '&' + selected_variant.join("&");
              let obj = {
                variant: variant,
                quantity: bulk_input_value
              };
              bulkOptions.push(obj);
            }
          });
          $(self.total_quantity_element).text(total_quantity);
          if (prodigyProduct.is_validate_options()) {
            self.get_bulk_variants_data(total_quantity, bulkOptions);
          }
        }
      });
    },
    get_bulk_variants_data: function (quantity, selected_variant_options) {
      this.bulkVariants = selected_variant_options;
      this.bulkTotalQuantity = quantity;
      if (prodigyProduct.is_validate_options()) {
        let logo_id = product_logo_management_object.get_logo_id();
        prodigyProduct.get_variant_data(selected_variant_options, quantity, logo_id, null, true, false);
      }
    },
    set_variant_bulk_info: function (response) {
      let self = this;
      $.each(response.data, function (key, value) {
        self.set_bulk_price_modifier(key, value);
        self.set_bulk_stock_info(key, value);
      });
    },
    set_bulk_stock_info: function (key, value) {
      let key_field = key.replace(/\s/g, "_");
      if (typeof value.inventory !== "undefined" && value.inventory.attributes) {
        if (value.inventory.attributes['manage-stock'] && value.inventory.attributes['count'] !== null) {
          $(this.bulk_stock_status + key_field).text('In stock: ');
          if (value.inventory.attributes['count'] !== null) {
            $(this.bulk_stock_qty + key_field).text(value.inventory.attributes['count']);
          }
        } else {
          $(this.bulk_stock_status + key_field).text(this._stock_status_mapper[value.inventory.attributes['stock']]);
        }
      }
    },
    set_bulk_price_modifier: function (key, value) {
      if (value.attributes && typeof value.attributes['price-quantity-modifier'] !== "undefined" && parseFloat(value.attributes['price-quantity-modifier']) > 0) {
        $(this.bulk_price_modifier_element + key).show();
        $(this.bulk_price_modifier_element + key).text('+ $' + parseFloat(value.attributes['price-quantity-modifier']));
      } else {
        $(this.bulk_price_modifier_element + key).hide();
      }
    },
    set_bulk_variants_data: function () {
      let self = this;
      $(document).on("input", '.prodigy-bulk-input-js', function (e) {
        self.set_bulk_data();
      });
    }
  };
  window.prodigyProductBulk = prodigy_product_bulk;
})(jQuery, window);
jQuery(document).ready(function ($) {
  window.prodigyProductBulk.init();
});

/***/ }),

/***/ "./web/templates/js/scripts/product-logo-management.js":
/*!*************************************************************!*\
  !*** ./web/templates/js/scripts/product-logo-management.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  let product_logo_management = {
    toggle_checkbox_selector: '.toggle-form-js',
    logo_value_element: '.prodigy-logo-values-js',
    template_selector: '#logo-form-template',
    main_logo_management_container: '.logo-container-js',
    block_logo_management_container: '.container-js',
    max_logo_quantity: 3,
    logo_options_ids: [],
    // logo can be just for 'color' attribute
    logo_attribute: 'color',
    init: function () {
      this.set_default_logo();
      this.show_logo_form();
      if (this.is_logo_swatches()) {
        this.set_logos_swatches();
        this.change_logo_radio();
      } else {
        this.set_logos();
      }
      this.set_custom_location_select();
      this.set_custom_logo_select();
      if (!prodigyProduct.is_variants() && !this.is_logo_swatches()) {
        this.set_logo_dropdown_for_single_product();
      }
      this.update_forms_visibility();
      this.open_tooltip_mobile();
      this.close_tooltip_mobile();
    },
    is_logo: function () {
      return $('.prodigy-logo-tool__container.opened').length > 0;
    },
    set_default_logo: function () {
      let self = this;
      let logo_images_options = self.get_images_logos_settings();
      if (typeof logo_images_options !== 'undefined') {
        if (logo_images_options && logo_images_options.length && logo_images_options.length === 0) {
          return;
        }
        if (Object.entries(logo_images_options).length > 0) {
          let suitable_logo_image = Object.entries(logo_images_options)[0][1];
          for (let i in logo_images_options) {
            if (logo_images_options[i].is_default) {
              suitable_logo_image = logo_images_options[i];
              break;
            }
          }
          let $container = $('.prodigy-logo-tool__container.opened');
          if (self.is_logo_swatches()) {
            self.set_swatch_logo_value($container.find('.prodigy-product__logo-swatch-js'), suitable_logo_image.logo_id);
          } else {
            self.set_logo_select_value($container.find('.prodigy-logo-values-js'), suitable_logo_image.logo_id);
          }
          let $location_select = $container.find('.prodigy-logo-location-js');
          let preselected_location_ids = self.get_selected_locations_list($location_select);
          if (self.is_available_logo_location(suitable_logo_image.logo_id, suitable_logo_image.location_id, preselected_location_ids, logo_images_options)) {
            self.refresh_locations_list($location_select, logo_images_options, preselected_location_ids, suitable_logo_image.logo_id);
            self.set_location_select_value($location_select, suitable_logo_image.location_id);
          } else {
            self.preselect_logo_location($container, logo_images_options, suitable_logo_image.logo_id);
          }
          self.update_locations_availability();
          self.update_main_gallery_images(suitable_logo_image.logo_id, suitable_logo_image.location_id);
        }
      }
    },
    set_logo_dropdown_for_single_product: function () {
      this.set_logos();
      this.get_logos_price();
    },
    is_logo_swatches: function () {
      return $('.prodigy-product__logo-swatch-js').length > 0;
    },
    update_main_gallery_images: function (logo_id, location_id) {
      let self = this;
      const options = self.get_images_logos_settings();
      const $current_image = $('#gallery-main .swiper-slide-active .main-gallery-image-js');
      let is_image_available = false;
      for (let i in options) {
        if (parseInt(options[i].logo_id) === parseInt(logo_id) && parseInt(options[i].location_id) === parseInt(location_id) && parseInt(options[i].image_id) === $current_image.data('image-id')) {
          is_image_available = true;
          break;
        }
      }
      if (!is_image_available) {
        let image_id;
        for (let i in options) {
          if (parseInt(options[i].logo_id) === parseInt(logo_id) && parseInt(options[i].location_id) === parseInt(location_id)) {
            image_id = options[i].image_id;
          }
        }
        for (let j in prodigyProduct.swiperMain.slides) {
          const slide_image_id = $(prodigyProduct.swiperMain.slides[j]).find('.main-gallery-image-js').data('image-id');
          if (parseInt(slide_image_id) === parseInt(image_id)) {
            prodigyProduct.swiperMain.slideTo(j);
          }
        }
      }
    },
    update_forms_visibility: function () {
      let self = this;
      const max_form_number = self.get_max_add_logo_forms();
      let close_forms_number = $('.prodigy-logo-tool__container.opened').length - max_form_number;
      if (close_forms_number < 0 && $('.prodigy-logo-tool__container.closed').length === 0) {
        let $clone = $(self.template_selector).contents().clone();
        $(self.main_logo_management_container).append($clone);
        this.set_custom_logo_select();
      }

      //TODO - this code removing swatch logos form
      if (close_forms_number > 0 && !prodigyProductBulk.is_active_logo_bulk) {
        for (let i = 1; i <= close_forms_number; i++) {
          let last_form = $('.prodigy-logo-tool__container.opened:last');
          last_form.remove();
        }
      }
      if ($('.prodigy-logo-tool__container').length === 1 && max_form_number > 0) {
        $('.prodigy-logo-tool__container').removeClass('closed');
        $('.prodigy-logo-tool__container').addClass('opened');
      }
      if ($('.prodigy-logo-tool__container.opened').length === max_form_number) {
        $('.prodigy-logo-tool__container.closed').remove();
      }
      $('.prodigy-logo-tool__container.opened:first').find('.prodigy-logo-tool__toggler-block').remove();
    },
    get_locations_set: function (images_logos_settings, logo_id) {
      let location_set = new Set();
      for (let i in images_logos_settings) {
        if (logo_id === undefined || parseInt(images_logos_settings[i].logo_id) === parseInt(logo_id)) {
          let location_id = images_logos_settings[i].location_id;
          if (!location_set.has(location_id)) {
            location_set.add(location_id);
          }
        }
      }
      return location_set;
    },
    find_suitable_logo_location: function (images_logos_settings, default_logo_id, excluded_location_ids) {
      for (let i in images_logos_settings) {
        let is_location_available = !excluded_location_ids.includes(parseInt(images_logos_settings[i].location_id));
        let is_same_logo = false;
        if (typeof default_logo_id === 'undefined' || parseInt(images_logos_settings[i].logo_id) === parseInt(default_logo_id)) {
          is_same_logo = true;
        }
        if (is_same_logo && is_location_available) {
          return images_logos_settings[i];
        }
      }
      for (let i in images_logos_settings) {
        let is_location_available = !excluded_location_ids.includes(parseInt(images_logos_settings[i].location_id));
        if (is_location_available) {
          return images_logos_settings[i];
        }
      }
      return null;
    },
    update_locations_availability: function (attribute_name) {
      let self = this;
      let image_logos_settings = self.get_images_logos_settings(attribute_name);
      $('.prodigy-logo-tool__container.opened').each(function () {
        let $container = $(this);
        let $location_select = $container.find('.prodigy-logo-location-js');
        let logo_id = self.is_logo_swatches() ? $(this).find('.prodigy-product__logo-swatch-js:checked').val() : $container.find('.prodigy-logo-values-js').val();
        let preselected_location_ids = self.get_selected_locations_list($location_select);
        let location_set = self.get_locations_set(image_logos_settings, logo_id);
        $location_select.find('option').attr('disabled', true);
        for (const location_id of location_set) {
          if (!preselected_location_ids.includes(location_id)) {
            $location_select.find('option[value="' + location_id + '"]').attr('disabled', false);
          }
        }
        self.disable_logos_with_no_locations($container, image_logos_settings);
      });
    },
    is_available_logo_location: function (logo_id, location_id, preselected_logo_location, image_logos_settings) {
      if (preselected_logo_location.includes(location_id)) {
        return false;
      }
      for (let i in image_logos_settings) {
        if (parseInt(image_logos_settings[i].logo_id) === parseInt(logo_id) && parseInt(image_logos_settings[i].location_id) === parseInt(location_id)) {
          return true;
        }
      }
      return false;
    },
    refresh_locations_list: function ($location_select, image_logos_settings, preselected_location_ids, logo_id) {
      let self = this;
      let location_set = self.get_locations_set(image_logos_settings, logo_id);
      for (const location_id of location_set) {
        if (!preselected_location_ids.includes(location_id)) {
          $location_select.find('option[value="' + location_id + '"]').prop('disabled', false);
        }
      }
    },
    preselect_logo_location: function ($container, image_logos_settings, logo_id) {
      let self = this;
      let $location_select = $container.find('.prodigy-logo-location-js');
      let preselected_location_ids = self.get_selected_locations_list($location_select);
      let suitable_logo_location = self.find_suitable_logo_location(image_logos_settings, logo_id, preselected_location_ids);
      if (self.is_available_logo_location(logo_id, $location_select.val(), preselected_location_ids, image_logos_settings)) {
        return;
      }
      if (suitable_logo_location !== null) {
        self.refresh_locations_list($location_select, image_logos_settings, preselected_location_ids, logo_id);
        self.set_location_select_value($location_select, suitable_logo_location.location_id);
        if (parseInt(suitable_logo_location.logo_id) !== parseInt(logo_id)) {
          this.is_logo_swatches() ? self.set_swatch_logo_value($container.find('.prodigy-product__logo-swatch-js'), suitable_logo_location.logo_id) : self.set_logo_select_value($container.find('.prodigy-logo-values-js'), suitable_logo_location.logo_id);
        }
      }
      self.disable_logos_with_no_locations($container, image_logos_settings);
    },
    disable_logos_with_no_locations: function ($container, image_logos_settings) {
      let self = this;
      if (self.is_logo_swatches()) {
        self.disable_logos_swatches_with_no_locations($container, image_logos_settings);
        return;
      }
      $('.prodigy-logo-tool__container').each(function () {
        let $container = $(this);
        let $location_select = $container.find('.prodigy-logo-location-js');
        let preselected_location_ids = self.get_selected_locations_list($location_select);
        $container.find('.prodigy-logo-values-js option').each(function () {
          let is_empty_locations = true;
          for (let i in image_logos_settings) {
            if (parseInt(image_logos_settings[i].logo_id) === parseInt($(this).attr('value')) && !preselected_location_ids.includes(parseInt(image_logos_settings[i].location_id))) {
              is_empty_locations = false;
              break;
            }
          }
          $(this).prop('disabled', is_empty_locations);
        });
      });
    },
    disable_logos_swatches_with_no_locations: function ($container, image_logos_settings) {
      let self = this;
      $('.prodigy-logo-tool__container').each(function () {
        let $container = $(this);
        let $location_select = $container.find('.prodigy-logo-location-js');
        let preselected_location_ids = self.get_selected_locations_list($location_select);
        $container.find('.prodigy-product__logo-swatch-js').each(function () {
          let is_empty_locations = true;
          for (let i in image_logos_settings) {
            if (parseInt(image_logos_settings[i].logo_id) === parseInt($(this).val()) && !preselected_location_ids.includes(parseInt(image_logos_settings[i].location_id))) {
              is_empty_locations = false;
              break;
            }
          }
          $(this).prop('disabled', is_empty_locations);
          if (is_empty_locations) {
            $(this).closest('.prodigy-tooltip-js').addClass('prodigy-logo__disabled');
            $(this).closest('.prodigy-radio__swatch-logo-btn').find('.prodigy-product__swatch-init-js').addClass('prodigy-logo__disabled-mobile');
          } else {
            $(this).closest('.prodigy-tooltip-js').removeClass('prodigy-logo__disabled');
            $(this).closest('.prodigy-radio__swatch-logo-btn').find('.prodigy-product__swatch-init-js').removeClass('prodigy-logo__disabled-mobile');
          }
        });
      });
    },
    open_tooltip_mobile: function () {
      $(document).on('click', '.prodigy-logo__disabled-mobile', function (e) {
        e.preventDefault();
        let $tooltip = $(this).closest('.prodigy-tooltip-js').find('.prodigy-tooltip__message');
        let $backdrop = $(this).closest('.prodigy-tooltip-js').find('.prodigy-after__backdrop');
        $tooltip.addClass('d-flex');
        $backdrop.show();
      });
    },
    close_tooltip_mobile: function () {
      $(document).on('click', '.prodigy-after__backdrop', function () {
        let $tooltip = $(this).closest('.prodigy-tooltip-js').find('.prodigy-tooltip__message');
        $tooltip.removeClass('d-flex');
        $(this).hide();
      });
    },
    set_location_select_value($location_select, value) {
      let self = this;
      $location_select.val(value);
      if (typeof $location_select !== undefined && $location_select.get(0) && typeof $location_select.get(0).msDropdown !== "undefined") {
        $location_select.get(0).msDropdown.refresh();
      } else {
        self.set_custom_location_select();
      }
    },
    set_swatch_logo_value($logo_radio, value) {
      $logo_radio.filter('[value="' + value + '"]').prop('checked', 'checked');
    },
    set_logo_select_value($logo_select, value) {
      let self = this;
      $logo_select.val(value);
      if (typeof $logo_select !== undefined && $logo_select.get(0) && typeof $logo_select.get(0).msDropdown !== "undefined") {
        $logo_select.get(0).msDropdown.refresh();
      } else {
        self.set_custom_logo_select();
      }
    },
    disable_selected_location: function (location_id) {
      $('.prodigy-logo-location-js').each(function () {
        if (parseInt($(this).val()) !== parseInt(location_id)) {
          $(this).find('option[value="' + location_id + '"]').attr('disabled', true);
        }
        if (typeof $(this).get(0).msDropdown !== "undefined") {
          $(this).get(0).msDropdown.refresh();
        }
      });
    },
    enable_selected_location: function (location_id) {
      $('.prodigy-logo-location-js').each(function () {
        if (parseInt($(this).val()) !== parseInt(location_id)) {
          $(this).find('option[value="' + location_id + '"]').attr('disabled', false);
        }
        if (typeof $(this).get(0).msDropdown !== "undefined") {
          $(this).get(0).msDropdown.refresh();
        }
      });
    },
    init_logos_locations_form: function () {
      let self = this;
      const images_logos_settings = self.get_images_logos_settings();
      $('.prodigy-logo-tool__container').each(function () {
        let logo_value;
        if (self.is_logo_swatches()) {
          let $logo_radio = $(this).find('.prodigy-product__logo-swatch-js');
          logo_value = $logo_radio.filter(':checked').val();
        } else {
          let $logo_select = $(this).find('.prodigy-logo-values-js');
          logo_value = $logo_select.val();
        }
        self.preselect_logo_location($(this), images_logos_settings, logo_value);
      });
    },
    change_logo_radio: function () {
      let self = this;
      $(document).on('click', '.prodigy-product__logo-swatch-js', function () {
        if (prodigyProductBulk.is_active_logo_bulk) {
          $(document).trigger('enable-multiple-quantity');
        } else {
          if (self.is_logo_swatches()) {
            let $container = $(this).closest('.prodigy-logo-tool__form-container');
            let logo_id = $container.find('.prodigy-product__logo-swatch-js:checked').val();
            self.preselect_logo_location($container, self.get_images_logos_settings(), logo_id);
            self.set_logos_swatches();
          }
          if (prodigyProduct.is_variants()) {
            prodigyProduct.set_variants_data(self.get_variant_data());
          } else {
            prodigyProduct.show_master_variant_info();
          }
        }
      });
    },
    set_custom_logo_select: function () {
      let self = this;
      let dropdownOpened = false;
      MsDropdown.make('.prodigy-logo-values-js:not(.inited)', {
        enableAutoFilter: false,
        on: {
          open: function () {
            dropdownOpened = true;
          },
          change: function (data) {
            if (dropdownOpened) {
              let location_select = $(data.option).closest('.prodigy-logo-tool__container').find('.prodigy-logo-location-js');
              self.preselect_logo_location($(data.option).closest('.prodigy-logo-tool__container'), self.get_images_logos_settings(), data.data.value);
              self.update_main_gallery_images(data.data.value, location_select.val());
              self.set_logos();
              self.get_logos_price();
              self.update_locations_availability();
              dropdownOpened = false;
              if (prodigyProductBulk.is_active_logo_bulk) {
                $(document).trigger('enable-multiple-quantity');
              }
            }
          },
          close: function () {
            if (prodigyProduct.is_variants()) {
              prodigyProduct.set_variants_data(self.get_variant_data());
            } else {
              prodigyProduct.show_master_variant_info();
            }
          }
        }
      });
      $('.prodigy-logo-values-js:not(.inited)').addClass('inited');
    },
    set_custom_location_select: function () {
      let self = this;
      let dropdownOpened = false;
      MsDropdown.make('.prodigy-logo-location-js:not(.inited)', {
        enableAutoFilter: false,
        on: {
          enableAutoFilter: false,
          open: function () {
            dropdownOpened = true;
          },
          change: function (data) {
            if (prodigyProductBulk.is_active_logo_bulk) {
              $(document).trigger('enable-multiple-quantity');
            } else {
              if (dropdownOpened) {
                let $container = $(data.option).closest('.prodigy-logo-tool__container');
                let location_id = data.data.value;
                let logo_id;
                if (self.is_logo_swatches()) {
                  let logo_radio = $container.find('.prodigy-product__logo-swatch-js');
                  self.set_logos_swatches();
                  logo_id = logo_radio.val();
                } else {
                  let logo_select = $container.find('.prodigy-logo-values-js');
                  self.set_logos();
                  logo_id = logo_select.val();
                }
                self.update_locations_availability();
                self.update_main_gallery_images(logo_id, location_id);
                if (prodigyProduct.is_variants()) {
                  prodigyProduct.set_variants_data(self.get_variant_data());
                } else {
                  prodigyProduct.show_master_variant_info();
                }
              }
              dropdownOpened = false;
            }
          }
        }
      });
      $('.prodigy-logo-location-js:not(.inited)').addClass('inited');
    },
    get_variant_data: function () {
      return $('#variant-data-js').data('variant');
    },
    clear_logos: function () {
      $('svg .prodigy-product__gallery-logo-js').remove();
      $('svg .thumb-gallery-logo-js').remove();
    },
    get_logo_id: function () {
      let logo_id;
      let $container = $('.prodigy-logo-tool__container.opened');
      if (product_logo_management_object.is_logo_swatches()) {
        logo_id = $('.prodigy-product__logo-swatch-js:checked').val();
      } else {
        logo_id = $container.find('.prodigy-logo-values-js').val();
      }
      return logo_id;
    },
    get_images_logos_settings: function (attribute_name = null) {
      let options = [];
      if (prodigyProductBulk.is_active_logo_bulk && attribute_name === null) {
        attribute_name = $('.bulk-container-js:visible').data('attribute');
      }
      if (!prodigyProduct.is_variants() || prodigyProductBulk.is_active_logo_bulk && attribute_name === this.logo_attribute) {
        const master_logos = $('#master-logo-locations-data-js');
        options = master_logos.data('locations');
      } else if (prodigyProduct.is_swatches()) {
        let selected_swatch = $('.has-logo-settings-js:checked');
        options = selected_swatch.data('logos');
      } else {
        const $select_for_images = $('option[data-logos]').parent('select');
        if ($select_for_images.val() === '') {
          return [];
        }
        options = $select_for_images.find('option[value="' + $select_for_images.val() + '"]').data('logos');
      }
      return options;
    },
    get_logos_price: function () {
      let total_price = 0;
      if (this.is_logo_swatches()) {
        $('.prodigy-logo-tool__container.opened .prodigy-product__logo-swatch-js:checked').each(function () {
          total_price += parseFloat($(this).data('price'));
        });
      } else {
        $('.prodigy-logo-tool__container.opened .prodigy-logo-values-js').each(function () {
          const $current_option = $(this).find('option[value=' + $(this).val() + ']');
          total_price += parseFloat($current_option.data('price'));
        });
      }
      return parseFloat(total_price);
    },
    set_logos_swatches: function () {
      let self = this;
      self.clear_logos();
      const images_logos_settings = self.get_images_logos_settings();
      $('.prodigy-logo-tool__container.opened').each(function () {
        const $logo_radio = $(this).find('.prodigy-product__logo-swatch-js:checked');
        const default_logo_name = $logo_radio.data('name');
        const $location_select = $(this).find('.prodigy-logo-location-js');
        const logo_id = $logo_radio.val();
        const location_id = $location_select.val();
        $(this).closest('.prodigy-logo-tool__container').find('.swatch-logo-name-js').text(default_logo_name);
        for (let i in images_logos_settings) {
          let image_id = images_logos_settings[i].image_id;
          let $current_image = $('.main-gallery-image-js[data-image-id="' + image_id + '"]');
          let $current_thumb = $('.thumb-gallery-image-js[data-image-id="' + image_id + '"]');
          if (parseInt(images_logos_settings[i].logo_id) === parseInt(logo_id) && parseInt(images_logos_settings[i].location_id) === parseInt(location_id)) {
            $current_image.parent('svg').append(self.create_logo_element(images_logos_settings[i]));
            $current_thumb.closest('svg').append(self.create_logo_element(images_logos_settings[i]));
          }
        }
        self.update_locations_availability();
      });
    },
    set_logos: function () {
      let self = this;
      self.clear_logos();
      const images_logos_settings = self.get_images_logos_settings();
      $('.prodigy-logo-tool__container.opened').each(function () {
        const $logo_select = $(this).find('.prodigy-logo-values-js');
        const $location_select = $(this).find('.prodigy-logo-location-js');
        const logo_id = $logo_select.val();
        const location_id = $location_select.val();
        for (let i in images_logos_settings) {
          let image_id = images_logos_settings[i].image_id;
          let $current_image = $('.main-gallery-image-js[data-image-id="' + image_id + '"]');
          let $current_thumb = $('.thumb-gallery-image-js[data-image-id="' + image_id + '"]');
          if (parseInt(images_logos_settings[i].logo_id) === parseInt(logo_id) && parseInt(images_logos_settings[i].location_id) === parseInt(location_id)) {
            $current_image.parent('svg').append(self.create_logo_element(images_logos_settings[i]));
            $current_thumb.closest('svg').append(self.create_logo_element(images_logos_settings[i]));
          }
        }
      });
    },
    get_logos_options_swatches: function () {
      let self = this;
      const images_logos_settings = self.get_images_logos_settings();
      let logo_options_ids = [];
      $('.prodigy-logo-tool__container.opened').each(function () {
        const $logo_radio = $(this).find('.prodigy-product__logo-swatch-js:checked');
        const default_logo_name = $logo_radio.data('name');
        const $location_select = $(this).find('.prodigy-logo-location-js');
        const logo_id = $logo_radio.val();
        const location_id = $location_select.val();
        $(this).closest('.prodigy-logo-tool__container').find('.swatch-logo-name-js').text(default_logo_name);
        for (let i in images_logos_settings) {
          if (parseInt(images_logos_settings[i].logo_id) === parseInt(logo_id) && parseInt(images_logos_settings[i].location_id) === parseInt(location_id)) {
            logo_options_ids.push(i);
            break;
          }
        }
      });
      return logo_options_ids;
    },
    get_logo_options: function () {
      let self = this;
      const images_logos_settings = self.get_images_logos_settings();
      let logo_options_ids = [];
      $('.prodigy-logo-tool__container.opened').each(function () {
        const $logo_select = $(this).find('.prodigy-logo-values-js');
        const $location_select = $(this).find('.prodigy-logo-location-js');
        const logo_id = $logo_select.val();
        const location_id = $location_select.val();
        for (let i in images_logos_settings) {
          if (parseInt(images_logos_settings[i].logo_id) === parseInt(logo_id) && parseInt(images_logos_settings[i].location_id) === parseInt(location_id)) {
            logo_options_ids.push(i);
            break;
          }
        }
      });
      return logo_options_ids;
    },
    get_selected_locations_list: function ($excluded_location_select) {
      let location_ids = [];
      $('.prodigy-logo-tool__container.opened .prodigy-logo-location-js').not($excluded_location_select).each(function () {
        location_ids.push(parseInt($(this).val()));
      });
      return location_ids;
    },
    create_logo_element: function (logo_settings) {
      let $logo = $(document.createElementNS('http://www.w3.org/2000/svg', 'image'));
      $logo.addClass('prodigy-product__gallery-logo-js');
      $logo.attr('data-logo-id', logo_settings.logo_id);
      $logo.attr('data-location-id', logo_settings.location_id);
      $logo.attr('href', logo_settings.logo['original-url']);
      $logo.attr('width', logo_settings.location['width']);
      $logo.attr('height', logo_settings.location['height']);
      $logo.attr('x', logo_settings.location['x']);
      $logo.attr('y', logo_settings.location['y']);
      let transformX = logo_settings.location['x'] + logo_settings.location['width'] / 2;
      let transformY = logo_settings.location['y'] + logo_settings.location['height'] / 2;
      let logo_style = "transform-origin:" + transformX + "px " + transformY + "px; transform: rotate(" + logo_settings.location['angle'] + "deg) rotateY(" + logo_settings.location['rotation-y'] + "deg) rotateX(" + logo_settings.location['rotation-x'] + "deg)";
      $logo.attr('style', logo_style);
      return $logo;
    },
    get_max_add_logo_forms: function () {
      let self = this;
      const images_logos_settings = self.get_images_logos_settings();
      let logo_images = new Set();
      for (let i in images_logos_settings) {
        logo_images.add(images_logos_settings[i].location_id);
      }
      return logo_images.size > self.max_logo_quantity ? self.max_logo_quantity : logo_images.size;
    },
    show_logo_form: function () {
      let self = this;
      $(document).on("click", self.toggle_checkbox_selector, function () {
        let $container = $(this).closest('.container-js');
        let $location_select = $container.find('.prodigy-logo-location-js');
        if ($(this).is(':checked')) {
          $container.removeClass('closed');
          $container.addClass('opened');
          if ($(document).find('.prodigy-logo-location-js').length < self.get_max_add_logo_forms()) {
            let $clone = $(self.template_selector).contents().clone();
            $(this).closest(self.main_logo_management_container).append($clone);
            self.set_custom_logo_select();
          }
          self.preselect_logo_location($container, self.get_images_logos_settings(), $container.find('.prodigy-logo-value-js').val());
          self.disable_selected_location($location_select.val());
        } else {
          self.enable_selected_location($location_select.val());
          if ($container.is('.container-js:last-of-type')) {
            $container.removeClass('opened');
            $container.addClass('closed');
          } else {
            $container.remove();
          }
        }
        self.set_logos();
        if (self.is_logo_swatches()) {
          self.set_logos_swatches();
        }
        self.get_logos_price();
        self.update_locations_availability();
        prodigyProduct.set_variants_data(self.get_variant_data());
      });
    },
    bulk_logo_validate: function (attribute, current_options) {
      let $container = $('.prodigy-logo-tool__container.opened');
      let current_location_id = $container.find('.prodigy-logo-location-js').find('option:selected').val();
      let product_options = JSON.parse($('#product-options-data-js').val());
      let logos = [];
      for (let index in current_options) {
        for (const key in product_options[attribute]) {
          if (current_options[index].name !== key || typeof product_options[attribute][key]['logos'] === "undefined") {
            continue;
          }
          for (const i in product_options[attribute][key]['logos']) {
            if (parseInt(product_options[attribute][key]['logos'][i]['option_id']) === parseInt(current_options[index].id) && parseInt(product_options[attribute][key]['logos'][i]['location_id']) === parseInt(current_location_id)) {
              logos.push(product_options[attribute][key]['logos'][i]['logo_id']);
            }
          }
        }
      }
      this.bulk_logo_disable(logos);
      this.set_logo_bulk(attribute, current_options);
    },
    set_logo_bulk: function (attribute, current_options) {
      let $container = $('.prodigy-logo-tool__container.opened');
      let current_location_id = $container.find('.prodigy-logo-location-js').find('option:selected').val();
      let product_options = JSON.parse($('#product-options-data-js').val());
      let current_logo_id = this.is_logo_swatches() ? $container.find('.prodigy-product__logo-swatch-js:checked').val() : $container.find('.prodigy-logo-values-js').find('option:selected').val();
      for (let index in current_options) {
        for (const key in product_options[attribute]) {
          if (current_options[index].name !== key || typeof product_options[attribute][key]['logos'] === "undefined") {
            continue;
          }
          for (const i in product_options[attribute][key]['logos']) {
            if (parseInt(product_options[attribute][key]['logos'][i]['option_id']) === parseInt(current_options[index].id) && parseInt(product_options[attribute][key]['logos'][i]['location_id']) === parseInt(current_location_id)) {
              // set logo
              let image_id = product_options[attribute][key]['logos'][i]['image_id'];
              let $current_image = $('.main-gallery-image-js[data-image-id="' + image_id + '"]');
              let $current_thumb = $('.thumb-gallery-image-js[data-image-id="' + image_id + '"]');
              if (parseInt(product_options[attribute][key]['logos'][i]['logo_id']) === parseInt(current_logo_id) && parseInt(product_options[attribute][key]['logos'][i]['location_id']) === parseInt(current_location_id)) {
                $current_image.parent('svg').append(this.create_logo_element(product_options[attribute][key]['logos'][i]));
                $current_thumb.closest('svg').append(this.create_logo_element(product_options[attribute][key]['logos'][i]));
              }
            }
          }
        }
      }
    },
    bulk_logo_disable: function (logos) {
      let $container = $('.prodigy-logo-tool__container.opened');
      if (this.is_logo_swatches()) {
        let current_logo = $container.find('.prodigy-product__logo-swatch-js:checked').val();
        if (!logos.includes(parseInt(current_logo))) {
          $container.find('.prodigy-product__logo-swatch-js:checked').removeProp('checked');
        }
        $container.find('.prodigy-product__logo-swatch-js').each(function () {
          if (logos.includes(parseInt($(this).val()))) {
            $(this).prop('disabled', false);
            $(this).closest('.prodigy-tooltip-js').removeClass('prodigy-logo__disabled');
            $(this).closest('.prodigy-radio__swatch-logo-btn').find('.prodigy-product__swatch-init-js').removeClass('prodigy-logo__disabled-mobile');
          } else {
            $(this).prop('disabled', true);
            $(this).closest('.prodigy-tooltip-js').addClass('prodigy-logo__disabled');
            $(this).closest('.prodigy-radio__swatch-logo-btn').find('.prodigy-product__swatch-init-js').addClass('prodigy-logo__disabled-mobile');
          }
        });
        if (!logos.includes(parseInt(current_logo))) {
          $container.find('.prodigy-product__logo-swatch-js:not(:disabled)').first().prop('checked', 'checked');
        }
        $('.prodigy-logo-tool__container.opened').each(function () {
          const $logo_radio = $(this).find('.prodigy-product__logo-swatch-js:checked');
          const default_logo_name = $logo_radio.data('name');
          $(this).closest('.prodigy-logo-tool__container').find('.swatch-logo-name-js').text(default_logo_name);
        });
      } else {
        $container.find('.prodigy-logo-values-js option').each(function () {
          $(this).prop('disabled', !logos.includes(parseInt($(this).val())));
        });
        if ($container.find('.prodigy-logo-values-js option:selected:disabled').length > 0) {
          const val = $container.find('.prodigy-logo-values-js option:not(:disabled)').first().val();
          this.set_logo_select_value($container.find('.prodigy-logo-values-js'), val);
        }
      }
    },
    set_bulk_logo_option_validate: function (attribute, current_options) {
      let image_options = {};
      let $container = $('.prodigy-logo-tool__container.opened');
      let location_id = $container.find('.prodigy-logo-location-js').find('option:selected').val();
      let product_options = JSON.parse($('#product-options-data-js').val());
      let current_logo_id = this.is_logo_swatches() ? $container.find('.prodigy-product__logo-swatch-js:checked').val() : $container.find('.prodigy-logo-values-js').find('option:selected').val();
      for (let index in current_options) {
        for (const key in product_options[attribute]) {
          if (current_options[index].name !== key || typeof product_options[attribute][key]['logos'] === "undefined") {
            continue;
          }
          for (const i in product_options[attribute][key]['logos']) {
            if (parseInt(product_options[attribute][key]['logos'][i]['option_id']) === parseInt(current_options[index].id) && parseInt(product_options[attribute][key]['logos'][i]['location_id']) === parseInt(location_id) && parseInt(product_options[attribute][key]['logos'][i]['logo_id']) === parseInt(current_logo_id)) {
              current_options[index].has_logo = current_options[index].has_logo || true;
              image_options[index] = current_options[index];
            } else {
              current_options[index].has_logo = current_options[index].has_logo || false;
            }
          }
        }
      }
      prodigyProduct.set_gallery(image_options, attribute);
      this.bulk_options_disable(current_options);
    },
    bulk_options_disable: function (current_options) {
      for (let index in current_options) {
        let bulk_input = $(".prodigy-bulk-input-js[data-option=" + current_options[index].name + "]");
        if (current_options[index].has_logo) {
          bulk_input.attr('disabled', false);
          bulk_input.closest('.prodigy-bulk__table-cell-body').removeClass('prodigy-bulk__table-cell-body--disabled');
        } else {
          bulk_input.val('');
          bulk_input.attr('disabled', true);
          bulk_input.closest('.prodigy-bulk__table-cell-body').addClass('prodigy-bulk__table-cell-body--disabled');
        }
      }
    },
    bulk_locations_validate: function () {
      $('.prodigy-logo-tool__container.opened').each(function () {
        let $container = $(this);
        let $location_select = $container.find('.prodigy-logo-location-js');
        $location_select.find('option').attr('disabled', false);
      });
    }
  };
  $(document).ready(function () {
    product_logo_management.init();
  });
  window.product_logo_management_object = product_logo_management;
})(jQuery, window);

/***/ }),

/***/ "./web/templates/js/scripts/product-page.js":
/*!**************************************************!*\
  !*** ./web/templates/js/scripts/product-page.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
  var prodigy_product = {
    _weight_type_mapper: ["lbs", "g", "kg", "oz"],
    _dimension_type_mapper: ["in", "cm"],
    _stock_status_mapper: {
      "in_stock": "In stock",
      "out_of_stock": "Out of stock"
    },
    _add_to_cart_key: "add_item_to_cart",
    product: {},
    is_show_subscription_popup: false,
    subscription_price: 0,
    is_subscription_replaced: false,
    is_one_time_order: true,
    subscription_id: '',
    remote_product: {},
    variant: {},
    maxItems: 9999,
    is_admin: false,
    is_tiered_price: false,
    selectedVariant: [],
    master_variant_id: 0,
    active_bulk_attribute_name: '',
    min_quantity: 1,
    add_to_cart_button_element: '.add-to-cart-js',
    enable_bulk_element: '.enable-bulk-js',
    disable_bulk_button_element: '.disable-bulk-button-js',
    product_counter_input_element: '.counter-count-js',
    prodigy_product_swatch_element: '.prodigy-product__swatch-js',
    is_variant_was_chosen: false,
    swiperThumbs: false,
    swiperMain: false,
    main_slider_template: '#gallery-slide',
    thumb_slider_template: '#gallery-thumbs-slide',
    is_variant_gallery: false,
    selected_attributes: [],
    bulk_variants_info: [],
    init: function () {
      this.is_tiered_price = Boolean($('.is_tired_price-js').val());
      if (this.is_tiered_price) {
        localStorage.setItem("min_quantity", this.min_quantity);
      }
      let is_product_page = $("body").hasClass("single-prodigy-product");
      let is_shop_page = $("body").hasClass("tax-prodigy-product-shop");
      this.master_variant_id = $('#product_id').val();
      this.is_admin = $(document).find('#user-role-js').data('attr');
      if (!is_shop_page && is_product_page) {
        if (!this.is_variants()) {
          this.get_master_variant_data();
        }
        this.set_product_tabs();
        this.set_product_counter();
        this.show_tab_review();
        this.show_tab_description();
        this.send_captcha();
        this.send_review_for_user();
        this.disable_submit_comment();
        this.reset_focus_to_press_enter();
        this.set_default_link_review();
        this.change_product_quantity_analytic_event();
        this.set_product_gallery();
        if (this.is_variants()) {
          if (this.is_swatches()) {
            this.change_swatch_value();
            this.set_checked_swatch();
          } else {
            this.set_variant_dropdown();
            this.set_attribute_value_options();
            this.update_variants_dropdown();
          }
          this.set_customised_variant_selection();
        }
        this.set_variant_data();
        this.set_elementor_options();
        this.set_subscription_id();
        this.set_tabs_for_resolution();
        this.customise_sort_select();
        this.add_item_to_cart();
        this.hide_empty_div();
        prodigyProductBulk.set_bulk_variants_data();
        if (this.is_bulk()) {
          this.set_bulk();
        }
        if (this.is_swatches()) {
          this.set_checked_swatch();
        } else {
          this.set_attribute_value_options();
        }
        if (this.is_personalization()) {
          this.input_personalization_field();
        }
        if (!prodigyProductBulk.is_active_bulk) {
          this.show_available_variants();
        }
        if (this.is_tiered_price) {
          this.get_tiered_prices_range_ajax();
          this.close_tiered_price_popup();
        }
        if (prodigyProductBulk.is_bulk_enabled()) {
          let active_bulk_attribute = $('.bulk-container-js:visible').data('attribute');
          this.set_variant_modifier(active_bulk_attribute);
        }
        this.set_redemption_price();
      }
    },
    set_redemption_price: function () {
      if (parseInt(settings.redemption_store)) {
        $('.prodigy-bulk__subtotal-save').hide();
      } else {
        $('.prodigy-bulk__subtotal-save').show();
      }
    },
    show_available_variants: function () {
      let selected = [];
      let allowed_variants = $('.variants-options-intersect-js').data('options');
      if (this.is_swatches()) {
        $('.prodigy-product__swatch-js:checked').each(function () {
          let attr_name = $(this).data('attribute');
          selected[attr_name] = $(this).data('slug');
        });
        $('.prodigy-product__swatch-js').each(function () {
          let attr_name = $(this).data('attribute');
          let attr_value = $(this).data('slug');
          let hide_control = true;
          for (let i in allowed_variants) {
            let is_accepted = allowed_variants[i][attr_name] === attr_value;
            for (let selected_attr_name in selected) {
              if (attr_name === selected_attr_name) {
                continue;
              }
              is_accepted = is_accepted && allowed_variants[i][selected_attr_name] === selected[selected_attr_name];
            }
            if (is_accepted) {
              hide_control = false;
              break;
            }
          }
          if (hide_control) {
            $(this).parent().hide();
          } else {
            $(this).parent().show();
          }
        });
      } else {
        $(".attribute_values_js").each(function () {
          let $option = $(this).find("option:selected");
          let attr_value = $option.data('slug');
          let attr_name = $option.data('attribute');
          selected[attr_name] = attr_value;
        });
        $(".attribute_values_js option").each(function () {
          let attr_value = $(this).data('slug');
          let attr_name = $(this).data('attribute');
          let hide_control = true;
          for (let i in allowed_variants) {
            let is_accepted = allowed_variants[i][attr_name] === attr_value;
            for (let selected_attr_name in selected) {
              if (attr_name === selected_attr_name) {
                continue;
              }
              is_accepted = is_accepted && allowed_variants[i][selected_attr_name] === selected[selected_attr_name];
            }
            if (is_accepted) {
              hide_control = false;
              break;
            }
          }
          if (hide_control) {
            $(this).addClass('d-none');
          } else {
            $(this).removeClass('d-none');
          }
        });
      }
    },
    show_available_variants_bulk: function (active_attribute) {
      let selected = [];
      let allowed_variants = $('.variants-options-intersect-js').data('options');
      if (this.is_swatches()) {
        $('.prodigy-product__swatch-js:checked').each(function () {
          let attr_name = $(this).data('attribute');
          let attr_value = $(this).data('slug');
          if (attr_name !== active_attribute) {
            selected[attr_name] = attr_value;
          }
        });
      } else {
        $(".attribute_values_js").each(function () {
          let $option = $(this).find("option:selected");
          let attr_value = $option.data('slug');
          let attr_name = $option.data('attribute');
          if (attr_name !== active_attribute) {
            selected[attr_name] = attr_value;
          }
        });
      }
      $('.bulk-container-js[data-attribute="' + active_attribute + '"]').find('input').each(function () {
        let hide_control = true;
        let attr_value = $(this).data('option');
        for (let i in allowed_variants) {
          let is_accepted = allowed_variants[i][active_attribute] === attr_value;
          for (let selected_attr_name in selected) {
            is_accepted = is_accepted && allowed_variants[i][selected_attr_name] === selected[selected_attr_name];
          }
          if (is_accepted) {
            hide_control = false;
            break;
          }
        }
        if (hide_control) {
          $(this).val('');
          $(this).attr('disabled', true);
          $(this).closest('.prodigy-bulk__table-cell-body').addClass('prodigy-bulk__table-cell-body--disabled');
        } else {
          $(this).attr('disabled', false);
          $(this).closest('.prodigy-bulk__table-cell-body').removeClass('prodigy-bulk__table-cell-body--disabled');
        }
      });
    },
    close_tiered_price_popup: function () {
      $(document).on('click', '.close-tiered-prices-js', function () {
        $('#minorderQTY').modal('hide');
      });
    },
    get_options: function () {
      let self = this;
      let selected_options = [];
      if (this.is_swatches()) {
        $(self.prodigy_product_swatch_element).each(function () {
          let swatch_block = $(this).closest('.prodigy-product__swatch-block-js');
          if ($(this).is(':checked') && !$(swatch_block).hasClass('ignored')) {
            let value = $(this).val();
            $(this).closest('.swatch-container-js').find('.swatch-attribute-name-js').html("&nbsp;" + $(this).val());
            selected_options.push(value);
          }
        });
      } else {
        $(".attribute_values_js").each(function (key) {
          let $option = $(this).find("option:selected");
          if ($option.val() !== '') {
            selected_options.push($option.val());
          }
        });
      }
      return selected_options;
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
        });
        el.on("click", ".prodigy-product__gallery-nav-next", function () {
          if (swiper.isEnd) {
            swiper.slideTo(0);
          } else {
            swiper.slideNext();
          }
        });
      };
      this.swiperThumbs = new Swiper("#gallery-thumbs", {
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
      this.swiperMain = new Swiper("#gallery-main", {
        speed: 500,
        pagination: {
          el: ".prodigy-product__gallery-count",
          type: "fraction"
        },
        thumbs: {
          swiper: $("#gallery-thumbs").length ? this.swiperThumbs : null
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
      if (typeof code_happened === 'undefined' || window.code_happened == false) {
        window.code_happened = true;
        $(document).on("click", ".icon-fullscreen-js", this.open_photo_swipe.bind(this));
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
                title: img.attr("data-caption") ? img.attr("data-caption") : img.attr("title")
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
      var options = $.extend({
        index: index
      }, {});

      // Initializes and opens PhotoSwipe.
      var photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
      photoswipe.init();
    },
    set_bulk: function () {
      let self = this;
      $(document).on('enable-multiple-quantity', function (e, context) {
        let bulk_attr = $(context).data('attribute');
        if (typeof bulk_attr === "undefined") {
          bulk_attr = $('.bulk-container-js:visible').data('attribute');
        }
        let bulk_options = self.get_bulk_options(bulk_attr);
        self.set_variant_modifier(bulk_attr, bulk_options);
        if (product_logo_management_object.is_logo() && product_logo_management_object.logo_attribute === bulk_attr && prodigyProductBulk.is_active_logo_bulk) {
          product_logo_management_object.update_locations_availability(bulk_attr);
          product_logo_management_object.set_bulk_logo_option_validate(bulk_attr, bulk_options);
          product_logo_management_object.bulk_logo_validate(bulk_attr, bulk_options);
          product_logo_management_object.bulk_locations_validate();
          prodigyProductBulk.set_bulk_data();
        }
      });
    },
    get_bulk_options: function (bulk_attr) {
      let self = this;
      let $container = $(".bulk-container-" + bulk_attr + "-js");
      $(self.disable_bulk_button_element).attr('data-value', $container.data('slug'));
      let modifierOptions = [];
      if (product_logo_management_object.is_logo() && prodigyProductBulk.is_active_logo_bulk) {
        let $logo_bulk_container = $('.bulk-container-' + product_logo_management_object.logo_attribute + '-js');
        if (typeof bulk_attr !== "undefined") {
          $logo_bulk_container.each(function (e) {
            $(this).find(prodigyProductBulk.input_bulk_quantity_element).each(function (e) {
              let name = jQuery.trim($(this).data('option'));
              let id = $(this).data('option-id');
              modifierOptions.push({
                id: id,
                name: name
              });
            });
          });
        } else {
          let $selected_color = $('.attribute_values_js[data-slug="color"] option:selected');
          if ($selected_color.length > 0) {
            let name = $selected_color.data('slug');
            let id = $selected_color.data('option-id');
            modifierOptions.push({
              id: id,
              name: name
            });
          }
        }
      }
      return modifierOptions;
    },
    set_variant_modifier: function (attribute, modifierOptions = []) {
      let self = this;
      if (modifierOptions.length === 0) {
        $('.bulk-container-' + attribute + '-js').each(function (e) {
          $(this).find(prodigyProductBulk.input_bulk_quantity_element).each(function (e) {
            let name = jQuery.trim($(this).data('option'));
            let id = $(this).data('option-id');
            modifierOptions.push({
              id: id,
              name: name
            });
          });
        });
      }
      if (self.is_variants()) {
        let attributes = self.get_attributes_for_query();
        if (Object.keys(attributes.attribute).length === 1 && $('.bulk-container-js').length === 1) {
          attributes.attribute = [];
        }
        if (Object.keys(self.clear_selected_attributes(attributes.attribute)).length > 1) {
          for (const [key, value] of Object.entries(attributes.attribute)) {
            let selected_value = $(self.disable_bulk_button_element).data('value');
            if (value === selected_value) {
              delete attributes.attribute[key];
            }
          }
        }
        prodigyProductBulk.get_bulk_variant_data(attributes.attribute, modifierOptions);
      }
    },
    clear_selected_attributes: function (values) {
      $.each(values, function (key, val) {
        if ('Choose an option' === val) {
          delete values[key];
        }
      });
      return values;
    },
    set_subscription_id: function () {
      this.subscription_id = $('.subscription_id').val();
    },
    set_elementor_options: function () {
      let is_show_regular_price = $('#regular_price_state_option').val();
      if (is_show_regular_price !== 'yes') {
        $('.regular-price-container').remove();
      } else {
        $('.regular-price-container').show();
      }
      this.set_subscriptions();
      if (this.is_bulk()) {
        this.open_bulk_option();
      }
    },
    open_bulk_option: function () {
      let i = 0;
      $('.bulk-container-js').each(function () {
        if (settings.is_show_certain_bulk_block && settings.number_certain_bulk_block == i) {
          prodigyProductBulk.open_bulk_options_mode($(this));
        }
        i++;
      });
    },
    format_subscription_price: function (price) {
      if (this.is_subscriptions()) {
        if (typeof parse_price(price) === 'undefined') {
          price = $('.sale-subscription-price-js').text();
        }
        let sale_price = $('.subscription-sale_price-js').val();
        let one_time_price = $('.prodigy-subscriptions-tab__item-price').find('.sale-price').text();
        $('.subscriptions-price-currency-js').show();
        if (parse_price(price) !== parse_price(sale_price)) {
          $('.subscriptions-regular-price-js').text(prodigy_price_format(parse_price(price)));
        }
        $('.product-default-info-price-js').text('$' + prodigy_price_format(parse_price(sale_price)));
        $('.prodigy-subscriptions-tab-js').trigger('click');
        if (parseFloat(one_time_price) !== parseFloat(price)) {
          $('.subscriptions-one-time-price-js').text('$' + prodigy_price_format(parse_price(price)));
          let one_time_sale_price = $('.prodigy-product-list__item-price-js').text();
          if (parse_price(one_time_sale_price) !== undefined) {
            $('.subscriptions-one-time-price-js').text(one_time_sale_price);
          }
        } else {
          $('.subscriptions-one-time-price-js').parent().hide();
        }
      }
    },
    is_need_replace_subscription_item: function (subscription_id) {
      let self = this;
      let remote_product_id;
      let attribute_values_js = $(".attribute_values_js");

      // if isset variants
      if (attribute_values_js.length > 0) {
        remote_product_id = $(self.add_to_cart_button_element).attr("data-remote-id");
      } else {
        if (typeof self.remote_product !== 'undefined') {
          remote_product_id = self.remote_product.remote_master_id_variant;
        }
      }
      if (typeof remote_product_id !== "undefined") {
        let post_data = {
          action: "prodigy-is-replace-subscription-item",
          remote_product_id: remote_product_id,
          one_time_order: self.is_one_time_order
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
    is_user_personalization_validate: function () {
      let result = true;
      $('.prodigy-personalization__input-js').each(function () {
        if ($(this).val().trim() === '' && $(this).data('required') !== "") {
          $(this).closest('.prodigy-personalization__label-js').addClass('prodigy-personalization__field-has-error');
          result = false;
        }
      });
      return result;
    },
    delete_personalization_errors: function () {
      $('.prodigy-personalization__label-js').each(function () {
        $(this).removeClass('prodigy-personalization__field-has-error');
      });
    },
    get_personalization_data: function () {
      let myObj = [];
      $('.prodigy-personalization__input-js').each(function (key) {
        let obj = {
          personalization_id: $(this).data('id'),
          personalization_field_id: $(this).data('field-id'),
          label: $(this).attr('name'),
          value: $(this).val()
        };
        myObj.push(obj);
      });
      return myObj;
    },
    add_item_to_cart: function () {
      let self = this;
      $(document).off("click", "button.add-to-cart-js, button.replace-subscription-condition-js").on("click", "button.add-to-cart-js, button.replace-subscription-condition-js", function (e) {
        if (!self.validate_options() && !self.is_bulk_opened()) {
          return;
        }
        if (!self.is_user_personalization_validate()) {
          return;
        } else {
          self.delete_personalization_errors();
        }
        let remote_product_id;
        let attribute_values_js = $(".attribute_values_js");
        let attribute_swatch_js = $(self.prodigy_product_swatch_element);
        let current_button = $(this).attr('data-name');
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
          if (attribute_values_js.length > 0 || attribute_swatch_js.length > 0) {
            remote_product_id = $(this).attr("data-remote-id");
          } else {
            if (typeof self.remote_product !== 'undefined') {
              remote_product_id = self.remote_product.id;
            }
          }
          if (typeof remote_product_id === 'undefined') {
            remote_product_id = $(self.add_to_cart_button_element).attr("data-remote-id");
          }
          self.set_analytic_add_item_to_cart();
          let form_count_products = $(self.product_counter_input_element).val();
          let logo_option_ids = product_logo_management_object.get_logo_options();
          if (product_logo_management_object.is_logo_swatches()) {
            logo_option_ids = product_logo_management_object.get_logos_options_swatches();
          }
          if (self.is_validate_options()) {
            if (self.is_bulk_opened()) {
              self.add_to_cart(form_count_products, self.bulk_variants_info, prodigyProductBulk.bulkVariants, self.get_personalization_data(), null, null, false, true, logo_option_ids);
            } else {
              // set items in remote cart
              self.add_to_cart(form_count_products, remote_product_id, self.get_attributes_for_query(), self.get_personalization_data(), self.get_current_product_price(), self.subscription_id, self.is_subscription_replaced, false, logo_option_ids);
            }
          }
        }
      });
    },
    get_quantity_of_products: function () {
      let self = this;
      let products_quantity = 0;
      if (prodigyProductBulk.is_active_logo_bulk) {
        $(this.bulk_container_element).each(function (e) {
          let is_visible = $(this).is(':visible');
          if (is_visible) {
            $(this).find(self.input_bulk_quantity_element).each(function (e) {
              let bulk_input_value = parseInt($(this).val());
              if (!isNaN(bulk_input_value)) {
                products_quantity += bulk_input_value;
              }
            });
          }
        });
      } else {
        products_quantity = $(self.product_counter_input_element).val();
      }
      return products_quantity;
    },
    get_bulk_variants_data: function (quantity, selected_variant_options) {
      this.bulkVariants = selected_variant_options;
      this.bulkTotalQuantity = quantity;
      if (this.is_validate_options()) {
        this.get_variant_data(selected_variant_options, quantity, null, true);
      }
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
    get_attributes_for_query: function () {
      let attribute_values_js = $('.attribute_values_js:not(.ignored)');
      let attribute_swatch = $('.prodigy-product__swatch-block-js:not(.ignored)');
      let attributes = {
        attribute: {},
        item: {}
      };
      attribute_values_js.each(function (key) {
        let $option = $(this).find("option:selected");
        attributes["attribute"][key] = $option.data('slug');
        attributes["item"][key] = $option.text();
      });
      attribute_swatch.find('.prodigy-product__swatch-js').each(function (key) {
        if ($(this).is(':checked')) {
          attributes["attribute"][key] = $(this).data('slug');
          attributes["item"][key] = $(this).val();
        }
      });
      return attributes;
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
    load_subscription_price: function () {
      let self = this;
      $('.prodigy-subscriptions-tab-js').each(function () {
        self.set_subscription_options($(this));
      });
    },
    set_subscription_additional_price: function (price, container) {
      let format_price_string = '$' + prodigy_price_format(price);
      let condition_string = container.parent().find('.subscription-condition-js').val();
      $('.product-default-info-price-js').text(format_price_string + ' (' + condition_string + ')');
    },
    activate_subscription_block: function (container) {
      $('.prodigy-subscriptions-radio-js').prop('checked', false);
      $('.prodigy-subscriptions-tab-js').removeClass('active');
      $(container).find('.prodigy-subscriptions-radio-js').prop('checked', true);
      container.addClass('active');
      $('.subscription-radio-js').prop('disabled', function (i, v) {
        return !v;
      });
    },
    set_subscription_price: function (container) {
      let subscription_price = $('.prodigy-subscriptions-wrap-price-js').text();
      $('.prodigy-additional-info-price-js').text(subscription_price).show();
    },
    get_current_product_price: function () {
      var self = this;
      var price = 0;
      var price_str = $(document).find(".sale-price").text().trim();
      if (self.is_subscriptions() && !self.is_one_time_order) {
        price = parseFloat(self.subscription_price);
      }
      if (self.is_one_time_order && price_str !== '') {
        price = prodigy_price_format(price_str).replace(/\,/g, '');
      }
      return price;
    },
    is_bulk: function () {
      return $(this.enable_bulk_element).length;
    },
    is_bulk_opened: function () {
      return $('.prodigy-bulk__wrap').is(":visible");
    },
    add_to_cart: function (number_of_product, remote_product_id, attributes_item, personalization = [], price = null, subscription_id = null, is_subscription_replaced = false, is_bulk = false, logo_ids = []) {
      let self = this;
      let post_data = {
        action: "prodigy-add-remote-cart",
        remote_product_id: remote_product_id,
        count: number_of_product,
        price: price,
        attributes: attributes_item,
        is_subscription_replaced: is_subscription_replaced,
        is_bulk: is_bulk,
        logos_ids: logo_ids,
        personalization: personalization,
        nonce: settings.nonce
      };
      self.show_cart_button_loader();
      if (!self.is_one_time_order) {
        post_data.subscription_id = subscription_id;
      }
      clearTimeout(self.timeoutAddToCartId);
      self.timeoutAddToCartId = setTimeout(function () {
        $.ajax({
          type: "post",
          data: post_data,
          dataType: "json",
          url: ajax_url,
          error: function (data) {
            if (self.is_tiered_price && data.error_code && data.error_code === 422) {
              self.show_tiered_price_modal(data);
              return;
            }
            if (window.prodigy_cart_widget !== undefined) {
              window.prodigy_cart_widget.cart_modal_trigger(true);
            }
            self.show_error(data.responseJSON.data);
          },
          success: function (data) {
            if (self.is_bulk_opened()) {
              prodigyProductBulk.reset_bulk_inputs();
            }
            if (window.prodigy_cart_widget !== undefined) {
              window.prodigy_cart_widget.cart_modal_trigger(false);
            }
            if (self.is_tiered_price && typeof data.error_code === "undefined" || !self.is_tiered_price) {
              self.cart_slide_open();
              if (!self.is_tiered_price) {
                $(self.product_counter_input_element).val(1);
              }
              self.show_add_to_cart_message();
              self.show_cart_message();
            }
            if (self.is_tiered_price) {
              self.get_tiered_prices_range_ajax();
            }
            self.hide_cart_button_loader();
            // redirect to cart page
            if ($(".cart-redirect-js").data("cart-redirect") === "redirect_to_cart") {
              var dinamic_cart_url = $('.pg-cart-url-js').data('attr');
              window.location.replace(dinamic_cart_url);
            }
          }
        });
      }, 500);
    },
    show_cart_button_loader: function () {
      $(this.add_to_cart_button_element).prop("disabled", true);
    },
    hide_cart_button_loader: function () {
      $(this.add_to_cart_button_element).prop("disabled", false);
    },
    show_tiered_price_modal: function (data) {
      let cart_slider = $('.prodigy-cart-slide-js');
      cart_slider.removeClass('prodigy-cart-slide--open');
      $('body').removeClass('overflow-hidden');
      if (typeof data.message !== undefined) {
        $('.tiered-price-message-js').text(data.message);
        $('#minorderQTY').modal('show');
      }
    },
    cart_slide_open: function () {
      let cart_slider = $('.prodigy-cart-slide-js');
      let slider = cart_slider.data('auto-open');
      if (slider === 'yes' || slider) {
        cart_slider.toggleClass('prodigy-cart-slide--open');
        $('body').toggleClass('overflow-hidden');
        setTimeout(function () {
          cart_slider.removeClass('prodigy-cart-slide--open');
          $('body').removeClass('overflow-hidden');
        }, 10000);
      }
    },
    set_checked_swatch: function () {
      let self = this;
      self.selectedVariant = [];
      let options = {};
      $(self.prodigy_product_swatch_element).each(function () {
        let swatch_block = $(this).closest('.prodigy-product__swatch-block-js');
        if ($(this).is(':checked') && !$(swatch_block).hasClass('ignored')) {
          let slug = $(this).data('slug');
          let attribute = swatch_block.data('attribute');
          $(this).closest('.swatch-container-js').find('.swatch-attribute-name-js').html("&nbsp;" + $(this).val());
          self.selectedVariant.push(slug);
          if ($(this).data('attribute') === product_logo_management_object.logo_attribute && product_logo_management_object.is_logo()) {
            options[0] = {
              name: slug
            };
            self.set_gallery(options, attribute);
            self.set_logo();
          }
          if (!product_logo_management_object.is_logo()) {
            options[0] = {
              name: slug
            };
            self.set_gallery(options, attribute);
            if (!product_logo_management_object.is_logo() && $(this).data('attribute') === product_logo_management_object.logo_attribute) {
              self.set_logo();
            }
          }
        }
      });
    },
    set_logo: function () {
      product_logo_management_object.update_forms_visibility();
      product_logo_management_object.init_logos_locations_form();
      if (product_logo_management_object.is_logo_swatches()) {
        product_logo_management_object.set_logos_swatches();
      } else {
        product_logo_management_object.set_logos();
      }
    },
    change_swatch_value: function () {
      let self = this;
      $(document).on('change', self.prodigy_product_swatch_element, function () {
        self.set_checked_swatch();
        if (!prodigyProductBulk.is_bulk_enabled()) {
          self.set_variant_data();
        }
        if (prodigyProductBulk.is_active_bulk) {
          prodigyProductBulk.activate_bulk_processes();
        }
        self.show_available_variants();
        if (self.is_bulk()) {
          $(this).parent().parent().closest('.prodigy-product__attr-item--no-select').find(self.enable_bulk_element).attr('data-value', $(this).data('slug'));
        }
      });
    },
    get_active_swatches: function () {
      let active_options = [];
      $('.prodigy-product__swatch-js:checked').each(function () {
        active_options.push($(this).data('slug'));
      });
      return active_options;
    },
    get_active_swatches_attributes: function () {
      let active_attributes = [];
      $('.prodigy-product__swatch-js:checked').each(function () {
        active_attributes.push($(this).closest('.prodigy-product__swatch-block-js').data('attribute'));
      });
      return active_attributes;
    },
    set_variant_data() {
      let logo_id = false;
      this.set_checked_swatch();
      if (this.is_variants() && this.is_validate_options()) {
        let number_of_items = parseInt($(this.product_counter_input_element).val());
        if (product_logo_management_object.is_logo()) {
          logo_id = product_logo_management_object.get_logo_id();
        }
        this.get_variant_data(this.get_selected_variant(), number_of_items, logo_id);
      }
    },
    get_selected_variant() {
      let self = this;
      let selectedVariant = [];
      if ($(self.prodigy_product_swatch_element).length > 0) {
        $(self.prodigy_product_swatch_element).each(function () {
          let swatch_block = $(this).closest('.prodigy-product__swatch-block-js');
          if ($(this).is(':checked') && !$(swatch_block).hasClass('ignored')) {
            let slug = $(this).data('slug');
            selectedVariant.push(slug);
          }
        });
      } else {
        $('.attribute_values_js').each(function () {
          let current_slug = $(this).find('option:selected').data('slug');
          if (!$(this).hasClass('ignored')) {
            selectedVariant.push(current_slug);
          }
        });
      }
      return selectedVariant;
    },
    set_active_bulk_attribute_name: function () {
      let self = this;
      $(prodigyProductBulk.bulk_container_element).each(function () {
        if ($(this).is(":visible")) {
          self.active_bulk_attribute_name = $(this).data('attribute');
        }
      });
    },
    set_variant_dropdown: function () {
      let is_variant_gallery_prev = this.is_variant_gallery;
      this.selectedVariant = [];
      this.is_variant_gallery = false;
      this.set_attribute_value_options();
      if (!this.is_bulk() && this.is_variant_gallery === false && is_variant_gallery_prev !== this.is_variant_gallery) {
        this.restore_default_image_gallery();
      }
      this.selectedVariant = [...new Set(this.selectedVariant)];
    },
    set_attribute_value_options: function () {
      let self = this;
      let $option = false;
      let options_list = {};
      $('.attribute_values_js').each(function () {
        $option = $(this).find("option:selected");
        if (typeof $option.data('slug') !== "undefined" && typeof $option.data('attribute') !== "undefined") {
          if ($(this).data('attribute') === product_logo_management_object.logo_attribute && product_logo_management_object.is_logo()) {
            options_list[0] = {
              name: $option.data('slug')
            };
            self.set_gallery(options_list, $option.data('attribute'));
            self.set_logo();
          }
          if (!product_logo_management_object.is_logo()) {
            options_list[0] = {
              name: $option.data('slug')
            };
            self.set_gallery(options_list, $option.data('attribute'));
            if (!product_logo_management_object.is_logo() && $(this).data('attribute') === product_logo_management_object.logo_attribute) {
              self.set_logo();
            }
          }
        }
        self.selected_attributes[$(this).data('slug')] = $option.data('slug');
        if (!$(this).hasClass('ignored') && $option.data('slug') !== '') {
          self.selectedVariant.push($option.data('slug'));
          if (self.is_bulk()) {
            $(this).parent().find(self.enable_bulk_element).attr('data-slug', $option.data('slug'));
          }
        }
      });
    },
    prepare_main_slider_slide: function (current_image_id, image_url, view_box = null, width = null, height = null, large_img = null) {
      let clone = $(this.main_slider_template).contents().clone();
      let svg = clone.find('.main-gallery-image-js').parent();
      let img = clone.find('img');
      if (width > 0) {
        img.attr('data-large_image_width', width);
      }
      if (height > 0) {
        img.attr('data-large_image_height', height);
      }
      if (large_img) {
        img.attr('data-large_image', large_img);
      }
      clone.find('.main-gallery-image-js').attr('href', image_url);
      clone.find('.main-gallery-image-js').attr('data-image-id', current_image_id);
      if (view_box) {
        svg.attr('viewBox', view_box);
      }
      return clone;
    },
    prepare_thumbnail_slider_slide: function (current_image_id, image_url, view_box) {
      let clone = $(this.thumb_slider_template).contents().clone();
      clone.find('image.thumb-gallery-image-js').attr('href', image_url);
      clone.find('image.thumb-gallery-image-js').attr('data-image-id', current_image_id);
      clone.find('svg').attr('viewBox', view_box);
      return clone;
    },
    set_gallery: function (slugs, attribute) {
      this.is_variant_gallery = true;
      let option_attributes = [];
      let option_images = '';
      let product_options = JSON.parse($('#product-options-data-js').val());
      $.each(product_options, function (i) {
        for (k in slugs) {
          if (attribute === i) {
            option_attributes.push(product_options[i][slugs[k].name]);
          }
        }
      });
      let images = [];
      for (let k in option_attributes) {
        if (typeof option_attributes[k].images === 'undefined') {
          return false;
        }
        for (i in option_attributes[k].images) {
          images.push(option_attributes[k].images[i]);
        }
      }
      if (images.length > 0) {
        this.swiperMain.removeAllSlides();
        if (this.is_gallery_thumbnails()) {
          this.swiperThumbs.removeAllSlides();
        }
        for (let i in images) {
          const attributes = images[i].attributes;
          const image_url = attributes['cropped-url'];
          const thumbnail_url = attributes['cropped-url'];
          let width = 0;
          let height = 0;
          let view_box = '0 0 800 1000';
          if (typeof attributes['cropping-params'] !== undefined && attributes['cropping-params'] !== null) {
            width = typeof attributes['cropping-params']['w'] !== undefined ? parseInt(attributes['cropping-params']['w']) : 0;
            height = typeof attributes['cropping-params']['h'] !== undefined ? parseInt(attributes['cropping-params']['h']) : 0;
            view_box = width > 0 && height > 0 ? '0 0 ' + width + ' ' + height : '0 0 800 1000';
          }
          const large_img = attributes.versions['large_retina'] ? attributes.versions['large_retina'] : '';
          let current_image_id = images[i].id;
          this.swiperMain.appendSlide(this.prepare_main_slider_slide(current_image_id, image_url, view_box, width, height, large_img));
          if (this.is_gallery_thumbnails()) {
            this.swiperThumbs.appendSlide(this.prepare_thumbnail_slider_slide(current_image_id, thumbnail_url, view_box));
          }
        }
      } else {
        this.restore_default_image_gallery();
      }
      if (option_attributes.images && typeof option_attributes[k].images[0] !== "undefined") {
        option_images = option_attributes[k].images[0].attributes;
      }
      $('.swiper-slide-active').find('.main-gallery-image-js').attr('href', option_images["cropped-url"]);
    },
    is_gallery_thumbnails: function () {
      return $('#gallery-thumbs').length > 0;
    },
    restore_default_image_gallery: function () {
      let images = $('#gallery-main').data('images');
      if (images.length !== 0) {
        this.swiperMain.removeAllSlides();
        this.swiperThumbs.removeAllSlides();
        for (i in images) {
          const image_url = images[i]['cropped-url'];
          const thumbnail_url = images[i].versions['thumbnails'];
          let view_box = '';
          if (typeof images[i]['cropping-params'] !== 'undefined' && images[i]['cropping-params'] !== null) {
            let width = typeof images[i]['cropping-params']['w'] !== 'undefined' ? images[i]['cropping-params']['w'] : 0;
            let height = images[i]['cropping-params']['h'] ? images[i]['cropping-params']['h'] : 0;
            view_box = height && width ? '0 0 ' + width + ' ' + height : '';
          }
          this.swiperMain.appendSlide(this.prepare_main_slider_slide(images[i].id, image_url, view_box));
          this.swiperThumbs.appendSlide(this.prepare_thumbnail_slider_slide(images[i].id, thumbnail_url, view_box));
        }
      }
    },
    choose_variant_dropdown: function () {
      let self = this;
      let $attribute_values = $('.attribute_values_js');
      if (!prodigyProductBulk.is_active_bulk) {
        this.show_available_variants();
      }
      this.set_variant_dropdown();
      if (this.get_selected_variant().length === $attribute_values.length) {
        this.isVariantSelected = true;
      }
      if (this.isVariantSelected && this.is_validate_options()) {
        self.show_cart_button_loader();
        if (this.is_variants()) {
          let number_of_items = parseInt($(self.product_counter_input_element).val());
          if (this.is_bulk_opened()) {
            prodigyProductBulk.set_bulk_data();
          } else {
            if (this.is_validate_options() && !self.is_bulk_opened()) {
              let logo_id = product_logo_management_object.get_logo_id();
              this.get_variant_data(this.get_selected_variant(), number_of_items, logo_id);
            }
          }
        }
      } else {
        this.is_one_time_order = true;
        this.show_master_variant_info();
        if (typeof self.remote_product.remote_master_variant_info !== "undefined") {
          let dimension_attrs = this.remote_product.remote_master_variant_info.dimension.attributes;
          this.set_shipping_data_variants(this.remote_product.remote_main_sku, dimension_attrs['weight-value'] + dimension_attrs['weight-unit'], dimension_attrs['depth-value'] + ' x ' + dimension_attrs['width-value'] + ' x ' + dimension_attrs['height-value'] + dimension_attrs['size-unit']);
        }
      }
    },
    get_variant_data: function (variant, number_of_items = null, logo_id = false, selector = null, is_bulk = false, bulk_attribute = false) {
      let self = this;
      let post_data = {
        action: "prodigy-public-get-variant-data",
        post_id: $("#product_id").val(),
        variants: variant,
        options: this.get_options(),
        number_of_items: number_of_items,
        is_bulk: is_bulk,
        bulk_attribute: bulk_attribute,
        logo_id: logo_id,
        is_personalization: this.is_personalization(),
        location: window.location.href,
        nonce: settings.nonce
      };
      clearTimeout(self.timeoutVariantsDataId);
      $(self.add_to_cart_button_element).prop("disabled", true);
      $(self.add_to_cart_button_element).removeAttr('data');
      self.timeoutVariantsDataId = setTimeout(function () {
        $.ajax({
          type: "post",
          data: post_data,
          dataType: "json",
          url: ajax_url,
          error: function (xhr, status, error) {
            $(self.add_to_cart_button_element).prop("disabled", true);
            $(self.add_to_cart_button_element).attr('data', 'loader');
          },
          success: function (response) {
            if (typeof response.data.result[0] !== "undefined") {
              self.variant = response.data.result[0];
              $('#variant-data-js').attr('data-variant', JSON.stringify(response.data.result[0]));
            }
            if (typeof self.variant === "undefined") {
              return;
            }
            $(self.add_to_cart_button_element).removeAttr('data');
            if (self.is_bulk_opened()) {
              $(self.add_to_cart_button_element).removeAttr("disabled");
              prodigyProductBulk.update_bulk_price(response.data);
              self.update_bulk_info(response.data.result);
              $('#variant-data-js').attr('data-bulk-variants', JSON.stringify(response.data));
            }
            if (typeof self.variant !== undefined && self.variant.subscriptions) {
              $('#subscriptions_block').html(self.variant.subscriptions);
            }
            self.set_variants_data(self.variant);
            if (!self.is_subscriptions()) {
              self.is_one_time_order = true;
            }
            self.set_shipping_data(self.variant);
            self.disable_add_to_cart_button_loader();
            if (!self.is_bulk_opened() && !self.is_variant_was_chosen) {
              self.set_tiered_prices(self.variant);
            }
          }
        });
      }, 500);
    },
    update_bulk_info: function (data) {
      this.bulk_variants_info = data;
    },
    is_subscriptions: function () {
      return $(document).find('.prodigy-subscriptions-tab').length > 0;
    },
    disable_add_to_cart_button_loader: function () {
      $(this.add_to_cart_button_element).prop("disabled", false);
    },
    set_tiered_prices: function (product) {
      this.min_quantity = product.tiered_prices_range.min_quantity;
      if (this.is_tiered_price) {
        localStorage.setItem("min_quantity", product.tiered_prices_range.min_quantity);
        if (parseFloat(product.tiered_prices_range.min_price) !== parseFloat(product.tiered_prices_range.max_price)) {
          let range_price_string = 'From $' + prodigy_price_format(product.tiered_prices_range.min_price) + ' to $' + prodigy_price_format(product.tiered_prices_range.max_price);
          $('.prodigy-product__main-price').text(range_price_string);
        }
        $(this.product_counter_input_element).val(product.tiered_prices_range.min_quantity);
        $(document).find(".counter-btn-minus-js").prop("disabled", true);
      }
    },
    set_shipping_data: function (product) {
      if (typeof product.dimension !== "undefined") {
        let dimension_attrs = product.dimension.attributes;
        this.set_shipping_data_variants(product.attributes.sku, dimension_attrs['weight-value'] + dimension_attrs['weight-unit'], dimension_attrs['depth-value'] + ' x ' + dimension_attrs['width-value'] + ' x ' + dimension_attrs['height-value'] + dimension_attrs['size-unit']);
      }
    },
    update_variants_dropdown: function () {
      let self = this;
      let variantsObj = $('div.variants-container-js');
      let variants = variantsObj.data('variants');
      if (variants !== 'undefined') {
        $('select[data-attribute]').each(function () {
          self.update_select($(this), variants, {});
        });
        let dropdownOpened = false;
        MsDropdown.make('.attribute_values_js', {
          enableAutoFilter: false,
          on: {
            open: function () {
              dropdownOpened = true;
            },
            change: function (data) {
              if (dropdownOpened) {
                self.choose_variant_dropdown();
                if (prodigyProductBulk.is_active_bulk) {
                  prodigyProductBulk.activate_bulk_processes();
                }
                self.show_available_variants();
                dropdownOpened = false;
                if (!product_logo_management_object.is_logo()) {
                  return;
                }
                if (product_logo_management_object.is_logo_swatches()) {
                  product_logo_management_object.set_logos_swatches();
                } else {
                  product_logo_management_object.set_logos();
                  $('.prodigy-logo-tool__container.opened .prodigy-logo-values-js').each(function () {
                    $(this).get(0).msDropdown.refresh();
                  });
                }
              }
            }
          }
        });
      }
    },
    is_variants: function () {
      let attributes = $('.variants-container-js').data('attributes');
      if (attributes !== undefined) return Boolean(attributes.length);
    },
    update_select: function ($select, variants, selected_attributes) {
      let attributes = $('.variants-container-js').data('attributes');
      let available_attributes = {};
      for (i in variants) {
        let variant = variants[i];
        for (j in attributes) {
          let attr_name = attributes[j];
          if (typeof variant[attr_name] !== 'undefined') {
            let value = Object.values(variant[attr_name])[0];
            if (value !== undefined) {
              if (available_attributes[attr_name] === undefined) {
                available_attributes[attr_name] = [];
              }
              available_attributes[attr_name][value.name] = value;
            }
          }
        }
      }
      if ($select.length > 0) {
        let attr_name = $select.data('attribute');
        let default_select_option = $('#default_select_option').val();
        $select.html('<option class="attributes_default_value-js prodigy-attr__default-value" value="">' + default_select_option + '</option>');
        let orderedVariants = [];
        Object.values(available_attributes[attr_name]).sort(this.compareBySort).forEach(function (variant) {
          orderedVariants.push(variant.name);
        });
        orderedVariants.forEach(function (i) {
          let attr_value_name = available_attributes[attr_name][i].name;
          let attr_value_slug = available_attributes[attr_name][i].slug;
          let attr_value_id = available_attributes[attr_name][i].option_id;
          let attr_value_logos = JSON.stringify(available_attributes[attr_name][i].logos);
          let attr_value_attribute = available_attributes[attr_name][i].attribute;
          let option = $('<option>').text(attr_value_name).val(attr_value_slug);
          let dataColorProperties = '';

          // set color like a picture
          if (available_attributes[attr_name][i].color != undefined) {
            const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute("width", "100");
            svg.setAttribute("height", "100");
            svg.style.backgroundColor = "black";
            const rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
            rect.setAttribute("width", "100%");
            rect.setAttribute("height", "100%");
            rect.setAttribute("fill", available_attributes[attr_name][i].color);
            svg.appendChild(rect);
            const svgData = new XMLSerializer().serializeToString(svg);
            const svgBase64 = btoa(svgData);
            const dataUrl = 'data:image/svg+xml;base64,' + svgBase64;
            option.attr('data-image', dataUrl);
          }
          if (available_attributes[attr_name][i].image !== undefined) {
            option.attr('data-image', available_attributes[attr_name][i].image);
          }
          option.addClass('attached enabled');
          if (dataColorProperties) {
            option.attr('style', '--data-color:' + dataColorProperties);
          }
          option.attr('data-attribute', attr_value_attribute);
          option.attr('data-logos', attr_value_logos);
          option.attr('data-slug', attr_value_slug);
          option.attr('data-option-id', attr_value_id);
          if (selected_attributes[attr_name] === attr_value_name || available_attributes[attr_name][i].default) {
            option.attr('selected', true);
          }
          $select.append(option);
        });
      }
    },
    compareBySort: function (a, b) {
      return a.sort - b.sort;
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
    set_analytic_add_item_to_cart: function () {
      if (settings.pg_google_track_id !== '') {
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
            "items": [{
              "id": remote_variant_id,
              "name": title,
              // "category": product.categories,
              "variant": sku,
              "price": self.get_actual_price(price, sale_price),
              "quantity": parseInt($(self.product_counter_input_element).val())
            }]
          });
        }
      }
    },
    /**
     * @version 2.0.0
     */
    change_product_quantity_analytic_event: function () {
      let self = this;
      if (settings.pg_google_track_id !== "") {
        let current_url = window.location.pathname.replace(/\/+$/, "");
        if (current_url.includes(settings.product_type)) {
          let old_quantity = parseInt($(self.product_counter_input_element).val());
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
              "items": [{
                "id": remote_variant_id,
                "name": title,
                "sku": sku,
                "price": self.get_actual_price(price, sale_price),
                "new_quantity": parseInt($(self.product_counter_input_element).val()),
                "old_quantity": old_quantity
              }]
            });
          });
        }
      }
    },
    /**
     * @version 2.0.0
     * @param data
     */
    set_view_product_analytic_event: function (data) {
      let current_url = window.location.pathname.replace(/\/+$/, "");
      if (typeof data.attributes !== "undefined") {
        let price = data.attributes.price;
        let sku = data.attributes.sku;
        /**
         * TODO check title in api
         */
        let title = data.attributes.sku;
        let sale_price = data.attributes['sale-price'];
        let remote_variant_id = data.remote_variant_id;
        if (typeof current_url.includes(settings.product_type)) {
          let self = this;
          gtag('event', 'view_variant', {
            "event_category": 'prodigy_product',
            "items": [{
              "id": remote_variant_id,
              "name": title,
              // "category": data.categories,
              "variant": sku,
              "price": self.get_actual_price(price, sale_price)
            }]
          });
        }
      }
    },
    captcha_callback: function (val) {
      $(".recaptcha-checkbox").attr("aria-checked", true);
      this.check_enable_comment_fields();
    },
    reset_focus_to_press_enter: function () {
      let self = this;
      $(document).on("keypress blur focusout", self.product_counter_input_element, function (e) {
        self.update_counter_of_products(self, $(this));
      });
    },
    update_counter_of_products: function (self, container) {
      let number_of_items = parseInt($(self.product_counter_input_element).val());
      if (this.is_tiered_price && this.is_variants() && this.is_validate_options()) {
        let logo_id = product_logo_management_object.get_logo_id();
        this.get_variant_data(this.get_selected_variant(), number_of_items, logo_id);
      } else if (this.is_tiered_price && this.is_validate_options()) {
        this.get_master_variant_data(number_of_items);
      }
      if (parseInt(container.val()) > 1) {
        $(".counter-btn-minus-js").prop("disabled", false);
      }
    },
    send_captcha: function () {
      $(".submit-product-button").click(function (e) {
        var response;
        $.ajax({
          type: "post",
          data: $("#commentform").serialize() + "&action=google-captcha-url",
          dataType: "json",
          url: ajax_url,
          async: false,
          success: function (data) {
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
    send_review_for_user: function () {
      var is_admin = this.is_admin;
      $(document).on('submit', 'form#commentform', function (e) {
        e.preventDefault();
        $('#submit').addClass('prodigy-main-button--loading');
        var form = $('form#commentform');
        $.ajax({
          type: 'POST',
          url: form.attr('action'),
          data: form.serialize(),
          error: function (error) {
            $('#reviewModal').modal('toggle');
            $('#reviewModalSuccess').modal('toggle');
            $('.prodigy-reviews-ratings__btn').hide();
            $('.review-message-popup-js').text('Couldn\'t submit a review. Please try again later.');
          },
          success: function (respond_data) {
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
      $(self.add_to_cart_button_element).prop("disabled", true);
      self.show_cart_message();
      self.show_view_cart_btn();
      setTimeout(function () {
        $(self.add_to_cart_button_element).prop("disabled", false);
      }, 5000);
    },
    show_error: function (message, type = "success") {
      let self = this;
      let add_to_cart_message = $(".widget-cart-message-error-js");
      add_to_cart_message.find("span").html(message);
      add_to_cart_message.show();
      add_to_cart_message.delay(5000).fadeOut("slow");
      if (type === "error") {
        add_to_cart_message.addClass("prodigy-cart-dropdown__error-alert");
      }
      self.hide_cart_button_loader();
    },
    disable_submit_comment: function () {
      let self = this;
      self.check_enable_comment_fields();
      $(document).on('input', "#comment", function (e) {
        self.check_enable_comment_fields();
      });
      $(document).on('input', ".comment-author-js", function (e) {
        self.check_enable_comment_fields();
      });
      $(document).on('input', ".comment-email-js", function (e) {
        self.check_enable_comment_fields();
      });
      $("body").on("change", "#prodigy-rating", function (e) {
        self.check_enable_comment_fields();
      });
    },
    check_enable_comment_fields: function () {
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
        } else if (typeof rating_val !== 'undefined') {
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
          } else if (captcha.length == 0 && !this.is_admin && !is_rating_enable && !is_email_enable) {
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
      } else {
        comment_submit.prop("disabled", true);
      }
    },
    set_shipping_data_variants: function (sku, weight, dimension) {
      let prodigy_additional_weight_js = $('.prodigy-additional-weight-js');
      let prodigy_additional_dimensions_js = $('.prodigy-additional-dimensions-js');
      let product_sku_value = $('.product_sku_value');
      prodigy_additional_weight_js.text(weight);
      prodigy_additional_dimensions_js.text(dimension);
      product_sku_value.text(sku);
    },
    counter_reset: function () {
      $(this.product_counter_input_element).val(1);
    },
    set_product_counter: function () {
      let self = this;
      const counterCount = $(self.product_counter_input_element);
      counterCount.inputmask({
        regex: "^[1-9][0-9]*|$",
        rightAlign: false
      });
      $(document).on("click", '.counter-btn-minus-js', function () {
        let number_of_items = parseInt($(self.product_counter_input_element).val()) - 1;
        if (!self.is_bulk_opened()) {
          if (self.is_tiered_price && self.is_variants() && self.is_validate_options()) {
            let logo_id = product_logo_management_object.get_logo_id();
            self.get_variant_data(self.get_selected_variant(), number_of_items, logo_id);
          } else if (self.is_tiered_price && self.is_validate_options()) {
            self.get_master_variant_data(number_of_items);
          }
        }
        $(self.add_to_cart_button_element).prop("disabled", false);
        const counterCount = $(self.product_counter_input_element);
        const minusBtn = $(".counter-btn-minus-js");
        let counter = parseInt(counterCount.val());
        if (counter !== self.min_quantity) {
          counterCount.val(--counter);
          if (counter <= self.min_quantity) {
            minusBtn.prop("disabled", true);
          }
        }
      });
      $(document).off("click", ".counter-btn-plus-js").on("click", ".counter-btn-plus-js", function () {
        self.get_inventory_data();
        let number_of_items = parseInt($(self.product_counter_input_element).val()) + 1;
        if (!self.is_bulk_opened()) {
          if (self.is_tiered_price && self.is_variants() && self.is_validate_options()) {
            let logo_id = product_logo_management_object.get_logo_id();
            self.get_variant_data(self.get_selected_variant(), number_of_items, logo_id);
          } else if (self.is_tiered_price && self.is_validate_options()) {
            self.get_master_variant_data(number_of_items);
          }
        }
        const counterCount = $(self.product_counter_input_element);
        let counter = parseInt(counterCount.val());
        const minusBtn = $(".counter-btn-minus-js");
        counterCount.val(++counter);
        if (counter > self.min_quantity) {
          minusBtn.prop("disabled", false);
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
      clearTimeout(self.timeouInventorytId);
      self.timeouInventorytId = setTimeout(function () {
        $.ajax({
          type: "post",
          data: post_data,
          dataType: "json",
          url: ajax_url,
          success: function (data) {
            if (typeof data.attributes !== 'undefined') {
              self.set_stock_status(data.attributes);
            }
          }
        });
      }, 500);
    },
    set_stock_status: function (inventory, is_variant) {
      let self = this;
      let inventory_quantity = parseInt(localStorage.getItem("items_quantity"));
      if (inventory['manage-stock'] && !inventory['backorderable'] && inventory_quantity > 0) {
        self.maxItems = inventory_quantity;
      }
      if (inventory['manage-stock']) {
        if ($(".attribute_values_js").length !== 0 && !is_variant || inventory_quantity === 0) {
          self.set_out_of_stock_status();
        } else {
          self.disable_minus_button();
          self.set_in_stock_status(inventory);
        }
      } else if (is_variant && inventory['manage-stock'] && inventory['backorderable'] && inventory['stock'] === 'in_stock' && inventory_quantity === 0) {
        self.set_in_stock_status(inventory);
      } else if (is_variant && !inventory['manage-stock'] && inventory['stock'] === 'in_stock') {
        self.set_in_stock_status(inventory);
      } else if (is_variant && !inventory['manage-stock'] && inventory['stock'] === 'out_of_stock') {
        self.set_out_of_stock_status();
      }
    },
    is_swatches: function () {
      return $(".prodigy-product__swatch-block-js").length !== 0;
    },
    show_product_data: function (data_object, price, sale_price, subscriptions, inventory = [], items_quantity = 1, is_selected_variant = false) {
      if (!is_selected_variant && $('.main-price-js').text() !== prodigy_price_format(price)) {
        localStorage.setItem('product-range', $('.main-price-js').text().trim());
      }
      this.show_product_price(price, sale_price, data_object.tiered_price, items_quantity, is_selected_variant);
      if (this.is_subscriptions()) {
        this.show_subscription_block(is_selected_variant, subscriptions, price);
        this.format_subscription_price(price);
      }
      this.show_variant_inventory(inventory);
      this.show_variant_sku(data_object);
    },
    show_variant_inventory: function (inventory) {
      if (typeof inventory.attributes !== "undefined") {
        localStorage.setItem("items_quantity", inventory.attributes.count);
        this.show_status(inventory.attributes, true, true);
        this.clear_default_info();
        this.is_variant_was_chosen = true;
        if (this.is_tiered_price) {
          const counterCount = $(self.product_counter_input_element);
          let counter = parseInt(counterCount.val());
          const minusBtn = $(".counter-btn-minus-js");
          counterCount.val(counter);
          if (counter > self.min_quantity) {
            minusBtn.prop("disabled", false);
          }
        } else if (inventory.attributes['manage-stock']) {
          this.counter_reset();
        }
      }
    },
    show_subscription_block: function (is_selected_variant, subscriptions, price) {
      let default_info = $('.product-default-info-js');
      default_info.show();
      if (is_selected_variant) {
        default_info.hide();
        if (subscriptions) {
          $('.prodigy-subscriptions-tab-js:first').trigger('click');
          $('.prodigy-product__price-wrapper').hide();
        } else {
          $('.prodigy-product__price-wrapper').show();
        }
        this.show_subscription_price(price);
      } else if (this.is_subscriptions()) {
        $('.product-default-info-price-js').text('$' + price);
      }
    },
    show_subscription_price: function (price) {
      let sale_price = $('.subscription-sale_price-js').val();
      if (sale_price !== price && typeof sale_price !== 'undefined') {
        let price = this.get_current_product_price();
        let price_string = '$' + prodigy_price_format(price);
        $('.prodigy-product__prop-txt-price').text(price_string).show();
      }
    },
    calculate_product_price: function (start_price, sale_price = null, tiered_price = null, items_quantity = 1) {
      let logo_price = 0;
      let total_price = 0;
      let actual_price = 0;
      let total_price_with_personalization = 0;
      let personalization_price = 0;
      if (tiered_price !== undefined && parseFloat(tiered_price) > 0) {
        actual_price = prodigy_price_format(parseFloat(tiered_price));
        total_price = actual_price * items_quantity;
      } else {
        actual_price = this.get_actual_price(start_price, sale_price);
        total_price = actual_price * items_quantity;
      }
      if (product_logo_management_object.is_logo()) {
        logo_price = product_logo_management_object.get_logos_price() * items_quantity;
        total_price = total_price + logo_price;
      }
      if (this.is_personalization()) {
        if (this.is_personalization_filled()) {
          personalization_price = this.calculate_personalization_price(actual_price) * items_quantity;
          total_price = total_price + personalization_price;
        } else {
          total_price_with_personalization = total_price + this.calculate_personalization_price(actual_price) * items_quantity;
          $('.prodigy-product__main-price').data('personalization-price', parseFloat(total_price_with_personalization));
        }
      }
      $('.prodigy-product__main-price').data('total-price', total_price);
      return total_price;
    },
    show_product_price: function (price, sale_price, tiered_price, items_quantity, is_selected_variant) {
      let attribute_select = $(".attribute_values_js");
      let subscription_block = $('.subscriptions');
      let main_currency_js = $('.main-price-currency-js');
      let main_price_js = $(".main-price-js");
      let sale_price_info = $(".sale-price-container");
      let regular_price_info = $(".regular-price-container");
      let stock_info = $(".prodigy-product-stock-js");
      let sale_price_value_block = $(".sale-price");
      let top_product_price = $('.prodigy-product__main-price');
      let master_product_price = $('.prodigy-product__price-wrapper');
      let total_price = this.calculate_product_price(price, sale_price, tiered_price);
      const hasAttributesOrSwatches = attribute_select.length !== 0 || this.is_swatches();
      const isVariantSelected = is_selected_variant;
      if (hasAttributesOrSwatches && !isVariantSelected) {
        this.handle_stock_and_price_info(stock_info, regular_price_info, sale_price_info);
        subscription_block.hide();
        main_currency_js.hide();
        this.set_price_text(main_price_js, localStorage.getItem('product-range'));
      } else {
        const formattedTotalPrice = parseFloat(total_price) >= 0 ? '$' + prodigy_price_format(parseFloat(total_price)) : '';
        if (formattedTotalPrice) {
          if (this.is_sale_price_valid(sale_price)) {
            if (price === "") {
              this.handle_stock_and_price_info(stock_info, regular_price_info, sale_price_info);
            } else {
              this.set_price_text(main_price_js, formattedTotalPrice);
              this.show_elements(regular_price_info, sale_price_info, stock_info);
            }
            if (!sale_price) {
              sale_price_info.show();
              if (price) {
                sale_price_value_block.text(formattedTotalPrice);
                top_product_price.text(formattedTotalPrice);
                master_product_price.text(formattedTotalPrice);
                regular_price_info.hide();
              }
            } else {
              sale_price_value_block.text(formattedTotalPrice);
            }
            regular_price_info.hide();
          } else {
            this.handle_stock_and_price_info(stock_info, regular_price_info, sale_price_info);
          }
        } else {
          this.handle_stock_and_price_info(stock_info, regular_price_info, sale_price_info);
        }
      }
    },
    hide_elements: function (...elements) {
      elements.forEach(element => element.hide());
    },
    show_elements: function (...elements) {
      elements.forEach(element => element.show());
    },
    set_price_text: function (priceElement, price) {
      priceElement.text(price);
    },
    is_sale_price_valid: function (salePrice) {
      return typeof salePrice !== "undefined" && parseInt(salePrice) !== 0;
    },
    handle_stock_and_price_info: function (stock_info, regular_price_info, sale_price_info) {
      this.hide_elements(stock_info, regular_price_info, sale_price_info);
    },
    input_personalization_field: function () {
      let self = this;
      $('.prodigy-personalization__input-js').on('input', function () {
        if (prodigyProductBulk.is_active_logo_bulk) {
          let bulk_data = $('#variant-data-js').data('bulk-variants');
          prodigyProductBulk.update_bulk_price(bulk_data);
          self.update_bulk_info(bulk_data.result);
        } else {
          if (self.is_variants()) {
            let variant_data = $('#variant-data-js').data('variant');
            self.set_variants_data(variant_data);
            self.set_shipping_data(variant_data);
            self.disable_add_to_cart_button_loader();
            if (!self.is_bulk_opened() && !self.is_variant_was_chosen) {
              self.set_tiered_prices(variant_data);
            }
          }
        }
      });
    },
    is_personalization_filled: function () {
      let is_personalization_filled = false;
      $('.prodigy-personalization__input-js').each(function () {
        if ($(this).val().length > 0) {
          is_personalization_filled = true;
        }
      });
      return is_personalization_filled;
    },
    is_personalization: function () {
      return $('#personalization-price-modifier-js').length > 0;
    },
    calculate_personalization_price: function (price) {
      let personalization_modifier_type = $('#personalization-price-modifier-js').val();
      let personalization_modifier_value = $('#personalization-price-value-js').val();
      let personalization_price;
      if (personalization_modifier_type && personalization_modifier_value) {
        if (personalization_modifier_type === 'flat') {
          personalization_price = parseFloat(personalization_modifier_value);
        } else {
          personalization_price = prodigy_price_format(parseFloat(price) * personalization_modifier_value / 100);
        }
      } else {
        personalization_price = price;
      }
      return personalization_price;
    },
    show_master_variant_info: function () {
      let self = this;
      if (typeof this.remote_product !== "undefined" && this.remote_product.remote_main_price !== null) {
        let subscriptions = false;
        if (typeof this.remote_product.remote_master_variant_info !== 'undefined') {
          subscriptions = typeof this.remote_product.remote_master_variant_info['subscription-plan'] !== 'undefined';
        }
        let price = 0;
        let sale_price = 0;
        if (typeof this.remote_product.remote_main_price !== 'undefined') {
          price = this.remote_product.remote_main_price.price;
          sale_price = this.remote_product.remote_main_price['sale-price'];
          this.show_product_data(this.remote_product, price, sale_price, subscriptions, this.remote_product.remote_master_variant_info.inventory, this.get_quantity_of_products());
        }
        self.show_master_product_info();
      }
    },
    show_master_product_info: function () {
      let self = this;
      if (typeof this.remote_product !== 'undefined' && typeof this.remote_product.remote_master_variant_info !== "undefined" && this.remote_product.remote_master_variant_info.inventory && typeof this.remote_product.remote_master_variant_info.inventory.attributes !== "undefined") {
        localStorage.setItem("items_quantity", this.remote_product.remote_master_variant_info.inventory.attributes.count);
      }
      if (!self.is_variants()) {
        self.hide_cart_button_loader();
      }
      if (typeof this.remote_product.remote_master_variant_info !== 'undefined' && typeof this.remote_product.remote_master_variant_info.inventory !== 'undefined') {
        this.show_status(this.remote_product.remote_master_variant_info.inventory.attributes, self.is_variants(), false);
        self.clear_default_info();
      }
      if (this.product.meta && typeof this.product.meta.product_sku !== "undefined" && this.product.meta.product_sku[0]) {
        var main_product_sku = this.product.meta.product_sku[0];
        $(".product_sku_value").text(main_product_sku);
      }
      if (!self.is_subscriptions()) {
        self.is_one_time_order = true;
      }
      self.load_subscription_price();
    },
    get_tiered_prices_range_ajax: function () {
      let self = this;
      let post_data = {
        action: "prodigy-get-tiered-prices-range",
        product_id: this.master_variant_id,
        nonce: settings.nonce
      };
      clearTimeout(self.timeoutTieredtId);
      self.timeoutTieredtId = setTimeout(function () {
        $.ajax({
          type: "post",
          data: post_data,
          dataType: "json",
          url: ajax_url,
          success: function (data) {
            self.min_quantity = data.data.min_quantity;
            if (self.is_tiered_price && !self.is_variant_was_chosen) {
              localStorage.setItem("min_quantity", data.data.min_quantity);
              $(self.product_counter_input_element).val(data.data.min_quantity);
              $(document).find(".counter-btn-minus-js").prop("disabled", true);
            }
            if (parseFloat(data.data.min_price) !== parseFloat(data.data.max_price)) {
              let range_price_string = 'From $' + prodigy_price_format(data.data.min_price) + ' to $' + prodigy_price_format(data.data.max_price);
              $('.prodigy-product__main-price').text(range_price_string);
            }
          }
        });
      }, 500);
    },
    show_status: function (inventory, has_variant, select_variant) {
      let self = this;
      let inventory_quantity = parseInt(localStorage.getItem("items_quantity"));
      if (typeof inventory_quantity !== "undefined" && inventory['manage-stock']) {
        self.maxItems = inventory_quantity;
      }
      let is_variant = has_variant && select_variant || !has_variant;
      if (typeof inventory.stock !== "undefined") {
        self.set_stock_status(inventory, is_variant);
      }
    },
    clear_default_info: function () {
      $('.product-default-info-price-js').hide();
      $('.product-default-info-js').hide();
    },
    disable_minus_button: function () {
      var minus = $(".counter-btn-minus-js");
      if (parseInt($(self.product_counter_input_element).val()) === self.min_quantity) {
        minus.prop("disabled", true);
      } else {
        minus.prop("disabled", false);
      }
    },
    set_out_of_stock_status: function () {
      $(".prodigy-product-stock-js").text(this._stock_status_mapper['out_of_stock']);
    },
    set_in_stock_status: function (inventory) {
      let plus = $(".counter-btn-plus-js");
      let count_input = $(self.product_counter_input_element);
      count_input.prop("disabled", false);
      plus.prop("disabled", false);
      $(this.add_to_cart_button_element).prop("disabled", false);
      let counter = inventory.count !== null ? inventory.count : '';
      $(".prodigy-product-stock-js").show();
      $(".prodigy-product-stock-js").text(this._stock_status_mapper[inventory.stock] + ' ' + counter);
    },
    get_actual_price: function (price, sale_price) {
      if (sale_price === '' || !sale_price) {
        return parseFloat(price);
      } else {
        return parseFloat(sale_price);
      }
    },
    set_variants_data: function (data) {
      let self = this;
      if (typeof data !== 'undefined') {
        if (settings.pg_google_track_id !== "" && typeof settings.pg_google_track_id !== "undefined") {
          self.set_view_product_analytic_event(data);
        }
        if (typeof data.inventory !== "undefined" && typeof data.inventory.attributes.count !== "undefined") {
          this.show_product_data(data.attributes, data.attributes.price, data.attributes['sale-price'], data['subscription-plan'], data.inventory, this.get_quantity_of_products(), true);
        }
        self.set_product_data_for_cart(data);
        self.load_subscription_price();
      }
    },
    show_variant_sku: function (attributes) {
      let sku;
      if (typeof attributes !== "undefined" && attributes.sku) {
        sku = attributes.sku;
      }
      if (sku !== "" && typeof sku !== "undefined") {
        $(".product_sku_value").text(sku);
      } else {
        $(".prodigy-product__tags-item product_sku").hide();
      }
    },
    set_product_data_for_cart: function (data_variant) {
      let self = this;
      if (typeof data_variant !== "undefined") {
        if (typeof data_variant.remote_variant_id !== "undefined") {
          $(self.add_to_cart_button_element).attr("data-remote-id", data_variant.remote_variant_id);
        }
        if (typeof data_variant.local_variant_id !== "undefined") {
          $(self.add_to_cart_button_element).attr("data-local-id", data_variant.local_variant_id);
        }
      }
    },
    /**
     * Get obj remote product info
     *
     * @version 2.0.0
     */
    get_master_variant_data: function (number_of_items = 1) {
      let post_data = {
        action: "prodigy-get-master-variant-data",
        post_id: this.master_variant_id,
        items_number: number_of_items,
        nonce: settings.nonce
      };
      let self = this;
      $.ajax({
        type: "post",
        data: post_data,
        dataType: "json",
        url: ajax_url,
        success: function (data) {
          self.remote_product = data.data;
          if (typeof settings.is_captcha !== 'undefined' && settings.is_captcha !== '' && typeof settings.captcha_site_key !== 'undefined' && settings.captcha_site_key !== '') {
            let is_admin = $(document).find('#user-role-js').data('attr');
            if (!is_admin) {
              grecaptcha.render('captcha', {
                'sitekey': settings.captcha_site_key
              });
            }
          }
          if (typeof data.data !== 'undefined') {
            self.variant = data.data.remote_master_variant_info;
          }
          self.show_master_variant_info();
          self.add_item_to_cart();
        }
      });
    },
    show_tab_description: function () {
      $("body").on("click", ".show-description-js", function () {
        $(".description_tab").addClass("active").show();
        $("#tab-description").show();
        $("#tab-li-reviews").removeClass("active");
        $(".additional_information_tab").removeClass("active");
        $(".reviews_tab").removeClass("active");
        $(".tiered_prices_tab").removeClass("active");
        $("#tab-additional_information").hide();
        $("#tab-reviews").hide();
        $("#tab-tiered_prices").hide();
      });
    },
    show_tab_review: function () {
      $("body").on("click", ".prodigy-review-link-js", function () {
        $("#tab-reviews").addClass("active").show();
        $("#tab-li-reviews").addClass("active");
        $("#tab-description").hide();
        $("#tab-additional_information").hide();
        $("#tab-tiered_prices").hide();
        $(".description_tab").removeClass("active");
        $(".tiered_prices_tab").removeClass("active");
        $(".additional_information_tab").removeClass("active");
        $(".reviews_tab").addClass("active");
        if (document.getElementById("tab-reviews")) {
          document.getElementById("tab-reviews").scrollIntoView();
        }
      });
    },
    set_product_tabs: function () {
      $(".description_tab").addClass("active");
      $("#tab-additional_information").hide();
      $("#tab-reviews").hide();
      var product_url = $('.product-url-js').val();
      $(document).on('click', '.tiered_prices_tab, .show-description-js, .description_tab, .additional_information_tab, .reviews_tab', function () {
        $('html,body').animate({
          scrollTop: $(this).offset().top
        }, 500);
      });
      $("body")
      // Tabs
      .on("init", ".prodigy-tabs-js, .prodigy-tabs", function () {
        $(".pg-tab, .prodigy-tabs .panel:not(.panel .panel)").hide();
        var hash = window.location.hash;
        var url = window.location.href;
        var $tabs = $(this).find(".pg-tabs, ul.tabs").first();
        if (hash.toLowerCase().indexOf("comment-") >= 0 || hash === "#reviews" || hash === "#tab-reviews") {
          $tabs.find("li.reviews_tab a").click();
        } else if (url.indexOf("comment-page-") > 0 || url.indexOf("cpage=") > 0) {
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
      }).on("click", ".pg-tabs li a, ul.tabs li a", function (e) {
        var $tab = $(this);
        var $tabs_wrapper = $tab.closest(".prodigy-tabs-js, .prodigy-tabs");
        var $tabs = $tabs_wrapper.find(".pg-tabs, ul.tabs");
        $tabs.find("li").removeClass("active");
        $tabs_wrapper.find(".pg-tab, .panel:not(.panel .panel)").hide();
        $tab.closest("li").addClass("active");
        $tabs_wrapper.find($tab.data("href")).show();
      })

      // Star ratings for comments
      .on("init", "#prodigy-rating", function () {
        $(this).hide().before("" + '<div class="stars prodigy-comment__rating">' + '<a class="star-1 prodigy-comment__star icon icon-star" href="#">1</a>' + '<a class="star-2 prodigy-comment__star icon icon-star" href="#">2</a>' + '<a class="star-3 prodigy-comment__star icon icon-star" href="#">3</a>' + '<a class="star-4 prodigy-comment__star icon icon-star" href="#">4</a>' + '<a class="star-5 prodigy-comment__star icon icon-star" href="#">5</a>' + "</div>");
      }).on("click", "#respond div.stars a", function () {
        var $star = $(this),
          $rating = $(this).closest("#respond").find("#prodigy-rating"),
          $container = $(this).closest(".stars");
        $rating.val($star.text()).trigger("change");
        $star.siblings("a").removeClass("active");
        $star.addClass("active");
        $container.addClass("selected");
        return false;
      }).on("click", "#reviews #comments .justify-content-center", function () {
        window.prodigyProduct.get_count_review().done(function (result) {
          let count_review = result.data;
          if (count_review > 0) {
            window.prodigyProduct.get_content_review();
          }
        }).fail(function () {});
      });
      $(".prodigy-tabs-js, .prodigy-tabs, #prodigy-rating").trigger("init");
    },
    get_content_review: function () {
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
        success: function (data) {
          self.before(data);
          $(".per-page-js").data("page", page + 1);
          window.prodigyProduct.get_count_review().done(function (res) {
            if (res.data === 0) {
              window.prodigyProduct.hide_link_show_more_reviews();
            }
          });
        }
      });
    },
    get_count_review: function () {
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
    hide_link_show_more_reviews: function () {
      $(".link-show-more-reviews-js").removeClass("d-flex").addClass("d-none");
    },
    set_default_link_review: function () {
      window.prodigyProduct.get_count_review().done(function (res) {
        if (res.data === 0) {
          window.prodigyProduct.hide_link_show_more_reviews();
        }
      });
    },
    init_show_more: function () {
      $("body").on("click", ".prodigy-product__description-show-more", function () {
        var $container = $(this).parent();
        $container.find(".prodigy-product__description-container").removeClass("prodigy-product__description-container--truncated");
        $container.find(".prodigy-product__description-fade").remove();
        $(this).remove();
      });
    },
    set_customised_variant_selection: function () {
      $(document).find('select[data-attribute]').trigger('focus');
    },
    customise_sort_select: function () {
      $('.prodigy-custom-select').styler({
        onFormStyled: function () {
          $('.jq-selectbox__select-text').each(function () {
            const width = $(this).closest('.jq-selectbox').find('select').width();
            $(this).width(width);
          });
        }
      });
    },
    set_tabs_for_resolution: function () {
      let windowWidth = window.innerWidth;
      if (windowWidth < 768) {
        $('.desktop-resolution-js').remove();
      } else {
        $('.mobile-resolution-js').remove();
      }
    },
    is_validate_options: function () {
      let result = true;
      let self = this;
      $('.bulk-container-js:visible').each(function (i, bulk_container) {
        let bulk_result = false;
        $(bulk_container).find(prodigyProductBulk.input_bulk_quantity_element).each(function (index, input) {
          if ($(input).val() !== "") {
            bulk_result = true;
          } else {
            bulk_result = bulk_result || false;
          }
        });
        result = result && bulk_result;
      });
      $('.attribute_values_js').each(function (e) {
        if (!$(this).hasClass('ignored')) {
          if ($(this).val() === "") {
            result = false;
          } else {
            result = result && true;
          }
        }
      });
      $('.prodigy-product__swatch-block-js').each(function () {
        let self = this;
        let checkbox = $(this).find('.prodigy-product__swatch-js');
        checkbox.each(function () {
          if (!checkbox.is(':checked') && !$(self).hasClass('ignored')) {
            result = false;
          } else {
            result = result && true;
          }
        });
      });
      return result;
    },
    validate_options: function () {
      let result = true;
      let self = this;
      $('.bulk-container-js:visible').each(function (i, bulk_container) {
        let bulk_result = false;
        $(bulk_container).find(prodigyProductBulk.input_bulk_quantity_element).each(function (index, input) {
          if ($(input).val() !== "") {
            bulk_result = true;
          } else {
            bulk_result = bulk_result || false;
          }
        });
        const headers = $(bulk_container).find('.prodigy-tooltip, .prodigy-bulk__table-cell');
        bulk_result ? headers.removeAttr('style') : headers.css('border-color', 'red');
        result = result && bulk_result;
      });
      $('.attribute_values_js').each(function (e) {
        if (!$(this).hasClass('ignored') && $(this).val() === "") {
          $(this).parent().parent().prev().prev().css('color', 'red');
          result = false;
        } else {
          $(this).parent().parent().prev().prev().removeAttr('style');
          result = result && true;
        }
      });
      $('.prodigy-product__swatch-block-js:not(.ignored)').each(function () {
        let element = $(this).closest('.prodigy-product__attr-item--no-select-value').find('.prodigy-product__attr-text');
        let checkbox = $(this).find(self.prodigy_product_swatch_element);
        checkbox.each(function () {
          if (!checkbox.is(':checked')) {
            element.css('color', 'red');
            result = false;
          } else {
            element.removeAttr('style');
            result = result && true;
          }
        });
      });
      return result;
    },
    hide_empty_div: function () {
      $('.prodigy-product__prop-wrap').each(function () {
        if ($.trim($(this).text()) == '' && $(this).children().length == 0) {
          $(this).hide();
        }
      });
    }
  };
  window.prodigyProduct = prodigy_product;
})(jQuery, window);
jQuery(document).ready(function ($) {
  window.prodigyProduct.init();
  window.prodigyRecaptchaCallback = window.prodigyProduct.captcha_callback.bind(window.prodigyProduct);
});

/***/ }),

/***/ "./web/templates/js/scripts/product-quick-view.js":
/*!********************************************************!*\
  !*** ./web/templates/js/scripts/product-quick-view.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, window) {
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
      success: function (html) {
        $.magnificPopup.open({
          items: {
            src: '#quick-view-js'
          },
          type: 'inline',
          callbacks: {
            beforeOpen: function () {
              $('#quick-view-content-js').html(html);
              prodigyProduct.init();
              if (!prodigyProduct.is_variants()) {
                prodigyProduct.get_master_variant_data();
              }
              prodigyProduct.set_elementor_options();
              prodigyProduct.set_product_counter();
              if (prodigyProduct.is_swatches()) {
                prodigyProduct.change_swatch_value();
                prodigyProduct.set_checked_swatch();
              }
              prodigyProduct.add_item_to_cart();
              prodigyProduct.reset_focus_to_press_enter();
              prodigyProductBulk.bulk_showing_manager();
              if (prodigyProduct.is_tiered_price) {
                prodigyProduct.get_tiered_prices_range_ajax();
              }
              prodigyProductBulk.set_bulk_variants_data();
              if (prodigyProduct.is_bulk()) {
                prodigyProduct.set_bulk();
              }
            },
            open: function () {
              prodigyProduct.update_variants_dropdown();
              prodigyProduct.set_product_gallery();
              prodigyProduct.set_attribute_value_options();
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

/***/ }),

/***/ "./web/templates/js/scripts/shop-page.js":
/*!***********************************************!*\
  !*** ./web/templates/js/scripts/shop-page.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  'use strict';

  let shop_page_url = settings.shop_page_url;
  let default_number_of_columns = settings.customizer_product_columns;
  let windowWidth = screen.width;
  $(document).ready(function () {
    let catalog_containers = ['filter__browse', 'filter-widget-container-js', 'prodigy-pagination', 'catalog-sort-js', 'price-filter-container-js'];
    init();
    function init() {
      set_search_parameters();
      set_dropdown_sortable();
      search_handler();
      slow_search();
      hiding_search_widget();
      hiding_empty_search_space();
      set_number_of_columns_by_screen_resolution();
    }
    function set_number_of_columns_by_screen_resolution() {
      $('.prodigy-product-list__grid').removeClass('d-none');
      let number_of_columns = '';
      if (windowWidth >= 1440) {
        number_of_columns = default_number_of_columns;
      } else if (windowWidth >= 1024) {
        number_of_columns = default_number_of_columns >= 4 ? 4 : default_number_of_columns;
      } else if (windowWidth >= 768) {
        number_of_columns = default_number_of_columns >= 3 ? 3 : default_number_of_columns;
      } else if (windowWidth >= 375) {
        number_of_columns = default_number_of_columns >= 2 ? 2 : default_number_of_columns;
      }
      $('.shop-resolution-js').addClass('prodigy-product-list__grid-' + number_of_columns);
    }
    function hiding_empty_search_space() {
      let search = $('.catalog-page-sort-js');
      let sorting = $('.prodigy-search__input-js');
      if (search.length === 0 && sorting.length === 0) {
        $('.prodigy-search-filter').remove();
      }
    }
    function hiding_search_widget() {
      $('.prodigy-filter__main').each(function (index, element) {
        let badge = $(element).find('.prodigy-filter__badges');
        let container_attribute = badge.find('.prodigy-main-badge');
        let active_filter = container_attribute.data('attribute-name');
        if (badge.length !== 0 && typeof active_filter === 'undefined') {
          element.remove();
        }
      });
    }
    function slow_search() {
      if (prodigyGetUrlParam('search')) {
        $("html,body").animate({
          scrollTop: 0
        }, "slow");
      }
    }
    function search_handler() {
      const searchBtn = $('.prodigy-search__icon-js');
      const searchWidgetBtn = $('.prodigy-search__icon-widget-js');
      const closeSearchBtn = $('.prodigy-search__close-icon');
      const searchInput = $('.prodigy-search__input-js');
      const searchCustom = $('.prodigy-search__custom-search');
      const backdropOverlay = $('body');
      searchWidgetBtn.on('click', e => {
        let input = $(e.target).closest('form').find('.prodigy-search__input-js, .prodigy-search__input-mobile-js');
        if (!input.length) {
          return;
        }
        set_search_params(input.val());
      });
      searchBtn.on('click', () => {
        localStorage.removeItem('price-range');
        localStorage.removeItem('catalog-sortable');

        /**
         * for prodigy theme
         */
        searchInput.toggleClass('prodigy-search__input-is-open');
        searchInput.focus();
        if (searchInput.hasClass('prodigy-search__input-is-open') && searchInput.val().length > 0) {
          setTimeout(function () {
            closeSearchBtn.removeClass('d-none');
          }, 200);
        } else {
          closeSearchBtn.addClass('d-none');
        }
      });
      if (typeof searchInput.val() !== 'undefined' && searchInput.val().length > 0) {
        searchInput.addClass('prodigy-search__input-is-open');
        closeSearchBtn.removeClass('d-none');
      }
      searchInput.on('keyup', function () {
        if (searchInput.val().length > 0) {
          closeSearchBtn.removeClass('d-none');
        } else {
          closeSearchBtn.addClass('d-none');
        }
      });
      closeSearchBtn.on('click', function () {
        searchInput.val('');
        $(this).addClass('d-none');
        window.history.replaceState({}, document.title, shop_page_url);
        document.location.reload();
      });
      searchCustom.on('click', function (e) {
        e.stopPropagation();
        $(this).closest(".prodigy-search__custom-dropdown").addClass("prodigy-search__custom-dropdown--open");
      });
      backdropOverlay.on('click', function (e) {
        if (!$(e.target).closest('.prodigy-search__custom-dropdown-block-search').length) {
          $('.prodigy-search__custom-dropdown').removeClass("prodigy-search__custom-dropdown--open");
        }
      });
    }
    function set_search_parameters() {
      var search = prodigyGetUrlParam('search');
      if (typeof search !== 'undefined' && search !== 0) {
        $('.prodigy-search__input-js').val(prodigyGetUrlParam('search'));
      }
      $(document).on('keypress', '.prodigy-search__input-js, .prodigy-search__input-mobile-js', function (e) {
        let target = $(e.currentTarget);
        if (e.which === 13 && target.val() && typeof target.val() !== 'undefined') {
          e.preventDefault();
          set_search_params(target.val());
        }
      });
    }
    function set_search_params(search_value) {
      var newParams = [['search', search_value]];
      window.history.replaceState({}, document.title, shop_page_url);
      let newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);
      history.pushState('', '', newUrl);
      document.location.reload();
    }
    function set_dropdown_sortable() {
      var selText = '';
      var sort_param = prodigyGetUrlParam('sort');
      var dropdown_container = $(".prodigy-dropdown__menu a");
      switch (sort_param) {
        case 'created_at':
          selText = 'Sort by newness';
          break;
        case 'rating':
          selText = 'Sort by average rating';
          break;
        case 'price':
          selText = 'Sort by price';
          break;
        default:
          selText = 'Sort by newness';
          break;
      }
      dropdown_container.parents('.btn-group').find('.prodigy-dropdown__btn').html(selText + ' <span class="caret"></span>');
      dropdown_container.click(function (e) {
        selText = $(this).text();
        $(this).parents('.btn-group').find('.prodigy-dropdown__btn').html(selText + ' <span class="caret"></span>');
      });
    }
    const filterToggleBtnHandler = () => {
      $('.prodigy-shop-sidebar').toggleClass('prodigy-shop-sidebar--open');
      $('body').toggleClass('prodigy-overflow-y-hidden');
      $('html').toggleClass('prodigy-overflow-y-hidden');
    };
    $('body').on('click', '#filter-toggle-btn, #filter-toggle-btn-elementor-js, #filter-toggle-btn-2, #shop-sidebar-backdrop-js, #shop-sidebar-backdrop-elementor-js', filterToggleBtnHandler);
  });
})(jQuery);

/***/ }),

/***/ "./web/templates/js/skip-link-focus-fix.js":
/*!*************************************************!*\
  !*** ./web/templates/js/skip-link-focus-fix.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function () {
  var isIe = /(trident|msie)/i.test(navigator.userAgent);
  if (isIe && document.getElementById && window.addEventListener) {
    window.addEventListener('hashchange', function () {
      var id = location.hash.substring(1),
        element;
      if (!/^[A-z0-9_-]+$/.test(id)) {
        return;
      }
      element = document.getElementById(id);
      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
          element.tabIndex = -1;
        }
        element.focus();
      }
    }, false);
  }
})();

/***/ }),

/***/ 0:
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./web/templates/js/navigation.js ./web/templates/js/skip-link-focus-fix.js ./web/templates/js/scripts/cart-load.js ./web/templates/js/scripts/shop-page.js ./web/templates/js/scripts/product-quick-view.js ./web/templates/js/scripts/analytics.js ./web/templates/js/scripts/product-page.js ./web/templates/js/scripts/filter.js ./web/templates/js/scripts/product-bulk.js ./web/templates/js/scripts/product-logo-management.js ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./web/templates/js/navigation.js */"./web/templates/js/navigation.js");
__webpack_require__(/*! ./web/templates/js/skip-link-focus-fix.js */"./web/templates/js/skip-link-focus-fix.js");
__webpack_require__(/*! ./web/templates/js/scripts/cart-load.js */"./web/templates/js/scripts/cart-load.js");
__webpack_require__(/*! ./web/templates/js/scripts/shop-page.js */"./web/templates/js/scripts/shop-page.js");
__webpack_require__(/*! ./web/templates/js/scripts/product-quick-view.js */"./web/templates/js/scripts/product-quick-view.js");
__webpack_require__(/*! ./web/templates/js/scripts/analytics.js */"./web/templates/js/scripts/analytics.js");
__webpack_require__(/*! ./web/templates/js/scripts/product-page.js */"./web/templates/js/scripts/product-page.js");
__webpack_require__(/*! ./web/templates/js/scripts/filter.js */"./web/templates/js/scripts/filter.js");
__webpack_require__(/*! ./web/templates/js/scripts/product-bulk.js */"./web/templates/js/scripts/product-bulk.js");
module.exports = __webpack_require__(/*! ./web/templates/js/scripts/product-logo-management.js */"./web/templates/js/scripts/product-logo-management.js");


/***/ })

/******/ });
//# sourceMappingURL=public.js.map