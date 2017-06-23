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
									<i class="material-icons right" v-if="order.key==key">
										{{ order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
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
					:per-page="pagination.per_page" 
					:total-records="pagination.total"
					:current_page="pagination.current_page">
				</pagination>
			</div>
			<div class="fixed-action-btn">
				<router-link :to="{ name: 'bank-account.create' }" class="btn-floating btn-large">
					<i class="large material-icons">add</i>
				</router-link>
			</div>

			<modal :modal="modal" v-if="bankAccountToDelete">
				<div slot="content">
					<h4>Mensagem de confirmação</h4>
					<p>Deseja excluir a conta?</p>
					<div class="divider"></div>
					<p>Nome: <strong>{{ bankAccountToDelete.name }}</strong></p>
					<p>Agência: <strong>{{ bankAccountToDelete.agency }}</strong></p>
					<p>C/C: <strong>{{ bankAccountToDelete.account }}</strong></p>
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
	export default {
		components: {
			'modal': ModalComponent,
			'pagination': PaginationComponent,
			'page-title': PageTitleComponent,
			'search': SearchComponent
		},
		data() {
			return {
				bankAccounts: [],
				bankAccountToDelete: null,
				modal: {
					id: 'modal-delete'
				},
				pagination: {
					current_page: 1,
					per_page: 0,
					total: 0	
				},
				search: "",
				order: {
					key: 'id',
					sort: 'asc'
				},
				current_page: 1,
				table: {
					headers: {
						id: { label: '#', width: '10%' },
						name: { label: 'Nome',  width: '30%' },
						agency: { label: 'Agência',  width: '10%' },
						account: { label: 'Conta',  width: '10%' },
						'banks:bank_id|banks.name': {label: 'Banco', width: '15%' },
						'default': { label: 'Padrão',  width: '10%' },
					}
				}
			}
		},
		mounted() {
			this.getBankAccounts();
		},
		methods: {
			destroy() {
				BankAccount.delete({id: this.bankAccountToDelete.id}).then((response) => {
					let self = this;
					this.bankAccounts = this.bankAccounts.filter(function (bankAccount) {
						return self.bankAccountToDelete.id != bankAccount.id;
					});
					this.bankAccountToDelete = null;
					if(this.bankAccounts.length === 0 && this.current_page > 1){
						this.current_page--;
						this.getBankAccounts();
					}
					Materialize.toast('Conta bancária excluída com sucesso!', 2000);					
				});
			},
			openModalDelete(bankAccount){
				this.bankAccountToDelete = bankAccount;
				$('#modal-delete').modal('open');
			},
			getBankAccounts(){
				BankAccount.query({
					page: this.current_page,
					orderBy: this.order.key,
					sortedBy: this.order.sort,
					search: this.search,
					include: 'bank'
				}).then((response) => {
					this.bankAccounts = response.data.data;
					this.pagination = response.data.meta.pagination;
				});
			},
			changePage(page){
				if(page != this.current_page){
					this.current_page = page;
					this.getBankAccounts();
				}
			},
			sortBy(key){
				this.order.key = key;
				this.order.sort = this.order.sort == 'asc' ? 'desc' : 'asc';
				this.getBankAccounts();
			},
			filter(model){
				this.current_page = 1;
				this.search = model;
				this.getBankAccounts();
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
