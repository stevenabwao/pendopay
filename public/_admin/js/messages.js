webpackJsonp([4],{

/***/ 154:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(460)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(392),
  /* template */
  __webpack_require__(438),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/pages/ChatPage.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatPage.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3398d846", Component.options)
  } else {
    hotAPI.reload("data-v-3398d846", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


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

/***/ 380:
/***/ (function(module, exports) {

module.exports = "/images/nikk.jpg?a90fca9e865988552c7ca5409b3b2be7";

/***/ }),

/***/ 383:
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


//import Pusher from 'pusher-js'

/* harmony default export */ __webpack_exports__["default"] = {
	data: function data() {
		return {
			message: '',
			addLoading: false,
			pusher: null,
			channel: null
		};
	},
	created: function created() {
		/*this.pusher = new Pusher('3b731e398e444a456164', {
  	cluster: 'ap2',
  encrypted: true
  })
  let that = this
  this.channel = this.pusher.subscribe('chat_channel')
  this.channel.bind('chat-message', function(data) {
  	that.$emit('incoming_chat', data)
  })
  this.$on('incoming_chat', function(chatMessage) {
  	this.incoming_chat(chatMessage)
  })*/
	},


	computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
		chatStore: function chatStore(state) {
			return state.chats;
		},
		authUserStore: function authUserStore(state) {
			return state.authUser;
		}
	})),

	methods: {
		handleAddChat: function handleAddChat() {
			var _this = this;

			if (this.message !== null) {

				var postData = {
					'message': this.message,
					'receiver_id': this.chatStore.currentChatUser.id

					//post form data
				};this.$store.dispatch('addNewChatToConversation', postData).then(function (response) {
					console.log(response);
					_this.message = null;
					//scroll to view
					var element = document.getElementById('chat-widget-wrapper');
					element.scrollIntoView(false);
				}).catch(function (error) {
					return console.log(error);
				});
			}
		},
		incomngChat: function incomngChat(chatMessage) {
			if (this.chatStore.currentChatUser.id === chatMessage.message.sender_id) {
				if (this.chatMessage.message.receiver.id === this.authUserStore.authUser.id) {
					//send msg to current user
					this.$store.dispatch('newIncomingChat', chatMessage.message).then(function (res) {
						var element = document.getElementById('chat-widget-wrapper');
						element.scrollIntoView(false);
					});
					console.log('chatMessage', chatMessage);
				} else {
					console.log('message for other user');
				}
			}
		}
	}
};

/***/ }),

/***/ 384:
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




/* harmony default export */ __webpack_exports__["default"] = {
	computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
		chatStore: function chatStore(state) {
			return state.chats;
		}
	}))
};

/***/ }),

/***/ 385:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ChatHeader_vue__ = __webpack_require__(422);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ChatHeader_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__ChatHeader_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ChatWidget_vue__ = __webpack_require__(425);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ChatWidget_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__ChatWidget_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ChatUserList_vue__ = __webpack_require__(424);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ChatUserList_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__ChatUserList_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ChatAddWidget_vue__ = __webpack_require__(421);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ChatAddWidget_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__ChatAddWidget_vue__);
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








/* harmony default export */ __webpack_exports__["default"] = {

	components: {
		'chat-header': __WEBPACK_IMPORTED_MODULE_1__ChatHeader_vue___default.a,
		'chat-widget': __WEBPACK_IMPORTED_MODULE_2__ChatWidget_vue___default.a,
		'chat-user-list': __WEBPACK_IMPORTED_MODULE_3__ChatUserList_vue___default.a,
		'chat-add-widget': __WEBPACK_IMPORTED_MODULE_4__ChatAddWidget_vue___default.a
	},

	computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
		chatStore: function chatStore(state) {
			return state.chats;
		}
	})),

	created: function created() {
		this.$store.dispatch('setUserList');
	}
};

/***/ }),

/***/ 386:
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



