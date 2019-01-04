<?php

namespace App\Repositories\CompanyAdmin;

use App\Models\CompanyPackage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CompanyPackageRepository
 * @package App\Repositories
 * @version January 2, 2019, 8:35 am UTC
 *
 * @method CompanyPackage findWithoutFail($id, $columns = ['*'])
 * @method CompanyPackage find($id, $columns = ['*'])
 * @method CompanyPackage first($columns = ['*'])
*/
class CompanyPackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'offer',
        'detail'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyPackage::class;
    }
}
