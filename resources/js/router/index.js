/**
 * Created by SWESWE on 2019/10/12.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Hello from '../components/test.vue'
import Hello2 from '../components/WelcomeComponent.vue'
import Login from'../components/login.vue'
export default new VueRouter({
    routes: [
        {
            name: 'hello',
            path: '/hello',
            component:Hello
        },
        {
            name: 'hello2',
            path: '/',
            component:Hello2
        },
        {
            name: 'login',
            path: '/login',
            component:Login
        }
    ],
    mode:'history'
});