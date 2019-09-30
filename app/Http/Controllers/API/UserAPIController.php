<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\CompanyAdminRepositories\NotificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use \Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Response;
use Spatie\Activitylog\Models\Activity;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $notificationRepository;

    public function __construct(UserRepository $userRepo, NotificationRepository $notificationRepo)
    {
        $this->userRepository = $userRepo;
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $this->userRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->userRepository->all();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $users = $this->userRepository->create($input);

        return $this->sendResponse($users->toArray(), 'User saved successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param  int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse($id, 'User deleted successfully');
    }

    public function changePassWord(Request $request) {
        try {

            $token = (new Parser())->parse((string) $request['access_token']);
            $email=  $token->getClaim('email');

            $user = User::where('email',$email)->first();

            if (!password_verify($request['oldPassword'], $user->password)) {
                return response()->json(['success' => false, 'message' => 'The password current incorrect']);
            }

            if(strcmp($request['oldPassword'], $request['newPassword']) == 0)
            {
                return response()->json([
                        'success' => false,
                        'message' => 'The new password cannot be the same as the old password'
                ]);
            }

            if(strcmp($request['newPassword'], $request['confirmPassword']) != 0 ) {
                return response()->json([
                        'success' => false,
                        'message' => 'The new password does not match'
                ]);
            }

            $this->notificationRepository->createNotifi($user->id, 'changePasswordSuccess','Change Password Success');

            if($user){
                $user = User::where('email',$email)->first()->update([
                                'password' => Hash::make($request['newPassword'])
                        ]);
            }

            // Save activity logs
            $log = Activity::all()->last();
            $log['user_id'] = User::where('email',$email)->first()->id;
            $log['description_log'] = 'Change Password';
            $log->save();

            event(new \App\Events\RedisEventActivityLog($log));

            return $this->sendResponse($user, 'Change password success');
        }

         catch (Exception $e) {
             return $e;
        }


    }


    public function getUserProfile($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    public function userProfile(Request $request)
    {
       try {
            $user = User::where('id',$request['id'])->first();

            $checkUsernameExits = User::where('username', $request['username'])->where('id', '!=', $request['id'])->first();
            $checkEmailExits = User::where('email', $request['email'])->where('id', '!=', $request['id'])->first();

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

            $this->notificationRepository->createNotifi($user->id, 'editProfileSuccess','Edit Profile Success');

            $user->update($request->all());

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
    /*
    *  Target : Function update Onesignalid in table users with where email
    */

    public function updateOnesignalUser(Request $request){

        $input  = $request->all();

        $findUser = User::where('email',$input['email'])->first();

        if($findUser->id_one_signal !== null && $findUser->id_one_signal !== ""){

            $arr_id_signal = explode(',',$findUser->id_one_signal);

            if(!in_array($input['id_one_signal'], $arr_id_signal)){
                $id_one_signal = $findUser->id_one_signal . ',' . $input['id_one_signal'];
            } else {
                $id_one_signal = $findUser->id_one_signal;
            }

        } else {
            $id_one_signal =  $input['id_one_signal'];
        }

        $user = User::where('email',$input['email'])->first()->update([

                        'id_one_signal' => $id_one_signal
                    ]);

        return $this->sendResponse($user, 'Updata success');

    }
}
