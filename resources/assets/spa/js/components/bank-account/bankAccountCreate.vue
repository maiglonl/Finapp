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
				title: "Nova conta bancária"
			}
		},
		created(){
			this.getBanks();
		},
		methods: {
			submit(){
				BankAccount.save({}, this.bankAccount).then(() => {
					Materialize.toast('Conta bancária criada com sucesso!', 2000);
					this.$router.replace({name: 'bank-account.list'});
				})
			},
			getBanks(){
				Bank.query().then((response) => {
					this.banks = response.data.data;
				});
			}
		}
	}
</script>