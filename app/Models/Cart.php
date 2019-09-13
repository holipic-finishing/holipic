<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cart.
 *
 * @package namespace App\Models;
 */
class Cart extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image_id', 'quantity', 'company_package_id', 'photo_package_id', 'price'];

}
