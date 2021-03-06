<?php

namespace Finapp\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Repositories\UserRepository;
use Finapp\Models\User;
use Finapp\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

	public function create(array $attributes)
	{
		$attributes['password'] = bcrypt($attributes['password']);
		$model = parent::create($attributes);
		return $model;
	}


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