/* harmony default export */ __webpack_exports__["default"] = {

	computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
		chatStore: function chatStore(state) {
			return state.chats;
		},
		authUserStore: function authUserStore(state) {
			return state.authUser;
		}
	})),

	methods: {
		userActiveStyle: function userActiveStyle(user) {
			if (this.chatStore.currentChatUser === null) {
				return false;
			}
			if (this.chatStore.currentChatUser === user.id) {
				return true;
			}
			return false;
		},
		changeChatUser: function changeChatUser(user) {
			this.$store.dispatch('setCurrentChatUser', user);
		}
	}

};

/***/ }),

/***/ 387:
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




/* harmony default export */ __webpack_exports__["default"] = {
	computed: _extends({}, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
		chatStore: function chatStore(state) {
			return state.chats;
		},
		authUserStore: function authUserStore(state) {
			return state.authUser;
		}
	})),
	methods: {
		//check if this is the logged in user or not
		isAuthUser: function isAuthUser(user_id) {
			return user_id === this.authUserStore.authUser.id;
		}
	}
};

/***/ }),

/***/ 392:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__chat_ChatPage_vue__ = __webpack_require__(423);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__chat_ChatPage_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__chat_ChatPage_vue__);
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
        chatPage: __WEBPACK_IMPORTED_MODULE_1__chat_ChatPage_vue___default.a,
        appSidebarLeft: __WEBPACK_IMPORTED_MODULE_2__includes_SidebarLeft_vue___default.a,
        appSidebarRight: __WEBPACK_IMPORTED_MODULE_3__includes_SidebarRight_vue___default.a
    }

};

/***/ }),

/***/ 407:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 409:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n.grey_bg[data-v-42f96838]{ background: #dedede;\n}\n.white_bg[data-v-42f96838]{ background: #fbf9fa;\n}\n.chat_time[data-v-42f96838]{ padding: 10px;\n}\n", ""]);

// exports


/***/ }),

