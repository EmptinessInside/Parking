/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';

import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import AppComponent from './components/App';
import ClientCompomemt from './components/client/Client';
import ClientForm from "./components/client/ClientForm";
import CarForm from "./components/client/CarForm";

require('./bootstrap');

Vue.use(VueRouter)
Vue.use(BootstrapVue)

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-component', require('./components/App.vue').default);
Vue.component('client_form', require('./components/client/ClientForm').default);
Vue.component('car_form', require('./components/client/CarForm').default);

const routes = [
    { path: '/', component: AppComponent },
    { path : '/create_client', component : ClientCompomemt , children: [
            {
                path: 'client_form',
                components : {
                    client_form : ClientForm
                },
            },
            {
                path: 'car_form',
                components : {
                    car_form : CarForm
                },
            },
        ]},

]

const router = new VueRouter({
    routes
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
