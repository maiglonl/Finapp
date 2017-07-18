<template>
	<div>
		<form name="formCategory" method="POST" @submit.prevent="submit">
			<modal :modal="modalOptions">
				<div slot="content">
					<h5><slot name="title"></slot></h5>
					<div class="row">
						<div class="input-field col s12">
							<label>Nome</label>
							<input type="text" v-model="categoryReg.name">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<select-material :options="cpOptions" :selected="categoryReg.parent_id"></select-material>
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
			cpOptions: { type: Object, required: true }
		},
		data(){
			return {
				categoryReg: {
					id: 0,
					name: '',
					parent_id: 0
				}
			}
		},
		created(){
			this.categoryReg = this.categoryRegister;
			EventHub.$on('selectedValue', this.changeParentId);
		},
		methods: {
			submit(){
				EventHub.$emit('saveCategory', this.categoryReg);
			},
			changeParentId(newId){
				console.log("categRegChanged to: "+newId);
				let newVal = newId !== 0 ? newId : null;
				this.categoryReg.parent_id = newId;
			}
		},
		watch: {
			'categoryRegister'(data){
				this.categoryReg = data;
			}
		}
	}
</script>