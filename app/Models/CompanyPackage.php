<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CompanyPackage
 * @package App\Models
 * @version January 2, 2019, 8:35 am UTC
 *
 * @property string name
 * @property string price
 * @property string offer
 * @property string detail
 */
class CompanyPackage extends Model
{
    use SoftDeletes;

    public $table = 'company_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'package_name',
        'price',
        'offer',
        'detail'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_name' => 'string',
        'price' => 'string',
        'offer' => 'string',
        'detail' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'package_name' => 'required',
        'price' => 'required',
        'offer' => 'required',
        'detail' => 'required'
    ];

    
}
