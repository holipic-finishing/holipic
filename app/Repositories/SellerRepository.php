<?php

namespace App\Repositories;

use App\Models\Seller;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SellerRepository
 * @package App\Repositories
 * @version September 27, 2019, 7:36 am UTC
 *
 * @method Seller findWithoutFail($id, $columns = ['*'])
 * @method Seller find($id, $columns = ['*'])
 * @method Seller first($columns = ['*'])
*/
class SellerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Seller::class;
    }
}
