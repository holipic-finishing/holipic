<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
<<<<<<< HEAD
 * Class UserRoleRepository
 * @package App\Repositories
 * @version December 7, 2018, 3:35 am UTC
 *
 * @method UserRole findWithoutFail($id, $columns = ['*'])
 * @method UserRole find($id, $columns = ['*'])
 * @method UserRole first($columns = ['*'])
=======
 * Class UserRepository
 * @package App\Repositories
 * @version December 7, 2018, 7:20 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
>>>>>>> 9823f81593ee09ebc45d2075a9a0b37b91013d30
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

    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'access_token',
        'active',
        'package_id'
    ];


    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function findUserIsExits($email)
    {
        $this->skipPresenter();
        return $this->scopeQuery(function($query) use ($email){
            return $query->where('email', $email);
        })->first();
    }

    public function findUserNotAdminFromEmail($email)
    {
        $this->skipPresenter();
        return $this->scopeQuery(function($query) use ($email){
            return $query->where('email', $email)->where('role_id', 2);
        })->first();

    } 

    public function findUserByUserName($userName)
    {
        $this->skipPresenter();
        return $this->scopeQuery(function($query) use ($userName){
            return $query->where('username', $userName);
        })->first();
    } 


    public function checkUserCommpanyExits($user)
    {
        $company = \App\Models\Company::onlyTrashed()->whereOwnerId($user->id)->first();

        if(!empty($company)) {
            return false;
        }

        return true;
    }

}
