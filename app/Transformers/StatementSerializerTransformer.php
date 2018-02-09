<?php

namespace Finapp\Transformers;

use League\Fractal\TransformerAbstract;
use Finapp\Models\StatementSerializer;
use Finapp\Presenters\StatementPresenter;

/**
 * Class StatementTransformer
 * @package namespace Finapp\Transformers;
 */
class StatementTransformer extends TransformerAbstract{

	private $statementPresenter;

	public function __construct(StatementPresenter $statementPresenter){
		$this->statementPresenter = $statementPresenter;
	}

	public function transform(StatementSerializer $serializer){
		return [
			'statement' => $this->statementPresenter->present($serializer->getStatements()),
			'statement_data' => $serializer->getStatementData()
		];
	}
}