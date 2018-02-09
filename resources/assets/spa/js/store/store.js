
import Vuex from 'vuex';
import auth from './auth';
import bankAccount from './bank-account';
import bank from './bank';
import cashFlow from './cash-flow';
import statement from './statement';
import categoryModule from './category';
import billModule from './bill';

import {CategoryRevenue, CategoryExpense} from '../services/resources'
import {BillPay, BillReceive} from '../services/resources'

let categoryRevenue = categoryModule();
let categoryExpense = categoryModule();
categoryRevenue.state.resource = CategoryRevenue;
categoryExpense.state.resource = CategoryExpense;

let billPay = billModule();
let billReceive = billModule();
billPay.state.resource = BillPay;
billReceive.state.resource = BillReceive;

export default new Vuex.Store({
	modules: {
		auth, 
		bankAccount, 
		bank,
		categoryRevenue,
		categoryExpense,
		billPay,
		billReceive,
		cashFlow,
		statement
	}
});