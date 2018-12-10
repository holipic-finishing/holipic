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
}
