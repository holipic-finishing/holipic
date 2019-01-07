<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreatePagesAPIRequest;
use App\Http\Requests\API\UpdatePagesAPIRequest;
use App\Models\CompanyAdmin\Pages;
use App\Repositories\CompanyAdminRepositories\PagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PagesController
 * @package App\Http\Controllers\API\CompanyAdmin
 */

class PagesAPIController extends AppBaseController
{
    /** @var  PagesRepository */
    private $pagesRepository;

    public function __construct(PagesRepository $pagesRepo)
    {
        $this->pagesRepository = $pagesRepo;
    }

    /**
     * Display a listing of the Pages.
     * GET|HEAD /pages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pagesRepository->pushCriteria(new RequestCriteria($request));
        $this->pagesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pages = $this->pagesRepository->all();

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * Store a newly created Pages in storage.
     * POST /pages
     *
     * @param CreatePagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePagesAPIRequest $request)
    {
        $input = $request->all();

        $pages = $this->pagesRepository->create($input);

        return $this->sendResponse($pages->toArray(), 'Pages saved successfully');
    }

    /**
     * Display the specified Pages.
     * GET|HEAD /pages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Pages $pages */
        $pages = $this->pagesRepository->findWithoutFail($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * Update the specified Pages in storage.
     * PUT/PATCH /pages/{id}
     *
     * @param  int $id
     * @param UpdatePagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pages $pages */
        $pages = $this->pagesRepository->findWithoutFail($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        $pages = $this->pagesRepository->update($input, $id);

        return $this->sendResponse($pages->toArray(), 'Pages updated successfully');
    }

    /**
     * Remove the specified Pages from storage.
     * DELETE /pages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Pages $pages */
        $pages = $this->pagesRepository->findWithoutFail($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        $pages->delete();

        return $this->sendResponse($id, 'Pages deleted successfully');
    }

    /*
    * Target : Show detail in Page by itemId and update data
    * POST /edit/page/{itemId}
    * 
    * @param int itemId, Request $request
    *
    * @return Response
    */
    public function editPage(Request $request, $itemId) {

        $input =  $request->all();

        if (!$input['value']) {
            return $this->sendError('This field could be not null');
        }

        $result = null;

        if ($input['field_name'] == 'page_title') {

            $page = $this->pagesRepository->find($itemId);

            if(empty($page)){
                return $this->sendError('Pages not found');
            }

            $result = $this->pagesRepository->find($itemId)->update([
                        'page_title' => $input['value']
                    ]);
        }

        if ($input['field_name'] == 'page_content') {

            $page = $this->pagesRepository->find($itemId);

            if(empty($page)){
                return $this->sendError('Pages not found');
            }

            $result = $this->pagesRepository->find($itemId)->update([
                        'page_content' => $input['value'],
                        'sort_content' => $input['sort_value']
                    ]);
        }

        if($result){

            return $this->sendResponse([], 'Pages updated successfully');
        }else{

            return $this->sendError('System Error Occurred');
        }
    }
}
