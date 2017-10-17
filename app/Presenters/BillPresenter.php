<?php

namespace Finapp\Presenters;

use Finapp\Transformers\BillTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class BillPresenter extends FractalPresenter{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer(){
		return new BillTransformer();
	}
}
