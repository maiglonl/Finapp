import VueRouter from 'vue-router';
import store from './store/store';

Vue.use(VueRouter);
let routes = require('./routes').default;
let router = new VueRouter({ routes });
router.beforeEach((to, from, next)=>{
	if(to.meta.auth && !store.state.auth.check){
		return router.push({name: "auth.login"});
	}
	next();
});

export default router;