export default class{
	constructor(){
		this._pagination = {
			current_page: 1,
			per_page: 0,
			total: 0
		};
		this.search = '',
		this.order = {
			get key(){
				return this._key;
			},
			set key(value){
				this._key = value;
				this.sort = this.sort == 'asc' ? 'desc' : 'asc';
			},
			_key: 'id',
			sort: 'asc'
		},
		this.include = null
	}

	get pagination(){
		return this._pagination;
	}
	set pagination(value){
		this._pagination = value;
	}

	createOptions(){
		let options = {
			page: this.pagination.current_page,
			orederBy: this.order.key,
			sortedBy: this.order.sort,
			search: this.search
		};
		if(this.include){
			options.include = this.include;
		}
		return options;
	}


}