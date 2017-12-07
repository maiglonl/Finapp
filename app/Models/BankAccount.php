<?php

namespace Finapp\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Finapp\Models\Bank;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BankAccount extends Model implements Transformable{
	use TransformableTrait;
	use BelongsToTenants;

	protected $fillable = [
		'name', 
		'agency', 
		'account', 
		'bank_id', 
		'default'
	];

	protected $casts = [
		'balance' => 'float'
	];

	public function bank(){
		return $this->belongsTo(Bank::class);
	}

}
