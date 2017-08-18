<template>
	<ul class="category-tree">
		<li v-for="(o, index) in categories" class="category-child">
			<div class="valign-wrapper">
				<a :data-activates="dropdownId(o)" :id="categorySymbolId(o)"
					class="category-symbol" href="#" @click.prevent=""
					:class="{'green-text' : o.children.data.length > 0, 'grey-text' : !o.children.data.length }">
					<i class="material-icons">{{ categoryIcon(o) }}</i>
				</a>
				<ul :id="dropdownId(o)" class="dropdown-content">
					<li><a href="#" @click.prevent="categoryNew(o)">Adicionar</a></li>
					<li><a href="#" @click.prevent="categoryEdit(o)">Editar</a></li>
					<li><a href="#" @click.prevent="categoryDelete(o)">Remover</a></li>
				</ul>
				<span class="valign" v-html="categoryText(o)"></span>
			</div>
			<category-tree v-if="o.children.data" :categories="o.children.data" :parent="o" :namespace="namespace"></category-tree>
		</li>
	</ul>
</template>

<script type="text/javascript">
	export default {
		name: 'category-tree',
		props: {
			categories: {
				type: Array,
				required: true
			},
			parent: {
				type: Object,
				required: false,
				'default'(){
					return null;
				}
			},
			namespace: {
				type: String,
				required: true
			}
		},
		mounted(){
			this.setupDropDown();
		},
		methods: {
			dropdownId(category){
				return `category-tree-dropdown-${this._uid}-${category.id}`;
			},
			categorySymbolId(category){
				return `category-symbol-${this._uid}-${category.id}`;
			},
			categoryText(category){
				return category.children.data.length > 0 ? `<strong>${category.name}</strong>` : `${category.name}`;
			},
			categoryIcon(category){
				return category.children.data.length > 0 ? 'folder' : 'label';
			},
			setupDropDown(){
				$(`a[id^=category-symbol-${this._uid}-]`).unbind('mouseenter mouseleave');
				$(`a[id^=category-symbol-${this._uid}-]`).dropdown({
					hover: true,
					inDuration: 300,
					outDuration: 400,
					belowOrigin: true
				});
			},
			categoryNew(category){
				EventHub.$emit(`${this.namespace}New`, category);
			},
			categoryEdit(category){
				EventHub.$emit(`${this.namespace}Edit`, category, this.parent);
			},
			categoryDelete(category){
				EventHub.$emit(`${this.namespace}Delete`, category, this.parent);
			},
		},
		watch: {
			categories: {
				handler: function(val, oldVal){
					this.setupDropDown();	
				},
				deep: true
			}
		}
	}
</script>