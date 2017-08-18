<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\CategoryExpenseRepository;
use Finapp\Models\CategoryExpense;
use Finapp\Validators\CategoryValidator;
use Finapp\Presenters\CategoryPresenter;

/**
 * Class CategoryExpenseRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class CategoryExpenseRepositoryEloquent extends BaseRepository implements CategoryExpenseRepository{
	use CategoryRepositoryTrait;

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model(){
		return CategoryExpense::class;
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
