<template src="../_form.html"></template>

<script type="text/javascript">
	import billPayMixin from '../../../mixins/bill-mixin';
	import store from '../../../store/store';
	import Bill from '../../../models/bill';

	export default {
		mixins: [billPayMixin],
		created(){
			let self = this;
			this.modalOptions.options = {};
			this.modalOptions.options.ready = () => {
				self.getBill();
			};
			this.modalOptions.options.complete = () => {
				self.resetScope();
			};
			EventHub.$on(`selectedValue_${this._uid}`, this.changeCategoryId);
		},
		methods: {
			namespace(){
				return 'billPay';
			},
			categoryNamespace(){
				return 'categoryExpense';
			},
			title(){
				return 'Editar conta à pagar';
			},
			getBill(){
				this.resetScope();
				let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
				this.bill = new Bill(bill);
				let text = store.getters['bankAccount/textAutocomplete'](bill.bankAccount.data);
				this.bill.bankAccountText = text;
			}
		},
		mounted(){
			this.initSelect2();
		}
	}
</script>

<style type="text/css" scoped src="../_style.css"></style>