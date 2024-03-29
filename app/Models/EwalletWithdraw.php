<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EwalletWithdraw
 * @package App\Models
 * @version January 22, 2019, 8:14 am UTC
 *
 * @property decimal amount
 * @property string bank_account_number
 * @property string bank_name
 * @property string account_holder_name
 * @property string iban
 * @property string swift_code
 * @property string status
 * @property integer company_id
 */
class EwalletWithdraw extends Model
{

    public $table = 'ewallet_withdraws';
    
    public $fillable = [
        'amount',
        'bank_account_number',
        'bank_name',
        'account_holder_name',
        'iban',
        'swift_code',
        'status',
        'company_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bank_account_number' => 'string',
        'bank_name' => 'string',
        'account_holder_name' => 'string',
        'iban' => 'string',
        'swift_code' => 'string',
        'status' => 'string',
        'company_id' => 'integer'
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
            static::createTransaction($model);
        });

        static::updated(function($model)
        {
            static::createTransaction($model);
        });

    }

    public static function createTransaction($model){
        if($model->status == 'DONE'){
            $now = \Carbon\Carbon::now();
            $invoice = 'INV'.time();

            Transaction::create([
                'title' => 'Withdraw From Company',
                'amount' => $model->amount,
                'status' => 'DONE',
                'invoice' => $invoice,
                'currency_id' => 1,
                'company_id' => $model->company_id,
                'dated' => $now,       
            ]);

            TransactionCalulatorEwallet::create([
                'title' => 'Withdraw From Company',
                'amount' => $model->amount,
                'status' => 'DONE',
                'invoice' => $invoice,
                'currency_id' => 1,
                'company_id' => $model->company_id,
                'dated' => $now,       
            ]);
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    
}
