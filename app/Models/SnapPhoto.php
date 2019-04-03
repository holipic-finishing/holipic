<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Snap_Photo
 * @package App\Models
 * @version March 21, 2019, 3:30 am UTC
 *
 * @property string branch_id
 * @property integer photographer_id
 * @property integer room_id
 */
class SnapPhoto extends Model
{
    use SoftDeletes;

    public $table = 'snap_photos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'branch_id',
        'photographer_id',
        'room_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'branch_id' => 'string',
        'photographer_id' => 'integer',
        'room_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'room_id' => 'exit'
    ];

    public function snapPhotoDetails()
    {
        return $this->hasMany('App\Models\SnapPhotoDetail', 'snap_photo_id', 'id');
    }

    
}
