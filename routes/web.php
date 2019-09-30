<?php

/***************************************************
*********  ROUTER FOR LANDING PAGE   ***************
****************************************************/

Route::get('','LandingController@viewLanding');

Route::get('landing-page/active', 'LandingController@activationAccount');
Route::post('landing-page/login', 'LandingController@landingLogin');

/***************************************************
*********  ROUTER FOR ADMIN PAGE   *****************
****************************************************/

Route::get('/{any}', function () {
   return view('index');
})->where('any', '^(?!api).*$');


/****************************************
*********  ROUTER TEST  *****************
*****************************************/




