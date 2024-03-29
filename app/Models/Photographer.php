<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Photographer
 * @package App\Models
 * @version January 2, 2019, 10:14 am UTC
 *
 * @property integer company_id
 * @property integer branch_id
 * @property string name
 * @property string phone_number
 * @property string address
 * @property boolean status
 */
class Photographer extends Model
{
    use SoftDeletes;

    use LogsActivity;

    protected static $logFillable = true;

    public $table = 'photographers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'phone_number',
        'address',
        'status',
        'branch_id',
        'avatar',
        'email',
        'identification_card'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone_number' => 'string',
        'address' => 'string',
        'status' => 'boolean',
        'branch_id' => 'integer',
        'avatar' => 'string',
        'email' => 'string',
        'identification_card' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }


    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'photographer_id', 'id');
    }
    
}
