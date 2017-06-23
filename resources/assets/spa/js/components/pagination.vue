<template>
	<ul class="pagination">
		<li :class="{'disabled': curPage == 1}">
			<a href="#" @click.prevent="previousPage()">
				<i class="material-icons">chevron_left</i>
			</a>
		</li>

		<li v-for="o in pages" class="waves-effect" :class="{'active': curPage == o}">
			<a href="#" @click.prevent="setCurrentPage(o)">{{o}}</a>
		</li>

		<li :class="{'disabled': curPage == pages}">
			<a href="#" @click.prevent="nextPage()">
				<i class="material-icons">chevron_right</i>
			</a>
		</li>
	</ul>
</template>

<script type="text/javascript">
	export default{
		props:{
			currentPage:{
				type: Number,
				'default': 1
			},
			perPage:{
				type: Number,
				required:true
			},
			totalRecords:{
				type: Number,
				required:true
			}
		},
		data(){
			return{
				/*
				 * Utilizando atributo curPage para não alterar diretamente a propriedade 'currentPage', o que causa um Warning no Vue.
				 */ 
				curPage: 1 
			}
		},
		computed:{
			pages(){
				let perPage = this.perPage < 1 ? 15 : this.perPage; 
				let totalRecords = this.totalRecords < 1 ? 15 : this.totalRecords; 
				let pages = Math.ceil(totalRecords/perPage);
				return Math.max(pages, 1);
			}
		},
		methods:{
			previousPage(){
				if(this.curPage > 1){
					this.curPage--;
				}
			},
			setCurrentPage(page){
				this.curPage = page;
			},
			nextPage(){
				if(this.curPage < this.pages){
					this.curPage++;
				}
			},
			changePage(page){
				if(page != this.curPage){
					this.curPage = page;
				}
			}
		},
		created: function () {
			EventHub.$on('pageChanged', this.changePage);
		},
		watch:{
			curPage(newValue){
				EventHub.$emit('pageChanged', newValue);
			},
			currentPage(newValue){
				this.curPage = newValue;
			}
		}
	}
</script>