webpackJsonp([2],{

/***/ 158:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(463)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(396),
  /* template */
  __webpack_require__(442),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/pages/MyMatchesPage.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MyMatchesPage.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4cb4a4b0", Component.options)
  } else {
    hotAPI.reload("data-v-4cb4a4b0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 318:
/***/ (function(module, exports) {

module.exports = "/images/guy-2.jpg?7059bb621eaab9ba65f42e436e7ea3a3";

/***/ }),

/***/ 319:
/***/ (function(module, exports) {

module.exports = "/images/woman-1.jpg?0f9bf730f55eddb5d6e68c6c1d50a027";

/***/ }),

/***/ 320:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {

    computed: _extends({
        loggedIn: function loggedIn() {
            return this.authUserStore.authUser !== null && this.authUserStore.authUser.access_token !== null;
        }
    }, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        authUserStore: function authUserStore(state) {
            return state.authUser;
        }
    }))

};

/***/ }),

/***/ 321:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(320),
  /* template */
  __webpack_require__(323),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/SidebarLeft.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] SidebarLeft.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0a377dac", Component.options)
  } else {
    hotAPI.reload("data-v-0a377dac", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 322:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  null,
  /* template */
  __webpack_require__(324),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/SidebarRight.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] SidebarRight.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-c22e03ee", Component.options)
  } else {
    hotAPI.reload("data-v-c22e03ee", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 323:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "fixed-sidebar-left"
  }, [_c('ul', {
    staticClass: "nav navbar-nav side-nav nicescroll-bar"
  }, [_c('li', {
    staticClass: "navigation-header"
  }, [_c('span', [_vm._v("\n            " + _vm._s(_vm.authUserStore.authUser.first_name) + "  \n            " + _vm._s(_vm.authUserStore.authUser.last_name) + "\n         ")]), _vm._v(" "), _c('i', {
    staticClass: "zmdi zmdi-more"
  })]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c('li', [_vm._m(1), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1",
    attrs: {
      "id": "app_dr"
    }
  }, [_c('router-link', {
    attrs: {
      "to": {
        name: 'admincreateuser'
      },
      "activeClass": "active",
      "tag": "li",
      "exact": ""
    }
  }, [_c('a', [_vm._v("\n                    Create New User\n                ")])]), _vm._v(" "), _c('router-link', {
    attrs: {
      "to": {
        name: 'admincreateuser'
      },
      "activeClass": "active",
      "tag": "li",
      "exact": ""
    }
  }, [_c('a', [_vm._v("\n                    Manage Users\n                ")])])], 1)]), _vm._v(" "), _vm._m(2), _vm._v(" "), _vm._m(3), _vm._v(" "), _vm._m(4), _vm._v(" "), _vm._m(5), _vm._v(" "), _vm._m(6), _vm._v(" "), _vm._m(7), _vm._v(" "), _vm._m(8), _vm._v(" "), _vm._m(9), _vm._v(" "), _vm._m(10), _vm._v(" "), _vm._m(11), _vm._v(" "), _vm._m(12), _vm._v(" "), _vm._m(13), _vm._v(" "), _vm._m(14), _vm._v(" "), _vm._m(15)])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    staticClass: "active",
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#dashboard_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-landscape mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Dashboard")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1",
    attrs: {
      "id": "dashboard_dr"
    }
  }, [_c('li', [_c('a', {
    staticClass: "active-page",
    attrs: {
      "href": "index.php"
    }
  }, [_vm._v("Home")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "index2.php"
    }
  }, [_vm._v("Home 2")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "profile.html"
    }
  }, [_vm._v("profile")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#app_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-apps mr-20"
  }), _vm._v(" "), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Users ")])]), _vm._v(" "), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "widgets.php"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-flag mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("widgets")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('span', {
    staticClass: "label label-warning"
  }, [_vm._v("8")])]), _c('div', {
    staticClass: "clearfix"
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('hr', {
    staticClass: "light-grey-hr mb-10"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "navigation-header"
  }, [_c('span', [_vm._v("component")]), _vm._v(" "), _c('i', {
    staticClass: "zmdi zmdi-more"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#ui_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-smartphone-setup mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("UI Elements")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1 two-col-list",
    attrs: {
      "id": "ui_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "panels_wells.php"
    }
  }, [_vm._v("Panels & Wells")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "modals.php"
    }
  }, [_vm._v("Modals")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "sweetalert.html"
    }
  }, [_vm._v("Sweet Alerts")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "notifications.php"
    }
  }, [_vm._v("notifications")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "typography.html"
    }
  }, [_vm._v("Typography")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "buttons.php"
    }
  }, [_vm._v("Buttons")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "accordion-toggle.html"
    }
  }, [_vm._v("Accordion / Toggles")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "tabs.html"
    }
  }, [_vm._v("Tabs")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "progressbars.php"
    }
  }, [_vm._v("Progress bars")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "dorpdown.html"
    }
  }, [_vm._v("Dropdowns")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "carousel.php"
    }
  }, [_vm._v("Carousel")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "range_slider.php"
    }
  }, [_vm._v("Range Slider")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "grid-styles.html"
    }
  }, [_vm._v("Grid")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "bootstrap-ui.html"
    }
  }, [_vm._v("Bootstrap UI")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#form_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-edit mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Forms")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1 two-col-list",
    attrs: {
      "id": "form_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "form_element.php"
    }
  }, [_vm._v("Main Form")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_new_group.php"
    }
  }, [_vm._v("New Group")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_layout.php"
    }
  }, [_vm._v("form Layout")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_advanced.php"
    }
  }, [_vm._v("Form Advanced")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_picker.php"
    }
  }, [_vm._v("Form Picker")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_validation.php"
    }
  }, [_vm._v("form Validation")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_cropper.php"
    }
  }, [_vm._v("Cropperjs")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "file_upload.php"
    }
  }, [_vm._v("File Upload")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "form_type_ahead.php"
    }
  }, [_vm._v("Type Ahead")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#chart_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-chart-donut mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Charts ")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1 two-col-list",
    attrs: {
      "id": "chart_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "flot-chart.html"
    }
  }, [_vm._v("Flot Chart")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "morris-chart.html"
    }
  }, [_vm._v("Morris Chart")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "chart.js.html"
    }
  }, [_vm._v("chartjs")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "chartist.html"
    }
  }, [_vm._v("chartist")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "easy-pie-chart.html"
    }
  }, [_vm._v("Easy Pie Chart")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "sparkline.html"
    }
  }, [_vm._v("Sparkline")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "peity-chart.html"
    }
  }, [_vm._v("Peity Chart")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#table_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-format-size mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Tables")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1 two-col-list",
    attrs: {
      "id": "table_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "basic-table.html"
    }
  }, [_vm._v("Basic Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "bootstrap-table.html"
    }
  }, [_vm._v("Bootstrap Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "data-table.html"
    }
  }, [_vm._v("Data Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "export-table.html"
    }
  }, [_c('span', {
    staticClass: "pull-right"
  }, [_c('span', {
    staticClass: "label label-danger"
  }, [_vm._v("New")])]), _vm._v("Export Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "responsive-data-table.html"
    }
  }, [_c('span', {
    staticClass: "pull-right"
  }, [_c('span', {
    staticClass: "label label-danger"
  }, [_vm._v("New")])]), _vm._v("RSPV DataTable")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "responsive-table.html"
    }
  }, [_vm._v("Responsive Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "editable-table.html"
    }
  }, [_vm._v("Editable Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "foo-table.html"
    }
  }, [_vm._v("Foo Table")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "jsgrid-table.html"
    }
  }, [_vm._v("Jsgrid Table")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#icon_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-iridescent mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Icons")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1",
    attrs: {
      "id": "icon_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "fontawesome.html"
    }
  }, [_vm._v("Fontawesome")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "themify.html"
    }
  }, [_vm._v("Themify")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "linea-icon.html"
    }
  }, [_vm._v("Linea")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "simple-line-icons.html"
    }
  }, [_vm._v("Simple Line")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "pe-icon-7.html"
    }
  }, [_vm._v("Pe-icon-7")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "glyphicons.html"
    }
  }, [_vm._v("Glyphicons")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#maps_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-map mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("maps")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1",
    attrs: {
      "id": "maps_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "google_map.php"
    }
  }, [_vm._v("Google Map")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('hr', {
    staticClass: "light-grey-hr mb-10"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "navigation-header"
  }, [_c('span', [_vm._v("featured")]), _vm._v(" "), _c('i', {
    staticClass: "zmdi zmdi-more"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#pages_dr"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-google-pages mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("Special Pages")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1 two-col-list",
    attrs: {
      "id": "pages_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "blank.html"
    }
  }, [_vm._v("Blank Page")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#auth_dr"
    }
  }, [_vm._v("Authantication pages"), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-2",
    attrs: {
      "id": "auth_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "login.php"
    }
  }, [_vm._v("Login")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "register.php"
    }
  }, [_vm._v("Register")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "forgot_password.php"
    }
  }, [_vm._v("Forgot Password")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "reset-password.html"
    }
  }, [_vm._v("reset Password")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "locked.html"
    }
  }, [_vm._v("Lock Screen")])])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#invoice_dr"
    }
  }, [_vm._v("Invoice"), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-2",
    attrs: {
      "id": "invoice_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "invoice.html"
    }
  }, [_vm._v("Invoice")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "invoice-archive.html"
    }
  }, [_vm._v("Invoice Archive")])])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#error_dr"
    }
  }, [_vm._v("error pages"), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-2",
    attrs: {
      "id": "error_dr"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "404.html"
    }
  }, [_vm._v("Error 404")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "500.html"
    }
  }, [_vm._v("Error 500")])])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "gallery.html"
    }
  }, [_vm._v("Gallery")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "timeline.html"
    }
  }, [_vm._v("Timeline")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "faq.html"
    }
  }, [_vm._v("FAQ")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "documentation.html"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-book mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("documentation")])]), _c('div', {
    staticClass: "clearfix"
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#dropdown_dr_lv1"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-filter-list mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("multilevel")])]), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-1",
    attrs: {
      "id": "dropdown_dr_lv1"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Item level 1")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "collapse",
      "data-target": "#dropdown_dr_lv2"
    }
  }, [_vm._v("Dropdown level 2"), _c('div', {
    staticClass: "pull-right"
  }, [_c('i', {
    staticClass: "zmdi zmdi-caret-down"
  })]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "collapse collapse-level-2",
    attrs: {
      "id": "dropdown_dr_lv2"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Item level 2")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Item level 2")])])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-0a377dac", module.exports)
  }
}

