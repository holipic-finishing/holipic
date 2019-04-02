<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Email
 * @package App\Models
 * @version January 11, 2019, 3:39 am UTC
 *
 * @property string email_title
 * @property string email_content
 * @property string format_email_content
 */
class Email extends Model
{

    public $table = 'emails';
    
    public $fillable = [
        'email_title',
        'email_content',
        'format_email_content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_title' => 'string',
        'email_content' => 'string',
        'format_email_content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
