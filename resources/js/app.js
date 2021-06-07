/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import App from './components/App.vue';
import Login from './components/Login.vue';

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

    },
    mutations: {

    }
});

const app = new Vue({
    el: '#app',
    router,
    store,
});
