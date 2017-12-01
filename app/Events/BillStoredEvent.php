<?php

namespace Finapp\Events;

class BillStoredEvent{

	private $model;
	private $modelOld;

	/**
	 * Create a new event instance.
	 *
	 * @param $model
	 * @param $modelOld
	 * @return void
	 */
	public function __construct($model, $modelOld = null){
		$this->model = $model;
		$this->modelOld = $modelOld;
	}

	public function getModel(){
		return $this->model;
	}

	public function getModelOld(){
		return $this->modelOld;
	}
}
