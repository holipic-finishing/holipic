<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * @package App\Models
 * @version December 10, 2018, 3:23 am UTC
 *
 * @property string name
 * @property string description
 * @property string address
 * @property integer user_id
 * @property string logo
 */
class Company extends Model
{
    use SoftDeletes;

    public $table = 'companies';
    
    public $fillable = [
        'name',
        'description',
        'address',
        'owner_id',
        'logo',
        'coupon_codes_id',
        'phone'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'address' => 'string',
        'owner_id' => 'integer',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function files(){
        return $this->hasMany('App\Models\File','company_id','id');
    }

    public function user(){
        return $this->hasOne('App\Models\User','id','owner_id');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction','company_id','id');
    }

    public function coupon_code(){
        return $this->hasOne('App\Models\CouponCode', 'coupon_codes_id', 'id');
    }

    public function branchs(){
        return $this->hasMany('App\Models\Branch','company_id','id');
    }
}