/***/ }),

/***/ 324:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "fixed-sidebar-right"
  }, [_c('ul', {
    staticClass: "right-sidebar"
  }, [_c('li', [_c('div', {
    staticClass: "tab-struct custom-tab-1"
  }, [_c('ul', {
    staticClass: "nav nav-tabs",
    attrs: {
      "role": "tablist",
      "id": "right_sidebar_tab"
    }
  }, [_c('li', {
    staticClass: "active",
    attrs: {
      "role": "presentation"
    }
  }, [_c('a', {
    attrs: {
      "aria-expanded": "true",
      "data-toggle": "tab",
      "role": "tab",
      "id": "chat_tab_btn",
      "href": "#chat_tab"
    }
  }, [_vm._v("chat")])]), _vm._v(" "), _c('li', {
    attrs: {
      "role": "presentation"
    }
  }, [_c('a', {
    attrs: {
      "data-toggle": "tab",
      "id": "messages_tab_btn",
      "role": "tab",
      "href": "#messages_tab",
      "aria-expanded": "false"
    }
  }, [_vm._v("messages")])]), _vm._v(" "), _c('li', {
    attrs: {
      "role": "presentation"
    }
  }, [_c('a', {
    attrs: {
      "data-toggle": "tab",
      "id": "todo_tab_btn",
      "role": "tab",
      "href": "#todo_tab",
      "aria-expanded": "false"
    }
  }, [_vm._v("todo")])])]), _vm._v(" "), _c('div', {
    staticClass: "tab-content",
    attrs: {
      "id": "right_sidebar_content"
    }
  }, [_c('div', {
    staticClass: "tab-pane fade active in",
    attrs: {
      "id": "chat_tab",
      "role": "tabpanel"
    }
  }, [_c('div', {
    staticClass: "chat-cmplt-wrap"
  }, [_c('div', {
    staticClass: "chat-box-wrap"
  }, [_c('div', {
    staticClass: "add-friend"
  }, [_c('a', {
    staticClass: "inline-block txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more"
  })]), _vm._v(" "), _c('span', {
    staticClass: "inline-block txt-dark"
  }, [_vm._v("users")]), _vm._v(" "), _c('a', {
    staticClass: "inline-block text-right txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-plus"
  })]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('form', {
    staticClass: "chat-search pl-15 pr-15 pb-15",
    attrs: {
      "role": "search"
    }
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "text",
      "id": "example-input1-group2",
      "name": "example-input1-group2",
      "placeholder": "Search"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "input-group-btn"
  }, [_c('button', {
    staticClass: "btn  btn-default",
    attrs: {
      "type": "button"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-search"
  })])])])]), _vm._v(" "), _c('div', {
    attrs: {
      "id": "chat_list_scroll"
    }
  }, [_c('div', {
    staticClass: "nicescroll-bar"
  }, [_c('ul', {
    staticClass: "chat-list-wrap"
  }, [_c('li', {
    staticClass: "chat-list"
  }, [_c('div', {
    staticClass: "chat-body"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Clay Masse")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("No one saves us but ourselves.")])]), _vm._v(" "), _c('div', {
    staticClass: "status away"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user1.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Evie Ono")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Unity is strength")])]), _vm._v(" "), _c('div', {
    staticClass: "status offline"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user2.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Madalyn Rascon")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Respect yourself if you would have others respect you.")])]), _vm._v(" "), _c('div', {
    staticClass: "status online"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user3.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Mitsuko Heid")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("I’m thankful.")])]), _vm._v(" "), _c('div', {
    staticClass: "status online"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Ezequiel Merideth")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Patience is bitter.")])]), _vm._v(" "), _c('div', {
    staticClass: "status offline"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user1.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Jonnie Metoyer")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Genius is eternal patience.")])]), _vm._v(" "), _c('div', {
    staticClass: "status online"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user2.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Angelic Lauver")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Every burden is a blessing.")])]), _vm._v(" "), _c('div', {
    staticClass: "status away"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user3.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Priscila Shy")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Wise to resolve, and patient to perform.")])]), _vm._v(" "), _c('div', {
    staticClass: "status online"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "chat-data"
  }, [_c('img', {
    staticClass: "user-img img-circle",
    attrs: {
      "src": "/css/images/user4.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "user-data"
  }, [_c('span', {
    staticClass: "name block capitalize-font"
  }, [_vm._v("Linda Stack")]), _vm._v(" "), _c('span', {
    staticClass: "time block truncate txt-grey"
  }, [_vm._v("Our patience will achieve more than our force.")])]), _vm._v(" "), _c('div', {
    staticClass: "status away"
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])])])])])])])]), _vm._v(" "), _c('div', {
    staticClass: "recent-chat-box-wrap"
  }, [_c('div', {
    staticClass: "recent-chat-wrap"
  }, [_c('div', {
    staticClass: "panel-heading ma-0"
  }, [_c('div', {
    staticClass: "goto-back"
  }, [_c('a', {
    staticClass: "inline-block txt-grey",
    attrs: {
      "id": "goto_back",
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-chevron-left"
  })]), _vm._v(" "), _c('span', {
    staticClass: "inline-block txt-dark"
  }, [_vm._v("ryan")]), _vm._v(" "), _c('a', {
    staticClass: "inline-block text-right txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more"
  })]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "panel-wrapper collapse in"
  }, [_c('div', {
    staticClass: "panel-body pa-0"
  }, [_c('div', {
    staticClass: "chat-content"
  }, [_c('ul', {
    staticClass: "nicescroll-bar pt-20"
  }, [_c('li', {
    staticClass: "friend"
  }, [_c('div', {
    staticClass: "friend-msg-wrap"
  }, [_c('img', {
    staticClass: "user-img img-circle block pull-left",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "msg pull-left"
  }, [_c('p', [_vm._v("Hello Jason, how are you, it's been a long time since we last met?")]), _vm._v(" "), _c('div', {
    staticClass: "msg-per-detail text-right"
  }, [_c('span', {
    staticClass: "msg-time txt-grey"
  }, [_vm._v("2:30 PM")])])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "self mb-10"
  }, [_c('div', {
    staticClass: "self-msg-wrap"
  }, [_c('div', {
    staticClass: "msg block pull-right"
  }, [_vm._v(" Oh, hi Sarah I'm have got a new job now and is going great.\n                                                "), _c('div', {
    staticClass: "msg-per-detail text-right"
  }, [_c('span', {
    staticClass: "msg-time txt-grey"
  }, [_vm._v("2:31 pm")])])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "self"
  }, [_c('div', {
    staticClass: "self-msg-wrap"
  }, [_c('div', {
    staticClass: "msg block pull-right"
  }, [_vm._v("  How about you?\n                                                "), _c('div', {
    staticClass: "msg-per-detail text-right"
  }, [_c('span', {
    staticClass: "msg-time txt-grey"
  }, [_vm._v("2:31 pm")])])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])]), _vm._v(" "), _c('li', {
    staticClass: "friend"
  }, [_c('div', {
    staticClass: "friend-msg-wrap"
  }, [_c('img', {
    staticClass: "user-img img-circle block pull-left",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "user"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "msg pull-left"
  }, [_c('p', [_vm._v("Not too bad.")]), _vm._v(" "), _c('div', {
    staticClass: "msg-per-detail  text-right"
  }, [_c('span', {
    staticClass: "msg-time txt-grey"
  }, [_vm._v("2:35 pm")])])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])])])]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    staticClass: "input-msg-send form-control",
    attrs: {
      "type": "text",
      "id": "input_msg_send",
      "name": "send-msg",
      "placeholder": "Type something"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "input-group-btn emojis"
  }, [_c('div', {
    staticClass: "dropup"
  }, [_c('button', {
    staticClass: "btn  btn-default  dropdown-toggle",
    attrs: {
      "type": "button",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-mood"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu dropdown-menu-right"
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v("Action")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v("Another action")])]), _vm._v(" "), _c('li', {
    staticClass: "divider"
  }), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v("Separated link")])])])])]), _vm._v(" "), _c('div', {
    staticClass: "input-group-btn attachment"
  }, [_c('div', {
    staticClass: "fileupload btn  btn-default"
  }, [_c('i', {
    staticClass: "zmdi zmdi-attachment-alt"
  }), _vm._v(" "), _c('input', {
    staticClass: "upload",
    attrs: {
      "type": "file"
    }
  })])])])])])])])])]), _vm._v(" "), _c('div', {
    staticClass: "tab-pane fade",
    attrs: {
      "id": "messages_tab",
      "role": "tabpanel"
    }
  }, [_c('div', {
    staticClass: "message-box-wrap"
  }, [_c('div', {
    staticClass: "msg-search"
  }, [_c('a', {
    staticClass: "inline-block txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more"
  })]), _vm._v(" "), _c('span', {
    staticClass: "inline-block txt-dark"
  }, [_vm._v("messages")]), _vm._v(" "), _c('a', {
    staticClass: "inline-block text-right txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-search"
  })]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('div', {
    staticClass: "set-height-wrap"
  }, [_c('div', {
    staticClass: "streamline message-box nicescroll-bar"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item unread-message"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Clay Masse")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("12:28 AM")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Themeforest message sent via your envato market profile")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsu messm quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user1.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Evie Ono")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("1 Feb")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Pogody theme support")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user2.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Madalyn Rascon")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("31 Jan")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Congratulations from design nominees")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item unread-message"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user3.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Ezequiel Merideth")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("29 Jan")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Themeforest item support message")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item unread-message"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user4.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Jonnie Metoyer")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("27 Jan")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Help with beavis contact form")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Priscila Shy")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("19 Jan")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v("Your uploaded theme is been selected")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-item"
  }, [_c('div', {
    staticClass: "sl-avatar avatar avatar-sm avatar-circle"
  }, [_c('img', {
    staticClass: "img-responsive img-circle",
    attrs: {
      "src": "/css/images/user1.png",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font   pull-left message-per"
  }, [_vm._v("Linda Stack")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right message-time"
  }, [_vm._v("13 Jan")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('span', {
    staticClass: " truncate message-subject"
  }, [_vm._v(" A new rating has been received")]), _vm._v(" "), _c('p', {
    staticClass: "txt-grey truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])])])])])]), _vm._v(" "), _c('div', {
    staticClass: "tab-pane fade",
    attrs: {
      "id": "todo_tab",
      "role": "tabpanel"
    }
  }, [_c('div', {
    staticClass: "todo-box-wrap"
  }, [_c('div', {
    staticClass: "add-todo"
  }, [_c('a', {
    staticClass: "inline-block txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more"
  })]), _vm._v(" "), _c('span', {
    staticClass: "inline-block txt-dark"
  }, [_vm._v("todo list")]), _vm._v(" "), _c('a', {
    staticClass: "inline-block text-right txt-grey",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-plus"
  })]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('div', {
    staticClass: "set-height-wrap"
  }, [_c('ul', {
    staticClass: "todo-list nicescroll-bar"
  }, [_c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-default"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox01"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox01"
    }
  }, [_vm._v("Record The First Episode")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })]), _vm._v(" "), _c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-pink"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox02"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox02"
    }
  }, [_vm._v("Prepare The Conference Schedule")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })]), _vm._v(" "), _c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-warning"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox03",
      "checked": ""
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox03"
    }
  }, [_vm._v("Decide The Live Discussion Time")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })]), _vm._v(" "), _c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-success"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox04",
      "checked": ""
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox04"
    }
  }, [_vm._v("Prepare For The Next Project")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })]), _vm._v(" "), _c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-danger"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox05",
      "checked": ""
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox05"
    }
  }, [_vm._v("Finish Up AngularJs Tutorial")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })]), _vm._v(" "), _c('li', {
    staticClass: "todo-item"
  }, [_c('div', {
    staticClass: "checkbox checkbox-purple"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "checkbox06",
      "checked": ""
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox06"
    }
  }, [_vm._v("Finish Infinity Project")])])]), _vm._v(" "), _c('li', [_c('hr', {
    staticClass: "light-grey-hr"
  })])])])])])])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-c22e03ee", module.exports)
  }
}

