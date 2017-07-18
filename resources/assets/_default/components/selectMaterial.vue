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
			}
		},
		data(){
			return{
				optionsData: [],
				selectedData: 0
			}
		},
		mounted(){
			this.optionsData = this.options;
			this.selectedData = this.selected !== null ? this.selected : 0;
			let self = this;
			$(this.$el)
				.select2(this.optionsData)
				.on('change', function(){
					if(self.selectedData != $(this.$el).val()){
						console.log("changed 1");
						self.selectedData = this.value;
					}
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
					console.log("changed 3");
					this.selectedData = this.selected !== null ? this.selected : 0;
					$(this.$el).val(this.selectedData).trigger('change');
				}
			},
			'selectedData'(newId){
				console.log("changed 2["+newId+", "+$(this.$el).val()+"]");
				EventHub.$emit('selectedValue', newId);
			}
		}
	}
</script>