<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Repositories\BankRepository;
use Finapp\Http\Controllers\Controller;

class BanksController extends Controller{
	/*
	 * @var BankRepositorye
	 */
	private $repositorie;

	function __construct(BankRepository $repositorie){
		$this->repositorie = $repositorie;
	}

	public function index(){
		return $this->repositorie->all();
	}
}