/***/ 412:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n#chat-page-wrapper{\n\t  position: absolute;\n\t  top: 10px;\n\t  bottom: 10px;\n\t  width: 97%;\n\t  height: 100%; \n\t  overflow: hidden;\n}\n/*.row [class*=\"col-\"] {\n     padding: 0; \n}*/\n#custom-search-input {\n    background: #e8e6e7 none repeat scroll 0 0;\n    margin: 0;\n    padding: 10px;\n}\n#custom-search-input .search-query {\n    background: #fff none repeat scroll 0 0 !important;\n    border-radius: 4px;\n    height: 33px;\n    margin-bottom: 0;\n    padding-left: 7px;\n    padding-right: 7px;\n}\n#custom-search-input button {\n    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;\n    border: 0 none;\n    border-radius: 3px;\n    color: #666666;\n    left: auto;\n    margin-bottom: 0;\n    margin-top: 7px;\n    padding: 2px 5px;\n    position: absolute;\n    right: 10px;\n    z-index: 9999;\n}\n.search-query:focus + button {\n    z-index: 3;\n}\n.all_conversation button {\n    background: #f5f3f3 none repeat scroll 0 0;\n    border: 1px solid #dddddd;\n    height: 38px;\n    text-align: left;\n    width: 100%;\n}\n.all_conversation i {\n    background: #e9e7e8 none repeat scroll 0 0;\n    border-radius: 100px;\n    color: #636363;\n    font-size: 17px;\n    height: 30px;\n    line-height: 30px;\n    text-align: center;\n    width: 30px;\n}\n.all_conversation .caret {\n    bottom: 0;\n    margin: auto;\n    position: absolute;\n    right: 15px;\n    top: 0;\n}\n.all_conversation .dropdown-menu {\n    background: #f5f3f3 none repeat scroll 0 0;\n    border-radius: 0;\n    margin-top: 0;\n    padding: 0;\n    width: 100%;\n}\n.all_conversation ul li {\n    border-bottom: 1px solid #dddddd;\n    line-height: normal;\n    width: 100%;\n}\n.all_conversation ul li a:hover {\n    background: #dddddd none repeat scroll 0 0;\n    color: #333;\n}\n.all_conversation ul li a {\n    color: #333;\n    line-height: 30px;\n    padding: 3px 20px;\n}\n.member_list .chat-body {\n    margin-left: 47px;\n    margin-top: 0;\n}\n.top_nav {\n    overflow: visible;\n}\n.member_list .contact_sec {\n    margin-top: 3px;\n}\n.member_list li {\n    padding: 6px;\n}\n.member_list ul {\n    border: 1px solid #dddddd;\n}\n.chat-img img {\n    height: 34px;\n    width: 34px;\n}\n.member_list li {\n    border-bottom: 1px solid #dddddd;\n    padding: 6px;\n}\n.member_list li:last-child {\n    border-bottom: none;\n}\n.member_list {\n    height: 380px;\n    overflow-x: hidden;\n    overflow-y: auto;\n}\n.sub_menu_ {\n    background: #e8e6e7 none repeat scroll 0 0;\n    left: 100%;\n    max-width: 233px;\n    position: absolute;\n    width: 100%;\n}\n.sub_menu_ {\n    background: #f5f3f3 none repeat scroll 0 0;\n    border: 1px solid rgba(0, 0, 0, 0.15);\n    display: none;\n    left: 100%;\n    margin-left: 0;\n    max-width: 233px;\n    position: absolute;\n    top: 0;\n    width: 100%;\n}\n.all_conversation ul li:hover .sub_menu_ {\n    display: block;\n}\n.new_message_head button {\n    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;\n    border: medium none;\n}\n.new_message_head {\n    background: #f5f3f3 none repeat scroll 0 0;\n    float: left;\n    font-size: 13px;\n    font-weight: 600;\n    padding: 18px 10px;\n    width: 100%;\n}\n.message_section {\n    border: 1px solid #dddddd;\n}\n.chat_area {\n    float: left;\n    height: 300px;\n    overflow-x: hidden;\n    overflow-y: auto;\n    width: 100%;\n}\n.chat_area li {\n    padding: 14px 14px 0;\n}\n.chat_area li .chat-img1 img {\n    height: 40px;\n    width: 40px;\n}\n.chat_area .chat-body1 {\n    margin-left: 50px;\n}\n.chat-body1 p {\n    background: #fbf9fa none repeat scroll 0 0;\n    padding: 10px;\n}\n.chat-body1 p.grey_bg {\n    background: #dedede none repeat scroll 0 0;\n}\n.chat_area .admin_chat .chat-body1 {\n    margin-left: 0;\n    margin-right: 50px;\n}\n.chat_area li:last-child {\n    padding-bottom: 10px;\n}\n.message_write {\n    background: #f5f3f3 none repeat scroll 0 0;\n    float: left;\n    padding: 15px;\n    width: 100%;\n}\n.message_write textarea.form-control {\n    height: 70px;\n    padding: 10px;\n}\n.chat_bottom {\n    float: left;\n    margin-top: 13px;\n    width: 100%;\n}\n.upload_btn {\n    color: #777777;\n}\n.sub_menu_ > li a,\n.sub_menu_ > li {\n    float: left;\n    width: 100%;\n}\n.member_list li:hover {\n    background: #428bca none repeat scroll 0 0;\n    color: #fff;\n    cursor: pointer;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 414:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 416:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 420:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n#chat-user-list-wrapper li.active[data-v-ecb32106]{ background: #277E8E;\n}\n", ""]);

// exports


/***/ }),

/***/ 421:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(469)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(383),
  /* template */
  __webpack_require__(450),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/chat/ChatAddWidget.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatAddWidget.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-708f9f81", Component.options)
  } else {
    hotAPI.reload("data-v-708f9f81", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 422:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(467)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(384),
  /* template */
  __webpack_require__(447),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/chat/ChatHeader.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatHeader.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69b0b7fe", Component.options)
  } else {
    hotAPI.reload("data-v-69b0b7fe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 423:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(465)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(385),
  /* template */
  __webpack_require__(444),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/chat/ChatPage.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatPage.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-603a0bfa", Component.options)
  } else {
    hotAPI.reload("data-v-603a0bfa", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 424:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(473)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(386),
  /* template */
  __webpack_require__(456),
  /* styles */
  injectStyle,
  /* scopeId */
  "data-v-ecb32106",
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/chat/ChatUserList.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatUserList.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ecb32106", Component.options)
  } else {
    hotAPI.reload("data-v-ecb32106", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 425:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(462)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(387),
  /* template */
  __webpack_require__(440),
  /* styles */
  injectStyle,
  /* scopeId */
  "data-v-42f96838",
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/chat/ChatWidget.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ChatWidget.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-42f96838", Component.options)
  } else {
    hotAPI.reload("data-v-42f96838", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 438:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    staticClass: "full-width-left"
  }, [_c('app-sidebar-right'), _vm._v(" "), _c('div', {
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
  }, [_c('chat-page')], 1)])])])], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-3398d846", module.exports)
  }
}

