<template>
	<div>
		<category-tree :categories="categories" namespace="categoryExpense"></category-tree>
		<category-register 
			:modalOptions="modalRegisterOptions" 
			:categoryRegister="categoryRegister" 
			:cpOptions="cpOptions"
			:namespace="namespace()">

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
	</div>
</template>

<script type="text/javascript">
	import categoryMixin from '../../mixins/category-mixin';

	export default {
		mixins: [categoryMixin],
		methods: {
			namespace(){
				return 'categoryExpense';
			}
		},
		created(){
			EventHub.$on('categoryExpanseNew', this.modalNew);
			EventHub.$on('categoryExpanseEdit', this.modalEdit);
			EventHub.$on('categoryExpanseDelete', this.modalDelete);
			EventHub.$on('categoryExpanseSave', this.saveCategory);
		}
	}
</script>