/***/ }),

/***/ 325:
/***/ (function(module, exports) {

module.exports = "/images/guy-1.jpg?7979f6d1ec0f7702ca06461f481ca528";

/***/ }),

/***/ 326:
/***/ (function(module, exports) {

module.exports = "/images/guy-6.jpg?6f90fe825c4bf4d2863e492d93153293";

/***/ }),

/***/ 327:
/***/ (function(module, exports) {

module.exports = "/images/place2-full.jpg?21499f7215217584bcf0a98417596cd6";

/***/ }),

/***/ 328:
/***/ (function(module, exports) {

module.exports = "/images/woman-3.jpg?343a578ba624e5bed2acb1a743b6b8cb";

/***/ }),

/***/ 329:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway__ = __webpack_require__(150);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_clickaway___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_clickaway__);
var _this = this;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = {

    mixins: [__WEBPACK_IMPORTED_MODULE_1_vue_clickaway___default.a.mixin],
    props: ['comment', 'post'],
    data: function data() {
        return {
            editCommentValue: this.comment.content,
            editing: false,
            saveLoading: false,
            todayDate: false,
            deleteLoading: false,
            emoji: '',
            less_four_hr: false,
            less_one_day: false,
            less_one_wk: false,
            more_one_wk: false,
            showCommentActions: true,
            comments_menu_drop: false
        };
    },


    computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        authUserStore: function authUserStore(state) {
            return state.authUser;
        }
    }), {
        thisCommentUserLink: function thisCommentUserLink() {
            return '/profile/' + this.comment.user_id;
        }
    }),
    methods: {

        //check if this is the logged in user or not
        isAuthUser: function isAuthUser(user_id) {
            return user_id === this.authUserStore.authUser.id;
        },


        onCommentHover: _.throttle(function () {
            _this.showCommentActions = true; //fire after half seconds
            //console.log("true");
            //this.showCommentActions = !this.showCommentActions
        }, 500),

        onCommentHoverOut: _.throttle(function () {
            _this.showCommentActions = false; //fire after half seconds
            //console.log("false");
            //this.showCommentActions = !this.showCommentActions
        }, 500),

        onCommentsMenuClick: function onCommentsMenuClick() {
            this.comments_menu_drop = true;
        },
        onCommentEditClick: function onCommentEditClick() {
            this.editCommentValue = this.comment.content;
            this.editing = true;
        },
        onCommentDeleteClick: function onCommentDeleteClick() {

            $('#deleteModal').modal('show');
        },
        onDeleteComment: function onDeleteComment() {
            var _this2 = this;

            this.deleteLoading = true;

            if (this.comment !== null) {

                var postData = {
                    'id': this.comment.id
                    //post form data
                };this.$store.dispatch('deleteComment', postData).then(function (response) {

                    _this2.loading = false;
                    _this2.deleteLoading = false;

                    //close modal
                    $('#deleteModal').modal('toggle' //or  $('#IDModal').modal('hide');
                    );return false;
                }).catch(function (error) {
                    return console.log(error);
                });
            }
        },
        onCancel: function onCancel() {
            this.editCommentValue = this.comment.content;
            this.saveLoading = false;
            this.editing = false;
        },


        away: function away() {
            this.comments_menu_drop = false;
            console.log('clicked away');
        },

        onUpdate: function onUpdate() {
            var _this3 = this;

            if (this.comment.content !== null) {

                this.saveLoading = true;

                var postData = {
                    'content': this.editCommentValue,
                    'id': this.comment.id

                    //post form data
                };this.$store.dispatch('updatePostComment', postData).then(function (response) {
                    _this3.saveLoading = false;
                    _this3.editing = false;
                }).catch(function (error) {
                    return console.log(error);
                });
            }
        }
    },

    created: function created() {

        //this.emoji = twemoji.parse('\ud83d\ude07\ud83d\ude09');
        //this.emoji = twemoji.parse(document.body);

        //this.emoji = twemoji.convert.toCodePoint('\ud83c\udde8\ud83c\uddf3');

        this.todayDate = false;
        this.less_four_hr = false;
        this.less_one_day = false;
        this.less_one_wk = false;
        this.more_one_wk = false;

        var created_at = this.comment.created_at;
        var todayDateValue = new Date(Date.now());

        var content = this.comment.content;

        var ONE_HOUR = 60 * 60 * 1000; /* ms */
        var FOUR_HOUR = ONE_HOUR * 4;
        var ONE_DAY = ONE_HOUR * 24;
        var ONE_WEEK = ONE_DAY * 7;

        var created_date_obj = new Date(created_at);

        var timeDifference = Math.floor(todayDateValue - created_date_obj.getTime()

        //check if date is today
        );var isToday = created_date_obj.toDateString() === todayDateValue.toDateString();

        if (isToday) {
            this.todayDate = true;
        }

        //check if created time is less than an hr
        if (timeDifference < FOUR_HOUR) {
            this.less_four_hr = true;
        } else if (timeDifference > FOUR_HOUR && timeDifference < ONE_DAY) {
            this.less_one_day = true;
        } else if (timeDifference > ONE_DAY && timeDifference < ONE_WEEK) {
            this.less_one_wk = true;
        } else if (timeDifference > ONE_WEEK) {
            this.more_one_wk = true;
        }
    }
};

