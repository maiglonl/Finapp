import {BankAccount} from '../services/resources';

const state = {
	bankAccounts: [],
	bankAccountToDelete: null,
};

const mutations = {
	set(state, bankAccounts){
		state.bankAccounts = bankAccounts;
	},
	setDelete(state, bankAccounts){
		state.bankAccountToDelete = bankAccounts;
	},
	'delete'(state){
		let index = state.bankAccounts.indexOf(state.bankAccountToDelete);
		state.bankAccounts.splice(index, 1);
	}
};

const actions = {
	query(context, {pagination, order, search}){
		BankAccount.query({
			page: pagination.current_page,
			orderBy: order.key,
			sortedBy: order.sort,
			search: search,
			include: 'bank'
		}).then((response) => {
			context.commit('set', response.data.data);
			this.pagination = response.data.meta.pagination;
		});
	}
};

const module = {
	state, mutations, actions
}

export default module;