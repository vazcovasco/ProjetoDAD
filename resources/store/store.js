/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);
axios.defaults.baseURL = 'http://projetodad.local/';

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        user: localStorage.getItem('user') || null
    },  
    getters: {
        loggedIn(state) {
            return state.token !== null;
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
    },
    actions: {
        destroyToken(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;

            if(context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('api/logout')
                    .then(response => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        resolve(response);
                    })
                    .catch(error => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        reject(error);
                    })
                });
            }
        },
        retrieveToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('api/login', {
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
                    localStorage.setItem('user', user);
                    context.commit('setUser', user);
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