/***/ }),

/***/ 330:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = {

    props: ['post'],

    data: function data() {
        return {
            content: '',
            textLength: '',
            typing: false,
            addLoading: false
        };
    },


    methods: {
        onAddComment: function onAddComment() {
            var _this = this;

            this.addLoading = true;
            var post_id = this.post.id;

            if (post_id !== null) {

                var postData = {
                    'content': this.content,
                    'post_id': post_id

                    //post form data
                };this.$store.dispatch('addNewComment', postData).then(function (response) {
                    _this.addLoading = false;
                    _this.content = null;
                    _this.textLength = 0;
                    _this.$emit('addCommentChild', false);
                }).catch(function (error) {
                    return console.log(error);
                });
            }
        },
        addCommentClick: function addCommentClick() {
            this.$emit("clickCommentAddComment", true);
        },
        onTextKeyPress: function onTextKeyPress() {

            this.textLength = this.content.length;

            //if text is typed in
            if (this.content.length > 0) {
                typing: true;
            } else {
                typing: false;
            }
        }
    }

};

/***/ }),

/***/ 331:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Comment_vue__ = __webpack_require__(342);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Comment_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Comment_vue__);
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {

    props: ['post', 'comments'],

    components: {
        appPostComment: __WEBPACK_IMPORTED_MODULE_0__Comment_vue___default.a
    }

};

/***/ }),

/***/ 332:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__PostText_vue__ = __webpack_require__(347);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__PostText_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__PostText_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__comment_Comments_vue__ = __webpack_require__(344);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__comment_Comments_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__comment_Comments_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__comment_CommentAdd_vue__ = __webpack_require__(343);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__comment_CommentAdd_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__comment_CommentAdd_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {

    props: ['post'],

    components: {
        appPostText: __WEBPACK_IMPORTED_MODULE_0__PostText_vue___default.a,
        appPostCommentForm: __WEBPACK_IMPORTED_MODULE_2__comment_CommentAdd_vue___default.a,
        appPostComments: __WEBPACK_IMPORTED_MODULE_1__comment_Comments_vue___default.a
    },

    data: function data() {
        return {
            emoji: '',
            visible: false,
            addCommentBool: false,
            postcomments: [],
            postLikes: []
        };
    },


    methods: {
        getPostComments: function getPostComments() {
            var _this = this;

            this.$store.dispatch('getPostComments', this.post).then(function (response) {
                //console.log(response)
                _this.postcomments = response;
            });
        },
        getPostLikes: function getPostLikes() {
            var _this2 = this;

            this.$store.dispatch('getPostLikes', this.post).then(function (response) {
                //console.log(response)
                _this2.postLikes = response;
            });
        },
        addCommentChild: function addCommentChild() {
            //hide comment box
            this.addCommentBool = false;
        }
    },

    mounted: function mounted() {

        this.getPostComments(), this.getPostLikes();
    },
    computed: function computed() {

        this.getPostComments(), this.getPostLikes();
    }
};

/***/ }),

/***/ 333:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {
    data: function data() {
        return {
            content: '',
            textLength: '',
            addLoading: false
        };
    },


    methods: {
        onTextKeyPress: function onTextKeyPress() {
            this.textLength = this.content.length;
        },
        onSubmitted: function onSubmitted() {
            var _this = this;

            this.addLoading = true;

            if (this.content !== null) {

                var postData = {
                    'content': this.content,
                    'wall_id': this.currentUserStore.currentUser.id

                    //post form data
                };this.$store.dispatch('addNewPost', postData).then(function (response) {
                    _this.addLoading = false;
                    _this.content = null;
                    _this.textLength = 0;
                }).catch(function (error) {
                    return console.log(error);
                });
            }
        }
    },

    computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        currentUserStore: function currentUserStore(state) {
            return state.currentUser;
        }
    }))

};

/***/ }),

/***/ 334:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = {

    props: ['post', 'postLikes', 'comments'],

    data: function data() {
        return {
            emoji: '',
            visible: false,
            todayDate: false,
            addCommentBool: false,
            post_menu_drop: false,
            less_four_hr: false,
            less_one_day: false,
            less_one_wk: false,
            more_one_wk: false,
            addLoading: false,
            //comments: [],
            isLiked: false

        };
    },


    methods: {
        postLikeClick: function postLikeClick() {
            var _this = this;

            this.addLoading = true;

            var postData = {
                'post_id': this.post.id

                //post form data
            };this.$store.dispatch('addNewLike', postData).then(function (response) {
                _this.addLoading = false;
                _this.isLiked = true;
                _this.postLikes.length = _this.postLikes.length + 1;
            }).catch(function (error) {
                return console.log(error);
            });
        },
        postUnlikeClick: function postUnlikeClick() {
            var _this2 = this;

            this.addLoading = true;

            var postData = {
                'id': this.post.id

                //post form data
            };this.$store.dispatch('deleteLike', postData).then(function (response) {
                _this2.addLoading = false;
                _this2.isLiked = false;
                _this2.postLikes.length = _this2.postLikes.length - 1;
            }).catch(function (error) {
                return console.log(error);
            });
        },
        onPostEditClick: function onPostEditClick() {},
        onPostDeleteClick: function onPostDeleteClick() {},
        addCommentClick: function addCommentClick() {
            this.$emit("clickAddComment", true);
        }
    },

    mounted: function mounted() {

        this.isLiked = this.isPostUserLike ? true : false;
    },


    computed: {
        thisPostUserLink: function thisPostUserLink() {
            return '/profile/' + this.post.user_id;
        },
        isPostUserLike: function isPostUserLike() {
            return this.post.liked_by_auth_user;
        }
    },

    created: function created() {

        //this.emoji = twemoji.parse('\ud83d\ude07\ud83d\ude09');
        //this.emoji = twemoji.parse(document.body);

        //this.emoji = twemoji.convert.toCodePoint('\ud83c\udde8\ud83c\uddf3');

        //get time differences in created date
        var created_at = this.post.created_at;

        var todayDateValue = new Date(Date.now());

        var content = this.post.content;

        var ONE_HOUR = 60 * 60 * 1000; /* ms */
        var FOUR_HOUR = ONE_HOUR * 4;
        var ONE_DAY = ONE_HOUR * 24;
        var ONE_WEEK = ONE_DAY * 7;

        var created_date_obj = new Date(created_at);

        var timeDifference = Math.floor(todayDateValue - created_date_obj.getTime());

        //check if date is today
        var isToday = created_date_obj.toDateString() === todayDateValue.toDateString();

        if (isToday) {
            this.todayDate = true;
        }

        //check if created time is less than an hr
        if (timeDifference < FOUR_HOUR) {
            this.less_four_hr = true;
        } else if (timeDifference > FOUR_HOUR && timeDifference < ONE_DAY) {
            this.less_one_day = true;
        } else if (timeDifference > ONE_DAY && timeDifference < ONE_WEEK) {
            this.less_one_wk = true;
        } else if (timeDifference > ONE_WEEK) {
            this.more_one_wk = true;
        }
    }
};

