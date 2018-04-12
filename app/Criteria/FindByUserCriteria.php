<?php

namespace Finapp\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByUserCriteria
 * @package namespace Finapp\Criteria;
 */
class FindByUserCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
    	error_log(\Auth::user()->id);
        return $model->where('user_id', \Auth::user()->id);
    }
}
