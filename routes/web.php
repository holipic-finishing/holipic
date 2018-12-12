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

Route::get('','API\PackageAPIController@listPackage');

Route::namespace('API')->group(function(){
	Route::namespace('Auth')->group(function(){
		
		Route::post('landing-page/login', 'LoginController@login');
		Route::post('forgotpassword','LoginController@forgotpassword');
		Route::post('resetpassword','LoginController@resetpassword');
		Route::get('landing-page/logout', 'LoginController@logout');


	});
	
	Route::namespace('Auth')->prefix('auth')->group(function(){
	
		Route::post('loginSuperAdmin','LoginController@loginSuperAdmin');
	
	});
});

Route::prefix('/admin')->group(function () {
     Route::get('/', function () {
 	   return view('welcome');
	});
});

// Route::get('/{any}', function () {
// 		  return view('welcome');
// })->where('any', '^(?!api).*$');

Route::post('users/signup', 'UserController@signUp')->name('users.signup');
Route::get('users/activation', 'UserController@activationAccount')->name('users.activation');


Route::get('test', 'TestController@test');

Route::get('test-job', function() {
	App\Jobs\CronJobRemoveFile::dispatch();
});





