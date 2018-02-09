<template>
	<div class="row">
		<div class="col s8">
			<div class="row"></div>
			<div class="row"></div>
		</div>
		<div class="col s4">
			<ul class="collection">
				<li class="collection-item avatar" v-for="o in bankAccounts">
					<img :src="o.bank.data.logo" class="circle">
					<span class="title"><strong>{{ o.name }}</strong></span>
					<p>{{ o.balance | numberFormat(true) }}</p>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import store from '../store/store';
	export default {
		computed:{
			bankAccounts(){
				return store.state.bankAccount.bankAccounts;
			},
			clientId(){
				return store.state.auth.user.client_id;
			}
		},
		created(){
			this.store();
			this.echo();
		},
		methods: {
			store(){
				store.commit('bankAccount/setOrder', 'balance');
				store.commit('bankAccount/setSort', 'desc');
				store.commit('bankAccount/setLimit', 5);
				store.dispatch('bankAccount/query');
			},
			echo(){
				Echo.private(`client.${this.clientId}`)
					.listen('.Finapp.Events.BankAccountBalanceUpdatedEvent', (event) => {
						console.log('event launched');
					})
			}
		}
	}
</script>
