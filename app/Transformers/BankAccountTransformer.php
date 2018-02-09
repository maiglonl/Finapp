<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\BankAccount;
use Finapp\Transformers\BankTransformer;

/**
 * Class BankAccountTransformer
 * @package namespace Finapp\Transformers;
 */
class BankAccountTransformer extends TransformerAbstract{

	protected $availableIncludes = ['bank'];

	/**
	 * Transform the \BankAccount entity
	 * @param \BankAccount $model
	 *
	 * @return array
	 */
	public function transform(BankAccount $model){
		return [
			'id'			=> (int) $model->id,
			'name'			=> $model->name,
			'agency'		=> $model->agency,
			'account'		=> $model->account,
			'balance'		=> (float) $model->balance,
			'default'		=> (bool) $model->default,
			'bank_id'		=> (int) $model->bank_id,
			'created_at'	=> $model->created_at,
			'updated_at'	=> $model->updated_at
		];
	}

	public function includeBank(BankAccount $model){
		return $this->item($model->bank, new BankTransformer());
	}
}
