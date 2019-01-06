require('./bootstrap');

window.Vue = require('vue');

import VueSocketio from 'vue-socket.io';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
Vue.use(new VueSocketio({
    debug: true,
    connection: 'http://localhost:8080'
}));


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
const register = Vue.component('register', require('./components/auth/register.vue'));
const login = Vue.component('login', require('./components/auth/login.vue'));
const logout = Vue.component('logout', require('./components/auth/logout.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));
const changePassword = Vue.component('changePassword', require('./components/changePassword.vue'));
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
//-------------------------RESTAURANT-----------------------------------------
const rm = Vue.component('rm', require('./components/restaurantManagement.vue'));
const shift = Vue.component('shift', require('./components/shift.vue'));

//-------------------------Statistics----------------------------------------------
const statistics = Vue.component('statistics', require('./components/statistics.vue'));
const testView = Vue.component('testView', require('./components/testView.vue'));

//--------------------------Tables-------------------------------------------------------
const r_tables = Vue.component('tables', require('./components/restaurantTables.vue'));
const r_tablesList = Vue.component('tables-list', require('./components/restaurantTablesList.vue'));
const r_tablesAdd = Vue.component('tables-add', require('./components/restaurantTablesAdd.vue'));
const r_tablesShow = Vue.component('tables-show', require('./components/restaurantTablesShow.vue'));
const r_tablesEdit = Vue.component('tables-edit', require('./components/restaurantTablesEdit.vue'));

const routes = [{
        path: '/',
        redirect: '/items'
    },
    {
        path: '/items',
        component: item,
    },
    {
        path: '/items/add',
        component: itemAdd,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/items/:id',
        component: itemEdit,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/users',
        component: user,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/users/add',
        component: userAdd,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/users/:id',
        component: userEdit,
        meta: {
            requiresAuth: true
        }
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
        path: '/register',
        component: register
    },
    {
        path: '/profile',
        component: profile,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/meals',
        component: meal,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/meals/show/:id',
        component: mealShow
    },
    {
        path: '/meals/start',
        component: mealStart
    },
    {
        path: '/meals/test1',
        component: testView
    },
    {
        path: '/orders',
        component: order,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/orders/add',
        component: orderAdd,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/statistics/orders/:id',
        component: statistics

    },
    {
        path: '/restaurantManagement',
        component: rm,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/shift',
        component: shift,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/changePassword',
        component: changePassword,
        meta: {
            requiresAuth: true
        }
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
    {
        path: '/restaurantTables',
        component: r_tables
    },
    {
        path: '/restaurantTables/add',
        component: r_tablesAdd
    },
    {
        path: '/restaurantTables/show/:table_number',
        component: r_tablesShow
    },
    {
        path: '/restaurantTables/edit/:table_number',
        component: r_tablesEdit


    },
];


const router = new VueRouter({
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
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
        invoices: [],
        meals: [],
        orders: []
    },
    store,
    computed: {
        user() {
            return this.$store.state.user;
        }
    }



}).$mount('#app');
