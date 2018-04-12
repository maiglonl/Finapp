<?php

namespace Finapp\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindSubscriptionByUserClientCriteria
 * @package namespace Finapp\Criteria;
 */
class FindSubscriptionByUserClientCriteria implements CriteriaInterface
{
	private $clientId;

	public function __construct($id)
	{
		$this->clientId = $id;
	}

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
        return $model
        	->join('users', 'users.id', '=', 'subscriptions.user_id')
        	->join('clients', 'users.client_id', '=', 'clients.id')
        	->where('clients.id', '=', $this->clientId);
    }
}
