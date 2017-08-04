<template>
	<div class="container">
		<div class="row">
			<page-title>
				<h5>Minhas contas bancárias</h5>
			</page-title>
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
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(o,index) in bankAccounts">
							<td>{{ o.id }}</td>
							<td>{{ o.name }}</td>
							<td>{{ o.agency }}</td>
							<td>{{ o.account }}</td>
							<td><img :src="o.bank.data.logo" class="bank-logo"/>{{ o.bank.data.name }}</td>
							<td>
								<i class="material-icons green-text" v-if="o.default">check</i>
							</td>
							<td>
								<router-link :to="{ name: 'bank-account.update', params: {id: o.id}}">Editar</router-link> |
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
				<router-link :to="{ name: 'bank-account.create' }" class="btn-floating btn-large">
					<i class="large material-icons">add</i>
				</router-link>
			</div>

			<modal :modal="modal" v-if="bankAccountDelete">
				<div slot="content">
					<h4>Mensagem de confirmação</h4>
					<p>Deseja excluir a conta?</p>
					<div class="divider"></div>
					<p>Nome: <strong>{{ bankAccountDelete.name }}</strong></p>
					<p>Agência: <strong>{{ bankAccountDelete.agency }}</strong></p>
					<p>C/C: <strong>{{ bankAccountDelete.account }}</strong></p>
					<div class="divider"></div>
				</div>
				<div slot="footer">
					<button class="btn btn-flat waves-effect green lighten-2 modal-action modal-close" @click="destroy()">OK</button>
					<button class="btn btn-flat waves-effect waves-red modal-action modal-close">Cancelar</button>
				</div>
			</modal>
		</div>
	</div>
</template>

<script>
	import {BankAccount} from '../../services/resources';
	import ModalComponent from '../../../../_default/components/Modal.vue';
	import PaginationComponent from '../pagination.vue';
	import PageTitleComponent from '../pageTitle.vue';
	import SearchComponent from '../search.vue';
	import store from '../../store/store';

	export default {
		components: {
			'modal': ModalComponent,
			'pagination': PaginationComponent,
			'page-title': PageTitleComponent,
			'search': SearchComponent
		},
		data() {
			return {
				modal: {
					id: 'modal-delete'
				},
				table: {
					headers: {
						id: { label: '#', width: '12%' },
						name: { label: 'Nome',  width: '22%' },
						agency: { label: 'Agência',  width: '12%' },
						account: { label: 'Conta',  width: '12%' },
						'banks:bank_id|banks.name': {label: 'Banco', width: '15%' },
						'default': { label: 'Padrão',  width: '12%' },
					}
				}
			}
		},
		computed:{
			bankAccounts(){ return store.state.bankAccount.bankAccounts; },
			searchOptions(){ return store.state.bankAccount.searchOptions; },
			bankAccountDelete(){ return store.state.bankAccount.bankAccountDelete; }
		},
		mounted() {
			store.dispatch('bankAccount/query');
		},
		methods: {
			destroy() {
				store.dispatch('bankAccount/delete').then((response) => {
					Materialize.toast('Conta bancária excluída com sucesso!', 2000);
				});
			},
			openModalDelete(bankAccount){
				console.log(1);
				store.commit('bankAccount/setDelete', bankAccount);
				console.log(this.bankAccountDelete);
				$('#modal-delete').modal('open');
				console.log(3);
			},
			changePage(page){
				store.dispatch('bankAccount/queryWithPagination', page);
			},
			sortBy(key){
				store.dispatch('bankAccount/queryWithSortBy', key);
			},
			filter(filter){
				store.dispatch('bankAccount/queryWithFilter', filter);
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
