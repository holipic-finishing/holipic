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
            static::createTransaction($model);
        });

        static::updated(function($model)
        {
            static::createTransaction($model);
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
                                              

        return OrderExchange::create([
            'order_id' => $model->id,
            'exchange_rate_to_dollar' => $exchangeRateToDollar
        ]);
    }

    public static function createTransaction($model){
        
        if($model->status == 'PAID'){

            if($model->payment_method == "WEB"){
                $results = Branch::with('company')
                                ->where('id',$model->branch_id)
                                ->first();
                $owner_id = $results->company->owner_id;
                $company_id = $results->company->id;
                $coupon_codes_id = $results->company->coupon_codes_id;

                
             
                $package = User::with('package')
                                    ->where('id',$owner_id)
                                    ->first();
                $fee = $package->package->fee;

                /**
                * calculator fee with coupon_code
                */
                if($coupon_codes_id == null){
                    $system_fee = ($model->total_amount * $fee) / 100; 
                }elseif($coupon_codes_id != null ){
                    $coupon_code = CouponCode::where('id',$coupon_codes_id)->first();
                    if($coupon_code->active == 0){
                        $system_fee = ($model->total_amount * $fee) / 100; 
                    }
                    else{
                        $purchase_date = $model->purchase_date->format('Y-m-d h:m:s');
                        if($purchase_date >= $coupon_code->from_date && $purchase_date <= $coupon_code->to_date){
                           
                            $system_fee_increase = (($coupon_code->discount /100) * ($fee / 100)) * $model->total_amount;
                            $system_fee = ($model->total_amount * $fee) / 100 - $system_fee_increase;

                        }else{

                            $system_fee = ($model->total_amount * $fee) / 100;
                        }
                       
                    }
                }
                
                $now = \Carbon\Carbon::now();
                $invoice = 'INV'.time();

                Transaction::create([
                    'title' => 'Customer Paid',
                    'amount' => $model->total_amount,
                    'status' => 'RECIVED',
                    'system_fee' => $system_fee,
                    'invoice' => $invoice ,
                    'currency_id' =>$model->currency_id,
                    'company_id' => $company_id,
                    'dated' => $now,       
                ]);

                TransactionCalulatorEwallet::create([
                    'title' => 'Customer Paid',
                    'amount' => $model->total_amount,
                    'status' => 'RECIVED',
                    'system_fee' => $system_fee,
                    'invoice' => $invoice ,
                    'currency_id' =>$model->currency_id,
                    'company_id' => $company_id,
                    'dated' => $now,       
                ]);
            }

            elseif($model->payment_method == "CC" || $model->payment_method == "CASH"){
                $results = Branch::with('company')
                                ->where('id',$model->branch_id)
                                ->first();
                $owner_id = $results->company->owner_id;
                $company_id = $results->company->id;
                $coupon_codes_id = $results->company->coupon_codes_id;

                
             
                $package = User::with('package')
                                    ->where('id',$owner_id)
                                    ->first();
                $fee = $package->package->fee;

                /**
                * calculator fee with coupon_code
                */
                if($coupon_codes_id == null){
                    $system_fee = ($model->total_amount * $fee) / 100; 
                }elseif($coupon_codes_id != null ){
                    $coupon_code = CouponCode::where('id',$coupon_codes_id)->first();
                    if($coupon_code->active == 0){
                        $system_fee = ($model->total_amount * $fee) / 100; 
                    }
                    else{
                        $purchase_date = $model->purchase_date->format('Y-m-d h:m:s');
                        if($purchase_date >= $coupon_code->from_date && $purchase_date <= $coupon_code->to_date){
                           
                            $system_fee_increase = (($coupon_code->discount /100) * ($fee / 100)) * $model->total_amount;
                            $system_fee = ($model->total_amount * $fee) / 100 - $system_fee_increase;

                        }else{

                            $system_fee = ($model->total_amount * $fee) / 100;
                        }
                       
                    }
                }
                
                $now = \Carbon\Carbon::now();
                $invoice = 'INV'.time();

                Transaction::create([
                    'title' => 'System Fee',
                    'amount' => $model->total_amount,
                    'status' => 'RECIVED',
                    'system_fee' => $system_fee,
                    'invoice' => $invoice,
                    'currency_id' =>$model->currency_id,
                    'company_id' => $company_id,
                    'dated' => $now,       
                ]);

                TransactionCalulatorEwallet::create([
                    'title' => 'System Fee',
                    'amount' => $system_fee,
                    'status' => 'DONE',
                    'system_fee' => 0,
                    'invoice' => $invoice,
                    'currency_id' =>$model->currency_id,
                    'company_id' => $company_id,
                    'dated' => $now,       
                ]);
            }            
        }
    }


  
}
