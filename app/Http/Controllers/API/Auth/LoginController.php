<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\UserRepository;
use App\Http\Requests\API\UserLoginAPIRequest;
use Lcobucci\JWT\Parser;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Branch;
use App\Models\Company;

class LoginController extends BaseApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        // $this->middleware('guest')->except('logout');
        $this->userRepo = $userRepo;

    }

    public function login(UserLoginAPIRequest $request)
    {
        
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'];

        try{
            $user = $this->userRepo->findUserIsExits($email);
            if (empty($user)) {

                return [
                    "success"=> false,
                    "message"=>'Email address not exist in system',

                ];
            }

            if (! $token = auth()->attempt($credentials)) {

                return [
                    "success"=> false,
                    "message"=> 'Password provider was incorrect'
                ];
            }

            $data = [
                'status' => $token,
                'user' => auth()->user(),
            ];

            $this->reNewToken();

            return [
                "success" => true,
                "data" => $data,
            ];

            //return view('welcome', ['token' => $data['user']['access_token'], 'currentUser' => $data['user']]);

        } catch (\Exception $e){

            return ('An unexpected error occurred. Please try again...');
            
        }

    }


    public function reNewToken()
    {
        $user = auth()->user();
        $user->access_token = $user->generateAccessToken();
        $user->save();
    }

    public function logout() 
    {
        auth()->logout();
        return redirect('landing-page');
    }

    public function loginSuperAdmin(UserLoginAPIRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'];

        try{
            $user = $this->userRepo->findUserIsExits($email);
            if (empty($user)) {

                return [
                    "success"=> false,
                    "message"=>'Email address not exist in system',

                ];
            }

            if (! $token = auth()->attempt($credentials)) {

                return [
                    "success"=> false,
                    "message"=> 'Password provider was incorrect'
                ];
            }
            $userInfo = $this->informationUser(auth()->user());

            if(!$this->userRepo->checkUserCommpanyExits(auth()->user())) {
                return [
                    "success"=> false,
                    "message"=> 'Current account is block'
                ];
            }

            $data = [
                'status' => $token,
                'user' => $userInfo,
            ];
            $this->reNewToken();

            return [
                "success" => true,
                "data" => $data,
            ];

        } catch (\Exception $e){

            // return ('An unexpected error occurred. Please try again...');
            return $e;
            
        }

    }

    public function logoutAuth(){
        auth()->logout();
        return [
                "success" => true
            ];
    }

    public function informationUser($user){

        if($user->role_id == '1') {
            $data = [
                'role_id'      => $user->role_id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'access_token' => $user->access_token,
                'email'        => $user->email,
                'id'           => $user->id
            ];
        }
        if($user->role_id == '2') {
            $company = Company::where('owner_id', $user->id)->first();
            $data = [
                'role_id'      => $user->role_id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'access_token' => $user->access_token,
                'email'        => $user->email,
                'id'           => $user->id,
                'company_id'   => $company->id,
                'company_name' => $company->name,
                'company_logo' => $company->logo
            ];
        }
        if($user->role_id == '3') {
            $branch = Branch::where('user_id', $user->id)->first();
            $company = Company::where('id', $branch->company_id)->first();
            $data = [
                'role_id'      => $user->role_id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'access_token' => $user->access_token,
                'email'        => $user->email,
                'id'           => $user->id,
                'branch_id'    => $branch->id,
                'branch_name'  => $branch->name,
                'company_id'   => $company->id,
                'company_name' => $company->name,
                'company_logo' => $company->logo
            ];
        }

        return $data;

    }

}
