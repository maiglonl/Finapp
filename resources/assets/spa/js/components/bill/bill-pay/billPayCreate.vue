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
		},
		mounted(){
			this.initSelect2();
		}
	}
</script>

<style type="text/css" scoped src="../_style.css"></style>