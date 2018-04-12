<?php

namespace Finapp\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
	use TransformableTrait;

	const STATUS_PENDING = 1;
	const STATUS_PAID = 2;

	protected $fillable = [
		'date_due',
		'payment_date',
		'subscription_id',
		'payment_url',
		'code',
		'status',
		'value'
	];

}
