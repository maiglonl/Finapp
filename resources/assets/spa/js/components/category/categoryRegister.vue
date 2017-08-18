<template>
	<div>
		<form name="formCategory" method="POST" @submit.prevent="submit">
			<modal :modal="modalOptions">
				<div slot="content">
					<h5><slot name="title"></slot></h5>
					<div class="row">
						<div class="input-field col s12">
							<label>Nome</label>
							<input type="text" class="active" placeholder="Nome da categoria" v-model="categReg.name">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<select-material :options="cpOptions" :selected="categReg.parent_id" :parent="this._uid"></select-material>
							<label class="active">Categoria Pai</label>
						</div>
					</div>
				</div>
				<div slot="footer">
					<slot name="footer"></slot>
				</div>
			</modal>
		</form>
	</div>
</template>

<script type="text/javascript">
	import ModalComponent from '../../../../_default/components/Modal.vue';
	import SelectMaterial from '../../../../_default/components/selectMaterial.vue';

	export default {
		components: {
			'modal': ModalComponent,
			'select-material': SelectMaterial
		},
		props: {
			categoryRegister: { type: Object, required: true },
			modalOptions: { type: Object, required: true },
			cpOptions: { type: Object, required: true },
			namespace: { tpe: String, required: true }
		},
		data(){
			return {
				categReg: {
					id: 0,
					name: '',
					parent_id: 0
				}
			}
		},
		created(){
			this.categReg = Object.assign({}, this.categoryRegister);
			EventHub.$on(`selectedValue_${this._uid}`, this.changeParentId);
		},
		methods: {
			submit(){
				if(this.categReg.parent_id == 0){
					this.categReg.parent_id = null
				}
				EventHub.$emit(`${this.namespace}Save`, this.categReg);
			},
			changeParentId(newId){
				let newVal = newId !== 0 ? newId : null;
				this.categReg.parent_id = newId;
			}
		},
		watch: {
			'categoryRegister'(data){
				this.categReg = Object.assign({}, data);
			}
		}
	}
</script>