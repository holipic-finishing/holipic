<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePhotographerAPIRequest;
use App\Http\Requests\API\UpdatePhotographerAPIRequest;
use App\Models\Photographer;
use App\Repositories\PhotographerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PhotographerController
 * @package App\Http\Controllers\API
 */

class PhotographerAPIController extends AppBaseController
{
    /** @var  PhotographerRepository */
    private $photographerRepository;

    public function __construct(PhotographerRepository $photographerRepo)
    {
        $this->photographerRepository = $photographerRepo;
    }

    /**
     * Display a listing of the Photographer.
     * GET|HEAD /photographers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->photographerRepository->pushCriteria(new RequestCriteria($request));
        $this->photographerRepository->pushCriteria(new LimitOffsetCriteria($request));
        $photographers = $this->photographerRepository->all();

        return $this->sendResponse($photographers->toArray(), 'Photographers retrieved successfully');
    }

    /**
     * Store a newly created Photographer in storage.
     * POST /photographers
     *
     * @param CreatePhotographerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePhotographerAPIRequest $request)
    {
        $input = $request->all();

        $photographers = $this->photographerRepository->create($input);

        return $this->sendResponse($photographers->toArray(), 'Photographer saved successfully');
    }

    /**
     * Display the specified Photographer.
     * GET|HEAD /photographers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Photographer $photographer */
        $photographer = $this->photographerRepository->findWithoutFail($id);

        if (empty($photographer)) {
            return $this->sendError('Photographer not found');
        }

        return $this->sendResponse($photographer->toArray(), 'Photographer retrieved successfully');
    }

    /**
     * Update the specified Photographer in storage.
     * PUT/PATCH /photographers/{id}
     *
     * @param  int $id
     * @param UpdatePhotographerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhotographerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Photographer $photographer */
        $photographer = $this->photographerRepository->findWithoutFail($id);

        if (empty($photographer)) {
            return $this->sendError('Photographer not found');
        }

        $photographer = $this->photographerRepository->update($input, $id);

        return $this->sendResponse($photographer->toArray(), 'Photographer updated successfully');
    }

    /**
     * Remove the specified Photographer from storage.
     * DELETE /photographers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Photographer $photographer */
        $photographer = $this->photographerRepository->findWithoutFail($id);

        if (empty($photographer)) {
            return $this->sendError('Photographer not found');
        }

        $photographer->delete();

        return $this->sendResponse($id, 'Photographer deleted successfully');
    }

    public function getPhotographers()
    {
        $photographers = $this->photographerRepository->handleGetPhotographers();

        if(!$photographers) {
            return $this->sendError('Photographer not found');
        }

        return $this->sendResponse($photographers, 'Get Photographer successfully');
    }

    public function savePhotographer()
    {
        $photographer = $this->photographerRepository->handelSavePhotographer();

        if(!$photographer) {
            return $this->sendError('Error Add Photographer');
        }

        return $this->sendResponse($photographer, 'Add Photographer successfully');
    }

    public function updatePhotographer($id)
    {
        $photographer = $this->photographerRepository->findWithoutFail($id); 

        if (empty($photographer)) {
            return $this->sendError('Photographer not found');
        }

        $input = request('params');

        if(request('params.status')) 
        {
            $input = request('params.status') == 'Active' ? ['status' => true] : ['status' => false] ;
        }

        $photographer = $this->photographerRepository->update($input, $id);

        return $this->sendResponse($photographer, 'Update Photographer successfully');
    }

    /* Target : Show all name, id photographer by branch id 
    *  GET photographer/photographer-branch
    *
    *  @params : int branch_id
    *  @return : Response
    */

    public function getPhotographerByBranch(Request $request) {

        $input = $request->all();

        $branch_photographer = $this->photographerRepository->handelGetPhotographersByBranch($input['branchId']);

        if (empty($branch_photographer)) {
            return $this->sendError('Photographer not found');
        }

        return $this->sendResponse($branch_photographer, 'Photographer successfully');
    }
}
