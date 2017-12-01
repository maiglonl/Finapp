<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Finapp\Repositories\BillPayRepository;
use Finapp\Models\BillPay;

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

}
