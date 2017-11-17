<template src="../_form.html"></template>

<script type="text/javascript">
	import billReceiveMixin from '../../../mixins/bill-mixin';

	export default {
		mixins: [billReceiveMixin],
		methods: {
			namespace(){
				return 'billReceive';
			},
			categoryNamespace(){
				return 'categoryRevenue';
			},
			title(){
				return 'Nova conta à receber';
			},
			changeCategoryId(newId){
				let newVal = newId !== 0 ? newId : null;
				this.bill.category_id = newId;
			}
		},
		created(){
			EventHub.$on(`selectedValue_${this._uid}`, this.changeCategoryId);
		}
	}
</script>