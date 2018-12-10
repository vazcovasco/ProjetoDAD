require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from '../store/store.js';

const user = Vue.component('user', require('./components/user.vue'));
const item = Vue.component('item', require('./components/item.vue'));
const itemList = Vue.component('item-list', require('./components/itemList.vue'));
const userList = Vue.component('user-list', require('./components/userList.vue'));
const userAdd = Vue.component('user-add', require('./components/userAdd.vue'));
const userEdit = Vue.component('user-edit', require('./components/userEdit.vue'));
const login = Vue.component('login', require('./components/auth/login.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));

const routes = [{
        path: '/',
        redirect: '/items'
    },
    {
        path: '/items',
        component: item
    },
    {
        path: '/users',
        component: user
    },
    {
        path: '/users/add',
        component: userAdd
    },
    {
        path: '/users/:id',
        component: userEdit
    },
    {
        path: '/login',
        component: login
    },
    {
        path: '/profile',
        component: profile
    },
];

const router = new VueRouter({
    routes: routes
});

const app = new Vue({

    router,
    data: {

        items: [],
        users: []
    },
    store,
}).$mount('#app');
