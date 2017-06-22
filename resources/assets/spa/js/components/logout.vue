<template> 
	<div class="container">
		<div class="row">
			<div class="col s8 offset-s2 z-depth-2 card-panel">
				<h5 class="center">Efetuando Logout...</h5>
				<div class="progress">
					<div class="indeterminate"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Auth from '../services/auth';
	export default {
		mounted() {
			setTimeout(() => {
				this.logout();
			}, 1000);
		},
		methods: {
			logout(){
				let goToLogin = () => this.$router.push({ name: 'auth.login' });
				Auth.logout()
					.then(goToLogin)
					.catch(goToLogin);
			}
		}
	};
</script>