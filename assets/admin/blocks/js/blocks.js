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

/***/ "./includes/frontend/blocks/categories/index.js":
/*!******************************************************!*\
  !*** ./includes/frontend/blocks/categories/index.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../icons */ "./includes/frontend/blocks/icons/index.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : String(i); }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }





var categoriesBlock = {
  title: 'Prodigy Categories',
  icon: _icons__WEBPACK_IMPORTED_MODULE_4__["categoriesIcon"],
  category: 'prodigy',
  // Block attributes.
  attributes: {
    idWidget: {
      type: 'string',
      "default": ''
    },
    parentIds: {
      type: 'string',
      "default": ''
    },
    product_names: {
      type: 'string'
    },
    columns: {
      type: 'integer',
      "default": 4
    },
    tags: {
      type: 'string'
    },
    orderby: {
      type: 'string',
      "default": 'date'
    },
    show_product_count: {
      type: 'boolean',
      "default": true
    },
    order: {
      type: 'string',
      "default": 'asc'
    },
    display: {
      type: 'string',
      "default": 'slider'
    }
  },
  edit: Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__["withSelect"])(function (select) {
    var _select = select('core'),
      getEntityRecords = _select.getEntityRecords;
    var categories = getEntityRecords('taxonomy', 'prodigy-product-category', {
      per_page: -1
    });

    // Only return the parent categories with children.
    if (categories) {
      return {
        categories: categories.filter(function (cat) {
          return cat.parent === 0 && cat.count > 0;
        })
      };
    }
    return {
      categories: categories
    };
  })(function (_ref) {
    var categories = _ref.categories,
      attributes = _ref.attributes,
      setAttributes = _ref.setAttributes;
    var loading = !categories;
    var _onChange = function onChange(attribute, value) {
      setAttributes(_defineProperty({}, attribute, value));
    };
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InspectorControls"], null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Categories Selection"
    }, categories && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["QueryControls"], {
      label: "Parent Categories",
      categoriesList: categories,
      onCategoryChange: function onCategoryChange(categoryId) {
        var _categories$find;
        return _onChange('parentIds', (_categories$find = categories.find(function (cat) {
          return cat.id === parseInt(categoryId);
        })) === null || _categories$find === void 0 ? void 0 : _categories$find.prodigyHostedCategoryRelation);
      },
      onOrderByChange: function onOrderByChange(orderBy) {
        return _onChange('orderby', orderBy);
      },
      onOrderChange: function onOrderChange(order) {
        return _onChange('order', order);
      },
      selectedCategoryId: attributes.categories,
      order: attributes.order,
      orderBy: attributes.orderby
    })), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Categories Display"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["SelectControl"], {
      label: "Display",
      value: attributes.display,
      options: [{
        label: 'Grid',
        value: 'grid'
      }, {
        label: 'Slider',
        value: 'slider'
      }],
      onChange: function onChange(value) {
        return _onChange('display', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["__experimentalNumberControl"], {
      label: "Columns",
      type: "number",
      value: attributes.columns,
      min: 1,
      max: 6,
      onChange: function onChange(value) {
        return _onChange('columns', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["ToggleControl"], {
      label: "Product Count",
      checked: attributes.show_product_count,
      onChange: function onChange(value) {
        return _onChange('show_product_count', value);
      }
    }))), /*#__PURE__*/React.createElement("div", {
      className: "prodigy-".concat(attributes.display, "-columns-").concat(attributes.columns)
    }, attributes.display === 'slider' && !loading && /*#__PURE__*/React.createElement("div", {
      className: "prodigy-slider-arrow prodigy-slider-arrow-left"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["Dashicon"], {
      icon: "arrow-left-alt2"
    })), /*#__PURE__*/React.createElement(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default.a, {
      block: "prodigy/categories",
      attributes: attributes
    }), attributes.display === 'slider' && !loading && /*#__PURE__*/React.createElement("div", {
      className: "prodigy-slider-arrow prodigy-slider-arrow-right"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["Dashicon"], {
      icon: "arrow-right-alt2"
    }))));
  }),
  save: function save() {
    return null;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (categoriesBlock);

/***/ }),

/***/ "./includes/frontend/blocks/category/index.js":
/*!****************************************************!*\
  !*** ./includes/frontend/blocks/category/index.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../icons */ "./includes/frontend/blocks/icons/index.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : String(i); }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }





