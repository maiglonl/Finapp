<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Finapp\Http\Requests;
use Finapp\Http\Requests\BillReceiveRequest;
use Finapp\Repositories\BillReceiveRepository;

class BillReceivesController extends Controller
{
	protected $repository;

	public function __construct(BillReceiveRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		$billReceives = $this->repository->paginate(3);
		return $billReceives;
	}

	public function store(BillReceiveRequest $requst)
	{
		$billReceive = $this->repository->create($request->all());
		return response()->json($billReceive, 201);
	}

	public function show($id)
	{
		$billReceive = $this->repository->find($id);
		return response()->json($billReceive);
	}

	public function update(BillReceiveRequest $request, $id)
	{
		$billReceive = $this->repository->update($request->all(), $id);
		return response()->json($billReceive);
	}

	public function destroy($id)
	{
		$this->repository->delete($id);
		return response()->json([], 204);
}
