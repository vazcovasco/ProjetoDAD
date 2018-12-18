require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from '../store/store.js';


//-------------------------ITEM----------------------------------------------
const item = Vue.component('item', require('./components/item.vue'));
const itemList = Vue.component('item-list', require('./components/itemList.vue'));
const itemAdd = Vue.component('item-add', require('./components/itemAdd.vue'));
const itemEdit = Vue.component('item-edit', require('./components/itemEdit.vue'));
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
<<<<<<< HEAD
const mealAdd = Vue.component('meal-add', require('./components/mealAdd.vue'));
const mealEdit = Vue.component('meal-edit', require('./components/mealEdit.vue'));
//-------------------------ORDER----------------------------------------------
const order = Vue.component('order', require('./components/order.vue'));
const orderList = Vue.component('order-list', require('./components/orderList.vue'));
const orderAdd = Vue.component('order-add', require('./components/orderAdd.vue'));
=======



>>>>>>> b23c21c17f284442199e45c16166f2c2b6c6fa64

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
        path: '/items/add',
        component: itemAdd
    },
    {
        path: '/items/:id',
        component: itemEdit
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
<<<<<<< HEAD
    },
    {
        path: '/orders',
        component: order
    },
=======
    }

>>>>>>> b23c21c17f284442199e45c16166f2c2b6c6fa64
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
