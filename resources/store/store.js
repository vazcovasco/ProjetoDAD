/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);
axios.defaults.baseURL = 'http://157.230.136.9/';

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        user: JSON.parse(localStorage.getItem('user')) || null,
        manager: localStorage.getItem('manager') || null
    },  
    getters: {
        loggedIn(state) {
            return state.token !== null;
        },
        isManager(state) {
            return state.manager !== null;
        }
    },
    mutations: {
        retrieveToken(state, token) {
            state.token = token;
        },
        destroyToken(state) {
            state.token = null;
        },
        setUser: (state, user) => {
            state.user =  user;
        },
        setManager: (state, manager) => {
            state.manager =  manager;
        },
        removeUser: (state, user) => {
            state.user =  null;
        },
        removeManager: (state, manager) => {
            state.manager =  null;
        }
    },
    actions: {
        register(context, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/register', {
                    name: data.name,
                    username: data.username,
                    email: data.email,
                    photo: data.photo,
                    type: data.type,
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },
        destroyToken(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;

            if(context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('api/logout')
                    .then(response => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        localStorage.removeItem('user');
                        context.commit('removeUser');
                        localStorage.removeItem('manager');
                        context.commit('removeManager');
                        resolve(response);
                    })
                    .catch(error => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        localStorage.removeItem('user');
                        context.commit('removeUser');
                        localStorage.removeItem('manager');
                        context.commit('removeManager');
                        reject(error);
                    })
                });
            }
        },
        retrieveToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('api/login', {
                    username: credentials.username,
                    email: credentials.email,
                    password: credentials.password
                })
                    .then(response => {
                        const token = response.data.access_token;
                        localStorage.setItem('access_token', token);
                        context.commit('retrieveToken', token);
                        resolve(response);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    })
            });
        },
        setUser(context) {
            return new Promise((resolve, reject) => {
                axios.get('api/user', {
                    headers:{
                        'Authorization': 'Bearer ' + this.state.token,
                        'Accept': 'application/json'
                    }
                })
                .then(function (response) {
                    const user = response.data;
                    const type =  user.type;
                    console.log(user);
                    localStorage.setItem('user', JSON.stringify(user));
                    context.commit('setUser', user);
                    if(type === 'manager') {
                        localStorage.setItem('manager', type);
                        context.commit('setManager', type);
                    }
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                });
            });
        },
    }
});