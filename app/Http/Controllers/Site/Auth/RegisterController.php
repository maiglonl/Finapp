<?php

namespace Finapp\Http\Controllers\Site\Auth;

use Finapp\Http\Controllers\Controller;
use Finapp\Http\Requests\UserRegisterRequest;
use Finapp\Repositories\UserRepository;
use Finapp\Repositories\ClientRepository;
use Auth;

class RegisterController extends Controller{
	/*
	 * @var UserRepositorye
	 */
	private $userRepositorie;
	private $clientRepositorie;

	function __construct(UserRepository $userRepositorie, ClientRepository $clientRepositorie){
        $this->middleware('guest');
		$this->userRepositorie = $userRepositorie;
		$this->clientRepositorie = $clientRepositorie;
	}

	public function create(){
		return view('site.auth.register');
	}

	public function store(UserRegisterRequest $request){
		$clientData = $request->get('client');
		$client = $this->clientRepositorie->create($clientData);
		$data = $request->except('client');
		$data['client_id'] = $client->id;
		$user = $this->userRepository->create($data);
		Auth::loginUsingId($user->id);

		return redirect()->route('site.subscriptions.create');
	}
}
