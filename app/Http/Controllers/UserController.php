<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\activationMail;
use Response;

class UserController extends Controller
{
   	/**
   
   	TODO:
   	- function to signup new account
   	-@param : company_name, first_name, last_name, email, password,	package_id, role_id
      
    */
   
    public function signUp(Request $request){

    	$request['company_name'] = 'holipic';
    	$request['first_name'] = 'thong';
    	$request['last_name'] = 'tran';
    	$request['email'] = 'ttthongcn@gmail.com';
    	$request['password'] = '123456';
    	$request['package_id'] = '1';
    	$request['role_id'] = '1';

        $check = User::where('email', $request['email'])->first();
       
        if($check != null){
           	return \Response::json(['msg' => 'email had existed']);
        }
        
        $access_token = $this->generateUniqueAccessToken();

        $user = User::create([
            'company_name' => $request['company_name'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'access_token' => $access_token,
            'package_id' => $request['package_id'],
            'role_id' => $request['role_id'],

        ]);

        $fullname =  $request['first_name']." ".$request['last_name'];

        $data = array(
            'fullname'=> $fullname,
            'access_token' => $access_token,
        );

        \Mail::to($request['email'])->send(new activationMail($data));  

        return \Response::json(['msg' => 'please login gmail to active your account']);
    }

    protected function generateUniqueAccessToken(){
    	do{
    		$token = str_random(64);
    	}while($user = User::where('access_token', $token)->first());

    	return $token;
    }


    /**
    	TODO:
    	- function to activate account
    	- @param : access_token
     */
    
    protected function activationAccount(Request $request){
    	$input = $request->all() ;

        $access_token = $input['access_token'];

        $array = [
            'active' => 1
        ];

        $result = User::where('access_token',$access_token)->update($array);

        return \Response::json(['msg' => 'activation success']);
    }
}
