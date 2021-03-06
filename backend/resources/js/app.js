require('./bootstrap');

import Vue from 'vue';
import store from './store'
import VueRouter from "vue-router";
import router from './router';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import Paginate from 'vuejs-paginate'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import VueClipboard from 'vue-clipboard2'

import './modules/users'
import './modules/mailing'
import './modules/statistics'
import './modules/rfm'

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(VueToast);
Vue.component('paginate', Paginate)
Vue.component('pulse-loader', PulseLoader);
Vue.use(VueClipboard)


// Close all opened toast immediately
Vue.$toast.clear();

// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router,
    store
});