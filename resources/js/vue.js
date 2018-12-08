/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// ------------------------- ------------------------- ------------------------- -------------------------
// CODE - EXERCISE 1
// ------------------------- ------------------------- ------------------------- -------------------------
// import UserList from './components/userList.vue';
// Vue.component('user-list', UserList);

// const app = new Vue({
//     el: '#app',
//     data: {
//         title: 'List Users',
//         showSuccess: false,
//         showFailure: false,
//         successMessage: '',
//         failMessage: '',
//         currentUser: null,
//         users: [],
//         departments: []
//     },
//     methods: {
//         editUser: function(user){
//             this.currentUser = user;
//             this.showSuccess = false;
//         },
          
//         deleteUser: function(user){
//             axios.delete('api/users/'+user.id)
//                 .then(response => {
//                     this.showSuccess = true;
//                     this.successMessage = 'User Deleted';
//                     this.getUsers();
//                 });
//         },
//         saveUser: function(){
//             if (this.currentUser) {
//              axios.put('api/users/'+this.currentUser.id,this.currentUser)
//                  .then(response=>{
//                      this.showSuccess = true;
//                      this.successMessage = 'User Saved';
//                      // Copies response.data.data properties to this.currentUser
//                      // without changing this.currentUser reference
//                      Object.assign(this.currentUser, response.data.data);
//                      this.currentUser = null;
//                      this.$refs.usersListRef.editingUser = null;
//                  });
//              }
//         },
//         cancelEdit: function(){
//             this.showSuccess = false;
//             axios.get('api/users/'+this.currentUser.id)
//                 .then(response=>{
//                     // Copies response.data.data properties to this.currentUser
//                     // without changing this.currentUser reference
//                     Object.assign(this.currentUser, response.data.data); 
//                     this.currentUser = null;
//                  this.$refs.usersListRef.editingUser = null;
//                 });
//         },        
//         getUsers: function(){
//             axios.get('api/users')
//                 .then(response=>{this.users = response.data.data;});
//         }
//     },
//     mounted() {
//         this.getUsers();
//         axios.get('api/departments')
//             .then(response=>{this.departments = response.data.data; });
//     }
// });



// ------------------------- ------------------------- ------------------------- -------------------------
// CODE - EXERCISE 2
// ------------------------- ------------------------- ------------------------- -------------------------

// import UserList from './components/userList.vue';
// Vue.component('user-list', UserList);

// import UserEdit from './components/userEdit.vue';
// Vue.component('user-edit', UserEdit);

// const app = new Vue({
//     el: '#app',
//     data: {
//         title: 'List Users',
//         showSuccess: false,
//         successMessage: '',
//         currentUser: null,
//         users: [],
//         departments: []
//     },
//     methods: {
//         editUser: function(user){
//             this.currentUser = user;
//             this.showSuccess = false;
//         },
          
//         deleteUser: function(user){
//             axios.delete('api/users/'+user.id)
//                 .then(response => {
//                     this.showSuccess = true;
//                     this.successMessage = 'User Deleted';
//                     this.getUsers();
//                 });
//         },
//         savedUser: function(){
//             this.currentUser = null;
//             this.$refs.usersListRef.editingUser = null;
//             this.showSuccess = true;
//             this.successMessage = 'User Saved';
//         },
//         cancelEdit: function(){
//             this.currentUser = null;
//             this.$refs.usersListRef.editingUser = null;
//             this.showSuccess = false;
//         },
//         getUsers: function(){
//             axios.get('api/users')
//                 .then(response=>{this.users = response.data.data;});
//         }
//     },
//     mounted() {
//         this.getUsers();
//         axios.get('api/departments')
//             .then(response=>{this.departments = response.data.data; });
//     }
// });


// ------------------------- ------------------------- ------------------------- -------------------------
// CODE - EXERCISE 3
// ------------------------- ------------------------- ------------------------- -------------------------

// import UserComponent from './components/user.vue';
// Vue.component('user', UserComponent);

// const app = new Vue({
//     el: '#app'
// });


import VueRouter from 'vue-router';
Vue.use(VueRouter);


//-------------------------ITEM----------------------------------------------
const item = Vue.component('item', require('./components/item.vue'));
const itemList = Vue.component('item-list', require('./components/itemList.vue'));
//-------------------------USER----------------------------------------------
const user = Vue.component('user', require('./components/user.vue'));
const userList = Vue.component('user-list', require('./components/userList.vue'));
const userAdd = Vue.component('user-add', require('./components/userAdd.vue'));
const userEdit = Vue.component('user-edit', require('./components/userEdit.vue'));
//-------------------------MEAL----------------------------------------------
const meal = Vue.component('meal', require('./components/meal.vue'));
const mealList = Vue.component('meal-list', require('./components/mealList.vue'));
const mealAdd = Vue.component('meal-add', require('./components/mealAdd.vue'));
const mealEdit = Vue.component('meal-edit', require('./components/mealEdit.vue'));


const routes = [
  { path: '/', redirect: '/meals' },
  { path: '/items', component : item },
  { path: '/users', component: user },
  { path: '/meals', component : meal},
  { path: '/users/add', component: userAdd },
  { path: '/users/:id', component: userEdit }
];

const router = new VueRouter({
  routes:routes
});

const app = new Vue({
  router,
  data:{
    
    items: [],
    users:[],
    meals:[]
  }
}).$mount('#app');

