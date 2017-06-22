<template>
	<div class="container">
		<div class="row">
			<div class="card-panel green lighten-3">
				<span class="green-text text-darken-2">
					<h5>Minhas contas bancárias</h5>
				</span>
			</div>
			<div class="card-panel z-depth-5">
				<table class="bordered striped highlight responsive-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Agência</th>
							<th>C/C</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(o,index) in bankAccounts">
							<td>{{ o.id }}</td>
							<td>{{ o.name }}</td>
							<td>{{ o.agency }}</td>
							<td>{{ o.account }}</td>
							<td>
								<router-link :to="{ name: 'bank-account.update', params: {id: o.id}}">Editar</router-link> |
								<a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
							</td>
						</tr>
					</tbody>
				</table>
				<pagination :total-records="55"></pagination>
			</div>
			<div class="fixed-action-btn">
				<a href="#" class="btn-floating btn-large">
					<i class="large material-icons">add</i>
				</a>
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
	export default {
		components: {
			'modal': ModalComponent,
			'pagination': PaginationComponent
		},
		data() {
			return {
				bankAccounts: [],
				bankAccountToDelete: null,
				modal: {
					id: 'modal-delete'
				}
			}
		},
		mounted() {
			BankAccount.query().then((response) => {
				this.bankAccounts = response.data.data;
			});
		},
		methods: {
			destroy() {
				BankAccount.delete({id: this.bankAccountToDelete.id}).then((response) => {
					this.bankAccounts.$remove(this.bankAccountToDelete);
					this.bankAccountToDelete = null;
					Materialize.toast('Conta bancária excluída com sucesso!', 2000);
				});
			},
			openModalDelete(bankAccount){
				this.bankAccountToDelete = bankAccount;
				$('#modal-delete').modal('open');
			}
		}
	}
</script>
