import CategoryTreeComponent from '../components/category/categoryTree.vue';
import CategoryRegisterComponent from '../components/category/categoryRegister.vue';
import ModalComponent from '../../../_default/components/Modal.vue';
import store from '../store/store';

export default {
	components: {
		'category-tree': CategoryTreeComponent,
		'category-register': CategoryRegisterComponent,
		'modal': ModalComponent,
	},
	data(){
		return {
			categoryRegister:{
				id: 0,
				name: '',
				parent_id: 0
			},
			title: ''
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
		},
		categories(){
			console.log('changed categs');
			return store.state[this.namespace()].categories;
		},
		categoriesFormatted(){
			return store.getters[`${this.namespace()}/categoriesFormatted`];
		},
		categoryDelete(){
			return store.state[this.namespace()].category;
		},
		modalRegisterOptions(){
			return { id: `modal-category-save-${this._uid}` };
		},
		modalDeleteOptions(){
			return { id: `modal-category-delete-${this._uid}` };
		}
	},
	created(){
		store.dispatch(`${this.namespace()}/query`);
	},
	methods: {
		getCategories(){
			
		},
		saveCategory(category){
			store.dispatch(`${this.namespace()}/save`, category).then(response =>{
				if(category.id === 0){
					Materialize.toast('Categoria adicionada com sucesso!', 2000);
				}else{
					Materialize.toast('Categoria alterada com sucesso!', 2000);
				}
				this.resetScope();
			});
		},
		destroy(){
			store.dispatch(`${this.namespace()}/delete`).then(response => {
				Materialize.toast('Categoria excluída com sucesso!', 2000);
			});
		},
		modalNew(category){
			this.title = 'Nova Categoria';
			this.categoryRegister = {
				id: 0,
				name: '',
				parent_id: category === null ? null : category.id
			};
			store.commit(`${this.namespace()}/setParent`, category);
			$(`#${this.modalRegisterOptions.id}`).modal('open');
		},
		modalEdit(category, parent){
			this.title = 'Editar Categoria';
			this.categoryRegister = category;
			store.commit(`${this.namespace()}/setCategory`, category);
			store.commit(`${this.namespace()}/setParent`, parent);
			$(`#${this.modalRegisterOptions.id}`).modal('open');
		},
		modalDelete(category, parent){
			store.commit(`${this.namespace()}/setCategory`, category);
			store.commit(`${this.namespace()}/setParent`, parent);
			$(`#${this.modalDeleteOptions.id}`).modal('open');
		},
		resetScope(){
			this.categoryRegister = {
				id: 0,
				name: '',
				parent_id: 0
			};
		}
	}
}