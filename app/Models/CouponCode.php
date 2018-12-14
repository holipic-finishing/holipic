<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CouponCode
 * @package App\Models
 * @version December 14, 2018, 4:24 am UTC
 *
 * @property string name
 * @property string code
 * @property decimal discount
 * @property string active
 * @property string|\Carbon\Carbon from_date
 * @property string|\Carbon\Carbon to_date
 */
class CouponCode extends Model
{


    public $table = 'coupon_codes';

    public $timestamps = false;
    
    public $fillable = [
        'name',
        'code',
        'discount',
        'active',
        'from_date',
        'to_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'active' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
