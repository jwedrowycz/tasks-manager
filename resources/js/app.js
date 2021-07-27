require('./bootstrap');
import moment from "moment";
import Vue from "vue";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Vue = require('vue').default;

Vue.component('task-component', require('./components/TaskComponent.vue').default);
Vue.component('login', require('./components/auth/Login.vue').default);

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

const app = new Vue({
    el: '#app',
});

