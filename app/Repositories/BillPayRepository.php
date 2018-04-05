<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

/**
 * Interface BillPayRepository
 * @package namespace Finapp\Repositories;
 */
interface BillPayRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd);
}
