import Vue from 'vue';
import ajax from '../services/ajax';

/* We include the http to every component */
Vue.prototype.$http = ajax;