var categoryBlock = {
  title: 'Prodigy Category',
  icon: _icons__WEBPACK_IMPORTED_MODULE_4__["categoryIcon"],
  category: 'prodigy',
  // Block attributes.
  attributes: {
    idWidget: {
      type: 'string',
      "default": ''
    },
    category_id: {
      type: 'string',
      "default": ''
    },
    show_product_count: {
      type: 'boolean',
      "default": true
    }
  },
  edit: Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__["withSelect"])(function (select) {
    var _select = select('core'),
      getEntityRecords = _select.getEntityRecords;
    var categories = getEntityRecords('taxonomy', 'prodigy-product-category', {
      per_page: -1
    });
    return {
      categories: categories
    };
  })(function (_ref) {
    var _categories$find2;
    var categories = _ref.categories,
      attributes = _ref.attributes,
      setAttributes = _ref.setAttributes;
    console.log(categories);
    var _onChange = function onChange(attribute, value) {
      setAttributes(_defineProperty({}, attribute, value));
    };
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InspectorControls"], null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Category Selection"
    }, categories && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["QueryControls"], {
      label: "Category",
      categoriesList: categories,
      onCategoryChange: function onCategoryChange(categoryId) {
        var _categories$find;
        return _onChange('category_id', (_categories$find = categories.find(function (cat) {
          return cat.id === parseInt(categoryId);
        })) === null || _categories$find === void 0 ? void 0 : _categories$find.prodigyHostedCategoryRelation);
      },
      selectedCategoryId: (_categories$find2 = categories.find(function (cat) {
        return cat.prodigyHostedCategoryRelation === attributes.category_id;
      })) === null || _categories$find2 === void 0 ? void 0 : _categories$find2.id,
      maxItems: -1
    })), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Category Display"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["ToggleControl"], {
      label: "Product Count",
      checked: attributes.show_product_count,
      onChange: function onChange(value) {
        return _onChange('show_product_count', value);
      }
    }))), /*#__PURE__*/React.createElement(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default.a, {
      block: "prodigy/category",
      attributes: attributes
    }));
  }),
  save: function save() {
    return null;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (categoryBlock);

/***/ }),

