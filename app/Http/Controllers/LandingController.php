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
}
