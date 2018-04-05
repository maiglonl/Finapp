<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Serializers\BillSerializer;
use Finapp\Presenters\BillPresenter;
use Finapp\Transformers\CategoryTransformer;

/**
 * Class BillSerializerTransformer
 * @package namespace Finapp\Transformers;
 */
class BillSerializerTransformer extends TransformerAbstract{
	private $billPresenter;

	public function __construct(BillPresenter $billPresenter){
		$this->billPresenter = $billPresenter;
	}

	public function transform(BillSerializer $serializer){
		return [
			'bills'		=> $this->billPresenter->present($serializer->getBills()),
			'bill_data'	=> $serializer->getBillData()
		];
	}

}
