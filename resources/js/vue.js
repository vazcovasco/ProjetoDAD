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
const logout = Vue.component('logout', require('./components/auth/logout.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));
//-------------------------MEAL----------------------------------------------
const meal = Vue.component('meal', require('./components/meal.vue'));
const mealList = Vue.component('meal-list', require('./components/mealList.vue'));
const mealStart = Vue.component('meal-start', require('./components/mealStart.vue'));
const mealShow = Vue.component('meal-show', require('./components/mealShow.vue'));
//-------------------------Invoice----------------------------------------------
const invoice = Vue.component('invoice', require('./components/invoice.vue'));
const invoiceList = Vue.component('invoice-list', require('./components/invoiceList.vue'));
const invoiceShow = Vue.component('invoice-show', require('./components/invoiceShow.vue'));
const invoiceEdit = Vue.component('invoice-edit', require('./components/invoiceEdit.vue'));
//-------------------------ORDER----------------------------------------------
const order = Vue.component('order', require('./components/order.vue'));
const orderList = Vue.component('order-list', require('./components/orderList.vue'));
const orderAdd = Vue.component('order-add', require('./components/orderAdd.vue'));

//-------------------------Statistics----------------------------------------------
const statistics = Vue.component('statistics', require('./components/statistics.vue'));







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
        path: '/logout',
        component: logout
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
        path: '/meals/:id',
        component: mealShow
    },
    {
        path: '/meals/start',
        component: mealStart
    },
    {
        path: '/orders',
        component: order
    },
    {
        path: '/statistics/orders/:id',
        component: statistics
    },
    {
        path: '/invoices',
        component: invoice
    },
    {
        path: '/invoices/:id',
        component: invoiceShow
    },
    {
        path: '/invoices/:id',
        component: invoiceEdit
    },



];


const router = new VueRouter({
    routes: routes
});

router.beforeEach((to, from, next) => {
    if ((to.name == 'profile') || (to.name == 'logout')) {
        if (!store.state.user) {
            next("/login");
            return;
        }
    }
    next();
});

const app = new Vue({
    router,
    data: {
        items: [],
        users: [],
        invoices:[],
        meals: [],
        orders: []
    },
    store,

}).$mount('#app');
