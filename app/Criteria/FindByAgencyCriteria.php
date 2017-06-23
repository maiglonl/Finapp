<?php

namespace Finapp\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByAgencyCriteria
 * @package namespace Finapp\Criteria;
 */
class FindByAgencyCriteria implements CriteriaInterface{

	private $agency;

	function __construct($agency){
		$this->agency = $agency;
	}

	/**
	 * Apply criteria in query repository
	 *
	 * @param                     $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository){
		return $model->where('agency', 'like', '%'.$this->agency.'%');
	}
}
