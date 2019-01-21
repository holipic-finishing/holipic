<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderExchange
 * @package App\Models
 * @version January 9, 2019, 8:20 am UTC
 *
 * @property integer order_id
 * @property decimal exchange_rate_to_dollar
 */
class OrderExchange extends Model
{

    public $table = 'order_exchanges';
    

    public $timestamps = false;


    public $fillable = [
        'order_id',
        'exchange_rate_to_dollar'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
