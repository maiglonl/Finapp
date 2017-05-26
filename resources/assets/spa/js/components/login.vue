<template> 
	<div class="container">
		<div class="row">
			<div class="col s6 offset-s3 z-depth-2">
				<h3 class="center">Finapp</h3>
				<form method="POST" @submit.prevent="login()">
					<div class="row">
						<div class="input-field col s12">
							<input id="email" type="email" class="validate" name="email" v-model="user.email" required>
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
	import {Jwt} from '../resources';
	export default {
		data(){
			return {
				user: {
					email: '',
					password: ''
				}
			}
		},
		methods: {
			login(){

				console.log({
					email: this.user.email,
					password: this.user.password
				});
				Jwt.accessToken(this.user.email, this.user.password).then((response) => {
					console.log(response);
				});
			}
		}
	};
</script>