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

Route::get('/landing-page', function () {
    return view('sites.pages.landing-page');
});


Route::namespace('API')->group(function(){
	Route::namespace('Auth')->group(function(){
		Route::post('landing-page/login', 'LoginController@login');

		Route::get('landing-page/logout', 'LoginController@logout');

		Route::get('test', 'LoginController@reNewToken');

		Route::get('user', function() {
			$user = \Auth::user();
			dd($user);
		});

	});
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('users/signup', 'UserController@signUp')->name('users.signup');
Route::get('users/activation', 'UserController@activationAccount')->name('users.activation');
