/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueAxios from 'vue-axios';

window.Vue = require('vue').default;

Vue.component('tasks', require('./components/Tasks.vue').default);

Vue.use(VueAxios, axios);

const app = new Vue({
    el: '#app',
});
