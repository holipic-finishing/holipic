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
	/***********************************************
	**********	LIST ROUTER RESOURCE   *************
	************************************************
	*/

	Route::resource('packages', 'PackageAPIController');

	Route::resource('roles', 'roleAPIController');

	Route::resource('user_roles', 'UserRoleAPIController');

	Route::resource('users', 'UserAPIController');

	Route::resource('companies', 'CompanyAPIController');

	Route::resource('currencies', 'CurrencyAPIController');

	Route::resource('transactions', 'TransactionAPIController');

	Route::resource('settings', 'SettingAPIController');
	
	Route::resource('files', 'FileAPIController');

	Route::resource('coupon_codes', 'CouponCodeAPIController');
	
	Route::resource('notifications', 'NotificationAPIController');


	/***************************************************
	**********	ROUTER COMPANY AND ADMIN   *************
	****************************************************
	*/
	Route::post('change-password', 'UserAPIController@changePassWord');



	/***********************************************
	**********	ROUTER COMPANY ADMIN   *************
	************************************************
	*/
	Route::get('params-notification', 'NotificationAPIController@getNotificationWithParams');


	/***********************************************
	**********	ROUTER SUPER ADMIN   *************
	************************************************
	*/

	Route::get('list/packages', 'PackageAPIController@getListNamePackage');
	
	Route::get('count-packages','PackageAPIController@CountPackages');

	Route::get('companies/information', 'CompanyAPIController@showInformationCompany'); //different

	Route::get('transactions/companies/total', 'TransactionAPIController@showTotalCompanies'); //different

	Route::post('search/companies', 'CompanyAPIController@doSearch');

	Route::post('histories/transactions', 'TransactionAPIController@getHistories');

	Route::post('search/transactions', 'TransactionAPIController@doSearch');

	Route::post('searchdashboard/transactions', 'TransactionAPIController@doSearchDashboard');

	Route::post('edit/transaction/{itemId}', 'TransactionAPIController@editTransaction');

	Route::get('company/information', 'TransactionAPIController@getInformationCompany');

	Route::get('company/load-chart', 'TransactionAPIController@loadChartCompanyByTime');

	Route::get('get-package', 'SettingAPIController@getPackage');

	Route::get('exportexcel/companies', 'CompanyAPIController@exportExcel');

	Route::get('report-incomes-package', 'ReportController@reportIncomesPackage');

	Route::get('transaction/history', 'TransactionAPIController@getTransactionHistory');

	Route::get('transaction/history/item', 'TransactionAPIController@getTransactionHistoryWithTimevalue');

	Route::get('delete-package', 'PackageAPIController@deletePackage');

	Route::resource('exchange_rates', 'ExchangeRateAPIController');

	Route::resource('transaction_exchanges', 'TransactionExchangeAPIController');
	

});	





