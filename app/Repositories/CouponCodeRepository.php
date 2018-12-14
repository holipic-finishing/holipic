<?php

namespace App\Repositories;

use App\Models\CouponCode;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CouponCodeRepository
 * @package App\Repositories
 * @version December 14, 2018, 4:24 am UTC
 *
 * @method CouponCode findWithoutFail($id, $columns = ['*'])
 * @method CouponCode find($id, $columns = ['*'])
 * @method CouponCode first($columns = ['*'])
*/
class CouponCodeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code',
        'discount',
        'active',
        'from_date',
        'to_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CouponCode::class;
    }
}
