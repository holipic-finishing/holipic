<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExchangeRate
 * @package App\Models
 * @version December 28, 2018, 8:03 am UTC
 *
 * @property integer from_currency_id
 * @property integer to_currency_id
 * @property decimal rate
 */
class ExchangeRate extends Model
{

    public $table = 'exchange_rates';

    public $timestamps = false;


    public $fillable = [
        'from_currency_id',
        'to_currency_id',
        'rate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'from_currency_id' => 'integer',
        'to_currency_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
