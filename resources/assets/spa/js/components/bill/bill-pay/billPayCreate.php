<template src="../_form.html"></template>

<script type="text/javascript">
	import billPayMixin from '../../../mixins/bill-mixin';

	export default {
		mixins: [billPayMixin],
		methods: {
			namespace(){
				return 'billPay';
			},
			title(){
				return 'Nova conta à pagar';
			}
		}
	}
</script>