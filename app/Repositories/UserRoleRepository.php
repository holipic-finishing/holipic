<?php

namespace App\Repositories;

use App\Models\UserRole;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRoleRepository
 * @package App\Repositories
 * @version December 7, 2018, 3:35 am UTC
 *
 * @method UserRole findWithoutFail($id, $columns = ['*'])
 * @method UserRole find($id, $columns = ['*'])
 * @method UserRole first($columns = ['*'])
*/
class UserRoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'role_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserRole::class;
    }
}
