require('./bootstrap');
import moment from "moment";

window.Vue = require('vue').default;

Vue.component('tasks', require('./components/Tasks.vue').default);
Vue.component('create-task', require('./components/CreateTask.vue').default);

const app = new Vue({
    el: '#app',
});