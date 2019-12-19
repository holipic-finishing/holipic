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

    public function addCoupon($input)
    {
      $create = $this->model->create([
        'name' => $input['name'],
        'code' => $input['code'],
        'discount_type' => $input['discount_type'],
        'discount' => $input['discount'],
        'active' => $input['active'],
        'from_date' => $input['from_date'],
        'to_date' => $input['to_date'],
      ]);
      return $create;
    }

    public function updateCoupon($input, $itemId)
    {
      $update = $this->model->where('id', $itemId)->update($input);
      return $update;
    }


}
