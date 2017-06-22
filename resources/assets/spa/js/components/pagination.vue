<template>
	<div>{{pages}}</div>
</template>

<script type="text/javascript">
	export default{
		props:{
			currentPage:{
				type: Number,
				'default': 0
			},
			perPage:{
				type: Number,
				'default': 10
			},
			totalRecords:{
				type: Number,
				required:true
			}
		},
		computed:{
			pages(){
				let pages = Math.ceil(this.totalRecords/this.perPage);
				return Math.max(pages, 1);
			}
		}
	}
</script>