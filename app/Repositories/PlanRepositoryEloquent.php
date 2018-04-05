<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\PlanRepository;
use Finapp\Models\Plan;
use Finapp\Validators\PlanValidator;

/**
 * Class PlanRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
