<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\CategoryRevenueRepository;
use Finapp\Models\CategoryRevenue;
use Finapp\Validators\CategoryValidator;
use Finapp\Presenters\CategoryPresenter;

/**
 * Class CategoryRevenueRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class CategoryRevenueRepositoryEloquent extends BaseRepository implements CategoryRevenueRepository{
	use CategoryRepositoryTrait;

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model(){
		return CategoryRevenue::class;
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
