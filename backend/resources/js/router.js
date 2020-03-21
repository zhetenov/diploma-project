import Vue from 'vue'
import VueRouter from 'vue-router'
import pageNotFound from './helpers/pageNotFound'

Vue.use(VueRouter)

const router = new VueRouter({
    base: '/admin/',
    mode: 'history',
    routes: [
        {
            path: '*',
            component: pageNotFound
        }
    ]
})

export default router