<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTransactionExchangeAPIRequest;
use App\Http\Requests\API\UpdateTransactionExchangeAPIRequest;
use App\Models\TransactionExchange;
use App\Repositories\TransactionExchangeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TransactionExchangeController
 * @package App\Http\Controllers\API
 */

class TransactionExchangeAPIController extends AppBaseController
{
    /** @var  TransactionExchangeRepository */
    private $transactionExchangeRepository;

    public function __construct(TransactionExchangeRepository $transactionExchangeRepo)
    {
        $this->transactionExchangeRepository = $transactionExchangeRepo;
    }

    /**
     * Display a listing of the TransactionExchange.
     * GET|HEAD /transactionExchanges
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->transactionExchangeRepository->pushCriteria(new RequestCriteria($request));
        $this->transactionExchangeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $transactionExchanges = $this->transactionExchangeRepository->all();

        return $this->sendResponse($transactionExchanges->toArray(), 'Transaction Exchanges retrieved successfully');
    }

    /**
     * Store a newly created TransactionExchange in storage.
     * POST /transactionExchanges
     *
     * @param CreateTransactionExchangeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionExchangeAPIRequest $request)
    {
        $input = $request->all();

        $transactionExchanges = $this->transactionExchangeRepository->create($input);

        return $this->sendResponse($transactionExchanges->toArray(), 'Transaction Exchange saved successfully');
    }

    /**
     * Display the specified TransactionExchange.
     * GET|HEAD /transactionExchanges/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TransactionExchange $transactionExchange */
        $transactionExchange = $this->transactionExchangeRepository->findWithoutFail($id);

        if (empty($transactionExchange)) {
            return $this->sendError('Transaction Exchange not found');
        }

        return $this->sendResponse($transactionExchange->toArray(), 'Transaction Exchange retrieved successfully');
    }

    /**
     * Update the specified TransactionExchange in storage.
     * PUT/PATCH /transactionExchanges/{id}
     *
     * @param  int $id
     * @param UpdateTransactionExchangeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionExchangeAPIRequest $request)
    {
        $input = $request->all();

        /** @var TransactionExchange $transactionExchange */
        $transactionExchange = $this->transactionExchangeRepository->findWithoutFail($id);

        if (empty($transactionExchange)) {
            return $this->sendError('Transaction Exchange not found');
        }

        $transactionExchange = $this->transactionExchangeRepository->update($input, $id);

        return $this->sendResponse($transactionExchange->toArray(), 'TransactionExchange updated successfully');
    }

    /**
     * Remove the specified TransactionExchange from storage.
     * DELETE /transactionExchanges/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TransactionExchange $transactionExchange */
        $transactionExchange = $this->transactionExchangeRepository->findWithoutFail($id);

        if (empty($transactionExchange)) {
            return $this->sendError('Transaction Exchange not found');
        }

        $transactionExchange->delete();

        return $this->sendResponse($id, 'Transaction Exchange deleted successfully');
    }
}
