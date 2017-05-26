<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/client', function () {
	\Illuminate\Support\Facades\Auth::loginUsingId(2);
});

Route::get('/', function () {
	return view('welcome');
});

Route::get('/app', function () {
	return view('layouts.spa');
});

Route::get('/home', function () {
	return redirect()->route('admin.home');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){

	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// Registration Routes...
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');

	Route::group(['middleware' => 'can:access-admin'], function(){
		Route::get('/home', 'HomeController@index')->name('home');
	});
});