<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\UserRepository;
use App\Http\Requests\API\UserLoginAPIRequest;
use Lcobucci\JWT\Parser;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Branch;
use App\Models\Company;
use Mail;



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
                    "email" => false,
                    "message"=>'Email address not exist in system',

                ];
            }

            if (! $token = auth()->attempt($credentials)) {

                return [
                    "success"=> false,
                    "password" => false,
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
        $result = strpos($request['email'],'@');
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'];
        $dataInfoLogin = null;

        try{
            if(strpos($request['email'],'@') !== false) {
                $user = $this->userRepo->findUserIsExits($email);
                $dataInfoLogin = $credentials;

            } else {
                $user = $this->userRepo->findUserByUserName($email);
                $dataUser = [
                    'username' => $email,
                    'password' => $request['password']
                ];

                $dataInfoLogin = $dataUser;
            } 

            if (empty($user)) {

                return [
                    "success"=> false,
                    "message"=>'Email or Username address not exist in system',

                ];
            }
           
            if (! $token = auth()->attempt($dataInfoLogin)) {
                    return [
                        "success"=> false,
                        "message"=> 'Password provider was incorrect'
                    ];
                }

            
            if(!$this->userRepo->checkUserCommpanyExits(auth()->user())) {
                return [
                    "success"=> false,
                    "message"=> 'Current account is block'
                ];
            }
            
            $this->reNewToken();

            $userInfo = $this->informationUser(auth()->user());

            $data = [
                'status' => $token,
                'user' => $userInfo,
            ];

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
                'username'     => $user->username,
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
                'username'     => $user->username,
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
                'username'     => $user->username,
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
        if($user->role_id == '4') {
            $data = [
                'role_id'      => $user->role_id,
                'full_name'    => $user->customer->name,
                'avatar'       => $user->customer->avatar,
                'access_token' => $user->access_token,
                'email'        => $user->email,
                'id'           => $user->id,
                'room_id'      => $user->customer->room_id
            ];
        }
        if($user->role_id == '5') {
            $data = [
                'role_id'      => $user->role_id,
                'access_token' => $user->access_token,
                'email'        => $user->email,
                
            ];
        }
        return $data;
    }

    public function sendEmailResetPassword()
    {
        $user = $this->userRepo->findUserIsExits(request('email'));
        
        if($user) {

            $token = $this->userRepo->handleCreateOrUpdatePasswordReset($user);

            Mail::to($user->email)->send(new \App\Mail\SendMailForgotPasswordCustomer($user, $token));

            return $this->responseSuccess('Send email success', null);
        }

        return $this->responseError('Email does not exist', null);
    }

    public function confirmForgotPassword()
    {
        if(!request('token')) {
            return redirect('customer/reset-password');
        }

        // $jwtPayload = $this->userRepo->handleTokenForgotPassword();
        $token = $this->userRepo->handleTokenForgotPassword();

        if(!empty($token)) {
            if($token->life_time >  time()) {
                return redirect('customer/reset-password?token='.request('token').'&email='.$token->email); //render component vue
            } else {
                return redirect('customer/reset-password?exp=expired');
            }
        }

        return redirect('customer/reset-password');

        // if(!empty($jwtPayload) && $jwtPayload->exp) {
        //     if($jwtPayload->exp > time() + 60)
        //     {
        //         return redirect('customer/reset-password?token='.request('token').'&email='.$jwtPayload->email); //render component vue
        //         // dd($time,$jwtPayload->exp,'conhan');
        //     } else {
        //         // $time = time() + 60;
        //         // dd($time,$jwtPayload->exp,'hethan');
        //         return redirect('customer/reset-password?exp=expired');   
        //     }
        // } 
    }

    public function updatePassword()
    {
        if(!request('token') || !request('email')) {
           return $this->responseError('Not find token or email', null);
        }

        $token = $this->userRepo->handleTokenForgotPassword();

        if(!empty($token)) {
            if($token->life_time > time() && request('email') == $token->email) {

                $data = $this->userRepo->handleUpdatePassword();

                if($data) {
                    return $this->responseSuccess('Reset password successfully', null);
                }

                return $this->responseError('Email does not exist', null);
            }
        }

        return $this->responseError('The token is incorrect or expired', null);

        // $jwtPayload = $this->userRepo->handleTokenForgotPassword();

        // if(!empty($jwtPayload) && $jwtPayload->exp && $jwtPayload->exp > time() + 60) {

        //     if(request('email') == $jwtPayload->email) {

        //         $data = $this->userRepo->handleUpdatePassword();

        //         return $this->responseSuccess('Reset password successfully', null);
        //     }
        // }

        // return $this->responseError('The token is incorrect or expired', null);
    }
}
