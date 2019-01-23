<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEwalletWithdrawAPIRequest;
use App\Http\Requests\API\UpdateEwalletWithdrawAPIRequest;
use App\Models\EwalletWithdraw;
use App\Repositories\EwalletWithdrawRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class EwalletWithdrawController
 * @package App\Http\Controllers\API
 */

class EwalletWithdrawAPIController extends AppBaseController
{
    /** @var  EwalletWithdrawRepository */
    private $ewalletWithdrawRepository;

    public function __construct(EwalletWithdrawRepository $ewalletWithdrawRepo)
    {
        $this->ewalletWithdrawRepository = $ewalletWithdrawRepo;
    }

    /**
     * Display a listing of the EwalletWithdraw.
     * GET|HEAD /ewalletWithdraws
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ewalletWithdrawRepository->pushCriteria(new RequestCriteria($request));
        $this->ewalletWithdrawRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ewalletWithdraws = $this->ewalletWithdrawRepository->all();

        return $this->sendResponse($ewalletWithdraws->toArray(), 'Ewallet Withdraws retrieved successfully');
    }

    /**
     * Store a newly created EwalletWithdraw in storage.
     * POST /ewalletWithdraws
     *
     * @param CreateEwalletWithdrawAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateEwalletWithdrawAPIRequest $request)
    {
        $input = $request->all();

        $data = [
            'amount'              => $input['item']['amount'] ,
            'bank_account_number' => $input['item']['account_number'],
            'bank_name'           => $input['item']['bank_name'],
            'account_holder_name' => $input['item']['account_holder_name'],
            'iban'                => $input['item']['iban'],
            'swift_code'          => $input['item']['swift'],
            'status'              => 'PENDING',
            'company_id'          => $input['company_id']
        ];

        $ewalletWithdraws = $this->ewalletWithdrawRepository->create($data);

        return $this->sendResponse($ewalletWithdraws->toArray(), 'Ewallet Withdraw saved successfully');
    }

    /**
     * Display the specified EwalletWithdraw.
     * GET|HEAD /ewalletWithdraws/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var EwalletWithdraw $ewalletWithdraw */
        $ewalletWithdraw = $this->ewalletWithdrawRepository->findWithoutFail($id);

        if (empty($ewalletWithdraw)) {
            return $this->sendError('Ewallet Withdraw not found');
        }

        return $this->sendResponse($ewalletWithdraw->toArray(), 'Ewallet Withdraw retrieved successfully');
    }

    /**
     * Update the specified EwalletWithdraw in storage.
     * PUT/PATCH /ewalletWithdraws/{id}
     *
     * @param  int $id
     * @param UpdateEwalletWithdrawAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEwalletWithdrawAPIRequest $request)
    {
        $input = $request->all();

        /** @var EwalletWithdraw $ewalletWithdraw */
        $ewalletWithdraw = $this->ewalletWithdrawRepository->findWithoutFail($id);

        if (empty($ewalletWithdraw)) {
            return $this->sendError('Ewallet Withdraw not found');
        }

        $ewalletWithdraw = $this->ewalletWithdrawRepository->update($input, $id);

        return $this->sendResponse($ewalletWithdraw->toArray(), 'EwalletWithdraw updated successfully');
    }

    /**
     * Remove the specified EwalletWithdraw from storage.
     * DELETE /ewalletWithdraws/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var EwalletWithdraw $ewalletWithdraw */
        $ewalletWithdraw = $this->ewalletWithdrawRepository->findWithoutFail($id);

        if (empty($ewalletWithdraw)) {
            return $this->sendError('Ewallet Withdraw not found');
        }

        $ewalletWithdraw->delete();

        return $this->sendResponse($id, 'Ewallet Withdraw deleted successfully');
    }
}
