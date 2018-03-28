<?php

namespace Finapp\Models;
use Finapp\Models\CategoryRevenue;

class BillReceive extends AbstractBill
{
	public function category(){
		return $this->belongsTo(CategoryRevenue::class);
	}

}
