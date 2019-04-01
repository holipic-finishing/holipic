<?php

namespace App\Models\CompanyAdmin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notification
 * @package App\Models
 * @version December 25, 2018, 2:25 am UTC
 *
 * @property integer user_id
 * @property string message
 */
class Notification extends Model
{

    public $table = 'notifications';

    public $fillable = [
        'user_id',
        'message',
        'is_read',
        'push_notification'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'message' => 'string',
        'is_read' => 'boolean',
        'push_notification' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
