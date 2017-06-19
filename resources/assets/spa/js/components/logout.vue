<template> 
	<div class="container">
		<div class="row">
			<div class="col s6 offset-s3 z-depth-2">
				<h4 class="center">Efetuando Logout...</h4>
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
					.then(goToLogin())
					.catch(goToLogin());
			}
		}
	};
</script>