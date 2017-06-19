import DashboardComponent from './components/dashboard.vue';
import LoginComponent from './components/login.vue';
import LogoutComponent from './components/logout.vue';
export default [{ 
		name: 'auth.login',
		path: '/login', 
		component: LoginComponent,
		meta: { auth: false }
	},{ 
		name: 'logout',
		path: '/logout', 
		component: LogoutComponent,
		meta: { auth: true }
	},{ 
		name: 'dashboard',
		path: '/dashboard', 
		component: DashboardComponent,
		meta: { auth: true }
	},{ 
		path: '*', 
		redirect: { name: 'auth.login' }
	}
];
