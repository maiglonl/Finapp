<?php

namespace Finapp\Presenters;

use Finapp\Transformers\StatementSerializerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatementPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class StatementSerializerPresenter extends FractalPresenter{

	private $statementPresenter;

	public function __construct(StatementPresenter $statementPresenter){
		parent::__construct();
		$this->statementPresenter = $statementPresenter;
	}

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer(){
        return new StatementSerializerTransformer($this->statementPresenter);
    }
}
