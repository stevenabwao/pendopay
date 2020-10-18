webpackJsonp([6],{

/***/ 152:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(381),
  /* template */
  __webpack_require__(451),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/admin/CreateUser.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CreateUser.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-76f09652", Component.options)
  } else {
    hotAPI.reload("data-v-76f09652", Component.options)
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

/***/ 361:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(4);
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





/* harmony default export */ __webpack_exports__["default"] = {

      computed: _extends({
            loggedIn: function loggedIn() {
                  return this.authUserStore.authUser !== null && this.authUserStore.authUser.access_token !== null;
            },
            authUserLink: function authUserLink() {
                  return "/profile/" + this.authUserStore.authUser.id;
            },
            authUserAbout: function authUserAbout() {
                  return "/profile/" + this.authUserStore.authUser.id + "/about";
            },
            authUserPhotos: function authUserPhotos() {
                  return "/profile/" + this.authUserStore.authUser.id + "/photos";
            }
      }, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
            authUserStore: function authUserStore(state) {
                  return state.authUser;
            }
      })),

      methods: {
            handleLogout: function handleLogout() {
                  $.LoadingOverlay("show");
                  this.$store.dispatch('clearAuthUser');
                  window.localStorage.removeItem('authUser');
                  //this.$router.push({ name: 'home' });
                  location.reload();
            }
      },

      created: function created() {
            var _this = this;

            console.log("I am header created.");

            var authUser = JSON.parse(window.localStorage.getItem('authUser'));
            if (authUser !== null && authUser.access_token !== null) {
                  console.log('main user check');
                  //check if token still valid
                  //get user data 
                  axios.get(__WEBPACK_IMPORTED_MODULE_1__config__["a" /* userUrl */], { headers: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__config__["b" /* getHeader */])() }).then(function (successdata) {

                        //save new user details
                        authUser.id = successdata.data.id;
                        authUser.email = successdata.data.email;
                        authUser.first_name = successdata.data.first_name;
                        authUser.last_name = successdata.data.last_name;
                        authUser.gender = successdata.data.gender;

                        //window.localStorage.setItem('authUser', JSON.stringify(authUser));

                        //login the user
                        _this.$store.dispatch("setAuthUser", authUser);
                  }).catch(function (error) {
                        //redirect to login page
                        console.log('user not found');
                        console.log(error);
                  });
            } else {
                  //redirect to login
                  this.$router.push({ name: 'login' });
            }
      }
};

/***/ }),

/***/ 363:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(undefined);
// imports


