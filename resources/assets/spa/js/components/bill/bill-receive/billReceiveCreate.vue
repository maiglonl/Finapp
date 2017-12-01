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