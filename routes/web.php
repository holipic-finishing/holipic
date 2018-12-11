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
// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/landing-page', function () {
//     return view('sites.pages.landing-page');
// });

Route::get('/index','API\PackageAPIController@listPackage');

Route::get('','API\PackageAPIController@listPackage');

Route::namespace('API')->group(function(){
	Route::namespace('Auth')->group(function(){
		
		Route::post('landing-page/login', 'LoginController@login');
		// Route::post('login', 'LoginController@login');
		Route::post('loginSuperAdmin','LoginController@loginSuperAdmin');
		Route::post('forgotpassword','LoginController@forgotpassword');
		Route::post('resetpassword','LoginController@resetpassword');

		Route::get('landing-page/logout', 'LoginController@logout');


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