/***/ }),

/***/ 335:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Post_vue__ = __webpack_require__(345);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Post_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__Post_vue__);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = {

    components: {
        appPost: __WEBPACK_IMPORTED_MODULE_1__Post_vue___default.a
    },

    computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        postStore: function postStore(state) {
            return state.posts;
        }
    }))

};

/***/ }),

/***/ 336:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 337:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/*ul li:nth-child(n+3) {\n    display:none;\n}\nul li {\n    border: 1px solid #aaa;\n}\nspan {\n    cursor: pointer;\n    color: #f00;\n}*/\n.comments{background:#f7f7f7;\n}\nul.emoji-list * {\n    -webkit-user-select: none;\n    -moz-user-select: none;\n    -ms-user-select: none;\n    user-select: none;\n}\nul.emoji-list li {\n    font-size: 36px;\n    float: left;\n    display: inline-block;\n    padding: 2px;\n    margin: 4px;\n}\nimg.emoji {\n    cursor: pointer;\n    height: 1em;\n    width: 1em;\n    margin: 0 .05em 0 .1em;\n    vertical-align: -0.1em;\n}\n\n/*transitions*/\n.fade-enter-active, .fade-leave-active {\n    transition: opacity .5s\n}\n.fade-enter, .fade-leave-to {\n    opacity: 0\n}\n/*transitions*/\n\n", ""]);

// exports


/***/ }),

/***/ 338:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 339:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\nli.single-comment{margin-bottom: 5px;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 340:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\ni.filled{color:#e74c3c;\n}\ni.fa span{font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 341:
/***/ (function(module, exports) {

module.exports = "/images/guy-3.jpg?e0ed599e80d52b92218427770df523d5";

/***/ }),

/***/ 342:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(359)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(329),
  /* template */
  __webpack_require__(353),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/comment/Comment.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Comment.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-52d9dc58", Component.options)
  } else {
    hotAPI.reload("data-v-52d9dc58", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 343:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(356)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(330),
  /* template */
  __webpack_require__(350),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/comment/CommentAdd.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CommentAdd.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-120011dd", Component.options)
  } else {
    hotAPI.reload("data-v-120011dd", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 344:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(331),
  /* template */
  __webpack_require__(349),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/comment/Comments.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Comments.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-010a6c62", Component.options)
  } else {
    hotAPI.reload("data-v-010a6c62", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 345:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(357)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(332),
  /* template */
  __webpack_require__(351),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/post/Post.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Post.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-17511dd4", Component.options)
  } else {
    hotAPI.reload("data-v-17511dd4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 346:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(358)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(333),
  /* template */
  __webpack_require__(352),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/post/PostAdd.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] PostAdd.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-35f685dd", Component.options)
  } else {
    hotAPI.reload("data-v-35f685dd", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 347:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(360)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(334),
  /* template */
  __webpack_require__(355),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/post/PostText.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] PostText.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cd5d2abe", Component.options)
  } else {
    hotAPI.reload("data-v-cd5d2abe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 348:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(335),
  /* template */
  __webpack_require__(354),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/post/Posts.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Posts.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-53038462", Component.options)
  } else {
    hotAPI.reload("data-v-53038462", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 349:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div')
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-010a6c62", module.exports)
  }
}

/***/ }),

/***/ 350:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "comment-form"
  }, [_c('form', {
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.onAddComment($event)
      }
    }
  }, [_c('div', {
    staticClass: "panel panel-default share clearfix-xs"
  }, [_c('div', {
    staticClass: "panel-body"
  }, [_c('input', {
    attrs: {
      "name": "category_id",
      "value": "1",
      "type": "hidden"
    }
  }), _vm._v(" "), _c('input', {
    attrs: {
      "name": "user_id",
      "value": "1",
      "type": "hidden"
    }
  }), _vm._v(" "), _c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.content),
      expression: "content"
    }],
    staticClass: "form-control share-text",
    attrs: {
      "name": "content",
      "rows": "3",
      "placeholder": "Add comment..."
    },
    domProps: {
      "value": (_vm.content)
    },
    on: {
      "keyup": [_vm.onTextKeyPress, function($event) {
        if (!('button' in $event) && _vm._k($event.keyCode, "enter", 13)) { return null; }
        _vm.onAddComment($event)
      }],
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.content = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "panel-footer share-buttons"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._m(2), _vm._v(" "), _c('a', {
    attrs: {
      "title": "Close comment box"
    },
    on: {
      "click": _vm.addCommentClick
    }
  }, [_c('i', {
    staticClass: "fa fa-close"
  })]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary btn-xs pull-right",
    attrs: {
      "type": "submit",
      "disabled": _vm.textLength < 1 ? true : false
    }
  }, [(_vm.addLoading) ? _c('span', [_c('i', {
    staticClass: "fa fa-spinner fa-spin"
  })]) : _vm._e(), _vm._v("  \n                        Save Comment\n                ")])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-map-marker"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-photo"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-video-camera"
  })])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-120011dd", module.exports)
  }
}

/***/ }),

/***/ 351:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('app-post-text', {
    attrs: {
      "post": _vm.post,
      "postLikes": _vm.postLikes,
      "comments": _vm.postcomments
    },
    on: {
      "clickAddComment": function($event) {
        _vm.addCommentBool = !_vm.addCommentBool
      }
    }
  }), _vm._v(" "), _c('ul', {
    staticClass: "comments"
  }, [_c('transition', {
    attrs: {
      "name": "fade"
    }
  }, [(_vm.addCommentBool) ? _c('div', [_c('app-post-comment-form', {
    attrs: {
      "post": _vm.post
    },
    on: {
      "clickCommentAddComment": function($event) {
        _vm.addCommentBool = !_vm.addCommentBool
      },
      "addCommentChild": _vm.addCommentChild
    }
  })], 1) : _vm._e()]), _vm._v(" "), _c('app-post-comments', {
    attrs: {
      "comments": _vm.postcomments,
      "post": _vm.post
    }
  })], 1)], 1)])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-17511dd4", module.exports)
  }
}

/***/ }),

/***/ 352:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('form', {
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.onSubmitted($event)
      }
    }
  }, [_c('div', {
    staticClass: "panel panel-default share clearfix-xs"
  }, [_c('div', {
    staticClass: "panel-heading panel-heading-gray title"
  }, [_vm._v("\n                        Create a New Post\n                    ")]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('input', {
    attrs: {
      "name": "category_id",
      "value": "1",
      "type": "hidden"
    }
  }), _vm._v(" "), _c('input', {
    attrs: {
      "name": "user_id",
      "value": "1",
      "type": "hidden"
    }
  }), _vm._v(" "), _c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.content),
      expression: "content"
    }],
    staticClass: "form-control share-text",
    attrs: {
      "name": "content",
      "rows": "3",
      "placeholder": "Type text here..."
    },
    domProps: {
      "value": (_vm.content)
    },
    on: {
      "keyup": _vm.onTextKeyPress,
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.content = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "panel-footer share-buttons"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._m(2), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary btn-xs pull-right",
    attrs: {
      "type": "submit",
      "disabled": _vm.textLength < 1 ? true : false
    }
  }, [(_vm.addLoading) ? _c('span', [_c('i', {
    staticClass: "fa fa-spinner fa-spin"
  })]) : _vm._e(), _vm._v("  \n                                Add Post\n                        ")])])])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-map-marker"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-photo"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-video-camera"
  })])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-35f685dd", module.exports)
  }
}

