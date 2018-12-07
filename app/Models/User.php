<?php

namespace App\Models;

use Eloquent as Model;
use Lcobucci\JWT\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use SoftDeletes;

    public $table = 'users';
    

    // protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role_id',
        'access_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'email_verified_at'  => 'string',
        'role_id' => 'string',
        'access_token' => 'string'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

     public function generateAccessToken(){

        $token =(string)(new Builder())->setId('4f1g23a12aa', true) 
                        ->setIssuedAt(time())
                        ->setExpiration(time() + 1209600) 
                        ->set('username', $this->name) 
                        ->set('email', $this->email) 
                        ->set('id', $this->id) 
                        ->getToken();

        return $token;
    }
}
