<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Criteria\FindBetweenDateBRCriteria;
use Finapp\Http\Controllers\Controller;
use Finapp\Repositories\StatementRepository;
use Illuminate\Http\Request;

class StatementsController extends Controller {

	/**
	 * @var StatementRepository
	 */
	protected $repository;

	public function __construct(StatementRepository $repository){
		$this->repository = $repository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		$searchParam = condig('repository.criteria.params.search');
		$search = $request->get($searchParam);
		$this->repository
			->pushCriteria(new FindBetweenDateBRCriteria($search, 'created_at'));
		$statements = $this->repository->paginate();
		return $statements;
	}

}
