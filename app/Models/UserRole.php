<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserRole
 * @package App\Models
 * @version December 7, 2018, 3:35 am UTC
 *
 * @property integer user_id
 * @property integer role_id
 */
class UserRole extends Model
{
    use SoftDeletes;

    public $table = 'user_roles';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
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
