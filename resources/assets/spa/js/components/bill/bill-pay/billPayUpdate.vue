<template src="../_form.html"></template>

<script type="text/javascript">
	import billPayMixin from '../../../mixins/bill-mixin';
	import store from '../../../store/store';

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
				let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
				this.bill = {
					id: bill.id,
					date_due: bill.date_due,
					name: bill.name,
					value: bill.value,
					done: bill.done
				};
			},
			changeCategoryId(newId){
				let newVal = newId !== 0 ? newId : null;
				this.bill.category_id = newId;
			}
		}
	}
</script>