import Vue from 'vue'
import Router from 'vue-router'
import Login from './views/Login'
import Register from './views/Register'
import Dashboard from './views/Dashboard'
import store from './store.js'

Vue.use(Router)

let router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                requireAuth: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        }
    ]
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requireAuth)) {
        if(store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }
})

export default router