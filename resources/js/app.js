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

import storage from './localStorage.js';

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
    },
  ]
});

const store = new Vuex.Store({
    state: {
      profile: null,
      token: "",
      isRememberMe: false,
      username: "",
    },
    getters: {
      isLoggedIn(state) {
        if(state.token == "" && storage.get("token") != "") {
          state.token = storage.get("token")
        }
        return state.token != ""
      },
      getProfile(state) {
        let profile = state.profile
        if(storage.has("profile")) {
          profile = JSON.parse(storage.get("profile"))
        }
        return profile
      },
      getToken(state) {
        if(state.token == "" && storage.get("token") != "") {
          state.token = storage.get("token")
        }
        return state.token
      },
      getIsRememberMe(state) {
        if(state.isRememberMe == "" && storage.get("isRememberMe") != "") {
          state.isRememberMe = storage.get("isRememberMe")
        }
        return state.isRememberMe
      },
      getUsername(state) {
        if(state.username == "" && storage.get("username") != "") {
          state.username = storage.get("username")
        }
        return state.username
      },
    },
    mutations: {
      startSession(state, payload) {
        storage.set("token", payload.token)
        storage.set("profile", JSON.stringify(payload.profile))

        state.token = payload.token
        state.profile = payload.profile
      },
      clearSession(state) {
        storage.delete("profile")
        storage.delete("token")

        state.profile = null
        state.token = ""
      },
      rememberUser(state, username) {
        storage.set("isRememberMe", true)
        storage.set("username", username)

        state.isRememberMe = true
        state.username = username
      },
      forgetUser(state) {
        storage.delete("isRememberMe")
        storage.delete("username")

        state.isRememberMe = false
        state.username = ""

      },
      setProfile(state, profile) {
        storage.set("profile", JSON.stringify(profile))
        state.profile = profile
      },
      setToken(state, token) {
        storage.set("token", token)
        state.token = token
      },
      setIsRememberMe(state, isRememberMe) {
        storage.set("isRememberMe", isRememberMe)
        state.isRememberMe = isRememberMe
      },
      setUsername(state, username) {
        storage.set("username", username)
        state.username = username
      },
    },
});

const app = new Vue({
    el: '#app',
    router,
    store,
});