// module
exports.push([module.i, "\n.link{ cursor:pointer;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 366:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  null,
  /* template */
  __webpack_require__(371),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/Footer.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Footer.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0debe278", Component.options)
  } else {
    hotAPI.reload("data-v-0debe278", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 367:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(376)
}
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(361),
  /* template */
  __webpack_require__(372),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/Header.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Header.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a3c72b6", Component.options)
  } else {
    hotAPI.reload("data-v-1a3c72b6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 368:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  null,
  /* template */
  __webpack_require__(375),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/SettingsRight.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] SettingsRight.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6a4e1ec0", Component.options)
  } else {
    hotAPI.reload("data-v-6a4e1ec0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 369:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  null,
  /* template */
  __webpack_require__(374),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/SidebarBackdropRight.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] SidebarBackdropRight.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-609b9153", Component.options)
  } else {
    hotAPI.reload("data-v-609b9153", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 371:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('footer', {
    staticClass: "footer container-fluid pl-30 pr-30"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-sm-12"
  }, [_c('p', [_vm._v("2017 © Quick Loans")])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-0debe278", module.exports)
  }
}

/***/ }),

/***/ 372:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('nav', {
    staticClass: "navbar navbar-inverse navbar-fixed-top"
  }, [_c('div', {
    staticClass: "mobile-only-brand pull-left"
  }, [_c('div', {
    staticClass: "nav-header pull-left"
  }, [_c('div', {
    staticClass: "logo-wrap"
  }, [_c('router-link', {
    attrs: {
      "to": {
        name: 'home'
      }
    }
  }, [_c('a', [_c('img', {
    staticClass: "brand-img mr-10",
    attrs: {
      "src": "/css/images/logo.png",
      "alt": "QLoans"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "brand-text"
  }, [_vm._v("QuickLoans")])])])], 1)]), _vm._v(" "), _vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._m(2), _vm._v(" "), _vm._m(3)]), _vm._v(" "), _c('div', {
    staticClass: "mobile-only-nav pull-right",
    attrs: {
      "id": "mobile_only_nav"
    }
  }, [_c('ul', {
    staticClass: "nav navbar-right top-nav pull-right"
  }, [_vm._m(4), _vm._v(" "), _vm._m(5), _vm._v(" "), _vm._m(6), _vm._v(" "), _vm._m(7), _vm._v(" "), _c('li', {
    staticClass: "dropdown auth-drp"
  }, [_c('a', {
    staticClass: "dropdown-toggle pr-0",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('img', {
    staticClass: "user-auth-img img-circle",
    attrs: {
      "src": "/css/images/user1.png",
      "alt": _vm.authUserStore.authUser.first_name
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "user-online-status"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu user-auth-dropdown",
    attrs: {
      "data-dropdown-in": "flipInX",
      "data-dropdown-out": "flipOutX"
    }
  }, [_c('li', [_c('a', {
    staticClass: "dropdown-toggle pr-0 level-2-drp",
    attrs: {
      "href": "profile.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check text-info"
  }), _vm._v(" \n                          " + _vm._s(_vm.authUserStore.authUser.first_name) + " \n                      ")])]), _vm._v(" "), _c('li', {
    staticClass: "divider"
  }), _vm._v(" "), _c('li', [_c('router-link', {
    attrs: {
      "to": {
        name: 'profileHome'
      }
    }
  }, [_c('a', [_c('i', {
    staticClass: "zmdi zmdi-account"
  }), _vm._v(" "), _c('span', [_vm._v("Profile")])])])], 1), _vm._v(" "), _vm._m(8), _vm._v(" "), _vm._m(9), _vm._v(" "), _c('li', {
    staticClass: "divider"
  }), _vm._v(" "), _vm._m(10), _vm._v(" "), _c('li', {
    staticClass: "divider"
  }), _vm._v(" "), _c('li', {
    staticClass: "link",
    on: {
      "click": function($event) {
        _vm.handleLogout()
      }
    }
  }, [_c('a', {
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.handleLogout()
      }
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-power text-danger"
  }), _vm._v(" "), _c('span', [_vm._v("Log Out")])])])])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "toggle-left-nav-btn inline-block ml-20 pull-left",
    attrs: {
      "id": "toggle_nav_btn",
      "href": "javascript:void(0);"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-menu"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "mobile-only-view",
    attrs: {
      "id": "toggle_mobile_search",
      "data-toggle": "collapse",
      "data-target": "#search_form",
      "href": "javascript:void(0);"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-search"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "mobile-only-view",
    attrs: {
      "id": "toggle_mobile_nav",
      "href": "javascript:void(0);"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('form', {
    staticClass: "top-nav-search collapse pull-left",
    attrs: {
      "id": "search_form",
      "role": "search"
    }
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "text",
      "name": "example-input1-group2",
      "placeholder": "Search"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "input-group-btn"
  }, [_c('button', {
    staticClass: "btn  btn-default",
    attrs: {
      "type": "button",
      "data-target": "#search_form",
      "data-toggle": "collapse",
      "aria-label": "Close",
      "aria-expanded": "true"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-search"
  })])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "id": "open_right_sidebar",
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-settings top-nav-icon"
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "dropdown app-drp"
  }, [_c('a', {
    staticClass: "dropdown-toggle",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-apps top-nav-icon"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu app-dropdown",
    attrs: {
      "data-dropdown-in": "slideInRight",
      "data-dropdown-out": "flipOutX"
    }
  }, [_c('li', [_c('div', {
    staticClass: "app-nicescroll-bar"
  }, [_c('ul', {
    staticClass: "app-icon-wrap pa-10"
  }, [_c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "weather.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-cloud-outline txt-info"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("weather")])])]), _vm._v(" "), _c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "inbox.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-email-open txt-success"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("e-mail")])])]), _vm._v(" "), _c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "calendar.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-calendar-check txt-primary"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("calendar")])])]), _vm._v(" "), _c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "vector-map.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-map txt-danger"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("map")])])]), _vm._v(" "), _c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "chats.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-comment-outline txt-warning"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("chat")])])]), _vm._v(" "), _c('li', [_c('a', {
    staticClass: "connection-item",
    attrs: {
      "href": "contact-card.html"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-assignment-account"
  }), _vm._v(" "), _c('span', {
    staticClass: "block"
  }, [_vm._v("contact")])])])])])]), _vm._v(" "), _c('li', [_c('div', {
    staticClass: "app-box-bottom-wrap"
  }, [_c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('a', {
    staticClass: "block text-center read-all",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v(" more ")])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "dropdown full-width-drp"
  }, [_c('a', {
    staticClass: "dropdown-toggle",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-more-vert top-nav-icon"
  })]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu mega-menu pa-0",
    attrs: {
      "data-dropdown-in": "fadeIn",
      "data-dropdown-out": "fadeOut"
    }
  }, [_c('li', {
    staticClass: "product-nicescroll-bar row"
  }, [_c('ul', {
    staticClass: "pa-20"
  }, [_c('li', {
    staticClass: "col-md-3 col-xs-6 col-menu-list"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0);"
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
  })]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('ul', [_c('li', [_c('a', {
    attrs: {
      "href": "index.html"
    }
  }, [_vm._v("Analytical")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "index2.html"
    }
  }, [_vm._v("Demographic")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "index3.html"
    }
  }, [_vm._v("Project")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "profile.html"
    }
  }, [_vm._v("profile")])])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "widgets.html"
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
  })]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('a', {
    attrs: {
      "href": "documentation.html"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-book mr-20"
  }), _vm._v(" "), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("documentation")])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  })]), _vm._v(" "), _c('li', {
    staticClass: "col-md-3 col-xs-6 col-menu-list"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0);"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('i', {
    staticClass: "zmdi zmdi-shopping-basket mr-20"
  }), _c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("E-Commerce")])]), _vm._v(" "), _c('div', {
    staticClass: "pull-right"
  }, [_c('span', {
    staticClass: "label label-success"
  }, [_vm._v("hot")])]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('ul', [_c('li', [_c('a', {
    attrs: {
      "href": "e-commerce.html"
    }
  }, [_vm._v("Dashboard")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "product.html"
    }
  }, [_vm._v("Products")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "product-detail.html"
    }
  }, [_vm._v("Product Detail")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "add-products.html"
    }
  }, [_vm._v("Add Product")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "product-orders.html"
    }
  }, [_vm._v("Orders")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "product-cart.html"
    }
  }, [_vm._v("Cart")])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "product-checkout.html"
    }
  }, [_vm._v("Checkout")])])])]), _vm._v(" "), _c('li', {
    staticClass: "col-md-6 col-xs-12 preview-carousel"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0);"
    }
  }, [_c('div', {
    staticClass: "pull-left"
  }, [_c('span', {
    staticClass: "right-nav-text"
  }, [_vm._v("latest products")])]), _c('div', {
    staticClass: "clearfix"
  })]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('div', {
    staticClass: "product-carousel owl-carousel owl-theme text-center"
  }, [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    attrs: {
      "src": "/css/images/chair.jpg",
      "alt": "chair"
    }
  }), _vm._v(" "), _c('span', [_vm._v("Circle chair")])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    attrs: {
      "src": "/css/images/chair2.jpg",
      "alt": "chair"
    }
  }), _vm._v(" "), _c('span', [_vm._v("square chair")])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    attrs: {
      "src": "/css/images/chair3.jpg",
      "alt": "chair"
    }
  }), _vm._v(" "), _c('span', [_vm._v("semi circle chair")])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    attrs: {
      "src": "/css/images/chair4.jpg",
      "alt": "chair"
    }
  }), _vm._v(" "), _c('span', [_vm._v("wooden chair")])]), _vm._v(" "), _c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('img', {
    attrs: {
      "src": "/css/images/chair2.jpg",
      "alt": "chair"
    }
  }), _vm._v(" "), _c('span', [_vm._v("square chair")])])])])])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "dropdown alert-drp"
  }, [_c('a', {
    staticClass: "dropdown-toggle",
    attrs: {
      "href": "#",
      "data-toggle": "dropdown"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-notifications top-nav-icon"
  }), _c('span', {
    staticClass: "top-nav-icon-badge"
  }, [_vm._v("5")])]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu alert-dropdown",
    attrs: {
      "data-dropdown-in": "bounceIn",
      "data-dropdown-out": "bounceOut"
    }
  }, [_c('li', [_c('div', {
    staticClass: "notification-box-head-wrap"
  }, [_c('span', {
    staticClass: "notification-box-head pull-left inline-block"
  }, [_vm._v("notifications")]), _vm._v(" "), _c('a', {
    staticClass: "txt-danger pull-right clear-notifications inline-block",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v(" clear all ")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  })])]), _vm._v(" "), _c('li', [_c('div', {
    staticClass: "streamline message-nicescroll-bar"
  }, [_c('div', {
    staticClass: "sl-item"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "icon bg-green"
  }, [_c('i', {
    staticClass: "zmdi zmdi-flag"
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font  pull-left truncate head-notifications"
  }, [_vm._v("\n                                New subscription created")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right notifications-time"
  }, [_vm._v("2pm")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('p', {
    staticClass: "truncate"
  }, [_vm._v("Your customer subscribed for the basic plan. The customer will pay $25 per month.")])])])]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('div', {
    staticClass: "sl-item"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "icon bg-yellow"
  }, [_c('i', {
    staticClass: "zmdi zmdi-trending-down"
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font  pull-left truncate head-notifications txt-warning"
  }, [_vm._v("Server #2 not responding")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11 pull-right notifications-time"
  }, [_vm._v("1pm")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('p', {
    staticClass: "truncate"
  }, [_vm._v("Some technical error occurred needs to be resolved.")])])])]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('div', {
    staticClass: "sl-item"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "icon bg-blue"
  }, [_c('i', {
    staticClass: "zmdi zmdi-email"
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font  pull-left truncate head-notifications"
  }, [_vm._v("2 new messages")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right notifications-time"
  }, [_vm._v("4pm")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('p', {
    staticClass: "truncate"
  }, [_vm._v(" The last payment for your G Suite Basic subscription failed.")])])])]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('div', {
    staticClass: "sl-item"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "sl-avatar"
  }, [_c('img', {
    staticClass: "img-responsive",
    attrs: {
      "src": "/css/images/avatar.jpg",
      "alt": "avatar"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font  pull-left truncate head-notifications"
  }, [_vm._v("Sandy Doe")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right notifications-time"
  }, [_vm._v("1pm")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('p', {
    staticClass: "truncate"
  }, [_vm._v("Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit")])])])]), _vm._v(" "), _c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('div', {
    staticClass: "sl-item"
  }, [_c('a', {
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_c('div', {
    staticClass: "icon bg-red"
  }, [_c('i', {
    staticClass: "zmdi zmdi-storage"
  })]), _vm._v(" "), _c('div', {
    staticClass: "sl-content"
  }, [_c('span', {
    staticClass: "inline-block capitalize-font  pull-left truncate head-notifications txt-danger"
  }, [_vm._v("99% server space occupied.")]), _vm._v(" "), _c('span', {
    staticClass: "inline-block font-11  pull-right notifications-time"
  }, [_vm._v("1pm")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  }), _vm._v(" "), _c('p', {
    staticClass: "truncate"
  }, [_vm._v("consectetur, adipisci velit.")])])])])])]), _vm._v(" "), _c('li', [_c('div', {
    staticClass: "notification-box-bottom-wrap"
  }, [_c('hr', {
    staticClass: "light-grey-hr ma-0"
  }), _vm._v(" "), _c('a', {
    staticClass: "block text-center read-all",
    attrs: {
      "href": "javascript:void(0)"
    }
  }, [_vm._v(" read all ")]), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })])])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-card"
  }), _c('span', [_vm._v("My Account")])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-settings"
  }), _c('span', [_vm._v("Settings")])])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', {
    staticClass: "sub-menu show-on-hover"
  }, [_c('a', {
    staticClass: "dropdown-toggle pr-0 level-2-drp",
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check text-success"
  }), _vm._v(" available")]), _vm._v(" "), _c('ul', {
    staticClass: "dropdown-menu open-left-side"
  }, [_c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check text-success"
  }), _c('span', [_vm._v("available")])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-circle-o text-warning"
  }), _c('span', [_vm._v("busy")])])]), _vm._v(" "), _c('li', [_c('a', {
    attrs: {
      "href": "#"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-minus-circle-outline text-danger"
  }), _c('span', [_vm._v("offline")])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-1a3c72b6", module.exports)
  }
}

/***/ }),

