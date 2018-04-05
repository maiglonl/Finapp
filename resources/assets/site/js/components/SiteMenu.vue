<template> 
	<div>
		<nav class="navbar-fixed">
			<div class="nav-wrapper">
				<div class="row">
					<div class="col s12">
						<a href="#" class="brand-logo">Finapp</a>
						<a href="#" data-activates="navMobile" class="button-collapse" id="navMobileBtn">
							<i class="material-icons">menu</i>
						</a>
						<ul class="right hide-on-med-and-down">
							<li v-for="menu in config.menus" :class="menuItemClass(menu)">
								<a href="!#" v-if="menu.dropdownId" class="dropdownBtn" :data-activates="menu.dropdownId">
									{{ menu.name }}
									<i class="material-icons right">arrow_drop_down</i>
								</a>
								<a :href="menu.url" v-else class="dropdownBtn">{{ menu.name }}</a>
							</li>
							<li v-if="config.auth">
								<a href="!#" class="dropdownBtn" data-activates="dropdownLogout">
									{{ config.name }}<i class="material-icons right">arrow_drop_down</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<ul id="navMobile" class="side-nav">
			<li v-for="menu in config.menus">
				<a :href="menu.url" class="dropdownBtn">{{ menu.name }}</a>
			</li>
		</ul>
		<ul :id="dropMenu.id" class="dropdown-content" v-for="dropMenu in config.menusDropdown">
			<li v-for="submenu in dropMenu.items" :class="menuItemClass(submenu)">
				<a :href="submenu.url" class="dropdownBtn">{{ submenu.name }}</a>
			</li>
		</ul>
		<ul id="dropdownLogout" class="dropdown-content">
			<li>
				<a :href="config.urlLogout" @click.prevent="goToLogout()" class="dropdownBtn">Logout</a>

				<form id="logout-form" :action="config.urlLogout" method="POST" style="display: none;">
					<input type="hidden" name="_token" :value="config.csrfToken"/>
				</form>
			</li>
		</ul>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			config: {
				type: Object,
				default(){
					return {
						name: '',
						menus: [],
						menusDropdown: [],
						urlLogout: '/admin/logout'
					}
				}
			}
		},
		mounted(){
			$("#navMobileBtn").sideNav();
			$(".dropdownBtn").dropdown();
			//$('.modal').modal();
		},
		methods: {
			goToLogout(){
				$("#logout-form").submit();
			},
			menuItemClass(menu){
				let menuClass = [];
				if(menu.active){
					menuClass = ['active'];
				}
				if(menu.dropdownId !== undefined){
					let dropdown = this.config.menusDropdown.find((elemento)=>{
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
		}
	};
</script>

