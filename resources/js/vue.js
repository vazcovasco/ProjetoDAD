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

const user = Vue.component('user', require('./components/user.vue'));
const department = Vue.component('department', require('./components/departmentList.vue'));
const game = Vue.component('game', require('./components/tictactoe.vue'));

const routes = [
  { path: '/', redirect: '/users' },
  { path: '/users', component: user },
  { path: '/departments', component: department },
  { path: '/tictactoe', component: game }
];

const router = new VueRouter({
  routes:routes
});

const app = new Vue({
  router,
  data:{
    player1:undefined,
    player2: undefined,
    departments: [],
  }
}).$mount('#app');

