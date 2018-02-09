<?php

namespace Finapp\Presenters;

use Finapp\Transformers\StatementTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatementPresenter
 *
 * @package namespace Finapp\Presenters;
 */
class StatementPresenter extends FractalPresenter{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer(){
        return new StatementTransformer();
    }
}
