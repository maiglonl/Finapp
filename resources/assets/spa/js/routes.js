import DashboardComponent from './components/dashboard.vue';
import LoginComponent from './components/login.vue';
import LogoutComponent from './components/logout.vue';
import BankAccountListComponent from './components/bank-account/bankAccountList.vue';
import BankAccountCreateComponent from './components/bank-account/bankAccountCreate.vue';
import BankAccountUpdateComponent from './components/bank-account/bankAccountUpdate.vue';
import PlanAccountComponent from './components/category/planAccount.vue';
import BillPayListComponent from './components/bill/bill-pay/billPayList.vue';
import BillReceiveListComponent from './components/bill/bill-receive/billReceiveList.vue';
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
		name: 'plan-account',
		path: '/plan-account', 
		component: PlanAccountComponent,
		meta: { auth: true }
	},{
		path: '/bank-accounts', 
		component: { template: '<router-view></router-view>' },
		children: [
			{ 
				name: 'bank-account.list',
				path: '/', 
				component: BankAccountListComponent,
				meta: { auth: true }
			},{
				name: 'bank-account.update',
				path: '/:id/update', 
				component: BankAccountUpdateComponent,
				meta: { auth: true }
			},{
				name: 'bank-account.create',
				path: '/create', 
				component: BankAccountCreateComponent,
				meta: { auth: true }
			}
		]
	},{
		path: '/bill-pays', 
		component: { template: '<router-view></router-view>' },
		children: [
			{ 
				name: 'bill-pay.list',
				path: '/', 
				component: BillPayListComponent,
				meta: { auth: true }
			}
		]
	},{
		path: '/bill-receives', 
		component: { template: '<router-view></router-view>' },
		children: [
			{ 
				name: 'bill-receive.list',
				path: '/', 
				component: BillReceiveListComponent,
				meta: { auth: true }
			}
		]
	},{ 
		path: '*', 
		redirect: { name: 'auth.login' }
	}
];
