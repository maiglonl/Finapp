<?php

namespace Finapp\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Finapp\Models\BankAccount;
use Finapp\Models\Statement;

abstract class AbstractBill extends Model implements Transformable, BillRepeatTypeInterface{
	use TransformableTrait;
	use BelongsToTenants;
	use BillTrait;

	public static $enableTenant = true;
    protected $fillable = [
    	'date_due',
    	'name',
    	'value',
    	'done',
    	'bank_account_id',
    	'category_id'
    ];

    protected $casts = [
    	'value' => 'float', 
    	'done' => 'boolean'
    ];

    public function bankAccount(){
    	return $this->belongsTo(BankAccount::class);
    }


    public function statements(){
    	return $this->morphMany(Statement::class, 'statementable');
    }
}
