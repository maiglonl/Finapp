<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\CategoryRepository;
use Finapp\Models\Category;
use Finapp\Validators\CategoryValidator;
use Finapp\Presenters\CategoryPresenter;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model(){
		return Category::class;
	}

	public function create(array $attributes){
		Category::$enableTenant = false;
		if(isset($attributes['parent_id'])){
			$skipPresenter = $this->skipPresenter;
			$this->skipPresenter(true);
			$parent = $this->find($attributes['parent_id']);
			$this->skipPresenter = $skipPresenter;
			$child = $parent->children()->create($attributes);
			$result = $this->parserResult($child);
		}else{
			$result = parent::create($attributes);
		}
		Category::$enableTenant = true;
		return $result;

	}

	public function update(array $attributes, $id){
		Category::$enableTenant = false;
		if(isset($attributes['parent_id'])){
			$skipPresenter = $this->skipPresenter;
			$this->skipPresenter(true);
			$child = $this->find($id);
			$child->parent_id = $attributes['parent_id'];
			$child->fill($attributes);
			$child->save();
			$this->skipPresenter = $skipPresenter;
			$result = $this->parserResult($child);
		}else{
			$result = parent::update($attributes, $id);
			$result->makeRoot()->save();
		}
		Category::$enableTenant = true;
		return $result;

	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot(){
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter(){
		return CategoryPresenter::class;
	}
}
