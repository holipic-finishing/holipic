<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\UserRepository;
use App\Http\Requests\API\UserLoginAPIRequest;
use Lcobucci\JWT\Parser;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Seller;
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

    public function logout()
    {
        auth()->logout();
        return redirect('landing-page');
    }

    public function signinUser(UserLoginAPIRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'];
        $dataInfoLogin = null;

        try {
            if (strpos($request['email'], '@') !== false) {
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
                    "success" => false,
                    "message" => 'Email or Username address not exist in system',

                ];
            }

            if (!$token = auth()->attempt($dataInfoLogin)) {
                return [
                    "success" => false,
                    "message" => 'Password provider was incorrect'
                ];
            }


            if (!$this->userRepo->checkUserCommpanyExits(auth()->user())) {
                return [
                    "success" => false,
                    "message" => 'Current account is block'
                ];
            }

            $authData = $this->makeResponseWithToken($token);

            $userInfo = $this->informationUser(auth()->user());

            $dataResponse = [
                'user'      => $userInfo,
                'authData'  => $authData
            ];

            return $this->responseSuccess('Login successfully!', $dataResponse);

        } catch (\Exception $e) {
            return $this->responseError('An unexpected error occurred.', $e);
        }
    }

    public function logoutAuth()
    {
        auth()->logout();
        return $this->responseSuccess('Logout successfully!');
    }

    public function informationUser($user)
    {
        if ($user->role_id == '1') {
            $data = [
                'id'           => $user->id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'role_id'      => $user->role_id,
                'username'     => $user->username,
                'email'        => $user->email,
            ];
        }
        if ($user->role_id == '2') {
            $company = Company::where('owner_id', $user->id)->first();
            $data = [
                'id'           => $user->id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'role_id'      => $user->role_id,
                'username'     => $user->username,
                'email'        => $user->email,
                'company_id'   => $company->id,
                'company_name' => $company->name,
                'company_logo' => $company->logo
            ];
        }
        if ($user->role_id == '3') {
            $branch = Branch::where('user_id', $user->id)->first();
            $company = Company::where('id', $branch->company_id)->first();
            $data = [
                'id'           => $user->id,
                'full_name'    => $user->first_name . ' ' .  $user->last_name,
                'role_id'      => $user->role_id,
                'username'     => $user->username,
                'email'        => $user->email,
                'company_id'   => $company->id,
                'company_name' => $company->name,
                'company_logo' => $company->logo,
                'branch_id'    => $branch->id,
                'branch_name'  => $branch->name,
            ];
        }
        if ($user->role_id == '4') {
            $data = [
                'id'           => $user->id,
                'full_name'    => $user->customer->name,
                'role_id'      => $user->role_id,
                'email'        => $user->email,
                'avatar'       => $user->customer->avatar,
                'room_id'      => $user->customer->room_id
            ];
        }
        if ($user->role_id == '5') {
            $seller = Seller::where('user_id', $user->id)->with('branch')->first();

            $data = [
                'role_id'      => $user->role_id,
                'email'        => $user->email,
                'branch_name'  => $seller->branch->name,
                'branch_id'  => $seller->branch->id,
            ];
        }

        return $data;
    }

    public function sendEmailResetPassword()
    {
        $user = $this->userRepo->findUserIsExits(request('email'));

        if ($user) {

            $token = $this->userRepo->handleCreateOrUpdatePasswordReset($user);

            Mail::to($user->email)->send(new \App\Mail\SendMailForgotPasswordCustomer($user, $token));

            return $this->responseSuccess('Send email success', null);
        }

        return $this->responseError('Email does not exist', null);
    }

    public function confirmForgotPassword()
    {
        if (!request('token')) {
            return redirect('customer/reset-password');
        }

        // $jwtPayload = $this->userRepo->handleTokenForgotPassword();
        $token = $this->userRepo->handleTokenForgotPassword();

        if (!empty($token)) {
            if ($token->life_time >  time()) {
                return redirect('customer/reset-password?token=' . request('token') . '&email=' . $token->email); //render component vue
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
        if (!request('token') || !request('email')) {
            return $this->responseError('Not find token or email', null);
        }

        $token = $this->userRepo->handleTokenForgotPassword();

        if (!empty($token)) {
            if ($token->life_time > time() && request('email') == $token->email) {

                $data = $this->userRepo->handleUpdatePassword();

                if ($data) {
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
