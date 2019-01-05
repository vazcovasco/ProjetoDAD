/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import moment from 'moment';

Vue.use(Vuex);
axios.defaults.baseURL = 'http://projetodad.local/';

export default new Vuex.Store({
    state: {
        moment: moment,
        token: localStorage.getItem('access_token') || null,
        user: JSON.parse(localStorage.getItem('user')) || null,
        manager: localStorage.getItem('manager') || null,
        shift: localStorage.getItem('shift'),
        shiftStarted: localStorage.getItem('shiftStarted'),
        shiftEnded: localStorage.getItem('shiftEnded')
    },
    getters: {
        loggedIn(state) {
            return state.token !== null;
        },
        isManager(state) {
            return state.manager !== null;
        },
        isShiftStarted(state) {
            return state.shift != 0;
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
            state.user = user;
        },
        setManager: (state, manager) => {
            state.manager = manager;
        },
        removeUser: (state) => {
            state.user = null;
        },
        removeManager: (state) => {
            state.manager = null;
        },
        setShift: (state, shift) => {
            state.shift = shift;
        },
        removeShift: (state) => {
            state.shift = null;
        },
        setShiftStarted: (state, shiftStarted) => {
            state.shiftStarted = shiftStarted;
        },
        removeShiftStarted: (state) => {
            state.shiftStarted = null;
        },
        setShiftEnded: (state, shiftEnded) => {
            state.shiftEnded = shiftEnded;
        },
        removeShiftEnded: (state) => {
            state.shiftEnded = null;
        },
    },
    actions: {
        register(context, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/register', {
                        name: data.name,
                        username: data.username,
                        email: data.email,
                        password: data.password,
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

            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('api/logout')
                        .then(response => {
                            localStorage.removeItem('access_token');
                            context.commit('destroyToken');
                            localStorage.removeItem('user');
                            context.commit('removeUser');
                            localStorage.removeItem('manager');
                            context.commit('removeManager');
                            localStorage.removeItem('shift');
                            context.commit('removeShift');
                            localStorage.removeItem('shiftStarted');
                            context.commit('removeShiftStarted');
                            localStorage.removeItem('shiftEnded');
                            context.commit('removeShiftEnded');
                            resolve(response);
                        })
                        .catch(error => {
                            localStorage.removeItem('access_token');
                            context.commit('destroyToken');
                            localStorage.removeItem('user');
                            context.commit('removeUser');
                            localStorage.removeItem('manager');
                            context.commit('removeManager');
                            localStorage.removeItem('shift');
                            context.commit('removeShift');
                            localStorage.removeItem('shiftStarted');
                            context.commit('removeShiftStarted');
                            localStorage.removeItem('shiftEnded');
                            context.commit('removeShiftEnded');
                            reject(error);
                        })
                });
            }
        },
        retrieveToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('api/login', credentials)
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
                        headers: {
                            'Authorization': 'Bearer ' + this.state.token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(function (response) {
                        const user = response.data;
                        const type = user.type;
                        const shift = user.shift_active;
                        const shiftStarted = user.last_shift_start;
                        const shiftEnded = user.last_shift_end;
                        localStorage.setItem('user', JSON.stringify(user));
                        context.commit('setUser', user);
                        if (type === 'manager') {
                            localStorage.setItem('manager', type);
                            context.commit('setManager', type);
                        }
                        localStorage.setItem('shift', shift);
                        context.commit('setShift', shift);
                        localStorage.setItem('shiftStarted', shiftStarted);
                        context.commit('setShiftStarted', shiftStarted);
                        localStorage.setItem('shiftEnded', shiftEnded);
                        context.commit('setShiftEnded', shiftEnded);
                        resolve(response);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        startShift(context) {
            var shift = 1;
            var shiftStarted = this.state.moment().format("YYYY-MM-DD HH:mm:ss");
            localStorage.removeItem('shift');
            context.commit('removeShift');
            localStorage.setItem('shift', shift);
            context.commit('setShift', shift);

            localStorage.removeItem('shiftStarted');
            context.commit('removeShiftStarted');
            localStorage.setItem('shiftStarted', shiftStarted);
            context.commit('setShiftStarted', shiftStarted);
        },
        endShift(context) {
            var shift = 0;
            var shiftEnded = this.state.moment().format("YYYY-MM-DD HH:mm:ss");
            localStorage.removeItem('shift');
            context.commit('removeShift');
            localStorage.setItem('shift', shift);
            context.commit('setShift', shift);

            localStorage.removeItem('shiftEnded');
            context.commit('removeShiftEnded');
            localStorage.setItem('shiftEnded', shiftEnded);
            context.commit('setShiftEnded', shiftEnded);
        }
    }
});
