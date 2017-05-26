require('materialize-css');
window.Vue = require('vue');
require('vue-resource');

Vue.http.options.root = 'http://localhost:8000/api';

import VueRouter from 'vue-router';
import routes from './routes';
Vue.use(VueRouter);
Vue.component('app', require('./components/app.vue'));
let router = new VueRouter({ routes });
const app = new Vue({
	el: '#spaApp',
	router
})



/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
