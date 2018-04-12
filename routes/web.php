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
		Route::resource('banks', 'Admin\BanksController', ['except' => 'show']);
	});
});

Route::group(['prefix' => '/', 'as' => 'site.'], function(){
	Route::get('/', function(){
		return view('site.home');
	})->name('home');

	Route::get('register', 'Site\Auth\RegisterController@create')->name('auth.register.create');
	Route::post('register', 'Site\Auth\RegisterController@store')->name('auth.register.store');

	Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function(){
		Route::get('successfully', 'Site\SubscriptionsController@successfully')->name('successfully');
		Route::get('create', 'Site\SubscriptionsController@create')->name('create');
		Route::post('store', 'Site\SubscriptionsController@store')->name('store');
	});

	Route::group(['prefix' => 'my-financial', 'as' => 'my-financial' ,'middleware' => 'auth.from_token'], function(){
		Route::get('/', function(){
			echo 'teste';
		});
	});

	Route::get('login', 'Site\Auth\LoginController@showLoginForm')->name('auth.login.login');
	Route::post('login', 'Site\Auth\LoginController@login');
	Route::post('logout', 'Site\Auth\LoginController@logout');

});