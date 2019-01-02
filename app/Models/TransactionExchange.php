<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TransactionExchange
 * @package App\Models
 * @version December 28, 2018, 8:06 am UTC
 *
 * @property integer transaction_id
 * @property decimal exchange_rate_dollar
 */
class TransactionExchange extends Model
{

    public $table = 'transaction_exchanges';
    
    public $timestamps = false;
    public $fillable = [
        'transaction_id',
        'exchange_rate_to_dollar'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'transaction_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
