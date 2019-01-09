<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 * @package App\Models
 * @version January 5, 2019, 9:11 am UTC
 *
 * @property string name
 * @property string room
 * @property string email
 * @property string password
 * @property string avatar
 */
class Customer extends Model
{
    use SoftDeletes;

    public $table = 'customers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'customer_password',
        'avatar',
        'address',
        'room',
        'branch_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'room' => 'string',
        'email' => 'string',
        'password' => 'string',
        'avatar' => 'string',
        'branch_id' => 'integer',
        'address' => 'string',
        'status' => 'boolean'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'no'
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }
    
}
