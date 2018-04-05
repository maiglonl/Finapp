<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Presenters\BillPresenter;
use Finapp\Events\BillStoredEvent;
use Finapp\Serializers\BillSerializer;

trait BillRepositoryTrait{

	public function create(array $attributes){
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter(true);
		$model = parent::create($attributes);
		event(new BillStoredEvent($model));
		$this->repeatBill($attributes);
		$this->skipPresenter = $skipPresenter;
		return $this->parserResult($model);
	}

	public function update(array $attributes, $id){
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter(true);
		$modelOld = $this->find($id);
		$model = parent::update($attributes, $id);
		event(new BillStoredEvent($model, $modelOld));
		$this->repeatBill($attributes);
		$this->skipPresenter = $skipPresenter;
		return $this->parserResult($model);
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot(){
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter(){
		return BillPresenter::class;
	}

	public function paginate($limit = null, $columns = ['*'], $method="paginate"){
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter();
		$collection = parent::paginate($limit, $columns, $method);
		$this->skipPresenter($skipPresenter);
		return $this->parserResult(new BillSerializer($collection, $this->formatBillsData()));
	}

	public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd){
		$result = $this->getQueryTotal()
			->whereBetween('date_due', [$dateStart->format('Y-m-d'), $dateEnd->format('Y-m-d')])
			->get();
		return [
			'total' => (float)$result->first()->total
		];
	}

	protected function getTotalByDone($done){
		$result = $this->getQueryTotalByDone($done)->get();
		return (float)$result->first()->total;
	}

	protected function getQueryTotal(){
		$this->resetModel();
		$this->applyCriteria();
		return $this->model->selectRaw('SUM(value) as total');
	}

	protected function getQueryTotalByDone($done){
		return $this->getQueryTotal()->where('done', '=', $done);
	}

	protected function getTotalExpired(){
		$result = $this->getQueryTotalByDone(0)
			->where('date_due', '<', (new Carbon())->format('Y-m-d'))
			->get();
		return (float)$result->first()->total;
	}

	protected function formatBillsData(){
		$paid = $this->getTotalByDone(1);
		$toPay = $this->getTotalByDone(0);
		$expired = $this->getTotalExpired();
		return[
			'total_paid' => $paid,
			'total_to_pay' => $toPay,
			'total_expired' => $expired
		];
	}

	protected function repeatBill(array $attributes){
		if(isset($attributes['repeat'])){
			$repeat = filter_var($attributes['repeat'], FILTER_VALIDATE_BOOLEAN);
			if($repeat){
				$repeatNumber = (int)$attributes['repeat_number'];
				$repeatType = (int)$attributes['repeat_type'];
				$dateDue = $attributes['date_due'];
				foreach (rang(1, $repeatNumber) as $key => $value) {
					$newDate = $this->model->addDate($dateDue, $value, $repeatType);
					$model = parent::create(array_merge($attributes, ['date_due' => $newDate->format('Y-m-d')]));
					event(new BillStoredEvent($model));
				}
			}
		}
	}
}