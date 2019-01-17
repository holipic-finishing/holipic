<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;
use Spatie\Activitylog\Models\Activity;

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

    public function checkUserCommpanyExits($user)
    {
        $company = \App\Models\Company::onlyTrashed()->whereOwnerId($user->id)->first();

        if(!empty($company)) {
            return false;
        }

        return true;
    }

    public function editUserProfile($input)
    {
        try {
            $user = User::where('id',$input['id'])->first(); 

            $arrItems = $input; 

            $checkUsernameExits = User::where('username', $input['username'])->where('id', '!=', $input['id'])->first();
            $checkEmailExits = User::where('email', $input['email'])->where('id', '!=', $input['id'])->first();

            if ($checkUsernameExits != '') {
                return response()->json([
                        'success' => false, 
                        'message' => 'The username was exist!'
                ]);
            } 

            if ($checkEmailExits != '') {
                return response()->json([
                        'success' => false, 
                        'message' => 'The email was exist!'
                ]);
            } 

            $user->update($arrItems);
            
            NotificationRepository::createNotifi($user->id, 'editProfileSuccess','Edit Profile Success');
       
            // Save activity logs
            $log = Activity::all()->last();
            $log['user_id'] = $user->id;
            $log['description_log'] = 'Edit Profile';
            $log->save();

            event(new \App\Events\RedisEventActivityLog($log));

            return $this->sendResponse($user, 'Edit Profile success');
        }
        
         catch (Exception $e) {
             return $e;
        }
    }
}