/***/ }),

/***/ 353:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('li', {
    staticClass: "media single-comment",
    on: {
      "mouseover": _vm.onCommentHover,
      "mouseout": _vm.onCommentHoverOut
    }
  }, [_c('div', {
    staticClass: "media-left"
  }, [(_vm.comment.creator) ? _c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": _vm.comment.creator.img_thumb,
      "height": "50"
    }
  })]) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [(_vm.isAuthUser(_vm.comment.user_id)) ? _c('span', [(_vm.showCommentActions) ? _c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    directives: [{
      name: "on-clickaway",
      rawName: "v-on-clickaway",
      value: (_vm.away),
      expression: "away"
    }],
    staticClass: "toggle-button",
    attrs: {
      "data-toggle": "dropdown"
    },
    on: {
      "click": function($event) {
        _vm.comments_menu_drop = !_vm.comments_menu_drop
      }
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    on: {
      "click": _vm.onCommentEditClick
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    on: {
      "click": _vm.onCommentDeleteClick
    }
  }, [_vm._v("Delete")])])])]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": _vm.thisCommentUserLink
    }
  }, [_vm._v("\n                " + _vm._s(_vm.comment.user.first_name) + "\n            ")]), _vm._v(" "), _c('br'), _vm._v(" "), _c('span', [_vm._v(_vm._s(_vm.editCommentValue))]), _vm._v(" "), _c('br'), _vm._v(" "), (_vm.editing) ? _c('div', [_c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.editCommentValue),
      expression: "editCommentValue"
    }],
    staticClass: "form-control",
    attrs: {
      "placeholder": "Enter comment"
    },
    domProps: {
      "value": (_vm.editCommentValue)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.editCommentValue = $event.target.value
      }
    }
  }), _vm._v(" "), _c('a', {
    on: {
      "click": _vm.onUpdate
    }
  }, [_vm._v("Save")]), _vm._v("  \n                "), (_vm.saveLoading) ? _c('span', [_c('i', {
    staticClass: "fa fa-spinner fa-spin"
  })]) : _vm._e(), _vm._v("  \n                "), _c('a', {
    on: {
      "click": _vm.onCancel
    }
  }, [_vm._v("Cancel")])]) : _vm._e(), _vm._v(" "), (_vm.more_one_wk) ? _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("on " + _vm._s(_vm._f("createdDateWeeks")(_vm.comment.created_at)))]) : _vm._e(), _vm._v(" "), (_vm.less_one_wk) ? _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("on " + _vm._s(_vm._f("createdDateWeek")(_vm.comment.created_at)))]) : _vm._e(), _vm._v(" "), (_vm.less_one_day) ? _c('div', {
    staticClass: "comment-date"
  }, [(_vm.todayDate) ? _c('span', [_vm._v(" \n                    Today at " + _vm._s(_vm._f("createdDate")(_vm.comment.created_at)) + "\n                ")]) : _vm._e(), _vm._v(" "), (!_vm.todayDate) ? _c('span', [_vm._v(" \n                    at " + _vm._s(_vm._f("createdDate2")(_vm.comment.created_at)) + "\n                ")]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.less_four_hr) ? _c('div', {
    staticClass: "comment-date"
  }, [_c('timeago', {
    attrs: {
      "since": _vm.comment.created_at,
      "auto-update": 60
    }
  })], 1) : _vm._e()])]), _vm._v(" "), _c('div', {
    staticClass: "modal fade",
    attrs: {
      "id": "deleteModal"
    }
  }, [_c('div', {
    staticClass: "modal-dialog"
  }, [_c('div', {
    staticClass: "modal-content"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "modal-footer"
  }, [_c('button', {
    staticClass: "btn btn-danger",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.onDeleteComment
    }
  }, [(_vm.deleteLoading) ? _c('span', [_c('i', {
    staticClass: "fa fa-spinner fa-spin"
  })]) : _vm._e(), _vm._v("\n                        Delete\n                    ")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-default",
    attrs: {
      "type": "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Cancel")])])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "modal-header"
  }, [_c('button', {
    staticClass: "close",
    attrs: {
      "type": "button",
      "data-dismiss": "modal",
      "aria-hidden": "true"
    }
  }, [_vm._v("\n                        ×\n                    ")]), _vm._v(" "), _c('h4', {
    staticClass: "modal-title"
  }, [_vm._v("Delete Comment")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "modal-body"
  }, [_c('p', [_vm._v("Are you sure you want to delete this comment?")])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-52d9dc58", module.exports)
  }
}

/***/ }),

/***/ 354:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div')
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-53038462", module.exports)
  }
}

/***/ }),

/***/ 355:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "panel-heading"
  }, [_c('div', {
    staticClass: "media"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "data-toggle": "dropdown"
    },
    on: {
      "click": function($event) {
        _vm.post_menu_drop = !_vm.post_menu_drop
      }
    }
  }, [_c('i', {
    staticClass: "fa fa-chevron-down"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    on: {
      "click": _vm.onPostEditClick
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    on: {
      "click": _vm.onPostDeleteClick
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('a', {
    attrs: {
      "href": _vm.thisPostUserLink
    }
  }, [_vm._v("\n                    " + _vm._s(_vm.post.user.first_name) + "\n                ")]), _vm._v(" "), (_vm.more_one_wk) ? _c('span', [_vm._v("on " + _vm._s(_vm._f("createdDateWeeks")(_vm.post.created_at)))]) : _vm._e(), _vm._v(" "), (_vm.less_one_wk) ? _c('span', [_vm._v("on " + _vm._s(_vm._f("createdDateWeek")(_vm.post.created_at)))]) : _vm._e(), _vm._v(" "), (_vm.less_one_day) ? _c('span', [(!_vm.todayDate) ? _c('span', [_vm._v(" at " + _vm._s(_vm._f("createdDate2")(_vm.post.created_at)))]) : _vm._e(), _vm._v(" "), (_vm.todayDate) ? _c('span', [_vm._v(" Today at " + _vm._s(_vm._f("createdDate")(_vm.post.created_at)))]) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.less_four_hr) ? _c('span', [_c('timeago', {
    attrs: {
      "since": _vm.post.created_at,
      "auto-update": 60
    }
  })], 1) : _vm._e()])])]), _vm._v(" "), (_vm.post.content) ? _c('div', {
    staticClass: "panel-body"
  }, [_c('p', [_vm._v(_vm._s(_vm.post.content))]), _vm._v(" "), (_vm.post.total_photos) ? _c('div', {
    staticClass: "timeline-added-images"
  }, _vm._l((_vm.post.photos), function(photo) {
    return _c('img', {
      attrs: {
        "src": photo.user_image,
        "width": "80",
        "alt": photo.caption
      }
    })
  })) : _vm._e()]) : _vm._e(), _vm._v(" "), (_vm.post.color_class) ? _c('div', {
    staticClass: "panel-body no-padding"
  }, [_c('div', {
    class: _vm.post.color_class
  }, [_c('div', {
    staticClass: "colored-status center-vertical"
  }, [_c('p', {
    staticClass: "text-center"
  }, [_vm._v("\n                    " + _vm._s(_vm.post.content) + "\n                ")])])])]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "view-all-comments"
  }, [(_vm.comments.length) ? _c('span', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-comments-o"
  }), _vm._v(" "), _c('span', [_vm._v("\n\n                    " + _vm._s(_vm.comments.length) + " \n\n                    "), (_vm.comments.length > 1) ? _c('span', [_vm._v("\n                        comments\n                    ")]) : _vm._e(), _vm._v(" "), (_vm.comments.length === 1) ? _c('span', [_vm._v("\n                        comment\n                    ")]) : _vm._e()])]), _vm._v("\n\n              \n\n        ")]) : _vm._e(), _vm._v(" "), _c('span', [(_vm.postLikes.length) ? _c('span', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-heart icon"
  }), _vm._v(" "), (_vm.isLiked) ? _c('span', [_vm._v("\n                        You \n                        "), (_vm.postLikes.length === 2) ? _c('span', [_vm._v(" \n                            and " + _vm._s(_vm.postLikes.length - 1) + " person \n                        ")]) : _vm._e(), _vm._v(" "), (_vm.postLikes.length > 2) ? _c('span', [_vm._v(" \n                            and " + _vm._s(_vm.postLikes.length - 1) + " people \n                        ")]) : _vm._e(), _vm._v("\n                        like this\n                    ")]) : _vm._e(), _vm._v(" "), (!_vm.isLiked) ? _c('span', [(_vm.postLikes.length === 1) ? _c('span', [_vm._v(" \n                            1 person likes this\n                        ")]) : _vm._e(), _vm._v(" "), (_vm.postLikes.length > 1) ? _c('span', [_vm._v(" \n                            " + _vm._s(_vm.postLikes.length) + " people like this\n                        ")]) : _vm._e()]) : _vm._e()]), _vm._v("\n\n                  \n            ")]) : _vm._e()]), _vm._v(" "), (!_vm.comments.length) ? _c('span', [_c('a', {
    on: {
      "click": _vm.addCommentClick
    }
  }, [_c('i', {
    staticClass: "fa fa-comments-o"
  }), _vm._v("  Be the first to comment   \n            ")])]) : _vm._e(), _vm._v(" "), (_vm.comments.length) ? _c('span', [_c('a', {
    on: {
      "click": _vm.addCommentClick
    }
  }, [_c('i', {
    staticClass: "fa fa-comment icon"
  }), _vm._v(" Add Comment\n            ")]), _vm._v("\n              \n        ")]) : _vm._e(), _vm._v(" "), (!_vm.addLoading) ? _c('span', [(_vm.isLiked) ? _c('a', {
    attrs: {
      "title": "Unlike Post"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.postUnlikeClick(_vm.post)
      }
    }
  }, [_vm._m(2)]) : _c('a', {
    attrs: {
      "title": "Like Post"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.postLikeClick(_vm.post)
      }
    }
  }, [_c('i', {
    staticClass: "fa fa-heart-o icon"
  }, [_c('span', [_vm._v(" Like")])])])]) : _vm._e(), _vm._v("\n\n         \n\n        "), (_vm.addLoading) ? _c('span', [_c('i', {
    staticClass: "fa fa-spinner fa-spin"
  })]) : _vm._e()])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(341),
      "height": "50"
    }
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "pull-right text-muted",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "icon-reply-all-fill fa fa-2x "
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('i', {
    staticClass: "fa fa-heart icon filled"
  }, [_c('span', [_vm._v(" Unlike")])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-cd5d2abe", module.exports)
  }
}

