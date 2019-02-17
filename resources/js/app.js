import Vue from 'vue'
import App from './App'
import router from './router'
import './plugins/vuetify'
import '../sass/app.scss'

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