/***/ "./includes/frontend/blocks/editor-styles.scss":
/*!*****************************************************!*\
  !*** ./includes/frontend/blocks/editor-styles.scss ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./includes/frontend/blocks/icons/cart-page.js":
/*!*****************************************************!*\
  !*** ./includes/frontend/blocks/icons/cart-page.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var cartPageIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M21.5,4.542L21.5,19.458C21.5,20.317 20.812,21 19.98,21L4.02,21C3.185,21 2.5,20.317 2.5,19.458L2.5,4.542C2.5,3.686 3.185,3 4.02,3L19.98,3C20.812,3 21.5,3.686 21.5,4.542ZM20,4.542C20,4.524 19.998,4.5 19.98,4.5L4.02,4.5C4.002,4.5 4,4.524 4,4.542L4,19.458C4,19.476 4.002,19.5 4.02,19.5L19.98,19.5C19.998,19.5 20,19.476 20,19.458L20,4.542Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M8.271,9.17L15.728,9.17C16.103,9.17 16.421,9.448 16.471,9.82L17.308,16.081C17.337,16.295 17.271,16.512 17.129,16.674C16.987,16.837 16.781,16.931 16.565,16.931L7.435,16.931C7.219,16.931 7.014,16.837 6.871,16.675C6.729,16.512 6.663,16.296 6.692,16.081L7.528,9.82C7.577,9.448 7.895,9.17 8.271,9.17ZM8.928,10.669L8.292,15.43C8.292,15.43 15.708,15.431 15.708,15.43L15.071,10.67L8.928,10.669Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M10.77,10.544C10.793,10.957 10.476,11.311 10.063,11.334C9.649,11.357 9.295,11.04 9.272,10.627C9.272,10.627 9.199,9.209 9.706,8.073C10.112,7.165 10.846,6.43 12.114,6.43C13.274,6.43 13.962,7.168 14.327,8.108C14.762,9.228 14.688,10.628 14.688,10.628C14.665,11.041 14.311,11.358 13.898,11.334C13.484,11.311 13.168,10.957 13.191,10.543C13.191,10.543 13.255,9.491 12.929,8.65C12.786,8.282 12.568,7.931 12.114,7.931C11.376,7.931 11.088,8.534 10.934,9.085C10.73,9.814 10.77,10.544 10.77,10.544Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (cartPageIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/cart.js":
/*!************************************************!*\
  !*** ./includes/frontend/blocks/icons/cart.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var cartIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M4.853,7.022L19.147,7.022C19.521,7.022 19.838,7.297 19.89,7.668L21.493,19.146C21.523,19.361 21.458,19.579 21.316,19.742C21.173,19.906 20.967,20 20.75,20L3.25,20C3.033,20 2.827,19.906 2.684,19.742C2.542,19.579 2.477,19.361 2.507,19.146L4.11,7.668C4.162,7.297 4.479,7.022 4.853,7.022ZM5.506,8.522L4.112,18.5L19.888,18.5L18.494,8.522L5.506,8.522Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M8.956,8.948C8.981,9.361 8.665,9.717 8.251,9.741C7.838,9.765 7.483,9.449 7.459,9.036C7.459,9.036 7.322,6.588 8.237,4.63C8.911,3.188 10.113,2 12.218,2C14.12,2 15.217,3.191 15.815,4.665C16.604,6.608 16.468,9.036 16.468,9.036C16.444,9.449 16.089,9.765 15.675,9.741C15.262,9.717 14.946,9.361 14.97,8.948C14.97,8.948 15.096,6.882 14.425,5.229C14.051,4.306 13.409,3.5 12.218,3.5C10.44,3.5 9.663,4.813 9.292,6.081C8.874,7.515 8.956,8.948 8.956,8.948Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (cartIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/categories.js":
/*!******************************************************!*\
  !*** ./includes/frontend/blocks/icons/categories.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var categoriesIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M11.185,15.11C11.185,14.696 11.521,14.36 11.935,14.36C12.349,14.36 12.685,14.696 12.685,15.11L12.685,17.331C12.685,17.745 12.349,18.081 11.935,18.081C11.521,18.081 11.185,17.745 11.185,17.331L11.185,15.11Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M5.556,17.204C5.556,17.618 5.219,17.954 4.806,17.954C4.392,17.954 4.056,17.618 4.056,17.204C4.056,15.65 5.293,14.36 6.88,14.36L17.12,14.36C18.719,14.36 20.032,15.682 19.943,17.246C19.92,17.66 19.565,17.976 19.152,17.953C18.739,17.929 18.422,17.575 18.446,17.161C18.486,16.441 17.856,15.86 17.12,15.86L6.88,15.86C6.133,15.86 5.556,16.473 5.556,17.204Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M3.444,16.581L6.167,16.581C6.471,16.581 6.685,16.694 6.837,16.842C6.994,16.996 7.111,17.213 7.111,17.521L7.111,20.06C7.111,20.368 6.994,20.584 6.837,20.738C6.685,20.887 6.471,21 6.167,21L3.444,21C3.14,21 2.926,20.887 2.774,20.738C2.617,20.584 2.5,20.368 2.5,20.06L2.5,17.521C2.5,17.21 2.81,16.581 3.444,16.581ZM4,18.081L4,19.5L5.611,19.5L5.611,18.081L4,18.081Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M10.574,16.581L13.296,16.581C13.6,16.581 13.815,16.694 13.967,16.842C14.124,16.996 14.241,17.213 14.241,17.521L14.241,20.06C14.241,20.368 14.124,20.584 13.967,20.738C13.815,20.887 13.6,21 13.296,21L10.574,21C10.27,21 10.056,20.887 9.904,20.738C9.746,20.584 9.63,20.368 9.63,20.06C9.63,20.06 9.63,17.685 9.63,17.686C9.587,17.524 9.601,17.349 9.674,17.169C9.782,16.903 10.165,16.581 10.574,16.581ZM11.13,18.081L11.13,19.5L12.741,19.5L12.741,18.081L11.13,18.081ZM11.018,17.128C10.988,17.078 10.95,17.03 10.904,16.985C10.948,17.028 10.987,17.077 11.018,17.128Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M17.833,16.581L20.556,16.581C20.86,16.581 21.074,16.694 21.226,16.842C21.383,16.996 21.5,17.213 21.5,17.521L21.5,20.06C21.5,20.368 21.383,20.584 21.226,20.738C21.074,20.887 20.86,21 20.556,21L17.833,21C17.529,21 17.315,20.887 17.163,20.738C17.006,20.584 16.889,20.368 16.889,20.06L16.889,17.521C16.889,17.358 16.978,17.071 17.187,16.866C17.39,16.667 17.671,16.581 17.833,16.581ZM18.389,18.081L18.389,19.5L20,19.5L20,18.081L18.389,18.081Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M18.454,3.75L18.454,12.776C18.454,13.191 18.118,13.526 17.704,13.526L6.102,13.526C5.688,13.526 5.352,13.191 5.352,12.776L5.352,3.75C5.352,3.336 5.688,3 6.102,3L17.704,3C18.118,3 18.454,3.336 18.454,3.75ZM16.954,4.5L6.852,4.5L6.852,12.026L16.954,12.026L16.954,4.5Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M12.741,3.902C12.741,3.488 13.077,3.152 13.491,3.152C13.905,3.152 14.241,3.488 14.241,3.902L14.241,8.85C14.241,9.14 14.074,9.404 13.812,9.528C13.551,9.652 13.241,9.615 13.017,9.432C13.017,9.432 11.926,8.541 11.926,8.541L10.777,9.441C10.551,9.618 10.244,9.65 9.986,9.525C9.729,9.399 9.565,9.137 9.565,8.85L9.565,3.902C9.565,3.488 9.901,3.152 10.315,3.152C10.729,3.152 11.065,3.488 11.065,3.902L11.065,7.31L11.473,6.991C11.749,6.775 12.138,6.778 12.409,7L12.741,7.27L12.741,3.902Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (categoriesIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/category.js":
/*!****************************************************!*\
  !*** ./includes/frontend/blocks/icons/category.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var categoryIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M18.808,3.75L18.808,11.121C18.808,11.535 18.472,11.871 18.058,11.871L11.887,11.871L11.887,17.911C11.887,18.111 11.807,18.304 11.664,18.445C11.522,18.585 11.328,18.663 11.128,18.661L3.241,18.564C2.83,18.559 2.5,18.225 2.5,17.814L2.5,3.75C2.5,3.336 2.836,3 3.25,3L18.058,3C18.472,3 18.808,3.336 18.808,3.75ZM17.308,4.5L4,4.5L4,17.073C4,17.073 10.387,17.152 10.387,17.152L10.387,11.121C10.387,10.707 10.723,10.371 11.137,10.371C11.137,10.371 17.308,10.371 17.308,10.371L17.308,4.5Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M6.107,7.171C5.693,7.171 5.357,6.835 5.357,6.421C5.357,6.007 5.693,5.671 6.107,5.671L15.133,5.671C15.547,5.671 15.883,6.007 15.883,6.421C15.883,6.835 15.547,7.171 15.133,7.171L6.107,7.171Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M6.107,9.371C5.693,9.371 5.357,9.035 5.357,8.621C5.357,8.208 5.693,7.871 6.107,7.871L10.548,7.871C10.962,7.871 11.298,8.208 11.298,8.621C11.298,9.035 10.962,9.371 10.548,9.371L6.107,9.371Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M21.5,11.121L21.5,20.25C21.5,20.664 21.164,21 20.75,21L11.137,21C10.723,21 10.387,20.664 10.387,20.25L10.387,11.121C10.387,10.707 10.723,10.371 11.137,10.371L20.75,10.371C21.164,10.371 21.5,10.707 21.5,11.121ZM20,11.871L11.887,11.871C11.887,11.871 11.887,19.5 11.887,19.5L20,19.5L20,11.871Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M16.385,14.787C16.655,14.576 17.037,14.576 17.308,14.787L17.308,11.121C17.308,10.707 17.644,10.371 18.058,10.371C18.472,10.371 18.808,10.707 18.808,11.121L18.808,16.479C18.808,16.775 18.633,17.044 18.361,17.164C18.09,17.285 17.773,17.233 17.554,17.034C17.554,17.034 16.846,16.392 16.846,16.392L16.139,17.034C15.919,17.233 15.602,17.285 15.331,17.164C15.06,17.044 14.885,16.775 14.885,16.479L14.885,11.456C14.885,11.042 15.221,10.706 15.635,10.706C16.049,10.706 16.385,11.042 16.385,11.456L16.385,14.787Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (categoryIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/index.js":
/*!*************************************************!*\
  !*** ./includes/frontend/blocks/icons/index.js ***!
  \*************************************************/
