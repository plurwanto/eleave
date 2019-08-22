
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('pegawai', require('./components/pegawai/index.vue'));

/**
* Vue Router
*
* @link http://router.vuejs.org/en/installation.html
*/
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// define routes for users
const routes = [
				{
				  path: '/pegawai',
				  name: 'pegawaiIndex',
				  component: require('./components/pegawai/index.vue')
				}
]

const router = new VueRouter({ routes });

const app = new Vue({
  router
}).$mount('#app');
