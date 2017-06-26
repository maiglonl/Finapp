<template src="./_form.html"></template>

<script type="text/javascript">
	import {BankAccount, Bank} from '../../services/resources';
	import PageTitle from '../pageTitle.vue';
	import 'materialize-autocomplete';
	import _ from 'lodash';	

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
					bank: '',
					'default': false
				},
				bank: {
					name: ""
				},
				banks: [],
				title: "Editar conta bancária"
			}
		},
		created(){
			this.getBankAccount(this.$route.params.id);
			this.getBanks();
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
					this.initAutocomplete();
				});
			},
			getBankAccount(id){
				BankAccount.get({id: id, include: 'bank'}).then((response) => {
					this.bankAccount = response.data.data;
					this.title += " "+this.bankAccount.name;
					this.bank = response.data.data.bank.data;
				});
			},
			initAutocomplete(){
				let self = this;
				$(document).ready(() => {
					$("#bank-id").materialize_autocomplete({
						limit: 10,
						multiple: {
							enabled: false
						},
						dropdown: {
							el: '#bank-id-dropdown'
						},
						getData(value, callback){
							let banks = self.filterBankByName(value);
							banks = banks.map((o) => {
								return {id: o.id, text: o.name}
							});
							callback(value, banks);
						},
						onSelect(item){
							self.bankAccount.bank_id = item.id;
						}
					});
				});
			},
			filterBankByName(name){
				let banks = _.filter(this.banks, (o) => {
					return _.include(o.name.toLowerCase(), name.toLowerCase());
				});
				return banks
			}
		}
	}
</script>