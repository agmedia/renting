/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Filter from "./components/Filter/Filter";

require('./bootstrap');

import Vue from "vue";
window.Vue = Vue;

import Vuex from 'vuex';
window.Vuex = Vuex;
Vue.use(Vuex);

import store from './../cart/store';

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        // dynamic segments start with a colon
        { path: '/', component: Filter }
    ]
});
/*import Vuex from 'vuex';
window.Vuex = Vuex;
Vue.use(Vuex);

import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2)

import store from './store.js';*/

//import Storage from './services/Storage'

Vue.component('filter-view', require('./components/Filter/Filter').default);
Vue.component('products-view', require('./components/ProductsList/ProductsList').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store: new Vuex.Store(store)
}).$mount('#filter-app');
