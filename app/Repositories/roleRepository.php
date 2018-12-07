<?php

namespace App\Repositories;

use App\Models\role;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class roleRepository
 * @package App\Repositories
 * @version December 7, 2018, 3:31 am UTC
 *
 * @method role findWithoutFail($id, $columns = ['*'])
 * @method role find($id, $columns = ['*'])
 * @method role first($columns = ['*'])
*/
class roleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return role::class;
    }
}
