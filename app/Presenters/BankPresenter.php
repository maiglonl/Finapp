<?php

namespace Finapp\Presenters;

use Finapp\Transformers\BankTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BankPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class BankPresenter extends FractalPresenter{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer(){
		return new BankTransformer();
	}
}
