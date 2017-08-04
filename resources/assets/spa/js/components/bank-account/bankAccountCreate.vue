<template src="./_form.html"></template>

<script type="text/javascript">
	import {BankAccount} from '../../services/resources';
	import PageTitle from '../pageTitle.vue';
	import store from '../../store/store';
	import 'materialize-autocomplete';

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
				title: "Nova conta bancária"
			}
		},
		computed: {
			banks(){ return store.state.bank.banks; }
		},
		created(){
			this.getBanks();
		},
		methods: {
			submit(){
				store.dispatch('bankAccount/save', this.bankAccount).then((response) => {
					Materialize.toast('Conta bancária criada com sucesso!', 2000);
					this.$router.replace({name: 'bank-account.list'});
				});
			},
			getBanks(){
				store.dispatch('bank/query').then((response) => {
					this.initAutocomplete();
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
							let mapBanks = store.getters['bank/mapBanks'];
							let banks = mapBanks(value);
							callback(value, banks);
						},
						onSelect(item){
							self.bankAccount.bank_id = item.id;
							self.bank = {id: item.id, name: item.text};
						}
					});
				});
			}
		}
	}
</script>