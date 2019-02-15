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
	***********************************************/

	Route::resource('packages', 'PackageAPIController');

	Route::resource('roles', 'roleAPIController');

	Route::resource('user_roles', 'UserRoleAPIController');

	Route::resource('users', 'UserAPIController');

	Route::get('companies/information', 'CompanyAPIController@showInformationCompany'); //different

	Route::resource('companies', 'CompanyAPIController');

	Route::resource('currencies', 'CurrencyAPIController');

	Route::resource('transactions', 'TransactionAPIController');

	Route::resource('settings', 'SettingAPIController');
	
	Route::resource('files', 'FileAPIController');

	Route::resource('coupon_codes', 'CouponCodeAPIController');

	Route::resource('ewallet_withdraws', 'EwalletWithdrawAPIController');

	/***************************************************
	*********LIST ROUTER RESOURCE COMPANY ADMIN*********
	***************************************************/
	Route::group(['namespace' => 'CompanyAdmin'], function() {

		Route::resource('company_packages', 'CompanyPackageAPIController');
		Route::resource('photo_packages', 'PhotoPackageAPIController');
		Route::resource('pages', 'PagesAPIController');
		Route::resource('notifications', 'NotificationAPIController');
		Route::resource('branches', 'BranchAPIController');
		Route::resource('emails', 'EmailAPIController');
		Route::resource('exchange_rates', 'ExchangeRateAPIController');
		Route::resource('transaction_exchanges', 'TransactionExchangeAPIController');
		Route::resource('order_exchanges', 'OrderExchangeAPIController');

	});
	

	/***********************************************
	**********	ROUTER COMPANY ADMIN   *************
	************************************************/

	/*************UserAPIController**************/

	Route::post('change-password', 'UserAPIController@changePassWord');

	Route::get('get-user-profile/{id}', 'UserAPIController@getUserProfile');

	Route::post('edit-user-profile', 'UserAPIController@userProfile');

	Route::post('update-onesignal-id','UserAPIController@updateOnesignalUser');

	Route::namespace('CompanyAdmin')->group(function(){

		/*************PagesAPIController**************/

		Route::post('edit/page/{itemId}','PagesAPIController@editPage');

		/*************NotificationAPIController**************/

		Route::get('params-notification', 'NotificationAPIController@getNotificationWithParams');

		Route::get('get-notifications/{user_id}','NotificationAPIController@getNotification');

		/*************BranchAPIController**************/

		Route::resource('branches', 'BranchAPIController');

		Route::get('company/branches', 'BranchAPIController@getBranchesCompany');
	
		Route::post('company/branch', 'BranchAPIController@saveBranchCompany');
		
		/*************PhotographerAPIController**************/

		Route::get('photographers', 'PhotographerAPIController@getPhotographers');

		Route::delete('photographer/{id}', 'PhotographerAPIController@destroy');

		Route::post('photographer', 'PhotographerAPIController@savePhotographer');

		Route::put('photographer/{id}', 'PhotographerAPIController@updatePhotographer');

		Route::get('photographer/photographer-branch','PhotographerAPIController@getPhotographerByBranch');

		Route::get('branch/photographers', 'PhotographerAPIController@getPhotographers');


		/*************BranchAPIController**************/

		Route::get('company/branches', 'BranchAPIController@getBranchesCompany');

		Route::post('company/branch', 'BranchAPIController@saveBranchCompany');

		Route::get('company/branch-company','BranchAPIController@getBranchByCompanyId');

	
		/*************CustomerAPIController**************/

		Route::get('company/branches/customers', 'CustomerAPIController@getCustomers');

		Route::patch('company/branches/customer/{id}', 'CustomerAPIController@updateCustomer');

		Route::get('company/branches/customers/export', 'CustomerAPIController@exportEmailCustomers');

		Route::delete('company/branches/customer/delete/{id}', 'CustomerAPIController@destroy');

		Route::post('branch/customers', 'CustomerAPIController@getBranchCustomers');

		Route::patch('branch/customer/{id}', 'CustomerAPIController@updateBranchCustomer');

		Route::delete('branch/{id}', 'CustomerAPIController@deleteBranchCustomer');

		Route::get('branch/customers/export', 'CustomerAPIController@exportEmailBranchCustomers');


		/*************ActivityLogController**************/
		
		Route::get('activity-log/show', 'ActivityLogController@getActivityLog');

		Route::get('activity-log/update', 'ActivityLogController@updateIsReadActivityLog');

		/*****************EmailAPIController*****************/

		Route::resource('emails', 'EmailAPIController');

		Route::post('edit/email/{itemId}', 'EmailAPIController@editEmail');

		/*****************CompanyPackageAPIController*****************/

		Route::post('get-company-package', 'CompanyPackageAPIController@getPackage');

		Route::post('add/companyPackage', 'CompanyPackageAPIController@addPackage');

		Route::post('edit/companyPackage/{itemId}', 'CompanyPackageAPIController@editPackage');

		/*****************PhotoPackageAPIController*****************/
		
		Route::post('get-photo-package', 'PhotoPackageAPIController@getPhotoPackage');

		Route::post('edit/photoPackage/{itemId}', 'PhotoPackageAPIController@editPackage');

	});

		
		
	/*************Order Controllers**************/
	Route::resource('orders', 'OrderAPIController');

	Route::get('branch/sales-list', 'OrderAPIController@getSalesList');
	
	Route::get('branch/sales-list/export', 'OrderAPIController@exportSalesListBranch');

	Route::get('order/orders-company', 'OrderAPIController@getAllOrderCompany');

	Route::get('order/sales/company/export', 'OrderAPIController@exportSalesCompany');

	Route::post('order/history-order', 'OrderAPIController@getHistoryOrders');

	Route::get('order/count-income', 'OrderAPIController@countIncome');
	
	Route::get('order/countValuesOfTag', 'OrderAPIController@countValuesOfTag');

	/*************ImageUploadsController**************/
	Route::post('company/image/upload/store','ImageUploadsController@fileStore');
	Route::post('company/image/delete','ImageUploadsController@fileDestroy');
	

	/***********************************************
	**********	ROUTER SUPER ADMIN   ***************
	************************************************/

	/*************PackageAPIController**************/
	Route::get('list/packages', 'PackageAPIController@getListNamePackage');
	
	Route::get('count-packages','PackageAPIController@CountPackages');

	Route::get('delete-package', 'PackageAPIController@deletePackage');

	Route::post('edit/package/{itemId}', 'PackageAPIController@editPackage');

	/*************CompanyAPIController**************/
	
	Route::post('search/companies', 'CompanyAPIController@doSearch');

	Route::get('exportexcel/companies', 'CompanyAPIController@exportExcel');

	Route::get('company/export/customer','CompanyAPIController@exportEmailCustomerByCompanyId');

	Route::get('company/branches/customers/email', 'CompanyAPIController@getEmailCustomers');

	Route::get('company/branches/customer/send-email', 'CompanyAPIController@sendEmailCustomers');

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

	/*************EwalletWithdrawAPIController**************/

	Route::get('ewallet-withdraw', 'EwalletWithdrawAPIController@getEwalletWithdraw');

	Route::put('ewallet-withdraw/update-status/{id}', 'EwalletWithdrawAPIController@updateStatusEwalletWithdraw');


	/*************Different Controllers**************/

	Route::get('report-incomes-package', 'ReportController@reportIncomesPackage');
	
	Route::get('company-admin-chart', 'ReportController@getInfoForChartCompanyAdmin');
	
	/*************Ewallet Withdraw API Controllers**************/

	Route::get('ewallet_withdraw/{compnay_id}', 'EwalletWithdrawAPIController@withDrawCompanyId');

	/*************CouponCodeAPIController**************/

	Route::post('edit/coupon-codes/{itemId}', 'CouponCodeAPIController@editCouponCode');
	Route::post('add-coupon-code/{couponId}/{companyId}', 'CouponCodeAPIController@addCouponCode');
	Route::post('cancel-coupon-code/{couponId}/{companyId}', 'CouponCodeAPIController@cancelCouponCode');

	/*************TransactionCalulatorEwalletsAPIController**************/

	Route::resource('transaction_calulator_ewallets', 'TransactionCalulatorEwalletAPIController');

	Route::get('e-wallet/transaction-history', 'TransactionCalulatorEwalletAPIController@getEWalletTransactionHistory');

	Route::get('e-wallet/total-ewallet', 'TransactionCalulatorEwalletAPIController@calEwallet');
	
});	



