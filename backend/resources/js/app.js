require('./bootstrap');

import Vue from 'vue';
import store from './store'
import VueRouter from "vue-router";
import router from './router';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import Paginate from 'vuejs-paginate'

import './modules/users'
import './modules/mailing'

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(VueToast);
Vue.component('paginate', Paginate)

// Close all opened toast immediately
Vue.$toast.clear();

// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router,
    store
});