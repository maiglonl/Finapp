<?php

namespace Finapp\Iugu\Exceptions;

class AbstractIuguException extends \Exception{
	private $errors;

	public function __construct($errors = null, $message = "", $code = 0, \Exception $previous = null){
		$this->errors = $errors;
		parent::__construct($message, $code, $previous);
	}
}