<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Package
 * @package App\Models
 * @version December 7, 2018, 12:34 pm UTC
 *
 * @property string package_name
 * @property string short_description
 * @property string full_description
 * @property string secure_storage
 * @property string file_upload
 * @property string minimum_user
 * @property string max_user
 * @property integer company_id
 */
class Package extends Model
{

    public $table = 'packages';
    



    public $fillable = [
        'package_name',
        'short_description',
        'full_description',
        'secure_storage',
        'file_upload',
        'minimum_user',
        'max_user',
        'company_id',
        'fee'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_name' => 'string',
        'short_description' => 'string',
        'full_description' => 'string',
        'secure_storage' => 'string',
        'file_upload' => 'integer',
        'minimum_user' => 'integer',
        'max_user' => 'string',
        'company_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
