<template>
	<span>
		<slot></slot>
		<form method="POST" :action="action" :id="id">
			<input type="hidden" name="_method" value="DELETE"/>
			<input type="hidden" name="_token" :value="csrfToken"/>
		</form>
	</span>
</template>

<script type="text/javascript">
	export default{
		props: ['action', 'csrfToken', 'actionElement'],
		computed: {
			id(){
				return `form-delete-action_${this.actionElement}`;
			}
		},
		mounted(){
			let actionElement = this.actionElement;
			let formId = this.id;

			$(document).ready(() => {
				$(`#${actionElement}`).click((e) => {
					e.preventDefault();
					$(`#${formId}`).submit();
				})
			});
		}
	}
</script>

<style type="text/css" scoped>
	form{
		display: none;
	}
</style>