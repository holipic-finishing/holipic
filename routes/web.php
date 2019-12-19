<?php

/***************************************************
*********  ROUTER FOR LANDING PAGE   ***************
****************************************************/
// Route::redirect('', '/en');

// Route::group(['prefix' => '{language}'], function () {
  Route::get('','LandingController@direct');
  Route::get('/lang/{language}','LandingController@viewLanding');
// });
Route::post('/register', 'LandingController@register');
// Route::get('landing-page/active', 'LandingController@activationAccount');
// Route::post('landing-page/login', 'LandingController@landingLogin');

/***************************************************
*********  ROUTER FOR ADMIN PAGE   *****************
****************************************************/

Route::get('/{any}', function () {
   return view('index');
})->where('any', '^(?!api).*$');

// Route::get('/{any}', function () {
//    return view('index');
// })->where('any', '^(?!api).*$');


/****************************************
*********  ROUTER TEST  *****************
*****************************************/
