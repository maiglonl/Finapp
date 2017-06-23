<template src="./_form.html"></template>

<script type="text/javascript">
	import {BankAccount, Bank} from '../../services/resources';
	import PageTitle from '../pageTitle.vue';
	export default {
		components: {
			'page-title': PageTitle
		},
		data(){
			return {
				bankAccount: {
					name: '',
					agency: '',
					account: '',
					bank_id: '',
					'default': false
				},
				banks: [],
				title: "Editar conta bancária"
			}
		},
		created(){
			this.getBanks();
			this.getBankAccounts(this.$route.params.id);
		},
		methods: {
			submit(){
				let id = this.$route.params.id;
				BankAccount.update({id: id}, this.bankAccount).then(() => {
					Materialize.toast('Conta bancaria atualizada com sucesso!', 2000);
					this.$router.replace({name: 'bank-account.list'});
				})
			},
			getBanks(){
				Bank.query().then((response) => {
					this.banks = response.data.data;
				});
			},
			getBankAccounts(id){
				BankAccount.get({id: id}).then((response) => {
					this.bankAccount = response.data.data;
					this.title += " "+this.bankAccount.name;
				});
			}
		}
	}
</script>