<?php

namespace Finapp\Iugu;

use Finapp\Iugu\Exceptions\IuguPaymentMethodException;
use Carbon\Carbon;

class IuguPaymentMethodClient {

	public function create(array $attributes){
		$attributes['set_as_default'] = true;
		$attributes['description'] = 'Inserido em '.(new Carbon())->format('d/m/Y');
		$result = \Iugu_PaymentMethod::create($attributes);
		if(isset($result['errors'])){
			throw new IuguPaymentMethodException($result['errors']);
		}
		return $result;

	}
}