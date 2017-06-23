<?php

namespace Finapp\Repositories;

use Finapp\Events\BankStoredEvent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Models\Bank;
use Finapp\Repositories\BankRepositoryEloquent;
use Finapp\Presenters\BankPresenter;

/**
 * Class BankRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository{

	/**
	 * Create Repository
	 * @param  array  $attributes [description]
	 * @return Repository         [description]
	 */
	public function create(array $attributes){
		$logo = $attributes["logo"];
		$attributes["logo"] = env('BANK_LOGO_DEFAULT');
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter(true);
		$model = parent::create($attributes);
		$event = new BankStoredEvent($model, $logo);
		event($event);
		$this->skipPresenter = $skipPresenter;

		return $this->parserResult($model);
	}

	/**
	 * Update Repository
	 * @param  array  $attributes [description]
	 * @return Repository         [description]
	 */
	public function update(array $attributes, $id){
		$logo = null;
		if(isset($attributes["logo"]) && $attributes["logo"] instanceof UploadedFile){
			$logo = $attributes["logo"];
			unset($attributes["logo"]);
		}

		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter(true);
		$model = parent::update($attributes, $id);
		event(new BankStoredEvent($model, $logo));
		$this->skipPresenter = $skipPresenter;

		return $this->parserResult($model);
	}

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model(){
		return Bank::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot(){
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter(){
		return BankPresenter::class;
	}
}
