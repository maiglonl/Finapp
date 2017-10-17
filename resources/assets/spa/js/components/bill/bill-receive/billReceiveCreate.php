<template src="../_form.html"></template>

<script type="text/javascript">
	import billReceiveMixin from '../../../mixins/bill-mixin';

	export default {
		mixins: [billReceiveMixin],
		methods: {
			namespace(){
				return 'billReceive';
			},
			title(){
				return 'Nova conta à receber';
			}
		}
	}
</script>