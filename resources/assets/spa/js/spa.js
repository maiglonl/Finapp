import localStorage from './services/localStorage.js';
import appConfig from './services/appConfig.js';

require('materialize-css');
window.Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);

Vue.http.options.root = appConfig.api_url;

require('./services/interceptors');

var router = require('./router').default;
Vue.component('app', require('./components/app.vue'));

window.EventHub = new Vue();

const app = new Vue({
	el: '#spaApp',
	router
});
