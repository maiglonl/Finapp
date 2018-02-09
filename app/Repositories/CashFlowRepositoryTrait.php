<?php

namespace Finapp\Repositories;

use Carbon\Carbon;
use Finapp\Models\BillPay;
use Finapp\Models\BillReceive;
use Finapp\Models\CategoryExpense;
use Finapp\Models\CategoryRevenue;

trait CashFlowRepositoryTrait{

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
		return $this->formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth);
	}

	protected function formatCategories($collection){
		$categories = $collection->unique('name')->pluck('name', 'id')->all();
		$arrayResult = [];
		foreach ($categories as $id => $name) {
			$filtered = $collection->where('id', $id)->where('name', $name);
			$monthsYear = [];
			$filtered->each(function($category) use(&$monthsYear){
				$monthsYear[] = [
					'total' => $category->total,
					'month_year' => $category->month_year
				];
			});
			$arrayResult[] = [
				'id' => $id,
				'name' => $name,
				'months' => $monthsYear
			];
		}
		return $arrayResult;
	}

	protected function formatMonthsYear($expensesCollection, $revenuesCollection){
		$monthsYearRevenueCollection = $revenuesCollection->pluck('month_year');
		$monthsYearExpenseCollection = $expensesCollection->pluck('month_year');
		$monthsYearsCollection = $monthsYearExpenseCollection->merge($monthsYearRevenueCollection)->unique()->sort();
		$monthsYearList = [];
		$monthsYearsCollection->each(function($monthYear) use(&$monthsYearList){
			$monthsYearList[$monthYear] = [
				'month_year' => $monthYear,
				'revenues' => ['total' => 0],
				'expenses' => ['total' => 0]
			];
		});

		foreach ($monthsYearRevenueCollection as $monthYear) {
			$monthsYearList[$monthYear]['revenues']['total'] = $revenuesCollection->where('month_year', $monthYear)->sum('total');
		}
		foreach ($monthsYearExpenseCollection as $monthYear) {
			$monthsYearList[$monthYear]['expenses']['total'] = $expensesCollection->where('month_year', $monthYear)->sum('total');
		}

		return array_values($monthsYearList);
	}

	protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth){
		$monthsYearList = $this->formatMonthsYear($expensesCollection, $revenuesCollection);
		$expensesFormatted = $this->formatCategories($expensesCollection);
		$revenuesFormatted = $this->formatCategories($revenuesCollection);
		$collectionFormatted = [
			'months_list' => $monthsYearList,
			'balance_before_first_month' => $balancePreviousMonth,
			'categories_months' => [
				'expenses' => [
					'data' => $expensesFormatted
				],
				'revenues' => [
					'data' => $revenuesFormatted
				],
			]
		];
		return $collectionFormatted;
	}

	protected function getCategoriesValuesCollection($model, $billTable, Carbon $dateStart, Carbon $dateEnd){
		$dateStartStr = $dateStart->copy()->day(1)->format('Y-m-d');
		$dateEndStr = $dateEnd->copy()->day($dateEnd->daysInMonth)->format('Y-m-d');

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

}