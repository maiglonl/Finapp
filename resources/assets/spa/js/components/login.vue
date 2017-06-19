<template> 
	<div class="container">
		<div class="row">
			<div class="col s6 offset-s3 z-depth-2">
				<h3 class="center">Finapp</h3>
				<div class="row" v-if="error.error">
					<div class="col s12">
						<div class="card-panel red">
							<span class="white-text">{{ error.message }}</span>
						</div>
					</div>
				</div>
				<form method="POST" @submit.prevent="login()">
					<div class="row">
						<div class="input-field col s12">
							<input id="email" type="text" class="validate" name="email" v-model="user.email" required>
							<label for="email">E-mail</label>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<input id="password" type="password" class="validate" name="password" v-model="user.password" required>
							<label for="password">Senha</label>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<button type="submit" class="btn waves-effect">Login</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Auth from '../services/auth';
	export default {
		data(){
			return {
				user: { email: '', password: '' },
				error: { message: '', error: false }
			}
		},
		methods: {
			login(){
				Auth.login(this.user.email, this.user.password)
					.then(() => this.$router.push({ name: 'dashboard' }))
					.catch((responseError) => {
						switch(responseError.status){
							case 401:
								this.error.message = responseError.data.message;
								break;
							default:
								this.error.message = "Login failure!"
								break;
						}
						this.error.error = true;
					});
			}
		}
	};
</script>