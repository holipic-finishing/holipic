<?php

namespace App\Repositories\CompanyAdminRepositories;

use App\Models\CompanyPackage;
use App\Models\Company;
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
        $company_id = Company::where('owner_id', '=', $input)->first()->id;

        return $this->model->where('company_id', '=', $company_id)->get();
    }

    public function addCompanyPackageItem($input)
    { 
        $company_id = Company::where('owner_id', '=', $input['user_id'])->first()->id; 

        $arrItem = array(
                    'package_name' => $input['package_name'],
                    'price' => $input['price'],
                    'offer' => $input['offer'],
                    'total_photo' => $input['total_photo'],
                    'album' => $input['album'],
                    'photo_on_disc' => $input['photo_on_disc'],
                    'poster' => $input['poster'],
                    'company_id' => $company_id,
                ); 

        return $this->model->create($arrItem);
    }
}
