<?php

namespace Finapp\Serializers;

use Illuminate\Contracts\Support\Jsonable;

class BillSerializer implements Jsonable{

	private $bills;
	private $billData;

	public function __construct($bills, $billData){
		$this->bills = $bills;
		$this->billData = $billData;
	}

	public function toJson($options = 0)
	{
		$bills = $this->bills->jsonSerialize();
		return json_encode([
			'bills' => $bills,
			'bill_data' => $this->billData
		], $options);
	}

	public function getBillData(){
		return $this->billData;
	}

	public function getBills(){
		return $this->bills;
	}
}