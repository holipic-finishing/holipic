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
	************************************************/

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
	

	/***********************************************
	**********	ROUTER COMPANY ADMIN   *************
	************************************************
	*/
	
	Route::namespace('CompanyAdmin')->group(function(){
	
		Route::resource('pages', 'PagesAPIController');

		Route::resource('notifications', 'NotificationAPIController');

		Route::post('edit/page/{itemId}','PagesAPIController@editPage');
	
		Route::get('params-notification', 'NotificationAPIController@getNotificationWithParams');
	});

	Route::get('activity-log/show', 'ActivityLogController@getActivityLog');



	/***************************************************
	**********	LIST ROUTER RESOURCE COMPANY ADMIN   *************
	****************************************************
	*/
	Route::group(['namespace' => 'CompanyAdmin'], function() {
		Route::resource('company_packages', 'CompanyPackageAPIController');

		Route::resource('photo_packages', 'PhotoPackageAPIController');
	});
	


	/***************************************************
	**********	ROUTER COMPANY AND ADMIN   *************
	****************************************************/
	Route::post('change-password', 'UserAPIController@changePassWord');


	Route::group(['namespace' => 'CompanyAdmin'], function() {

		Route::post('edit/companyPackage/{itemId}', 'CompanyPackageAPIController@editPackage');

		Route::get('get-photo-package', 'PhotoPackageAPIController@getPhotoPackage');

		Route::post('edit/photoPackage/{itemId}', 'PhotoPackageAPIController@editPackage');
		
	});


	/***********************************************
	**********	ROUTER SUPER ADMIN   ***************
	************************************************/

	/*************PackageAPIController**************/
	Route::get('list/packages', 'PackageAPIController@getListNamePackage');
	
	Route::get('count-packages','PackageAPIController@CountPackages');

	Route::get('delete-package', 'PackageAPIController@deletePackage');

	Route::post('edit/package/{itemId}', 'PackageAPIController@editPackage');

	/*************CompanyAPIController**************/
	
	Route::get('companies/information', 'CompanyAPIController@showInformationCompany'); //different

	Route::post('search/companies', 'CompanyAPIController@doSearch');

	Route::get('exportexcel/companies', 'CompanyAPIController@exportExcel');

	/*************TransactionAPIController**************/

	Route::get('transactions/companies/total', 'TransactionAPIController@showTotalCompanies'); //different

	Route::post('histories/transactions', 'TransactionAPIController@getHistories');

	Route::post('search/transactions', 'TransactionAPIController@doSearch');

	Route::post('searchdashboard/transactions', 'TransactionAPIController@doSearchDashboard');

	Route::post('edit/transaction/{itemId}', 'TransactionAPIController@editTransaction');

	Route::get('company/information', 'TransactionAPIController@getInformationCompany');

	Route::get('company/load-chart', 'TransactionAPIController@loadChartCompanyByTime');

	Route::get('transaction/history', 'TransactionAPIController@getTransactionHistory');

	Route::get('transaction/history/item', 'TransactionAPIController@getTransactionHistoryWithTimevalue');

	/*************SettingAPIController**************/

	Route::get('get-package', 'SettingAPIController@getPackage');

	Route::post('edit/setting/{itemId}', 'SettingAPIController@editSetting');

	/*************Different Controllers**************/

	Route::get('report-incomes-package', 'ReportController@reportIncomesPackage');

	Route::resource('exchange_rates', 'ExchangeRateAPIController');

	Route::resource('transaction_exchanges', 'TransactionExchangeAPIController');

	Route::post('edit/coupon-codes/{itemId}', 'CouponCodeAPIController@editCouponCode');
});	

