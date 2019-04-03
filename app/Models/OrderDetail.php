<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderDetail
 * @package App\Models
 *
 * @property integer order_id
 * @property integer snap_photo_detail_id
 * @property integer quantity
 * @property integer photo_package_id
 */
class OrderDetail extends Model
{
    use SoftDeletes;

    public $table = 'order_details';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'order_id',
        'snap_photo_detail_id',
        'quantity',
        'photo_package_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'snap_photo_detail_id' => 'integer',
        'quantity' => 'integer',
        'photo_package_id' => 'integer'
    ];

    /**
     * Validation get_required_files()
     *
     * @var array
     */
    public static $rules = [
        'photo_package_id' => 'exit'
    ];

    
}
