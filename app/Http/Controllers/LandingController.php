<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Repositories\PackageRepository;

class LandingController extends Controller
{

    /**
     * @var  PackageRepository
     */
    private $packageRepository;

    public function __construct(PackageRepository $packageRepo)
    {
        $this->packageRepository = $packageRepo;
    }

    public function viewLanding()
    {
        $packages = $this->packageRepository->getPackage();

        return view('sites.pages.landing-page', compact('packages'));
    }

    // public function landingLogin(UserLoginAPIRequest $request)
    // {

    //     $credentials = $request->only(['email', 'password']);
    //     $email = $credentials['email'];

    //     try {
    //         $user = $this->userRepo->findUserIsExits($email);
    //         if (empty($user)) {

    //             return [
    //                 "success" => false,
    //                 "email" => false,
    //                 "message" => 'Email address not exist in system',

    //             ];
    //         }

    //         if (!$token = auth()->attempt($credentials)) {

    //             return [
    //                 "success" => false,
    //                 "password" => false,
    //                 "message" => 'Password provider was incorrect'
    //             ];
    //         }

    //         $data = [
    //             'status' => $token,
    //             'user' => auth()->user(),
    //         ];

    //         $user = auth()->user();
    //         $user->access_token = $user->generateAccessToken();
    //         $user->save();

    //         return [
    //             "success" => true,
    //             "data" => $data,
    //         ];
    //     } catch (\Exception $e) {

    //         return ('An unexpected error occurred. Please try again...');
    //     }
    // }
}
