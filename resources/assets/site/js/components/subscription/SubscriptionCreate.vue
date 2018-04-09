<template src="./_template.html"></template>

<script type="text/javascript">
	export default {
		props: ['plan', 'csrfToken', 'action'],
		data(){
			return {
				payment_type: 'credit_card',
				token_payment: null,
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
			Iugu.setAccountID("87E9149D78CA4BD3AA24522DCD0D8E02");
			Iugu.setTestMode(true);
			Iugu.setup();
		},
		methods: {
			submit(){
				if(this.payment_type == 'credit_card'){
					let expirationArray = this.credit_card.expiration.split('/');
					let creditCard = Iugu.CreditCard(
						this.credit_card.number,
						expirationArray[0],
						expirationArray[1],
						this.credit_card.first_name,
						this.credit_card.last_name,
						this.credit_card.cvv
					);
					let self = this;
					Iugu.createPaymentToken(creditCard, response => {
						if(response.errors){
							Materialize.toast("Erro ao processar cartão de crédito. Tente novamente!", 2000);
						}else{
							self.token_payment = response.id;
							setTimeout(() => {
								$('#subscription-form')[0].submit();
							});
						}
					});
				}else{
					$('#subscription-form')[0].submit();
				}
			},
		}
	};
</script>

