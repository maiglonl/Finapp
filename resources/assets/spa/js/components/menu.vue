<template> 
	<div>
		<nav class="navbar-fixed">
			<div class="nav-wrapper">
				<div class="row">
					<div class="col s12">
						<a href="#" class="brand-logo">Finapp - Admin</a>
						<a href="#" data-activates="navMobile" class="button-collapse" id="navMobileBtn">
							<i class="material-icons">menu</i>
						</a>
						<ul class="right hide-on-med-and-down">
							<li v-for="menu in menus">
								<a href="!#" v-if="menu.dropdownId" class="dropdownBtn" :data-activates="menu.dropdownId">
									{{ menu.name }}
									<i class="material-icons right">arrow_drop_down</i>
								</a>
								<router-link :to="{name: menu.routeName}" v-else class="dropdownBtn">{{ menu.name }}</router-link>
							</li>
							<li>
								<a href="!#" class="dropdownBtn" data-activates="dropdownLogout">
									{{ name }}<i class="material-icons right">arrow_drop_down</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<ul id="navMobile" class="side-nav">
			<li v-for="menu in menus">
				{{ name }}<router-link :to="{name: menu.routeName}" class="dropdownBtn">{{ menu.name }}</router-link>
			</li>
		</ul>
		<ul :id="dropMenu.id" class="dropdown-content" v-for="dropMenu in menusDropdown">
			<li v-for="submenu in dropMenu.items">
				<router-link :to="{name: submenu.routeName}" class="dropdownBtn">{{ submenu.name }}</router-link>
			</li>
		</ul>
		<ul id="dropdownLogout" class="dropdown-content">
			<li>
				<router-link :to="{name: 'logout' }">Logout</router-link>
			</li>
		</ul>
	</div>
</template>

<script type="text/javascript">
	import Auth from '../services/auth';
	export default {
		data(){
			return {
				user: Auth.user,
				menus: [
					{ name: "Contas bancárias", routeName: 'bank-account.list'},
					{ name: "Contas a receber", dropdownId: 'billReceiveMenu'},
				],
				menusDropdown: [
					{
						id: 'billReceiveMenu',
						items: [
							{ name: "Cadastrar Conta", routeName: 'auth.login' },
							{ name: "Listar Contas", routeName: 'auth.login' },
						]
					},
				]
			}
		},
		computed: {
			name(){
				return this.user.data ? this.user.data.name : 'User';
			}
		},
		mounted(){
			$("#navMobileBtn").sideNav();
			$(".dropdownBtn").dropdown();
			//$('.modal').modal();
		}
	};
</script>

