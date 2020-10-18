webpackJsonp([8],{

/***/ 157:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(395),
  /* template */
  __webpack_require__(448),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/pages/Login.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Login.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6aa72f83", Component.options)
  } else {
    hotAPI.reload("data-v-6aa72f83", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 362:
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


/* harmony default export */ __webpack_exports__["default"] = {};

/***/ }),

/***/ 370:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(362),
  /* template */
  __webpack_require__(373),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/partials/AuthHeaderShared.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] AuthHeaderShared.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5acc2fc4", Component.options)
  } else {
    hotAPI.reload("data-v-5acc2fc4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 373:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "sp-logo-wrap pull-left"
  }, [_c('img', {
    staticClass: "brand-img mr-10",
    attrs: {
      "src": "/css/images/logo.png",
      "alt": "QLoans"
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "brand-text"
  }, [_vm._v("QLoans")])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-5acc2fc4", module.exports)
  }
}

/***/ }),

/***/ 388:
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

/* harmony default export */ __webpack_exports__["default"] = {
    props: ['errors']
};

/***/ }),

/***/ 390:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__AuthHeaderShared_vue__ = __webpack_require__(370);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__AuthHeaderShared_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__AuthHeaderShared_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
        appAuthHeaderShared: __WEBPACK_IMPORTED_MODULE_0__AuthHeaderShared_vue___default.a
    }

};

/***/ }),

/***/ 395:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuex__ = __webpack_require__(148);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__env__ = __webpack_require__(151);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_partials_AuthHeaderLogin_vue__ = __webpack_require__(428);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__includes_partials_AuthHeaderLogin_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__includes_partials_AuthHeaderLogin_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__includes_FormError_vue__ = __webpack_require__(426);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__includes_FormError_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__includes_FormError_vue__);
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








/* harmony default export */ __webpack_exports__["default"] = {
    data: function data() {
        return {
            form: new Form({
                username: '',
                password: '',
                grant_type: 'password',
                client_id: __WEBPACK_IMPORTED_MODULE_2__env__["a" /* clientId */],
                client_secret: __WEBPACK_IMPORTED_MODULE_2__env__["b" /* clientSecret */],
                scope: ''
            }),
            addLoading: false,
            showsuccess: false,
            showerror: false
        };
    },


    components: {
        appAuthHeaderLogin: __WEBPACK_IMPORTED_MODULE_3__includes_partials_AuthHeaderLogin_vue___default.a,
        FormError: __WEBPACK_IMPORTED_MODULE_4__includes_FormError_vue___default.a
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
        handleLoginSubmit: function handleLoginSubmit() {
            var _this = this;

            this.addLoading = true;

            $("#submit-btn").LoadingOverlay("show");

            var authUser = {};

            //post form data
            this.form.post(__WEBPACK_IMPORTED_MODULE_1__config__["d" /* loginUrl */]).then(function (response) {

                _this.addLoading = false;

                $("#submit-btn").LoadingOverlay("hide");

                if (response.status === 200) {
                    authUser.access_token = response.data.access_token;
                    authUser.refresh_token = response.data.refresh_token;
                    //store tokens locally
                    window.localStorage.setItem('authUser', JSON.stringify(authUser));
                }

                //console.log(response);

                //get user data 
                axios.get(__WEBPACK_IMPORTED_MODULE_1__config__["a" /* userUrl */], { headers: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__config__["b" /* getHeader */])() }).then(function (successdata) {

                    //save new user details
                    authUser.id = successdata.data.id;
                    authUser.email = successdata.data.email;
                    authUser.first_name = successdata.data.first_name;
                    authUser.last_name = successdata.data.last_name;
                    authUser.gender = successdata.data.gender;

                    window.localStorage.setItem('authUser', JSON.stringify(authUser));

                    //login the user
                    _this.$store.dispatch("setAuthUser", authUser);

                    //redirect to home
                    _this.$router.push({ name: 'home' });
                }).catch(function (error) {
                    return console.log(error);
                });
            }).catch(function (error) {
                console.log(error
                // form submission failed, pass form  errors to errors array
                );_this.$emit('errors', error.data);
            });
        }
    }

};

/***/ }),

