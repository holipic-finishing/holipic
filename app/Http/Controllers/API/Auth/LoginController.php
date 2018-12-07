<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\UserRepository;
use App\Http\Requests\API\UserLoginAPIRequest;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
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
        $input = $request->all();
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'];

        try{
            $user = $this->userRepo->findUserNotAdminFromEmail($email);
            if (empty($user)) {

                return [
                    "success"=> false,
                    "message"=>'Email does not exit',

                ];
            }

            if (! $token = auth()->attempt($credentials)) {

                return [
                    "success"=> false,
                    "message"=>' Password provider was incorrect'
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
}
