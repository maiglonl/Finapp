<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Finapp\Repositories\CategoryRevenueRepository;
use Finapp\Criteria\WithDepthCategoriesCriteria;

class CategoryRevenuesController extends Controller{

	use CategoriesControllerTrait;

	protected $repository;

	public function __construct(CategoryRevenueRepository $repository){
		$this->repository = $repository;
		$this->repository->pushCriteria(new WithDepthCategoriesCriteria());
	}

}
