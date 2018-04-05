<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

/**
 * Interface BillReceiveRepository
 * @package namespace Finapp\Repositories;
 */
interface BillReceiveRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd);
}
