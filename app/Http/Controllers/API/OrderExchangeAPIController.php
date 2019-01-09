<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOrderExchangeAPIRequest;
use App\Http\Requests\API\UpdateOrderExchangeAPIRequest;
use App\Models\OrderExchange;
use App\Repositories\OrderExchangeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class OrderExchangeController
 * @package App\Http\Controllers\API
 */

class OrderExchangeAPIController extends AppBaseController
{
    /** @var  OrderExchangeRepository */
    private $orderExchangeRepository;

    public function __construct(OrderExchangeRepository $orderExchangeRepo)
    {
        $this->orderExchangeRepository = $orderExchangeRepo;
    }

    /**
     * Display a listing of the OrderExchange.
     * GET|HEAD /orderExchanges
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->orderExchangeRepository->pushCriteria(new RequestCriteria($request));
        $this->orderExchangeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $orderExchanges = $this->orderExchangeRepository->all();

        return $this->sendResponse($orderExchanges->toArray(), 'Order Exchanges retrieved successfully');
    }

    /**
     * Store a newly created OrderExchange in storage.
     * POST /orderExchanges
     *
     * @param CreateOrderExchangeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderExchangeAPIRequest $request)
    {
        $input = $request->all();

        $orderExchanges = $this->orderExchangeRepository->create($input);

        return $this->sendResponse($orderExchanges->toArray(), 'Order Exchange saved successfully');
    }

    /**
     * Display the specified OrderExchange.
     * GET|HEAD /orderExchanges/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var OrderExchange $orderExchange */
        $orderExchange = $this->orderExchangeRepository->findWithoutFail($id);

        if (empty($orderExchange)) {
            return $this->sendError('Order Exchange not found');
        }

        return $this->sendResponse($orderExchange->toArray(), 'Order Exchange retrieved successfully');
    }

    /**
     * Update the specified OrderExchange in storage.
     * PUT/PATCH /orderExchanges/{id}
     *
     * @param  int $id
     * @param UpdateOrderExchangeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderExchangeAPIRequest $request)
    {
        $input = $request->all();

        /** @var OrderExchange $orderExchange */
        $orderExchange = $this->orderExchangeRepository->findWithoutFail($id);

        if (empty($orderExchange)) {
            return $this->sendError('Order Exchange not found');
        }

        $orderExchange = $this->orderExchangeRepository->update($input, $id);

        return $this->sendResponse($orderExchange->toArray(), 'OrderExchange updated successfully');
    }

    /**
     * Remove the specified OrderExchange from storage.
     * DELETE /orderExchanges/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var OrderExchange $orderExchange */
        $orderExchange = $this->orderExchangeRepository->findWithoutFail($id);

        if (empty($orderExchange)) {
            return $this->sendError('Order Exchange not found');
        }

        $orderExchange->delete();

        return $this->sendResponse($id, 'Order Exchange deleted successfully');
    }
}
