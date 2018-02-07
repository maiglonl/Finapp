<template src="./_cashFlowList.html">
	
</template>

<script>
	import PageTitleComponent from '../pageTitle.vue';
	import store from '../../store/store';

	export default {
		components: {
			'page-title': PageTitleComponent
		},
		computed:{
			cashFlows(){ return store.state.cashFlow.cashFlows; },
			monthsList(){ return this.cashFlows.months_list; },
			hasFirstMonthYear(){ return store.getters['cashFlow/hasFirstMonthYear']; },
			firstMonthYear(){ return store.state.cashFlow.firstMonthYear; },
			firstBalance(){ return store.getters['cashFlow/firstBalance']; },
			secondBalance(){ return store.getters['cashFlow/secondBalance']; },
			monthsListBalanceFinal(){ return store.getters['cashFlow/monthsListBalanceFinal']; },
			hasCashFlows(){ return store.getters['cashFlow/hasCashFlows']; },
		},
		mounted() {
			store.commit('cashFlow/setFirstMonthYear', new Date());
			store.dispatch('cashFlow/query');
		},
		methods: {
			balance(index){
				return store.getters['cashFlow/balance'](index);
			}
		}
	}
</script>