/***/ 374:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "right-sidebar-backdrop"
  })
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-609b9153", module.exports)
  }
}

/***/ }),

/***/ 375:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "setting-panel"
  }, [_c('ul', {
    staticClass: "right-sidebar nicescroll-bar pa-0"
  }, [_c('li', {
    staticClass: "layout-switcher-wrap"
  }, [_c('ul', [_c('li', [_c('span', {
    staticClass: "layout-title"
  }, [_vm._v("Scrollable sidebar")]), _vm._v(" "), _c('span', {
    staticClass: "layout-switcher"
  }, [_c('input', {
    staticClass: "js-switch",
    attrs: {
      "type": "checkbox",
      "id": "switch_3",
      "data-color": "#ff2a00",
      "data-secondary-color": "#878787",
      "data-size": "small"
    }
  })]), _vm._v(" "), _c('h6', {
    staticClass: "mt-30 mb-15"
  }, [_vm._v("Theme colors")]), _vm._v(" "), _c('ul', {
    staticClass: "theme-option-wrap"
  }, [_c('li', {
    staticClass: "active-theme",
    attrs: {
      "id": "theme-1"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })]), _vm._v(" "), _c('li', {
    attrs: {
      "id": "theme-2"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })]), _vm._v(" "), _c('li', {
    attrs: {
      "id": "theme-3"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })]), _vm._v(" "), _c('li', {
    attrs: {
      "id": "theme-4"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })]), _vm._v(" "), _c('li', {
    attrs: {
      "id": "theme-5"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })]), _vm._v(" "), _c('li', {
    attrs: {
      "id": "theme-6"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-check"
  })])]), _vm._v(" "), _c('h6', {
    staticClass: "mt-30 mb-15"
  }, [_vm._v("Primary colors")]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-red",
      "checked": "",
      "value": "pimary-color-red"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-red"
    }
  }, [_vm._v(" Red ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-blue",
      "value": "pimary-color-blue"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-blue"
    }
  }, [_vm._v(" Blue ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-green",
      "value": "pimary-color-green"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-green"
    }
  }, [_vm._v(" Green ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-yellow",
      "value": "pimary-color-yellow"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-yellow"
    }
  }, [_vm._v(" Yellow ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-pink",
      "value": "pimary-color-pink"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-pink"
    }
  }, [_vm._v(" Pink ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-orange",
      "value": "pimary-color-orange"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-orange"
    }
  }, [_vm._v(" Orange ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-5"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-gold",
      "value": "pimary-color-gold"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-gold"
    }
  }, [_vm._v(" Gold ")])]), _vm._v(" "), _c('div', {
    staticClass: "radio mb-35"
  }, [_c('input', {
    attrs: {
      "type": "radio",
      "name": "radio-primary-color",
      "id": "pimary-color-silver",
      "value": "pimary-color-silver"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "pimary-color-silver"
    }
  }, [_vm._v(" Silver ")])]), _vm._v(" "), _c('button', {
    staticClass: "btn  btn-info btn-xs btn-outline btn-rounded mb-10",
    attrs: {
      "id": "reset_setting"
    }
  }, [_vm._v("reset")])])])])])]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success btn-circle setting-panel-btn shadow-2dp",
    attrs: {
      "id": "setting_panel_btn"
    }
  }, [_c('i', {
    staticClass: "zmdi zmdi-settings"
  })])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-6a4e1ec0", module.exports)
  }
}

