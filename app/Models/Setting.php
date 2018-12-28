<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 * @package App\Models
 * @version December 10, 2018, 7:04 am UTC
 *
 * @property integer expiration_date
 * @property decimal fee
 * @property decimal card_fee
 * @property decimal bonus
 * @property boolean sms
 */
class Setting extends Model
{

    public $table = 'settings';
    
    public $fillable = [
        'expiration_date',
        'fee',
        'card_fee',
        'bonus',
        'sms',
        'email_service',
        'package_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiration_date' => 'integer',
        'sms' => 'boolean',
        'email_service' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    // public function package(){
    //     return $this->hasOne('App\Models\Package','id','package_id');
    // }
}
