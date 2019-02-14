<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PhotoPackage
 * @package App\Models
 * @version January 3, 2019, 7:19 am UTC
 *
 * @property string size
 * @property string price
 * @property string free_photo
 * @property integer currency_id
 */
class PhotoPackage extends Model
{
    use SoftDeletes;

    public $table = 'photo_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'size',
        'price',
        'free_photo',
        'currency_id',
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
        'size' => 'string',
        'price' => 'string',
        'free_photo' => 'string',
        'currency_id' => 'integer',
        'company_id' => 'integer',
        'dollar' => 'integer',
        'euro' => 'integer',
        'indo' => 'integer',
        'turkey' => 'integer',
        'vn' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'size' => 'required',
        'price' => 'required',
        'free_photo' => 'required',
        'currency_id' => 'required',
        'company_id' => 'required',
        'dollar' => 'required',
        'euro' => 'required',
        'indo' => 'required',
        'turkey' => 'required',
        'vn' => 'required',
    ];

    
}
