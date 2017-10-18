<?php

namespace Finapp\Http\Controllers\Api;

use Finapp\Http\Controllers\Controller;
use Finapp\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{
	use AuthenticatesUsers;

	public function accessToken(Request $request){
		$this->validateLogin($request);

		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);
			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->credentials($request);
		if($token = Auth::guard('api')->attempt($credentials)){
			return $this->sendLoginResponse($request, $token);
		}

		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	public function refreshToken(Request $request){
		$token = Auth::guard('api')->refresh();
		return $this->sendLoginResponse($request, $token);
	}

	protected function sendLoginResponse(Request $request, $token){
		$this->clearLoginAttempts($request);
		dd(Auth::user('api'));
		return response()->json([
			'token' => $token
		]);
	}

	protected function sendLockoutResponse(Request $request, $token){
		$seconds = $this->limiter()->availableIn(
			$this->throttleKey($request)
		);

		$message = Lang::get('auth.throttle', ['seconds' => $seconds]);
		return response()->json([
			'message' => $message
		], 403);
	}

	protected function sendFailedLoginResponse(Request $request){
		$message = Lang::get('auth.failed');
		return response()->json([
			'message' => $message
		], 400);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request){
		Auth::guard('api')->logout();
		return response()->json([],204);
	}
}
