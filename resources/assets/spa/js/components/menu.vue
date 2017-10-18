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
							<li v-for="menu in menus" :class="menuItemClass(menu)">
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
			<li>{{ name }}</li>
			<li v-for="menu in menus">
				<router-link :to="{name: menu.routeName}" class="dropdownBtn">{{ menu.name }}</router-link>
			</li>
		</ul>
		<ul :id="dropMenu.id" class="dropdown-content" v-for="dropMenu in menusDropdown">
			<li v-for="submenu in dropMenu.items" :class="menuItemClass(submenu)">
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
	import store from '../store/store';

	export default {
		data(){
			return {
				menus: [
					{ name: "Conta bancária", routeName: 'bank-account.list'},
					{ name: "Plano de Contas", routeName: 'plan-account'},
					{ name: "Contas", dropdownId: 'billsMenu'},
				],
				menusDropdown: [
					{
						id: 'billPayMenu',
						items: [
							{ name: "Cadastrar Conta", routeName: 'auth.login' },
							{ name: "Listar Contas", routeName: 'auth.login' },
						]
					},{
						id: 'billsMenu',
						items: [
							{ name: "À Pagar", routeName: 'bill-pay.list' },
							{ name: "À Receber", routeName: 'bill-receive.list' },
						]
					},
				]
			}
		},
		computed: {
			name(){
				return store.state.auth.user ? store.state.auth.user.name : "";
			}
		},
		methods: {
			menuItemClass(menu){
				let menuClass = [];
				if(menu.active){
					menuClass = ['active'];
				}
				if(menu.dropdownId !== undefined){
					let dropdown = this.menusDropdown.find((elemento)=>{
						return elemento.id == menu.dropdownId;
					});
					if(dropdown){
						dropdown.items.forEach((val, key) => {
							if(val.active){
								menuClass = ['active'];
							}
						});
					}
				}
				return menuClass;
			}
		},
		mounted(){
			$("#navMobileBtn").sideNav();
			$(".dropdownBtn").dropdown({
				belowOrigin: true
			});
			//$('.modal').modal();
		}
	};
</script>

