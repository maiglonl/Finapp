<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\Statement;

/**
 * Class StatementTransformer
 * @package namespace Finapp\Transformers;
 */
class StatementTransformer extends TransformerAbstract{

	protected $availableIncludes = ['bankAccount'];

	public function transform(Statement $model){
		return [
			'id'				=> (int) $model->id,
			'date'				=> $model->created_at->format('Y-m-d'),
			'value' 			=> $model->value,
	    	'balance'			=> $model->balance,
	    	'bank_account_id'	=> (int) $model->bank_account_id,
			'updated_at'		=> $model->updated_at
		];
	}

	public function includeBankAccount(Statement $model){
		return $this->item($model->bankAccount, new BankAccountTransformer());
	}
}