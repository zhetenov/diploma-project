require('./bootstrap');

// 1. Comment out this following line:
// window.Vue = require('vue');

// 2. Add below the above commented-out line:
import Vue from 'vue';
import VueRouter from "vue-router";

window.Vue = Vue;
Vue.use(VueRouter);

import Form from "./utilities/Form";
window.Form = Form;

import router from './routes';

/* ... SNIP ... */

// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router
});