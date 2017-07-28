import {Category} from './resources';

export class CategoryFormat{
	static getCategoriesFormatted(categories){
		let categoriesFormatted = this._formatCategories(categories);
		categoriesFormatted.unshift({
			id: 0,
			text: "Nenhuma categoria",
			level: 0,
			hasChildren: false
		});
		return categoriesFormatted;
	}

	static _formatCategories(categories, categoryCollection = []){
		for(let category of categories){
			let categoryNew = {
				id: category.id,
				text: category.name,
				level: category.depth,
				hasChildren: category.children.data.length > 0
			};
			categoryCollection.push(categoryNew);
			this._formatCategories(category.children.data, categoryCollection)
		}
		return categoryCollection;
	}
}

export class CategoryService{

	static save(category, parent, categories, categoryOriginal){
		if(category.id === 0){
			return this.new(category, parent, categories);
		}else{
			return this.edit(category, parent, categories, categoryOriginal);
		}
	}

	static new(category, parent, categories){
		let categoryCopy = $.extend(true, {}, category);
		if(categoryCopy.parent_id === null){
			delete categoryCopy.parent_id;
		}
		return Category.save(categoryCopy).then(response =>{
			let categoryAdded = response.data.data;
			if(categoryAdded.parent_id === null){
				categories.push(categoryAdded);
			}else{
				parent.children.data.push(categoryAdded);
			}
			return response; 
		});
	}

	static edit(category, parent, categories, categoryOriginal){
		let categoryCopy = $.extend(true, {}, category);
		if(categoryCopy.parent_id === null){
			delete categoryCopy.parent_id;
		}
		let self = this;
		return Category.update({id: categoryCopy.id},categoryCopy).then(response =>{
			let categoryUpdated = response.data.data;
			if(categoryUpdated.parent_id === null){
				/*
				 * Categoria alterada,
				 * está sem pai e antes tinha pai
				 */
				if(parent){
					let index = parent.children.data.indexOf(categoryOriginal);
					parent.children.data.splice(index, 1);
					categories.push(categoryUpdated);
					return response;
				}
			}else{
				/*
				 * Categoria alterada está com pai
				 */
				if(parent){
					/*
					 * Trocar categoria de pai
					 */
					if(parent.id != categoryUpdated.parent_id){
						let index = parent.children.data.indexOf(categoryOriginal);
						parent.children.data.splice(index, 1);
						self._addChild(categoryUpdated, categories);
						return response;
					}
				}else{
					/*
					 * Tornar a categoria um filho
					 */
					let index = categories.indexOf(categoryOriginal);
					categories.splice(index, 1);
					self._addChild(categoryUpdated, categories);
					return response;
				}
			}

			/**
			 * Alteração somente no nome da categoria
			 */
			if(parent){
				let index = parent.children.data.findIndex(element => {
					return element.id == categoryUpdated.id;
				});
				Vue.set(parent.children.data, index, categoryUpdated);
			}else{
				let index = categories.findIndex(element => {
					return element.id == categoryUpdated.id;
				});
				Vue.set(categories, index, categoryUpdated);
			}
			return response; 
		});
	}

	static destroy (category, parent, categories){
		return Category.delete({id: category.id}).then(response => {
			if(parent){
				let index = parent.children.data.indexOf(category);
				parent.children.data.splice(index, 1);
			}else{
				let index = categories.indexOf(category);
				categories.splice(index, 1);
			}
			return response;
		});
	}

	static _addChild(child, categories){
		let parent = this._findParent(child.parent_id, categories);
		parent.children.data.push(child);   
	}

	static _findParent(id, categories){
		let result = null;
		for(let category of categories){
			if(id == category.id){
				result = category;
				break;
			}
			result = this._findParent(id, category.children.data);
			if(result !== null){
				break;
			}
		}
		return result;
	}
}