/*! exports provided: cartIcon, cartPageIcon, categoriesIcon, categoryIcon, myAccountIcon, productsIcon, relatedProductsIcon, thankYouPageIcon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _cart__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cart */ "./includes/frontend/blocks/icons/cart.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "cartIcon", function() { return _cart__WEBPACK_IMPORTED_MODULE_0__["default"]; });

/* harmony import */ var _cart_page__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./cart-page */ "./includes/frontend/blocks/icons/cart-page.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "cartPageIcon", function() { return _cart_page__WEBPACK_IMPORTED_MODULE_1__["default"]; });

/* harmony import */ var _categories__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./categories */ "./includes/frontend/blocks/icons/categories.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "categoriesIcon", function() { return _categories__WEBPACK_IMPORTED_MODULE_2__["default"]; });

/* harmony import */ var _category__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./category */ "./includes/frontend/blocks/icons/category.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "categoryIcon", function() { return _category__WEBPACK_IMPORTED_MODULE_3__["default"]; });

/* harmony import */ var _my_account__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./my-account */ "./includes/frontend/blocks/icons/my-account.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "myAccountIcon", function() { return _my_account__WEBPACK_IMPORTED_MODULE_4__["default"]; });

/* harmony import */ var _products__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./products */ "./includes/frontend/blocks/icons/products.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "productsIcon", function() { return _products__WEBPACK_IMPORTED_MODULE_5__["default"]; });

/* harmony import */ var _related_products__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./related-products */ "./includes/frontend/blocks/icons/related-products.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "relatedProductsIcon", function() { return _related_products__WEBPACK_IMPORTED_MODULE_6__["default"]; });

/* harmony import */ var _thank_you_page__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./thank-you-page */ "./includes/frontend/blocks/icons/thank-you-page.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "thankYouPageIcon", function() { return _thank_you_page__WEBPACK_IMPORTED_MODULE_7__["default"]; });