/***/ }),

/***/ 440:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "chat-widget-wrapper"
    }
  }, [_c('div', {
    staticClass: "chat_area"
  }, [(_vm.chatStore.conversation.length) ? _c('ul', {
    staticClass: "list-unstyled"
  }, _vm._l((_vm.chatStore.conversation), function(chat) {
    return _c('li', {
      staticClass: "left clearfix",
      class: _vm.isAuthUser(chat.sender_id) ? 'admin_chat' : ''
    }, [_c('span', {
      staticClass: "chat-img1",
      class: _vm.isAuthUser(chat.sender_id) ? 'pull-right' : 'pull-left'
    }, [_c('img', {
      staticClass: "img-circle",
      attrs: {
        "src": __webpack_require__(380),
        "alt": chat.sender.first_name
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "chat-body1 clearfix",
      class: _vm.isAuthUser(chat.sender_id) ? 'grey_bg' : 'white_bg'
    }, [_c('p', {
      class: _vm.isAuthUser(chat.sender_id) ? 'grey_bg' : ''
    }, [_vm._v(_vm._s(chat.message))]), _vm._v(" "), _c('div', {
      staticClass: "chat_time",
      class: _vm.isAuthUser(chat.sender_id) ? 'pull-left' : 'pull-right'
    }, [_c('timeago', {
      attrs: {
        "since": chat.created_at,
        "auto-update": 60
      }
    })], 1)])])
  })) : _c('div', {
    staticClass: "alert alert-info"
  }, [_c('h4', {
    staticClass: "text-center"
  }, [_vm._v("No message to display")])])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-42f96838", module.exports)
  }
}

/***/ }),

/***/ 444:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "chat-page-wrapper"
    }
  }, [_c('div', {
    staticClass: "chat_container"
  }, [_c('div', {
    staticClass: "col-sm-4 chat_sidebar"
  }, [_c('div', {
    staticClass: "row"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "member_list"
  }, [_c('chat-user-list')], 1)])]), _vm._v(" "), _c('div', {
    staticClass: "col-sm-8 message_section"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('chat-header'), _vm._v(" "), _c('chat-widget'), _vm._v(" "), _c('chat-add-widget')], 1)])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "custom-search-input"
    }
  }, [_c('div', {
    staticClass: "input-group col-md-12"
  }, [_c('input', {
    staticClass: "  search-query form-control",
    attrs: {
      "type": "text",
      "placeholder": "Find User Conversation"
    }
  }), _vm._v(" "), _c('button', {
    staticClass: "btn btn-danger",
    attrs: {
      "type": "button"
    }
  }, [_c('span', {
    staticClass: " glyphicon glyphicon-search"
  })])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "dropdown all_conversation"
  }, [_c('button', {
    staticClass: "dropdown-toggle",
    attrs: {
      "type": "button",
      "id": "dropdownMenu2",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c('i', {
    staticClass: "fa fa-weixin",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" All Conversations\n\t                        "), _c('span', {
    staticClass: "caret pull-right"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu",
    attrs: {
      "aria-labelledby": "dropdownMenu2"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v(" All Conversation ")]), _vm._v(" "), _c('ul', {
    staticClass: "sub_menu_ list-unstyled"
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v(" All Conversation ")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Another action")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Something else here")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Separated link")])])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Another action")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Something else here")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Separated link")])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-603a0bfa", module.exports)
  }
}

/***/ }),

/***/ 447:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "chat-widget-wrapper"
  }, [_c('div', {
    staticClass: "new_message_head"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "col-sm-4 text-center"
  }, [(_vm.chatStore.currentChatUser !== null) ? _c('span', [_vm._v("\n    \t\t" + _vm._s(_vm._f("capitalize")(_vm.chatStore.currentChatUser.first_name)) + " \n    \t\t" + _vm._s(_vm._f("capitalize")(_vm.chatStore.currentChatUser.last_name)) + "\n    \t\t")]) : _vm._e()]), _vm._v(" "), _vm._m(1)])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-sm-4"
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('button', [_c('i', {
    staticClass: "fa fa-plus-square-o",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" Start New Message\n                ")])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-sm-4"
  }, [_c('div', {
    staticClass: "pull-right"
  }, [_c('div', {
    staticClass: "dropdown"
  }, [_c('button', {
    staticClass: "dropdown-toggle",
    attrs: {
      "type": "button",
      "id": "dropdownMenu1",
      "data-toggle": "dropdown",
      "aria-haspopup": "true",
      "aria-expanded": "false"
    }
  }, [_c('i', {
    staticClass: "fa fa-cogs",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" Chat Options\n                        "), _c('span', {
    staticClass: "caret"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu dropdown-menu-right",
    attrs: {
      "aria-labelledby": "dropdownMenu1"
    }
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Action")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Profile")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_vm._v("Logout")])])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-69b0b7fe", module.exports)
  }
}

/***/ }),

/***/ 450:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "message_write"
  }, [_c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.message),
      expression: "message"
    }],
    staticClass: "form-control",
    attrs: {
      "placeholder": "Enter message"
    },
    domProps: {
      "value": (_vm.message)
    },
    on: {
      "keydown": function($event) {
        if (!('button' in $event) && _vm._k($event.keyCode, "enter", 13)) { return null; }
        $event.preventDefault();
        _vm.handleAddChat($event)
      },
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.message = $event.target.value
      }
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('div', {
    staticClass: "chat_bottom"
  }, [_vm._m(0), _vm._v(" "), _c('a', {
    staticClass: "pull-right btn btn-success",
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.handleAddChat($event)
      }
    }
  }, [_vm._v("Send")])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "pull-left upload_btn",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "fa fa-cloud-upload",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v("\n\t\t\t\t\tAdd Files\n\t\t\t\t")])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-708f9f81", module.exports)
  }
}

