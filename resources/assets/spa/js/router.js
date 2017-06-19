import VueRouter from 'vue-router';
import Auth from './services/auth';

Vue.use(VueRouter);
let routes = require('./routes').default;
let router = new VueRouter({ routes });
router.beforeEach((to, from, next)=>{
	if(to.meta.auth && !Auth.user.check){
		return router.push({name: "auth.login"});
	}
	next();
});

export default router;