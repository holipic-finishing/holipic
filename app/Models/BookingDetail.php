<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BookingDetail
 * @package App\Models
 *
 * @property integer booking_id
 * @property integer snap_photo_detail_id
 * @property integer quantity
 * @property integer company_package_id
 * @property integer photo_package_id
 */
class BookingDetail extends Model
{
    use SoftDeletes;

    public $table = 'booking_details';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'booking_id',
        'snap_photo_detail_id',
        'quantity',
        'company_package_id',
        'photo_package_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'booking_id' => 'integer',
        'snap_photo_detail_id' => 'integer',
        'quantity' => 'integer',
        'company_package_id' => 'integer',
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
