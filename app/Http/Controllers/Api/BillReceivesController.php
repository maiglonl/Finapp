<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Finapp\Http\Requests;
use Finapp\Http\Requests\BillReceiveRequest;
use Finapp\Repositories\BillReceiveRepository;
use Finapp\Criteria\FindByNameCriteria;
use Finapp\Criteria\FindByValueBRCriteria;
use Finapp\Criteria\FindBetweenDateBRCriteria;

class BillReceivesController extends Controller {
	protected $repository;

	public function __construct(BillReceiveRepository $repository){
		$this->repository = $repository;
	}

	public function index(Request $request){
		$searchParam = config('repository.criteria.params.search');
		$search = $request->get($searchParam);
		$this->repository
			->pushCriteria(new FindByNameCriteria($search))
			->pushCriteria(new FindByValueBRCriteria($search))
			->pushCriteria(new FindBetweenDateBRCriteria($search));
		$billReceives = $this->repository->paginate(15);
		return $billReceives;
	}

	public function store(BillReceiveRequest $request){
		$billReceive = $this->repository->create($request->all());
		return response()->json($billReceive, 201);
	}

	public function show($id){
		$billReceive = $this->repository->find($id);
		return response()->json($billReceive);
	}

	public function update(BillReceiveRequest $request, $id){
		$billReceive = $this->repository->update($request->all(), $id);
		return response()->json($billReceive);
	}

	public function destroy($id){
		$this->repository->delete($id);
		return response()->json([], 204);
	}
}
