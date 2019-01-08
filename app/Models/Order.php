<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version January 8, 2019, 2:09 am UTC
 *
 * @property integer branch_id
 * @property integer photographer_id
 * @property integer customer_id
 * @property decimal total_amount
 * @property string|\Carbon\Carbon purchase_date
 * @property string|\Carbon\Carbon download_date
 * @property string payment_method
 * @property string purchase_from
 * @property integer status
 */
class Order extends Model
{

    public $table = 'orders';
    

    public $fillable = [
        'branch_id',
        'photographer_id',
        'customer_id',
        'total_amount',
        'purchase_date',
        'download_date',
        'payment_method',
        'purchase_from',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'branch_id' => 'integer',
        'photographer_id' => 'integer',
        'customer_id' => 'integer',
        'payment_method' => 'string',
        'purchase_from' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
