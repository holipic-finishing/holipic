<?php

/***************************************************
*********  ROUTER FOR LANDING PAGE   ***************
****************************************************/

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

		Route::get('logout','LoginController@logoutAuth');
		
	});
});

Route::post('users/signup', 'UserController@signUp')->name('users.signup');
Route::get('users/activation', 'UserController@activationAccount')->name('users.activation');


/***************************************************
*********  ROUTER FOR ADMIN PAGE   *****************
****************************************************/

Route::get('/{any}', function () {
   return view('index');
})->where('any', '^(?!api).*$');


/****************************************
*********  ROUTER TEST  *****************
*****************************************/


Route::get('test', function() {
// 	$curl = curl_init();

// 	curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://onesignal.com/api/v1/notifications?app_id=d4cb0199-4846-481d-9388-39ba00fe2773&limit=50&offset=0",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//     "authorization: Basic OWU4ZjhhZTUtZWE2MC00NWJiLWE1NjQtMGU1Y2YzNmZhZWY5",
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// dd($response);
	// $id_one_signal = \App\Models\User::select('id_one_signal')
 //                                ->where('email','amara.conroy@hotmail.com')
 //                                ->first();
 //                 $id = "adsfasfasdfasdf";               
 //     if($id_one_signal){
 //     	$data = $id_one_signal->id_one_signal . ',' . $id;
 //     }

 //     // $arId = explode(',',$data);
 //     $arId = ['asdfasdfasdfasdf','asdfasdfasdfasdf'];
 //     dd($arId);
});




