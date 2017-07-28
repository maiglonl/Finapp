<template>
	<div class="container">
		<div class="row">
			<page-title>
				<h5>Administração de categorias</h5>
			</page-title>
			<div class="card-panel z-depth-5">
				<category-tree :categories="categories"></category-tree>
			</div>
			<category-register 
				:modalOptions="modalRegisterOptions" 
				:categoryRegister="categoryRegister" 
				:cpOptions="cpOptions">

				<span slot="title">{{ title }}</span>
				<div slot="footer">
					<button class="btn btn-flat waves-effect green lighten-2 modal-action modal-close" type="submit">OK</button>
					<button class="btn btn-flat waves-effect waves-red modal-action modal-close" type="button">Cancelar</button>
				</div>
			</category-register>
			<modal :modal="modalDeleteOptions">
				<div slot="content" v-if="categoryDelete">
					<h4>Mensagem de confirmação</h4>
					<p><strong>Deseja excluir esta categoria?</strong></p>
					<div class="divider"></div>
					<p>Nome: <strong>{{categoryDelete.name}}</strong></p>
					<div class="divider"></div>
				</div>
				<div slot="footer">
					<button class="btn btn-flat waves-effect green lighten-2 modal-action modal-close" @click="destroy()">OK</button>
					<button class="btn btn-flat waves-effect waves-red modal-action modal-close">Cancelar</button>
				</div>
			</modal>
			<div class="fixed-action-btn">
				<button class="btn-floating btn-large" @click="categoryNew(null)">
					<i class="large material-icons">add</i>
				</button>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import PageTitleComponent from '../pageTitle.vue';
	import CategoryTreeComponent from './categoryTree.vue';
	import CategoryRegisterComponent from './categoryRegister.vue';
	import {Category} from '../../services/resources';
	import {CategoryFormat, CategoryService} from '../../services/category-nsm';
	import ModalComponent from '../../../../_default/components/Modal.vue';

	export default {
		components: {
			'page-title': PageTitleComponent,
			'category-tree': CategoryTreeComponent,
			'category-register': CategoryRegisterComponent,
			'modal': ModalComponent,
		},
		data(){
			return {
				categories: [],
				categoriesFormatted: [],
				title: '',
				modalRegisterOptions:{
					id: 'modal-category-register'
				},
				modalDeleteOptions:{
					id: 'modal-category-delete'
				},
				categoryRegister:{
					id: 0,
					name: '',
					parent_id: 0
				},
				categoryDelete: null,
				category: null,
				parent: null
			}
		},
		computed: {
			cpOptions(){
				return{
					data: this.categoriesFormatted,
					templateResult(category){
						let margin = '&nbsp'.repeat(category.level*5);
						let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
						return `${margin}${text}`;
					},
					escapeMarkup(m){ return m; }
				}
			}
		},
		created(){
			this.getCategories();
			EventHub.$on('categoryNew', this.modalNew);
			EventHub.$on('categoryEdit', this.modalEdit);
			EventHub.$on('categoryDelete', this.modalDelete);
			EventHub.$on('saveCategory', this.saveCategory);
		},
		methods: {
			getCategories(){
				Category.query().then(response => {
					this.categories = response.data.data;
					this.formatCategories();
				})
			},
			saveCategory(category){
				CategoryService.save(this.categoryRegister, this.parent, this.categories, this.category).then(response =>{
					if(this.categoryRegister.id === 0){
						Materialize.toast('Categoria adicionada com sucesso!', 2000);
					}else{
						Materialize.toast('Categoria alterada com sucesso!', 2000);
					}
					this.resetScope();
				});
				console.log("categ saved!");
			},
			modalNew(category){
				this.title = 'Nova Categoria';
				this.categoryRegister = {
					id: 0,
					name: '',
					parent_id: category === null ? null : category.id
				};
				this.parent = category;
				$(`#${this.modalRegisterOptions.id}`).modal('open');
			},
			modalEdit(category, parent){
				this.title = 'Editar Categoria';
				this.categoryRegister = category;
				this.category = category;
				this.parent = parent;
				$(`#${this.modalRegisterOptions.id}`).modal('open');
			},
			modalDelete(category, parent){
				this.categoryDelete = category;
				this.parent = parent;
				$(`#${this.modalDeleteOptions.id}`).modal('open');
			},
			destroy(){
				CategoryService.destroy(this.categoryDelete, this.parent, this.categories).then(response => {
					Materialize.toast('Categoria excluída com sucesso!', 2000);
					this.resetScope();
				});
			},
			formatCategories(){
				this.categoriesFormatted = CategoryFormat.getCategoriesFormatted(this.categories);
			},
			resetScope(){
				this.categoryRegister = {
					id: 0,
					name: '',
					parent_id: 0
				};
				this.categoryDelete = null;
				this.category = null;
				this.parent = null;
				this.title = '';
				this.formatCategories();
			}
		}
	}
</script>