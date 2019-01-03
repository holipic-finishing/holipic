<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * @package App\Models
 * @version December 10, 2018, 4:42 am UTC
 *
 * @property integer user_id
 * @property boolean type
 * @property decimal(8 amount
 * @property string status
 * @property integer company_id
 * @property string|\Carbon\Carbon dated
 */
class Transaction extends Model
{
    use LogsActivity;

    public $table = 'transactions';

    public $fillable = [
        'user_id',
        'type',
        'amount',
        'currency_id',
        'status',
        'company_id',
        'dated',
        'title',
        'invoice'
    ];


    protected static $logFillable = true;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'type' => 'boolean',
        // 'amount' => 'decimal',
        'currency_id' => 'integer',
        'status' => 'string',
        'company_id' => 'integer',
        'dated' => 'datetime',
        'title' => 'string',
        'invoice' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'status' => 'required',
        'company_id' => 'required',
        'dated' => 'required'
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function($model)
        {
            static::exchange($model);
        });

    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function company(){
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    public function packages(){
        return $this->hasOne(App\Model\Package::class, 'company_id');
    }

    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id', 'id');
    }
    

    public function transactionexchange()
    {
        return $this->hasOne(\App\Models\TransactionExchange::class, 'transaction_id', 'id');
    }
    
    public static function exchange($model){

        if($model->currency_id == 1){

            $exchangeRateToDollar = 1;

        }else{

            $exchangeRateToDollar = ExchangeRate::select('rate')
                        ->where('from_currency_id', $model->currency_id)
                        ->where('to_currency_id', 1)
                        ->first()->toArray();

            $exchangeRateToDollar = (double) $exchangeRateToDollar['rate'];

        }
                                              

        return TransactionExchange::create([
            'transaction_id' => $model->id,
            'exchange_rate_to_dollar' => $exchangeRateToDollar
        ]);
    }
        
    public function companyUser(){
        return $this->hasMany(\App\Models\Company::class,'owner_id','user_id');
    }
}
