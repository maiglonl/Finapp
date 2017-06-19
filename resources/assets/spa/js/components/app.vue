<template> 
	<div id="app">
		<header>
			<appMenu v-if="showMenu"></appMenu>
		</header>

		<main>
			<router-view></router-view>
		</main>

		<footer class="page-footer">
			<div class="footer-copyright">
				<div class="container">
					© {{ year }} <a href="http://fb.com/maiglon" class="grey-text text-lighten-4">Maiglon Lubacheuski</a>
				</div>
			</div>
		</footer>
	</div>
</template>

<script type="text/javascript">
	import MenuComponent from './menu.vue';
	import Auth from '../services/auth';
	export default {
		components: {
			'appMenu' : MenuComponent
		},
		data(){
			return {
				year: new Date().getFullYear(),
				user: Auth.user
			}
		},
		computed:{
			showMenu(){
				return this.user.check && this.$route.name != 'auth.login'
			}
		}
	};
</script>

<style type="text/css">
	#app{
		display: flex;
		min-height: 100vh;
		flex-direction: column;
	}

	main{
		flex: 1 0 auto;
	}
</style>