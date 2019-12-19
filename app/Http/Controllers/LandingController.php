<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Company;
use App\Models\Pages;
use Hash;
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

    public function direct()
    {
      return redirect('/lang/en');
    }

    public function viewLanding(Request $request)
    {
        $packages = $this->packageRepository->getPackage();
        $term = Pages::where('id', 2)->first();
        $refund = Pages::where('id', 3)->first();
        $policy = Pages::where('id', 1)->first();
        // App::setLocale($locale);
        \App::setLocale($request->language);
        $lang = $request->language;
        return view('sites.pages.landing-page', compact('packages', 'lang', 'term', 'refund', 'policy'));
    }

    public function register(Request $request)
    {
        $id = User::insertGetId([
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'package_id' => $request->package_id,
          'role_id' => 2,
          'show_password' => $request->password
        ]);

        Company::create([
          'name' => $request->company,
          'phone' => $request->phone,
          'owner_id' => $id,
          'currency_id' => $request->currency_id
        ]);

        return redirect('/login');
    }
}