/***/ }),

/***/ "./includes/frontend/blocks/icons/my-account.js":
/*!******************************************************!*\
  !*** ./includes/frontend/blocks/icons/my-account.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var myAccountIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M2.5,20.25C2.5,20.25 2.499,16.146 5.803,13.683C7.191,12.649 9.168,11.891 12,11.891C14.832,11.891 16.809,12.649 18.197,13.683C21.501,16.146 21.5,20.25 21.5,20.25C21.5,20.664 21.164,21 20.75,21L3.25,21C2.836,21 2.5,20.664 2.5,20.25ZM4.069,19.5C4.069,19.5 19.931,19.5 19.931,19.5C19.766,18.395 19.206,16.306 17.301,14.886C16.116,14.003 14.418,13.391 12,13.391C9.582,13.391 7.884,14.003 6.699,14.886C4.794,16.306 4.234,18.395 4.069,19.5Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M12,3C14.618,3 16.76,5.203 16.76,7.935C16.76,10.667 14.618,12.87 12,12.87C9.382,12.87 7.24,10.667 7.24,7.935C7.24,5.203 9.382,3 12,3ZM12,4.5C10.192,4.5 8.74,6.048 8.74,7.935C8.74,9.822 10.192,11.37 12,11.37C13.808,11.37 15.26,9.822 15.26,7.935C15.26,6.048 13.808,4.5 12,4.5Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (myAccountIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/products.js":
/*!****************************************************!*\
  !*** ./includes/frontend/blocks/icons/products.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var productsIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M21.5,3.75L21.5,20.25C21.5,20.664 21.164,21 20.75,21L3.25,21C2.836,21 2.5,20.664 2.5,20.25L2.5,3.75C2.5,3.336 2.836,3 3.25,3L20.75,3C21.164,3 21.5,3.336 21.5,3.75ZM20,4.5L4,4.5L4,19.5L20,19.5L20,4.5Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M13.437,3.915C13.438,3.501 13.774,3.165 14.188,3.165C14.601,3.165 14.938,3.501 14.937,3.915L14.937,11.67C14.938,11.968 14.76,12.239 14.487,12.358C14.213,12.477 13.895,12.422 13.676,12.219C13.676,12.219 11.708,10.385 11.708,10.385L9.74,12.219C9.522,12.422 9.204,12.477 8.93,12.358C8.656,12.239 8.479,11.968 8.479,11.67L8.479,3.915C8.479,3.501 8.815,3.165 9.229,3.165C9.643,3.165 9.979,3.501 9.979,3.915L9.979,9.946L11.197,8.811C11.485,8.543 11.932,8.543 12.22,8.811C12.22,8.811 13.438,9.946 13.437,9.946L13.437,3.915Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M6.604,17.7C6.19,17.7 5.854,17.364 5.854,16.95C5.854,16.536 6.19,16.2 6.604,16.2L11.125,16.2C11.539,16.2 11.875,16.536 11.875,16.95C11.875,17.364 11.539,17.7 11.125,17.7L6.604,17.7Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (productsIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/related-products.js":
/*!************************************************************!*\
  !*** ./includes/frontend/blocks/icons/related-products.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var relatedProductsIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M12.424,3.75L12.424,11.214C12.424,11.628 12.088,11.964 11.674,11.964L3.25,11.964C2.836,11.964 2.5,11.628 2.5,11.214L2.5,3.75C2.5,3.336 2.836,3 3.25,3L11.674,3C12.088,3 12.424,3.336 12.424,3.75ZM10.924,4.5L4,4.5L4,10.464L10.924,10.464L10.924,4.5Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M11.242,13.964C11.242,13.55 11.578,13.214 11.992,13.214C12.406,13.214 12.742,13.55 12.742,13.964L12.742,16.636C12.742,17.05 12.406,17.386 11.992,17.386C11.578,17.386 11.242,17.05 11.242,16.636L11.242,13.964Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M4.901,14.714C4.487,14.714 4.151,14.378 4.151,13.964C4.151,13.55 4.487,13.214 4.901,13.214L16.819,13.214C18.482,13.214 19.907,14.732 19.814,16.594C19.794,17.008 19.442,17.327 19.028,17.306C18.615,17.286 18.296,16.933 18.316,16.52C18.364,15.553 17.683,14.714 16.819,14.714L4.901,14.714Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M3.461,15.886L6.409,15.886C6.734,15.886 6.963,16.013 7.126,16.195C7.263,16.348 7.369,16.565 7.369,16.871L7.369,20.014C7.369,20.321 7.263,20.538 7.126,20.691C6.963,20.873 6.734,21 6.409,21L3.461,21C3.135,21 2.906,20.873 2.743,20.691C2.607,20.538 2.5,20.321 2.5,20.014L2.5,16.871C2.5,16.717 2.555,16.481 2.692,16.288C2.861,16.053 3.124,15.886 3.461,15.886ZM4,17.386L4,19.5L5.869,19.5L5.869,17.386L4,17.386Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M10.518,15.886L13.467,15.886C13.792,15.886 14.021,16.013 14.184,16.195C14.321,16.348 14.427,16.565 14.427,16.871L14.427,20.014C14.427,20.321 14.321,20.538 14.184,20.691C14.021,20.873 13.792,21 13.467,21L10.518,21C10.193,21 9.964,20.873 9.801,20.691C9.664,20.538 9.558,20.321 9.558,20.014L9.558,16.871C9.558,16.717 9.612,16.481 9.75,16.288C9.918,16.053 10.182,15.886 10.518,15.886ZM11.058,17.386L11.058,19.5L12.927,19.5L12.927,17.386L11.058,17.386Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M17.591,15.886L20.539,15.886C20.865,15.886 21.094,16.013 21.257,16.195C21.393,16.348 21.5,16.565 21.5,16.871L21.5,20.014C21.5,20.321 21.393,20.538 21.257,20.691C21.094,20.873 20.865,21 20.539,21L17.591,21C17.266,21 17.037,20.873 16.874,20.691C16.737,20.538 16.631,20.321 16.631,20.014L16.631,16.871C16.631,16.565 16.737,16.348 16.874,16.195C17.036,16.013 17.266,15.886 17.591,15.886ZM18.131,17.386L18.131,19.5L20,19.5L20,17.386L18.131,17.386Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M5.685,16.636C5.685,17.05 5.349,17.386 4.935,17.386C4.521,17.386 4.185,17.05 4.185,16.636L4.185,11.214C4.185,10.8 4.521,10.464 4.935,10.464C5.349,10.464 5.685,10.8 5.685,11.214L5.685,16.636Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (relatedProductsIcon);

/***/ }),

