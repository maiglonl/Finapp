<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Repositories\UserRepository;
use Finapp\Http\Controllers\Controller;

class RegisterController extends Controller{
	/*
	 * @var UserRepositorye
	 */
	private $repositorie;

	function __construct(UserRepository $repositorie){
		$this->repositorie = $repositorie;
	}

	public function create(){
		return view('site.auth.register');
	}

	public function store(){
	}
}
