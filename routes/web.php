<?php

/***************************************************
*********  ROUTER FOR LANDING PAGE   ***************
****************************************************/

Route::get('','API\SuperAdmin\PackageAPIController@listPackage');

Route::namespace('API')->group(function(){
	Route::namespace('Auth')->group(function(){
		
		Route::post('landing-page/login', 'LoginController@login');
		Route::post('forgotpassword','LoginController@forgotpassword');
		Route::post('resetpassword','LoginController@resetpassword');
		Route::get('landing-page/logout', 'LoginController@logout');

	});

	Route::namespace('Auth')->prefix('auth')->group(function(){
		
		Route::post('loginSuperAdmin','LoginController@loginSuperAdmin');

		Route::get('logout','LoginController@logoutAuth');
		
	});
});

Route::post('users/signup', 'UserController@signUp')->name('users.signup');
Route::get('users/activation', 'UserController@activationAccount')->name('users.activation');
/***************************************************
*********  ROUTER FOR ADMIN PAGE   *****************
****************************************************/

use Carbon\Carbon;
Route::get('test', function() {
	$date = '2018-03-05 10:00:00';
	$utc = Carbon::parse($date);
	$converted = $utc->setTimeZone('Pacific/Norfolk');
	dd($converted->toDateString(), $converted->toTimeString());

	dd(Carbon::parse($date));
});
Route::get('/{any}', function () {
   return view('index');
})->where('any', '^(?!api).*$');


/****************************************
*********  ROUTER TEST  *****************
*****************************************/