/***/ "./includes/frontend/blocks/icons/thank-you-page.js":
/*!**********************************************************!*\
  !*** ./includes/frontend/blocks/icons/thank-you-page.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);

var thankYouPageIcon = /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M11.189,17.476C11.203,17.42 11.219,17.37 11.233,17.336C11.306,17.167 11.413,17.03 11.554,16.93C11.779,16.758 12.024,16.694 12.279,16.696C12.305,16.696 12.335,16.698 12.367,16.7C12.369,16.681 12.371,16.663 12.374,16.648C12.416,16.422 12.517,16.221 12.712,16.063C12.932,15.861 13.175,15.789 13.439,15.791C13.469,15.791 13.506,15.794 13.546,15.798C13.586,15.569 13.665,15.291 13.823,15.132C14.011,14.944 14.246,14.853 14.444,14.81C14.421,14.766 14.396,14.722 14.372,14.686C14.171,14.384 13.879,14.063 13.577,13.765C13.181,13.374 12.766,13.023 12.485,12.802C12.259,12.957 11.748,13.307 11.407,13.53C10.779,13.94 10.108,14.165 9.538,14.012C9.11,13.896 8.679,13.592 8.361,12.897C8.242,12.637 8.281,12.331 8.463,12.11C8.463,12.11 9.624,10.704 10.339,10.177C10.64,9.943 11.195,9.703 11.829,9.534C12.737,9.293 13.803,9.191 14.39,9.317C14.795,9.404 15.053,9.803 14.966,10.208C14.879,10.612 14.48,10.87 14.076,10.784C13.648,10.692 12.876,10.808 12.214,10.984C11.812,11.091 11.447,11.212 11.262,11.36C11.253,11.367 11.244,11.374 11.234,11.381C10.882,11.637 10.404,12.152 10.06,12.545C10.14,12.522 10.222,12.485 10.304,12.441C10.532,12.322 10.761,12.158 10.979,12C11.461,11.649 11.922,11.34 12.259,11.262C12.621,11.177 12.928,11.248 13.177,11.443C13.696,11.824 15.209,13.1 15.769,14.096C16.206,14.876 16.128,15.56 15.626,15.991C15.62,15.996 15.613,16.001 15.606,16.007C15.423,16.153 15.191,16.218 15.006,16.247C15.005,16.255 15.005,16.263 15.005,16.27C14.985,16.568 14.885,16.85 14.581,17.093C14.344,17.282 14.096,17.346 13.844,17.345C13.842,17.345 13.839,17.345 13.837,17.345C13.795,17.568 13.692,17.782 13.473,17.965C13.246,18.18 12.98,18.26 12.68,18.249C12.64,18.247 12.587,18.242 12.531,18.235C12.467,18.425 12.368,18.649 12.229,18.788C12.217,18.799 12.205,18.811 12.192,18.822C11.899,19.079 11.513,19.177 11.044,19.049C10.688,18.952 10.235,18.68 9.758,18.266C8.696,17.344 7.405,15.685 6.668,14.482C6.306,13.892 6.077,13.391 6.016,13.101C5.931,12.696 6.19,12.298 6.595,12.213C7.001,12.128 7.399,12.387 7.484,12.792C7.524,12.985 7.705,13.305 7.946,13.698C8.615,14.789 9.778,16.298 10.741,17.133C10.898,17.27 11.048,17.387 11.189,17.476Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M16.687,12.451C16.994,12.173 17.469,12.197 17.746,12.505C18.024,12.812 18,13.286 17.692,13.564L15.822,15.254C15.514,15.531 15.04,15.507 14.762,15.2C14.485,14.892 14.509,14.418 14.816,14.14L16.687,12.451Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M10.222,10.251C9.812,10.303 9.436,10.011 9.385,9.6C9.334,9.19 9.626,8.814 10.036,8.763C11.224,8.615 12.642,9.477 12.642,9.477C12.992,9.698 13.097,10.161 12.875,10.511C12.654,10.861 12.191,10.966 11.841,10.745C11.841,10.745 10.966,10.159 10.222,10.251Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M11.743,8.955L6.553,14.084C6.262,14.372 5.794,14.373 5.501,14.087L2.726,11.371C2.582,11.231 2.501,11.039 2.5,10.839C2.499,10.639 2.578,10.446 2.72,10.305L7.909,5.115C8.202,4.822 8.677,4.822 8.97,5.115L11.746,7.891C11.887,8.032 11.966,8.224 11.966,8.423C11.965,8.623 11.885,8.814 11.743,8.955ZM10.152,8.418L8.44,6.706L4.317,10.829C4.317,10.829 6.023,12.499 6.023,12.499L10.152,8.418Z"
}), /*#__PURE__*/React.createElement(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__["Path"], {
  d: "M17.447,14.265L12.257,9.136C12.115,8.995 12.035,8.804 12.034,8.604C12.034,8.405 12.113,8.213 12.254,8.072L15.03,5.296C15.323,5.003 15.798,5.003 16.091,5.296L21.28,10.486C21.422,10.627 21.501,10.82 21.5,11.02C21.499,11.22 21.418,11.412 21.274,11.552L18.499,14.268C18.206,14.554 17.738,14.553 17.447,14.265ZM17.977,12.68C17.977,12.68 19.683,11.01 19.683,11.01L15.56,6.887C15.56,6.887 13.848,8.599 13.848,8.599L17.977,12.68Z"
}));
/* harmony default export */ __webpack_exports__["default"] = (thankYouPageIcon);