/***/ }),

/***/ 376:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(363);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(149)("2436e529", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a3c72b6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Header.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a3c72b6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Header.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 377:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Header_vue__ = __webpack_require__(367);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Header_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__Header_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__SidebarLeft_vue__ = __webpack_require__(321);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__SidebarLeft_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__SidebarLeft_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__SidebarRight_vue__ = __webpack_require__(322);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__SidebarRight_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__SidebarRight_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__SettingsRight_vue__ = __webpack_require__(368);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__SettingsRight_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__SettingsRight_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__SidebarBackdropRight_vue__ = __webpack_require__(369);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__SidebarBackdropRight_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__SidebarBackdropRight_vue__);
//
//
//
//
//
//
//
//
//
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
        appHeader: __WEBPACK_IMPORTED_MODULE_0__Header_vue___default.a,
        appSidebarLeft: __WEBPACK_IMPORTED_MODULE_1__SidebarLeft_vue___default.a,
        appSidebarRight: __WEBPACK_IMPORTED_MODULE_2__SidebarRight_vue___default.a,
        appSettingsRight: __WEBPACK_IMPORTED_MODULE_3__SettingsRight_vue___default.a,
        appSidebarBackdropRight: __WEBPACK_IMPORTED_MODULE_4__SidebarBackdropRight_vue___default.a
    }

};

