<?php

namespace Finapp\Presenters;

use Finapp\Presenters\BillPresenter;
use Finapp\Transformers\BillSerializerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillReceiveSerializerPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class BillReceiveSerializerPresenter extends FractalPresenter{

	private $billPresenter;

	public function __construct(BillPresenter $billPresenter){
		parent::__construct();
		$this->billPresenter = $billPresenter;
	}

	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer(){
		return new BillSerializerTransformer($this->billPresenter);
	}
}
