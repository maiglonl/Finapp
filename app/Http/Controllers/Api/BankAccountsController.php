<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Finapp\Http\Controllers\Response;
use Finapp\Http\Requests\BankAccountCreateRequest;
use Finapp\Http\Requests\BankAccountUpdateRequest;
use Finapp\Repositories\BankAccountRepository;


class BankAccountsController extends Controller{

	/**
	 * @var BankAccountRepository
	 */
	protected $repository;

	public function __construct(BankAccountRepository $repository){
		$this->repository = $repository;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$bankAccounts = $this->repository->all();
		return $bankAccounts;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  BankAccountCreateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(BankAccountCreateRequest $request){
		$bankAccount = $this->repository->create($request->all());
		return response()->json($bankAccount, 201);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$bankAccount = $this->repository->find($id);
		return response()->json($bankAccount, 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  BankAccountUpdateRequest $request
	 * @param  string            $id
	 *
	 * @return Response
	 */
	public function update(BankAccountUpdateRequest $request, $id){
		$bankAccount = $this->repository->update($request->all(), $id);
		return response()->json($bankAccount, 200);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		$this->repository->delete($id);

		return response()->json([], 204);
	}
}
