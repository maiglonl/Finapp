<template src="../_form.html"></template>

<script type="text/javascript">
	import billReceiveMixin from '../../../mixins/bill-mixin';
	import store from '../../../store/store';

	export default {
		mixins: [billReceiveMixin],
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
				return 'billReceive';
			},
			categoryNamespace(){
				return 'categoryRevenue';
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
			}
		},
		mounted(){
			this.initSelect2();
		}
	}
</script>

<style type="text/css" scoped src="../_style.css"></style>