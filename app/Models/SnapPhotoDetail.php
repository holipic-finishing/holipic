<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SnapPhotoDetail
 * @package App\Models
 *
 * @property integer snap_photo_id
 * @property string image_resize
 * @property string image_final
 * @property string is_booking
 */
class SnapPhotoDetail extends Model
{
    use SoftDeletes;

    public $table = 'snap_photo_details';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'snap_photo_id',
        'image_resize',
        'image_final',
        'is_booking'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'snap_photo_id' => 'integer',
        'image_resize' => 'string',
        'image_final' => 'string',
        'is_booking' => 'boolean'
    ];


    /**
     * Validation get_required_files()
     *
     * @var array
     */
    public static $rules = [
        'is_booking' => 'exit'
    ];

    
}
