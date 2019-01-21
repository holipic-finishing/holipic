<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;
use Spatie\Activitylog\Models\Activity;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version December 7, 2018, 7:20 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */

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
