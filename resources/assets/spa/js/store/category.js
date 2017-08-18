import {CategoryRevenue, CategoryExpense} from '../services/resources';

export default() => {
	const findParent = (id, categories)=>{
		let result = null;
		for(let category of categories){
			if(id == category.id){
				result = category;
				break;
			}
			result = this.findParent(id, category.children.data);
			if(result !== null){
				break;
			}
		}
		return result;
	};

	const addChild = (child, categories)=>{
		let parent = this.findParent(child.parent_id, categories);
		parent.children.data.push(child);   
	};

	const formatCategories = (categories, categoryCollection = [])=>{
		for(let category of categories){
			let categoryNew = {
				id: category.id,
				text: category.name,
				level: category.depth,
				hasChildren: category.children.data.length > 0
			};
			categoryCollection.push(categoryNew);
			formatCategories(category.children.data, categoryCollection)
		}
		return categoryCollection;
	};

	const state = {
		categories: [],
		category: null,
		parent: null,
		resource: null
	};

	const mutations = {
		add(state){
			if(state.category.parent_id === null){
				state.categories.push(state.category);
			}else{
				state.parent.children.data.push(state.category);
			}
		},
		edit(state, categoryUpdated){
			if(state.category.parent_id === null){
				/*
				 * Categoria alterada,
				 * está sem pai e antes tinha pai
				 */
				if(state.parent){
					let index = state.parent.children.data.indexOf(state.category);
					state.parent.children.data.splice(index, 1);
					state.categories.push(state.categoryUpdated);
					return;
				}
			}else{
				/*
				 * Categoria alterada está com pai
				 */
				if(state.parent){
					/*
					 * Trocar categoria de pai
					 */
					if(state.parent.id != state.category.parent_id){
						let index = state.parent.children.data.indexOf(state.category);
						state.parent.children.data.splice(index, 1);
						addChild(categoryUpdated, state.categories);
						return;
					}
				}else{
					/*
					 * Tornar a categoria um filho
					 */
					let index = state.categories.indexOf(state.category);
					state.categories.splice(index, 1);
					addChild(categoryUpdated, state.categories);
					return;
				}
			}

			/**
			 * Alteração somente no nome da categoria
			 */
			if(state.parent){
				let index = state.parent.children.data.findIndex(element => {
					return element.id == state.category.id;
				});
				Vue.set(state.parent.children.data, index, categoryUpdated);
			}else{
				let index = state.categories.findIndex(element => {
					return element.id == state.category.id;
				});
				Vue.set(state.categories, index, categoryUpdated);
			}
		},
		set(state, categories){
			state.categories = categories;
		},
		'delete'(state){
			if(state.parent){
				let index = state.parent.children.data.indexOf(state.category);
				state.parent.children.data.splice(index, 1);
			}else{
				let index = state.categories.indexOf(state.category);
				state.categories.splice(index, 1);
			}
		},
		setCategory(state, category){
			state.category = category;
		},
		setParent(state, parent){
			state.parent = parent;
		},
		setResource(state, type){
			state.resource = type == 'categoryRevenue' ? CategoryRevenue : CategoryExpense;
		}
	};

	const actions = {
		query(context){
			return context.state.resource.query().then((response) => {
				context.commit('set', response.data.data);
				return response
			});
		},
		'delete'(context){
			let id = context.state.category.id;
			return context.state.resource.delete({id: id}).then((response) => {
				context.commit('delete');
				context.commit('setCategory', null);
				return response;
			});
		},
		save(context, category){
			console.log('saved');
			let categoryCopy = $.extend(true, {}, category);
			if(categoryCopy.parent_id === null){
				delete categoryCopy.parent_id;
			}
			if(category.id === 0){
				return context.dispatch('new', categoryCopy);
			}else{
				return context.dispatch('edit', categoryCopy);
			}
		},
		'new'(context, category){
			return context.state.resource.save(category).then(response =>{
				context.commit('setCategory', response.data.data);
				context.commit('add');
				return response; 
			});
		},
		edit(context, category){
			return context.state.resource.update({id: category.id},category).then(response =>{
				context.commit('edit', response.data.data);
				return response; 
			});
		}
	};

	const getters = {
		categoriesFormatted(state){
			let categoriesFormatted = formatCategories(state.categories);
			categoriesFormatted.unshift({
				id: 0,
				text: "Nenhuma categoria",
				level: 0,
				hasChildren: false
			});
			return categoriesFormatted;
		}
	}

	const module = {
		namespaced: true,
		state, 
		mutations, 
		actions,
		getters
	}

	return module;

};