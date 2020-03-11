require('./bootstrap');

import Vue from 'vue';
import store from './store'
import VueRouter from "vue-router";
import router from './router';

import './modules/users'

window.Vue = Vue;
Vue.use(VueRouter);


// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router,
    store
});