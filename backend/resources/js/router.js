import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    base: '/admin/',
    mode: 'history'
})

export default router