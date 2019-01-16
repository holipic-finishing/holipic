<?php

namespace App\Repositories\CompanyAdminRepositories;

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

    public function getCompanyPackages($input) 
    {
        return $this->model->where('company_id', '=', $input)->get();
    }

    public function addCompanyPackageItem($input)
    { 
        $arrItem = array(
                    'package_name' => $input['package_name'],
                    'price' => $input['price'],
                    'offer' => $input['offer'],
                    'total_photo' => $input['total_photo'],
                    'album' => $input['album'],
                    'photo_on_disc' => $input['photo_on_disc'],
                    'poster' => $input['poster'],
                    'company_id' => $input['company_id'],
                ); 

        return $this->model->create($arrItem);
    }
}