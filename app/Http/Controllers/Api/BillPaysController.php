<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Finapp\Http\Requests;
use Finapp\Http\Requests\BillPayRequest;
use Finapp\Repositories\BillPayRepository;
use Finapp\Criteria\FindByNameCriteria;
use Finapp\Criteria\FindByValueBRCriteria;
use Finapp\Criteria\FindBetweenDateBRCriteria;
use Finapp\Presenters\BillPaySerializerPresenter;

class BillPaysController extends Controller {
	protected $repository;

	public function __construct(BillPayRepository $repository){
		$this->repository = $repository;
	}

	public function index(Request $request){
		$searchParam = config('repository.criteria.params.search');
		$search = $request->get($searchParam);
		$this->repository->setPresenter(BillPaySerializerPresenter::class);
		$this->repository
			->pushCriteria(new FindByNameCriteria($search))
			->pushCriteria(new FindByValueBRCriteria($search))
			->pushCriteria(new FindBetweenDateBRCriteria($search));
		$billPays = $this->repository->paginate(15);
		return $billPays;
	}

	public function store(BillPayRequest $request){
		$billPay = $this->repository->create($request->all());
		return response()->json($billPay, 201);
	}

	public function show($id){
		$billPay = $this->repository->find($id);
		return response()->json($billPay);
	}

	public function update(BillPayRequest $request, $id){
		$billPay = $this->repository->update($request->all(), $id);
		return response()->json($billPay);
	}

	public function destroy($id){
		$this->repository->delete($id);
		return response()->json([], 204);
	}
}
