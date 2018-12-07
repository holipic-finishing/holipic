<?php

namespace App\Repositories;

use App\Models\User;
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
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    // protected $fieldSearchable = [
    //     'user_id',
    //     'role_id'
    // ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function findUserIsAdminFromEmail($email)
    {
        $this->skipPresenter();
        return $this->scopeQuery(function($query) use ($email){
            return $query->where('email', $email)->where('role_id', 1);
        })->first();
    }

    public function findUserNotAdminFromEmail($email)
    {
        $this->skipPresenter();
        return $this->scopeQuery(function($query) use ($email){
            return $query->where('email', $email)->where('role_id', 1);
        })->first();
    }  
}
