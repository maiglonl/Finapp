<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\BankAccountRepository;
use Finapp\Presenters\BankAccountPresenter;
use Finapp\Models\BankAccount;

/**
 * Class BankAccountRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository{

	protected $skipPresenter = false;

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
