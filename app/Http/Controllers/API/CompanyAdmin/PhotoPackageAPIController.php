<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreatePhotoPackageAPIRequest;
use App\Http\Requests\API\UpdatePhotoPackageAPIRequest;
use App\Models\PhotoPackage;
use App\Repositories\CompanyAdminRepositories\PhotoPackageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PhotoPackageController
 * @package App\Http\Controllers\API
 */

class PhotoPackageAPIController extends AppBaseController
{
    /** @var  PhotoPackageRepository */
    private $photoPackageRepository;

    public function __construct(PhotoPackageRepository $photoPackageRepo)
    {
        $this->photoPackageRepository = $photoPackageRepo;
    }

    /**
     * Display a listing of the PhotoPackage.
     * GET|HEAD /photoPackages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->photoPackageRepository->pushCriteria(new RequestCriteria($request));
        $this->photoPackageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $photoPackages = $this->photoPackageRepository->all();

        return $this->sendResponse($photoPackages->toArray(), 'Photo Packages retrieved successfully');
    }

    /**
     * Store a newly created PhotoPackage in storage.
     * POST /photoPackages
     *
     * @param CreatePhotoPackageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePhotoPackageAPIRequest $request)
    {
        $input = $request->all();

        $photoPackages = $this->photoPackageRepository->create($input);

        return $this->sendResponse($photoPackages->toArray(), 'Photo Package saved successfully');
    }

    /**
     * Display the specified PhotoPackage.
     * GET|HEAD /photoPackages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PhotoPackage $photoPackage */
        $photoPackage = $this->photoPackageRepository->findWithoutFail($id);

        if (empty($photoPackage)) {
            return $this->sendError('Photo Package not found');
        }

        return $this->sendResponse($photoPackage->toArray(), 'Photo Package retrieved successfully');
    }

    /**
     * Update the specified PhotoPackage in storage.
     * PUT/PATCH /photoPackages/{id}
     *
     * @param  int $id
     * @param UpdatePhotoPackageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhotoPackageAPIRequest $request)
    {
        $input = $request->all();

        /** @var PhotoPackage $photoPackage */
        $photoPackage = $this->photoPackageRepository->findWithoutFail($id);

        if (empty($photoPackage)) {
            return $this->sendError('Photo Package not found');
        }

        $photoPackage = $this->photoPackageRepository->update($input, $id);

        return $this->sendResponse($photoPackage->toArray(), 'PhotoPackage updated successfully');
    }

    /**
     * Remove the specified PhotoPackage from storage.
     * DELETE /photoPackages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PhotoPackage $photoPackage */
        $photoPackage = $this->photoPackageRepository->findWithoutFail($id);

        if (empty($photoPackage)) {
            return $this->sendError('Photo Package not found');
        }

        $photoPackage->delete();

        return $this->sendResponse($id, 'Photo Package deleted successfully');
    }

    public function getPhotoPackage(Request $request) 
    {
        $input = $request->company_id;

        $photoPackages = $this->photoPackageRepository->getPhotoPackage($input);

        return $this->sendResponse($photoPackages->toArray(), 'Photo Packages retrieved successfully');
    }

    public function editPackage(Request $request, $itemId){

        $input =  $request->all(); 

        if (!$input['value'] && $input['field_name'] != 0) {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        $result = $this->photoPackageRepository->update([
            $input['field_name'] => $input['value']
        ], $itemId);

        if($result){

            return $this->sendResponse([], 'Package updated successfully');
        }else{
            return $this->sendError('System Error Occurred');
        }

    }

}
