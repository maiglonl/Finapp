<?php

namespace Finapp\Http\Controllers\Api;

use Carbon\Carbon;
use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Repositories\StatementRepository;

class CashFlowsController extends Controller{

	/**
	 * @var StatementRepository
	 */
	protected $repository;

	public function __construct(StatementRepository $repository){
		$this->repository = $repository;
	}

	public function index(){
		$dateStart = new Carbon('2018-03-01');
		$dateEnd = $dateStart->copy()->addMonths(10);
		return $this->repository->getCashFlow($dateStart, $dateEnd);
	}

	public function byPeriod(){
		$dateStart = new Carbon();
		$dateEnd = $dateStart->copy()->addDays(30);
		return $this->repository->getCashFlowByPeriod($dateStart, $dateEnd);
	}
}
