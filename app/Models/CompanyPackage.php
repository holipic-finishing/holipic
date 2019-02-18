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
        'total_photo',
        'album',
        'photo_on_disc',
        'poster',
        'company_id',
        'dollar',
        'euro',
        'indo',
        'turkey',
        'vn',
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
        'total_photo' => 'integer',
        'album' => 'string',
        'photo_on_disc' => 'integer',
        'poster' => 'integer',
        'company_id' => 'integer',
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
        'total_photo' => 'required',
        'album' => 'required',
        'photo_on_disc' => 'required',
        'poster' => 'required',
        'company_id' => 'required',
    ];

    
}
