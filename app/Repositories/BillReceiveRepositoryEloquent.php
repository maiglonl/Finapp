<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Finapp\Repositories\BillReceiveRepository;
use Finapp\Models\BillReceive;

/**
 * Class BillReceiveRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class BillReceiveRepositoryEloquent extends BaseRepository implements BillReceiveRepository {

	use BillRepositoryTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillReceive::class;
    }

}
