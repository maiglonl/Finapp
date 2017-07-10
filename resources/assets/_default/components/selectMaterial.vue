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
			}
		},
		ready(){
			this.optionsData = this.options;
			let self = this;
			$(this.$el)
				.select2(this.optionsData)
				.on('change', function(){
					if(parseInt(this.value, 10) !== 0){
						EventHub.$emit('selectedValue', self.selected);
					}
				});
			let newVal = this.selected !== null ? this.selected : 0;
			$(this.$el).val(newVal).trigger('change');
		},
		watch: {
			'options.data'(data){
				this.optionsData.data = data;
				$(this.$el).select2(Object.assign({}, this.options, {data: data}));
			},
			'selected'(newId){
				if(newId != $(this.$el).val()){
					let newVal = newId !== null ? newId : 0;
					$(this.$el).val(newVal).trigger('change');
				}
			}
		}
	}
</script>