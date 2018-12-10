<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Package
 * @package App\Models
 * @version December 7, 2018, 3:44 am UTC
 *
 * @property string package_name
 * @property string short_description
 * @property string full_description
 * @property decimal fee
 * @property integer secure_storage
 * @property integer file_upload
 * @property integer minimum_user
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
        'fee',
        'secure_storage',
        'file_upload',
        'minimum_user',
        'max_user',
        'company_id'
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

     public function users(){
        return $this->hasMany('App\Models\User','package_id','id');
    }
}
