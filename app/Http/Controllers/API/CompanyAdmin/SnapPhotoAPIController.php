<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Models\SnapPhoto;
use App\Repositories\SnapPhotoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class Snap_PhotoController
 * @package App\Http\Controllers\API
 */

class SnapPhotoAPIController extends AppBaseController
{
    /** @var  Snap_PhotoRepository */
    private $snapPhotoRepository;

    public function __construct(SnapPhotoRepository $snapPhotoRepo)
    {
        $this->snapPhotoRepository = $snapPhotoRepo;
    }

    /**
     * Display a listing of the Snap_Photo.
     * GET|HEAD /snapPhotos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->snapPhotoRepository->pushCriteria(new RequestCriteria($request));
        $this->snapPhotoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $snapPhotos = $this->snapPhotoRepository->all();

        return $this->sendResponse($snapPhotos->toArray(), 'Snap  Photos retrieved successfully');
    }

    /**
     * Store a newly created Snap_Photo in storage.
     * POST /snapPhotos
     *
     * @param CreateSnap_PhotoAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $snapPhotos = $this->snapPhotoRepository->create($input);

        return $this->sendResponse($snapPhotos->toArray(), 'Snap  Photo saved successfully');
    }

    /**
     * Display the specified Snap_Photo.
     * GET|HEAD /snapPhotos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Snap_Photo $snapPhoto */
        $snapPhoto = $this->snapPhotoRepository->findWithoutFail($id);

        if (empty($snapPhoto)) {
            return $this->sendError('Snap  Photo not found');
        }

        return $this->sendResponse($snapPhoto->toArray(), 'Snap  Photo retrieved successfully');
    }

    /**
     * Update the specified Snap_Photo in storage.
     * PUT/PATCH /snapPhotos/{id}
     *
     * @param  int $id
     * @param UpdateSnap_PhotoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Update $request)
    {
        $input = $request->all();

        /** @var Snap_Photo $snapPhoto */
        $snapPhoto = $this->snapPhotoRepository->findWithoutFail($id);

        if (empty($snapPhoto)) {
            return $this->sendError('Snap  Photo not found');
        }

        $snapPhoto = $this->snapPhotoRepository->update($input, $id);

        return $this->sendResponse($snapPhoto->toArray(), 'Snap_Photo updated successfully');
    }

    /**
     * Remove the specified Snap_Photo from storage.
     * DELETE /snapPhotos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Snap_Photo $snapPhoto */
        $snapPhoto = $this->snapPhotoRepository->findWithoutFail($id);

        if (empty($snapPhoto)) {
            return $this->sendError('Snap  Photo not found');
        }

        $snapPhoto->delete();

        return $this->sendResponse($id, 'Snap  Photo deleted successfully');
    }

    public function createSnapPhoto()
    {
        $snapPhoto = $this->snapPhotoRepository->handleCreateSnapPhoto();
        return $this->sendResponse($snapPhoto, 'Create snap photo for room successfully');
    }

    public function findRoomCheckDetailSnapPhoto()
    {
        $roomHavePhoto = $this->snapPhotoRepository->handleFindRoom();

        if(!$roomHavePhoto) {
            return $this->sendError('Can not find room');
        }

        return $this->sendResponse($roomHavePhoto, 'Login room success');
    }
}
