<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\StatementRepository;
use Finapp\Models\Statement;
use Finapp\Validators\StatementValidator;

/**
 * Class StatementRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
