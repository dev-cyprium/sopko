import Vue from 'vue';
import './plugins/vuetify'
import App from './App';
import '../sass/app.scss';

new Vue({
    render: h => h(App)
}).$mount('#app');
