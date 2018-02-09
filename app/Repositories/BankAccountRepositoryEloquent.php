<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\BankAccountRepository;
use Finapp\Presenters\BankAccountPresenter;
use Finapp\Models\BankAccount;
use Finapp\Criteria\LockTableCriteria;
use Finapp\Events\BankAccountBalanceUpdatedEvent;

/**
 * Class BankAccountRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository{

	protected $skipPresenter = false;
	protected $fieldSearchable = [
		'name' => 'like', 
		'agency' => 'like', 
		'account' => 'like', 
		'bank.name' => 'like'
	];

	public function addBalance($id, $value){
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter(true);
		\DB::beginTransaction();
		$this->pushCriteria(new LockTableCriteria());
		$model = $this->find($id);
		$model->balance += $value;
		$model->save();
		\DB::commit();
		broadcast(new BankAccountBalanceUpdatedEvent($model));
		$this->popCriteria(LockTableCriteria::class);
		$this->skipPresenter = $skipPresenter;
		return $this->parserResult($model);
	}

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model(){
		return BankAccount::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot(){
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter(){
		return BankAccountPresenter::class;
	}
}
