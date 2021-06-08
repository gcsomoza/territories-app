/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import App from './views/App.vue';
import Login from './views/Login.vue';

Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(Vuex);

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'app',
      component: App
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    }
  ]
});

const store = new Vuex.Store({
    state: {
      profile: null,
      username: "",
      password: "",
    },
    getters: {
      isLoggedIn(state) {
        return (state.username != "" && state.password != "")
      },
      getProfile(state) {
        return state.profile
      },
      getUsername(state) {
        return state.username
      },
      getPassword(state) {
        return state.password
      },
    },
    mutations: {
      startSession(state, payload) {
        state.username = payload.username
        state.password = payload.password
        state.profile = payload.profile
      },
      clearSession(state) {
        state.profile = null
        state.username = ""
        state.password = ""
      },
      setProfile(state, profile) {
        state.profile = profile
      },
      setUsername(state, username) {
        state.username = username
      },
      setPassword(state, password) {
        state.password = password
      },
    },
});

const app = new Vue({
    el: '#app',
    router,
    store,
});