/***/ }),

/***/ 378:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(377),
  /* template */
  __webpack_require__(379),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/MainIncludes.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MainIncludes.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1b2afd8d", Component.options)
  } else {
    hotAPI.reload("data-v-1b2afd8d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 379:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('app-header'), _vm._v(" "), _c('app-sidebar-left'), _vm._v(" "), _c('app-sidebar-right'), _vm._v(" "), _c('app-settings-right'), _vm._v(" "), _c('app-sidebar-backdrop-right')], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-1b2afd8d", module.exports)
  }
}

/***/ }),

/***/ 381:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__env__ = __webpack_require__(151);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_MainIncludes_vue__ = __webpack_require__(378);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_MainIncludes_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__includes_MainIncludes_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__includes_Footer_vue__ = __webpack_require__(366);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__includes_Footer_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__includes_Footer_vue__);
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









/* harmony default export */ __webpack_exports__["default"] = {

    components: {
        appMainIncludes: __WEBPACK_IMPORTED_MODULE_3__includes_MainIncludes_vue___default.a,
        appFooter: __WEBPACK_IMPORTED_MODULE_4__includes_Footer_vue___default.a
    },

    data: function data() {
        return {
            form: new Form({
                first_name: '',
                last_name: '',
                gender: '',
                email: '',
                password: ''
            }),
            addLoading: false,
            showsuccess: false,
            showerror: false
        };
    },


    computed: _extends({
        loggedIn: function loggedIn() {
            return this.authUserStore.authUser !== null && this.authUserStore.authUser.access_token !== null;
        }
    }, __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuex__["a" /* mapState */])({
        authUserStore: function authUserStore(state) {
            return state.authUser;
        }
    })),

    methods: {
        handleRegisterSubmit: function handleRegisterSubmit() {
            var _this = this;

            this.addLoading = true;

            console.log(__WEBPACK_IMPORTED_MODULE_1__config__["c" /* addUserUrl */]);
            console.log(this.form);

            //$("#submit-btn").LoadingOverlay("show");

            var authUser = {};

            //post form data
            this.form.post(__WEBPACK_IMPORTED_MODULE_1__config__["c" /* addUserUrl */]).then(function (response) {

                _this.addLoading = false;

                //$("#submit-btn").LoadingOverlay("hide");

                if (response.status === 200) {
                    console.log("User created");
                }

                console.log(response);
            }).catch(function (error) {
                return console.log(error);
            });
        }
    }

};

