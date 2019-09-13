<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateCompanyPackageAPIRequest;
use App\Http\Requests\API\UpdateCompanyPackageAPIRequest;
use App\Models\CompanyPackage;
use App\Repositories\CompanyAdminRepositories\CompanyPackageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CompanyPackageController
 * @package App\Http\Controllers\API
 */

class CompanyPackageAPIController extends AppBaseController
{
    /** @var  CompanyPackageRepository */
    private $companyPackageRepository;

    public function __construct(CompanyPackageRepository $companyPackageRepo)
    {
        $this->companyPackageRepository = $companyPackageRepo;
    }

    /**
     * Display a listing of the CompanyPackage.
     * GET|HEAD /companyPackages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    { 
        $this->companyPackageRepository->pushCriteria(new RequestCriteria($request));
        $this->companyPackageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $companyPackages = $this->companyPackageRepository->all();

        return $this->sendResponse($companyPackages->toArray(), 'Company Packages retrieved successfully');
    }

    /**
     * Store a newly created CompanyPackage in storage.
     * POST /companyPackages
     *
     * @param CreateCompanyPackageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyPackageAPIRequest $request)
    {
        $input = $request->all(); 


        $companyPackages = $this->companyPackageRepository->create($input);

        return $this->sendResponse($companyPackages->toArray(), 'Company Package saved successfully');
    }

    /**
     * Display the specified CompanyPackage.
     * GET|HEAD /companyPackages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompanyPackage $companyPackage */
        $companyPackage = $this->companyPackageRepository->findWithoutFail($id);

        if (empty($companyPackage)) {
            return $this->sendError('Company Package not found');
        }

        return $this->sendResponse($companyPackage->toArray(), 'Company Package retrieved successfully');
    }

    /**
     * Update the specified CompanyPackage in storage.
     * PUT/PATCH /companyPackages/{id}
     *
     * @param  int $id
     * @param UpdateCompanyPackageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyPackageAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompanyPackage $companyPackage */
        $companyPackage = $this->companyPackageRepository->findWithoutFail($id);

        if (empty($companyPackage)) {
            return $this->sendError('Company Package not found');
        }

        $companyPackage = $this->companyPackageRepository->update($input, $id);

        return $this->sendResponse($companyPackage->toArray(), 'CompanyPackage updated successfully');
    }

    /**
     * Remove the specified CompanyPackage from storage.
     * DELETE /companyPackages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompanyPackage $companyPackage */
        $companyPackage = $this->companyPackageRepository->findWithoutFail($id);

        if (empty($companyPackage)) {
            return $this->sendError('Company Package not found');
        }

        $companyPackage->delete();

        return $this->sendResponse($id, 'Company Package deleted successfully');
    }

    public function getPackage(Request $request)
    {
        $input = $request->company_id;

        $result = $this->companyPackageRepository->getCompanyPackages($input);

        return $this->sendResponse($result, 'Company Packages retrieved successfully');
    }

    public function addPackage(Request $request) 
    {
        $input = $request->all(); 

        $result = $this->companyPackageRepository->addCompanyPackageItem($input);

        return $this->sendResponse($result->toArray(), 'Company Package saved successfully');
    }

    public function editPackage(Request $request, $itemId)
    {
        $input =  $request->all();

        if (!$input['value'] && $input['value'] != 0) {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        $result = $this->companyPackageRepository->update([
            $input['field_name'] => $input['value']
        ], $itemId);

        if($result){

            return $this->sendResponse([], 'Package updated successfully');
        }else{
            return $this->sendError('System Error Occurred');
        }

    }

    public function showAllPackage()
    {
        $packages = $this->companyPackageRepository->handleshowAllPackages();

        return $this->sendResponse($packages, 'Package successfully');
    }
}
