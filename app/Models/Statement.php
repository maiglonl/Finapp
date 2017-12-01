<?php

namespace Finapp\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Finapp\Models\BankAccount;

class Statement extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
    	'value', 
    	'balance',
    	'bank_account_id'
    ];

    public function bankAccount(){
    	return $this->belongsTo(BankAccount::class);
    }

    public function statementable(){
    	return $this->morphTo();
    }
}
