<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\API\UserSignupRequest;
use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;

class RegisterController extends BaseApiController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var  PackageRepository
     */
    private $userRepo;
    private $companyRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo, CompanyRepository $companyRepo)
    {
        $this->middleware('guest');
        $this->userRepo = $userRepo;
        $this->companyRepo = $companyRepo;
    }

    /**
   	    TODO:
   	    @param function to signup new account
   	    @param : company_name, first_name, last_name, email, password,	package_id, role_id
    **/
    public function register(UserSignupRequest $request)
    {
        $requestData = $request->all();
        $requestData['role_id'] = 2;
        $requestData['password'] = Hash::make($requestData['password']);

        $already_exist_user = $this->userRepo->findByField('email', $requestData['email'])->first();

        if ($already_exist_user != null) {

            return $this->responseError('This email already exists in the system');
        }

        try {
            $user = $this->userRepo->create($requestData);

            if($user) {
                $this->companyRepo->create([
                    'name' => $requestData['company_name'],
                    'owner_id' => $user->id
                ]);

                event(new Registered($user));

                return this->responseSuccess("A verification link has been sent to your email account. Please check your email to active your account");
            }

        } catch (\Exception $e) {
            return $this->responseError("System error: " . $e->getMessage())
        }
    }
}
