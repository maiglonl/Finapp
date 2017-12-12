<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Finapp\Models\Statement;
use Finapp\Models\BillPay;
use Finapp\Models\BillReceive;
use Finapp\Models\CategoryExpense;
use Finapp\Models\CategoryRevenue;
use Finapp\Repositories\StatementRepository;

/**
 * Class StatementRepositoryEloquent
 * @package namespace Finapp\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{

	public function create(array $attributes){
		$statementable = $attributes['statementable'];
		return $statementable->statements()->create(array_except($attributes, 'statementable'));
	}

	public function getCashFlow(Carbon $dateStart, Carbon $dateEnd){
		$datePrevious = $dateStart->copy()->day(1)->subMonths(2);
		$datePrevious->day($datePrevious->daysInMonth);
		$balancePreviousMonth = $this->getBalanceByMonth($datePrevious);

		$revenuesCollection = $this->getCategoriesValuesCollection(
			new CategoryRevenue(),
			(new BillReceive())->getTable(),
			$dateStart,
			$dateEnd
		);

		$expensesCollection = $this->getCategoriesValuesCollection(
			new CategoryExpense(),
			(new BillPay())->getTable(),
			$dateStart,
			$dateEnd
		);
		return $this->formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth){
	}

	protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth){
		
	}

	protected function getCategoriesValuesCollection($model, $billTable, Carbon $dateStart, Carbon $dateEnd){
		$dateStartStr = $dateStart->copy()->day(1)->format('Y-m-d');
		$dateEndStr = $dateEnd->copy()->day($dateEnd->daysInMonth->format('Y-m-d'));

		$firstDateStart = $dateStart->copy()->subMonths(1);
		$firstDateStartStr = $firstDateStart->format('Y-m-d');

		$firstDateEnd = $firstDateStart->copy()->day($firstDateStart->daysInMonth);
		$firstDateEndStr = $firstDateEnd->format('Y-m-d');

		$firstCollection = $this->getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $firstDateStartStr, $firstDateEndStr)->get();
		$mainCollection = $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStartStr, $dateEndStr)->get();

		$firstCollection->reverse()->each(function($value) use($mainCollection){
			$mainCollection->prepend($value);
		});

		return $mainCollection;
	}

	protected function getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $dateStart, $dateEnd){
		return $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
			->where('done', 1);
	}


	protected function getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd){
		$table = $model->getTable();
		list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];
		return $model
			->addSelect("$table.id")
			->addSelect("$table.name")
			->selectRaw("SUM(value) as total")
			->selectRaw("DATE_FORMAT(date_due, '%Y-%m') as month_year")
			->join("$table as child", function($join) use($table, $lft, $rgt){
				$join->on("$table.$lft", "<=", "child.$lft")
					->whereRaw("$table.$rgt >= child.$rgt");
			})
			->join($billTable, "$billTable.category_id", '=', 'child.id')
			->selectSub($this->getQueryWithDepth($model), 'depth')
			->whereBetween('date_due', [$dateStart, $dateEnd])
			->groupBy("$table.id", "$table.name", "month_year")
			->havingRaw("depth = 0")
			->orderBy("month_year")
			->orderBy("$table.name");
	}

	protected function getQueryWithDepth($model){
		$table = $model->getTable();

		list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

		$alias = "_d";

		return $model
			->newScopedQuery($alias)
			->toBase()
			->selectRaw('count(1) - 1')
			->from("{$table} as {$alias}")
			->whereRaw("{$table}.{$lft} between {$alias}.{$lft} and {$alias}.{$rgt}");
	}

	public function getBalanceByMonth(Carbon $date){
		$dateString = $date->copy()->day($date->daysInMonth)->format('Y-m-d');
		$modelClass = $this->model();

		$subQuery = (new $modelClass)
			->toBase()
			->selectRaw("bank_account_id, MAX(statements.id) as maxid")
			->whereRaw("statements.created_at <= '$dateString'")
			->groupBy("bank_account_id");

		$result = (new $modelClass)
			->selectRaw("SUM(statements.balance) as total")
			->join(\DB::raw("({$subQuery->toSql()}) as s"), 'statements.id',  '=', 's.maxid')
			->mergeBindings($subQuery)
			->get();
		return $result->first()->total === null ? 0 : $result->first()->total;
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

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
