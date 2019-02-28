import Vue from 'vue'
import axios from 'axios'
import App from './App'
import router from './router'
import store from './store'
import { sync } from 'vuex-router-sync'
import './plugins/chartist'
import './plugins/vuetify'
import '../sass/app.scss'


/*
Vue.prototype.$http = axios
const token = localStorage.getItem('token')

if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}
*/
const token = localStorage.getItem('token')

if(token) {
    axios.defaults.headers.common['Authorization'] = token
}

sync(store, router);

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
