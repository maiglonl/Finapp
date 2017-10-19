<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Finapp\Http\Requests;
use Finapp\Http\Requests\BillPayRequest;
use Finapp\Repositories\BillPayRepository;

class BillPaysController extends Controller
{
	protected $repository;

	public function __construct(BillPayRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		error_log("index");
		$billPays = $this->repository->paginate(3);
		return $billPays;
	}

	public function store(BillPayRequest $requst)
	{
		error_log("store");
		$billPay = $this->repository->create($request->all());
		return response()->json($billPay, 201);
	}

	public function show($id)
	{
		error_log("show");
		$billPay = $this->repository->find($id);
		return response()->json($billPay);
	}

	public function update(BillPayRequest $request, $id)
	{
		error_log("update");
		$billPay = $this->repository->update($request->all(), $id);
		return response()->json($billPay);
	}

	public function destroy($id)
	{
		error_log("destroy");
		$this->repository->delete($id);
		return response()->json([], 204);
	}
}
