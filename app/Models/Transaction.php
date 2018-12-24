<?php

namespace App\Models;

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
    
}
