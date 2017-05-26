
import LoginComponent from './components/login.vue';
export default [{ 
		name: 'auth.login',
		path: '/login', 
		component: LoginComponent
	},{ 
		path: '*', 
		redirect: { name: 'auth.login' }
	}
];
