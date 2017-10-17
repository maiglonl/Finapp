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
		},
		methods: {
			namespace(){
				return 'billReceive';
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
		}
	}
</script>