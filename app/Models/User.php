<?php

namespace App\Models;

use Eloquent as Model;

use Lcobucci\JWT\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public $table = 'users';

    public $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'email',
        'password',
        'access_token',
        'active',
        'package_id',
        'role_id'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'email_verified_at'  => 'string',
        'role_id' => 'string',
        'access_token' => 'string'
    ];

    protected $hidden = [
        'password', 'remember_token'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email'=>'required',
        
    ];

     public function generateAccessToken(){

        $token =(string)(new Builder())->setId('4f1g23a12aa', true) 
                        ->setIssuedAt(time())
                        ->setExpiration(time() + 1209600) 
                        ->set('username', $this->first_name) 
                        ->set('email', $this->email) 
                        ->set('id', $this->id) 
                        ->getToken();

        return $token;
    }

}
