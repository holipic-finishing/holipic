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
        'branch_name', 'company_id', 'username', 'password', 'user_id', 'branch_address', 'branch_phone_number'
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

    
}
