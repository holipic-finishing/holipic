<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Branch
 * @package App\Models
 * @version January 2, 2019, 4:19 am UTC
 *
 */
class Branch extends Model
{
    use SoftDeletes;

    use LogsActivity;

    protected static $logFillable = true;

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

    public function photographers()
    {
        return $this->hasMany('App\Models\Photographer', 'branch_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer', 'branch_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'branch_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function sellers()
    {
        return $this->hasMany('App\Models\Customer', 'branch_id', 'id');
    }

}
