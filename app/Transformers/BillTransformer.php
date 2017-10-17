<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\AbstractBill;

/**
 * Class BillTransformer
 * @package namespace Finapp\Transformers;
 */
class BillTransformer extends TransformerAbstract{

	/**
	 * Transform the \AbstractBill entity
	 * @param \AbstractBill $model
	 *
	 * @return array
	 */
	public function transform(AbstractBill $model){
		return [
			'id'        	=> (int) $model->id,
			'date_due'		=> $model->date_due,
			'name'			=> $model->name,
			'value'			=> (float)$model->value,
			'done'			=> (boolean)$model->done,
			'created_at'	=> $model->created_at,
			'updated_at'	=> $model->updated_at
		];
	}
}
