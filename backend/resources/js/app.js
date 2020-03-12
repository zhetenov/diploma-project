require('./bootstrap');

import Vue from 'vue';
import store from './store'
import VueRouter from "vue-router";
import router from './router';
import VueToast from 'vue-toast-notification';
// Import any of available themes
import 'vue-toast-notification/dist/theme-default.css';
//import './vue-toast-notification/dist/dist/theme-sugar.css';

import './modules/users'

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(VueToast);


// Close all opened toast immediately
Vue.$toast.clear();

// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router,
    store
});