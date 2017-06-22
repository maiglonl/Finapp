<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\BankAccount;

/**
 * Class BankAccountTransformer
 * @package namespace Finapp\Transformers;
 */
class BankAccountTransformer extends TransformerAbstract{

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
			'dafault'		=> (bool) $model->dafault,
			'created_at'	=> $model->created_at,
			'updated_at'	=> $model->updated_at
		];
	}
}
