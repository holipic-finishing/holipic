<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Images.
 *
 * @package namespace App\Models;
 */
class Image extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename', 'img_type', 'is_booking', 'listing_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function listing()
    {
        return $this->belongsTo('App\Models\Listing', 'listing_id', 'id');
    }

    public function imageSelected()
    {
        return $this->hasOne('App\Models\Cart', 'image_id', 'id');
    }
}
