<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\BillPayRepository;
use Finapp\Models\BillPay;
use Finapp\Validators\BillPayValidator;
use Finapp\Presenters\BillPresenter;

/**
 * Class BillPayRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BillPayRepositoryEloquent extends BaseRepository implements BillPayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillPay::class;
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
}
