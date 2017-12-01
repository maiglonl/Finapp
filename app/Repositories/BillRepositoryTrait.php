<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Presenters\BillPresenter;
use Finapp\Events\BillStoredEvent;

trait BillRepositoryTrait{

	protected $fieldSearchable = [
		'name' => 'like'
	]

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
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
    	return BillPresenter::class;
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