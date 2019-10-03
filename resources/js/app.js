/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from "vue";
import App from './components/App.vue';
import router from './router';
import Gate from './Gate';
import store from './store';
Vue.prototype.$gate = new Gate(window.user);


window.Vue = require('vue');
import '../sass/app.scss';

require('./bootstrap');

import jQuery from 'jquery';
window.$ = window.jQuery = require('jquery');


import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

import VueEditor  from 'vue2-editor';
Vue.use(VueEditor);

import Vue2Filters from 'vue2-filters';
Vue.use(Vue2Filters);

import Datepicker from 'vuejs-datepicker';
Vue.use(Datepicker);

import StarRating from 'vue-star-rating';

import HotelDatePicker from 'vue-hotel-datepicker'
Vue.use(HotelDatePicker);

import moment from 'moment';

Vue.filter('myDate', function(created) {
  return moment(created).format('MMMM Do YYYY');
})


Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('star-rating', StarRating);

window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
})
