<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class File
 * @package App\Models
 * @version December 12, 2018, 4:03 am UTC
 *
 * @property string name
 * @property string storage_url
 * @property bigInteger file_size
 * @property string|\Carbon\Carbon uploaded_date
 * @property integer company_id
 * @property integer user_id
 * @property boolean status
 */
class File extends Model
{

    public $table = 'files';

    public $timestamps = false;

    public $fillable = [
        'name',
        'storage_url',
        'file_size',
        'uploaded_date',
        'company_id',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'storage_url' => 'string',
        'company_id' => 'integer',
        'user_id' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }


    
}
