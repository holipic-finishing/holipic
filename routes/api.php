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
Route::group(['namespace' => 'API'],function(){

    /************************** AUTH******************************/
    Route::namespace('Auth')->prefix('auth')->group(function(){

        Route::post('register', 'RegisterController@register');
        Route::post('signinUser', 'LoginController@signinUser');
        Route::post('logout', 'LoginController@logoutAuth')->middleware('jwt');

		Route::get('forgot-password', 'LoginController@sendEmailResetPassword');
		Route::get('customer/confirm-forgot-password', 'LoginController@confirmForgotPassword');
		Route::post('customer/update-password', 'LoginController@updatePassword');

    });
});

Route::middleware(['auth:api'])->group(function () {
    // Email Verification Routes...
    Route::post('email/verify', 'Auth\VerificationController@check')->name('verification.notice');
    Route::post('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'],function(){

	/***********************************************
	**********	LIST ROUTER RESOURCE   *************
	***********************************************/
	Route::resource('users', 'UserAPIController');
	Route::resource('currencies', 'CurrencyAPIController');
	Route::resource('files', 'FileAPIController');

	/*************UserAPIController**************/
	Route::post('change-password', 'UserAPIController@changePassWord');
	Route::get('get-user-profile/{id}', 'UserAPIController@getUserProfile');
	Route::post('edit-user-profile', 'UserAPIController@userProfile');
	Route::post('update-onesignal-id','UserAPIController@updateOnesignalUser');

	/*************ImageUploadsController**************/
	Route::post('company/image/upload/store','ImageUploadsController@fileStore');
	Route::post('company/image/delete','ImageUploadsController@fileDestroy');

	/*************Different Controllers**************/
	Route::get('super-admin-chart-report', 'ReportController@totalIncomeReport');
	Route::get('company-admin-chart', 'ReportController@getInfoForChartCompanyAdmin');

	/**************************************************
	*********LIST ROUTES SUPER ADMIN**********
	***************************************************/
	Route::group(['namespace' => 'SuperAdmin'], function() {

		/***********************************************
		**********	LIST ROUTES RESOURCE   *************
		***********************************************/

		Route::resource('companies', 'CompanyAPIController');
		Route::resource('coupon_codes', 'CouponCodeAPIController');
		Route::resource('settings', 'SettingAPIController');
		Route::resource('packages', 'PackageAPIController');
		Route::resource('transactions', 'TransactionAPIController');

		/***********************************************
		**********	ROUTES SUPER ADMIN   ***************
		************************************************/

		/*************CompanyAPIController**************/
		Route::get('companies/information', 'CompanyAPIController@showInformationCompany');
		Route::get('companies/export-excel', 'CompanyAPIController@exportExcel');

		/*************TransactionAPIController**************/
		Route::post('history-transactions', 'TransactionAPIController@getDashboardTransactions');
		Route::post('transaction-edit/{itemId}', 'TransactionAPIController@editTransaction');
		Route::get('company/history-transactions', 'TransactionAPIController@getCompanyTransactions');
		Route::get('company/history-transactions/filter', 'TransactionAPIController@getTransactionHistoryWithTimeValue');

		/*************CouponCodeAPIController**************/
		Route::post('edit/coupon-codes/{itemId}', 'CouponCodeAPIController@editCouponCode');
		Route::post('add-coupon-code/{couponId}/{companyId}', 'CouponCodeAPIController@addCouponCode');
		Route::post('cancel-coupon-code/{couponId}/{companyId}', 'CouponCodeAPIController@cancelCouponCode');

		/*************SettingAPIController**************/
		Route::post('edit/setting/{itemId}', 'SettingAPIController@editSetting');

		/*************PackageAPIController**************/
		Route::get('list-package', 'PackageAPIController@getListNamePackage');
		Route::get('delete-package', 'PackageAPIController@deletePackage');
		Route::post('edit/package/{itemId}', 'PackageAPIController@editPackage');


	});

	/***************************************************
	*********LIST ROUTES COMPANY ADMIN*********
	***************************************************/
	Route::group(['namespace' => 'CompanyAdmin'], function() {

		/***********************************************
		**********	LIST ROUTES RESOURCE   *************
		***********************************************/
		Route::resource('company_packages', 'CompanyPackageAPIController');
		Route::resource('photo_packages', 'PhotoPackageAPIController');
		Route::resource('pages', 'PagesAPIController');
		Route::resource('notifications', 'NotificationAPIController');
		Route::resource('branches', 'BranchAPIController');
		Route::resource('emails', 'EmailAPIController');
		Route::resource('exchange_rates', 'ExchangeRateAPIController');
		Route::resource('transaction_exchanges', 'TransactionExchangeAPIController');
		Route::resource('order_exchanges', 'OrderExchangeAPIController');
		Route::resource('branches', 'BranchAPIController');
		Route::resource('emails', 'EmailAPIController');
		Route::resource('orders', 'CompanyOrderAPIController');
		Route::resource('ewallet_withdraws', 'EwalletWithdrawAPIController');

		/*************CompanyAPIController**************/
		Route::get('export-customers','CompanyAPIController@exportEmailCustomerByCompanyId');
		Route::get('customer-emails', 'CompanyAPIController@getCustomerEmails');
		Route::get('customer/send-email', 'CompanyAPIController@sendEmailCustomer');
		Route::post('company/upload-photo', 'CompanyAPIController@uploadPhoto');

		/*************PagesAPIController**************/
		Route::post('edit/page/{itemId}','PagesAPIController@editPage');

		/*************NotificationAPIController**************/
		Route::get('params-notification', 'NotificationAPIController@getNotificationWithParams');
		Route::get('get-notifications/{user_id}','NotificationAPIController@getNotification');

		/*************BranchAPIController**************/
		Route::get('company/branches', 'BranchAPIController@getBranchesCompany');
		Route::post('company/branch', 'BranchAPIController@saveBranchCompany');

		/*************PhotographerAPIController**************/
		Route::get('photographers', 'PhotographerAPIController@getPhotographers');
		Route::delete('photographer/{id}', 'PhotographerAPIController@destroy');
		Route::post('photographer', 'PhotographerAPIController@savePhotographer');
		Route::put('photographer/{id}', 'PhotographerAPIController@updatePhotographer');
		Route::get('photographer/photographer-branch','PhotographerAPIController@getPhotographerByBranch');
		Route::get('branch/photographers', 'PhotographerAPIController@getPhotographers');
		Route::get('photographer/detail/{id}', 'PhotographerAPIController@getDetailPhotographer');

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

		/*****************EmailAPIController*************/
		Route::post('edit/email/{itemId}', 'EmailAPIController@editEmail');

		/***********CompanyPackageAPIController**********/
		Route::post('get-company-package', 'CompanyPackageAPIController@getPackage');
		Route::post('add/companyPackage', 'CompanyPackageAPIController@addPackage');
		Route::post('edit/companyPackage/{itemId}', 'CompanyPackageAPIController@editPackage');

		/*************PhotoPackageAPIController**********/
		Route::post('get-photo-package', 'PhotoPackageAPIController@getPhotoPackage');
		Route::post('edit/photoPackage/{itemId}', 'PhotoPackageAPIController@editPackage');
		Route::get('photo-package/search', 'PhotoPackageAPIController@searchPhotoPackage');

		/************CompanyOrderAPIController***********/
		Route::get('order/orders-company', 'CompanyOrderAPIController@getAllOrderCompany');
		Route::get('order/sales/company/export', 'CompanyOrderAPIController@exportSalesCompany');
		Route::post('order/history-order', 'CompanyOrderAPIController@getHistoryOrders');
		Route::get('order/count-income', 'CompanyOrderAPIController@countIncome');
		Route::get('order/countValuesOfTag', 'CompanyOrderAPIController@countValuesOfTag');

		/*************EwalletWithdrawAPIController**************/
		Route::get('ewallet-withdraw', 'EwalletWithdrawAPIController@getEwalletWithdraw');
		Route::put('ewallet-withdraw/update-status/{id}', 'EwalletWithdrawAPIController@updateStatusEwalletWithdraw');
		Route::get('ewallet_withdraw/{compnay_id}', 'EwalletWithdrawAPIController@withDrawCompanyId');

		/************TransactionCalulatorEwalletAPIController***********/
		Route::resource('transaction_calulator_ewallets', 'TransactionCalulatorEwalletAPIController');
		Route::get('e-wallet/transaction-history', 'TransactionCalulatorEwalletAPIController@getEWalletTransactionHistory');
		Route::get('e-wallet/total-ewallet', 'TransactionCalulatorEwalletAPIController@calEwallet');

		/************BookingAPIController***********/
		Route::get('bookings', 'BookingAPIController@getBookings');
		Route::get('booking/update/{id}', 'BookingAPIController@updateDateTime');
		Route::get('booking/timezone/convert'	, 'BookingAPIController@convertTimezone');
		Route::delete('booking/{id}', 'BookingAPIController@destroy');
		Route::get('booking/sendmail/{id}', 'BookingAPIController@sendMailCustomer');


		/************TimezoneAPIController***********/
		Route::get('timezones', 'TimezoneAPIController@getTimezones');

		/************SnapPhotoAPIController***********/
		Route::post('snap-photo', 'SnapPhotoAPIController@createSnapPhoto');

		// Route::get('room/snap-photo', 'SnapPhotoAPIController@findRoomCheckDetailSnapPhoto');

		/************SnapPhotoAPIController***********/
		Route::get('photo-package/search', 'PhotoPackageAPIController@searchPhotoPackage');

		/**Shop selling**/

		Route::get('shop-selling/packages', 'CompanyPackageAPIController@showAllPackage');

		Route::post('shop-selling/order-confirm', 'CompanyOrderAPIController@createOrderConfirm');

	});

	/**************************************************
	**************LIST ROUTES BRANCH ADMIN*************
	***************************************************/
	Route::group(['namespace' => 'BranchAdmin'], function() {

		/************BranchOrderAPIController***********/
		Route::get('branch/sales-list', 'BranchOrderAPIController@getSalesList');
		Route::get('branch/sales-list/export', 'BranchOrderAPIController@exportSalesListBranch');

	});


	/**************************************************
	**************LIST ROUTES SHOP SELLING*************
	***************************************************/
	Route::group(['namespace' => 'ShopSelling'], function() {

		Route::get('room/login', 'ListingController@loginRoom');
		Route::get('room/show-photo', 'ListingController@getPhoto');
		Route::post('cart/add-photo', 'CartController@addPhoto');
		Route::delete('cart/delete-photo', 'CartController@deletePhoto');
		// Route::get('room/photo-selected', 'CartController@getPhotoSelected');

	});

	Route::group(['namespace' => 'Customer'], function() {
		Route::post('customer/order-image', 'CustomerAPIController@orderImage');

		Route::get('customer/list-image-selected', 'CustomerAPIController@getImageSelected');

	});
});
