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
        'address',
        'status',
        'customer_password',
        'avatar',
        'branch_id',
        'user_id',
        'room_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'status' => 'boolean',
        'customer_password' => 'string',
        'avatar' => 'string',
        'branch_id' => 'integer',
        'user_id' => 'integer',
        'room_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function room()
    {
        return $this->hasOne('App\Models\Room', 'id', 'room_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id', 'id');
    }
}
