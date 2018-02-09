import {Statement} from '../services/resources';
import SearchOptions from '../services/search-options';
import _ from 'lodash';	

const state = {
	statements: [],
	statementData: {
		count: 0,
		revenues: {total: 0},
		expenses: {total: 0}
	},
	searchOptions: new SearchOptions('bankAccount')
};

const mutations = {
	set(state, statements){
		state.statements = statements;
	},
	setStatementData(state, statementData){
		state.statementData = statementData;
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
	query(context){
		let searchOptions = context.state.searchOptions;
		return Statement.query(searchOptions.createOptions()).then((response) => {
			context.commit('set', response.data.data.statements.data);
			context.commit('setPagination',response.data.data.statements.meta.pagination);
			context.commit('setStatementData',response.data.data.statement_data);
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
	}
};

const module = {
	namespaced: true,
	state, 
	mutations, 
	actions
}

export default module;