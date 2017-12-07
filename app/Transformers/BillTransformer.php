<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\AbstractBill;
use Finapp\Transformers\CategoryTransformer;

/**
 * Class BillTransformer
 * @package namespace Finapp\Transformers;
 */
class BillTransformer extends TransformerAbstract{
	protected $availableIncludes = ["category", "bankAccount"];

	/**
	 * Transform the \AbstractBill entity
	 * @param \AbstractBill $model
	 *
	 * @return array
	 */
	public function transform(AbstractBill $model){
		return [
			'id'        		=> (int) $model->id,
			'date_due'			=> $model->date_due,
			'name'				=> $model->name,
			'value'				=> $model->value,
			'done'				=> $model->done,
			'category_id'		=> (int) $model->category_id,
			'bank_account_id'	=> (int) $model->bank_account_id,
			'created_at'		=> $model->created_at,
			'updated_at'		=> $model->updated_at
		];
	}

	public function includeCategory(AbstractBill $model){
		$transformer = new CategoryTransformer();
		$transformer->setDefaultIncludes([]);
		return $this->item($model->category, $transformer);
	}

	public function includeBankAccount(AbstractBill $model){
		return $this->item($model->bankAccount, new BankAccountTransformer());
	}
}
