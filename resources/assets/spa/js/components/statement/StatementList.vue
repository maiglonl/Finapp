<template>
	<div class="container">
		<div class="row">
			<page-title><h5>Extrato</h5></page-title>
			<div class="card-panel z-depth-5">
				<search></search>
				<table class="bordered striped highlight responsive-table">
					<thead>
						<tr>
							<th v-for="(o, key) in table.headers" :width="o.width"  @click.prevent="sortBy(key)">
								<a href="#">
									{{o.label}}
									<i class="material-icons right" v-if="searchOptions.order.key == key">
										{{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
									</i>
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="o in statements">
							<td>{{ o.date | dateFormat }}</td>
							<td>{{ o.bankAccount.data.name }}</td>
							<td>{{ o.value | numberFormat }}</td>
							<td>{{ o.balance | numberFormat }}</td>
						</tr>
					</tbody>
				</table>
				<pagination 
					:per-page="searchOptions.pagination.per_page" 
					:total-records="searchOptions.pagination.total"
					:current-page="searchOptions.pagination.current_page">
				</pagination>
			</div>
			<table class="grey-text text-darken-2">
				<tbody class="left">
					<tr>
						<td><strong>Total de Recebimentos</strong></td>
						<td><strong>{{ statementData.revenues.total }}</strong></td>
					</tr>
					<tr>
						<td><strong>Total de Pagamentos</strong></td>
						<td><strong>{{ statementData.expenses.total }}</strong></td>
					</tr>
					<tr>
						<td><strong>Número de Lançamentos</strong></td>
						<td><strong>{{ statementData.count }}</strong></td>
					</tr>
					<tr>
						<td><strong>Total do Período</strong></td>
						<td><strong>{{ statementData.revenues.total + statementData.expenses.total }}</strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	import PaginationComponent from '../pagination.vue';
	import PageTitleComponent from '../pageTitle.vue';
	import SearchComponent from '../search.vue';
	import store from '../../store/store';
	import moment from 'moment';

	export default {
		components: {
			'pagination': PaginationComponent,
			'page-title': PageTitleComponent,
			'search': SearchComponent
		},
		data() {
			return {
				table: {
					headers: {
						date: { label: 'Data',  width: '10%' },
						'bank_account:bank_account_id|bank_accounts.name': { label: 'Conta bacária',  width: '13%' },
						value: { label: 'Valor',  width: '20%' },
						balance: { label: 'Saldo',  width: '20%' },
					}
				}
			}
		},
		computed:{
			statements(){ return store.state.statement.statements; },
			statementData(){ return store.state.statement.statementData; },
			searchOptions(){ return store.state.statement.searchOptions; },
		},
		mounted() {
			store.commit('statement/setFilter', `${this.dateFilterStart()} - ${this.dateFilterEnd()}`);
			store.dispatch('statement/query');
		},
		methods: {
			changePage(page){
				store.dispatch('statement/queryWithPagination', page);
			},
			sortBy(key){
				store.dispatch('statement/queryWithSortBy', key);
			},
			filter(filter){
				store.dispatch('statement/queryWithFilter', filter);
			},
			dateFilterStart(){
				let date = new Date();
				date.setDate(1);
				return moment(date).format("DD/MM/YYYY");
			},
			dateFilterEnd(){
				return moment(new Date).endOf('month').format("DD/MM/YYYY");
			}
		},
		created: function () {
			EventHub.$on('pageChanged', this.changePage);
			EventHub.$on('searchSubmit', this.filter);
		},
		watch:{
			current_page(newValue){
				EventHub.$emit('pageChanged', newValue);
			}
		}
	}
</script>
