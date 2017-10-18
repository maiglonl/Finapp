<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Requests\CategoryRequest;
use Finapp\Criteria\FindRootCategoriesCriteria;

trait CategoriesControllerTrait {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$this->repository->pushCriteria(new FindRootCategoriesCriteria());
			
		$categories = $this->repository->all();
		return $categories;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  CategoryRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoryRequest $request){
		$category = $this->repository->skipPresenter()->create($request->all());
		$this->repository->skipPresenter(false);
		$category = $this->repository->find($category->id);
		return response()->json($category, 201);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$category = $this->repository->find($id);
		return response()->json($category, 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  CategoryRequest $request
	 * @param  string            $id
	 *
	 * @return Response
	 */
	public function update(CategoryRequest $request, $id){
		$category = $this->repository->skipPresenter()->update($request->all(), $id);
		$this->repository->skipPresenter(false);
		$category = $this->repository->find($category->id);
		return response()->json($category, 200);
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
