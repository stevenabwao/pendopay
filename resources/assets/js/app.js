
import 'jquery';

window.$ = window.jQuery = require('jquery');
//window.swal = require('sweetalert');

require('./bootstrap');

//import App from './App.vue';

import Vue from 'vue';
//import VueRouter from 'vue-router';
import axios from 'axios';
//import VueAxios from 'vue-axios'; 
//import { routes } from './routes/index.js';
//import store from './store/store';
import moment from 'moment';
//import VeeValidate from 'vee-validate';
//import VueTimeago from 'vue-timeago';
//import { mixin as clickaway } from 'vue-clickaway';
//import _ from 'lodash';
import Form from './core/Form';
import { HTTP } from './common/http-common';

import { userUrl, getHeader } from './config';
//import { clientId, clientSecret } from './.env'; 

//import custom components
//import

//add x-csrf-token to all axios requests
let token = document.head.querySelector('meta[name="csrf-token"]');
axios.interceptors.request.use(function(config) {
    config.headers['X-CSRF-TOKEN'] = token
    return config
})

//make axios available as $http
Vue.prototype.$http = axios

window.Vue = Vue;
//window.axios = axios; 
window.Form = Form;
window.HTTP = HTTP;
//window._ = _;

//Vue.use(VueRouter); 
//Vue.use(VeeValidate); 

//timeago
/*Vue.use(VueTimeago, {
    name: 'timeago', // component name, `timeago` by default
    locale: 'en-US',
    locales: {
        'en-US': require('vue-timeago/locales/en-US.json')
    }
});


Vue.component('app', App); */

//start create date filters
/*Vue.filter('createdDate', (value) => {
    return moment(value).format('h:mm a');
});

Vue.filter('createdDate2', (value) => {
    return moment(value).format('MMM Do h:mm a');
});

Vue.filter('createdDateWeek', (value) => {
    return moment(value).format('MMM Do');
});

Vue.filter('createdDateWeeks', (value) => {
    return moment(value).format('MMM Do, YYYY');
});
//end create date filters

//capitalize filter
Vue.filter('capitalize', (value) => {
    return value.toUpperCase();
});*/
//end capitalize filter


//init vue router
/*const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition){
        if (savedPosition){
            return savedPosition; 
        }
        if (to.hash){
            return { selector: to.hash };
        }
        return {x: 0, y:0};
    }
});*/


//check for auth guarded pages
/*router.beforeEach((to, from, next) => {


    //add user auth token to each route that requires authorization
    if (to.meta.requiresAuth){
          const authUser = JSON.parse(window.localStorage.getItem('authUser'));
          if ((authUser !== null) && (authUser.access_token !== null)){
                //console.log('app js main user check');
                //check if token still valid
                //get user data 
                axios.get(userUrl, { headers: getHeader() })
                    .then(successdata => {
                        //proceed as usual
                        next();                               
                    })
                    .catch(error => { 
                        //redirect to login page
                        next({ name: 'login' });
                    });

          } else {
            //user not logged in or token not present, redirect to login page
            next({ name: 'login' });
          }
    }
   
    next();

});*/


/*new Vue ({

    el: "#app",
    router,
    store

});*/