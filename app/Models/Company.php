<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * @package App\Models
 * @version December 10, 2018, 3:23 am UTC
 *
 * @property string name
 * @property string description
 * @property string address
 * @property integer user_id
 * @property string logo
 */
class Company extends Model
{

    public $table = 'companies';
    
    public $fillable = [
        'name',
        'description',
        'address',
        'ower_id',
        'logo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'address' => 'string',
        'ower_id' => 'integer',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
