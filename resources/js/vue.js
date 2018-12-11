require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from '../store/store.js';


//-------------------------ITEM----------------------------------------------
const item = Vue.component('item', require('./components/item.vue'));
const itemList = Vue.component('item-list', require('./components/itemList.vue'));
//-------------------------USER----------------------------------------------
const user = Vue.component('user', require('./components/user.vue'));
const userList = Vue.component('user-list', require('./components/userList.vue'));
const userAdd = Vue.component('user-add', require('./components/userAdd.vue'));
const userEdit = Vue.component('user-edit', require('./components/userEdit.vue'));
const login = Vue.component('login', require('./components/auth/login.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));
//-------------------------MEAL----------------------------------------------
const meal = Vue.component('meal', require('./components/meal.vue'));
const mealList = Vue.component('meal-list', require('./components/mealList.vue'));
const mealAdd = Vue.component('meal-add', require('./components/mealAdd.vue'));
const mealEdit = Vue.component('meal-edit', require('./components/mealEdit.vue'));
//-------------------------ORDER----------------------------------------------
const order = Vue.component('order', require('./components/order.vue'));
const orderList = Vue.component('meal-list', require('./components/orderList.vue'));
const orderAdd = Vue.component('meal-add', require('./components/orderAdd.vue'));

const routes = [
    {
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
    {
        path: '/meals',
        component: meal
    },
    {
        path: '/orders',
        component: order
    },
];


const router = new VueRouter({
    routes: routes
});

const app = new Vue({
    router,
    data: {

        items: [],
        users: [],
        meals: [],
        orders: []
    },
    store,
}).$mount('#app');