/***/ }),

/***/ "./includes/frontend/blocks/index.js":
/*!*******************************************!*\
  !*** ./includes/frontend/blocks/index.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _products__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./products */ "./includes/frontend/blocks/products/index.js");
/* harmony import */ var _categories__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./categories */ "./includes/frontend/blocks/categories/index.js");
/* harmony import */ var _category__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./category */ "./includes/frontend/blocks/category/index.js");




Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])('prodigy/products', _products__WEBPACK_IMPORTED_MODULE_1__["default"]);
Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])('prodigy/categories', _categories__WEBPACK_IMPORTED_MODULE_2__["default"]);
Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])('prodigy/category', _category__WEBPACK_IMPORTED_MODULE_3__["default"]);

/***/ }),

/***/ "./includes/frontend/blocks/products/index.js":
/*!****************************************************!*\
  !*** ./includes/frontend/blocks/products/index.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../icons */ "./includes/frontend/blocks/icons/index.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : String(i); }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }





var productsBlock = {
  title: 'Prodigy Products',
  icon: _icons__WEBPACK_IMPORTED_MODULE_4__["productsIcon"],
  category: 'prodigy',
  // Block attributes.
  attributes: {
    idWidget: {
      type: 'string',
      "default": ''
    },
    categoryIds: {
      type: 'string',
      "default": ''
    },
    columns: {
      type: 'integer',
      "default": 4
    },
    limit: {
      type: 'integer',
      "default": 9
    },
    tags: {
      type: 'string'
    },
    orderby: {
      type: 'string',
      "default": 'date'
    },
    on_sale: {
      type: 'boolean',
      "default": false
    },
    sale: {
      type: 'boolean',
      "default": true
    },
    category: {
      type: 'boolean',
      "default": true
    },
    rating: {
      type: 'boolean',
      "default": true
    },
    order: {
      type: 'string',
      "default": 'asc'
    },
    display: {
      type: 'string',
      "default": 'slider'
    }
  },
  edit: Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__["withSelect"])(function (select) {
    var _select = select('core'),
      getEntityRecords = _select.getEntityRecords;
    var categories = getEntityRecords('taxonomy', 'prodigy-product-category', {
      per_page: -1
    });
    return {
      categories: categories
    };
  })(function (_ref) {
    var categories = _ref.categories,
      attributes = _ref.attributes,
      setAttributes = _ref.setAttributes;
    var loading = !categories;
    var _onChange = function onChange(attribute, value) {
      setAttributes(_defineProperty({}, attribute, value));
    };
    return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InspectorControls"], null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Products Selection"
    }, categories && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["QueryControls"], {
      label: "Select Categories",
      categoriesList: categories,
      onCategoryChange: function onCategoryChange(categoryId) {
        var _categories$find;
        return _onChange('categoryIds', (_categories$find = categories.find(function (cat) {
          return cat.id === parseInt(categoryId);
        })) === null || _categories$find === void 0 ? void 0 : _categories$find.prodigyHostedCategoryRelation);
      },
      onNumberOfItemsChange: function onNumberOfItemsChange(numberOfItems) {
        return _onChange('limit', numberOfItems);
      },
      onOrderByChange: function onOrderByChange(orderBy) {
        return _onChange('orderby', orderBy);
      },
      onOrderChange: function onOrderChange(order) {
        return _onChange('order', order);
      },
      selectedCategoryId: attributes.categories,
      numberOfItems: attributes.limit,
      order: attributes.order,
      orderBy: attributes.orderby
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["SelectControl"], {
      label: "On Sale",
      value: attributes.on_sale,
      options: [{
        label: 'On Sale',
        value: true
      }, {
        label: 'All',
        value: false
      }],
      onChange: function onChange(value) {
        return _onChange('on_sale', value);
      }
    })), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["PanelBody"], {
      title: "Products Display"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["SelectControl"], {
      label: "Display",
      value: attributes.display,
      options: [{
        label: 'Grid',
        value: 'grid'
      }, {
        label: 'Slider',
        value: 'slider'
      }],
      onChange: function onChange(value) {
        return _onChange('display', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["__experimentalNumberControl"], {
      label: "Columns",
      type: "number",
      value: attributes.columns,
      min: 1,
      max: 6,
      onChange: function onChange(value) {
        return _onChange('columns', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["ToggleControl"], {
      label: "Show Sale",
      checked: attributes.sale,
      onChange: function onChange(value) {
        return _onChange('sale', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["ToggleControl"], {
      label: "Show Category",
      checked: attributes.category,
      onChange: function onChange(value) {
        return _onChange('category', value);
      }
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["ToggleControl"], {
      label: "Show Rating",
      checked: attributes.rating,
      onChange: function onChange(value) {
        return _onChange('rating', value);
      }
    }))), /*#__PURE__*/React.createElement("div", {
      className: "prodigy-".concat(attributes.display, "-columns-").concat(attributes.columns)
    }, attributes.display === 'slider' && !loading && /*#__PURE__*/React.createElement("div", {
      className: "prodigy-slider-arrow prodigy-slider-arrow-left"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["Dashicon"], {
      icon: "arrow-left-alt2"
    })), /*#__PURE__*/React.createElement(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_2___default.a, {
      block: "prodigy/products",
      attributes: attributes
    }), attributes.display === 'slider' && !loading && /*#__PURE__*/React.createElement("div", {
      className: "prodigy-slider-arrow prodigy-slider-arrow-right"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__["Dashicon"], {
      icon: "arrow-right-alt2"
    }))));
  }),
  save: function save() {
    return null;
  }
};
/* harmony default export */ __webpack_exports__["default"] = (productsBlock);

/***/ }),

/***/ 0:
/*!***********************************************************************************************!*\
  !*** multi ./includes/frontend/blocks/index.js ./includes/frontend/blocks/editor-styles.scss ***!
  \***********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./includes/frontend/blocks/index.js */"./includes/frontend/blocks/index.js");
module.exports = __webpack_require__(/*! ./includes/frontend/blocks/editor-styles.scss */"./includes/frontend/blocks/editor-styles.scss");


/***/ }),

/***/ "@wordpress/block-editor":
/*!*********************************!*\
  !*** external "wp.blockEditor" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.blockEditor;

/***/ }),

/***/ "@wordpress/blocks":
/*!****************************!*\
  !*** external "wp.blocks" ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.blocks;

/***/ }),

/***/ "@wordpress/components":
/*!********************************!*\
  !*** external "wp.components" ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.components;

/***/ }),

/***/ "@wordpress/data":
/*!**************************!*\
  !*** external "wp.data" ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.data;

/***/ }),

/***/ "@wordpress/primitives":
/*!********************************!*\
  !*** external "wp.primitives" ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.primitives;

/***/ }),

/***/ "@wordpress/server-side-render":
/*!**************************************!*\
  !*** external "wp.serverSideRender" ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = wp.serverSideRender;

/***/ })

/******/ });
//# sourceMappingURL=blocks.js.map