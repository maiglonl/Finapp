<template>
	<select></select>
</template>
<script type="text/javascript">
	import 'select2';
	export default {
		props: {
			options: {
				type: Object,
				required: true
			},
			selected: {
				validator(value){
					return typeof value == 'string' || typeof value == 'number' || value === null;
				} 
			},
			parent:{
				type: Number,
				required: false,
				default(){ return null; }
			}
		},
		data(){
			return{
				val: null,
				optionsData: [],
				selectedData: 0
			}
		},
		mounted(){
			this.optionsData = this.options;
			this.selectedData = this.getValue(this.selected);
			let self = this;
			$(this.$el)
				.select2(this.optionsData)
				.on('change', function(){
					self.selectedData = self.getSelectedValue(this.value);
					self.val = this.value;
				});
			$(this.$el).val(this.selectedData).trigger('change');
		},
		watch: {
			'options.data'(data){
				this.optionsData.data = data;
				$(this.$el).empty();
				$(this.$el).select2(this.optionsData);
			},
			'selected'(newId){
				if(newId != $(this.$el).val()){
					this.selectedData = this.getValue(newId);
					$(this.$el).val(this.selectedData).trigger('change');
				}
			},
			'selectedData'(newId){
				let parentId = this.parent != null ? `_${this.parent}` : ''; 
				EventHub.$emit(`selectedValue${parentId}`, newId);
			}
		},
		methods: {
			getSelectedValue(value){
				return parseInt(value, 10) !== 0 ? value : null;
			},
			getValue(value){
				return value !== null ? value : 0;
			}
		}
	}
</script>