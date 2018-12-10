<?php

namespace App\Repositories;

use App\Models\Package;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackageRepository
 * @package App\Repositories
<<<<<<< HEAD
 * @version December 7, 2018, 12:34 pm UTC
=======
 * @version December 7, 2018, 3:44 am UTC
>>>>>>> 631723baa105c8a24d83155a812b37acfd07c6b3
 *
 * @method Package findWithoutFail($id, $columns = ['*'])
 * @method Package find($id, $columns = ['*'])
 * @method Package first($columns = ['*'])
*/
class PackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'package_name',
        'short_description',
        'full_description',
        'fee',
        'secure_storage',
        'file_upload',
        'minimum_user',
        'max_user',
        'company_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Package::class;
    }

    public function getPackage(){

        $data = $this->model->get();
        return $data;
     }


    public function countPackages(){

        $data = $this->model->withCount('users')->get()->toArray();

        $count_packages = 0;

        $array_data = [];

        foreach ($data as $key => $value) {

            if($value['package_name']=="Basic"){
                if($value['users_count'])
                {
                    $array_data['count_basic'] = $value['users_count'];
                }
            }

            if($value['package_name']=="Pro"){
                if($value['users_count'])
                {
                    $array_data['count_pro'] = $value['users_count'];
                }
            }

            $count_packages += $value['users_count'];

        }

        $array_data['total_count_company'] = $count_packages;

        return $array_data;

    }

}
