<?php

namespace Finapp\Models;
use Finapp\Models\CategoryExpense;

class BillPay extends AbstractBill
{
	public function category(){
		return $this->belongsTo(CategoryExpense::class);
	}
}
