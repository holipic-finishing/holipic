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

        $check = User::where('email', $request['email'])->first();
       
        if($check != null){

            return [
                    "success"=> false,
                    "message"=> 'Email had existed',
                ];
        }
        
        $user = User::create([
            'company_name' => $request['company_name'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'package_id' => $request['package_id'],

        ]);
        $user = $this->reNewToken($user);

        $fullname =  $request['first_name']." ".$request['last_name'];

        $data = array(
            'fullname'=> $fullname,
            'access_token' => $user->access_token
        );

        \Mail::to($request['email'])->send(new activationMail($data));  

        return [
                "success"=> true,
                "message"=> 'Please login your email to active your account',
            ];

    }

    /**

        TODO:
        - function create access_token

    */
    

     public function reNewToken($user)
    {
        $user = User::find($user['id']);
        $user->access_token = $user->generateAccessToken();
        $user->save();

        return $user;
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

         return redirect('/');
    }
}
