<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePackageAPIRequest;
use App\Http\Requests\API\UpdatePackageAPIRequest;
use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PackageController
 * @package App\Http\Controllers\API
 */

class PackageAPIController extends AppBaseController
{
    /** @var  PackageRepository */
    private $packageRepository;

    public function __construct(PackageRepository $packageRepo)
    {
        $this->packageRepository = $packageRepo;
    }

    /**
     * Display a listing of the Package.
     * GET|HEAD /packages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->packageRepository->pushCriteria(new RequestCriteria($request));
        $this->packageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $packages = $this->packageRepository->all();

        return $this->sendResponse($packages->toArray(), 'Packages retrieved successfully');
    }

    /**
     * Store a newly created Package in storage.
     * POST /packages
     *
     * @param CreatePackageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePackageAPIRequest $request)
    {
        $input = $request->all();

        $packages = $this->packageRepository->create($input);

        return $this->sendResponse($packages->toArray(), 'Package saved successfully');
    }

    /**
     * Display the specified Package.
     * GET|HEAD /packages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Package $package */
        $package = $this->packageRepository->findWithoutFail($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        return $this->sendResponse($package->toArray(), 'Package retrieved successfully');
    }

    /**
     * Update the specified Package in storage.
     * PUT/PATCH /packages/{id}
     *
     * @param  int $id
     * @param UpdatePackageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePackageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Package $package */
        $package = $this->packageRepository->findWithoutFail($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        $package = $this->packageRepository->update($input, $id);

        return $this->sendResponse($package->toArray(), 'Package updated successfully');
    }

    /**
     * Remove the specified Package from storage.
     * DELETE /packages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Package $package */
        $package = $this->packageRepository->findWithoutFail($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        $package->delete();

        return $this->sendResponse($id, 'Package deleted successfully');
    }

    public function listPackage(){
        
        $list = $this->packageRepository->getPackage();

        return view('sites.pages.landing-page',compact('list'));
    }

    public function CountPackages(){

        $count_packages = $this->packageRepository->countPackages();

        return $this->sendResponse($count_packages, 'Package counted successfully');

    }
}
