<template>
	<form name="searchForm" method="GET" @submit="submit()">
		<div class="filter-group">
			<button class="btn waves-effect" type="submit">
				<i class="material-icons">search</i>
			</button>
			<div class="filter-wrapper">
				<input type="text" v-model="search" placeholder="Digite aqui a sua busca">
			</div>
		</div>
	</form>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				search: ""
			}
		},
		methods: {
			submit(){
				EventHub.$emit('searchSubmit', this.search);
			}
		}
	}
</script>
