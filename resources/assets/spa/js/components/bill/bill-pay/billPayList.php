<template>
	<div class="row">
		<page-title>
			<h5>Minhas contas à pagar</h5>
		</page-title>
		<div class="card-panel z-depth-5">
			<search></search>
			<table class="bordered striped highlight responsive-table">
				<thead>
					<tr>
						<th v-for="(o, key) in table.headers" :width="o.width">
							<a href="#" @click.prevent="sortBy(key)">
								{{o.label}}
								<i class="material-icons right" v-if="searchOptions.order.key == key">
									{{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
								</i>	
							</a>
						</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(o, index) in bills">
						<td>{{ o.id }}</td>
						<td>{{ o.date_due }}</td>
						<td>{{ o.name }}</td>
						<td>{{ o.value }}</td>
						<td>
							<a href="#" @click.prevent="openModalEdit(index)">Editar</a>
							<a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
						</td>
					</tr>
				</tbody>
			</table>
			<pagination 
				:per-page="searchOptions.pagination.per_page" 
				:total-records="searchOptions.pagination.total"
				:current-page="searchOptions.pagination.current_page">
			</pagination>
		</div>
		<div class="fixed-action-btn">
			<a href="#" class="btn-floating btn-large" @click.prevent="openModalCreate()">
				<i class="large material-icons">add</i>
			</a>
		</div>
	</div>

	<bill-pay-create :modal-options="modalCreate"></bill-pay-create>
	<bill-pay-update :index="idexUpdate" :modal-options="modalEdit"></bill-pay-update>

	<modal :modal="modalDelete" v-if="billPayDelete">
		<div slot="content">
			<h4>Mensagem de confirmação</h4>
			<p>Deseja excluir a conta?</p>
			<div class="divider"></div>
			<p>Nome: <strong>{{ billPayDelete.name }}</strong></p>
			<p>Vencimento: <strong>{{ billPayDelete.date_due }}</strong></p>
			<p>Valor: <strong>{{ billPayDelete.value }}</strong></p>
			<div class="divider"></div>
		</div>
		<div slot="footer">
			<button class="btn btn-flat waves-effect green lighten-2 modal-action modal-close" @click="destroy()">OK</button>
			<button class="btn btn-flat waves-effect waves-red modal-action modal-close">Cancelar</button>
		</div>
	</modal>
</template>

<script type="text/javascript">
	import ModalComponent from '../../../../../_default/components/Modal.vue';
	import PaginationComponent from '../../Pagination.vue';
	import PageTitleComponent from '../../PageTitle.vue';
	import SearchComponent from '../../Search.vue';
	import BillPayCreateComponent from './BillPayCreate.vue';
	import BillPayUpdateComponent from './BillPayUpdate.vue';
	import store from '../../../store/store';

	export default {
		components: {
			'modal': ModalComponent,
			'pagination': PaginationComponent,
			'page-title': PageTitleComponent,
			'search': SearchComponent,
			'bill-pay-create': BillPayCreateComponent,
			'bill-pay-update': BillPayUpdateComponent
		},
		data() {
			return {
				modalDelete: {
					id: 'modal_delete'
				},
				modalCreate: {
					id: 'modal-create'
				},
				modalEdit: {
					id: 'modal-edit'
				},
				indexUpdate: 0,
				table: {
					headers: {
						id: {label: '#', width: '7%'},
						date_due: {label: 'Vencimento', width: '30%'},
						name: {label: 'Nome', width: '30%'},
						value: {label: 'Valor', width: '13%'},
					}
				}
			}
		},
		computed: {
			bills(){
				return store.state.billPay.bills;
			},
			searchOptions(){
				return store.state.billPay.searchOptions;
			},
			search: {
				get(){
					return store.state.billPay.searchOptions.search;
				},
				set(value){
					store.commit('billPay/setFilter', value);
				}
			},
			billPayDelete(){
				return store.state.billPay.billDelete;
			}
		},
		created(){
			store.dispatch('billPay/query');
			EventHub.$on('pageChanged', this.changePage);
			EventHub.$on('searchSubmit', this.filter);
		},
		watch:{
			current_page(newValue){
				EventHub.$emit('pageChanged', newValue);
			}
		},
		methods: {
			destroy(){
				store.dispatch('billPay/delete').then((response) => {
					Materialize.toast('Conta excluída com sucesso!', 2000);
				});
			},
			openModalCreate(){
				$('#modal-create').modal('open');
			},
			openModalEdit(index){
				this.indexUpdate = index;
				$('#modal-edit').modal('open');
			},
			openModalDelete(billPay){
				store.commit('billPay/setDelete', billPay);
				$('#modal-delete').modal('open');
			},
			sortBy(key){
				store.dispatch('billPay/queryWithSortBy', key);
			},
			filter(){
				store.dispatch('billPay/queryWithFilter');
			},
		}
	}
</script>