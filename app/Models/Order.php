<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version January 7, 2019, 8:13 am UTC
 *
 * @property integer branch_id
 * @property integer photographer_id
 * @property integer customer_id
 * @property string room_number
 * @property decimal total_amount
 * @property string|\Carbon\Carbon purchase_date
 * @property string|\Carbon\Carbon download_date
 * @property string payment_method
 * @property string purchase_from
 */
class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'branch_id',
        'photographer_id',
        'customer_id',
        'room_number',
        'total_amount',
        'purchase_date',
        'download_date',
        'payment_method',
        'purchase_from'
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
        'room_number' => 'string',
        'payment_method' => 'string',
        'purchase_from' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