/***/ 426:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(388),
  /* template */
  __webpack_require__(457),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/FormError.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] FormError.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fb0282ea", Component.options)
  } else {
    hotAPI.reload("data-v-fb0282ea", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 428:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(147)(
  /* script */
  __webpack_require__(390),
  /* template */
  __webpack_require__(441),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "/Users/elishaomolo/Public/web/semesha/loans/loans/resources/assets/js/components/includes/partials/AuthHeaderLogin.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] AuthHeaderLogin.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-48d809c0", Component.options)
  } else {
    hotAPI.reload("data-v-48d809c0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 441:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('header', {
    staticClass: "sp-header auth-header"
  }, [_c('app-auth-header-shared'), _vm._v(" "), _c('div', {
    staticClass: "form-group mb-0 pull-right"
  }, [_c('span', {
    staticClass: "inline-block pr-10"
  }, [_vm._v("\n        Don't Have an Account Yet?\n      ")]), _vm._v(" "), _c('router-link', {
    attrs: {
      "to": {
        name: 'register'
      }
    }
  }, [_c('a', {
    staticClass: "inline-block btn btn-info btn-rounded btn-outline"
  }, [_vm._v("\n              Register\n           ")])])], 1), _vm._v(" "), _c('div', {
    staticClass: "clearfix"
  })], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-48d809c0", module.exports)
  }
}

/***/ }),

/***/ 448:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "page-wrapper wrapper pa-0 ma-0 auth-page"
  }, [_c('app-auth-header-login'), _vm._v(" "), _c('div', {
    staticClass: "container-fluid"
  }, [_c('div', {
    staticClass: "table-struct full-width full-height"
  }, [_c('div', {
    staticClass: "table-cell vertical-align-middle auth-form-wrap"
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
        _vm.handleLoginSubmit()
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
      value: (_vm.form.username),
      expression: "form.username"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "email",
      "id": "email",
      "required": ""
    },
    domProps: {
      "value": (_vm.form.username)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.username = $event.target.value
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
      value: (_vm.form.password),
      expression: "form.password"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "password",
      "id": "password",
      "required": ""
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
  }), _vm._v(" "), _vm._m(4)])]), _vm._v(" "), (_vm.errors.password) ? _c('form-error', {
    attrs: {
      "errors": _vm.errors
    }
  }, [_vm._v("\n                                                  @" + _vm._s(_vm.errors.password) + "\n                                              ")]) : _vm._e()], 1), _vm._v(" "), _vm._m(5), _vm._v(" "), _c('br'), _vm._v(" "), _vm._m(6), _vm._v(" "), _c('br'), _vm._v(" "), _c('hr'), _vm._v(" "), _c('div', {
    staticClass: "text-center"
  }, [_c('router-link', {
    attrs: {
      "to": {
        name: 'register'
      }
    }
  }, [_c('a', [_vm._v("\n                                                   Don't Have an Account Yet? Register\n                                                ")])]), _vm._v("\n\n                                                 |   \n\n                                              "), _c('router-link', {
    attrs: {
      "to": {
        name: 'forgotPassword'
      }
    }
  }, [_c('a', [_vm._v("\n                                                     Forgot Password\n                                                  ")])])], 1)])])])])])])])])])])])], 1)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "mb-30"
  }, [_c('h3', {
    staticClass: "text-center txt-dark mb-10"
  }, [_vm._v("Login")]), _vm._v(" "), _c('h6', {
    staticClass: "text-center nonecase-font txt-grey"
  }, [_vm._v("\n                                            Please enter your details below\n                                        ")])])
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
  return _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "col-sm-3"
  }), _vm._v(" "), _c('div', {
    staticClass: "col-sm-9"
  }, [_c('div', {
    staticClass: "checkbox"
  }, [_c('input', {
    attrs: {
      "id": "checkbox_2",
      "type": "checkbox",
      "name": "remember_me"
    }
  }), _vm._v(" "), _c('label', {
    attrs: {
      "for": "checkbox_2"
    }
  }, [_vm._v(" Remember me")])])])])
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
  }, [_vm._v("\n                                                       Submit\n                                                 ")])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-6aa72f83", module.exports)
  }
}

/***/ }),

/***/ 457:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    staticClass: "help-block"
  }, [_vm._v("\n    // this will be replaced by the error messages\n    "), _vm._t("default")], 2)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-fb0282ea", module.exports)
  }
}

/***/ })

});