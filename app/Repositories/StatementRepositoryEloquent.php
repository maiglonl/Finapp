<?php

namespace Finapp\Repositories;

use Finapp\Models\BillPay;
use Finapp\Models\BillReceive;
use Finapp\Models\Statement;
use Finapp\Presenters\StatementSerializerPresenter;
use Finapp\Serializers\StatementSerializer;
use Prettus\Repository\Eloquent\BaseRepository;
use Finapp\Repositories\StatementRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class StatementRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{

	use CashFlowRepositoryTrait;

	public function paginate($limit = null, $columns = ['*'], $method = "paginate"){
		$skipPresenter = $this->skipPresenter;
		$this->skipPresenter();
		$collection = parent::paginate($limit, $columns, $method);
		$this->skipPresenter($skipPresenter);
		return $this->parseResult(new StatementSerializer($collection, $this->formatStatementsData()));
	}

	public function getCountAndTotalByBill($billType){
		$this->resetModel();
		$this->applyCriteria();
		$collection = $this->model->selectRaw('COUNT(id) as count, SUM(value) as total')
			->where('statementable_type', '=', $billType)->get();
		$result = $collection->first();
		return [
			'count' => (float)$result->count,
			'total' => (float)$result->total
		];
	}

	protected function formatStatementsData(){
		$resultRevenue = $this->getCountAndTotalByBill(BillReceive::class);
		$resultExpense = $this->getCountAndTotalByBill(BillPay::class);

		return [
			'count' => $resultRevenue['count'] + $resultExpense['count'],
			'revenues' => ['total' => $resultRevenue['total']],
			'expenses' => ['total' => $resultExpense['total']]
		];
	}

	public function create(array $attributes){
		$statementable = $attributes['statementable'];
		return $statementable->statements()->create(array_except($attributes, 'statementable'));
	}

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }


	public function presenter(){
		return StatementSerializerPresenter::class;
	}    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
