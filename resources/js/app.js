require('./bootstrap');
import App from './App.vue';
import Vue from 'vue'
import router from './router/index.js';
//引入element-ui
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)
//引入axios
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)
const app = new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>'
});