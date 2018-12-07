<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version December 7, 2018, 7:20 am UTC
 *
 * @property string company_name
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string password
 * @property string access_token
 * @property integer active
 * @property integer package_id
 */
class User extends Model
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
        'company_name' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'access_token' => 'string',
        'active' => 'integer',
        'package_id' => 'integer',
        'role_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
