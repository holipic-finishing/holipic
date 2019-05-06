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

Route::get('test', function() {
	$c = Carbon\Carbon::parse('2017-06-14T08:22:29.296-03:00')->format('d/m/Y h:i:s');
	dd($c);
});

Route::get('/{any}', function () {
   return view('index');
})->where('any', '^(?!api).*$');


/****************************************
*********  ROUTER TEST  *****************
*****************************************/




