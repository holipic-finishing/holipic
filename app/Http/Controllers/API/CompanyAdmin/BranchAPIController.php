<?php

namespace App\Http\Controllers\API\CompanyAdmin;

use App\Http\Requests\API\CreateBranchAPIRequest;
use App\Http\Requests\API\UpdateBranchAPIRequest;
use App\Models\Branch;
use App\Repositories\BranchRepository;
use App\Repositories\UserRepository;
use App\Repositories\ActivityLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\Company;

/**
 * Class BranchController
 * @package App\Http\Controllers\API
 */

class BranchAPIController extends AppBaseController
{
    /** @var  BranchRepository */
    private $branchRepository;
    private $userRepo;
    private $activityRepo;

    public function __construct(BranchRepository $branchRepo, UserRepository $userRepo, ActivityLogRepository $activityRepo)
    {
        $this->branchRepository = $branchRepo;
        $this->userRepo = $userRepo;
        $this->activityRepo = $activityRepo;
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

        $this->activityRepo->insertActivityLog($branch[1]['owner_id'], 'Add Branch '.$branch[0]['name']);

        return $this->sendResponse($branch, 'Add branches successfully');
    }
}
