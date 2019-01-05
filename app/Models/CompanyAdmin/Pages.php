<?php

namespace App\Models\CompanyAdmin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pages
 * @package App\Models
 * @version January 2, 2019, 7:42 am UTC
 *
 * @property string page_title
 * @property string page_content
 */
class Pages extends Model
{
    public $table = 'pages';
    
    public $fillable = [
        'page_title',
        'page_content',
        'sort_content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'page_title' => 'string',
        'page_content' => 'string',
        'sort_content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