/***/ }),

/***/ 356:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(336);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("52271b86", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-120011dd\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./CommentAdd.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-120011dd\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./CommentAdd.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 357:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(337);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("fd2443e8", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-17511dd4\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Post.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-17511dd4\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Post.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 358:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(338);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("5cb931c6", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35f685dd\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PostAdd.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-35f685dd\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PostAdd.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 359:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(339);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("70a9c94c", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-52d9dc58\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Comment.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-52d9dc58\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Comment.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 360:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(340);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("2cfa76c8", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-cd5d2abe\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PostText.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-cd5d2abe\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PostText.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 364:
/***/ (function(module, exports) {

module.exports = "/images/food1.jpg?2c356132f77ad39cc9e12074cc97cdea";

/***/ }),

/***/ 365:
/***/ (function(module, exports) {

module.exports = "/images/place1-full.jpg?27eaea6205dd2582ea2a0fadc1ef8d76";

/***/ }),

/***/ 396:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__profile_MyMatches_vue__ = __webpack_require__(430);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__profile_MyMatches_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__profile_MyMatches_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__includes_SidebarLeft_vue__ = __webpack_require__(321);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__includes_SidebarLeft_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__includes_SidebarLeft_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_SidebarRight_vue__ = __webpack_require__(322);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_SidebarRight_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__includes_SidebarRight_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//







/* harmony default export */ __webpack_exports__["default"] = {

    components: {
        myMatches: __WEBPACK_IMPORTED_MODULE_1__profile_MyMatches_vue___default.a,
        appSidebarLeft: __WEBPACK_IMPORTED_MODULE_2__includes_SidebarLeft_vue___default.a,
        appSidebarRight: __WEBPACK_IMPORTED_MODULE_3__includes_SidebarRight_vue___default.a
    }

};

/***/ }),

/***/ 401:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__post_PostAdd_vue__ = __webpack_require__(346);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__post_PostAdd_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__post_PostAdd_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__post_Posts_vue__ = __webpack_require__(348);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__post_Posts_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__post_Posts_vue__);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = {
    data: function data() {
        return {
            posts: []
        };
    },
    created: function created() {},


    computed: _extends({
        loggedIn: function loggedIn() {
            return this.authUserStore.authUser !== null && this.authUserStore.authUser.access_token !== null;
        }
    }, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        authUserStore: function authUserStore(state) {
            return state.authUser;
        },
        currentUserStore: function currentUserStore(state) {
            return state.currentUser;
        }
    })),

    components: {
        appPosts: __WEBPACK_IMPORTED_MODULE_2__post_Posts_vue___default.a,
        appNewPostForm: __WEBPACK_IMPORTED_MODULE_1__post_PostAdd_vue___default.a,
        coverProfile: CoverProfile
    }

};

/***/ }),

