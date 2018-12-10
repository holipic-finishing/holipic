<?php

namespace App\Repositories;

use App\Models\Package;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackageRepository
 * @package App\Repositories
 * @version December 7, 2018, 3:44 am UTC
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
