<?php

namespace Finapp\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Interface StatementRepository
 * @package namespace Finapp\Repositories;
 */
interface StatementRepository extends RepositoryInterface
{
    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd);
    public function getCashFlowByPeriod(Carbon $dateStart, Carbon $dateEnd);
    public function getBalanceByMonth(Carbon $date);
}
