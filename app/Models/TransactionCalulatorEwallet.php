<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TransactionCalulatorEwallet
 * @package App\Models
 * @version January 30, 2019, 7:02 am UTC
 *
 * @property string title
 * @property decimal amount
 * @property string status
 * @property decimal system_fee
 * @property decimal credit_card_fee
 * @property string invoice
 * @property integer currency_id
 * @property integer company_id
 * @property string|\Carbon\Carbon dated
 */
class TransactionCalulatorEwallet extends Model
{
    use SoftDeletes;

    public $table = 'transaction_calulator_ewallets';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'amount',
        'status',
        'system_fee',
        'credit_card_fee',
        'invoice',
        'currency_id',
        'company_id',
        'dated'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'status' => 'string',
        'invoice' => 'string',
        'currency_id' => 'integer',
        'company_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function company(){
        return $this->belongsTo(\App\Models\Company::class, 'company_id', 'id');
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

    
}
