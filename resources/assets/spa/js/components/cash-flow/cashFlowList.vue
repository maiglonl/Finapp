<template src="./_cashFlowList.html">
	
</template>

<script>
	import PageTitleComponent from '../pageTitle.vue';
	import store from '../../store/store';
	import Papaparse from 'papaparse';

	export default {
		components: {
			'page-title': PageTitleComponent
		},
		computed:{
			cashFlows(){ 
				return store.state.cashFlow.cashFlows; 
			},
			monthsList(){ 
				return this.cashFlows.months_list; 
			},
			hasFirstMonthYear(){ 
				return store.getters['cashFlow/hasFirstMonthYear']; 
			},
			firstMonthYear(){ 
				return store.state.cashFlow.firstMonthYear; 
			},
			firstBalance(){ 
				return store.getters['cashFlow/firstBalance']; 
			},
			secondBalance(){ 
				return store.getters['cashFlow/secondBalance']; 
			},
			monthsListBalanceFinal(){ 
				return store.getters['cashFlow/monthsListBalanceFinal'];
			},
			monthsListBalancePrevious(){ 
				return store.getters['cashFlow/monthsListBalancePrevious'];
			},
			hasCashFlows(){ 
				return store.getters['cashFlow/hasCashFlows']; 
			},
			balanceBeforeFirstMonth(){ 
				return this.cashFlows.balance_before_first_month; 
			},
			categoriesMonths(){
				return this.cashFlows.categories_months;
			}
		},
		mounted() {
			store.commit('cashFlow/setFirstMonthYear', '2018-03-01');
			store.dispatch('cashFlow/query');
		},
		methods: {
			balance(index){
				return store.getters['cashFlow/balance'](index);
			},
			categoryTotal(category, monthYear){
				return store.getters['cashFlow/categoryTotal'](category, monthYear);
			},
			isCurrentMonthYear(monthYear){
				return this.$options.filters.monthYear(new Date) == this.$options.filters.monthYear(monthYear);
			},
			getCsv(){
				let result = [];
				result.push([]);
				$("table thead .text-csv").each(function(key, item){
					result[0].push($(item).text().trim());
				});
				$('table tbody tr').each(function(key, tr) {
					result.push([]);
					$(tr).find('.text-csv').each(function(index, el) {
						result[result.length-1].push($(el).text().trim());
					});
				});
				return Papaparse.unparse(result);
			},
			downloadCsv(){
				let anchor = $('<a/>');
				anchor.css('display', 'none');
				anchor.attr('download', 'fluxo de caixa.csv')
					.attr('target', '_blank')
					.attr('href', `data:text/csv;charset=UTF-8,${encodeURIComponent(this.getCsv())}`);
				anchor.html("Download CSV");
				$('body').append(anchor);
				anchor[0].click();
				anchor.remove();
			}
		}
	}
</script>

<style type="text/css" scoped>
	th{
		border-radius: 0px;
	}
</style>