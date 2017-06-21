<?php

namespace Finapp\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bank extends Model implements Transformable
{
	use TransformableTrait;

	protected $fillable = [
		'name',
		'logo'
	];

	public static function logosDir(){
		return 'banks/images';
	}

	public function getLogoPathAttribute(){
		return "storage/banks/images/$this->logo";
	}
}
