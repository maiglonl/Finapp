<?php

namespace Finapp\Http\Controllers\Api;

use Carbon\Carbon;
use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Repositories\StatementRepository;

class StatementsController extends Controller{

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
	public function index(){
		$statements = $this->repository->paginate();
		return $statements;
	}

}
