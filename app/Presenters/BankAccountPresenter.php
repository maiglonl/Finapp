<?php

namespace Finapp\Presenters;

use Finapp\Presenters\BankAccountPresenter;
use Finapp\Transformers\BankAccountTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BankAccountPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class BankAccountPresenter extends FractalPresenter{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer(){
		return new BankAccountTransformer();
	}
}
