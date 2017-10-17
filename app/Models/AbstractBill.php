<?php

namespace Finapp\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

abstract class AbstractBill extends Model implements Transformable{
	use TransformableTrait;
	use BelongsToTenants;

	public static $enableTenant = true;
    protected $fillable = [
    	'date_due',
    	'name',
    	'value',
    	'done'
    ];

}
