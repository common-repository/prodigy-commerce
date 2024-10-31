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

/***/ "./web/wizard/js/step-connect.js":
/*!***************************************!*\
  !*** ./web/wizard/js/step-connect.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(function ($) {
  const body_element = $('body');
  const modal_info_synchronization = $(".modal-info-synchronization-js");
  const cancel_sync_content = $('.cancel-sync-content-js');
  const sync_content = $('.sync-content-js');
  const input_synchronization = $("#synchronization");
  $('body').on('click', '.connect-button-js', function () {
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
        nonce_code: prodigyajax.nonce
      },
      success: function (data) {
        console.log(data.success);
      },
      fail: function (data) {}
    });
  }
  function remove_indicator_sync_content() {
    $.ajax({
      dataType: 'json',
      url: ajaxurl,
      type: 'post',
      data: {
        action: 'remove-indicator-sync-content',
        nonce_code: prodigyajax.nonce
      },
      success: function (data) {
        console.log(data.success);
      },
      fail: function (data) {}
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

/***/ }),

/***/ "./web/wizard/scss/application.scss":
/*!******************************************!*\
  !*** ./web/wizard/scss/application.scss ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ 0:
/*!********************************************************************************!*\
  !*** multi ./web/wizard/js/step-connect.js ./web/wizard/scss/application.scss ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./web/wizard/js/step-connect.js */"./web/wizard/js/step-connect.js");
module.exports = __webpack_require__(/*! ./web/wizard/scss/application.scss */"./web/wizard/scss/application.scss");


/***/ })

/******/ });
//# sourceMappingURL=wizard.js.map