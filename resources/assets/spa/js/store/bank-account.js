import {BankAccount} from '../services/resources';
import SearchOptions from '../services/search-options';
import _ from 'lodash';	

const state = {
	bankAccounts: [],
	lists: [],
	bankAccountDelete: null,
	searchOptions: new SearchOptions('bank'),
};

const mutations = {
	set(state, bankAccounts){
		state.bankAccounts = bankAccounts;
	},
	setLists(state, lists){
		state.lists = lists
	},
	setDelete(state, bankAccount){
		state.bankAccountDelete = bankAccount;
	},
	'delete'(state){
		let index = state.bankAccounts.indexOf(state.bankAccountDelete);
		state.bankAccounts.splice(index, 1);
	},
	setOrder(state, key){
		state.searchOptions.order.key = key;
		let sort = state.searchOptions.order.sort;
		state.searchOptions.order.sort = sort == 'asc' ? 'desc' : 'asc';
	},
	setCurrentPage(state, currentPage){
		state.searchOptions.pagination.current_page = currentPage;
	},
	setFilter(rstate, filter){
		state.searchOptions.search = filter;
	},
	setPagination(state, pagination){
		state.searchOptions.pagination = pagination;
	}
};

const actions = {
	lists(context){
		return BankAccount.lists().then(response => {
			context.commit('setLists', response.data);
		});
	},
	query(context){
		let searchOptions = context.state.searchOptions;
		return BankAccount.query(searchOptions.createOptions()).then((response) => {
			context.commit('set', response.data.data);
			context.commit('setPagination',response.data.meta.pagination);
		});
	},
	queryWithSortBy(context, key){
		context.commit('setOrder', key);
		context.dispatch('query');
	},
	queryWithPagination(context, currentPage){
		context.commit('setCurrentPage', currentPage);
		context.dispatch('query');
	},
	queryWithFilter(context, filter){
		context.commit('setFilter', filter);
		context.dispatch('query');
	},
	'delete'(context){
		let id = context.state.bankAccountDelete.id;
		return BankAccount.delete({id: id}).then((response) => {
			context.commit('delete');
			context.commit('setDelete', null);

			let bankAccounts = context.state.bankAccounts;
			let pagination = context.state.searchOptions.pagination;

			if(bankAccounts.length === 0 && pagination.current_page > 1){
				context.commit('setCurrentPage', pagination.current_page--);
			}

			return response;
		});
	},
	save(context, bankAccount){
		return BankAccount.save({}, bankAccount).then((response) => {
			return response;
		});
	},
	update(context, data){
		return BankAccount.update({id: data.id}, data.bankAccount).then((response) => {
			return response;
		});
	}
};

const getters = {
	filterBankAccountByName(state){
		return (name) => {
			let bankAccounts = _.filter(state.lists, (o) => {
				return _.includes(o.name.toLowerCase(), name.toLowerCase());
			});
			return bankAccounts;
		}
	},
	mapBankAccounts(state, getters){
		return (name) => {
			let bankAccounts = getters.filterBankAccountByName(name);
			return bankAccounts.map((o) => {
				return {id: o.id, text: `${o.name} - ${o.account}`};
			});
		}
	}
};

const module = {
	namespaced: true,
	state, 
	mutations, 
	actions,
	getters
}

export default module;