import DashboardComponent from './components/dashboard.vue';
import LoginComponent from './components/login.vue';
import LogoutComponent from './components/logout.vue';
import BankAccountListComponent from './components/bank-account/bankAccountList.vue';
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
		path: '/bank-accounts', 
		component: { template: '<router-view></router-view>' },
		children: [
			{ 
				name: 'bank-account.list',
				path: '/', 
				component: BankAccountListComponent,
				//meta: { auth: true }
			},{
				name: 'bank-account.update',
				path: '/:id/update', 
				component: BankAccountListComponent,
				//meta: { auth: true }
			}
		]
	},{ 
		path: '*', 
		redirect: { name: 'auth.login' }
	}
];
