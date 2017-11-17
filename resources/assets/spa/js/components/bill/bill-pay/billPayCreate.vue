<template src="../_form.html"></template>

<script type="text/javascript">
	import billPayMixin from '../../../mixins/bill-mixin';

	export default {
		mixins: [billPayMixin],
		methods: {
			namespace(){
				return 'billPay';
			},
			categoryNamespace(){
				return 'categoryExpense';
			},
			title(){
				return 'Nova conta à pagar';
			},
			changeCategoryId(newId){
				let newVal = newId !== 0 ? newId : null;
				this.bill.category_id = newId;
			},
			validateBeforeSubmit() {
				this.$validator.validateAll().then((result) => {
					if (result) {
						// eslint-disable-next-line
						alert('From Submitted!');
						return;
					}

					alert('Correct them errors!');
				});
			}
		},
		created(){
			EventHub.$on(`selectedValue_${this._uid}`, this.changeCategoryId);
		}
	}
</script>