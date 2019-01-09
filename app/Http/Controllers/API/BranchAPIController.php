<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBranchAPIRequest;
use App\Http\Requests\API\UpdateBranchAPIRequest;
use App\Models\Branch;
use App\Repositories\BranchRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BranchController
 * @package App\Http\Controllers\API
 */

class BranchAPIController extends AppBaseController
{
    /** @var  BranchRepository */
    private $branchRepository;
    private $userRepo;

    public function __construct(BranchRepository $branchRepo, UserRepository $userRepo)
    {
        $this->branchRepository = $branchRepo;
        $this->userRepo = $userRepo;

    }

    /**
     * Display a listing of the Branch.
     * GET|HEAD /branches
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->branchRepository->pushCriteria(new RequestCriteria($request));
        $this->branchRepository->pushCriteria(new LimitOffsetCriteria($request));
        $branches = $this->branchRepository->all();

        return $this->sendResponse($branches->toArray(), 'Branches retrieved successfully');
    }

    /**
     * Store a newly created Branch in storage.
     * POST /branches
     *
     * @param CreateBranchAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBranchAPIRequest $request)
    {
        $input = $request->all();

        $branches = $this->branchRepository->create($input);

        return $this->sendResponse($branches->toArray(), 'Branch saved successfully');
    }

    /**
     * Display the specified Branch.
     * GET|HEAD /branches/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->findWithoutFail($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        return $this->sendResponse($branch->toArray(), 'Branch retrieved successfully');
    }

    /**
     * Update the specified Branch in storage.
     * PUT/PATCH /branches/{id}
     *
     * @param  int $id
     * @param UpdateBranchAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBranchAPIRequest $request)
    {
        $input = $request->all();

        /** @var Branch $branch */
        $branch = $this->branchRepository->findWithoutFail($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        $branch = $this->branchRepository->update($input['params'], $id);

        if(isset($input['params']['branch_password'])){
            $password = $input['params']['branch_password'];

            $user = $this->userRepo->findWithoutFail($branch['user_id']);

            if (empty($user)) {
                return $this->sendError('User not found');
            }

            $user = $user->update(['password' => $password]);
        }

        return $this->sendResponse($branch->toArray(), 'Branch updated successfully');
    }

    /**
     * Remove the specified Branch from storage.
     * DELETE /branches/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->findWithoutFail($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        $branch->delete();

        return $this->sendResponse($id, 'Branch deleted successfully');
    }

    public function getBranchesCompany()
    {
        $branch = $this->branchRepository->handleGetBranchesCompany();

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        return $this->sendResponse($branch, 'Branches retrieved successfully');
    }

    public function saveBranchCompany()
    {
        $branch = $this->branchRepository->handleSaveBranchCompany();

        if(!$branch) {
            return $this->sendError('Add branch error');

        }

        return $this->sendResponse($branch, 'Add branches successfully');
    }

    /*  Target : Function get all branch by company id
     *  GET company/branch-company
     *
     *  @params int company_id
     * 
     *  @return Response
    */

    public function getBranchByCompanyId(Request $request) {

       $input = $request->all();

       $branch_company = $this->branchRepository->handleGetBranchCompanyId($input['companyId']);

        if(!$branch_company) {
            return $this->sendError('Branch by company not found');
        }

        return $this->sendResponse($branch_company, 'Branch successfully');

    }
}
