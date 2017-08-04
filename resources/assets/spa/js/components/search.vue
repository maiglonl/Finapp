<template>
	<form name="searchForm" method="GET" @submit.prevent="">
		<div class="filter-group">
			<div class="filter-wrapper">
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">search</i>
						<input type="text" v-model="search" placeholder="Digite aqui a sua busca">
					</div>
				</div>
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
		watch: {
			search(newValue){
				EventHub.$emit('searchSubmit', newValue);
			}
		}
	}
</script>