/***/ }),

/***/ 456:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "wrapper",
    attrs: {
      "id": "chat-user-list-wrapper"
    }
  }, [_c('ul', {
    staticClass: "list-group"
  }, _vm._l((_vm.chatStore.userList), function(user) {
    return (user.id !== _vm.authUserStore.authUser.id) ? _c('li', {
      staticClass: "left clearfix list-group-item",
      class: _vm.userActiveStyle(user) ? 'active' : '',
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.changeChatUser(user)
        }
      }
    }, [_c('span', {
      staticClass: "chat-img pull-left"
    }, [_c('img', {
      staticClass: "img-circle",
      attrs: {
        "src": __webpack_require__(380),
        "alt": user.first_name
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "chat-body clearfix"
    }, [_c('div', {
      staticClass: "header_sec"
    }, [_c('strong', {
      staticClass: "primary-font"
    }, [_vm._v(_vm._s(user.first_name) + " " + _vm._s(user.last_name))]), _vm._v(" "), _c('strong', {
      staticClass: "pull-right"
    }, [_vm._v("09:45AM")])]), _vm._v(" "), _vm._m(0, true)])]) : _vm._e()
  }))])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "contact_sec"
  }, [_c('strong', {
    staticClass: "primary-font"
  }, [_vm._v("(123) 123-456")]), _vm._v(" "), _c('span', {
    staticClass: "badge pull-right"
  }, [_vm._v("3")])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-ecb32106", module.exports)
  }
}

/***/ }),

/***/ 460:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(407);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("45b827b5", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3398d846\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatPage.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3398d846\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatPage.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 462:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(409);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("4b794cd2", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-42f96838\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatWidget.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-42f96838\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatWidget.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 465:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(412);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("10354d15", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-603a0bfa\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatPage.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-603a0bfa\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatPage.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 467:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(414);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("2892dd47", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69b0b7fe\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatHeader.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69b0b7fe\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatHeader.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 469:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(416);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("a439be5a", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-708f9f81\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatAddWidget.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-708f9f81\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatAddWidget.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 473:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(420);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("2c40dc31", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ecb32106\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatUserList.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ecb32106\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ChatUserList.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});