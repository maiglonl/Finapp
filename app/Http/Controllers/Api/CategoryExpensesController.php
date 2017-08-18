<?php

namespace Finapp\Http\Controllers\Api;


use Finapp\Http\Controllers\Controller;
use Finapp\Repositories\CategoryExpenseRepository;
use Finapp\Criteria\WithDepthCategoriesCriteria;

class CategoryExpensesController extends Controller{

	use CategoriesControllerTrait;

	protected $repository;

	public function __construct(CategoryExpenseRepository $repository){
		$this->repository = $repository;
		$this->repository->pushCriteria(new WithDepthCategoriesCriteria());
	}

}
