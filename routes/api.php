<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('hooks/iugu', 'Api\IuguController@hooks');
Route::group(['middleware' => ['cors', 'api'], 'as' => 'api.'], function(){
	Route::post('/access_token', 'Api\AuthController@accessToken')->name('access_token')->middleware('check-subscription:after');
	Route::post('/refresh_token', 'Api\AuthController@refreshToken')->name('refresh_token')->middleware('check-subscription:after');
	Route::get('statements/cash_flow', 'Api\StatementsController@listCashFlow');

	Route::group(['middleware' => 'auth:api', 'check-subscription'], function(){
		Route::resource('banks', 'Api\BanksController', ['only' => ['index']]);
		Route::get('bank_accounts/lists', 'Api\BankAccountsController@lists')->name('bank_accounts.lists');
		Route::resource('bank_accounts', 'Api\BankAccountsController', ['except' => ['create', 'edit']]);
		Route::resource('category_expenses', 'Api\CategoryExpensesController', ['except' => ['create', 'edit']]);
		Route::resource('category_revenues', 'Api\CategoryRevenuesController', ['except' => ['create', 'edit']]);

		Route::resource('bill_pays', 'Api\BillPaysController');
		Route::get('bill_pays/total_today', 'Api\BillPaysController@findToPayToday');
		Route::get('bill_pays/total_rest_of_month', 'Api\BillPaysController@findToPayRestOfMonth');

		Route::resource('bill_receives', 'Api\BillReceivesController', ['except' => ['create', 'edit']]);
		Route::get('bill_receives/total_today', 'Api\BillReceivesController@findToPayToday');
		Route::get('bill_receives/total_rest_of_month', 'Api\BillReceivesController@findToPayRestOfMonth');

		Route::get('cash_flows', 'Api\CashFlowsController@index');
		Route::get('cash_flows/monthly', 'Api\CashFlowsController@byPeriod');
		Route::get('statements', 'Api\CashFlowsController@index');
		Route::post('/logout', 'Api\AuthController@logout')->name('logout');
		Route::get('/user', function(Request $request){
			return $request->user('api');
		})->name('user');
	});
});
