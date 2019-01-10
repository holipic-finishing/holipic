<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version January 9, 2019, 6:50 am UTC
 *
 * @property integer branch_id
 * @property integer photographer_id
 * @property integer customer_id
 * @property decimal total_amount
 * @property string|\Carbon\Carbon purchase_date
 * @property string|\Carbon\Carbon download_date
 * @property string payment_method
 * @property string purchase_from
 * @property string status
 * @property string invoice
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
        'status',
        'invoice',
        'currency_id'
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
        'status' => 'string',
        'invoice' => 'string',
        'currency_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function($model)
        {
            static::exchange($model);
        });

    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function photographer()
    {
        return $this->belongsTo('App\Models\Photographer', 'photographer_id', 'id');
    }

    public function orderexchange()
    {
        return $this->hasOne(\App\Models\OrderExchange::class, 'order_id', 'id');
    }

    static public function exchange($model){
        if($model->currency_id == 1){

            $exchangeRateToDollar = 1;

        }else{

            $exchangeRateToDollar = ExchangeRate::select('rate')
                        ->where('from_currency_id', $model->currency_id)
                        ->where('to_currency_id', 1)
                        ->first()->toArray();

            $exchangeRateToDollar = (double) $exchangeRateToDollar['rate'];

        }
                                              

        return OrderExchange::create([
            'order_id' => $model->id,
            'exchange_rate_to_dollar' => $exchangeRateToDollar
        ]);
    }

    
}
