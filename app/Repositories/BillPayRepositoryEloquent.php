<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Finapp\Repositories\BillPayRepository;
use Finapp\Models\BillPay;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Presenters\BillPresenter;

/**
 * Class BillPayRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BillPayRepositoryEloquent extends BaseRepository implements BillPayRepository {

	use BillRepositoryTrait;

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return BillPay::class;
	}

	public function boot(){
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function presenter(){
		return BillPresenter::class;
	}
}
