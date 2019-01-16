<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Branch
 * @package App\Models
 * @version January 2, 2019, 4:19 am UTC
 *
 */
class Branch extends Model
{
    use SoftDeletes;

    public $table = 'branches';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name', 'branch_password', 'branch_address', 'branch_phone_number', 'user_id', 'company_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function photgrapher()
    {
        return $this->hasOne('App\Models\Photographer', 'branch_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer', 'branch_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }


    
}