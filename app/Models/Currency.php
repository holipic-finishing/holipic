<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Currency
 * @package App\Models
 * @version December 10, 2018, 4:30 am UTC
 *
 * @property string name
 * @property string symbol
 * @property string country
 */
class Currency extends Model
{
    use SoftDeletes;

    public $table = 'currencies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'symbol',
        'country'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'symbol' => 'string',
        'country' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'symbol' => 'required',
        'country' => 'required'
    ];

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'currency_id', 'id');
    }

    
}