/***/ 406:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 410:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 430:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(459)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(401),
  /* template */
  __webpack_require__(435),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/profile/MyMatches.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MyMatches.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0c3bb034", Component.options)
  } else {
    hotAPI.reload("data-v-0c3bb034", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 435:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "timeline row"
  }, [_c('div', {
    staticClass: "col-xs-12 col-md-6 col-lg-8"
  }, [_c('h1', [_vm._v("My Matches - " + _vm._s(_vm.authUserStore.authUser.first_name))]), _vm._v(" "), _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_vm._v("\n                            Kitu Gani\n                        ")]), _vm._v(" "), _c('div', {
    staticClass: "embed-responsive embed-responsive-4by3"
  }, [_c('iframe', {
    staticClass: "embed-responsive-item",
    attrs: {
      "src": "https://www.youtube.com/embed/MF_ilPWEkws",
      "frameborder": "0"
    }
  })], 1), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._m(2)])])]), _vm._v(" "), _vm._m(3), _vm._v(" "), _vm._m(4), _vm._v(" "), _vm._m(5)]), _vm._v(" "), _vm._m(6)])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "panel-heading"
  }, [_c('div', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(318)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('a', {
    staticClass: "pull-right text-muted",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "icon-reply-all-fill fa fa-2x "
  })]), _vm._v(" "), _c('a', {
    attrs: {
      "href": ""
    }
  }, [_vm._v("Jonathan")]), _vm._v(" "), _c('span', [_vm._v("on 15th January, 2014")])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "view-all-comments"
  }, [_c('i', {
    staticClass: "fa fa-comments-o"
  }), _vm._v(" Be the first to comment")])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('ul', {
    staticClass: "comments"
  }, [_c('li', {
    staticClass: "comment-form"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "text"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "input-group-btn"
  }, [_c('a', {
    staticClass: "btn btn-default",
    attrs: {
      "href": ""
    }
  }, [_c('i', {
    staticClass: "fa fa-photo"
  })])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-heading"
  }, [_c('div', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(319)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('a', {
    staticClass: "pull-right text-muted",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "icon-reply-all-fill fa fa-2x "
  })]), _vm._v(" "), _c('a', {
    attrs: {
      "href": ""
    }
  }, [_vm._v("Michelle")]), _vm._v(" "), _c('span', [_vm._v("on 15th January, 2014")])])])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body text-muted"
  }, [_c('i', {
    staticClass: "fa fa-map-marker"
  }), _vm._v(" Was in "), _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Brooklyn, New York")])]), _vm._v(" "), _c('div', {
    staticClass: "relative height-300"
  }, [_c('div', {
    staticClass: "maps-google-fs",
    attrs: {
      "data-toggle": "google-maps",
      "data-center": "40.776928,-73.910330",
      "data-zoom": "12",
      "data-style": "paper"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "view-all-comments"
  }, [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-comments-o"
  }), _vm._v(" View all\n                            ")]), _vm._v(" "), _c('span', [_vm._v("10 comments")])]), _vm._v(" "), _c('ul', {
    staticClass: "comments"
  }, [_c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(318)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Bill D.")]), _vm._v(" "), _c('span', [_vm._v("Hi Mary, Nice Party")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("21st September")])])]), _vm._v(" "), _c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(328)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Mary")]), _vm._v(" "), _c('span', [_vm._v("Thanks Bill")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("2 days")])])]), _vm._v(" "), _c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(318)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Bill D.")]), _vm._v(" "), _c('span', [_vm._v("What time did it finish?")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("14 min")])])]), _vm._v(" "), _c('li', {
    staticClass: "comment-form"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('span', {
    staticClass: "input-group-btn"
  }, [_c('a', {
    staticClass: "btn btn-default",
    attrs: {
      "href": ""
    }
  }, [_c('i', {
    staticClass: "fa fa-photo"
  })])]), _vm._v(" "), _c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "text"
    }
  })])])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "profile-block"
  }, [_c('div', {
    staticClass: "cover overlay cover-image-full"
  }, [_c('img', {
    attrs: {
      "src": __webpack_require__(365),
      "alt": "cover"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "overlay overlay-full overlay-bg-black"
  }, [_c('div', {
    staticClass: "v-top v-spacing-2"
  }, [_c('a', {
    staticClass: "icon pull-right",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-comment"
  })]), _vm._v(" "), _c('div', {
    staticClass: "text-headline text-overlay"
  }, [_vm._v("Adrian Demian")]), _vm._v(" "), _c('p', {
    staticClass: "text-overlay"
  }, [_vm._v("User Interface Designer")])]), _vm._v(" "), _c('div', {
    staticClass: "v-bottom"
  }, [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    staticClass: "img-circle avatar",
    attrs: {
      "src": __webpack_require__(318),
      "alt": "people"
    }
  })])])])]), _vm._v(" "), _c('div', {
    staticClass: "profile-icons"
  }, [_c('span', [_c('i', {
    staticClass: "fa fa-users"
  }), _vm._v(" 372")]), _vm._v(" "), _c('span', [_c('i', {
    staticClass: "fa fa-photo"
  }), _vm._v(" 43")]), _vm._v(" "), _c('span', [_c('i', {
    staticClass: "fa fa-video-camera"
  }), _vm._v(" 3 ")])])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-heading"
  }, [_c('div', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(328)
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('a', {
    staticClass: "pull-right text-muted",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "icon-reply-all-fill fa fa-2x "
  })]), _vm._v(" "), _c('a', {
    attrs: {
      "href": ""
    }
  }, [_vm._v("Michelle")]), _vm._v(" "), _c('span', [_vm._v("on 15th January, 2014")])])])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('div', {
    staticClass: "boxed"
  }, [_c('a', {
    staticClass: "h4 margin-none",
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Vegetarian Pizza")]), _vm._v(" "), _c('div', [_c('span', {
    staticClass: "fa fa-star text-primary"
  }), _vm._v(" "), _c('span', {
    staticClass: "fa fa-star text-primary"
  }), _vm._v(" "), _c('span', {
    staticClass: "fa fa-star text-primary"
  }), _vm._v(" "), _c('span', {
    staticClass: "fa fa-star text-primary"
  }), _vm._v(" "), _c('span', {
    staticClass: "fa fa-star-o"
  })]), _vm._v(" "), _c('div', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(364),
      "alt": "",
      "width": "80"
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('p', [_vm._v("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor impedit ipsum laborum maiores tempore veritatis....")])])]), _vm._v(" "), _c('ul', {
    staticClass: "icon-list"
  }, [_c('li', [_c('i', {
    staticClass: "fa fa-star fa-fw"
  }), _vm._v(" 4.8")]), _vm._v(" "), _c('li', [_c('i', {
    staticClass: "fa fa-clock-o fa-fw"
  }), _vm._v(" 20 min")]), _vm._v(" "), _c('li', [_c('i', {
    staticClass: "fa fa-graduation-cap fa-fw"
  }), _vm._v(" Beginner")])])])]), _vm._v(" "), _c('div', {
    staticClass: "view-all-comments"
  }, [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-comments-o"
  }), _vm._v(" View all\n                            ")]), _vm._v(" "), _c('span', [_vm._v("10 comments")])]), _vm._v(" "), _c('ul', {
    staticClass: "comments"
  }, [_c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(326),
      "width": "50"
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Bill D.")]), _vm._v(" "), _c('span', [_vm._v("Hi Mary, Nice Party")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("21st September")])])]), _vm._v(" "), _c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(326),
      "width": "50"
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Mary")]), _vm._v(" "), _c('span', [_vm._v("Thanks Bill")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("2 days")])])]), _vm._v(" "), _c('li', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [_c('a', {
    attrs: {
      "href": ""
    }
  }, [_c('img', {
    staticClass: "media-object",
    attrs: {
      "src": __webpack_require__(326),
      "width": "50"
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('div', {
    staticClass: "pull-right dropdown",
    attrs: {
      "data-show-hover": "li"
    }
  }, [_c('a', {
    staticClass: "toggle-button",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "fa fa-pencil"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "role": "menu"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Edit")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Delete")])])])]), _vm._v(" "), _c('a', {
    staticClass: "comment-author pull-left",
    attrs: {
      "href": ""
    }
  }, [_vm._v("Bill D.")]), _vm._v(" "), _c('span', [_vm._v("What time did it finish?")]), _vm._v(" "), _c('div', {
    staticClass: "comment-date"
  }, [_vm._v("14 min")])])]), _vm._v(" "), _c('li', {
    staticClass: "comment-form"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('span', {
    staticClass: "input-group-btn"
  }, [_c('a', {
    staticClass: "btn btn-default",
    attrs: {
      "href": ""
    }
  }, [_c('i', {
    staticClass: "fa fa-photo"
  })])]), _vm._v(" "), _c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "text"
    }
  })])])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-xs-12 col-md-6 col-lg-4 hidden-xs hidden-sm"
  }, [_c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default relative"
  }, [_c('img', {
    staticClass: "img-responsive",
    attrs: {
      "src": __webpack_require__(327),
      "alt": "place"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "panel-body panel-boxed text-center"
  }, [_c('div', {
    staticClass: "rating"
  }, [_c('span', {
    staticClass: "star"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(318),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(325),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "user-count-circle",
    attrs: {
      "href": "#"
    }
  }, [_vm._v("12+")])])])])]), _vm._v(" "), _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default relative"
  }, [_c('img', {
    staticClass: "img-responsive",
    attrs: {
      "src": __webpack_require__(327),
      "alt": "place"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "panel-body panel-boxed text-center"
  }, [_c('div', {
    staticClass: "rating"
  }, [_c('span', {
    staticClass: "star"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(318),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(325),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "user-count-circle",
    attrs: {
      "href": "#"
    }
  }, [_vm._v("12+")])])])])]), _vm._v(" "), _c('div', {
    staticClass: "item"
  }, [_c('div', {
    staticClass: "timeline-block"
  }, [_c('div', {
    staticClass: "panel panel-default relative"
  }, [_c('img', {
    staticClass: "img-responsive",
    attrs: {
      "src": __webpack_require__(327),
      "alt": "place"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "panel-body panel-boxed text-center"
  }, [_c('div', {
    staticClass: "rating"
  }, [_c('span', {
    staticClass: "star"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  }), _vm._v(" "), _c('span', {
    staticClass: "star filled"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(318),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(325),
      "alt": "people"
    }
  }), _vm._v(" "), _c('img', {
    staticClass: "img-circle",
    attrs: {
      "src": __webpack_require__(319),
      "alt": "people"
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "user-count-circle",
    attrs: {
      "href": "#"
    }
  }, [_vm._v("12+")])])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-0c3bb034", module.exports)
  }
}

/***/ }),

/***/ 442:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', [_c('app-sidebar-left'), _vm._v(" "), _c('app-sidebar-right'), _vm._v(" "), _c('div', {
    staticClass: "st-pusher",
    attrs: {
      "id": "content"
    }
  }, [_c('div', {
    staticClass: "st-content"
  }, [_c('div', {
    staticClass: "st-content-inner"
  }, [_c('div', {
    staticClass: "container-fluid"
  }, [_c('my-matches')], 1)])])])], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4cb4a4b0", module.exports)
  }
}

/***/ }),

/***/ 459:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(406);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("75ebe9d5", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0c3bb034\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyMatches.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0c3bb034\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyMatches.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 463:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(410);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("ebef1256", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4cb4a4b0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyMatchesPage.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4cb4a4b0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MyMatchesPage.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});