/***/ }),

/***/ 451:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "wrapper theme-1-active pimary-color-red"
  }, [_c('app-main-includes'), _vm._v(" "), _c('div', {
    staticClass: "page-wrapper"
  }, [_c('div', {
    staticClass: "container-fluid pt-25"
  }, [_c('div', {
    staticClass: "table-struct full-width full-height"
  }, [_c('div', {
    staticClass: "table-cell vertical-align-middle"
  }, [_c('div', {
    staticClass: "auth-form  ml-auto mr-auto no-float"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-sm-12 col-xs-12"
  }, [_c('div', {
    staticClass: "panel panel-default card-view"
  }, [_c('div', {
    staticClass: "panel-wrapper collapse in"
  }, [_c('div', {
    staticClass: "panel-body"
  }, [_vm._m(0), _vm._v(" "), _c('hr'), _vm._v(" "), _c('div', {
    staticClass: "form-wrap"
  }, [_c('form', {
    staticClass: "form-horizontal",
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.handleRegisterSubmit()
      }
    }
  }, [_c('div', {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.first_name),
      expression: "form.first_name"
    }, {
      name: "validate",
      rawName: "v-validate",
      value: ({
        rules: {
          required: true
        }
      }),
      expression: "{ rules: { required: true } }"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "text",
      "id": "first_name",
      "name": "first_name"
    },
    domProps: {
      "value": (_vm.form.first_name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.first_name = $event.target.value
      }
    }
  }), _vm._v(" "), _vm._m(2)])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.last_name),
      expression: "form.last_name"
    }, {
      name: "validate",
      rawName: "v-validate",
      value: ({
        rules: {
          required: true
        }
      }),
      expression: "{ rules: { required: true } }"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "text",
      "id": "last_name",
      "name": "last_name"
    },
    domProps: {
      "value": (_vm.form.last_name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.last_name = $event.target.value
      }
    }
  }), _vm._v(" "), _vm._m(4)])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(5), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.email),
      expression: "form.email"
    }, {
      name: "validate",
      rawName: "v-validate",
      value: ({
        rules: {
          required: true,
          email: true
        }
      }),
      expression: "{ rules: { required: true, email: true } }"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "email",
      "id": "email",
      "name": "email"
    },
    domProps: {
      "value": (_vm.form.email)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.email = $event.target.value
      }
    }
  }), _vm._v(" "), _vm._m(6)]), _vm._v(" "), _c('span', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.errors.has('email')),
      expression: "errors.has('email')"
    }]
  }, [_vm._v("\n                                                    " + _vm._s(_vm.errors.first('email')) + "\n                                                 ")])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(7), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.password),
      expression: "form.password"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "password",
      "id": "password",
      "name": "password"
    },
    domProps: {
      "value": (_vm.form.password)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.password = $event.target.value
      }
    }
  }), _vm._v(" "), _vm._m(8)])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_vm._m(9), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "col-sm-6"
  }, [_c('div', {
    staticClass: "radio"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.gender),
      expression: "form.gender"
    }],
    attrs: {
      "type": "radio",
      "name": "gender",
      "id": "gender",
      "value": "m",
      "checked": ""
    },
    domProps: {
      "checked": _vm._q(_vm.form.gender, "m")
    },
    on: {
      "__c": function($event) {
        _vm.form.gender = "m"
      }
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "m"
    }
  }, [_vm._v("Male")])])]), _vm._v(" "), _c('div', {
    staticClass: "col-sm-6"
  }, [_c('div', {
    staticClass: "radio"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.gender),
      expression: "form.gender"
    }],
    attrs: {
      "type": "radio",
      "name": "gender",
      "id": "gender",
      "value": "f"
    },
    domProps: {
      "checked": _vm._q(_vm.form.gender, "f")
    },
    on: {
      "__c": function($event) {
        _vm.form.gender = "f"
      }
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "f"
    }
  }, [_vm._v("Female")])])])])]), _vm._v(" "), _c('br'), _vm._v(" "), _vm._m(10), _vm._v(" "), _c('br'), _vm._v(" "), _c('hr'), _vm._v(" "), _c('div', {
    staticClass: "text-center"
  }, [_c('router-link', {
    attrs: {
      "to": {
        name: 'login'
      }
    }
  }, [_c('a', [_c('i', {
    staticClass: "fa fa-users"
  }), _vm._v(" \n                                                      \n                                                     View Users List\n                                                  ")])])], 1)])])])])])])])])])])]), _vm._v(" "), _c('app-footer')], 1)], 1)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "mb-30"
  }, [_c('h3', {
    staticClass: "text-center txt-dark mb-10"
  }, [_vm._v("Create a New User")]), _vm._v(" "), _c('h6', {
    staticClass: "text-center nonecase-font txt-grey"
  }, [_vm._v("\n                                            Please enter user details below\n                                        ")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "col-sm-3 control-label",
    attrs: {
      "for": "first_name"
    }
  }, [_vm._v("\n                                                 First Name\n                                                 "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v(" *")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "input-group-addon"
  }, [_c('i', {
    staticClass: "icon-user"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "col-sm-3 control-label",
    attrs: {
      "for": "last_name"
    }
  }, [_vm._v("\n                                                 Last Name\n                                                 "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v(" *")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "input-group-addon"
  }, [_c('i', {
    staticClass: "icon-user"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "col-sm-3 control-label",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("\n                                                 Email Address\n                                                 "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v(" *")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "input-group-addon"
  }, [_c('i', {
    staticClass: "icon-envelope-open"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "col-sm-3 control-label",
    attrs: {
      "for": "password"
    }
  }, [_vm._v("\n                                                 Password\n                                                 "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v(" *")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "input-group-addon"
  }, [_c('i', {
    staticClass: "icon-lock"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    staticClass: "col-sm-3 control-label",
    attrs: {
      "for": "gender"
    }
  }, [_vm._v("\n                                                 Gender\n                                                 "), _c('span', {
    staticClass: "text-danger"
  }, [_vm._v(" *")])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "col-sm-3"
  }), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('button', {
    staticClass: "btn btn-primary btn-block mr-10",
    attrs: {
      "type": "submit",
      "id": "submit-btn"
    }
  }, [_vm._v("\n                                                      Submit\n                                                ")])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-76f09652", module.exports)
  }
}

/***/ })

});