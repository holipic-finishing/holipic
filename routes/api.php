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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'],function(){
	
	Route::resource('packages', 'PackageAPIController');

	Route::get('list/packages', 'PackageAPIController@getListNamePackage');
	
	Route::resource('roles', 'roleAPIController');

	Route::resource('user_roles', 'UserRoleAPIController');

	Route::resource('users', 'UserAPIController');

	Route::get('count-packages','PackageAPIController@CountPackages');

	Route::post('change-password', 'UserAPIController@changePassWord');

	Route::resource('companies', 'CompanyAPIController');

	Route::resource('currencies', 'CurrencyAPIController');

	Route::post('search/companies', 'CompanyAPIController@doSearch');

	Route::resource('transactions', 'TransactionAPIController');

	Route::get('company/total-amount', 'TransactionAPIController@totalAmountCompany');

	Route::get('company/load-chart', 'TransactionAPIController@loadChartCompany');

	Route::resource('settings', 'SettingAPIController');

	Route::get('get-package', 'SettingAPIController@getPackage');

	Route::get('exportexcel/companies', 'CompanyAPIController@exportExcel');


});	



Route::resource('files', 'FileAPIController');
