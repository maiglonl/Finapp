<template src="./_template.html"></template>

<script type="text/javascript">
	export default {
		props: ['plan', 'csrf-token', 'action'],
		data(){
			return {
				payment_type: 'credit_card',
				credit_card: {
					number: '4111111111111111',
					cvv: '123',
					expiration: '12/18',
					first_name: 'Nome',
					last_name: 'Sobrenome'
				}
			};
		},
		mounted(){
			//$('.modal').modal();
		},
		methods: {
			submit(){
				//$("#logout-form").submit();
			},
		}
	};
</script>

